<?php 
defined('IN_ECJIA') or exit('No permission resources.');
/**
 *获取仓库信息 
 */
 function get_region_warehouse() {
	RC_Loader::load_theme('extras/b2b2c/model/goods/goods_region_warehouse_model.class.php');
    $db_region = new goods_region_warehouse_model();
	$warehouse = $db_region->field('region_id, region_name')->where(array('parent_id' => 0))->select();
	
	return $warehouse;
 }
 
/**
* 获得指定国家的所有省份
* @param type $type
* @param type $parent
* @return type
*/
function get_regions($type = 0, $parent = 0) {
	RC_Loader::load_theme('extras/b2b2c/model/goods/goods_region_model.class.php');
	$db_region = new goods_region_model();
	$condition['region_type'] = $type;
	$condition['parent_id'] = $parent;
	$rs = $db_region->field('region_id, region_name')->where($condition)->select();
	return $rs;
}

/**
 * 获得商品的详细信息
 *
 * @access public
 * @param integer $goods_id
 * @return void
 */
function get_goods_msg($goods_id) {
    RC_Loader::load_theme('extras/b2b2c/model/goods/b2b2c_goods_viewmodel.class.php');
    $db_goods_viewmodel = new b2b2c_goods_viewmodel();
    RC_Loader::load_theme('extras/b2b2c/model/goods/goods_warehouse_goods_model.class.php');
    RC_Loader::load_theme('extras/b2b2c/model/goods/goods_warehouse_area_goods_model.class.php');
    $db_ware_area_goods = new goods_warehouse_area_goods_model();
    $db_warehouse_goods_model = new goods_warehouse_goods_model();

    $field = "g.*, c.measure_unit, b.brand_id, b.brand_name | goods_brand, m.type_money | bonus_money,IFNULL(AVG(r.comment_rank), 0) | comment_rank,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') | rank_price, ms.shoprz_brandName, ms.shopNameSuffix";

    $row = $db_goods_viewmodel->join(array('category', 'brand', 'comment', 'bonus_type', 'member_price', 'merchants_shop_information'))->field($field)->where(array('g.goods_id' => $goods_id,'g.is_delete' => 0))->group('g.goods_id')->find();
    if ($row !== false) {
        /* 用户评论级别取整 */
        $row ['comment_rank'] = ceil ( $row ['comment_rank'] ) == 0 ? 5 : ceil ( $row ['comment_rank'] );
        /* 获得商品的销售价格 */
        $row ['market_price'] = price_format ($row ['market_price'],false);

        $row ['shop_price_formated'] = price_format ($row ['shop_price']);

        /* 修正促销价格 */
        if ($row ['promote_price'] > 0) {
            $promote_price = bargain_price ( $row ['promote_price'], $row ['promote_start_date'], $row ['promote_end_date'] );
        } else {
            $promote_price = 0;
        }
        /* 处理商品水印图片 */
        $watermark_img = '';
        if ($promote_price != 0) {
            $watermark_img = "watermark_promote";
        } elseif ($row ['is_new'] != 0) {
            $watermark_img = "watermark_new";
        } elseif ($row ['is_best'] != 0) {
            $watermark_img = "watermark_best";
        } elseif ($row ['is_hot'] != 0) {
            $watermark_img = 'watermark_hot';
        }
        if ($watermark_img != '') {
            $row ['watermark_img'] = $watermark_img;
        }
        $row ['promote_price_org'] = $promote_price;
        $row ['promote_price'] = price_format ($promote_price );
        /* 修正重量显示 */
        $row ['goods_weight'] = (intval ( $row ['goods_weight'] ) > 0) ? $row ['goods_weight'] . RC_Lang::lang ( 'kilogram' ) : ($row ['goods_weight'] * 1000) . RC_Lang::lang ( 'gram' );
        /* 修正上架时间显示 */
        $row ['add_time'] = RC_Time::local_date ( ecjia::config ( 'date_format' ), $row ['add_time'] );
        /* 促销时间倒计时 */
        $time = RC_Time::gmtime ();
        if ($time >= $row ['promote_start_date'] && $time <= $row ['promote_end_date']) {
            $row ['gmt_end_time'] = $row ['promote_end_date'];
        } else {
            $row ['gmt_end_time'] = 0;
        }
        /* 是否显示商品库存数量 */
        $row ['goods_number'] = intval((ecjia::config ( 'use_storage' ) == 1) ? $row ['goods_number'] : 0);
        /* 修正积分：转换为可使用多少积分（原来是可以使用多少钱的积分） */
        $row ['integral'] = ecjia::config ( 'integral_scale' ) ? round ( $row ['integral'] * 100 / ecjia::config ( 'integral_scale' ) ) : 0;
        /* 修正优惠券 */
        $row ['bonus_money'] = ($row ['bonus_money'] == 0) ? 0 : price_format ( $row ['bonus_money'], false );
        /* 修正商品图片 */
        $row ['goods_img'] = get_image_path($goods_id, $row ['goods_img']);
        $row ['goods_thumb'] = get_image_path($goods_id, $row ['goods_thumb'], true);
        $row ['sc'] = get_goods_collect($goods_id);
        $row['shop_name'] = !empty($row['user_id']) ? '进入'.$row['shoprz_brandName'].$row['shopNameSuffix'] : '进入';
        if($row['model_price'] == 1 || $row['model_price'] == 2) {
            if($row['model_price'] == 1){
                // 仓库模式商品价格
                $rs = $db_warehouse_goods_model->where(array('goods_id' => $goods_id, 'region_id' => 1))->get_field('warehouse_price');
                $row['shop_price_formated'] = price_format(intval($rs));
            }else if($row['model_price'] == 2){
                // 地区模式商品价格
                $rs = $db_ware_area_goods->where(array('goods_id' => $goods_id, 'region_id' =>RC_Cookie::get('province_id')))->get_field('region_price');
                $row['shop_price_formated'] = price_format(intval($rs));
            }
        }
        if($row['model_inventory'] == 1 || $row['model_inventory'] == 2) {
            if($row['model_inventory'] == 1){
                $rs = $db_warehouse_goods_model->where(array('goods_id' => $goods_id, 'region_id' => 1))->get_field('region_number');
                $row['goods_number'] = intval($rs);
            }elseif($row['model_inventory'] == 2){
                $rs = $db_ware_area_goods->where(array('goods_id' => $goods_id, 'region_id' => RC_Cookie::get('province_id')))->get_field('region_number');
                $row['goods_number'] = intval($rs);
            }
        }
        return $row;
    } else {
        return false;
    }
}
    /*
     * 获取商品的价格和库存
     */
    function get_goods($goods_id, $housename, $region_id){

        RC_Loader::load_theme('extras/model/goods/goods_model.class.php');
        RC_Loader::load_theme('extras/b2b2c/model/goods/goods_warehouse_goods_model.class.php');
        RC_Loader::load_theme('extras/b2b2c/model/goods/goods_warehouse_area_goods_model.class.php');

        $db_goods                   = new goods_model();
        $db_ware_area_goods         = new goods_warehouse_area_goods_model();
        $db_warehouse_goods_model   = new goods_warehouse_goods_model();

        if (empty($housename)) {
            $housename = $db_warehouse_goods_model->where(array('goods_id' => $goods_id))->get_field('region_id');
        }
        $row = $db_goods->where(array('goods_id' => $goods_id))->find();

        $model_price = $row['model_price'];
        $model_inventory = $row['model_inventory'];
        $number = $row['goods_number'];
        /* 取得商品价格 */
        $promote_price = bargain_price ( $row ['promote_price'], $row ['promote_start_date'], $row ['promote_end_date'] );
        $shop_price = !empty($promote_price) ? $promote_price : $row['shop_price'];

        if ($model_price != 1 && $model_price != 2) {
            $shop_price_formated = price_format($shop_price);
        }
        if ($model_price == 1) {
            // 仓库模式商品价格
            $rs = $db_warehouse_goods_model->where(array('goods_id' => $goods_id, 'region_id' => $housename))->get_field('warehouse_price');
            $shop_price_formated = price_format($rs);
        } else if ($model_price == 2) {
            // 地区模式商品价格
            $rs = $db_ware_area_goods->where(array('goods_id' => $goods_id, 'region_id' => $region_id))->get_field('region_price');
            $shop_price_formated = price_format($rs);
        }
        if ($model_inventory != 1 && $model_inventory != 2) {
            $goods_number = intval($number);
        }
        if ($model_inventory == 1) {
            $rs = $db_warehouse_goods_model->where(array('goods_id' => $goods_id, 'region_id' => $housename))->get_field('region_number');
            $goods_number = intval($rs);
        } elseif ($model_inventory == 2) {
            $rs = $db_ware_area_goods->where(array('goods_id' => $goods_id, 'region_id' => $region_id))->get_field('region_number');
            $goods_number = intval($rs);
        }
        $arr['goods_price']     = $shop_price_formated;
        $arr['goods_number']    = $goods_number;
        return $arr;
    }
     
    /**
     * 获得仓库
     */
    function get_warehouse($region = 0){
        RC_Loader::load_theme('extras/b2b2c/model/goods/goods_region_warehouse_model.class.php');
        $db_region = new goods_region_warehouse_model();
        $region_id = $db_region->where(array('region_id' => $region_id))->get_field('parent_id');
        return $region_id;
    }

//end