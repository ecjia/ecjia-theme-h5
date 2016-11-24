<?php
/**
 * 会员编辑个人信息模块控制器代码
 */
class user_profile_controller {

    /**
     * 会员中心：编辑个人资料
     */
    public static function edit_profile() {
        // $db_reg_fields = RC_Loader::load_app_model ( "reg_fields_model" );
        // RC_Loader::load_theme('extras/model/user/user_reg_fields_model.class.php');
        // $db_reg_fields       = new user_reg_fields_model();
        // // $db_reg_extend_info = RC_Loader::load_app_model ( "reg_extend_info_model" );
        // RC_Loader::load_theme('extras/model/user/user_reg_extend_info_model.class.php');
        // $db_reg_extend_info       = new user_reg_extend_info_model();
        // $user_id = $_SESSION['user_id'];
        // /* 用户资料 */
        // $user_info = get_profile($user_id);
        // /* 取出注册扩展字段 */
        // $extend_info_list = $db_reg_fields->where(array('type'=>array('elt'=>2, 'display'=>1)))->order('dis_order, id')->select();
        // $extend_info_arr = $db_reg_extend_info->field('reg_field_id, content')->where(array('user_id' => $user_id))->select();
        // $temp_arr = array();
        // if (!empty($extend_info_arr)) {
        //     foreach ($extend_info_arr as $val) {
        //         $temp_arr[$val['reg_field_id']] = $val['content'];
        //     }
        // }
        // foreach ($extend_info_list as $key => $val) {
        //     switch ($val['id']) {
        //         case 1:
        //             unset($extend_info_list[$key]);
        //             break;
        //         case 2:
        //             $extend_info_list[$key]['content'] = $user_info['qq'];
        //             break;
        //         case 3:
        //             $extend_info_list[$key]['content'] = $user_info['office_phone'];
        //             break;
        //         case 4:
        //             unset($extend_info_list[$key]);
        //             break;
        //         case 5:
        //             $extend_info_list[$key]['content'] = $user_info['mobile_phone'];
        //             break;
        //         default:
        //             $extend_info_list[$key]['content'] = empty($temp_arr[$val['id']]) ? '' : $temp_arr[$val['id']];
        //             break;
        //     }
        // }
        $user_img = get_user_img();
        ecjia_front::$controller->assign('user_img', $user_img);
        // ecjia_front::$controller->assign('title', RC_Lang::lang('profile'));
        // ecjia_front::$controller->assign('extend_info_list', $extend_info_list);
        // ecjia_front::$controller->assign('passwd_questions', RC_Lang::lang('passwd_questions'));
        // ecjia_front::$controller->assign('profile', $user_info);
        // ecjia_front::$controller->assign_title(RC_Lang::lang('profile'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_profile.dwt');
    }
    
    /* 用户中心编辑用户名称 */
    public static function modify_username() {
        // $user = integrate::init_users();
        //
        // ecjia_front::$controller->assign('title', "用户名");
        // ecjia_front::$controller->assign_title("用户名");
        // ecjia_front::$controller->assign('header_right' , array('info' => '保存', 'href' => RC_Uri::url('user/index/edit_profile')));
        ecjia_front::$controller->assign('hideinfo', '123');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_modify_username.dwt');
    }

