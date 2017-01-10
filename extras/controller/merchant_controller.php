<?php
/**
 * 店铺模块控制器代码
 */
class merchant_controller {
   
	/**
	 * 店铺首页
	 */
	public static function init() {
		$store_id 		= intval($_GET['store_id']);
		$category_id 	= intval($_GET['category_id']);
		 
		$limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
		$page = intval($_GET['page']) ? intval($_GET['page']) : 1;
		 
		//店铺信息
		$store_info = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_HOME_DATA)->data(array('seller_id' => $store_id, 'location' => array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude'])))->run();
		ecjia_front::$controller->assign('store_info', $store_info);
		ecjia_front::$controller->assign_title($store_info['seller_name']);
	
		$type_name = '';
		$action_type = !empty($_GET['type']) ? trim($_GET['type']) : '';
		 
		if (empty($action_type) && empty($category_id)) {
			$goods_count = $store_info['goods_count'];
			if ($goods_count['best_goods'] > 0) {
				$action_type = 'best';
				$goods_num = $goods_count['best_goods'];
				$type_name = '精选';
			} elseif ($goods_count['hot_goods'] > 0) {
				$action_type = 'hot';
				$goods_num = $goods_count['hot_goods'];
				$type_name = '热销';
			} elseif ($goods_count['new_goods'] > 0) {
				$action_type = 'new';
				$goods_num = $goods_count['new_goods'];
				$type_name = '新品';
			}
		}
		ecjia_front::$controller->assign('action_type', $action_type);
		 
		//店铺分类
		$store_category = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_CATEGORY)->data(array('seller_id' => $store_id))->run();
		ecjia_front::$controller->assign('store_category', $store_category);
		 
		if (!empty($action_type) && $action_type != 'all') {
			$parameter = array(
				'action_type' 	=> $action_type,
				'pagination' 	=> array('count' => $limit, 'page' => $page),
				'seller_id'		=> $store_id
			);
			$data = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_SUGGESTLIST)->data($parameter)->send()->getBody();
			$data = json_decode($data, true);
			$goods_num = $data['paginated']['count'];
			$goods_list = $data['data'];
		} else {
			//店铺分类商品
			$arr = array(
				'filter' 		=> array('category_id' => $category_id),
				'pagination' 	=> array('count' => $limit, 'page' => $page),
				'seller_id'		=> $store_id
			);
			 
			$data = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_LIST)->data($arr)->send()->getBody();
			$data = json_decode($data, true);
			$goods_num = $data['paginated']['count'];
			$goods_list = $data['data'];
	
