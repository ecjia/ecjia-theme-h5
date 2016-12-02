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
        //         $user_img = get_user_img();
        ecjia_front::$controller->assign('user_img', $user_img);
        ecjia_front::$controller->assign('step', isset($_GET['step']) ? htmlspecialchars($_GET['step']) : '');
        ecjia_front::$controller->assign('anonymous_buy', ecjia::config('anonymous_buy'));
        ecjia_front::$controller->assign('title', RC_Lang::lang('login'));
        ecjia_front::$controller->assign_title(RC_Lang::lang('login'));
        ecjia_front::$controller->assign('header_right' , array('info' => '注册', 'href' => RC_Uri::url('user/privilege/register')));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_login.dwt');
    }
    
    /**
     * 退出
     */
    public static function logout() {
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_SIGNOUT)->run();
        //     	$user = integrate::init_users();
        $back_act = RC_Uri::url('user/privilege/login');
        //         $user->logout();
        //         $ucdata = empty($user->ucdata) ? "" : $user->ucdata;
        ecjia_front::$controller->showmessage(RC_Lang::lang('logout') . $ucdata,ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => $back_act));
    }
    
    /**
     * 验证登录
     */
    public static function signin() {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $data = ecjia_touch_user::singleton()->signin($username, $password);
        $user = ecjia_touch_user::singleton()->getUserinfo();
        if ($data) {
            ecjia_front::$controller->showmessage(__(''), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/index/init')));
        } else {
            ecjia_front::$controller->showmessage(__("用户信息错误或者账号不存在"), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('user/privilege/login')));
        }
        ecjia_front::$controller->assign('hideinfo', 1);
    }
    
    /**
     * 显示注册页面
     */
    public static function register() {
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->assign('hideinfo', 1);
        ecjia_front::$controller->display('user_register.dwt');
    }
    
    /**
     * 验证注册
     */
    public static function signup() {
        $mobile = !empty($_GET['mobile']) ? htmlspecialchars($_GET['mobile']) : '';
        $_SESSION['mobile'] = $mobile;
        $token = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_USERBIND)->data(array('token' => $token['access_token'], 'type' => 'mobile', 'value' => $mobile))->send()->getBody();
        $data = json_decode($data,true);
        if ($data['data']['registered'] == 1) {
            ecjia_front::$controller->showmessage(__('手机号码已被绑定'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if ($data['status']['succeed'] == 1) {
            ecjia_front::$controller->showmessage(__('请手机验证码发送成功，请注意查收'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
        } else {
            ecjia_front::$controller->showmessage(__('手机验证码发送失败'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
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
        $code = !empty($_POST['code']) ? trim($_POST['code']) : '';
        $mobile = !empty($_POST['mobile']) ? htmlspecialchars($_POST['mobile']) : '';
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::VALIDATE_BIND)->data(array('type' => 'mobile', 'value' => $mobile, 'code' => $code))->send()->getBody();
        $data = json_decode($data,true);
        if ($data['status']['succeed'] == 1) {
            ecjia_front::$controller->showmessage(__(''), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/privilege/set_password')));
        } else {
            ecjia_front::$controller->showmessage(__($data['status']['error_desc']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
    
    public static function set_password() {
        // $user = integrate::init_users();
        //
        // ecjia_front::$controller->assign('title', RC_Lang::lang('set_password'));
        // ecjia_front::$controller->assign_title(RC_Lang::lang('set_password'));
        $mobile = !empty($_SESSION['mobile']) ? $_SESSION['mobile'] : '';
        $username = !empty($_POST['username']) ? $_POST['username'] : '';
        $password = is_numeric($_POST['password']) ? $_POST['password'] : '';
        if (!empty($username) && !empty($password)) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_SIGNUP)->data(array('name' => $username, 'mobile' => $mobile, 'password' => $password))->send()->getBody();
            $data = json_decode($data,true);
            if ($data['status']['succeed'] == 1) {
                ecjia_front::$controller->showmessage(__('注册成功'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('login')));
            } else {
                ecjia_front::$controller->showmessage(__($data['status']['error_desc']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
    
        } else {
            ecjia_front::$controller->assign_lang();
            ecjia_front::$controller->display('user_set_password.dwt');
        }
    }
    
}

// end
