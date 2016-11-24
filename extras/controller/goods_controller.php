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

    /**
     *商品详情页
     */
    public static function goods_index() {
    //    // $db_goods_model  = RC_Loader::load_app_model('goods_model');
    //     // $db_collect_goods = RC_Loader::load_app_model ( "collect_goods_model" );
    //     RC_Loader::load_theme('extras/model/goods/goods_model.class.php');
    //     RC_Loader::load_theme('extras/model/goods/goods_cart_model.class.php');
    //     RC_Loader::load_theme('extras/model/goods/goods_collect_goods_model.class.php');
    //     $db_cart            = new goods_cart_model();
    //     $db_goods_model     = new goods_model();
    //     $db_collect_goods   = new goods_collect_goods_model();
    //     $goods_id = isset($_GET ['id']) ? intval($_GET ['id']) : 0;
    //     $res = $db_goods_model->where(array('is_delete'=>0,'is_on_sale'=>1,'goods_id'=>$goods_id))->count('*');
    //     if (empty($res)) {
    //         ecjia_front::$controller->showmessage('该商品不存在，请选择其他商品进行浏览', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON,array('pjaxurl'=>RC_Uri::url('touch/index/init')));
    //     }
    //     /*获得商品的信息*/
    //     $goods = get_goods_info($goods_id);
    //     if ($goods ['brand_id'] > 0) {
    //         $goods ['goods_brand_url'] = RC_Uri::url('goods/category/goods_list', array('brand' => $goods ['brand_id']));
    //     }
    //     $shop_price = $goods ['shop_price'];
    //     $linked_goods = get_related_goods($goods_id);
    //     $goods ['goods_style_name'] = add_style($goods ['goods_name'], $goods ['goods_name_style']);
    //     /*购买该商品可以得到多少钱的红包*/
    //     if ($goods ['bonus_type_id'] > 0) {
    //         /*买商品获得红包的流程*/
    //         $time = RC_Time::gmtime();
    //         $where = array(
    //             'type_id'			=> $goods[bonus_type_id],
    //             'send_type'			=> SEND_BY_GOODS,
    //             'send_start_date'	=> array('elt'=>$time),
    //             'send_end_date'		=> array('gt'=>$time)
    //         );
    //         // $db_bonus_type = RC_Loader::load_app_model ('bonus_type_model');
    //         // RC_Loader::load_theme('extras/model/goods/goods_bonus_type_model.class.php');
    //         // $db_bonus_type  = new goods_bonus_type_model();
    //         // $count = $db_bonus_type->field('type_money')->where($where)->get_field();
    //         $goods ['bonus_money'] = floatval($count);
    //         if ($goods ['bonus_money'] > 0) {
    //             $goods ['bonus_money'] = price_format($goods ['bonus_money']);
    //         }
    //     }
    //     $comments = get_comment_info($goods_id,0);
    //     /*获得商品的规格和属性*/
    //     $properties = get_goods_properties($goods_id);
    //     /*获取关联礼包*/
    //     $package_goods_list = get_package_goods_list($goods ['goods_id']);
    //     /*取得商品优惠价格列表*/
    //     $volume_price_list = get_volume_price_list($goods ['goods_id'], '1');
    //     ecjia_front::$controller->assign('goods',				$goods);
    //     ecjia_front::$controller->assign('comments',			$comments);
    //     ecjia_front::$controller->assign('goods_id',			$goods ['goods_id']);
    //     ecjia_front::$controller->assign('promote_end_time',	$goods ['gmt_end_time']);
    //     ecjia_front::$controller->assign('properties',			$properties ['pro']);/*商品属性*/
    //     ecjia_front::$controller->assign('specification',		$properties ['spe']);/*商品规格*/
    //     ecjia_front::$controller->assign('attribute_linked',	get_same_attribute_goods($properties));/*相同属性的关联商品*/
    //     ecjia_front::$controller->assign('related_goods',		$linked_goods);/*关联商品*/
    //     ecjia_front::$controller->assign('goods_article_list',	get_linked_articles($goods_id));/*关联文章*/
    //     ecjia_front::$controller->assign('fittings',			get_goods_fittings(array($goods_id)));/*配件*/
    //     ecjia_front::$controller->assign('rank_prices',		get_user_rank_prices($goods_id, $shop_price));/*会员等级价格*/
    //     ecjia_front::$controller->assign('pictures',			get_goods_gallery($goods_id));/*商品相册*/
    //     ecjia_front::$controller->assign('package_goods_list',	$package_goods_list);
    //     ecjia_front::$controller->assign('volume_price_list',	$volume_price_list);/*商品优惠价格区间*/
    //     /*检查是否已经存在于用户的收藏夹*/
    //     if ($_SESSION ['user_id']) {
    //         $where = array(
    //             'user_id'	=> $_SESSION ['user_id'],
    //             'goods_id'	=> $goods_id
    //         );
    //         $rs = $db_collect_goods->where($where)->count();
    //         if ($rs > 0) {
    //             ecjia_front::$controller->assign('sc', 1);
    //         }
    //     }
    //     /* 记录浏览历史 */
    //     if (!empty($_COOKIE ['ECS'] ['history'])) {
    //         $history = explode(',', $_COOKIE ['ECS'] ['history']);
    //         array_unshift($history, $goods_id);
    //         $history = array_unique($history);
    //         while (count($history) > ecjia::config('history_number')) {
    //             array_pop($history);
    //         }
    //         setcookie('ECS[history]', implode(',', $history), RC_Time::gmtime() + 3600 * 24 * 30);
    //     } else {
    //         setcookie('ECS[history]', $goods_id, RC_Time::gmtime() + 3600 * 24 * 30);
    //     }
    //     /*更新点击次数*/
    //     update_goods_click($_REQUEST['id']);
    //     /*当前系统时间*/
    //     $comment = assign_comment($_REQUEST['id']);
    //     $where = array(
    //         'session_id'    => SESS_ID,
    //         'rec_type'      => CART_GENERAL_GOODS
    //     );
    //     $cart_num = $db_cart->field('SUM(goods_number) | count')->where($where)->find();
    //     ecjia_front::$controller->assign('cart_num',        intval($cart_num['count']));
    //     ecjia_front::$controller->assign('comment_list',	$comment['comments']);
    //     ecjia_front::$controller->assign('now_time',		RC_Time::gmtime());
    //     ecjia_front::$controller->assign('sales_count',		get_goods_count($goods_id));
    //     ecjia_front::$controller->assign('image_width',		ecjia::config('image_width'));
    //     ecjia_front::$controller->assign('image_height',	ecjia::config('image_height'));
    //     ecjia_front::$controller->assign('id',				$goods_id);
    //     ecjia_front::$controller->assign('type',			0);
    //     ecjia_front::$controller->assign('cfg',				ecjia::config());
    //     ecjia_front::$controller->assign('title',			RC_Lang::lang('goods_detail'));
    //     ecjia_front::$controller->assign('promotion',		get_promotion_info($goods ['goods_id']));
    //     ecjia_front::$controller->assign_title($goods['goods_name']);
    //     ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('goods.dwt');
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
        
        $arr = array(
        	'action_type' 	=> $type,	
 			'pagination' 	=> array('count' => $limit, 'page' => $page),
			'location' 		=> array('longitude' => '121.416359', 'latitude' => '31.235371')
        );
        
        $cache_key = 'goods_list'.$type;
        $data = RC_Cache::app_cache_get($cache_key, 'goods');
        if (!$data) {
        	$data = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_SUGGESTLIST)->data($arr)->run();
        	RC_Cache::app_cache_set($cache_key, $data, 'goods', 60*24);//24小时缓存
        }
        
        if (!empty($data)) {
        	foreach ($data as $k => $v) {
        		$data[$k]['promote_end_date'] = RC_Time::local_strtotime($v['promote_end_date']);
        	}
        }
        ecjia_front::$controller->assign('goods_list', $data);
        ecjia_front::$controller->assign_lang();
    	if ($type == 'promotion') {
    		$sayList = ecjia_front::$controller->fetch('goods_promotion.dwt');
    	} elseif ($type == 'new') {
    		$sayList = ecjia_front::$controller->fetch('goods_new.dwt');
    	}