			if (empty($category_id)) {
				$type_name = '全部';
			}
		}
		 
		$token = ecjia_touch_user::singleton()->getToken();
		$arr = array(
			'token' 	=> $token,
			'seller_id' => $store_id,
			'location' 	=> array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude'])
		);
		 
		//店铺购物车商品
		$cart_list = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($arr)->run();
	
		$goods_cart_list = array();
		$rec_id = '';
		if (!empty($cart_list['cart_list'][0]['goods_list'])) {
			$cart_list['cart_list'][0]['total']['check_all'] = true;
			$cart_list['cart_list'][0]['total']['check_one'] = false;
			foreach ($cart_list['cart_list'][0]['goods_list'] as $k => $v) {
				if (!empty($v['goods_number'])) {
					$goods_cart_list[$v['goods_id']] = array('num' => $v['goods_number'], 'rec_id' => $v['rec_id']);
				}
				if ($v['is_checked'] == 1 && $v['is_disabled'] == 0) {
					$cart_list['cart_list'][0]['total']['check_one'] = true;	//至少选择了一个
					if ($k == 0) {
						$rec_id = $v['rec_id'];
					} else {
						$rec_id .= ','.$v['rec_id'];
					}
				} elseif ($v['is_checked'] == 0) {
					$cart_list['cart_list'][0]['total']['check_all'] = false;	//全部选择
					$cart_list['cart_list'][0]['total']['goods_number'] -= $v['goods_number'];
				}
				$rec_id = trim($rec_id, ',');
			}
		} else {
			$cart_list['cart_list'][0]['total']['check_all'] = false;
			$cart_list['cart_list'][0]['total']['check_one'] = false;
		}
		 
		if (!empty($goods_list)) {
			foreach ($goods_list as $k => $v) {
				if (array_key_exists($v['id'], $goods_cart_list)) {
					if (!empty($goods_cart_list[$v['id']]['num'])) {
						$goods_list[$k]['num'] = $goods_cart_list[$v['id']]['num'];
						$goods_list[$k]['rec_id'] = $goods_cart_list[$v['id']]['rec_id'];
					}
				}
			}
		}
		
		if (ecjia_touch_user::singleton()->isSignin()) {
			ecjia_front::$controller->assign('cart_list', $cart_list['cart_list'][0]['goods_list']);
			ecjia_front::$controller->assign('count', $cart_list['cart_list'][0]['total']);
			ecjia_front::$controller->assign('real_count', $cart_list['total']);
		}
		ecjia_front::$controller->assign('goods_list', $goods_list);
		 
		ecjia_front::$controller->assign('type_name', $type_name);
		ecjia_front::$controller->assign('goods_num', $goods_num);
		 
		ecjia_front::$controller->assign('store_id', $store_id);
		ecjia_front::$controller->assign('category_id', $category_id);
		ecjia_front::$controller->assign('rec_id', $rec_id);
	
		if (isset($_COOKIE['location_address_id']) && $_COOKIE['location_address_id'] > 0) {
			ecjia_front::$controller->assign('address_id', $_COOKIE['location_address_id']);
		}
	
		ecjia_front::$controller->assign('title', $store_info['seller_name']);
		ecjia_front::$controller->assign('header_left', ' ');
		 
		$header_right = array(
			'href' => RC_Uri::url('merchant/index/position', array('shop_address' => $store_info['shop_address'])),
			'info' => '<i class="iconfont icon-location"></i>',
		);
		ecjia_front::$controller->assign('header_right', $header_right);
		ecjia_front::$controller->assign('referer_url', urlencode(RC_Uri::url('merchant/index/init', array('store_id' => $store_id))));
		 
		ecjia_front::$controller->display('merchant.dwt');
	}
	
	/**
	 * 店铺详情
	 */
	public static function detail() {
		$store_id = intval($_GET['store_id']);
		$arr = array(
			'seller_id' => $store_id,
		);
		 
		//店铺信息
		$store_info = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_HOME_DATA)->data($arr)->run();
		 
		ecjia_front::$controller->assign('data', $store_info);
		ecjia_front::$controller->assign_title('店铺详情');
		ecjia_front::$controller->display('merchant_detail.dwt');
	}
	
	/**
	 * 获取店铺商品
	 */
	public static function ajax_goods() {
		$store_id = intval($_GET['store_id']);
		$category_id = 0;
		$action_type = '';
		 
		if (!empty($_GET['action_type']) && is_numeric($_GET['action_type'])) {
			$category_id = intval($_GET['action_type']);
		} else {
			$action_type = trim($_GET['action_type']);
		}
		 
		$type_name = '';
		$limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
		$page = intval($_GET['page']) ? intval($_GET['page']) : 1;
		 
		if ($action_type == 'best') {
			$type_name = '精选';
		} elseif ($action_type == 'hot') {
			$type_name = '热销';
		} elseif ($action_type == 'new') {
			$type_name = '新品';
		}
		 
		//店铺分类
		$store_category = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_CATEGORY)->data(array('seller_id' => $store_id))->run();
		 
		$goods_num = 0;
		if (!empty($action_type) && $action_type != 'all') {
			$parameter = array(
				'action_type' 	=> $action_type,
				'pagination' 	=> array('count' => $limit, 'page' => $page),
				'seller_id'		=> $store_id
			);
			$data = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_SUGGESTLIST)->data($parameter)->send()->getBody();
			$data = json_decode($data, true);
			$goods_num = $data['paginated']['count'];
			$goods_list = $data['data'];
		} else {
			//店铺分类商品
			$arr = array(
				'filter' 		=> array('category_id' => $category_id),
				'pagination' 	=> array('count' => $limit, 'page' => $page),
				'seller_id'		=> $store_id
			);
			$data = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_LIST)->data($arr)->send()->getBody();
			$data = json_decode($data, true);
			$goods_num = $data['paginated']['count'];
			$goods_list = $data['data'];
	
			if (empty($category_id)) {
				$type_name = '全部';
			} else {
				$type_name = '';
				if (!empty($store_category)) {
					foreach ($store_category as $k => $v) {
						if ($v['id'] == $category_id) {
							$type_name = $v['name'];
						} else if ($v['children']) {
							foreach ($v['children'] as $key => $val) {
								if ($val['id'] == $category_id) {
									$type_name = $val['name'];
								}
							}
						}
					}
				}
			}
		}
		 
		$token = ecjia_touch_user::singleton()->getToken();
		$arr = array(
			'token' 	=> $token,
			'seller_id' => $store_id,
			'location' 	=> array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude'])
		);
		 
		//店铺购物车商品
		$cart_list = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($arr)->run();
	
		$goods_cart_list = array();
		if (!empty($cart_list['cart_list'][0]['goods_list'])) {
			foreach ($cart_list['cart_list'][0]['goods_list'] as $k => $v) {
				if (!empty($v['goods_number'])) {
					$goods_cart_list[$v['goods_id']] = array('num' => $v['goods_number'], 'rec_id' => $v['rec_id']);
				}
			}
		}
		 
		if (!empty($goods_list)) {
			foreach ($goods_list as $k => $v) {
				if (array_key_exists($v['id'], $goods_cart_list)) {
					if (!empty($goods_cart_list[$v['id']]['num'])) {
						$goods_list[$k]['num'] = $goods_cart_list[$v['id']]['num'];
						$goods_list[$k]['rec_id'] = $goods_cart_list[$v['id']]['rec_id'];
					}
				}
			}
		}
		 
		if ($page == 1) {
			ecjia_front::$controller->assign('page', $page);
			ecjia_front::$controller->assign('type_name', $type_name);
			ecjia_front::$controller->assign('goods_num', $goods_num);
		}
		
		if (isset($goods_list['pager']['total']) && $goods_list['pager']['total'] == 0) {
			$goods_list = array();
		}
		ecjia_front::$controller->assign('goods_list', $goods_list);
		$say_list = ecjia_front::$controller->fetch('library/merchant_goods.lbi');
	
		if ($data['paginated']['more'] == 0) $data['is_last'] = 1;
		return ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $say_list, 'goods_list' => $goods_list, 'name' => $type_name, 'num' => $goods_num, 'type' => $action_type, 'is_last' => $data['is_last']));
	}

	/**
	 * 店铺位置
	 */
	public static function position() {
		$shop_address = $_GET['shop_address'];
		ecjia_front::$controller->assign('shop_address', $shop_address);
		ecjia_front::$controller->assign_title('店铺位置');
		 
		ecjia_front::$controller->display('merchant_position.dwt');
	}
	
}

// end