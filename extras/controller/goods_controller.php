<?php
/**
 * 商品模块控制器代码
 */
class goods_controller {
    /*
     * 分类信息
     * 获取分类信息
     */
    public static function init() {
    	$cat_id = isset($_GET['cid']) && intval($_GET['cid']) > 0 ? intval($_GET['cid']) : 0;
    	
    	$data = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_CATEGORY)->run();
    	if (empty($cat_id)) {
    		$cat_id = $data[0]['id'];
    	}
    	
    	ecjia_front::$controller->assign('cat_id', $cat_id);
    	ecjia_front::$controller->assign('data', $data);
        
//         ecjia_front::$controller->assign('title', RC_Lang::lang('catalog'));
//         ecjia_front::$controller->assign('page_title', RC_Lang::lang('catalog'));
        ecjia_front::$controller->assign_title(RC_Lang::lang('catalog'));
        ecjia_front::$controller->assign('active', 'category');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('category_list.dwt');
    }

    /**
     * 商品详情
     */
    public static function goods_info() {
    	$goods_id = isset($_GET['goods_id']) ? $_GET['goods_id'] : 0;
	    $rec_type = isset($_GET['rec_type']) ? $_GET['rec_type'] : 0;
	    $object_id= isset($_GET['object_id']) ? $_GET['object_id'] : 0;
	    //$goods_id = 412;
	    $par = array(
	    	'goods_id' => $goods_id,
	    	'rec_type' => $rec_type,
	    	'object_id'=> $object_id,
	    	'location' => array('longitude' => '121.41618102314', 'latitude' => '31.235278361951'),
	    );
	    /*商品基本信息*/
	    $goods_info = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_DETAIL)->data($par)->run();
	    if ($goods_info === false) {
	    	ecjia_front::$controller->assign('no_goods_info', 1);
	    	//ecjia_front::$controller->showmessage('不存在的信息', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }
	    if (!empty($goods_info['promote_end_date'])) {
	    	$goods_info['promote_end_time'] = RC_Time::local_strtotime($goods_info['promote_end_date']);
	    }
		/*商品所属店铺购物车列表*/
	   	$token = ecjia_touch_user::singleton()->getToken();
	   	$options = array(
	   		'token' 	=> $token,
	   		'seller_id' => $goods_info['seller_id'],
	   		'location' 	=> array('longitude' => '121.416359', 'latitude' => '31.235371')
	   	);
	   	 
	   	//店铺购物车商品
	   	$cart_goods_list = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($options)->run();
	   	
		/*购物车商品总数*/
		$total_num = $cart_goods_list['total']['goods_number'];
		
	   	$cart_goods_id = $cart_arr = array();
	   	$rec_id = $data_rec = $num = '';
	   	if (!empty($cart_goods_list['cart_list'][0]['goods_list'])) {
	   		$cart_goods_list['cart_list'][0]['total']['check_all'] = true;
	   		$cart_goods_list['cart_list'][0]['total']['check_one'] = false;
	   		foreach ($cart_goods_list['cart_list'][0]['goods_list'] as $key => $val) {
	   			if ($goods_id == $val['goods_id']) {
	   				$rec_id = $val['rec_id'];
	   				$num 	= $val['goods_number'];
	   			}
	   			$cart_arr[$val['goods_id']] = array('num' => $val['goods_number'], 'rec_id' => $val['rec_id']);
	   			
	   			if ($val['is_checked'] == 1 && $val['is_disabled'] == 0) {
	   				$cart_goods_list['cart_list'][0]['total']['check_one'] = true;	//至少选择了一个
	   				if ($k == 0) {
	   					$data_rec = $val['rec_id'];
	   				} else {
	   					$data_rec .= ','.$val['rec_id'];
	   				}
	   			} elseif ($val['is_checked'] == 0) {
	   				$cart_goods_list['cart_list'][0]['total']['check_all'] = false;	//全部选择
	   				$cart_goods_list['cart_list'][0]['total']['goods_number'] -= $v['goods_number'];
	   			}
	   			$data_rec = trim($data_rec, ',');
	   		}
	   	} else {
	   		$cart_goods_list['cart_list'][0]['total']['check_all'] = false;
	   		$cart_goods_list['cart_list'][0]['total']['check_one'] = false;
	   	}
	   	
	   	if (!empty($goods_info['related_goods'])){
	   		foreach ($goods_info['related_goods'] as $k => $v) {
	   			if (array_key_exists($v['goods_id'], $cart_arr)) {
	   				$goods_info['related_goods'][$k]['num'] = $cart_arr[$v['goods_id']]['num'];
	   				$goods_info['related_goods'][$k]['rec_id'] = $cart_arr[$v['goods_id']]['rec_id'];
	   			}
	   		}
	   	}

		/*商品描述*/
	    $goods_desc = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_DESC)->data(array('goods_id' => $goods_id))->run();
	    
	    if (!empty($rec_id)) {
	    	ecjia_front::$controller->assign('rec_id', $rec_id);
	    }

	    ecjia_front::$controller->assign('num', $num);
	    ecjia_front::$controller->assign('total_num', $total_num);
	    ecjia_front::$controller->assign('goods_info', $goods_info);
	    ecjia_front::$controller->assign('goods_desc', $goods_desc);
	    
	    ecjia_front::$controller->assign('cart_list', $cart_goods_list['cart_list'][0]['goods_list']);
	    ecjia_front::$controller->assign('count', $cart_goods_list['cart_list'][0]['total']);
	    ecjia_front::$controller->assign('real_count', $cart_goods_list['total']);
	    ecjia_front::$controller->assign('data_rec', $data_rec);
	    
	    if (isset($_COOKIE['location_address_id']) && $_COOKIE['location_address_id'] > 0) {
	    	ecjia_front::$controller->assign('address_id', $_COOKIE['location_address_id']);
	    }
	    ecjia_front::$controller->assign('referer_url', urlencode(RC_Uri::url('goods/index/show', array('goods_id' => $goods_id))));
	    
	    ecjia_front::$controller->assign_title('商品详情');
        ecjia_front::$controller->display('goods_info.dwt');
    }

    /**
     * 促销商品
     */
    public static function goods_promotion() {
		ecjia_front::$controller->assign_title('促销商品');
    	ecjia_front::$controller->display('goods_promotion.dwt');
    }

    /**
     * ajax获取促销商品
     */
    public static function ajax_goods() {
  		$type = htmlspecialchars($_GET['type']);
        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        
        $paramater = array(
        	'action_type' 	=> $type,	
 			'pagination' 	=> array('count' => $limit, 'page' => $page),
			'location' 		=> array('longitude' => '121.416359', 'latitude' => '31.235371')
        );
        
        $arr = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_SUGGESTLIST)->data($paramater)->send()->getBody();
        $list = json_decode($arr, true);
		
		$goods_list = !empty($list['data']) ? $list['data'] : array();
        if (!empty($goods_list)) {
        	foreach ($goods_list as $k => $v) {
        		$goods_list[$k]['promote_end_date'] = RC_Time::local_strtotime($v['promote_end_date']);
        	}
        }
        ecjia_front::$controller->assign('goods_list', $goods_list);
        ecjia_front::$controller->assign_lang();
    	if ($type == 'promotion') {
    		$sayList = ecjia_front::$controller->fetch('goods_promotion.dwt');
    	} elseif ($type == 'new') {
    		$sayList = ecjia_front::$controller->fetch('goods_new.dwt');
    	}
    	if ($list['paginated']['more'] == 0) $goods_list['is_last'] = 1;
    	return ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList, 'page', 'is_last' => $goods_list['is_last']));
    }


    /**
     * 新品推荐
     */
    public static function goods_new() {
    	ecjia_front::$controller->assign_title('新品推荐');
    	ecjia_front::$controller->display('goods_new.dwt');
    }

    /**
     * 店铺列表
     */
    public static function store_list() {
    	$cid 		= intval($_GET['cid']);
    	$store_id 	= intval($_GET['store_id']);
    	$keywords 	= isset($_POST['keywords']) ? $_POST['keywords'] : (isset($_GET['keywords']) ? trim($_GET['keywords']) : '');
    	
    	$limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
    	$page = intval($_GET['page']) ? intval($_GET['page']) : 1;
    	
    	$type = isset($_GET['type']) ? $_GET['type'] : '';//判断是否是下滑加载
    	
    	$arr = array(
    		'pagination'	=> array('count' => $limit, 'page' => $page),
    		'location' 		=> array('longitude' => '121.416359', 'latitude' => '31.235371')
    	);
    	
    	if ($keywords !== '') {
    		if (!empty($store_id)) {
    			$arr['filter']['keywords'] = $keywords;
    			$arr['seller_id'] = $store_id;
    			
    			$data = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_LIST)->data($arr)->send()->getBody();
    			$data = json_decode($data, true);
    			if ($data['status']['succeed'] == 1) {
    				$arr_list = $data['data'];
    			} else {
    				$arr_list = $data['data']['data'];
    			}
    			//购物车商品
	   			$token = ecjia_touch_user::singleton()->getToken();
    			$paramater = array(
    				'token' 	=> $token,
    				'location' 	=> array('longitude' => '121.416359', 'latitude' => '31.235371')
    			);
    			if (!empty($store_id)) {
    				$paramater['seller_id'] = $store_id;
    			}
    			$cart_list = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($paramater)->run();
    			 
    			$goods_cart_list = array();
    			$cart_list['cart_list'][0]['total']['check_all'] = true;
    			$cart_list['cart_list'][0]['total']['check_one'] = false;
    			$rec_id = '';
    			if (!empty($cart_list['cart_list'][0]['goods_list'])) {
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
    			
    			if (!empty($arr_list)) {
    				foreach ($arr_list as $k => $v) {
    					if (array_key_exists($v['id'], $goods_cart_list)) {
    						if (!empty($goods_cart_list[$v['id']]['num'])) {
    							$arr_list[$k]['num'] = $goods_cart_list[$v['id']]['num'];
    							$arr_list[$k]['rec_id'] = $goods_cart_list[$v['id']]['rec_id'];
    						}
    					}
    				}
    			}
    			ecjia_front::$controller->assign('cart_list', $cart_list['cart_list'][0]['goods_list']);
    			ecjia_front::$controller->assign('count', $cart_list['cart_list'][0]['total']);
    			ecjia_front::$controller->assign('real_count', $cart_list['total']);
    			ecjia_front::$controller->assign('rec_id', $rec_id);
    			
    			if (isset($_COOKIE['location_address_id']) && $_COOKIE['location_address_id'] > 0) {
    				ecjia_front::$controller->assign('address_id', $_COOKIE['location_address_id']);
    			}
    			if ($type == 'ajax_get') {
    				ecjia_front::$controller->assign('goods_list', $arr_list);
    				$say_list = ecjia_front::$controller->fetch('store_list.dwt');
    			} else {
    				user_function::insert_search($keywords, $store_id);//记录搜索
    			}
    			
    			$store_info = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_HOME_DATA)->data(array('seller_id' => $store_id, 'location' => array('longitude' => '121.416359', 'latitude' => '31.235371')))->run();
    			ecjia_front::$controller->assign('store_info', $store_info);
    		} else {
    			$arr['keywords'] = $keywords;
    				
    			$data = ecjia_touch_manager::make()->api(ecjia_touch_api::SELLER_LIST)->data($arr)->send()->getBody();
    			$data = json_decode($data, true);
    			$arr_list = $data['data'];
    			
    			if ($type == 'ajax_get') {
    				ecjia_front::$controller->assign('data', $arr_list);
    				$say_list = ecjia_front::$controller->fetch('library/store_list.lbi');
    			} else {
    				user_function::insert_search($keywords, $store_id);//记录搜索
    			}
    		}
    		ecjia_front::$controller->assign('store_id', $store_id);
    		ecjia_front::$controller->assign('keywords', $keywords);
    	} else {
    		$arr['category_id'] = $cid;
    		$data = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_SELLER_LIST)->data($arr)->send()->getBody();
    		$data = json_decode($data, true);
    		$arr_list = $data['data'];
    		
    		if ($type == 'ajax_get') {
    			ecjia_front::$controller->assign('data', $arr_list);
    			$say_list = ecjia_front::$controller->fetch('library/store_list.lbi');
    		}
    	}
		
    	$data['is_last'] = 0;
    	if ($data['paginated']['more'] == 0) $data['is_last'] = 1;
    	
    	ecjia_front::$controller->assign('is_last', $data['is_last']);
    	
    	if (array_key_exists('data', $arr_list) && $arr_list['pager']['total'] == 0) {
    		$arr_list = array();
    	}
    	ecjia_front::$controller->assign('data', $arr_list);
    	ecjia_front::$controller->assign('count_search', count($arr_list));
    	
    	if ($type == 'ajax_get') {
    		return ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $say_list, 'is_last' => $data['is_last']));
    	}
    	
    	ecjia_front::$controller->assign('referer_url', urlencode(RC_Uri::url('goods/category/store_list', array('store_id' => $store_id, 'keywords' => $keywords))));
    	ecjia_front::$controller->assign_title('店铺列表');
    	ecjia_front::$controller->display('store_list.dwt');
    }
    
    public static function seller_list() {
    	$cid = intval($_GET['cid']);
    	
    	$limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
    	$page = intval($_GET['page']) ? intval($_GET['page']) : 1;
    	 
    	$type = isset($_GET['type']) ? $_GET['type'] : '';//判断是否是下滑加载
    	 
    	$arr = array(
    		'pagination'	=> array('count' => $limit, 'page' => $page),
    		'location' 		=> array('longitude' => '121.416359', 'latitude' => '31.235371')
    	);
    	$arr['category_id'] = $cid;
    	$data = ecjia_touch_manager::make()->api(ecjia_touch_api::SELLER_LIST)->data($arr)->send()->getBody();
    	$data = json_decode($data, true);

    	if ($type == 'ajax_get') {
    		ecjia_front::$controller->assign('data', $data['data']);
    		$say_list = ecjia_front::$controller->fetch('seller_list.dwt');
    		
    		if ($data['paginated']['more'] == 0) $data['is_last'] = 1;
    		return ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $say_list, 'is_last' => $data['is_last']));
    	}
    	
    	ecjia_front::$controller->assign_title('店铺列表');
    	ecjia_front::$controller->assign('cid', $cid);
    	ecjia_front::$controller->display('seller_list.dwt');
    }

}

// end