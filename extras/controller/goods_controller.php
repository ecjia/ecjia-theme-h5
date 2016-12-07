<?php
/**
 * 商品模块控制器代码
 */
class goods_controller {

    /*
     * 分类信息
     * 获取分类信息
     */
    public static function top_all() {
    	$cat_id = isset($_GET['cid']) && intval($_GET['cid']) > 0 ? intval($_GET['cid']) : 0;
    	
    	$cache_key = 'goods_category_list';
    	$data = RC_Cache::app_cache_get($cache_key, 'goods');
    	if (!$data) {
    		$data = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_CATEGORY)->run();
    		RC_Cache::app_cache_set($cache_key, $data, 'goods', 60*24);//24小时缓存
    	}
    	
    	if (empty($cat_id)) {
    		$cat_id = $data[0]['id'];
    	}
    	
    	ecjia_front::$controller->assign('cat_id', $cat_id);
    	ecjia_front::$controller->assign('data', $data);
        
        ecjia_front::$controller->assign('title', RC_Lang::lang('catalog'));
        ecjia_front::$controller->assign('page_title', RC_Lang::lang('catalog'));
        ecjia_front::$controller->assign_title(RC_Lang::lang('catalog'));
        ecjia_front::$controller->assign('active', 2);
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('category_top_all.dwt');
    }

    /**
     * 分类产品信息列表
     */
    public static function goods_list() {
        RC_Loader::load_theme('extras/functions/b2b2c_front_merchant.func.php');

        $keywords = htmlspecialchars($_REQUEST['keywords']);
        $val = mysql_like_quote(trim($keywords));
        
        // $brand = intval($_REQUEST['brand']);
        // $type = intval($_REQUEST['type']);
        //
        if (empty($_REQUEST['cid']) && empty($brand)) {
            if (empty($keywords)) {
                ecjia_front::$controller->showmessage('请输入要搜索商品的关键字', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
            }
        }
        // /* 记录浏览历史 */
        // if (!empty($keywords)) {
        //     if (!empty($_COOKIE ['ECJia'] ['search'])) {
        //         $history = explode(',', $_COOKIE ['ECJia'] ['search']);
        //         array_unshift($history, $keywords);
        //         $history = array_unique($history);
        //         while (count($history) > ecjia::config('history_number')) {
        //             array_pop($history);
        //         }
        //         setcookie('ECJia[search]', implode(',', $history), RC_Time::gmtime() + 3600 * 24 * 30);
        //     } else {
        //         setcookie('ECJia[search]', $keywords, RC_Time::gmtime() + 3600 * 24 * 30);
        //     }
        // }
        // $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        // $order = htmlspecialchars($_GET['order'])? htmlspecialchars($_GET['order']) : 'ASC';
        // $sort = htmlspecialchars($_GET['sort'])? htmlspecialchars($_GET['sort']) :'last_update';
        // $price_min = intval($_REQUEST['price_min']);
        // $price_max = intval($_REQUEST['price_max']);
        // $goodslist = goods_category::factory()->get_category_goods($page, intval($_REQUEST['cid']), $val, $brand, $price_min, $price_max, $sort, $order);
        // $filter = array(
        //     'price_min' => $price_min,
        //     'price_max' => $price_max,
        //     'filter_attr_str' => goods_category::factory()->filter_attr_str,
        //     'children' => goods_category::factory()->children,
        // );
        // ecjia_front::$controller->assign('brand_id',        $brand);
        // ecjia_front::$controller->assign('filter_attr',     goods_category::factory()->filter_attr_str);
        // ecjia_front::$controller->assign('page',            $page);
        // ecjia_front::$controller->assign('size',            goods_category::factory()->size);
        // ecjia_front::$controller->assign('keywords',        $keywords);
        // ecjia_front::$controller->assign('view',            intval($_GET['view']));
        // ecjia_front::$controller->assign('price_min',       $price_min);
        // ecjia_front::$controller->assign('price_max',       $price_max);
        // ecjia_front::$controller->assign('brand',           $brand);
        // ecjia_front::$controller->assign('sort',            $sort);
        // ecjia_front::$controller->assign('order',           $order);
        // ecjia_front::$controller->assign('id',              intval($_REQUEST['cid']));
        // ecjia_front::$controller->assign('type',            $type);
        // /* 获取价格分级 */
        // ecjia_front::$controller->assign('price_grade', goods_category::factory()->get_price_range(intval($_REQUEST['cid']), $brand, $filter));
        // /* 属性筛选 */
        // ecjia_front::$controller->assign('filter_attr_list',    goods_category::factory()->get_attr_range());
        // /* 品牌筛选 */
        // ecjia_front::$controller->assign('brands',          goods_category::factory()->get_brands_range(intval($_REQUEST['cid']), $brand, $filter));
        // /* 获取分类 */
        // ecjia_front::$controller->assign('category',        goods_category::factory()->get_top_category());
        //
        // ecjia_front::$controller->assign('goods_list', $goodslist['list']);
        // ecjia_front::$controller->assign('pages', $goodslist['page']);
        //
        // $cat = get_cat_info(goods_category::factory()->cat_id);  // 获得分类的相关信息
        // if (!empty($cat['keywords'])) {
        //     if (!empty($cat['keywords'])) {
        //         ecjia_front::$controller->assign('keywords_list', explode(' ', $cat['keywords']));
        //     }
        // }
        // ecjia_front::$controller->assign('categories', get_categories_tree(goods_category::factory()->cat_id));
        // ecjia_front::$controller->assign('show_marketprice', ecjia::config('show_marketprice'));
        // ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('category.dwt');
    }

    /**
     * 异步加载商品列表
     */
    public static function asynclist() {
        // $brand = intval($_REQUEST['brand']);
        // $keywords = htmlspecialchars($_REQUEST['keywords']);
        // $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        // $order = htmlspecialchars($_GET['order']);
        // $sort = htmlspecialchars($_GET['sort']);
        // $price_min = intval($_REQUEST['price_min']);
        // $price_max = intval($_REQUEST['price_max']);
        // $val = mysql_like_quote(trim($keywords));
        // $goodslist = goods_category::factory()->get_category_goods($page, intval($_REQUEST['cid']), $val, $brand, $price_min, $price_max, $sort, $order);
        // ecjia_front::$controller->assign('show_marketprice', ecjia::config('show_marketprice'));
        // ecjia_front::$controller->assign('goods_list', $goodslist['list']);
        // ecjia_front::$controller->assign_lang();
        // $list = ecjia_front::$controller->fetch('category.dwt');
        // ecjia_front::$controller->showmessage('成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list'=>$list, 'is_last'=>$goodslist['is_last']));
    }

    public static function goods_index() {
    	$goods_id = isset($_GET['id']) ? $_GET['id'] : 0;
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
	    if (!empty($goods_info['promote_end_date'])) {
	    	$goods_info['promote_end_time'] = RC_Time::local_strtotime($goods_info['promote_end_date']);
	    }
	    
		/*商品所属店铺购物车列表*/
	   	$token = 'cb753377df06afef1c779e3808381105522a023b';
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
	   	$rec_id = '';
	   	$num = '';
	   	if (!empty($cart_goods_list['cart_list'][0]['goods_list'])) {
	   		foreach ($cart_goods_list['cart_list'][0]['goods_list'] as $key => $val) {
	   			if ($goods_id == $val['goods_id']) {
	   				$rec_id = $val['rec_id'];
	   				$num 	= $val['goods_number'];
	   			}
	   			$cart_arr[$val['goods_id']] = array('num' => $val['goods_number'], 'rec_id' => $val['rec_id']);
	   		}
	   	}
	   	
	   	if (!empty($goods_info['related_goods'])){
	   		foreach ($goods_info['related_goods'] as $k => $v) {
	   			if (mb_strlen(trim($v['name'])) > 14) {
	   				$goods_info['related_goods'][$k]['name'] = mb_substr(trim($v['name']), 0, 14, 'UTF-8').'...';
	   			}
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
	    
        ecjia_front::$controller->display('goods_info.dwt');
    }

    /**
     * 商品信息
     */
    public static function goods_info() {
        // $goods_id = isset($_GET ['id']) ? intval($_GET ['id']) : 0;
        // /* 获得商品的信息 */
        // $goods = get_goods_info($goods_id);
        // ecjia_front::$controller->assign('goods', $goods);
        // $properties = get_goods_properties($goods_id); // 获得商品的规格和属性
        // ecjia_front::$controller->assign('properties', $properties['pro']); // 商品属性
        // ecjia_front::$controller->assign('specification', $properties['spe']); // 商品规格
        // ecjia_front::$controller->assign('title', RC_Lang::lang('detail_intro'));
        // ecjia_front::$controller->assign_title(RC_Lang::lang('detail_intro'));
        // ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('goods_info.dwt');
    }

    /**
     * 改变属性、数量时重新计算商品价格
     */
    public static function goods_price() {
        // $goods_id = isset($_GET ['id']) ? intval($_GET ['id']) : 0;
        // /*格式化返回数组*/
        // $res = array(
        //     'err_msg'	=> '',
        //     'result'	=> '',
        //     'qty'		=> 1
        // );
        // /*获取参数*/
        // $attr_id = isset($_REQUEST ['attr']) ? explode(',', $_REQUEST ['attr']) : array();
        // $number = (isset($_REQUEST ['number'])) ? intval($_REQUEST ['number']) : 1;
        // /*如果商品id错误*/
        // if ($goods_id == 0) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('err_change_attr'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('err_no'=>1));
        // } else {
        //     /*查询*/
        //     if ($number <= 0) {
        //         $res ['qty'] = $number = 1;
        //     } else {
        //         $res ['qty'] = $number;
        //     }
        //     $shop_price = get_final_price($goods_id, $number, true, $attr_id);
        //     $res ['result'] = price_format($shop_price * $number);
        // }
        // ecjia_front::$controller->showmessage($res['result'], ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON);
    }

    /**
     * 促销商品
     */
    public static function goods_promotion() {
		ecjia_front::$controller->assign('title', '促销商品');
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
        
        $cache_key = 'goods_list_'.$type.'_'.$limit.'_'.$page;
        $arr = RC_Cache::app_cache_get($cache_key, 'goods');
        if (!$arr) {
        	$arr = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_SUGGESTLIST)->data($paramater)->send()->getBody();
        	RC_Cache::app_cache_set($cache_key, $arr, 'goods', 60*24);//24小时缓存
        }
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
    	ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList, 'page', 'is_last' => $goods_list['is_last']));
    }


    /**
     * 新品推荐
     */
    public static function goods_new() {
    	ecjia_front::$controller->assign('title', '新品推荐');
    	ecjia_front::$controller->display('goods_new.dwt');
    }

    /*
     * 商品标签
     *
     */
    public static function tags_list() {
        // $goods_id = intval($_GET['id']);
        // $tags = get_goods_tags($goods_id);
        // ecjia_front::$controller->assign('tags',     $tags);
        // ecjia_front::$controller->assign('goods_id', $goods_id);
        // ecjia_front::$controller->assign('title',    '商品标签');
        // ecjia_front::$controller->display('goods_tag.dwt');
    }

    /**
     *
     * 添加标签
     */
    public static function add_tags() {
        // $db = RC_Loader::load_app_model('tag_model');
        //  RC_Loader::load_theme('extras/model/goods/goods_tag_model.class.php');
        // $db       = new goods_tag_model();
        // $id = htmlspecialchars($_POST['goods_id']);
        // $tags = trim(htmlspecialchars($_POST['tags']));
        // if (empty($_SESSION['user_id'])) {
        //     ecjia_front::$controller->showmessage('请登录后在添加标签', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('user/index/login')));
        // }
        // if (empty($tags)) {
        //     ecjia_front::$controller->showmessage('标签不能为空', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // }
        // $data = array(
        //     'user_id' => $_SESSION['user_id'],
        //     'tag_words' => $tags,
        //     'goods_id' => $id,
        // );
        // $count = $db->where($data)->count();
        // if (!empty($count)) {
        //     ecjia_front::$controller->showmessage('不能在同一商品下添加重复标签', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('goods/index/tag', array('id' => $id))));
        // }
        // $tag = $db->insert($data);
        // if ($tag) {
        //     ecjia_front::$controller->showmessage('添加成功', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('is_show' => false,'pjaxurl' => RC_Uri::url('goods/index/tag', array('id' => $id))));
        // }
    }

    /**
    *
    * 评论页面
    */
    public static function comment() {
        // $id = intval($_GET['id']);
        // // $db_user = RC_loader::load_app_model('users_model','user');
        // RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
        // $db_user       = new touch_users_model();
        // $email = $db_user->where(array('user_id' => $_SESSION['user_id']))->get_field('email');
        // ecjia_front::$controller->assign('id', $id);
        // ecjia_front::$controller->assign('email', $email);
        // ecjia_front::$controller->assign('title', '发表评论');
        // ecjia_front::$controller->assign('enabled_captcha', ecjia::config('captcha'));
        // ecjia_front::$controller->assign_title('发表评论');
        // ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('goods_comment.dwt');
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
    			
    			$merchant_goods_key = 'merchant_goods_list_'.$store_id.'_'.$keywords.'_'.$limit.'_'.$page;
    			$data = RC_Cache::app_cache_get($merchant_goods_key, 'goods');
    			if (!$data) {
    				$data = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_LIST)->data($arr)->send()->getBody();
    				RC_Cache::app_cache_set($merchant_goods_key, $data, 'goods', 60*24);//24小时缓存
    			}
    			$data = json_decode($data, true);
    			$arr_list = $data['data'];
    			//购物车商品
    			$token = touch_function::get_token();
    			$paramater = array(
    				'token' 	=> $token,
    				'location' 	=> array('longitude' => '121.416359', 'latitude' => '31.235371')
    			);
    			if (!empty($store_id)) {
    				$paramater['seller_id'] = $store_id;
    			}
    			$cart_list = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($paramater)->run();
    			 
    			$goods_cart_list = array();
    			if (!empty($cart_list['cart_list'][0]['goods_list'])) {
    				foreach ($cart_list['cart_list'][0]['goods_list'] as $k => $v) {
    					if (!empty($v['goods_number'])) {
    						$goods_cart_list[$v['goods_id']] = array('num' => $v['goods_number'], 'rec_id' => $v['rec_id']);
    					}
    					if ($v['is_checked'] != 1) {
    						$cart_list['cart_list'][0]['total']['check_all'] = false;
    						$cart_list['cart_list'][0]['total']['goods_number'] -= $v['goods_number'];
    					}
    				}
    			} else {
    				$cart_list['cart_list'][0]['total']['check_all'] = false;
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
    			
    			if ($type == 'ajax_get') {
    				ecjia_front::$controller->assign('goods_list', $arr_list);
    				$say_list = ecjia_front::$controller->fetch('store_list.dwt');
    			} else {
    				user_function::insert_search($keywords, $store_id);//记录搜索
    			}
    		} else {
    			$arr['keywords'] = $keywords;
    				
    			$merchant_goods_key = 'merchant_goods_list_'.$keywords.'_'.$limit.'_'.$page;
    			$data = RC_Cache::app_cache_get($merchant_goods_key, 'goods');
    			if (!$data) {
    				$data = ecjia_touch_manager::make()->api(ecjia_touch_api::SELLER_LIST)->data($arr)->send()->getBody();
    				RC_Cache::app_cache_set($merchant_goods_key, $data, 'goods', 60*24);//24小时缓存
    			}
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
    		$goods_seller_key = 'goods_seller_list_'.$cid.'_'.$limit.'_'.$page;
    		$data = RC_Cache::app_cache_get($goods_seller_key, 'goods');
    		if (!$data) {
    			$data = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_SELLER_LIST)->data($arr)->send()->getBody();
    			RC_Cache::app_cache_set($goods_seller_key, $data, 'goods', 60*24);//24小时缓存
    		}
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
    	ecjia_front::$controller->assign('data', $arr_list);
    	
    	if ($type == 'ajax_get') {
    		ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $say_list, 'is_last' => $data['is_last']));
    		return false;
    	}
    	ecjia_front::$controller->display('store_list.dwt');
    }
    
    /**
     * 店铺详情
     */
    public static function store_detail() {
    	$store_id = intval($_GET['store_id']);
    	$arr = array(
    		'seller_id' => $store_id,
    	);
    	
    	//店铺信息
    	$cache_key = 'store_info_'.$store_id;
    	$store_info = RC_Cache::app_cache_get($cache_key, 'goods');
    	if (!$store_info) {
    		$store_info = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_HOME_DATA)->data($arr)->run();
    		RC_Cache::app_cache_set($cache_key, $store_info, 'goods', 60*24);//24小时缓存
    	}
    	
    	ecjia_front::$controller->assign('data', $store_info);
    	ecjia_front::$controller->display('store_detail.dwt');
    }
    
    /**
     * 店铺商品
     */
    public static function store_goods() {
    	$store_id 		= intval($_GET['store_id']);
    	$category_id 	= intval($_GET['category_id']);
    	
    	$limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
    	$page = intval($_GET['page']) ? intval($_GET['page']) : 1;
    	
    	//店铺信息
    	$cache_key = 'store_info_'.$store_id;
    	$store_info = RC_Cache::app_cache_get($cache_key, 'goods');
    	if (!$store_info) {
    		$store_info = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_HOME_DATA)->data(array('seller_id' => $store_id, 'location' => array('longitude' => '121.416359', 'latitude' => '31.235371')))->run();
    		RC_Cache::app_cache_set($cache_key, $store_info, 'goods', 60*24);//24小时缓存
    	}
    	ecjia_front::$controller->assign('store_info', $store_info);

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
    	$cache_key = 'store_category_'.$store_id;
    	$store_category = RC_Cache::app_cache_get($cache_key, 'goods');
    	if (!$store_category) {
    		$store_category = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_CATEGORY)->data(array('seller_id' => $store_id))->run();
    		RC_Cache::app_cache_set($cache_key, $store_category, 'goods', 60*24);//24小时缓存
    	}
    	ecjia_front::$controller->assign('store_category', $store_category);
    	
    	if (!empty($action_type) && $action_type != 'all') {
    		$parameter = array(
    			'action_type' 	=> $action_type,
    			'pagination' 	=> array('count' => $limit, 'page' => $page),
    			'seller_id'		=> $store_id
    		);
    		$suggest_goods_key = 'suggest_goods_'.$store_id.'_'.$action_type.'_'.$limit.'_'.$page;
    		$data = RC_Cache::app_cache_get($suggest_goods_key, 'goods');
    		if (!$data) {
    			$data = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_SUGGESTLIST)->data($parameter)->send()->getBody();
    			RC_Cache::app_cache_set($suggest_goods_key, $data, 'goods', 60*24);//24小时缓存
    		}
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
    		 
    		$merchant_goods_key = 'merchant_goods_list_'.$store_id.'_'.$category_id.'_'.$limit.'_'.$page;
    		$data = RC_Cache::app_cache_get($merchant_goods_key, 'goods');
    		
    		if (!$data) {
    			$data = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_LIST)->data($arr)->send()->getBody();
    			RC_Cache::app_cache_set($merchant_goods_key, $data, 'goods', 60*24);//24小时缓存
    		}
    		$data = json_decode($data, true);
    		$goods_num = $data['paginated']['count'];
    		$goods_list = $data['data'];
    		
    		if (empty($category_id)) {
    			$type_name = '全部';
    		}
    	}
    	
    	$token = 'cb753377df06afef1c779e3808381105522a023b';
    	$arr = array(
    		'token' 	=> $token, 
    		'seller_id' => $store_id, 
    		'location' 	=> array('longitude' => '121.416359', 'latitude' => '31.235371')
    	);
    	
    	//店铺购物车商品
    	$cart_list = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($arr)->run();

    	$goods_cart_list = array();
    	if (!empty($cart_list['cart_list'][0]['goods_list'])) {
    		$cart_list['cart_list'][0]['total']['check_all'] = true;
    		foreach ($cart_list['cart_list'][0]['goods_list'] as $k => $v) {
    			if (!empty($v['goods_number'])) {
    				$goods_cart_list[$v['goods_id']] = array('num' => $v['goods_number'], 'rec_id' => $v['rec_id']);
    			}
    			if ($v['is_checked'] != 1) {
    				$cart_list['cart_list'][0]['total']['check_all'] = false;
    				$cart_list['cart_list'][0]['total']['goods_number'] -= $v['goods_number'];
    			}
    		}
    	} else {
    		$cart_list['cart_list'][0]['total']['check_all'] = false;
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
    	
    	ecjia_front::$controller->assign('cart_list', $cart_list['cart_list'][0]['goods_list']);
    	ecjia_front::$controller->assign('count', $cart_list['cart_list'][0]['total']);
    	ecjia_front::$controller->assign('real_count', $cart_list['total']);
    	ecjia_front::$controller->assign('goods_list', $goods_list);
    	
    	ecjia_front::$controller->assign('type_name', $type_name);
    	ecjia_front::$controller->assign('goods_num', $goods_num);
    	
    	ecjia_front::$controller->assign('store_id', $store_id);
    	ecjia_front::$controller->assign('category_id', $category_id);
    	
    	ecjia_front::$controller->assign('title', $store_info['seller_name']);
    	ecjia_front::$controller->assign('header_left', ' ');
    	
    	$header_right = array(
    		'href' => '#',
    		'info' => '<i class="iconfont icon-location"></i>'
    	);
    	ecjia_front::$controller->assign('header_right', $header_right);
    	
    	ecjia_front::$controller->display('store_goods.dwt');
    }
    
    public static function ajax_category_goods() {
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
    	$cache_key = 'store_category_'.$store_id;
    	$store_category = RC_Cache::app_cache_get($cache_key, 'goods');
    	if (!$store_category) {
    		$store_category = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_CATEGORY)->data(array('seller_id' => $store_id))->run();
    		RC_Cache::app_cache_set($cache_key, $store_category, 'goods', 60*24);//24小时缓存
    	}
    	
    	$goods_num = 0;
    	if (!empty($action_type) && $action_type != 'all') {
    		$parameter = array(
    			'action_type' 	=> $action_type,
    			'pagination' 	=> array('count' => $limit, 'page' => $page),
    			'seller_id'		=> $store_id
    		);
    		$suggest_goods_key = 'suggest_goods_'.$store_id.'_'.$action_type.'_'.$limit.'_'.$page;
    		$data = RC_Cache::app_cache_get($suggest_goods_key, 'goods');
    		if (!$data) {
    			$data = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_SUGGESTLIST)->data($parameter)->send()->getBody();
    			RC_Cache::app_cache_set($suggest_goods_key, $data, 'goods', 60*24);//24小时缓存
    		}
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
    		$merchant_goods_key = 'merchant_goods_list_'.$store_id.'_'.$category_id.'_'.$limit.'_'.$page;
    		$data = RC_Cache::app_cache_get($merchant_goods_key, 'goods');
    		
    		if (!$data) {
    			$data = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_LIST)->data($arr)->send()->getBody();
    			RC_Cache::app_cache_set($merchant_goods_key, $data, 'goods', 60*24);//24小时缓存
    		}
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
    	
    	$token = 'cb753377df06afef1c779e3808381105522a023b';
    	$arr = array(
    		'token' 	=> $token,
    		'seller_id' => $store_id,
    		'location' 	=> array('longitude' => '121.416359', 'latitude' => '31.235371')
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
    	
    	ecjia_front::$controller->assign('goods_list', $goods_list);
    	$say_list = ecjia_front::$controller->fetch('library/store_goods.lbi');
    		
    	if ($data['paginated']['more'] == 0) $data['is_last'] = 1;
    	ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $say_list, 'goods_list' => $goods_list, 'name' => $type_name, 'num' => $goods_num, 'type' => $action_type, 'is_last' => $data['is_last']));
    }
    
    public static function update_cart() {
    	$rec_id 	= is_array(($_POST['rec_id'])) ? $_POST['rec_id'] : intval($_POST['rec_id']);
    	$new_number = intval($_POST['val']);
    	$store_id 	= intval($_POST['store_id']);
    	$goods_id   = intval($_POST['goods_id']);
    	$checked	= isset($_POST['checked']) ? $_POST['checked'] : '';
    	
    	$token = 'cb753377df06afef1c779e3808381105522a023b';
    	$arr = array(
    		'token' 	=> $token,
    		'location' 	=> array('longitude' => '121.416359', 'latitude' => '31.235371'),
    	);
    	if (!empty($store_id)) {
    		$arr['seller_id'] = $store_id;
    	}
    	
    	//修改购物车中商品选中状态
    	if ($checked !== '') {
    		if (is_array($rec_id)) {
    			$arr['rec_id'] = implode(',', $rec_id);
    		} else {
    			$arr['rec_id'] = $rec_id;
    		}
    		$arr['is_checked'] = $checked;
    		ecjia_touch_manager::make()->api(ecjia_touch_api::CART_CHECKED)->data($arr)->run();
    	} else {
    		//清空购物车
    		if (is_array($rec_id)) {
    			$arr['rec_id'] = implode(',', $rec_id);
    			$data = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_DELETE)->data($arr)->run();
    		
    			ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON);
    			return;
    		} else {
    			if (!empty($new_number)) {
    				$arr['new_number'] = $new_number;
    				if (!empty($rec_id)) {
    					//更新购物车中商品
    					$arr['rec_id'] = $rec_id;
    					ecjia_touch_manager::make()->api(ecjia_touch_api::CART_UPDATE)->data($arr)->run();
    				} elseif (!empty($goods_id)) {
    					//添加商品到购物车
    					$arr['goods_id'] = $goods_id;
    					$data = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_CREATE)->data($arr)->send()->getBody();
    					$data = json_decode($data, true);
    					if ($data['status']['succeed'] == 0) {
    						ecjia_front::$controller->showmessage($data['status']['error_desc'], ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    						return false;
    					}
    				}
    			} else {
    				if (!empty($rec_id)) {
    					//从购物车中删除商品
    					$arr['rec_id'] = $rec_id;
    					ecjia_touch_manager::make()->api(ecjia_touch_api::CART_DELETE)->data($arr)->run();
    				}
    			}
    		}
    	}
    	
    	$token = 'cb753377df06afef1c779e3808381105522a023b';
    	$paramater = array(
    		'token' 	=> $token,
    		'seller_id' => $store_id,
    		'location' 	=> array('longitude' => '121.416359', 'latitude' => '31.235371')
    	);
    	
		//店铺购物车商品
    	$cart_list = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($paramater)->run();
    	$cart_goods_list = $cart_list['cart_list'][0]['goods_list'];
    	$cart_count = $cart_list['cart_list'][0]['total'];
    	 
    	$sayList = '';
    	if ($_POST['checked'] === '') {
    		ecjia_front::$controller->assign('list', $cart_goods_list);
    		$sayList = ecjia_front::$controller->fetch('store_goods.dwt');
    	}
    	ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('say_list' => $sayList, 'list' => $cart_goods_list, 'count' => $cart_count));
    }
}

// end
