<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获得商品的详细信息
 */
function get_goods_info($goods_id) {
	// $db_goods_viewmodel = RC_Loader::load_app_model ( 'goods_viewmodel' );
	RC_Loader::load_theme('extras/model/goods/goods_viewmodel.class.php');
        $db_goods_viewmodel       = new goods_viewmodel();
	$field = "g.*, c.measure_unit, b.brand_id, b.brand_name | goods_brand, m.type_money | bonus_money,IFNULL(AVG(r.comment_rank), 0) | comment_rank,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') | rank_price";
	$row = $db_goods_viewmodel->join(array('category', 'brand', 'comment', 'bonus_type', 'member_price'))->field($field)->where(array('g.goods_id' => $goods_id,'g.is_delete' => 0))->group('g.goods_id')->find();
	if ($row !== false) {
		/* 用户评论级别取整 */
		$row ['comment_rank'] = ceil ( $row ['comment_rank'] ) == 0 ? 5 : ceil ( $row ['comment_rank'] );
		/* 获得商品的销售价格 */
		$row ['market_price'] = $row ['market_price'] > 0 ? price_format ($row ['market_price'],false) : 0;
		$row ['shop_price_formated'] = price_format ($row ['shop_price'] );

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
		$row ['promote_price'] = price_format ( $promote_price );
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
		$row ['goods_number'] = (ecjia::config ( 'use_storage' ) == 1) ? $row ['goods_number'] : '';
		/* 修正积分：转换为可使用多少积分（原来是可以使用多少钱的积分） */
		$row ['integral'] = ecjia::config ( 'integral_scale' ) ? round ( $row ['integral'] * 100 / ecjia::config ( 'integral_scale' ) ) : 0;
		/* 修正优惠券 */
		$row ['bonus_money'] = ($row ['bonus_money'] == 0) ? 0 : price_format ( $row ['bonus_money'], false );
		/* 修正商品图片 */
		$row ['goods_img'] = get_image_path($goods_id, $row ['goods_img']);
		$row ['goods_thumb'] = get_image_path($goods_id, $row ['goods_thumb'], true);
		$row ['sc'] = get_goods_collect($goods_id);
		return $row;
	} else {
		return false;
	}
}

/**
 * 获得指定商品的关联商品
 */
function get_related_goods($goods_id) {
	// $db_goods_viewmodel = RC_Loader::load_app_model ( 'goods_viewmodel' );
	 RC_Loader::load_theme('extras/model/goods/goods_viewmodel.class.php');
        $db_goods_viewmodel       = new goods_viewmodel();
	$field = "lg.goods_id,lg.link_goods_id,g.goods_name,g.goods_thumb,g.goods_img,g.market_price,g.promote_price,shop_price";
	$data = $db_goods_viewmodel->join(array('link_goods','member_price'))->field($field)->
	where(array('lg.goods_id' => $goods_id, 'g.is_on_sale' => 1, 'g.is_alone_sale' => 1,'g.is_delete' => 0))->limit(ecjia::config('related_goods_number'))->select();
	$arr = array();
	if(!empty($data)) {
		foreach ($data as $row) {
			$arr[$row['link_goods_id']]['goods_id']     = $row['link_goods_id'];
			$arr[$row['link_goods_id']]['goods_name']   = $row['goods_name'];
			$arr[$row['link_goods_id']]['short_name']   = ecjia::config('goods_name_length') > 0 ? RC_String::sub_str($row['goods_name'], ecjia::config('goods_name_length')) : $row['goods_name'];
			$arr[$row['link_goods_id']]['goods_thumb']  = get_image_path($row['goods_id'], $row['goods_img'], true);
			$arr[$row['link_goods_id']]['goods_img']    = get_image_path($row['goods_id'], $row['goods_img']);
			$arr[$row['link_goods_id']]['market_price'] = price_format($row['market_price']);
			$arr[$row['link_goods_id']]['shop_price']   = price_format($row['shop_price']);
			$arr[$row['link_goods_id']]['url']          = RC_Uri::url('goods/index/init', array('id'=>$row['link_goods_id']));
			if ($row['promote_price'] > 0) {
				$arr[$row['link_goods_id']]['promote_price'] 			= bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
				$arr[$row['link_goods_id']]['formated_promote_price'] 	= price_format($arr[$row['goods_id']]['promote_price']);
			} else {
				$arr[$row['link_goods_id']]['promote_price'] = 0;
			}
		}
	}
	return $arr;
}

