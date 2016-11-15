<?php
/**
 * 商品模块控制器代码
 * @author royalwang
 *
 */
class b2b2c_goods_controller {

    /**
     * 分类产品信息列表
     */
    public static function goods_list() {
        RC_Loader::load_theme('extras/b2b2c/functions/merchant/b2b2c_front_merchant.func.php');
        $keywords = htmlspecialchars($_REQUEST['keywords']);
        $val = mysql_like_quote(trim($keywords));
        $brand = intval($_REQUEST['brand']);
        $type = $_REQUEST['type_val'];
        $length = RC_String::str_len($keywords);
        if($length > 40){
            ecjia_front::$controller->showmessage('输入的关键字过长', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
         /* 记录浏览历史 */
         $key = $keywords;
        if($type == 2){
            $key = "店铺:".$val;
        }
        if (!empty($keywords)) {
            if (!empty($_COOKIE ['ECJia'] ['search'])) {
                $history = explode(',', $_COOKIE ['ECJia'] ['search']);
                array_unshift($history, $key);
                $history = array_unique($history);
                while (count($history) > ecjia::config('history_number')) {
                    array_pop($history);
                }
                setcookie('ECJia[search]', implode(',', $history), RC_Time::gmtime() + 3600 * 24 * 30);
            }else{
                setcookie('ECJia[search]', $key, RC_Time::gmtime() + 3600 * 24 * 30);
            }
        }

        if($type == 2){
            if (empty($keywords)) {
                ecjia_front::$controller->showmessage('请输入要搜索商品的关键字', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
            }
            $shoplist = get_merchant($keywords);
            ecjia_front::$controller->assign('merchant', $shoplist['list']);
            ecjia_front::$controller->assign('header_left', array('href' => RC_Uri::url('touch/index/search')));
            ecjia_front::$controller->assign_lang();
            ecjia_front::$controller->assign('title', '店铺街');
            ecjia_front::$controller->display('merchant.dwt');
        }else{
            if (empty($_REQUEST['cid']) && empty($brand) && empty($keywords)) {
                ecjia_front::$controller->showmessage('请输入要搜索商品的关键字', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
            }
            $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
            $order = htmlspecialchars($_GET['order']);
            $sort = htmlspecialchars($_GET['sort']);
            $price_min = intval($_REQUEST['price_min']);
            $price_max = intval($_REQUEST['price_max']);
            $goodslist = goods_category::factory()->get_category_goods($page, intval($_REQUEST['cid']), $val, $brand, $price_min, $price_max, $sort, $order);

            $filter = array(
                'price_min' => $price_min,
                'price_max' => $price_max,
                'filter_attr_str' => goods_category::factory()->filter_attr_str,
                'children' => goods_category::factory()->children,
            );
            ecjia_front::$controller->assign('brand_id',        $brand);
            ecjia_front::$controller->assign('filter_attr',     goods_category::factory()->filter_attr_str);
            ecjia_front::$controller->assign('page',            $page);
            ecjia_front::$controller->assign('size',            goods_category::factory()->size);
            ecjia_front::$controller->assign('keywords',        $keywords);
            ecjia_front::$controller->assign('view',            intval($_GET['view']));
            ecjia_front::$controller->assign('price_min',       $price_min);
            ecjia_front::$controller->assign('price_max',       $price_max);
            ecjia_front::$controller->assign('brand',           $brand);
            ecjia_front::$controller->assign('sort',            $sort);
            ecjia_front::$controller->assign('order',           $order);
            ecjia_front::$controller->assign('id',              intval($_REQUEST['cid']));
            ecjia_front::$controller->assign('type',            $type);
            /* 获取价格分级 */
            ecjia_front::$controller->assign('price_grade', goods_category::factory()->get_price_range(intval($_REQUEST['cid']), $brand, $filter));
            /* 属性筛选 */
            ecjia_front::$controller->assign('filter_attr_list',    goods_category::factory()->get_attr_range());
            /* 品牌筛选 */
            ecjia_front::$controller->assign('brands',          goods_category::factory()->get_brands_range(intval($_REQUEST['cid']), $brand, $filter));
            /* 获取分类 */
            ecjia_front::$controller->assign('category',        goods_category::factory()->get_top_category());
        
            ecjia_front::$controller->assign('goods_list', $goodslist['list']);
            ecjia_front::$controller->assign('pages', $goodslist['page']);
        
            $cat = get_cat_info(goods_category::factory()->cat_id);  // 获得分类的相关信息
            if (!empty($cat['keywords'])) {
                if (!empty($cat['keywords'])) {
                    ecjia_front::$controller->assign('keywords_list', explode(' ', $cat['keywords']));
                }
            }
            ecjia_front::$controller->assign('categories', get_categories_tree(goods_category::factory()->cat_id));
            ecjia_front::$controller->assign('show_marketprice', ecjia::config('show_marketprice'));
            ecjia_front::$controller->assign('header_left', array('href' => RC_Uri::url('goods/category/top_all')));
            ecjia_front::$controller->assign_lang();
            ecjia_front::$controller->display('category.dwt');
        }
    }
    

    /**
     *商品详情页
     */
    public static function goods_index() {

        RC_Loader::load_theme('extras/b2b2c/functions/goods/b2b2c_front_goods.func.php');

        RC_Loader::load_theme("extras/b2b2c/model/goods/goods_region_warehouse_model.class.php");
        RC_Loader::load_theme("extras/b2b2c/model/goods/goods_merchants_shop_information_viewmodel.class.php");
        RC_Loader::load_theme("extras/b2b2c/model/goods/goods_seller_shopinfo_viewmodel.class.php");
        RC_Loader::load_theme('extras/b2b2c/model/goods/goods_collect_store_model.class.php');
        RC_Loader::load_theme('extras/b2b2c/model/goods/goods_comment_viewmodel.class.php');
        RC_Loader::load_theme('extras/model/goods/goods_model.class.php');
        RC_Loader::load_theme('extras/b2b2c/model/goods/goods_collect_goods_model.class.php');
        RC_Loader::load_theme('extras/b2b2c/model/goods/goods_bonus_type_model.class.php');
        RC_Loader::load_theme('extras/model/goods/goods_cart_model.class.php');

        $db_goods_view                          = new goods_comment_viewmodel();
        $db_collect_store                       = new goods_collect_store_model();
        $db_region                              = new goods_region_warehouse_model();
        $db_merchant_shop_information_viewmodel = new goods_merchants_shop_information_viewmodel();
        $db_seller_shopinfo                     = new goods_seller_shopinfo_viewmodel();
        $db_goods_model                         = new goods_model();
        $db_collect_goods                       = new goods_collect_goods_model();
        $db_bonus_type                          = new goods_bonus_type_model();
        $db_cart                                = new goods_cart_model();
        
        $goods_id = isset($_GET ['id']) ? intval($_GET ['id']) : 0;
        $res = $db_goods_model->where(array('is_delete'=>0,'is_on_sale'=>1,'goods_id'=>$goods_id))->count('*');
        if(empty($res)){
            ecjia_front::$controller->showmessage('该商品不存在，请选择其他商品进行浏览', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON,array('pjaxurl'=>RC_Uri::url('touch/index/init')));
        }
        /*获得商品的信息*/
        $goods = get_goods_msg($goods_id);
        if ($goods ['brand_id'] > 0) {
            $goods ['goods_brand_url'] = RC_Uri::url('goods/category/goods_list', array('brand' => $goods ['brand_id']));
        }
        $shop_price = $goods ['shop_price'];
        $linked_goods = get_related_goods($goods_id);
        $goods ['goods_style_name'] = add_style($goods ['goods_name'], $goods ['goods_name_style']);
        /*购买该商品可以得到多少钱的红包*/
        if ($goods ['bonus_type_id'] > 0) {
            // 买商品获得红包的流程
            $time = RC_Time::gmtime();
            $where                  = array(
                'type_id'           => $goods[bonus_type_id],
                'send_type'         => SEND_BY_GOODS,
                'send_start_date'   => array('elt'=>$time),
                'send_end_date'     => array('gt'=>$time)
            );
            $count = $db_bonus_type->field('type_money')->where($where)->get_field();
            $goods ['bonus_money'] = floatval($count);
            if ($goods ['bonus_money'] > 0) {
                $goods ['bonus_money'] = price_format($goods ['bonus_money']);
            }
        }
        /* 
         * 取得联系方式 */
        $kf = $db_seller_shopinfo->join('goods')->where(array('goods_id' => $goods_id))->get_field('kf_qq, kf_ww, kf_tel');
        foreach ($kf as $val){
            $kf_qq = $val['kf_qq'];
            $kf_ww = $val['kf_ww'];
            $kf_tel = $val['kf_tel'];
        }
        ecjia_front::$controller->assign('qq',          $kf_qq);
        ecjia_front::$controller->assign('ww',          $kf_ww);
        ecjia_front::$controller->assign('tel',         $kf_tel);
        $comments = get_comment_info($goods_id,0);
        /*获得商品的规格和属性*/
        $properties = get_goods_properties($goods_id);
        /*获取关联礼包*/
        $package_goods_list = get_package_goods_list($goods ['goods_id']);
        /*取得商品优惠价格列表*/
        $volume_price_list = get_volume_price_list($goods ['goods_id'], '1');
        /*取得仓库信息*/
        $warehouse = get_region_warehouse();
        $house = get_warehouse(RC_Cookie::get('province_id'));
        ecjia_front::$controller->assign('house', $house);
        /* 取得地区信息 */
        $province_list = get_regions(1, 1);
        $city_list = get_regions(2);
        $district_list = get_regions(3);
        // 获取商品评论
        $comment = assign_comment($_REQUEST['id']);

        ecjia_front::$controller->assign('title', RC_Lang::lang('add_address'));
        /*取得国家列表、商店所在国家、商店所在国家的省列表*/
        ecjia_front::$controller->assign('country_list', get_regions());
        ecjia_front::$controller->assign('province_list', $province_list);
        ecjia_front::$controller->assign('city_list', $city_list);
        ecjia_front::$controller->assign('district_list', $district_list);
        
        ecjia_front::$controller->assign('warehouse',           $warehouse);
        ecjia_front::$controller->assign('goods',               $goods);
        ecjia_front::$controller->assign('comments',            $comments);
        ecjia_front::$controller->assign('goods_id',            $goods ['goods_id']);
        ecjia_front::$controller->assign('promote_end_time',    $goods ['gmt_end_time']);
        ecjia_front::$controller->assign('comment_list',        $comment['comments']);
        ecjia_front::$controller->assign('properties',          $properties ['pro']);/*商品属性*/
        ecjia_front::$controller->assign('specification',       $properties ['spe']);/*商品规格*/
        ecjia_front::$controller->assign('attribute_linked',    get_same_attribute_goods($properties));/*相同属性的关联商品*/
        ecjia_front::$controller->assign('related_goods',       $linked_goods);/*关联商品*/
        ecjia_front::$controller->assign('goods_article_list',  get_linked_articles($goods_id));/*关联文章*/
        ecjia_front::$controller->assign('fittings',            get_goods_fittings(array($goods_id)));/*配件*/
        ecjia_front::$controller->assign('rank_prices',         get_user_rank_prices($goods_id, $shop_price));/*会员等级价格*/
        ecjia_front::$controller->assign('pictures',            get_goods_gallery($goods_id));/*商品相册*/
        ecjia_front::$controller->assign('package_goods_list',  $package_goods_list);
    
        ecjia_front::$controller->assign('volume_price_list',   $volume_price_list);/*商品优惠价格区间*/
        /*检查是否已经存在于用户的收藏夹*/
        if ($_SESSION ['user_id']) {
            $where = array(
                'user_id'   => $_SESSION ['user_id'],
                'goods_id'  => $goods_id
            );
            $rs = $db_collect_goods->where($where)->count();
            if ($rs > 0) {
                ecjia_front::$controller->assign('sc', 1);
            }
        }
        /* 记录浏览历史 */
        if (!empty($_COOKIE ['ECS'] ['history'])) {
            $history = explode(',', $_COOKIE ['ECS'] ['history']);
            array_unshift($history, $goods_id);
            $history = array_unique($history);
            while (count($history) > ecjia::config('history_number')) {
                array_pop($history);
            }
            setcookie('ECS[history]', implode(',', $history), RC_Time::gmtime() + 3600 * 24 * 30);
        } else {
            setcookie('ECS[history]', $goods_id, RC_Time::gmtime() + 3600 * 24 * 30);
        }
        /*更新点击次数*/
        update_goods_click($_REQUEST['id']);
        /* 页面标题 */
        // $page_info = get_page_title($goods['cat_id'], $goods['goods_name']);
        /*当前系统时间*/
        ecjia_front::$controller->assign('now_time',        RC_Time::gmtime());
        ecjia_front::$controller->assign('sales_count', get_goods_count($goods_id));
        ecjia_front::$controller->assign('image_width', ecjia::config('image_width'));
        ecjia_front::$controller->assign('image_height',    ecjia::config('image_height'));
        ecjia_front::$controller->assign('id',              $goods_id);
        ecjia_front::$controller->assign('type',            0);
        ecjia_front::$controller->assign('cfg',         ecjia::config());
        /*促销信息*/
        /* 获取商品所在店铺的信息 START */
        $ru_id = $db_goods_model->where(array('goods_id' => $goods_id))->get_field('user_id');
        if($ru_id > 0){
            $seller_where = array();
            $seller_where['ssi.status'] = 1;
            $seller_where['msi.merchants_audit'] = 1;
            $seller_where['msi.user_id'] = $ru_id;
            
            $field ='msi.user_id,ssi.*, CONCAT(shoprz_brandName,shopNameSuffix) as seller_name, c.cat_name, ssi.shop_logo, count(cs.ru_id) as follower';
            $info = $db_merchant_shop_information_viewmodel->join(array('category', 'seller_shopinfo', 'collect_store'))->field($field)->where($seller_where)->find();

            if(substr($info['shop_logo'], 0, 1) == '.') {
                $info['shop_logo'] = str_replace('../', '/', $info['shop_logo']);
            }
            $goods_count = $db_goods_model->where(array('user_id' => $ru_id, 'is_on_sale' => 1, 'is_alone_sale' => 1, 'is_delete' => 0))->count();
            
            $follower_count = $db_collect_store->where(array('ru_id' => $ru_id))->count();
            
            $field = 'count(*) as count, SUM(IF(comment_rank>3,1,0)) as comment_rank, SUM(IF(comment_server>3,1,0)) as comment_server, SUM(IF(comment_delivery>3,1,0)) as comment_delivery';
            $comment = $db_goods_view->join(array('goods'))->field($field)->where(array('g.user_id' => $goods['user_id'], 'parent_id' => 0, 'status' => 1))->find();

            $data['merchant_info'] = array(
                'id'                => $info['user_id'],
                'seller_name'       => $info['seller_name'],
                'seller_logo'       => !empty($info['shop_logo']) ? RC_Upload::upload_url().'/'.$info['shop_logo'] : '',
                'goods_count'       => $goods_count,
                'follower'          => $follower_count,
                'kf_qq'             => $info['kf_qq'],
                'comment'           => array(
                        'comment_goods'     => $comment['count']>0 ? round($comment['comment_rank']/$comment['count']*100).'%' : '100%',
                        'comment_server'    => $comment['count']>0 ? round($comment['comment_server']/$comment['count']*100).'%' : '100%',
                        'comment_delivery'  => $comment['count']>0 ? round($comment['comment_delivery']/$comment['count']*100).'%' : '100%',
                )
            );
            ecjia_front::$controller->assign('shop', $data['merchant_info']);
        }else{
            $service = $db_seller_shopinfo->join(null)->where(array('ru_id' => 0))->get_field('shop_name');
            ecjia_front::$controller->assign('service', $service);
        }
        /* 获取商品所在店铺的信息 END */
        $where = array(
            'session_id'    => SESS_ID,
            'rec_type'      => CART_GENERAL_GOODS
        );
        $cart_num = $db_cart->field('SUM(goods_number) | count')->where($where)->find();
        ecjia_front::$controller->assign('cart_num',        intval($cart_num['count']));
        ecjia_front::$controller->assign('city_id',         RC_Cookie::get('city_id'));
        ecjia_front::$controller->assign('province_id',     RC_Cookie::get('province_id'));
        ecjia_front::$controller->assign('title',           RC_Lang::lang('goods_detail'));
        ecjia_front::$controller->assign('promotion',       get_promotion_info($goods ['goods_id']));
        // ecjia_front::$controller->assign('ur_here',         $page_info['ur_here']);
        // ecjia_front::$controller->assign('page_title',      $page_info['title']);
        ecjia_front::$controller->assign_title($goods['goods_name']);
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('goods.dwt');
    }

	 /**
     * 地区筛选
     */
    public static function region() {
        RC_Loader::load_theme('extras/b2b2c/functions/goods/b2b2c_front_goods.func.php');
        $type = intval($_GET['type']) ? intval($_GET['type']) : 0;
        $parent = intval($_GET['parent']) ? intval($_GET['parent']) : 0;
        $check = intval($_GET['checked']) ? intval($_GET['checked']) : 0;
        
        $arr['regions'] = get_regions($type, $parent);
        $arr['type'] = $type;
        $arr['target'] = htmlspecialchars(trim(stripslashes($_GET['target'])));
        $arr['check'] = $check;
        ecjia_front::$controller->showmessage('地区参数', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $arr);
    }

     /**
     * 根据商品模式获取商品价格和数量 
     */
    function goods_modal(){
        RC_Loader::load_theme('extras/b2b2c/functions/goods/b2b2c_front_goods.func.php');
        $id         = intval($_GET['id']) ? intval($_GET['id']) : 0;
        $housename  = intval($_GET['house']) ? intval($_GET ['house']) : 0;
        $region_id  = intval($_GET['region_id']) ? intval($_GET ['region_id']) : 0;
        $goods['goods'] = get_goods($id, $housename, $region_id );
        ecjia_front::$controller->showmessage('地区参数', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $goods);;
    }
    
}

// end 