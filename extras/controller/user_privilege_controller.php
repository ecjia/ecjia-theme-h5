<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 会员登录模块控制器代码
 */
class user_privilege_controller {
    
    /**
     * 登录
     */
    public static function login() {
    	$cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING']));
    	
        $signin = ecjia_touch_user::singleton()->isSignin();
        if ($signin) {
        	$token = ecjia_touch_user::singleton()->getToken();
	        $cache_id = $_SERVER['QUERY_STRING'].'-'.$token;
	        $cache_id = sprintf('%X', crc32($cache_id));
        	
        	if (!ecjia_front::$controller->is_cached('user_login.dwt', $cache_id)) {
        		$user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->data(array('token' => $token))->run();
        		if (!is_ecjia_error($user)) {
        			ecjia_front::$controller->redirect(RC_Uri::url('touch/index/init'));
        		} else {
        			ecjia_touch_user::singleton()->signout();
        		}
        	}
        }

        if (!ecjia_front::$controller->is_cached('user_login.dwt', $cache_id)) {
//         	$captcha = intval(ecjia::config('captcha'));
//         	if (($captcha & CAPTCHA_LOGIN) && (!($captcha & CAPTCHA_LOGIN_FAIL) || (($captcha & CAPTCHA_LOGIN_FAIL) && $_SESSION['login_fail'] > 2))) {
//         		ecjia_front::$controller->assign('enabled_captcha', 1);
//         		ecjia_front::$controller->assign('rand', mt_rand());
//         	}
        	$user_img = RC_Theme::get_template_directory_uri().'/images/user_center/icon-login-in2x.png';
        	
        	ecjia_front::$controller->assign('user_img', $user_img);
        	ecjia_front::$controller->assign('step', isset($_GET['step']) ? htmlspecialchars($_GET['step']) : '');
        	ecjia_front::$controller->assign('anonymous_buy', ecjia::config('anonymous_buy'));
//         	ecjia_front::$controller->assign('header_right', array('info' => '注册', 'href' => RC_Uri::url('user/privilege/register')));
        	ecjia_front::$controller->assign('header_right', array('info' => '密码登录', 'href' => RC_Uri::url('user/privilege/pass_login')));
        	
        	ecjia_front::$controller->assign('title', '手机登录');
        	ecjia_front::$controller->assign_title('手机登录');
        	ecjia_front::$controller->assign_lang();

            if (ecjia_plugin::is_active('sns_wechat/sns_wechat.php')) {
                ecjia_front::$controller->assign('sns_wechat', 1);
            }
            if (ecjia_plugin::is_active('sns_qq/sns_qq.php')) {
                ecjia_front::$controller->assign('sns_qq', 1);
            }
        }
        ecjia_front::$controller->display('user_login.dwt', $cache_id);
    }
    
    //密码登录
    public static function pass_login() {
    	$cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING']));
    	 
    	$signin = ecjia_touch_user::singleton()->isSignin();
    	if ($signin) {
    		$token = ecjia_touch_user::singleton()->getToken();
    		$cache_id = $_SERVER['QUERY_STRING'].'-'.$token;
    		$cache_id = sprintf('%X', crc32($cache_id));
    		 
    		if (!ecjia_front::$controller->is_cached('user_login.dwt', $cache_id)) {
    			$user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->data(array('token' => $token))->run();
    			if (!is_ecjia_error($user)) {
    				ecjia_front::$controller->redirect(RC_Uri::url('touch/index/init'));
    			} else {
    				ecjia_touch_user::singleton()->signout();
    			}
    		}
    	}
    	
    	if (!ecjia_front::$controller->is_cached('user_pass_login.dwt', $cache_id)) {
    		ecjia_front::$controller->assign('header_right', array('info' => '手机登录', 'href' => RC_Uri::url('user/privilege/login')));
    		 
    		ecjia_front::$controller->assign('title', '密码登录');
    		ecjia_front::$controller->assign_title('密码登录');
    		ecjia_front::$controller->assign_lang();
    		
    		if (ecjia_plugin::is_active('sns_wechat/sns_wechat.php')) {
    			ecjia_front::$controller->assign('sns_wechat', 1);
    		}
    		if (ecjia_plugin::is_active('sns_qq/sns_qq.php')) {
    			ecjia_front::$controller->assign('sns_qq', 1);
    		}
    	}
    	
    	ecjia_front::$controller->display('user_pass_login.dwt', $cache_id);
    }
    