/**
 * 获得商品的属性和规格
 */
function get_goods_properties($goods_id) {
	// $db_attribute_viewmodel = RC_Loader::load_app_model ( 'attribute_viewmodel' );
	 RC_Loader::load_theme('extras/model/goods/goods_attribute_viewmodel.class.php');
        $db_attribute_viewmodel       = new goods_attribute_viewmodel();
	/* 对属性进行重新排序和分组 */
	$field = "gt.attr_group,gt.*,count(a.cat_id)|attr_count";
	$grp = $db_attribute_viewmodel->join(array('goods_type', 'goods'))->where(array('g.goods_id' => $goods_id))->field($field)->find();
	$grp = $grp ['attr_group'];
	if (! empty ( $grp )) {
		$groups = explode ( "\n", strtr ( $grp, "\r", '' ) );
	}
	/* 获得商品的规格 */
	$res = $db_attribute_viewmodel->join('goods_attr')->field('a.attr_id, a.attr_name, a.attr_group, a.is_linked, a.attr_type, ga.goods_attr_id, ga.attr_value, ga.attr_price')->where(array('ga.goods_id' => $goods_id))->order(array('a.sort_order' => 'asc','ga.attr_price' => 'asc','ga.goods_attr_id' => 'asc'))->select();
	$arr ['pro'] = array (); // 属性
	$arr ['spe'] = array (); // 规格
	$arr ['lnk'] = array (); // 关联的属性
	if (! empty ( $res )) {
		foreach ( $res as $row ) {
			$row ['attr_value'] = str_replace ( "\n", '<br />', $row ['attr_value'] );
			if ($row ['attr_type'] == 0) {
				$group = (isset ( $groups [$row ['attr_group']] )) ? $groups [$row ['attr_group']] : RC_Lang::lang ( 'goods_attr' );
				$arr ['pro'] [$group] [$row ['attr_id']] ['name'] = $row ['attr_name'];
				$arr ['pro'] [$group] [$row ['attr_id']] ['value'] = $row ['attr_value'];
			} else {
				$arr ['spe'] [$row ['attr_id']] ['attr_type'] = $row ['attr_type'];
				$arr ['spe'] [$row ['attr_id']] ['name'] = $row ['attr_name'];
				$arr ['spe'] [$row ['attr_id']] ['values'] [] = array (
					'label' => $row ['attr_value'],
					'price' => $row ['attr_price'],
					'format_price' => price_format ( abs ( $row ['attr_price'] ), false ),
					'id' => $row ['goods_attr_id']
				);
			}
			if ($row ['is_linked'] == 1) {
				/* 如果该属性需要关联，先保存下来 */
				$arr ['lnk'] [$row ['attr_id']] ['name'] = $row ['attr_name'];
				$arr ['lnk'] [$row ['attr_id']] ['value'] = $row ['attr_value'];
			}
		}
	}
	return $arr;
}

/**
 * 取得礼包列表
 */
