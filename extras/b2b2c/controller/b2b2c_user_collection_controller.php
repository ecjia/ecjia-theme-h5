<?php
/**
 * 收藏模块控制器代码
 * @author royalwang
 *
 */
class b2b2c_user_collection_controller{

	/**
     * 收藏店铺
     */
    public static function shop_collection(){
        RC_Loader::load_theme('extras/b2b2c/functions/merchant/b2b2c_front_merchant.func.php');
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $merchant = get_merchant('',$size, $page, 0);
        ecjia_front::$controller->assign('merchant', $merchant['list']);
        ecjia_front::$controller->assign_title('收藏店铺');
        ecjia_front::$controller->assign('title', '收藏店铺');
        ecjia_front::$controller->assign('header_left', array('href' => RC_Uri::url('user/index/init')));
        ecjia_front::$controller->display('user_merchant.dwt');
    }
}