<?php
defined('IN_ECJIA') or exit('No permission resources.');

	/**
	* 获取商户信息 
	*/
	function get_merchant($keywords, $size, $page, $type = 1){
		RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_shop_information_viewmodel.class.php');
		RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_collect_store_model.class.php');
 		$db_collect_store = new merchant_collect_store_model();
		$db_merchants_shop_information = new merchant_shop_information_viewmodel();
		RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_goods_model.class.php');
		$db_goods = new merchant_goods_model();
		RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_warehouse_goods_model.class.php');
		$db_warehouse_goods = new merchant_warehouse_goods_model();
		RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_warehouse_area_goods_model.class.php');
		$db_warehouse_areagoods = new merchant_warehouse_area_goods_model();
		
		if(!empty($keywords)){
			$where[] = "( shopNameSuffix LIKE '%$keywords%' OR shoprz_brandName LIKE '%$keywords%' OR shop_name LIKE '%$keywords%' )";
		}
		$where['ssi.status'] = 1;
		$where['msi.merchants_audit'] = 1;
        $count = $db_merchants_shop_information->join(array('seller_shopinfo', 'collect_store'))->where($where)->count();
		$pages = new touch_page($count, $size, 6, '', $page);
		$warehouser = $db_merchants_shop_information->join(array('seller_shopinfo', 'collect_store'))->field('ssi.id, ssi.ru_id, shop_name, msi.shoprz_brandName, msi.shopNameSuffix, shop_logo, cs.user_id')->where($where)->group('msi.shop_id')->limit($pages->limit())->select();

		foreach ($warehouser as $key => $val){
			$follower_count = $db_collect_store->where(array('ru_id' => $val['ru_id']))->count();
			$goods_count = $db_goods->where(array('user_id' => $val['ru_id'], 'is_on_sale' => 1, 'is_alone_sale' => 1, 'is_delete' => 0))->count();
            $is_attention = $db_collect_store->where(array('ru_id' => $val['ru_id'], 'user_id' => $_SESSION['user_id']))->count();
			$shop[$key]['ru_id'] = $val['ru_id'];
			$shop[$key]['is_attention'] = $is_attention;
			$shop[$key]['shop_name'] = $val['shoprz_brandName'].$val['shopNameSuffix'];
			$shop[$key]['shop_name'] = empty($shop[$key]['shop_name']) ? $val['rz_shopName'] : $shop[$key]['shop_name']; 
			if(!empty($val['shop_logo'])){
				$shop[$key]['shop_logo'] = get_image_path($val['id'],$val['shop_logo']);
			}else{
				$shop[$key]['shop_logo'] = '';
			}
			$shop[$key]['follower'] = $follower_count;
			$shop[$key]['goods_count'] = $goods_count;
		}
		if ( !empty ($shop)) {

			foreach ($shop as $key => $val) {
				$goods_result = $db_goods->where(array('user_id' => $val['ru_id'], 'is_on_sale' => 1, 'is_alone_sale' => 1, 'is_delete' => 0))->limit(3)->order(array('goods_id' => 'desc'))->select();
				
				if (!empty ($goods_result)) {
					foreach ($goods_result as $v) {
						//仓库价格
						if ($v['model_price'] == 1) {
							$price = $db_warehouse_goods->where(array('goods_id' => $v['goods_id']))->get_field('warehouse_price');
							$v['shop_price'] = empty($price) ? $v['shop_price'] : $price;
						}
						//区域价格
						if ($v['model_price'] == 2) {
							$price = $db_warehouse_areagoods->where(array('goods_id' => $v['goods_id']))->get_field('region_price');
							$v['shop_price'] = empty($price) ? $v['shop_price'] : $price;
						}
						$shop[$key]['goods_list'][]= array(
								'id'			=> $v['goods_id'],
								'name'			=> $v['goods_name'],
								'market_price'	=> price_format($v['market_price'], false),
								'shop_price'	=> price_format($v['shop_price'], false),
								'img' => array(
										'thumb'	=> get_image_path($v['goods_id'], $v['goods_img'], true),
										'url'	=> get_image_path($v['goods_id'], $v['original_img'], true),
										'small'	=> get_image_path($v['goods_id'], $v['goods_thumb'], true),
								),
						);
					}
				}

			}
		}
		if(empty($type)){
			foreach($shop as $key => $val){
				if($val['is_attention'] == 0){
					unset($shop[$key]);
				}
			}
		}
        $is_last = $page >= $pages->total_pages ? 1 : 0;
 		return array('list' => $shop, 'page'=>$pages->show(5), 'desc' => $pages->page_desc(), 'is_last' => $is_last);
	}

    /**
     * 获取商户信息
     */
	function get_shop_msg($id){
        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_seller_shopinfo_viewmodel.class.php');
        RC_Loader::load_theme("extras/b2b2c/model/merchant/merchant_shop_information_viewmodel.class.php");
        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_collect_store_model.class.php');
        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_comment_viewmodel.class.php');
        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_goods_model.class.php');
        $db_goods_view                          = new merchant_comment_viewmodel();
        $db_collect_store                       = new merchant_collect_store_model();
        $db_merchant_shop_information_viewmodel = new merchant_shop_information_viewmodel();
        $db_sell_shop_info                      = new merchant_seller_shopinfo_viewmodel();
        $db_goods_model                         = new merchant_goods_model();

        $seller_where = array();
        $seller_where['ssi.status'] = 1;
        $seller_where['msi.merchants_audit'] = 1;
        $seller_where['msi.user_id'] = $id;
        $commemt_field = 'count(*) as count, SUM(IF(comment_rank>3,1,0)) as comment_rank, SUM(IF(comment_server>3,1,0)) as comment_server, SUM(IF(comment_delivery>3,1,0)) as comment_delivery';
        $type_fld = 'count(*) as count, SUM(IF(is_new=1, 1, 0)) as new_goods, SUM(IF(is_best=1, 1, 0)) as best_goods, SUM(IF(is_hot=1, 1, 0)) as hot_goods';

        $goods_count = $db_goods_model->where(array('user_id' => $id, 'is_on_sale' => 1, 'is_alone_sale' => 1, 'is_delete' => 0))->count();
        $comment = $db_goods_view->join(array('goods'))->field($commemt_field)->where(array('g.user_id' => $id, 'parent_id' => 0, 'status' => 1))->find();
        $goods_type_count = $db_goods_model->field($type_fld)->where(array('user_id' => $id, 'is_on_sale' => 1, 'is_alone_sale' => 1, 'is_delete' => 0))->find();
        $follower_count = $db_collect_store->where(array('ru_id' => $id))->count();
        $attention = $db_merchant_shop_information_viewmodel->join('collect_store')->where(array('ru_id' => $id, 'cs.user_id' => $_SESSION['user_id']))->count();

        if($id> 0){
            $field ='msi.user_id,ssi.*, CONCAT(shoprz_brandName,shopNameSuffix) as seller_name, c.cat_name, ssi.shop_logo, count(cs.ru_id) as follower';
            $info = $db_merchant_shop_information_viewmodel->join(array('category', 'seller_shopinfo', 'collect_store'))->field($field)->where($seller_where)->find();
            if(substr($info['shop_logo'], 0, 1) == '.') {
                $info['shop_logo'] = str_replace('../', '/', $info['shop_logo']);
            }
            $data['merchant_info'] = array(
                'id'				=> $info['user_id'],
                'seller_name'		=> $info['seller_name'],
                'seller_logo'		=> !empty($info['shop_logo']) ? RC_Upload::upload_url().'/'.$info['shop_logo'] : '',
                'goods_count'		=> $goods_count,
                'attention'         => $attention,
                'follower'			=> $follower_count,
                'goods_type_count'  => $goods_type_count,
                'comment' 			=> array(
                    'comment_goods'		=> $comment['count']>0 ? round($comment['comment_rank']/$comment['count']*100).'%' : '100%',
                    'comment_server'	=> $comment['count']>0 ? round($comment['comment_server']/$comment['count']*100).'%' : '100%',
                    'comment_delivery'	=> $comment['count']>0 ? round($comment['comment_delivery']/$comment['count']*100).'%' : '100%',
                )
            );
        }else{

            $info = $db_sell_shop_info->join('collect_store')->field('shop_name, shop_logo')->where(array('ru_id' => 0))->select();
            $attention = $db_collect_store->where(array('ru_id' => $id, 'user_id' => $_SESSION['user_id']))->count();
            foreach ($info as $val){
                $info['attention'] = $attention;
                $info['seller_name'] = $val['shop_name'];
                $info['seller_logo'] = !empty($val['shop_logo']) ? RC_Upload::upload_url().'/'.$val['shop_logo'] : '';
                $info['goods_count'] = $goods_count;
                $info['follower'] = $follower_count;
                $info['goods_type_count'] = $goods_type_count;
                $info['comment'] = array(
                    'comment_goods'		=> $comment['count']>0 ? round($comment['comment_rank']/$comment['count']*100).'%' : '100%',
                    'comment_server'	=> $comment['count']>0 ? round($comment['comment_server']/$comment['count']*100).'%' : '100%',
                    'comment_delivery'	=> $comment['count']>0 ? round($comment['comment_delivery']/$comment['count']*100).'%' : '100%',
                );
            }
            $data['merchant_info'] = $info;
        }
        return $data['merchant_info'];
    }

    /*
     *  获取店铺基本信息
     */
    function get_shop_info($id){
        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_seller_shopinfo_viewmodel.class.php');
        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_region_model.class.php');
        $db_seller_shopinfo = new merchant_seller_shopinfo_viewmodel();
        $db_region = new merchant_region_model();

        $shop = $db_seller_shopinfo->join(null)->where(array('ru_id' => $id))->field('shop_name, country, province, city, shop_address, kf_tel, notice')->find();
        $shop['country'] = $db_region->where(array('region_id' => $shop['country'], 'region_type' => 0))->get_field('region_name');

        $shop['province'] = $db_region->where(array('region_id' => $shop['province'], 'region_type' => 1))->get_field('region_name');
        $shop['city'] = $db_region->where(array('region_id' => $shop['city'], 'region_type' => 2))->get_field('region_name');

        return $shop;
    }
	/**
	* 获取商户的商品列表
	*/
	function get_user_goods($ru_id, $size, $page, $sort, $order){
		RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_goods_model.class.php');
        $db_goods = new merchant_goods_model();
		$where = array(
			'user_id' => $ru_id,
			'is_on_sale'		=> 1,
            'is_alone_sale'	=> 1,
            'is_delete'		=> 0
		);
		$count = $db_goods->where($where)->count();
		$pages = new touch_page($count, $size, 6, '', $page);
        $sort = empty($sort)? 'last_update' : $sort;
        $order = empty($order) ? 'DESC' : $order;
		$goods = $db_goods->field('goods_id, shop_price, goods_thumb, promote_start_date, promote_end_date, goods_img, promote_price, goods_brief, goods_name, market_price')->where($where)->limit($pages->limit())->order(array($sort => $order))->select();
		foreach ($goods as $key => $value) {
			$goods[$key]['shop_price'] = price_format ($value['shop_price']);
			if($value['promote_price']> 0){
				$bargain_price = bargain_price ($value['promote_price'],$value['promote_start_date'],$value['promote_end_date']);
				$goods[$key]['price_promote'] =price_format($bargain_price);
			}
			$goods[$key]['img'] = get_image_path($value['goods_id'], $value['goods_img']);
			$goods[$key]['thumb'] = get_image_path($value['goods_id'], $value['goods_thumb']);
			$goods[$key]['url'] = RC_Uri::url('goods/index/init', array('id' => $value['goods_id']));
		}

		$is_last = $page >= $pages->total_pages ? 1 : 0;
		return array('list'=>$goods, 'page'=>$pages->show(5), 'desc' => $pages->page_desc(), 'is_last' => $is_last);
	}

	/**
	* 获取商户自定义导航
	*/
	function get_custom_nav ($id) {
		RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_seller_shopwindow_model.class.php');
		$db_seller_win = new merchant_seller_shopwindow_model();
		$where['id'] = $id;
		$where['type'] = 0;
		$shop_nav = $db_seller_win->where($where)->select();
		return $shop_nav;
	}
	