<?php
/**
 * 客服模块控制器代码
 */
class user_package_controller {

    /**
     * 客户服务
     */
    public static function service() {
        /*页面显示*/
        // ecjia_front::$controller->assign('title', RC_Lang::lang('user_service'));
        // ecjia_front::$controller->assign_title(RC_Lang::lang('user_service'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_service.dwt');
    }

    /**
     * 添加客户服务:留言、投诉、询问、售后、求购
     */
    public static function add_server() {
        // $user_id = $_SESSION['user_id'];
        // if(empty($_POST['msg_content'])){
        //     ecjia_front::$controller->showmessage('请填写留言内容', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // }
        // $message = array(
        //     'user_id'       => $user_id,
        //     'user_name'     => $_SESSION['user_name'],
        //     'user_email'    => $_SESSION['email'],
        //     'msg_type'      => htmlspecialchars($_POST['msg_type']),
        //     'msg_title'     => htmlspecialchars($_POST['msg_title']),
        //     'msg_content'   => htmlspecialchars($_POST['msg_content']),
        //     'order_id'      => htmlspecialchars($_POST['order_id']),
        //     'upload'        => ''
        // );
        // $data['msg_id'] = add_message($message);
        // if (!empty($data['msg_id']) && $data['msg_id'] > 0) {
        //     ecjia_front::$controller->showmessage('发表成功',ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl'=>RC_Uri::url('user/user_message/msg_list'), 'is_show' => false));
        // } else {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('add_message_error'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // }
    }
}

// end
