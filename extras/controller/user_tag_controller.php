<?php
/**
 * 标签模块控制器代码
 */
class user_tag_controller {

    /**
     * 我的标签
     */
    public static function tag_list() {
        $user_id = $_SESSION['user_id'];
        $tags = get_user_tags($user_id);
        ecjia_front::$controller->assign('title', RC_Lang::lang('label_tag'));
        ecjia_front::$controller->assign('tags', $tags);
        ecjia_front::$controller->assign_title( RC_Lang::lang('label_tag'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_tag_list.dwt');
    }

    /**
     * 删除标签
     */
    public static function del_tag() {
        $user_id = $_SESSION['user_id'];
        $tag_words = htmlspecialchars($_GET['id']);
        delete_tag($tag_words, $user_id);
        ecjia_front::$controller->showmessage(RC_Lang::lang('delete_tag_true'),ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl'=>RC_Uri::url('user/user_tag/tag_list'), 'is_show' => false));
    }

}

// end
