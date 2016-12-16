<?php
/**
 * 会员登录模块控制器代码
 */
class user_privilege_controller {
    
    /**
     * 登录
     */
    public static function login() {
        $captcha = intval(ecjia::config('captcha'));
        if (($captcha & CAPTCHA_LOGIN) && (!($captcha & CAPTCHA_LOGIN_FAIL) || (($captcha & CAPTCHA_LOGIN_FAIL) && $_SESSION['login_fail'] > 2))) {
            ecjia_front::$controller->assign('enabled_captcha', 1);
            ecjia_front::$controller->assign('rand', mt_rand());
        }
        $user_img = RC_Theme::get_template_directory_uri().'/images/user_center/icon-login-in2x.png';
        
        ecjia_front::$controller->assign('user_img', $user_img);
        ecjia_front::$controller->assign('step', isset($_GET['step']) ? htmlspecialchars($_GET['step']) : '');
        ecjia_front::$controller->assign('anonymous_buy', ecjia::config('anonymous_buy'));
        ecjia_front::$controller->assign('header_right', array('info' => '注册', 'href' => RC_Uri::url('user/privilege/register')));
        
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->assign('title', RC_Lang::lang('login'));
        ecjia_front::$controller->assign_title(RC_Lang::lang('login'));
        
        ecjia_front::$controller->display('user_login.dwt');
    }
    
    /**
     * 退出
     */
    public static function logout() {
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_SIGNOUT)->run();
        $data = json_decode($data,true);
        $back_act = RC_Uri::url('user/privilege/login');
        return ecjia_front::$controller->showmessage('',ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => $back_act));
    }
    
    /**
     * 验证登录
     */
    public static function signin() {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $data = ecjia_touch_user::singleton()->signin($username, $password);
        $user = ecjia_touch_user::singleton()->getUserinfo();
        if (is_ecjia_error($data)) {
            $message = $data->get_error_message();
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('info' => $message));
        } else {
        	$referer = !empty($_POST['referer']) ? urldecode($_POST['referer']) : '';
        	if (!empty($referer)) {
        		return ecjia_front::$controller->showmessage(__(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $referer));
        	}
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('touch/my/init')));
        }
    }
    
    /**
     * 显示注册页面
     */
    public static function register() {
        ecjia_front::$controller->assign('title', '手机快速注册');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->assign_title('注册');
        ecjia_front::$controller->display('user_register.dwt');
    }
    
    /**
     * 验证注册
     */
    public static function signup() {
        $chars = "/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/";
        $mobile = !empty($_GET['mobile']) ? htmlspecialchars($_GET['mobile']) : '';
        if (preg_match($chars, $mobile)) {
            $_SESSION['mobile'] = $mobile;
            $token = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_USERBIND)->data(array('token' => $token['access_token'], 'type' => 'mobile', 'value' => $mobile))->send()->getBody();
            $data = json_decode($data,true);
            if ($data['data']['registered'] == 1) {
                return ecjia_front::$controller->showmessage(__('该手机号已被注册，请更换其他手机号'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('user/privilege/register')));
            } else {
                return ecjia_front::$controller->showmessage(__('短信已发送到手机'.$mobile.'，请注意查看'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
            }
        } else {
            return ecjia_front::$controller->showmessage(__('手机号码格式错误'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        
    }
    
    /* 第三方登陆 */
    public static function bind_signin() {
//         $user_img = get_user_img();
//         ecjia_front::$controller->assign('user_img', $user_img);
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_bind_signin.dwt');
    }
    
    /* 第三方登陆快速注册 */
    public static function bind_signup() {
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_bind_signup.dwt');
    }
    
    /* 第三方登陆绑定 */
    public static function bind_login() {
        // $user = integrate::init_users();
        //
        // ecjia_front::$controller->assign('title', "登录绑定");
        // ecjia_front::$controller->assign_title("登录绑定");
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_bind_login.dwt');
    }
    
    /*注册用户验证码接受*/
    public static function validate_code() {
        $verification = !empty($_POST['verification']) ? trim($_POST['verification']) : '';
        if (strlen($verification) > 6) {
            return ecjia_front::$controller->showmessage(__('邀请码格式不正确'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $code = !empty($_POST['code']) ? trim($_POST['code']) : '';
        $mobile = !empty($_POST['mobile']) ? htmlspecialchars($_POST['mobile']) : '';
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::VALIDATE_BIND)->data(array('type' => 'mobile', 'value' => $mobile, 'code' => $code))->send()->getBody();
        $data = json_decode($data,true);
        if ($data['status']['succeed'] == 1) {
            return ecjia_front::$controller->showmessage(__(''), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/privilege/set_password&verification='.$verification)));
        } else {
            return ecjia_front::$controller->showmessage(__($data['status']['error_desc']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
    
    public static function set_password() {
        $verification = !empty($_GET['verification']) ? $_GET['verification'] : ''; 
        $mobile = !empty($_SESSION['mobile']) ? $_SESSION['mobile'] : '';
        $username = !empty($_POST['username']) ? $_POST['username'] : '';
        $password = is_numeric($_POST['password']) ? $_POST['password'] : '';
        if (!empty($username) && !empty($password)) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_SIGNUP)->data(array('name' => $username, 'mobile' => $mobile, 'password' => $password, 'invite_code' => $verification))->send()->getBody();
            $data = json_decode($data,true);
            if ($data['status']['succeed'] == 1) {
                return ecjia_front::$controller->showmessage(__('恭喜您，注册成功'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('login')));
            } else {
                return ecjia_front::$controller->showmessage(__($data['status']['error_desc']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
    
        } else {
            ecjia_front::$controller->assign('title', '设置密码');
            ecjia_front::$controller->assign_lang();
            ecjia_front::$controller->display('user_set_password.dwt');
        }
    }
    
}

// end