function get_package_goods_list($package_id) {
	// $db_goods_viewmodel = RC_Loader::load_app_model ( 'goods_viewmodel' );
	 RC_Loader::load_theme('extras/model/goods/goods_viewmodel.class.php');
        $db_goods_viewmodel       = new goods_viewmodel();
	// $db_attribute_viewmodel = RC_Loader::load_app_model ( 'attribute_viewmodel' );
        RC_Loader::load_theme('extras/model/goods/goods_attribute_viewmodel.class.php');
        $db_attribute_viewmodel       = new goods_attribute_viewmodel();
	$field = 'pg.goods_id, g.goods_name, (CASE WHEN pg.product_id > 0 THEN p.product_number ELSE g.goods_number END) | goods_number, p.goods_attr, p.product_id, pg.goods_number | order_goods_number, g.goods_sn, g.is_real, p.product_sn';
	$resource = $db_goods_viewmodel->join(array('package_goods','products'))->field($field)->
	where(array('pg.package_id' => $package_id))->select();
	if (empty($resource)) {
		return array();
	}
	$row = array();
	/* 生成结果数组 取存在货品的商品id 组合商品id与货品id */
	$good_product_arr = array();
	foreach ($resource as $key => $_row) {
		if ($_row['product_id'] > 0) {
			/* 取存商品id */
			$good_product_arr[] = $_row['goods_id'];
			/* 组合商品id与货品id */
			$_row['g_p'] = $_row['goods_id'] . '_' . $_row['product_id'];
		} else {
			/* 组合商品id与货品id */
			$_row['g_p'] = $_row['goods_id'];
		}
		/*生成结果数组*/
		$row[] = $_row;
	}
	/* 释放空间 */
	unset($resource, $_row, $sql);
	/* 取商品属性 */
	if (!empty($good_product_arr)) {
		$result_goods_attr = $db_attribute_viewmodel->join('goods_attr')->field('ga.goods_attr_id, ga.attr_value, ga.attr_price, a.attr_name')->
		where(array('a.attr_type' => 1))->in(array('goods_id' => $good_product_arr))->select();
		$_goods_attr = array();
		if(!empty($result_goods_attr)) {
			foreach ($result_goods_attr as $value) {
				$_goods_attr[$value['goods_attr_id']] = $value;
			}
		}
	}
	/* 过滤货品 */
	$format[0] = "%s:%s[%d] <br>";
	$format[1] = "%s--[%d]";
	foreach ($row as $key => $value) {
		if ($value['goods_attr'] != '') {
			$goods_attr_array = explode('|', $value['goods_attr']);

			$goods_attr = array();
			foreach ($goods_attr_array as $_attr) {
				$goods_attr[] = sprintf($format[0], $_goods_attr[$_attr]['attr_name'], $_goods_attr[$_attr]['attr_value'], $_goods_attr[$_attr]['attr_price']);
			}
			$row[$key]['goods_attr_str'] = implode('', $goods_attr);
		}
		$row[$key]['goods_name'] = sprintf($format[1], $value['goods_name'], $value['order_goods_number']);
	}
	return $row;
}

/**
 * 取得商品优惠价格列表
 */
function get_volume_price_list($goods_id, $price_type = '1') {
	// $db = RC_Loader::load_app_model ( 'volume_price_model' );
	 RC_Loader::load_theme('extras/model/goods/goods_volume_price_model.class.php');
        $db       = new goods_volume_price_model();
	$volume_price = array ();
	$res = $db->field ('`volume_number` , `volume_price`')->
	where(array('goods_id' => $goods_id, 'price_type' => $price_type))->order ('`volume_number` asc')->select();
	if (! empty ( $res )) {
		foreach ( $res as $k => $v ) {
			$volume_price [$k] = array ();
			$volume_price [$k] ['number'] = $v ['volume_number'];
			$volume_price [$k] ['price'] = $v ['volume_price'];
			$volume_price [$k] ['format_price'] = price_format ( $v ['volume_price'] );
		}
	}
	return $volume_price;
}

/**
 * 获得属性相同的商品
 */
