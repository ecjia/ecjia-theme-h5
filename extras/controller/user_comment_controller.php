<?php
/**
 * 评论模块控制器代码
 */
class user_comment_controller {

    /**
    * 评论列表
    */
    public static function comment_list() {
        $user_id = $_SESSION['user_id'];
        /*分页*/
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $comment_list = get_comment_list($user_id, $size, $page);
        ecjia_front::$controller->assign('title', RC_Lang::lang('label_comment'));
        ecjia_front::$controller->assign('comment_list', $comment_list['list']);
        ecjia_front::$controller->assign('page', $comment_list['page']);
        ecjia_front::$controller->assign_title(RC_Lang::lang('label_comment'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_comment_list.dwt');
    }

    /**
     * 评论列表
     */
    public static function async_comment_list() {
        $user_id = $_SESSION['user_id'];
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $comment_list = get_comment_list($user_id, $size, $page);
        ecjia_front::$controller->assign('comment_list', $comment_list['list']);
        ecjia_front::$controller->assign('page', $comment_list['page']);
        $sayList = ecjia_front::$controller->fetch('user_comment_list.dwt');
        ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page' , 'is_last' => $comment_list['is_last']));
    }

    /**
    * 删除评论
    */
    public static function delete_comment() {
        // $db_comment = RC_Loader::load_app_model ( "comment_model" );
        RC_Loader::load_theme('extras/model/user/user_comment_model.class.php');
        $db_comment  = new user_comment_model();
        $user_id = $_SESSION['user_id'];
        $id = intval($_GET['id']);
        $db_comment->where(array('user_id'=>$user_id, 'comment_id'=>$id))->delete();
        ecjia_front::$controller->showmessage('删除评论成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl'=>RC_Uri::url('comment_list'),'is_show' => false));
    }

}

// end