    /**
     * 退出
     */
    public static function logout() {
        $status = !empty($_POST['status']) ? $_POST['status'] : '';
        if ($status == 'logout') {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_SIGNOUT)->run();
            $back_act = RC_Uri::url('user/privilege/login');
            
            ecjia_touch_user::singleton()->signout();
            RC_Cookie::delete(RC_Config::get('session.session_name'));
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('logout_url' => $back_act));
        }
    }
    
    /**
     * 验证登录
     */
    public static function signin() {
        $username = $_POST['username'] ? trim($_POST['username']) : '';
        $password = $_POST['password'] ? trim($_POST['password']) : '';
        
        $message = '';
        if (empty($username)) {
        	$message = '请输入用户名或手机号';
        } elseif (empty($password)) {
        	$message = '请输入密码';
        }
        
        $type = 'password';
        if (empty($message)) {
        	$data = ecjia_touch_user::singleton()->signin($type, $username, $password);
        	if (is_ecjia_error($data)) {
        		$message = $data->get_error_message();
        	} else {
        		$url = RC_Uri::url('touch/my/init');
        		$referer_url = !empty($_POST['referer_url']) ? urldecode($_POST['referer_url']) : '';
        		if (!empty($referer_url)) {
        			$url = $referer_url;
        		}
        		return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
        	}
        }
        return ecjia_front::$controller->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    }
    
    /**
     * 手机登录
     */
    public static function mobile_login() {
    	$mobile_phone = trim($_POST['mobile_phone']);
    	if (empty($mobile_phone)) {
    		return ecjia_front::$controller->showmessage('请输入手机号', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	$chars = "/^1(3|4|5|7|8)\d{9}$/";
    	if (!preg_match($chars, $mobile_phone)) {
    		return ecjia_front::$controller->showmessage(__('手机号码格式错误'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    	}
    	
    	return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/privilege/captcha_validate', array('mobile_phone' => $mobile_phone))));
    }
    
    //身份验证
    public static function captcha_validate() {
    	$mobile_phone = trim($_GET['mobile_phone']);
    	
    	$data	= ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
    	$token	= $data['access_token'];
    	
    	$res = ecjia_touch_manager::make()->api(ecjia_touch_api::CAPTCHA_IMAGE)->data(array('token' => $token))->run();
    	ecjia_front::$controller->assign('captcha_image', $res['base64']);
    	
    	ecjia_front::$controller->assign('token', $token);
    	ecjia_front::$controller->assign('mobile_phone', $mobile_phone);
    	
    	ecjia_front::$controller->assign('title', '身份验证');
    	ecjia_front::$controller->assign_title('身份验证');
    	ecjia_front::$controller->assign_lang();
    	
    	ecjia_front::$controller->display('user_captcha_validate.dwt');
    }
    
    //刷新验证码
    public static function captcha_refresh() {
    	$token = trim($_POST['token']);
    	
    	$res = ecjia_touch_manager::make()->api(ecjia_touch_api::CAPTCHA_IMAGE)->data(array('token' => $token))->run();
    	if (is_ecjia_error($res)) {
    		return ecjia_front::$controller->showmessage($res->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGTYPE_JSON);
    	}
    	return ecjia_front::$controller->showmessage($res['base64'], ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }
    
    //检查图形验证码
    public static function captcha_check() {
    	$token = trim($_POST['token']);
    	$mobile = trim($_POST['mobile_phone']);
    	$code_captcha = trim($_POST['code_captcha']);
    	
    	if (empty($code_captcha)) {
			return ecjia_front::$controller->showmessage('请输入验证码', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
    	$param = array(
    		'token'	=> $token,
    		'type'	=> 'mobile',
    		'value'	=> $mobile,
    		'captcha_code' => $code_captcha
    	);
    	$res = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_USERBIND)->data($param)->run();
    	
    	if (is_ecjia_error($res)) {
    		return ecjia_front::$controller->showmessage($res->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGTYPE_JSON);
    	}
    	$registered = 0;
    	if ($res['registered'] == 1) {
    		$registered = 1;
    	}
    	$invited = 0;
    	if ($res['is_invited'] == 1) {
    		$invited = 1;
    	}
    	$pjaxurl = RC_Uri::url('user/privilege/enter_code', array('mobile_phone' => $mobile, 'registered' => $registered, 'invited' => $invited));
    	return ecjia_front::$controller->showmessage('身份验证成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjaxurl));
    }
    
    //输入验证码
    public static function enter_code() {
    	$mobile = trim($_GET['mobile_phone']);
    	$registered = intval($_GET['registered']);
    	$invited = intval($_GET['invited']);
    	
    	ecjia_front::$controller->assign('title', '输入验证码');
    	ecjia_front::$controller->assign_title('输入验证码');
    	ecjia_front::$controller->assign_lang();
    	
    	ecjia_front::$controller->assign('mobile', $mobile);
    	ecjia_front::$controller->assign('type', 'smslogin');
    	ecjia_front::$controller->assign('registered', $registered);
    	ecjia_front::$controller->assign('invited', $invited);
    	
    	ecjia_front::$controller->display('user_enter_code.dwt');
    }
    
    
    //验证码验证登录
    public static function mobile_signin() {
    	$type = trim($_POST['type']);
    	$password = trim($_POST['password']);
    	$mobile = trim($_POST['mobile']);
    	$registered = intval($_POST['registered']);
    	$invited = intval($_POST['invited']);

    	//已经注册 走登录接口
    	if ($registered == 1) {
    		$data = ecjia_touch_user::singleton()->signin($type, $mobile, $password);
    		if (is_ecjia_error($data)) {
    			return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		
    		$url = RC_Uri::url('touch/my/init');
    		$referer_url = !empty($_POST['referer_url']) ? urldecode($_POST['referer_url']) : '';
    		if (!empty($referer_url)) {
    			$url = $referer_url;
    		}
    	} else {
    		$data = ecjia_touch_manager::make()->api(ecjia_touch_api::VALIDATE_BIND)->data(array('type' => 'mobile', 'value' => $mobile, 'code' => $password))->run();
    		if (is_ecjia_error($data)) {
    			return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    		}
    		
    		//未注册 走注册接口 
    		$url = RC_Uri::url('user/privilege/set_password');
    		$_SESSION['mobile'] = $mobile;
    		$_SESSION['register_status'] = 'succeed';
    	}
    	return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
    }
    
    /**
     * 显示注册页面
     */
    public static function register() {
        $mobile = !empty($_POST['mobile']) ? trim($_POST['mobile']) : '';
        if (!empty($mobile)) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::INVITE_VALIDATE)->data(array('mobile' => $mobile))->run();
            $data = is_ecjia_error($data) ? array() : $data;
            $verification = $data['invite_code'];
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS,array('verification' => $verification));
        }
        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING']));
        if (!ecjia_front::$controller->is_cached('user_register.dwt', $cache_id)) {
        	ecjia_front::$controller->assign('title', '手机快速注册');
        	ecjia_front::$controller->assign_lang();
        	ecjia_front::$controller->assign_title('注册');
        }
        ecjia_front::$controller->display('user_register.dwt', $cache_id);
    }
    
    /**
     * 验证注册
     */
    public static function signup() {
        $chars = "/^1(3|4|5|7|8)\d{9}$/";
        $mobile = !empty($_GET['mobile']) ? htmlspecialchars($_GET['mobile']) : '';
        
        if (!preg_match($chars, $mobile)) {
        	return ecjia_front::$controller->showmessage(__('手机号码格式错误'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
		$data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_USERBIND)->data(array('type' => 'mobile', 'value' => $mobile))->run();
		if (is_ecjia_error($data)) {
			return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		}
		
		if ($data['registered'] == 1) {
			return ecjia_front::$controller->showmessage(__('该手机号已被注册，请更换其他手机号'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
		} else {
			$_SESSION['mobile'] = $mobile;
			return ecjia_front::$controller->showmessage(__('短信已发送到手机'.$mobile.'，请注意查看'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}            
    }
    
    /*注册用户验证码接受*/
    public static function validate_code() {
        $verification = !empty($_POST['verification']) ? trim($_POST['verification']) : '';
        if (strlen($verification) > 6) {
            return ecjia_front::$controller->showmessage(__('邀请码格式不正确'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $_SESSION['verification'] = $verification;
        $code = !empty($_POST['code']) ? trim($_POST['code']) : '';
        $mobile = !empty($_POST['mobile']) ? htmlspecialchars($_POST['mobile']) : '';
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::VALIDATE_BIND)->data(array('type' => 'mobile', 'value' => $mobile, 'code' => $code))->run();
        
        if (!is_ecjia_error($data)) {
            $_SESSION['register_status'] = 'succeed';
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/privilege/set_password')));
        } else {
            return ecjia_front::$controller->showmessage(__($data->get_error_message()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
    
    public static function set_password() {
        if ($_SESSION['register_status'] != 'succeed') {
            ecjia_front::$controller->redirect(RC_Uri::url('user/privilege/register'));
        }
        
        $verification 	= !empty($_SESSION['verification']) ? $_SESSION['verification'] : ''; 
        $mobile 		= !empty($_SESSION['mobile']) 		? $_SESSION['mobile'] 		: '';
        $username 		= !empty($_POST['username']) 		? trim($_POST['username']) 	: '';
        $password 		= !empty($_POST['password']) 		? trim($_POST['password']) 	: '';
        
        if (!empty($username) && !empty($password)) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_SIGNUP)->data(array('name' => $username, 'mobile' => $mobile, 'password' => $password, 'invite_code' => $verification))->run();
            if (!is_ecjia_error($data)) {
                unset($_SESSION['verification']);
                ecjia_touch_user::singleton()->signin('password', $username, $password);
                
                unset($_SESSION['register_status']);
                return ecjia_front::$controller->showmessage(__('恭喜您，注册成功'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('touch/my/init')));
            } else {
                return ecjia_front::$controller->showmessage(__($data->get_error_message()), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        } else {
            $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING']));
            if (!ecjia_front::$controller->is_cached('user_set_password.dwt', $cache_id)) {
                ecjia_front::$controller->assign('title', '设置名字密码');
                ecjia_front::$controller->assign_lang();
            }
            ecjia_front::$controller->display('user_set_password.dwt', $cache_id);
        }
    }
}

// end