function get_same_attribute_goods($attr) {
	// $db_goods_viewmodel = RC_Loader::load_app_model ( 'goods_viewmodel' );
	RC_Loader::load_theme('extras/model/goods/goods_viewmodel.class.php');
        $db_goods_viewmodel       = new goods_viewmodel();
	$lnk = array ();
	if (!empty($attr)) {
		foreach($attr['lnk'] as $key => $val) {
			$lnk[$key]['title'] = sprintf(RC_Lang::lang('same_attrbiute_goods'),$val['name'],$val['value']);
			/* 查找符合条件的商品 */
			$where = array(
				'attr_id'		=> $key,
				'is_on_sale'	=> 1,
				'attr_value'	=> $val['value'],
				'g.goods_id'	=> array('neq' => $_REQUEST['id'])
			);
			$field = "g.goods_id, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price | org_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') | shop_price,g.market_price, g.promote_price, g.promote_start_date, g.promote_end_date";
			$res = $db_goods_viewmodel->join(array('goods_attr', 'member_price'))->field($field)->
			where ($where)->limit (ecjia::config ( 'attr_related_number' ))->select ();
			if (! empty ( $res )) {
				foreach ( $res as $row ) {
					$lnk [$key] ['goods'] [$row ['goods_id']] ['goods_id'] = $row ['goods_id'];
					$lnk [$key] ['goods'] [$row ['goods_id']] ['goods_name'] = $row ['goods_name'];
					$lnk [$key] ['goods'] [$row ['goods_id']] ['short_name'] = ecjia::config ( 'goods_name_length' ) > 0 ? RC_String::sub_str ( $row ['goods_name'], ecjia::config ( 'goods_name_length' ) ) : $row ['goods_name'];
					$lnk [$key] ['goods'] [$row ['goods_id']] ['goods_thumb'] = (empty($row['goods_thumb'])) ? ecjia::config ('no_picture') : 'content/uploads/goods/' . substr ($row['goods_thumb'], stripos($row['goods_thumb'], '/' ));
					$lnk [$key] ['goods'] [$row ['goods_id']] ['market_price'] = price_format ( $row ['market_price'] );
					$lnk [$key] ['goods'] [$row ['goods_id']] ['shop_price'] = price_format ( $row ['shop_price'] );
					$lnk [$key] ['goods'] [$row ['goods_id']] ['promote_price'] = bargain_price ( $row ['promote_price'], $row ['promote_start_date'], $row ['promote_end_date'] );
					$lnk [$key] ['goods'] [$row ['goods_id']] ['url'] = RC_Uri::url('touch/goods', array ('gid' => $row ['goods_id']));
				}
			}
		}
	}
	return $lnk;
}

/**
 * 获得指定商品的关联文章
 */
function get_linked_articles($goods_id) {
	// $db_goods_article_viewmodel = RC_Loader::load_app_model ( 'new_goods_article_viewmodel' );
	 RC_Loader::load_theme('extras/model/goods/goods_new_goods_article_viewmodel.class.php');
        $db_goods_article_viewmodel       = new goods_new_goods_article_viewmodel();
	$data = $db_goods_article_viewmodel->join('article')->field('a.article_id, a.title, a.file_url, a.open_type, a.add_time')->
	where(array('ga.goods_id' => "$goods_id" ,'a.is_open' => '1'))->order(array('a.add_time' =>'DESC'))->select();
	$arr = array();
	foreach ($data as $row) {
		$row['url']         = $row['open_type'] != 1 ? RC_Uri::url('article', array('aid'=>$row['article_id'])) : trim($row['file_url']);
		$row['add_time']    = RC_Time::local_date(ecjia::config('date_format'), $row['add_time']);
		$row['short_title'] = ecjia::config('article_title_length') > 0 ?
		RC_String::sub_str($row['title'], ecjia::config('article_title_length')) : $row['title'];
		$arr[] = $row;
	}
	return $arr;
}

/**
 * 获得购物车中商品的配件
 */
