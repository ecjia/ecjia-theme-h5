<?php
/**
 * 信息模块控制器代码
 */
class user_message_controller {

    /**
     * 信息中心
     */
    public static function msg_list() {
        // $user_id = $_SESSION['user_id'];
        // // $db_feedback = RC_Loader::load_app_model ( "feedback_model" );
        // RC_Loader::load_theme('extras/model/user/user_feedback_model.class.php');
        // $db_feedback       = new user_feedback_model();
        // $order_id = intval($_GET['order_id']);
        // $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : (intval(ecjia::config('article_page_size')) > 0 ? intval(ecjia::config('article_page_size')) : 10);
        // $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        // $message_list = get_message_list($user_id, $size , $page, $order_id); /*获取信息*/
        // ecjia_front::$controller->assign('message_list',$message_list['list']);
        // ecjia_front::$controller->assign('page',$message_list['page']);
        // ecjia_front::$controller->assgin('page',$$message_list['page']);
        // ecjia_front::$controller->assign('title', RC_Lang::lang('user_service_list'));
        // ecjia_front::$controller->assign_title(RC_Lang::lang('user_service_list'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_msg_list.dwt');
    }

    /**
     * 异步加载消息列表
     */
    public static function async_msg_list() {
        // $user_id = $_SESSION['user_id'];
        // $order_id = intval($_GET['order_id']) > 0 ? intval($_GET['order_id']) : 0;
        // $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : (intval(ecjia::config('article_page_size')) > 0 ? intval(ecjia::config('article_page_size')) : 5);
        // $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        // $message_list = get_message_list($user_id, $size , $page, $order_id); /*获取信息*/
        // ecjia_front::$controller->assign('message_list',$message_list['list']);
        ecjia_front::$controller->assign_lang();
        // $sayList = ecjia_front::$controller->fetch('user_msg_list.dwt');
        // ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page' , 'is_last' => $message_list['is_last']));
    }

    /**
     * 加载消息详情
     */
    public static function msg_detail() {
        // $user_id	= $_SESSION['user_id'];
        // $msg_id 	= $_GET['msg_id'];
        // $mes_detail = get_message_detail($user_id, $msg_id);
        // ecjia_front::$controller->assign('msg_detail',$mes_detail);
        // ecjia_front::$controller->assign('id',$msg_id);
        // ecjia_front::$controller->assign('title', RC_Lang::lang('user_service_detail'));
        // ecjia_front::$controller->assign_title(RC_Lang::lang('user_service_detail'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_msg_detail.dwt');
    }

    /**
     * 删除信息
     */
    public static function del_msg() {
        // $db_feedback = RC_Loader::load_app_model ( "feedback_model" );
        // RC_Loader::load_theme('extras/model/user/user_feedback_model.class.php');
        // $db_feedback       = new user_feedback_model();
        // $user_id = $_SESSION['user_id'];
        // $id = intval($_GET['id']) > 0 ? intval($_GET['id']) : 0;
        // $order_id = intval($_GET['order_id']);
        // if ($id > 0) {
        //     $where_s['msg_id'] = $id;
        //     $where_s['user_id'] = $user_id;
        //     $message_img = $db_feedback->where($where_s)->get_field('message_img');
        //     if (!empty($message_img) && $message_img != '*') {
        //         @unlink(RC_Upload::upload_path('data' . DIRECTORY_SEPARATOR . 'afficheimg' . DIRECTORY_SEPARATOR . $message_img));
        //     }
        //     $db_feedback->where($where_s)->delete();
        //     $db_feedback->where(array('parent_id'=>$id))->delete();
        // }
        // ecjia_front::$controller->showmessage('删除成功', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl'=>RC_Uri::url('user/user_message/msg_list'),'is_show' => false));
    }

}

// end