//     	if ($page == 3) $goods_list['is_last'] = 1;
    	ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList, 'page', 'is_last' => $data['is_last']));
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
    	$cid = intval($_GET['cid']);
    	$keywords = !empty($_POST['keywords']) ? trim($_POST['keywords']) : (!empty($_GET['keywords']) ? trim($_GET['keywords']) : '');
    	
    	$arr = array(
    		'pagination' 	=> array('count' => 10, 'page' => 1),
    		'location' 		=> array('longitude' => '121.416359', 'latitude' => '31.235371')
    	);
    	
    	if (!empty($keywords)) {
    		$arr['keywords'] = $keywords;
    		$data = ecjia_touch_manager::make()->api(ecjia_touch_api::SELLER_LIST)->data($arr)->run();
    		ecjia_front::$controller->assign('keywords', $keywords);
    	} else {
    		$arr['category_id'] = $cid;
    		$cache_key = 'goods_seller_list'.$cid;
    		$data = RC_Cache::app_cache_get($cache_key, 'goods');
    		if (!$data) {
    			$data = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_SELLER_LIST)->data($arr)->run();
    			RC_Cache::app_cache_set($cache_key, $data, 'goods', 60*24);//24小时缓存
    		}
    	}
		
    	ecjia_front::$controller->assign('data', $data);