function get_goods_fittings($goods_list = array()) {
	if (empty($goods_list)) return array();
	// $db_group_goods_viewmodel = RC_Loader::load_app_model ( 'group_goods_viewmodel' );
	 RC_Loader::load_theme('extras/model/goods/goods_group_goods_viewmodel.class.php');
        $db_group_goods_viewmodel       = new goods_group_goods_viewmodel();
	$temp_index = 0;
	$arr = array ();
	$db_group_goods_viewmodel->view = array (
			'goods ' => array (
				'type' => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'g',
				'field' => "gg.parent_id, ggg.goods_name AS parent_name, gg.goods_id, gg.goods_price, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price AS org_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price",
				'on' => 'g.goods_id = gg.goods_id'
			),
			'member_price' => array (
				'type' => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'mp',
				'on' => "mp.goods_id = gg.goods_id AND mp.user_rank = '$_SESSION[user_rank]'"
			),
			'goods' => array (
				'type' => Component_Model_View::TYPE_LEFT_JOIN,
				'alias' => 'ggg',
				'on' => 'ggg.goods_id = gg.parent_id'
			)
	);
	$res = $db_group_goods_viewmodel->where('g.is_delete = 0 AND g.is_on_sale = 1')->in(array('gg.parent_id' => $goods_list))->
	order(array('gg.parent_id' => 'asc', 'gg.goods_id' => 'asc'))->select();
	if (! empty ( $res )) {
		foreach ( $res as $row ) {
			$arr [$temp_index] ['parent_id'] = $row ['parent_id']; // 配件的基本件ID
			$arr [$temp_index] ['parent_name'] = $row ['parent_name']; // 配件的基本件的名称
			$arr [$temp_index] ['parent_short_name'] = ecjia::config ( 'goods_name_length' ) > 0 ? RC_String::sub_str ( $row ['parent_name'], ecjia::config ( 'goods_name_length' ) ) : $row ['parent_name']; // 配件的基本件显示的名称
			$arr [$temp_index] ['goods_id'] = $row ['goods_id']; // 配件的商品ID
			$arr [$temp_index] ['goods_name'] = $row ['goods_name']; // 配件的名称
			$arr [$temp_index] ['short_name'] = ecjia::config ( 'goods_name_length' ) > 0 ? RC_String::sub_str ( $row ['goods_name'], ecjia::config ( 'goods_name_length' ) ) : $row ['goods_name']; // 配件显示的名称
			$arr [$temp_index] ['fittings_price'] = price_format ( $row ['goods_price'] ); // 配件价格
			$arr [$temp_index] ['shop_price'] = price_format ( $row ['shop_price'] ); // 配件原价格
			$arr [$temp_index] ['goods_thumb'] = get_image_path ( $row ['goods_id'], $row ['goods_thumb'], true );
			$arr [$temp_index] ['goods_img'] = get_image_path ( $row ['goods_id'], $row ['goods_img'] );
			$arr [$temp_index] ['url'] = RC_Uri::url( 'goods', array ('gid' => $row ['goods_id']));
			$temp_index ++;
		}
	}
	return $arr;
}

/**
 * 获得指定商品的各会员等级对应的价格
 */
function get_user_rank_prices($goods_id, $shop_price=0) {
	// $db_user_rank_viewmodel = RC_Loader::load_app_model ( 'user_rank_viewmodel' );
	 RC_Loader::load_theme('extras/model/goods/goods_user_rank_viewmodel.class.php');
        $db_user_rank_viewmodel       = new goods_user_rank_viewmodel();
	if (empty($shop_price)) {
		$shop_price = 0;
	}
	$res = $db_user_rank_viewmodel->field('rank_id, IFNULL(mp.user_price, ur.discount * ' . $shop_price . ' / 100)|price, ur.rank_name, ur.discount')->
	where(array('mp.goods_id'=>$goods_id, 'show_price'=>1, 'rank_id'=>$_SESSION[user_rank]))->select();
	$arr = array();
	if (is_array($res) && !empty($res)) {
		foreach ($res as $row) {
			$arr [$row ['rank_id']] = array(
					'rank_name' => htmlspecialchars($row ['rank_name']),
					'price' => price_format($row ['price'])
			);
		}
	}
	return $arr;
}

/**
 * 获得指定商品的相册
 *
 * @access public
 * @param integer $goods_id
 * @return array
 */
