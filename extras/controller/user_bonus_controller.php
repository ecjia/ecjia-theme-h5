<?php
/**
 * 红包模块控制器代码
 */
class user_bonus_controller {

    /**
     * 我的红包
     */
    public static function bonus() {
        $status = $_GET['status'];
        $_SESSION['bonus_type'] = $status;
        ecjia_front::$controller->display('user_bonus.dwt');
    }

    /**
     * 异步加载红包列表
     */
    public static function async_bonus_list() {
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $cur_date = RC_Time::gmtime();
        $status = empty($_SESSION['bonus_type'])? 'allow_use' : $_SESSION['bonus_type'];
        $bonus = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_BONUS)->data(array('pagination' => array('page' => $page, 'count' => $limit), 'bonus_type' => $status))->send()->getBody();
        $bonus = json_decode($bonus,true);
        ecjia_front::$controller->assign('bonus', $bonus['data']);
        $sayList = ecjia_front::$controller->fetch('user_bonus.dwt');
        $more = 0;
        if ($bonus['paginated']['more'] == 0) {
            $more = 1;
        }
        ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page', 'is_last' => $more));
        
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
    /**
     * 我的奖励
     */
    public static function my_reward() {
		$token = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
    	$invite_reward = ecjia_touch_manager::make()->api(ecjia_touch_api::INVITE_REWARD)->data(array('token' => $token['access_token']))->run();
        $intive_total = $invite_reward[invite_total];
        ecjia_front::$controller->assign('intive_total', $intive_total);
        ecjia_front::$controller->display('user_my_reward.dwt');
    }
    
    /**
     * 奖励明细
     */
    public static function reward_detail() {
		$token = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
    	$invite_reward = ecjia_touch_manager::make()->api(ecjia_touch_api::INVITE_REWARD)->data(array('token' => $token['access_token']))->run();
    	$month = $invite_reward[invite_record];
//     	_dump($month, 1);
    	ecjia_front::$controller->assign('month', $month);
        ecjia_front::$controller->display('user_reward_detail.dwt');
    }
    
    /**
     * 赚积分
     */
    public static function get_integral() {
        ecjia_front::$controller->display('user_get_integral.dwt');
    }
}

// end