//     	ecjia_front::$controller->assign('shop_logo', RC_Uri::admin_url('statics/images/nopic.png'));
    	ecjia_front::$controller->assign('title', '分类店铺');
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
    	
    	$data = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_HOME_DATA)->data($arr)->run();
    	ecjia_front::$controller->assign('data', $data);
    	ecjia_front::$controller->assign('title', '店铺详情');
    	ecjia_front::$controller->display('store_detail.dwt');
    }
    /**
     * 店铺商品
     */
    public static function store_goods() {
    	$store_id 		= intval($_GET['store_id']);
    	$category_id 	= intval($_GET['category_id']);
    	
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
    	
    	if ($action_type == 'best') {
    		$type_name = '精选';
    	} elseif ($action_type == 'hot') {
    		$type_name = '热销';
    	} elseif ($action_type == 'new') {
    		$type_name = '新品';
    	}
    	
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
    			'pagination' 	=> array('count' => 10, 'page' => 1),
    			'seller_id'		=> $store_id
    		);
    		$cache_key = 'suggest_goods_'.$store_id;
    		$suggest_goods = RC_Cache::app_cache_get($cache_key, 'goods');
    		if (!$suggest_goods) {
    			$suggest_goods = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_SUGGESTLIST)->data($parameter)->run();
    			RC_Cache::app_cache_set($cache_key, $suggest_goods, 'goods', 60*24);//24小时缓存
    		}
    		if (!array_key_exists('data', $suggest_goods)) {
    			$goods_num = count($suggest_goods);
    			ecjia_front::$controller->assign('suggest_goods', $suggest_goods);
    			ecjia_front::$controller->assign('suggest_count', count($suggest_goods));
    		}
    	} else {
    		//店铺分类商品
    		$arr = array(
    			'filter' 		=> array('category_id' => $category_id),
    			'pagination' 	=> array('count' => 10, 'page' => 1),
    			'seller_id'		=> $store_id
    		);
    		 
    		$cache_key = 'merchant_goods_list'.$store_id;
    		$merchant_goods_list = RC_Cache::app_cache_get($cache_key, 'goods');
    		if (!$merchant_goods_list) {
    			$merchant_goods_list = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_LIST)->data($arr)->run();
    			RC_Cache::app_cache_set($cache_key, $merchant_goods_list, 'goods', 60*24);//24小时缓存
    		}
    		if (empty($category_id)) {
    			$type_name = '全部';
    		}
    		$goods_num = count($merchant_goods_list);
    		ecjia_front::$controller->assign('goods_list', $merchant_goods_list);
    	}

    	ecjia_front::$controller->assign('type_name', $type_name);
    	ecjia_front::$controller->assign('store_id', $store_id);
    	ecjia_front::$controller->assign('category_id', $category_id);
    	ecjia_front::$controller->assign('goods_num', $goods_num);
    	
    	ecjia_front::$controller->display('store_goods.dwt');
    }
}

// end