    /**
     * 修改个人资料
     */
    public static function update_profile() {
        // // $db_users = RC_Loader::load_app_model('users_model');
        // RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
        // $db_users       = new touch_users_model();
        // // $db_reg_fields = RC_Loader::load_app_model ( "reg_fields_model" );
        // RC_Loader::load_theme('extras/model/user/user_reg_fields_model.class.php');
        // $db_reg_fields       = new user_reg_fields_model();
        // $user_id = $_SESSION['user_id'];
        // $email = htmlspecialchars($_POST['email']);
        // $other['qq'] = $qq = htmlspecialchars($_POST['extend_field2']);
        // $other['office_phone'] = $office_phone = htmlspecialchars($_POST['extend_field3']);
        // $other['mobile_phone'] = $mobile_phone = htmlspecialchars($_POST['extend_field5']);
        // $sel_question = htmlspecialchars($_POST['sel_question']);
        // $passwd_answer = htmlspecialchars($_POST['passwd_answer']);
        // /*读出所有扩展字段的id*/
        // $where['type'] = 0;
        // $where['display'] = 1;
        // $fields_arr = $db_reg_fields->field('id')->where($where)->order('dis_order, id')->select();
        // /*循环更新扩展用户信息*/
        // if (!empty($fields_arr)) {
        //     foreach ($fields_arr as $val) {
        //         // $db_reg_extend_info = RC_Loader::load_app_model ( "reg_extend_info_model" );
        //         RC_Loader::load_theme('extras/model/user/users_reg_extend_info_model.class.php');
        //         $db_reg_extend_info       = new users_reg_extend_info_model();
        //         $extend_field_index = 'extend_field' . $val['id'];
        //         if (isset($_POST[$extend_field_index])) {
        //             $temp_field_content = RC_String::str_len($_POST[$extend_field_index]) > 100 ? mb_substr(htmlspecialchars($_POST[$extend_field_index]), 0, 99) : htmlspecialchars($_POST[$extend_field_index]);
        //             $where_s['reg_field_id'] = $val['id'];
        //             $where_s['user_id'] = $user_id;
        //             $rs_s = $db_reg_extend_info->where($where_s)->find();
        //             /*如果之前有记录则更新，没有则插入*/
        //             if ($rs_s) {
        //                 $where_u['reg_field_id'] = $val['id'];
        //                 $where_u['user_id'] = $user_id;
        //                 $data_u['content'] = $temp_field_content;
        //                 $db_reg_extend_info->where($where_u)->update($data_u);
        //             } else {
        //                 $data_i['user_id'] = $user_id;
        //                 $data_i['reg_field_id'] = $val['id'];
        //                 $data_i['content'] = $temp_field_content;
        //                 $db_reg_extend_info->insert($data_i);
        //             }
        //         }
        //     }
        // }
        // if (!empty($office_phone) && !preg_match('/^[\d|\_|\-|\s]+$/', $office_phone)) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('passport_js/office_phone_invalid'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // }
        // if (!is_email($email)) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('msg_email_format'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // }
        // if (!empty($qq) && !preg_match('/^\d+$/', $qq)) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('passport_js/qq_invalid'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // }
        // if (!empty($mobile_phone) && !preg_match('/^[\d-\s]+$/', $mobile_phone)) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('passport_js/mobile_phone_invalid'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // }
        // // $db_users = RC_Loader::load_app_model ( "users_model" );
        // RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
        //         $db_users       = new touch_users_model();
        // /*写入密码提示问题和答案*/
        // if (!empty($passwd_answer) && !empty($sel_question)) {
        //     $where_up['user_id'] 		= $user_id;
        //     $data_up['passwd_question'] = $sel_question;
        //     $data_up['passwd_answer'] 	= $passwd_answer;
        //     $db_users->where($where_up)->update($data_up);
        // }
        // $profile = array(
        //     'user_id'   => $user_id,
        //     'email'     => htmlspecialchars($_POST['email']),
        //     'sex'       => htmlspecialchars($_POST['sex'], 0),
        //     'other'     => isset($other) ? $other : array()
        // );
        // $res = edit_profile($profile);
        // if (!is_ecjia_error($res)) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('edit_profile_success'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('user/index/init'), 'is_show' => false));
        // } else {
        // 	ecjia_front::$controller->showmessage($res->get_error_message(), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // }
    }

    /**
     * 修改密码页面
     */
    public static function edit_password() {
        /*显示修改密码页面*/
        // if (!empty($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
        //     ecjia_front::$controller->assign('title', RC_Lang::lang('edit_password'));
        //     ecjia_front::$controller->assign_title(RC_Lang::lang('edit_password'));
            ecjia_front::$controller->assign_lang();
            ecjia_front::$controller->assign('hideinfo', '123');
            ecjia_front::$controller->display('user_edit_password.dwt');
        // } else {
        //     ecjia_front::$controller->redirect(RC_Uri::url('login'));
        // }
    }

}

// end
