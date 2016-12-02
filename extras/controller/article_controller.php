<?php
/**
 * 文章模块控制器代码
 */
class article_controller {
    /**
     *  帮助中心页
     */
    public static function init() {
        // $cat_id = intval($_GET['id']);
        // ecjia_front::$controller->assign('article_categories', article_categories_tree($cat_id)); //文章分类树
    	$data = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_HELP)->run();
    	ecjia_front::$controller->assign('data', $data);
    	ecjia_front::$controller->assign('title', '帮助中心');
    	ecjia_front::$controller->assign('hideinfo', '1');
    	ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('article_init.dwt');
    }
    /**
     * 文章列表
     */
    public static function art_list() {
        // $size          = intval($_GET['size']) > 0 ? intval($_GET['size']) : (intval(ecjia::config('article_page_size')) > 0 ? intval(ecjia::config('article_page_size')) : 10);
        // $page          = intval($_GET['page'])     ? intval($_GET['page']) : 1;
        // $cat_id        = intval($_GET['id']);
        // $keywords      = htmlspecialchars($_REQUEST['keywords']);
        // $artciles_list = get_cat_articles($cat_id, $page, $size, $keywords);
        // ecjia_front::$controller->assign('keywords'     , $keywords);
        // ecjia_front::$controller->assign('id'           , $cat_id);
        // ecjia_front::$controller->assign('page'         , $page);
        // ecjia_front::$controller->assign('size'         , $size);
        // ecjia_front::$controller->assign('artciles_list', $artciles_list['list']);
        // ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('article_list.dwt');
    }
    /**
     * 文章列表异步加载
     */
    public static function asynclist() {
        // $size          = intval($_GET['size']) > 0 ? intval($_GET['size']) : (intval(ecjia::config('article_page_size')) > 0 ? intval(ecjia::config('article_page_size')) : 10);
        // $page          = intval($_GET['page']) ? intval($_GET['page']) : 1;
        // $cat_id        = intval($_GET['id']);
        // $keywords      = htmlspecialchars($_REQUEST['keywords']);
        // $artciles_list = get_cat_articles($cat_id, $page, $size, $keywords);
        // ecjia_front::$controller->assign('artciles_list', $artciles_list['list']);
        // $sayList = ecjia_front::$controller->fetch('article_list.dwt');
        // ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page' , 'is_last' => $artciles_list['is_last']));
    }
    /**
     * 文章详情
     *
     */
    public static function info() {
        // /* 文章详情 */
        $article_id = intval($_GET['aid']);
        $title = trim($_GET['title']);
        // $article = get_article_info($article_id);
        // ecjia_front::$controller->assign('article', $article);
        ecjia_front::$controller->assign('title', $title);
        // ecjia_front::$controller->assign_lang();
        
    	$data = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_HELP_DETAIL)->data(array('article_id' => $article_id))->run();
    	ecjia_front::$controller->assign('data', $data);

    	ecjia_front::$controller->assign('hideinfo', '1');
        ecjia_front::$controller->display('article_info.dwt');
    }
}
// end
