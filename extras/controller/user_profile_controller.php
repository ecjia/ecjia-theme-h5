<?php
/**
 * 会员编辑个人信息模块控制器代码
 */
class user_profile_controller {

    /**
     * 会员中心：编辑个人资料
     */
    public static function edit_profile() {
        $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
        $user_img_login = RC_Theme::get_template_directory_uri().'/images/user_center/icon-login-in2x.png';
        $user_img_logout = RC_Theme::get_template_directory_uri().'/images/user_center/icon-login-out2x.png';
        if (!empty($user)) {
            if (!empty($user['avatar_img'])) {
                $user_img_login = $user['avatar_img'];
            }
            ecjia_front::$controller->assign('user_img', $user_img_login);
        } else {
            ecjia_front::$controller->assign('user_img', $user_img_logout);
        }
        ecjia_front::$controller->assign('user', $user);
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->assign_title('个人资料');
        ecjia_front::$controller->display('user_profile.dwt');
    }
    
    /* 用户中心编辑用户名称 */
    public static function modify_username() {
        $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
        $time = RC_Time::gmtime();
        $last_time = $user['update_username_time'];
        $limit_time = mktime($last_time) + 2592000;
        if (!empty($last_time) || $limit_time  > $time) {
            ecjia_front::$controller->assign('limit_time', $limit_time);
        }
        $update_username_time = substr($user['update_username_time'],0,10);
        ecjia_front::$controller->assign('update_username_time', $update_username_time);
        ecjia_front::$controller->assign('user', $user);
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->assign_title('修改用户名');
        ecjia_front::$controller->display('user_modify_username.dwt');
    }

    /* 处理用户中心编辑用户名称 */
    public static function modify_username_account() {
        $name = !empty($_POST['username']) ? $_POST['username'] :'';
        if (strlen($name) > 20 || strlen($name) < 4) {
              return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('msg' => '修改失败，请输入4-20个字符'));
        }
        if (!empty($name)) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_UPDATE)->data(array('user_name' => $name))->send()->getBody();
            $data = json_decode($data,true);
            if ($data['status']['succeed'] == 1) {
                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('msg' => RC_Uri::url('user/user_profile/edit_profile')));
            } else {
                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('msg' => $data['status']['error_desc']));
            }
        }
    }
    
    
    /**
     * 修改密码页面
     */
    public static function edit_password() {
            $old_password = !empty($_POST['old_password']) ? $_POST['old_password'] : '';
            $new_password = !empty($_POST['new_password']) ? $_POST['new_password'] : '';
            $comfirm_password = !empty($_POST['comfirm_password']) ? $_POST['comfirm_password'] : '';
            
            if (!empty($old_password)) {
                if ($new_password == $comfirm_password) {
                    $token = ecjia_touch_user::singleton()->getToken();
                    $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_PASSWORD)->data(array('token' => $token, 'password' => $old_password, 'new_password' => $new_password))->send()->getBody();
                    $data = json_decode($data,true);
                if ($data['status']['succeed'] == 1) {
                    return ecjia_front::$controller->showmessage(__('修改密码成功'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/privilege/login')));
                } else {
                    return ecjia_front::$controller->showmessage(__($data['status']['error_desc']), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('user/user_profile/edit_password')));
                }
                    
                } else {
                    return ecjia_front::$controller->showmessage(__('两次输入的密码不同，请重新输入'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('user/user_profile/edit_password')));
                }
            }
            ecjia_front::$controller->assign_title('修改密码');
            ecjia_front::$controller->assign_lang();
            ecjia_front::$controller->display('user_edit_password.dwt');
        // } else {
        //     ecjia_front::$controller->redirect(RC_Uri::url('login'));
        // }
    }

}

// end
