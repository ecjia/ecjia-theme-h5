<?php
/**
 * 会员登录模块控制器代码
 */
class user_get_password_controller {
    public static function mobile_register() {
        /*验证码相关设置*/
        $mobile = !empty($_POST['mobile']) ? $_POST['mobile'] : '';
        $code = !empty($_POST['code']) ? $_POST['code'] : '';
        $token = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
        $_SESSION['mobile'] = $mobile;
        if (!empty($code)) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::VALIDATE_FORGET_PASSWORD)->data(array('token' => $token['access_token'], 'type' => 'mobile', 'value' => $mobile, 'code' => $code))->send()->getBody();
            $data = json_decode($data,true);
            if ($data['status']['succeed'] == 1) {
                return ecjia_front::$controller->showmessage(__(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/get_password/reset_password')));
            } else {
                return ecjia_front::$controller->showmessage(__($data['status']['error_desc']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('user/get_password/mobile_register')));
            }
        }
        ecjia_front::$controller->assign('title', '找回密码');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->assign_title('找回密码');
        ecjia_front::$controller->display('user_mobile_register.dwt');
    }

    public static function mobile_register_account() {
        $mobile = !empty($_GET['mobile']) ? $_GET['mobile'] : '';
        $chars = "/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/";
        if (preg_match($chars, $mobile)) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_FORGET_PASSWORD)->data(array('token' => $token['access_token'], 'type' => 'mobile', 'value' => $mobile))->send()->getBody();
            $data = json_decode($data,true);
            if ($data['status']['succeed'] == 0){
                return ecjia_front::$controller->showmessage(__($data['status']['error_desc']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } elseif ($data['status']['succeed'] == 1){
                return ecjia_front::$controller->showmessage(__("短信已发送到手机".$mobile."，请注意查看"), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
            }
        } else {
            return ecjia_front::$controller->showmessage(__('手机号码格式错误'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
    
    public static function reset_password() {
        /*验证码相关设置*/
        $passwordf = !empty($_POST['passwordf']) ? $_POST['passwordf'] : '';
        $passwords = !empty($_POST['passwords']) ? $_POST['passwords'] : '';
        $mobile    = !empty($_SESSION['mobile']) ? $_SESSION['mobile'] : '';
        if ($passwordf != $passwords) {
            return ecjia_front::$controller->showmessage(__('两次密码输入不一致'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        $token = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
        if ($passwordf) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_RESET_PASSWORD)->data(array('token' => $token['access_token'], 'type' => 'mobile', 'value' => $mobile, 'password' => $passwordf))->send()->getBody();
            $data = json_decode($data,true);
            if ($data['status']['succeed'] == 1) {
               return ecjia_front::$controller->showmessage(__('您已成功找回密码'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/privilege/login')));
            } else {
               return ecjia_front::$controller->showmessage(__($data['status']['error_desc']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
        }
        ecjia_front::$controller->assign('title', '设置新密码');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->assign_title('设置新密码');
        ecjia_front::$controller->display('user_reset_password.dwt');
    }
    

}
// end
