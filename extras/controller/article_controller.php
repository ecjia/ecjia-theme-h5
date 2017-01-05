<?php
/**
 * 文章模块控制器代码
 */
class article_controller {
    /**
     *  帮助中心页
     */
    public static function init() {
    	$data = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_HELP)->run();
    	
    	ecjia_front::$controller->assign('data', $data);
    	ecjia_front::$controller->assign_title('帮助中心');
    	ecjia_front::$controller->assign('title', '帮助中心');
    	ecjia_front::$controller->assign('hideinfo', '1');
    	ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('article_init.dwt');
    }
    /**
     * 文章列表
     */
    public static function art_list() {
        ecjia_front::$controller->display('article_list.dwt');
    }
    /**
     * 文章列表异步加载
     */
    public static function asynclist() {
    }
    /**
     * 文章详情
     *
     */
    public static function detail() {
        // /* 文章详情 */
        $article_id = intval($_GET['aid']);
        
        $title = trim($_GET['title']);
        ecjia_front::$controller->assign('title', $title);
    	$data = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_HELP_DETAIL)->data(array('article_id' => $article_id))->run();
    	
    	ecjia_front::$controller->assign_title($title);
    	ecjia_front::$controller->assign('data', $data);
    	ecjia_front::$controller->assign('hideinfo', '1');
        ecjia_front::$controller->display('article_detail.dwt');
    }
    /**
     * 网店信息内容
     */
    public static function shop_detail() {
        $title = trim($_GET['title']);
        $article_id = intval($_GET['article_id']);
        $shop_detail = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_INFO_DETAIL)->data(array('article_id' => $article_id))->run();
        $shop = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_INFO)->run();
        
       
        ecjia_front::$controller->assign('title', $title);
        ecjia_front::$controller->assign('data', $shop_detail);
        ecjia_front::$controller->assign('hideinfo', 1);
        ecjia_front::$controller->assign_title($title);
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('article_shop_detail.dwt');
    }
}

// end