function get_goods_gallery($goods_id) {
	// $db_goods_gallery = RC_Loader::load_app_model('goods_gallery_model');
	 RC_Loader::load_theme('extras/model/goods/goods_gallery_model.class.php');
        $db_goods_gallery       = new goods_gallery_model();
	$row = $db_goods_gallery->field('img_id, img_url, thumb_url, img_desc, img_original')->where(array('goods_id' => $goods_id))->limit(ecjia::config ('goods_gallery_number'))->select();
	/* 格式化相册图片路径 */
	$sort_index = array();
	$sort_id = array();
	if (empty($row)) {
		return array();
	} else {
		foreach ( $row as $key => $gallery_img ) {
			$sort = substr($gallery_img['img_original'], strrpos($gallery_img['img_original'], '?')+1);
			$row [$key] ['img_url'] = get_image_path ( $goods_id, $gallery_img ['img_url'], false, 'gallery' );
			$row [$key] ['thumb_url'] = get_image_path ( $goods_id, $gallery_img ['thumb_url'], true, 'gallery' );
			$row [$key] ['sort'] = $sort;
			$sort_index[$key] = $sort;
			$sort_id[$key] = $key;
		}
	}
	array_multisort($sort_index,SORT_NUMERIC,SORT_ASC,$sort_id,SORT_STRING,SORT_ASC,$row);
	return $row;
}

/**
 * 更新商品点击次数
 */
function update_goods_click($goods_id) {
	// $db_goods = RC_Loader::load_app_model('goods_model');
	 RC_Loader::load_theme('extras/model/goods/goods_model.class.php');
        $db_goods       = new goods_model();
	if (!empty($goods_id)) {
		$db_goods->inc('click_count', 'goods_id='.$goods_id , 1);
	}
}

/**
 * 获取商品销量总数
 */
function get_goods_count($goods_id){
	/*加载订单视图模型*/
	// $order_info_viewmodel = RC_Loader::load_app_model('goods_order_info_viewmodel');
	 RC_Loader::load_theme('extras/model/goods/goods_order_info_viewmodel.class.php');
        $order_info_viewmodel       = new goods_order_info_viewmodel();
	/* 统计时间段 */
	$period = RC_Time::local_strtotime('top10_time');
	$ext = '';
	if ($period == 1) {// 一年
		$ext = RC_Time::local_strtotime('-1 years');
	} elseif ($period == 2) {// 半年
		$ext = RC_Time::local_strtotime('-6 months');
	} elseif ($period == 3) {// 三个月
		$ext = RC_Time::local_strtotime('-3 months');
	} else {// 一个月
		$ext = RC_Time::local_strtotime('-1 months');
	}
	/* 查询该商品销量 */
	$where = array(
		'order_status'		=> OS_CONFIRMED,
		'shipping_status'	=> array(SS_SHIPPED, SS_RECEIVED),
		'pay_status'		=> array(PS_PAYED, PS_PAYING),
		'goods_id'			=> $goods_id,
		'add_time'			=> array('gt' => $ext)
	);
	$result = $order_info_viewmodel->join('order_goods')->field('IFNULL(SUM(og.goods_number), 0)|count')->
	where($where)->get_field();
	return $result;
}

/**
 * 取得商品最终使用价格
 */
