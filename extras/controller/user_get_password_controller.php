<?php
/**
 * 会员登录模块控制器代码
 */
class user_get_password_controller {
    /**
     * 邮件找回密码
     */
    public static function get_password_email() {
        $token = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
        if ($_POST['mobile']) {
            $mobile = !empty($_POST['mobile']) ? $_POST['mobile'] : '';
        } else {
            $mobile = !empty($_SESSION['mobile']) ? $_SESSION['mobile'] : '';
        }
        if (!empty($mobile)) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_FORGET_PASSWORD)->data(array('token' => $token['access_token'], 'type' => 'mobile', 'value' => $mobile))->run();
            ecjia_front::$controller->showmessage(__("已发送验证码短信至：$mobile"), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl'=>RC_Uri::url('user/index/mobile_register')));
        }
        ecjia_front::$controller->assign('title', '找回密码');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_get_password.dwt');
    }
    
    public static function mobile_register() {
        /*验证码相关设置*/
        // $captcha = intval(ecjia::config('captcha'));
        //
        // ecjia_front::$controller->assign('title', RC_Lang::lang('reset_new_password'));
        // ecjia_front::$controller->assign_title(RC_Lang::lang('reset_new_password'));
        $code = !empty($_POST['code']) ? $_POST['code'] : '';
        $token = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
        $mobile = !empty($_SESSION['mobile']) ? $_SESSION['mobile'] : '';
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::VALIDATE_FORGET_PASSWORD)->data(array('token' => $token['access_token'], 'type' => 'mobile', 'value' => $mobile, 'code' => $code))->send()->getBody();
        $data = json_decode($data,true);
        if (!empty($code)) {
            if ($data['status']['succeed'] == 1) {
                ecjia_front::$controller->showmessage(__(''), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('reset_password')));
            } else {
                ecjia_front::$controller->showmessage(__($data['status']['error_desc']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('mobile_register')));
            }
        } else {
            ecjia_front::$controller->assign_lang();
            ecjia_front::$controller->display('user_mobile_register.dwt');
        }
    }
    
    public static function reset_password() {
        /*验证码相关设置*/
        // $captcha = intval(ecjia::config('captcha'));
        //
        // ecjia_front::$controller->assign('title', RC_Lang::lang('reset_new_password'));
        // ecjia_front::$controller->assign_title(RC_Lang::lang('reset_new_password'));
        $passwordf = !empty($_POST['passwordf']) ? $_POST['passwordf'] : '';
        $passwords = !empty($_POST['passwords']) ? $_POST['passwords'] : '';
        $mobile    = !empty($_SESSION['mobile']) ? $_SESSION['mobile'] : '';
        if ($passwordf != $passwords) {
            ecjia_front::$controller->showmessage(__('两次密码输入不一致'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('reset_password')));
        }
        $token = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
        if ($passwordf) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_RESET_PASSWORD)->data(array('token' => $token['access_token'], 'type' => 'mobile', 'value' => $mobile, 'password' => $passwordf))->send()->getBody();;
            $data = json_decode($data,true);
            if ($data['status']['succeed'] == 1) {
                ecjia_front::$controller->showmessage(__('您已成功找回密码'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('login')));
            } else {
                ecjia_front::$controller->showmessage(__($data['status']['error_desc']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('mobile_register')));
            }
        }
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_reset_password.dwt');
    }
    

}
// end
