<?php
/**
 * 收藏模块控制器代码
 */
class user_collection_controller {

    /**
     * 收藏商品列表
     */
    public static function collection_list() {
        // $user_id = $_SESSION['user_id'];
        // $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        // $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        // $collection_list = get_collection_goods($user_id, $size, $page);
        // ecjia_front::$controller->assign('title', RC_Lang::lang('label_collection'));
        // ecjia_front::$controller->assign('collection_list', $collection_list['list']);
        // ecjia_front::$controller->assign('page', $collection_list['page']);
        // ecjia_front::$controller->assign_title(RC_Lang::lang('label_collection'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_collection_list.dwt');
    }

    /**
     * 异步加载收藏列表
     */
    public static function async_collection_list() {
        // $user_id = $_SESSION['user_id'];
        // $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        // $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        // $collection_list = get_collection_goods($user_id, $size, $page);
        // ecjia_front::$controller->assign('collection_list', $collection_list['list']);
        ecjia_front::$controller->assign_lang();
        // $sayList = ecjia_front::$controller->fetch('user_collection_list.dwt');
        // ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page' , 'is_last' => $collection_list['is_last']));
    }

    /**
     * 添加关注
     */
    public static function add_attention() {
        // $user_id = $_SESSION['user_id'];
        // RC_Loader::load_theme('extras/model/user/user_collect_goods_model.class.php');
        // $db_collect_goods  = new user_collect_goods_model();
        // $rec_id = intval($_GET['rec_id']);
        // if (!empty($rec_id) && $db_collect_goods->where(array('rec_id' => $rec_id, 'user_id' => $user_id))->update(array('is_attention' => 1))) {
        //     ecjia_front::$controller->showmessage(RC_Uri::url('collection_list'),ecjia::MSGSTAT_SUCCESS |ecjia::MSGTYPE_JSON, array('pjaxurl'=>RC_Uri::url('collection_list'), 'is_show' => false));
        // }
        // ecjia_front::$controller->showmessage('添加关注失败',ecjia::MSGSTAT_ERROR |ecjia::MSGTYPE_JSON);
    }

    /**
     * 取消关注
     */
    public static function del_attention() {
        // $user_id = $_SESSION['user_id'];
        // // $db_collect_goods = RC_Loader::load_app_model("collect_goods_model");
        // RC_Loader::load_theme('extras/model/user/user_collect_goods_model.class.php');
        //     $db_collect_goods  = new user_collect_goods_model();
        // $rec_id = !empty($_GET['rec_id']) ? intval($_GET['rec_id']) : 0;
        // if ($rec_id && $db_collect_goods->where(array('rec_id' => $rec_id, 'user_id' => $user_id))->update(array('is_attention' => 0))) {
        //     ecjia_front::$controller->showmessage(RC_Uri::url('collection_list'),ecjia::MSGSTAT_SUCCESS |ecjia::MSGTYPE_JSON, array('pjaxurl'=>RC_Uri::url('collection_list'), 'is_show' => false));
        // }
        // ecjia_front::$controller->showmessage('取消关注失败',ecjia::MSGSTAT_ERROR |ecjia::MSGTYPE_JSON);
    }

    /**
     * 删除收藏商品
     */
    public static function delete_collection() {
        // $db_collect_goods = RC_Loader::load_app_model ( "collect_goods_model" );
        // RC_Loader::load_theme('extras/model/user/user_collect_goods_model.class.php');
        //     $db_collect_goods  = new user_collect_goods_model();
        // $user_id = $_SESSION['user_id'];
        // $rec_id = intval($_GET['id']);
        // $db_collect_goods->where(array('user_id'=>$user_id, 'rec_id'=>$rec_id))->delete();
        // ecjia_front::$controller->showmessage('成功删除收藏商品', ecjia::MSGSTAT_SUCCESS |ecjia::MSGTYPE_JSON, array('pjaxurl'=>RC_Uri::url('user/user_collection/collection_list'), 'is_show' => false));
    }

    /**
     * 添加收藏商品
     */
    public static function add_collection() {
        // $db_collect_goods = RC_Loader::load_app_model ( "collect_goods_model" );
    //     RC_Loader::load_theme('extras/model/user/user_collect_goods_model.class.php');
    //     $db_collect_goods  = new user_collect_goods_model();
    //     $goods_id = intval($_GET['id']);
    //     $user_id = $_SESSION['user_id'];
    //     if (!isset($user_id) || $user_id == 0) {
    //         ecjia_front::$controller->showmessage(RC_Lang::lang('login_please'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl'=>RC_Uri::url('user/index/login')));
    //     }
    //     /*检查是否已经存在于用户的收藏夹*/
    //     $where = array(
    //         'user_id'	=> $user_id,
    //         'goods_id'	=> $goods_id
    //     );
    //     $count = $db_collect_goods->where($where)->count();
    //     if ($count > 0) {
    //         $db_collect_goods->where($where)->delete();
    //         ecjia_front::$controller->showmessage(RC_Lang::lang('uncollect_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('is_show' => false,'pjaxurl'=>RC_Uri::url('goods/index/init',array('id' => $goods_id))));
    //     }
    //     $data = array(
    //         'user_id'	=> $user_id,
    //         'goods_id'	=> $goods_id,
    //         'add_time'	=> RC_Time::gmtime()
    //     );
    //     if ($db_collect_goods->insert($data)) {
    //         ecjia_front::$controller->showmessage(RC_Lang::lang('collect_success'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('is_show' => false,'pjaxurl'=>RC_Uri::url('goods/index/init',array('id' => $goods_id))));
    //     } else {
    //         ecjia_front::$controller->showmessage(RC_Lang::lang('login_please'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    //     }
    }

}

// end
