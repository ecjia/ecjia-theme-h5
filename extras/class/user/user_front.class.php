<?php
/**
 * ecjia 前端页面控制器父类
 */
defined('IN_ECJIA') or exit('No permission resources.');

class user_front extends ecjia_front {
	protected $user_id;
	protected $action;

	public function __construct() {
		parent::__construct();
		RC_Loader::load_theme('extras/functions/user/front_user.func.php');
		/*属性赋值*/
		$this->user_id = $_SESSION['user_id'];
		$this->action = ROUTE_A;
		/*验证登录*/
		$this->check_login();
		/*用户信息*/
		$info = get_user_default($this->user_id);
		/*如果是显示页面，对页面进行相应赋值*/
		$this->assign('action', $this->action);
		$this->assign('info', $info);
	}

	/**
	* 未登录验证
	*/
	private function check_login() {
		/*不需要登录的操作或自己验证是否登录（如ajax处理）的方法*/
		$without = array(
			'login',
			'register',
			'get_password_phone',
			'get_password_email',
			'pwd_question_name',
			'send_pwd_email',
			'update_password',
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
		    'reset_password',
		    'register_signup'
		);
		/*未登录处理*/
		if (empty($_SESSION['user_id']) && !in_array($this->action, $without)) {
			$url = RC_Uri::site_url() . substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], '/'));
			$this->redirect(RC_Uri::url('user/index/login', array('referer' => urlencode($url))));
			exit();
		}
		/*已经登录，不能访问的方法*/
		$deny = array(
			'login',
            'signin',
			'register',
            'signup',
		);
		if (!empty($_SESSION['user_id']) && in_array($this->action, $deny)) {
			$this->redirect(RC_Uri::url('user/index/init'));
			exit();
		}
	}

}

// end
