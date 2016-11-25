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
        // $user_id = $_SESSION['user_id'];
        // RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
        // $db_users = new touch_users_model();
        // RC_Loader::load_theme('extras/functions/user/front_account.func.php');
        // /*用户等级*/
        // $rank = get_rank_info();
        //
        // $base   = goods_list('new', 10);
        // ecjia_front::$controller->assign('new_goods', $base['list']);
        //
        // ecjia_front::$controller->assign('rank_name', $rank['rank_name']);
        // ecjia_front::$controller->assign('order_num', get_order_num());
        // ecjia_front::$controller->assign('user_notice', ecjia::config('user_notice'));
        // ecjia_front::$controller->assign('title', RC_Lang::lang('user_center'));
        // ecjia_front::$controller->assign_title(RC_Lang::lang('user_center'));
        $user_img = get_user_img();
        // $surplus_amount = get_user_surplus($user_id);
        // $user = $db_users->where(array('user_id'=>$user_id))->find();
        // unset($user['question']);
        // unset($user['answer']);
        // /* 格式化帐户余额 */
        // if ($user) {
        //     $user['formated_user_money'] = price_format($user['user_money'], false);
        //     $user['formated_frozen_money'] = price_format($user['frozen_money'], false);
        // }
        // ecjia_front::$controller->assign('integral',intval($user['pay_points']));
        // ecjia_front::$controller->assign('surplus_amount', intval($surplus_amount));
        ecjia_front::$controller->assign('user_img', $user_img);
        ecjia_front::$controller->assign('active', 5);
        
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user.dwt');
    }

    /**
     * 登录
     */
    public static function login() {
        $captcha = intval(ecjia::config('captcha'));
        if (($captcha & CAPTCHA_LOGIN) && (!($captcha & CAPTCHA_LOGIN_FAIL) || (($captcha & CAPTCHA_LOGIN_FAIL) && $_SESSION['login_fail'] > 2))) {
            ecjia_front::$controller->assign('enabled_captcha', 1);
            ecjia_front::$controller->assign('rand', mt_rand());
        }
        $user_img = get_user_img();
        ecjia_front::$controller->assign('user_img', $user_img);
        ecjia_front::$controller->assign('step', isset($_GET['step']) ? htmlspecialchars($_GET['step']) : '');
        ecjia_front::$controller->assign('anonymous_buy', ecjia::config('anonymous_buy'));
        ecjia_front::$controller->assign('title', RC_Lang::lang('login'));
        ecjia_front::$controller->assign_title(RC_Lang::lang('login'));
        ecjia_front::$controller->assign('header_right' , array('info' => '注册', 'href' => RC_Uri::url('user/index/register')));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_login.dwt');
    }

    /**
     * 验证登录
     */
    public static function signin() {
        // RC_Loader::load_app_class('integrate', 'user', false);
        RC_Loader::load_theme('extras/class/user/integrate.class.php');
    	$user = integrate::init_users();
        // $db_users = RC_Loader::load_app_model ( "users_model" );
        RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
        $db_users  = new touch_users_model();
        /*登录处理*/
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        /* 检查验证码 */
        $captcha = intval(ecjia::config('captcha'));
        if (($captcha & CAPTCHA_LOGIN) && (!($captcha & CAPTCHA_LOGIN_FAIL) || (($captcha & CAPTCHA_LOGIN_FAIL) && $_SESSION['login_fail'] > 2))) {
            if (empty($_POST['captcha'])) {
                ecjia_front::$controller->showmessage(RC_Lang::lang('invalid_captcha'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($_SESSION['captcha_word'] !== strtolower($_POST['captcha'])) {
                ecjia_front::$controller->showmessage(RC_Lang::lang('invalid_captcha'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        /*用户名是邮箱格式*/
        if (is_email($username)) {
            $username_try = $db_users->where(array('email'=>$username))->get_field('user_name');
            $username = $username_try ? $username_try : $username;
        }
        /*用户名是手机格式*/
        if (is_mobile($username)) {
            $username_try = $db_users->where(array('mobile_phone'=>$username))->get_field('user_name');
            $username = $username_try ? $username_try : $username;
        }
        if ($user->login($username, $password,1)) {
            update_user_info();
            recalculate_price();
            $referer = empty($_POST['referer']) ? RC_Uri::url('user/index/init') : urldecode($_POST['referer']);
            ecjia_front::$controller->showmessage(RC_Lang::lang('login_success'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('is_show' => false, 'pjaxurl'=>$referer));
        } else {
            $_SESSION['login_fail']++;
            if ($_SESSION['login_fail'] == 3) {
                ecjia_front::$controller->showmessage(RC_Lang::lang('login_failure'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl'=>RC_Uri::url('user/index/login')));
            }
            ecjia_front::$controller->showmessage(RC_Lang::lang('login_failure'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('is_show' => true));
        }
    }

    /**
     * 显示注册页面
     */
    public static function register() {
        /*验证码相关设置*/
        // if (intval(ecjia::config('captcha')) > 0) {
        //     ecjia_front::$controller->assign('enabled_captcha', 1);
        //     ecjia_front::$controller->assign('rand', mt_rand());
        // }
        // /*短信开启*/
        // if (intval(ecjia::config('sms_signin')) > 0) {
        //     ecjia_front::$controller->assign('enabled_sms_signin', ecjia::config('sms_signin'));
        //     $_SESSION['sms_code'] = $sms_code = md5(mt_rand(1000, 9999));
        //     ecjia_front::$controller->assign('sms_code', $sms_code);
        // }
        // ecjia_front::$controller->assign('title', RC_Lang::lang('register'));
        // ecjia_front::$controller->assign('back_act', isset(ecjia_front::$controller->back_act) ? ecjia_front::$controller->back_act : '');
        // ecjia_front::$controller->assign_title(RC_Lang::lang('register'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_register.dwt');
    }

    public static function set_password() {
        // $user = integrate::init_users();
        //
        // ecjia_front::$controller->assign('title', RC_Lang::lang('set_password'));
        // ecjia_front::$controller->assign_title(RC_Lang::lang('set_password'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_set_password.dwt');
    }

    /* 第三方登陆 */
    public static function bind_signin() {
        // $user = integrate::init_users();
        //
        // $user_img = get_user_img();
        // ecjia_front::$controller->assign('user_img', $user_img);
        // ecjia_front::$controller->assign('title', RC_Lang::lang('bind_signin'));
        // ecjia_front::$controller->assign_title(RC_Lang::lang('bind_signin'));
        $user_img = get_user_img();
        ecjia_front::$controller->assign('user_img', $user_img);
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_bind_signin.dwt');
    }

    /* 第三方登陆快速注册 */
    public static function bind_signup() {
        // $user = integrate::init_users();
        //
        // ecjia_front::$controller->assign('title', "注册绑定");
        // ecjia_front::$controller->assign_title("注册绑定");
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

    public static function reset_password() {
    /*验证码相关设置*/
        // $captcha = intval(ecjia::config('captcha'));
        //
        // ecjia_front::$controller->assign('title', RC_Lang::lang('reset_new_password'));
        // ecjia_front::$controller->assign_title(RC_Lang::lang('reset_new_password'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_reset_password.dwt');
    }

    public static function mobile_register() {
        /*验证码相关设置*/
        // $captcha = intval(ecjia::config('captcha'));
        //
        // ecjia_front::$controller->assign('title', RC_Lang::lang('reset_new_password'));
        // ecjia_front::$controller->assign_title(RC_Lang::lang('reset_new_password'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_mobile_register.dwt');
    }

    /**
     * 验证注册
     */
    public static function signup() {
//     	$user = integrate::init_users();
// 	    $username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
// 	    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
// 	    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
//         $enabled_sms = isset($_POST['enabled_sms'])? intval($_POST['enabled_sms']) : 0;
// 	    $other = array();
//         $captcha = intval(ecjia::config('captcha'));
//         RC_Loader::load_theme('extras/functions/user/front_order.func.php');
//         // TODO: 短信注册 $enabled_sms
//         if(empty($enabled_sms)){
//             if (($captcha & CAPTCHA_REGISTER)) {
//                 if (empty($_POST['captcha'])) {
//                     ecjia_front::$controller->showmessage(RC_Lang::lang('invalid_captcha'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
//                 }
//                 if ($_SESSION['captcha_word'] !== strtolower($_POST['captcha'])) {
//                     ecjia_front::$controller->showmessage(RC_Lang::lang('invalid_captcha'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
//                 }
//             }
//         }
//         $result = register($username, $password, $email, $other);
//         if (!empty($result) && !is_ecjia_error($result)) {
//             /*判断是否需要自动发送注册邮件*/
//             if (ecjia::config('member_email_validate') && ecjia::config('send_verify_email')) {
//                 send_regiter_hash($_SESSION['user_id']);
//             }
//             $ucdata = empty($user->ucdata) ? "" : $user->ucdata;
//             ecjia_front::$controller->showmessage(sprintf(RC_Lang::lang('register_success'), $username . $ucdata),ecjia::MSGSTAT_SUCCESS| ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('user/index/init'),'is_show' => false));
// //     } else {
// //             $errmsg = is_ecjia_error($result) ?  $result->get_error_message() : '';
// //             ecjia_front::$controller->showmessage($errmsg, ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
//        }
    }

    /**
     * 邮件验证
     */
    public static function validate_email() {
        // $db_users = RC_Loader::load_app_model ( "users_model" );
        // RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
        // $db_users  = new touch_users_model();
        // $hash = htmlspecialchars($_GET['hash']);
        // if ($hash) {
        //     $id = register_hash('decode', $hash);
        //     if ($id > 0) {
        //         $db_users->where('user_id = ' . $id)->update(array('is_validated'=>1));
        //         $row = $db_users->field('user_name, email')->where(array('user_id' => $id))->find();
        //         ecjia_front::$controller->showmessage(sprintf(RC_Lang::lang('validate_ok'), $row['user_name'], $row['email'] ), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('is_show' => false));
        //     }
        // }
        // ecjia_front::$controller->showmessage(RC_Lang::lang('validate_fail'),ecjia::MSGSTAT_SUCCESS| ecjia::MSGTYPE_JSON);
    }

    /**
     * 邮件找回密码
     */
    public static function get_password_email() {
    	// $user = integrate::init_users();
        // if (isset($_GET['code']) && isset($_GET['uid'])) {
        //     $code = htmlspecialchars($_GET['code']);
        //     $uid = intval($_GET['uid']);
        //     /*判断链接的合法性*/
        //     $user_info = $user->get_profile_by_id($uid);
        //     if (empty($user_info) || ($user_info && md5($user_info['user_id'] . ecjia::config('hash_code') . $user_info['reg_time']) != $code)) {
        //         ecjia_front::$controller->showmessage(RC_Lang::lang('parm_error'),ecjia::MSGSTAT_ERROR | MSGTYPE_JSON);
        //     }
        //     ecjia_front::$controller->assign('uid', $uid);
        //     ecjia_front::$controller->assign('code', $code);
        //     ecjia_front::$controller->assign('title', RC_Lang::lang('reset_password'));
            ecjia_front::$controller->assign_lang();
        //     ecjia_front::$controller->display('user_reset_password.dwt');
        // } else {
        //     /*验证码相关设置*/
        //     $captcha = intval(ecjia::config('captcha'));
        //     /*短信开启*/
        //     if (intval(ecjia::config('sms_signin')) > 0) {
        //         ecjia_front::$controller->assign('enabled_sms_signin', ecjia::config('sms_signin'));
        //     }
        //     ecjia_front::$controller->assign('title', RC_Lang::lang('get_password'));
        //     ecjia_front::$controller->assign_title(RC_Lang::lang('get_password'));
            ecjia_front::$controller->assign_lang();
            ecjia_front::$controller->display('user_get_password.dwt');
        // }
    }

    /**
     * 发送密码修改确认邮件
     */
    public static function send_pwd_email() {
    	// $user = integrate::init_users();
        // /*初始化会员用户名和邮件地址*/
        // $user_name = !empty($_POST['user_name']) ? htmlspecialchars($_POST['user_name']) : '';
        // $email = !empty($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
        // /*用户信息*/
        // $user_info = $user->get_user_info($user_name);
        // if ($user_info && $user_info['email'] == $email) {
        //     /*生成code*/
        //     $code = md5($user_info['user_id'] . ecjia::config('hash_code') . $user_info['reg_time']);
        //     /*发送邮件的函数*/
        //     if (send_pwd_email($user_info['user_id'], $user_name, $email, $code)) {
        //         ecjia_front::$controller->showmessage(RC_Lang::lang('send_success'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON);
        //     } else {
        //         /*发送邮件出错*/
        //         ecjia_front::$controller->showmessage(RC_Lang::lang('fail_send_password'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        //     }
        // } else {
        //     /*用户名与邮件地址不匹配*/
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('username_no_email'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // }
    }

    /**
     * 更新密码
     */
    public static function update_password() {
    	// $user                   = integrate::init_users();
        // // $db_users               = RC_Loader::load_app_model ( "users_model" );
        // RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
        // $db_users  = new touch_users_model();
        // /*修改密码处理*/
        // $user_id                = isset($_POST['uid']) ? intval($_POST['uid']) : $_SESSION['user_id'];
        // $old_password           = isset($_POST['old_password']) ? htmlspecialchars($_POST['old_password']) : null;
        // $new_password           = isset($_POST['new_password']) ? htmlspecialchars($_POST['new_password']) : '';
        // $comfirm_password       = isset($_POST['comfirm_password']) ? htmlspecialchars($_POST['comfirm_password']) : '';
        // $code                   = isset($_POST['code']) ? htmlspecialchars($_POST['code']) : ''; // 邮件code
        // $mobile                 = isset($_POST['mobile']) ? base64_decode(htmlspecialchars($_POST['mobile'])) : ''; // 手机号
        // $question               = isset($_POST['question']) ? base64_decode(htmlspecialchars($_POST['question'])) : ''; // 问题
        // if (RC_String::str_len($new_password) < 6) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('passport_js/password_shorter'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // }
	    // if($new_password != $comfirm_password){
		//     ecjia_front::$controller->showmessage('两次输入密码不一致，请重新输入', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    // }
        // $user_info = $user->get_profile_by_id($user_id); // 论坛记录
        // /*短信找回，邮件找回，问题找回，登录修改密码*/
        // if ((!empty($mobile) && $user_info['mobile'] == $mobile) ||
        //     ($user_info && (!empty($code) && md5($user_info['user_id'] . ecjia::config('hash_code') . $user_info['reg_time']) == $code)) ||
        //     (!empty($question) && $user_info['passwd_question'] == $question) ||
        //     ($_SESSION['user_id'] > 0 && $_SESSION['user_id'] == $user_id && $user->check_user($_SESSION['user_name'], $old_password))
        // ) {
        //     if ($user->edit_user(array(
        //         'username' => ((empty($code) && empty($mobile) && empty($question)) ? $_SESSION['user_name'] : $user_info['user_name']),
        //         'old_password' => $old_password,
        //         'password' => $new_password
        //     ), empty($code) ? 0 : 1)) {
        //         $data['ec_salt'] = 0;
        //         $where['user_id'] = $user_id;
        //         $db_users->where($where)->update($data);
        //         $user->logout();
        //         ecjia_front::$controller->showmessage(RC_Lang::lang('edit_password_success'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl'=>RC_Uri::url('user/index/init')));
        //     } else {
        //         ecjia_front::$controller->showmessage(RC_Lang::lang('edit_password_failure'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        //     }
        // } else {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('edit_password_failure'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // }
    }

    /**
     * 退出
     */
    public static function logout() {
    	$user = integrate::init_users();
        $back_act = RC_Uri::url('user/index/login');
        $user->logout();
        $ucdata = empty($user->ucdata) ? "" : $user->ucdata;
        ecjia_front::$controller->showmessage(RC_Lang::lang('logout') . $ucdata,ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => $back_act,'is_show' => false));
    }

    /**
     * 历史记录
     */
    public static function history() {
        // /*浏览记录*/
        // $history = insert_history();
        // ecjia_front::$controller->assign('history', $history);
        // ecjia_front::$controller->assign('title', RC_Lang::lang('view_history'));
        // ecjia_front::$controller->assign_title(RC_Lang::lang('view_history'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_history.dwt');
    }

    /**
     * 清空浏览历史
     */
    public static function clear_history() {
        // setcookie('ECS[history]', '', 1);
        // ecjia_front::$controller->showmessage('成功清除浏览历史', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl'=>RC_Uri::url('user/index/history'),'is_show' => false));
    }

    /**
     * 发送验证码
     */
    public static function send_captcha() {
//         $code = rand(100000, 999999);
//         $value = $_POST['phone_number'];
//         RC_Loader::load_app_class('integrate', 'user', false);
//         $user = integrate::init_users();
//         if($user->check_user($value)) {
//             ecjia_front::$controller->showmessage('此手机号已经注册，请直接登陆!',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
//         }
//         //发送短信
//         $tpl_name = 'sms_register_validate';
//         RC_loader::load_theme('extras/model/user/user_mail_templates_model.class.php');
//         $db = new user_mail_templates_model();
//         $tpl = $db->field('template_id, template_subject, is_html, template_content')->find(array('template_code' => $tpl_name));
//         ecjia_front::$controller->assign('code', $code);
//         ecjia_front::$controller->assign('mobile', $value);
//         ecjia_front::$controller->assign('shopname', ecjia::config('shop_name'));
//         ecjia_front::$controller->assign('service_phone', ecjia::config('service_phone'));
//         $time = RC_Time::gmtime();
//         ecjia_front::$controller->assign('time', RC_Time::local_date(ecjia::config('date_format'), $time));
//         $content = ecjia_front::$controller->fetch_string($tpl['template_content']);
//         $options = array(
//             'mobile'        => $value,
//             'msg'           => $content,
//             'template_id'   => $tpl['template_id'],
//         );
//         $response = RC_Api::api('sms', 'sms_send', $options);
//         if ($response === true) {
//             $_SESSION['bind_code'] = $code;
//             $_SESSION['bindcode_lifetime'] = RC_Time::gmtime();
//             $_SESSION['bind_value'] = $value;
// //            $_SESSION['bind_type'] = $type;
//             ecjia_front::$controller->showmessage('success',ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON,array('is_show' => false));
//         } else {
//             ecjia_front::$controller->showmessage('短信发送失败',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
//         }
    }
    /*
     * 验证手机验证码
     */
    public static function phone_register(){
        // RC_Loader::load_app_class('integrate', 'user', false);
        // $user = integrate::init_users();
        // $value = $_POST['mobile'];
        // $code = $_POST['mobile_code'];
        // if($user->check_user($value)) {
        //     ecjia_front::$controller->showmessage('此手机号已经注册，请直接登陆!',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        // } else {
        //     //判断值是否为空
        //     if ( empty($value) || empty($code)) {
        //         ecjia_front::$controller->showmessage('请输入信息',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        //     }
        //     //判断校验码是否过期
        //     if ($_SESSION['bindcode_lifetime'] + 180 < RC_Time::gmtime()) {
        //         ecjia_front::$controller->showmessage('验证码已过期，请重新获取！',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        //     }
        //     //判断校验码是否正确
        //     if ($code != $_SESSION['bind_code'] ) {
        //         ecjia_front::$controller->showmessage('验证码错误，请重新填写！',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        //     }
        //     //校验其他信息
        //     if ($value != $_SESSION['bind_value']) {
        //         ecjia_front::$controller->showmessage('信息错误，请重新获取验证码!',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        //     }
        // }
        // ecjia_front::$controller->assign('mobile',$value);
        // ecjia_front::$controller->assign('title','手机快速注册');
        // ecjia_front::$controller->assign_title('手机快速注册');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_mobile_register.dwt');

    }


}

// end
