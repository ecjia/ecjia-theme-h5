<?php
/**
 * 会员登录模块控制器代码
 */
RC_Loader::load_app_class('integrate', 'user', false);
class user_controller {
    /**
     * 会员中心欢迎页
     */
    public static function init() {
        
        //网店信息
        $user_img = RC_Theme::get_template_directory_uri().'/images/user_center/icon-login-in2x.png';
        $shop = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_INFO)->run();
        $token = ecjia_touch_user::singleton()->getToken();
        $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->data(array('token' => $token))->run();
        RC_Logger::getlogger('debug')->info('init-user');
        RC_Logger::getlogger('debug')->info($user);

        if (!empty($user['avatar_img'])) {
            $user_img = $user['avatar_img'];
        }
        ecjia_front::$controller->assign('user', $user);
        ecjia_front::$controller->assign('user_img', $user_img);
        ecjia_front::$controller->assign('shop', $shop);
        ecjia_front::$controller->assign('active', 'mine');
        
        ecjia_front::$controller->assign_title('个人中心');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user.dwt');
    }
    
    /**
     * 推广页面
     */
    public static function spread() {
    	$name = $_GET['name'];
    	$token = ecjia_touch_user::singleton()->getToken();
    	$invite_user_detail = ecjia_touch_manager::make()->api(ecjia_touch_api::INVITE_USER)->data(array('token' => $token))->run();
		
		if (!empty($invite_user_detail['invite_explain'])) {
			if (strpos($invite_user_detail['invite_explain'], '；')) {
				$invite_user_detail['invite_explain_new'] = explode('；', $invite_user_detail['invite_explain']);
			}
		}
		if (!empty($invite_user_detail['invite_explain_new'])) {
			foreach ($invite_user_detail['invite_explain_new'] as $key => $val) {
				if (empty($val)) {
					unset($invite_user_detail[$key]);
				}
			}
		}
		ecjia_front::$controller->assign('share_title', $name.'推荐这个使用的App给你~');
		ecjia_front::$controller->assign_title('我的推广');
    	ecjia_front::$controller->assign('invite_user', $invite_user_detail);
    	ecjia_front::$controller->assign('url', RC_Uri::url('user/index/wxconfig'));
    	ecjia_front::$controller->display('spread.dwt');
    }
	
    public static function wxconfig() {
    	$url = $_POST['url'];
    	RC_Loader::load_app_class('platform_account', 'platform', false);
    	RC_Loader::load_app_class('wechat_method', 'wechat', false);
    	 
    	$uuid = platform_account::getCurrentUUID('wechat');
    	$wechat = wechat_method::wechat_instance($uuid);
    	
    	$config = $wechat->wxconfig($url);
    	$config['image'] = ecjia::config('mobile_app_icon') != '' ? RC_Upload::upload_url(ecjia::config('mobile_app_icon')) : '';
    	
    	return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('data' => $config));
    }
}

// end