function get_final_price($goods_id, $goods_num = '1', $is_spec_price = false, $spec = array()){
	// $db_goods_viewmodel = RC_Loader::load_app_model ( 'goods_viewmodel' );
	 RC_Loader::load_theme('extras/model/goods/goods_viewmodel.class.php');
        $db_goods_viewmodel       = new goods_viewmodel();
	$final_price = '0'; // 商品最终购买价格
	$volume_price = '0'; // 商品优惠价格
	$promote_price = '0'; // 商品促销价格
	$user_price = '0'; // 商品会员价格
	/*取得商品优惠价格列表*/
	$price_list = get_volume_price_list ( $goods_id, '1' );
	if (! empty ( $price_list )) {
		foreach ( $price_list as $value ) {
			if ($goods_num >= $value ['number']) {
				$volume_price = $value ['price'];
			}
		}
	}
	/*取得商品促销价格列表*/
	$field = "g.promote_price, g.promote_start_date, g.promote_end_date, IFNULL(mp.user_price, g.shop_price * '" . $_SESSION['discount'] . "') | shop_price";
	$goods = $db_goods_viewmodel->join ( 'member_price' )->field($field)->
	where(array('g.goods_id' => $goods_id, 'g.is_delete' => 0))->find();
	/* 计算商品的促销价格 */
	if ($goods ['promote_price'] > 0) {
		$promote_price = bargain_price ( $goods ['promote_price'], $goods ['promote_start_date'], $goods ['promote_end_date'] );
	} else {
		$promote_price = 0;
	}
	/*取得商品会员价格列表*/
	$user_price = $goods ['shop_price'];
	/*比较商品的促销价格，会员价格，优惠价格*/
	if (empty ( $volume_price ) && empty ( $promote_price )) {
		/*如果优惠价格，促销价格都为空则取会员价格*/
		$final_price = $user_price;
	} elseif (! empty ( $volume_price ) && empty ( $promote_price )) {
		/*如果优惠价格为空时不参加这个比较。*/
		$final_price = min ( $volume_price, $user_price );
	} elseif (empty ( $volume_price ) && ! empty ( $promote_price )) {
		/*如果促销价格为空时不参加这个比较。*/
		$final_price = min ( $promote_price, $user_price );
	} elseif (! empty ( $volume_price ) && ! empty ( $promote_price )) {
		/*取促销价格，会员价格，优惠价格最小值*/
		$final_price = min ( $volume_price, $promote_price, $user_price );
	} else {
		$final_price = $user_price;
	}
	/*如果需要加入规格价格*/
	if ($is_spec_price) {
		if (! empty ( $spec )) {
			$spec_price = spec_price ( $spec );
			$final_price += $spec_price;
		}
	}
	/*返回商品最终购买价格*/
	return $final_price;
}

/**
 * 获得指定的规格的价格
 */
function spec_price($spec) {
	// $db = RC_Loader::load_app_model ( 'goods_attr_model' );
	 RC_Loader::load_theme('extras/model/goods/goods_attr_model.class.php');
        $db       = new goods_attr_model();
	if (! empty ( $spec )) {
		if (is_array ( $spec )) {
			foreach ( $spec as $key => $val ) {
				$spec [$key] = addslashes ( $val );
			}
		} else {
			$spec = addslashes ( $spec );
		}
		$price = $db->in(array('goods_attr_id' => $spec))->sum('`attr_price`|attr_price');
	} else {
		$price = 0;
	}
	return $price;
}

/**
 * 获取商品的标签
 */
function get_goods_tags($goods_id){
    // $db_tag = RC_Loader::load_app_model('tag_model');
     RC_Loader::load_theme('extras/model/goods/goods_tag_model.class.php');
        $db_tag       = new goods_tag_model();
    $tags = $db_tag->field('tag_words, count(tag_words) as num')->where(array('goods_id' => $goods_id))->group('tag_words')->select();
    return $tags;
}

// ================================================== 商品列表 ==================================================
/**
 * 获取商品总的评价详情 by Leah
 */
function get_comment_info($id, $type) {
	// $db_comment = RC_Loader::load_app_model ( 'comment_model' );
	 RC_Loader::load_theme('extras/model/goods/goods_comment_model.class.php');
        $db_comment       = new goods_comment_model();
	$info['count'] = $db_comment->where(array('id_value'=>$id, 'comment_type'=>$type, 'status'=>1, 'parent_id'=>0))->order(array('comment_id'=>'DESC'))->count();
	$favorable = $db_comment->where("id_value = '$id' AND comment_type = '$type' AND (comment_rank= 5 OR comment_rank = 4) AND status = 1 AND parent_id = 0")->order(array('comment_id'=>'DESC'))->count();
	$medium = $db_comment->where("id_value = '$id' AND comment_type = '$type' AND status = 1 AND parent_id = 0 AND(comment_rank = 2 OR comment_rank = 3)")->order(array('comment_id'=>'DESC'))->count();
	$bad = $db_comment->where(array('id_value'=>$id, 'comment_type'=>$type, 'status'=>1, 'parent_id'=>0, 'comment_rank'=>1))->order(array('comment_id'=>'DESC'))->count();
	$info['favorable_count'] = $favorable; //好评数量
	$info['medium_count'] = $medium; //中评数量
	$info['bad_count'] = $bad; //差评数量
	if ($info['count'] > 0) {
		$info['favorable'] = 0;
		if ($favorable) {
			$info['favorable'] = round(($favorable / $info['count']) * 100);  //好评率
		}
		$info['medium'] = 0;
		if ($medium) {
			$info['medium'] = round(($medium / $info['count']) * 100); //中评
		}
		$info['bad'] = 0;
		if ($bad) {
			$info['bad'] = round(($bad / $info['count']) * 100); //差评
		}
	} else {
		$info['favorable'] = 100;
		$info['medium'] = 100;
		$info['bad'] = 100;
	}
	if(80 < $info['favorable'] && $info['favorable'] <= 100){
		$info['rank'] = 5;
	}elseif(60 < $info['favorable'] && $info['favorable'] <= 80){
		$info['rank'] = 4;
	}elseif(40 < $info['favorable'] && $info['favorable'] <= 60){
		$info['rank'] = 3;
	}elseif(20 < $info['favorable'] && $info['favorable'] <= 40){
		$info['rank'] = 2;
	}else{
		$info['rank'] = 1;
	}
	return $info;
}

