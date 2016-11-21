<?php
/**
 * Touch主控制器
 */
class touch_controller {

    /**
     * 首页信息
     */
    public static function init() {
        /* 自定义导航栏 */
        $navigator = get_touch_nav();
        $cat_rec = get_recommend_res();/* 首页推荐分类商品 */
        ecjia_front::$controller->assign('navigator', $navigator['touch']);
        $base   = goods_list('best', 4);
        $new    = goods_list('new', 6);
        $hot    = goods_list('hot', ecjia::config('page_size'));
        $promotion = goods_list('promotion', 6);

        ecjia_front::$controller->assign('more_sales', RC_Uri::url('goods/index/promotion'));
        ecjia_front::$controller->assign('more_news', RC_Uri::url('goods/index/new'));
        ecjia_front::$controller->assign('theme_url', RC_Theme::get_template_directory_uri() . '/');
        
        $arr = array(
        	'location' => array('longitude' => '121.416359', 'latitude' => '31.235371')
        );
        
        //首页广告
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::HOME_DATA)->data($arr)->run();
        if (!empty($data['adsense_group'])) {
        	foreach ($data['adsense_group'] as $k => $v) {
        		$data['adsense_group'][$k]['count'] = count($v['adsense']);
        	}
        }
        ecjia_front::$controller->assign('adsense_group', $data['adsense_group']);
        
        //首页促销商品
        if (!empty($data['promote_goods'])) {
        	foreach ($data['promote_goods'] as $k => $v) {
        		$data['promote_goods'][$k]['promote_end_date'] = RC_Time::local_strtotime($v['promote_end_date']);
        	}
        }
        ecjia_front::$controller->assign('promotion_goods', $data['promote_goods']);
        
        //新品推荐
        ecjia_front::$controller->assign('new_goods', $data['new_goods']);
        
        //热门推荐
        ecjia_front::$controller->assign('best_goods', $base['list']);
        
        ecjia_front::$controller->assign('hot_goods', $hot['list']);
        ecjia_front::$controller->assign('cat_best', $cat_rec[1]);
        ecjia_front::$controller->assign('cat_new', $cat_rec[2]);
        ecjia_front::$controller->assign('cat_hot', $cat_rec[3]);
        ecjia_front::$controller->assign('brand_list', get_brands(0, $app = 'goods_list'));
        ecjia_front::$controller->assign('logo_url', get_image_path('', ecjia::config('wap_logo')));
        
        ecjia_front::$controller->assign('cycleimage', $data['player']);
        ecjia_front::$controller->assign('page_header', 'index');
        ecjia_front::$controller->assign('searchs', insert_search());
        ecjia_front::$controller->assign('shop_pc_url', ecjia::config('shop_pc_url'));
        ecjia_front::$controller->assign('copyright', ecjia::config('wap_copyright'));
        ecjia_front::$controller->assign_title();
        ecjia_front::$controller->assign_lang();

        ecjia_front::$controller->display('index.dwt');
    }

    /**
     * ajax获取商品
     */
    public static function ajax_goods() {
//         $type = htmlspecialchars($_GET['type']);
//         $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
//         $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
//         $goods_list = goods_list($type, $limit, $page);
//         ecjia_front::$controller->assign('goods_list', $goods_list['list']);
//         ecjia_front::$controller->assign_lang();
//         $sayList = ecjia_front::$controller->fetch('index.dwt');
// //         if ($page == 3) $goods_list['is_last'] = 1;
//         ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page' , 'is_last' => $goods_list['is_last']));
    }

    /**
     * 搜索
     */
    public static function search() {
        // $search_keywords = explode(',', ecjia::config('search_keywords'));
        // shuffle($search_keywords);
        // ecjia_front::$controller->assign('tags', array_slice($search_keywords, 0, 12));
        // ecjia_front::$controller->assign('searchs', insert_search());
        // ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('search.dwt');
    }

    /**
     * 清除搜索
     */
    public static function del_search() {
        // setcookie('ECJia[search]', '', 1);
        // ecjia_front::$controller->showmessage('成功清除搜索历史记录', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('touch/index/search'), 'is_show' => false));
    }

    public static function download() {
        // ecjia_front::$controller->assign('page_title', ecjia::config('shop_name') . ' - 手机APP下载');
        // ecjia_front::$controller->assign('theme_url', RC_Theme::get_template_directory_uri() . '/');
        //
        // ecjia_front::$controller->assign('shop_url', RC_Uri::url('touch/index/init'));
        // ecjia_front::$controller->assign('shop_app_icon', ecjia::config('shop_app_icon') ? get_image_path('', ecjia::config('shop_app_icon')) : RC_Uri::admin_url('statics/images/nopic.png'));
        // ecjia_front::$controller->assign('shop_app_description', ecjia::config('shop_app_description') ? ecjia::config('shop_app_description') : '暂无手机应用描述');
        // ecjia_front::$controller->assign('shop_android_download', ecjia::config('shop_android_download'));
        // ecjia_front::$controller->assign('shop_iphone_download', ecjia::config('shop_iphone_download'));
        // ecjia_front::$controller->assign('shop_ipad_download', ecjia::config('shop_ipad_download'));
        // ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('download.dwt');

    }
}

// end
