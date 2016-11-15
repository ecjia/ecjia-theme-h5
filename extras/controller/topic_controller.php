<?php
/**
 * 专题模块控制器代码
 */
class topic_controller {

    /**
     *  专题列表
     */
    public static function init() {
        RC_Loader::load_theme('extras/functions/topic/front_global.func.php');
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $keywords = $_REQUEST['keywords'];
        $topic_list = get_topic_list($page, $size, $keywords);
        ecjia_front::$controller->assign('topic_list', $topic_list['list']);
        ecjia_front::$controller->assign('title', '专题列表');
        ecjia_front::$controller->assign_title('专题列表');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('topic_list.dwt');
    }

    /**
     *  异步加载专题列表
     */
    public static function async_topic_list(){
        RC_Loader::load_theme('extras/functions/topic/front_global.func.php');
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $keywords = $_REQUEST['keywords'];
        $topic_list = get_topic_list($page, $size, $keywords);
        ecjia_front::$controller->assign('topic_list', $topic_list['list']);
        ecjia_front::$controller->assign('page', $topic_list['page']);
        $sayList = ecjia_front::$controller->fetch('topic_list.dwt');
        ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page' , 'is_last' => $topic_list['is_last']));
    }

    /**
     * 专题详情
     */
    public static function info() {
        RC_Loader::load_theme('extras/functions/topic/front_global.func.php');
    	$topic_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $topic_info = get_topic_info($topic_id);
        ecjia_front::$controller->assign('title', $topic_info['title']);
        ecjia_front::$controller->assign_title($topic_info['title']);
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display(RC_Theme::get_template_directory().'/library/topic/'.$topic_info['template']);
    }

}

// end