/**
 * 查询评论内容
 */
function assign_comment($id, $type, $rank = 0, $page = 1) {
	// $db_comment = RC_Loader::load_app_model ( 'comment_model' );
	 RC_Loader::load_theme('extras/model/goods/goods_comment_model.class.php');
        $db_comment       = new goods_comment_model();
	$rank_in = array();
	if ($rank == '1') {
		$rank_in = array('comment_rank' => array(5,4));
	}
	if ($rank == '2') {
		$rank_in = array('comment_rank' => array(3,2));
	}
	if ($rank == '3') {
		$rank_in = array('comment_rank' => array(1));
	}
	$where = array(
		'id_value'		=> $id,
		'comment_type'	=> $type,
		'status'		=> 1,
		'parent_id'		=> 0
	);
	/* 取得评论列表 */
	$count = $db_comment->where($where)->in($rank_in)->count('*');
	$size = ecjia::config('comments_number') > 0 ? ecjia::config('comments_number') : 5;
	$pages = new ecjia_page($count, $size, 6, '', $page);
	$res = $db_comment->where($where)->in($rank_in)->limit($pages->limit())->select();
	$arr = array();
	$ids = '';
	foreach ($res as $key => $row) {
		$ids .= $ids ? ",$row[comment_id]" : $row['comment_id'];
		$arr[$row['comment_id']]['id'] = $row['comment_id'];
		$arr[$row['comment_id']]['email'] = $row['email'];
		$arr[$row['comment_id']]['username'] = $row['user_name'];
		$arr[$row['comment_id']]['content'] = str_replace('\r\n', '<br />', htmlspecialchars($row['content']));
		$arr[$row['comment_id']]['content'] = nl2br(str_replace('\n', '<br />', $arr[$row['comment_id']]['content']));
		$arr[$row['comment_id']]['rank'] = $row['comment_rank'];
		$arr[$row['comment_id']]['add_time'] = RC_Time::local_date(ecjia::config('time_format'), $row['add_time']);
		$arr[$row['comment_id']]['user_img'] =  get_user_img($row['user_id']);
	}
	/* 取得已有回复的评论 */
	if ($ids) {
		$res = $db_comment->in(array('parent_id'=>$ids))->select();
		foreach ($res as $row) {
			$arr[$row['parent_id']]['re_content'] = nl2br(str_replace('\n', '<br />', htmlspecialchars($row['content'])));
			$arr[$row['parent_id']]['re_add_time'] = RC_Time::local_date(ecjia::config('time_format'), $row['add_time']);
			$arr[$row['parent_id']]['re_email'] = $row['email'];
			$arr[$row['parent_id']]['re_username'] = $row['user_name'];
		}
	}
	$is_last = $page >= $pages->total_pages ? 1 : 0;
	$cmt = array('comments' => $arr, 'page'=>$pages->show(5), 'desc'=>$pages->page_desc(), 'is_last'=>$is_last);
	return $cmt;
}

//end
