<?php
/**
 * 红包模块控制器代码
 */
class user_bonus_controller {

    /**
     * 我的红包
     */
    public static function bonus() {
//         $status = empty($_GET['status'])? 'notused' : $_GET['status'];
//         $cur_date = RC_Time::gmtime();
//         $where = array();
//         if ($status == 'notused') {
//             $where = array(
//                 'use_start_date'	=> array('elt'=>$cur_date),
//                 'use_end_date'		=> array('gt'=>$cur_date),
//                 'order_id'			=> 0
//             );
//         } elseif ($status == 'overdue'){
//             $where = array(
//                 'bt.use_end_date'	=> array('lt'=>$cur_date),
//                 'ub.order_id'		=> array('eq'=>0)
//             );
//         } elseif ($status == 'used') {
//             $where = array(
//                 'ub.order_id'		=> array('neq'=>0)
//             );
//         }
//         $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
//         $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
//         $bonus = get_user_bouns_list($where, $size, $page);
//         ecjia_front::$controller->assign('title', RC_Lang::lang('label_bonus'));
//         ecjia_front::$controller->assign('bonus', $bonus['list']);
//         ecjia_front::$controller->assign('page', $bonus['page']);
//         ecjia_front::$controller->assign('status',$status);
//         ecjia_front::$controller->assign_title(RC_Lang::lang('label_bonus'));
//         ecjia_front::$controller->assign_lang();
        $status = $_GET['status'];
        $_SESSION['bonus_type'] = $status;
        ecjia_front::$controller->display('user_bonus.dwt');
    }

    /**
     * 异步加载红包列表
     */
    public static function async_bonus_list() {
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $cur_date = RC_Time::gmtime();
        $status = empty($_SESSION['bonus_type'])? 'allow_use' : $_SESSION['bonus_type'];
//         $bonus = get_user_bouns_list($where, $size, $page);
//         ecjia_front::$controller->assign('bonus', $bonus['list']);
        $bonus = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_BONUS)->data(array('bonus_type' => $status))->send()->getBody();
        $bonus = json_decode($bonus,true);
        $bonus = $bonus['data'];
        ecjia_front::$controller->assign('bonus', $bonus);
        $sayList = ecjia_front::$controller->fetch('user_bonus.dwt');
        ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page'));
    }

    /**
     * 增加红包
     */
    public static function add_bonus() {
        $user_id = $_SESSION['user_id'];
        $bonus_sn = htmlspecialchars($_POST['bonus_sn']);
        $bonus = add_bonus($user_id, $bonus_sn);
        if (!empty($bonus['error'])) {
            ecjia_front::$controller->showmessage($bonus['message'], ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        } else {
            ecjia_front::$controller->showmessage(RC_Lang::lang('add_bonus_sucess'),ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON,array('is_show' => false));
        }
    }

}

// end
