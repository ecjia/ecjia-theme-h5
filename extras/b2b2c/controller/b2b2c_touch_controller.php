<?php

class b2b2c_touch_controller {
	/**
	 * 首页信息
	 */
	public static function init() {
		/* 自定义导航栏 */
		RC_Loader::load_theme('extras/b2b2c/functions/merchant/b2b2c_front_merchant.func.php');
		RC_Loader::load_theme('extras/b2b2c/functions/touch/b2b2c_front_touch.func.php');
		$navigator = get_touch_nav();
		ecjia_front::$controller->assign('navigator', $navigator['touch']);
		// ecjia_front::$controller->assign('best_goods', goods_list('best', ecjia::config('page_size')));
		// ecjia_front::$controller->assign('new_goods', goods_list('new', ecjia::config('page_size')));
		// ecjia_front::$controller->assign('hot_goods', goods_list('hot', ecjia::config('page_size')));
        $base   = goods_list('best', 4, 1);
        $new    = goods_list('new', ecjia::config('page_size'), 1);
        $hot    = goods_list('hot', ecjia::config('page_size'), 1);
        ecjia_front::$controller->assign('best_goods', $base['list']);
        ecjia_front::$controller->assign('new_goods', $new['list']);
        ecjia_front::$controller->assign('hot_goods', $hot['list']);
		$cat_rec = get_recommend_res();/* 首页推荐分类商品 */
		$province_id = RC_Cookie::get('province_id');
		$city_id = RC_Cookie::get('city_id');
		if(empty($province_id) || empty($city_id)){
			$ip = get_client_ip();
			$area = get_ip_area_name($ip);
			$province = get_area_id($area,1);
			$city = get_area_id($area,2);
			RC_Cookie::set('province', $province['name']);
			RC_Cookie::set('province_id', $province['id']);
			RC_Cookie::set('city', $city['name']);
			RC_Cookie::set('city_id', $city['id']);
		}
		RC_Loader::load_theme('extras/b2b2c/model/touch/touch_seller_shopwindow_model.class.php');

		$db_seller_window = new touch_seller_shopwindow_model();
		$where = array(
			'win_type' => 0,
			'ru_id' => 0,
			'is_show' => 1,
		);
		$custom = $db_seller_window->field('win_custom')->where($where)->order('win_order ASC')->select();
		ecjia_front::$controller->assign('copyright', ecjia::config('wap_copyright'));
		ecjia_front::$controller->assign('custom' ,$custom );
		ecjia_front::$controller->assign('cat_best', $cat_rec[1]);
		ecjia_front::$controller->assign('cat_new', $cat_rec[2]);
		ecjia_front::$controller->assign('cat_hot', $cat_rec[3]);
		ecjia_front::$controller->assign('area_name', $area);
		ecjia_front::$controller->assign('searchs', insert_search());
		ecjia_front::$controller->assign('shop_app_icon', ecjia::config('shop_app_icon') ? get_image_path('', ecjia::config('shop_app_icon')) : RC_Uri::admin_url('statics/images/nopic.png'));
		ecjia_front::$controller->assign('brand_list', get_brands(0, $app = 'goods_list'));
		ecjia_front::$controller->assign('logo_url', get_image_path('', ecjia::config('wap_logo')));
		ecjia_front::$controller->assign('cycleimage', get_cycleimage());
		ecjia_front::$controller->assign('page_header', 'index');
        ecjia_front::$controller->assign('searchs', insert_search());
		ecjia_front::$controller->assign('shop_pc_url', ecjia::config('shop_pc_url'));
        ecjia_front::$controller->assign('copyright', ecjia::config('wap_copyright'));
		ecjia_front::$controller->assign_title();

		ecjia_front::$controller->assign_lang();
		ecjia_front::$controller->display('index.dwt');
	}

	/**
	* 选择地区
	*/
	public function region_list() {

		RC_Loader::load_theme('extras/b2b2c/model/touch/touch_region_model.class.php');
		$db_region = new touch_region_model();
		$area_list = $db_region->where(array('region_type' => 2))->select();

		ecjia_front::$controller->assign('city',RC_Cookie::get('city'));
		ecjia_front::$controller->assign('area',$area_list);
		ecjia_front::$controller->assign_title('选择所在地区');
		ecjia_front::$controller->assign('title', '选择所在地区');
        ecjia_front::$controller->assign('header_left', array('href' => RC_Uri::url('touch/index/init')));
		ecjia_front::$controller->display('region_list.dwt');

	}

	/*
	* 设置地区
	*/
	public function set_area(){
		RC_Loader::load_theme('extras/b2b2c/functions/merchant/b2b2c_front_merchant.func.php');
		$province = intval($_GET['province_id']);
		$city = intval($_GET['city_id']);
		$province = get_area($province);
		$city = get_area($city);
		RC_Cookie::set('province', $province['name']);
		RC_Cookie::set('province_id', $province['id']);
		RC_Cookie::set('city', $city['name']);
		RC_Cookie::set('city_id', $city['id']);
        ecjia_front::$controller->showmessage('选择所在地区成功！', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('touch/index/init')));
    }
}
