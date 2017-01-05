<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * ecjia 前端页面控制器父类
 */
class user_front {
    
    private $public_route;

	public function __construct() {
	    $this->makePublicRoute();
		
		if (!$this->check_login()) {
		    /*未登录处理*/
            $url = RC_Uri::site_url() . substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], '/'));
            if (isset($_GET['referer_url'])) {
            	$url = $_GET['referer_url'];
            	return ecjia_front::$controller->redirect(RC_Uri::url('user/privilege/login', array('referer_url' => urlencode($url))));
            }
            return ecjia_front::$controller->redirect(RC_Uri::url('user/privilege/login', array('referer' => urlencode($url))));
		}
	}
	
	protected function makePublicRoute() {
	    $this->public_route = array(
	        'user/privilege/login',
	        'user/privilege/signin',
	        'user/privilege/register',
	        
	        'user/privilege/bind_signin',
	        'user/privilege/bind_signin_do',
	        'user/privilege/bind_signup',
	        'user/privilege/bind_signup_do',
	        'user/privilege/bind_login',
	        
	        'user/get_password/get_password_phone',
	        'user/get_password/pwd_question_name',
	        'user/get_password/send_pwd_email',
	        'user/get_password/update_password',
	        'user/get_password/forget_pwd',
	        'user/get_password/reset_pwd_mail',
	        'user/get_password/reset_pwd_form',
	        'user/get_password/reset_pwd',
	        'user/privilege/validate_code',
	        'user/privilege/set_password',
	        'user/get_password/mobile_register',
	        'user/get_password/reset_password',
	        'user/privilege/signin',
	        'user/privilege/signup',
	        'user/get_password/mobile_register_account'
	    );
	}

	/**
	 * 未登录验证
	 */
	private function check_login() {
		/*不需要登录的操作或自己验证是否登录（如ajax处理）的方法*/
		$without = array(
// 			'login',
// 			'register',
// 			'get_password_phone',
// 			'get_password_email',
// 			'pwd_question_name',
// 			'send_pwd_email',
// 			'update_password',
			'check_answer',
			'logout',
			'add_collection',
			'third_login',
			'signin',
			'signup',
			'history',
			'clear_history',
			'get_user_info',
			'dump_user_info',
			'region',
			'send_captcha',
			'act_register',
		    'set_password',
		    'reset_password',
		    'bind_signin',
		    'bind_signup',
		    'bind_login',
		    'mobile_register',
		    'validate_code',
		    'reset_password'
		);
		
		//验证公开路由
		$route_controller = ROUTE_M . '/' . ROUTE_C . '/' . ROUTE_A;
		if (in_array($route_controller, $this->public_route)) {
		    return true;
		}
		
		//验证登录身份
		if (ecjia_touch_user::singleton()->isSignin()) {
		    return true;
		}
		
		return false;
	}
}

// end