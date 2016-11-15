<?php
/**
 * 收藏模块控制器代码
 * @author royalwang
 *
 */
class b2b2c_user_bonus_controller {

	/**
     * 我的红包
     */
    public static function bonus() {
        RC_Loader::load_theme('extras/b2b2c/functions/user/b2b2c_front_user_bonus.func.php');
        $status = empty($_GET['status'])? 'notused' : $_GET['status'];
        $cur_date = RC_Time::gmtime();
        $where = array();
        if ($status == 'notused'){
            $where = array(
                'use_start_date'    => array('elt'=>$cur_date),
                'use_end_date'      => array('gt'=>$cur_date),
                'order_id'          => 0
            );
        } elseif ($status == 'overdue'){
            $where = array(
                'bt.use_end_date'   => array('lt'=>$cur_date),
                'ub.order_id'       => array('eq'=>0)
            );
        } elseif ($status == 'used'){
            $where = array(
                'ub.order_id'       => array('neq'=>0)
            );
        }
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $bonus = get_user_bouns($where, $size, $page);
        ecjia_front::$controller->assign('title', RC_Lang::lang('label_bonus'));
        ecjia_front::$controller->assign('bonus', $bonus['list']);
        ecjia_front::$controller->assign('page', $bonus['page']);
        ecjia_front::$controller->assign('status',$status);
        ecjia_front::$controller->assign_title(RC_Lang::lang('label_bonus'));
        ecjia_front::$controller->assign('header_left', array('href' => RC_Uri::url('user/index/init')));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_bonus.dwt');
    }

    /**
     * 异步加载红包列表
     */
    public static function async_bonus_list() {
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $status = empty($_GET['status'])? 'notused' : $_GET['status'];
        $cur_date = RC_Time::gmtime();
        $where = array();
        if ($status == 'notused'){
            $where = array(
                'use_start_date'    => array('elt'=>$cur_date),
                'use_end_date'      => array('gt'=>$cur_date),
                'order_id'          => 0
            );
        } elseif ($status == 'overdue'){
            $where = array(
                'bt.use_end_date'   => array('lt'=>$cur_date),
                'ub.order_id'       => array('eq'=>0)
            );
        } elseif ($status == 'used'){
            $where = array(
                'ub.order_id'       => array('neq'=>0)
            );
        }
        $bonus = get_user_bouns($where, $size, $page);
        ecjia_front::$controller->assign('bonus', $bonus['list']);
        $sayList = ecjia_front::$controller->fetch('user_bonus.dwt');
        ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page' , 'is_last' => $bonus['is_last']));
    }
}

// end