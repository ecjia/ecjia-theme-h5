<?php
/**
 * 红包模块控制器代码
 */
class user_bonus_controller {

    /**
     * 我的红包
     */
    public static function bonus() {
//         $status = $_GET['status'];
//         $_SESSION['bonus_type'] = $status;
        ecjia_front::$controller->assign_title('我的红包');
        ecjia_front::$controller->display('user_bonus.dwt');
    }

    /**
     * 异步加载红包列表
     */
//     public static function async_bonus_list() {
//         $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
//         $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
//         $cur_date = RC_Time::gmtime();
//         $status = empty($_SESSION['bonus_type'])? 'allow_use' : $_SESSION['bonus_type'];
//         $bonus = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_BONUS)->data(array('pagination' => array('page' => $page, 'count' => $limit), 'bonus_type' => $status))->send()->getBody();
//         $bonus = json_decode($bonus,true);
//         $token = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
//         ecjia_front::$controller->assign('bonus', $bonus['data']);
//         $sayList = ecjia_front::$controller->fetch('user_bonus.dwt');
//         $more = 0;
//         if ($bonus['paginated']['more'] == 0) {
//             $more = 1;
//         }
//         ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page', 'is_last' => $more));
//     }

    public static function async_allow_use() {
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $cur_date = RC_Time::gmtime();
//         $status = empty($_SESSION['bonus_type'])? 'allow_use' : $_SESSION['bonus_type'];
        $status = 'allow_use';
        $bonus = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_BONUS)->data(array('pagination' => array('page' => $page, 'count' => $limit), 'bonus_type' => $status))->send()->getBody();
        $bonus = json_decode($bonus,true);
        $token = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
        ecjia_front::$controller->assign('bonus', $bonus['data']);
        $sayList = ecjia_front::$controller->fetch('user_bonus.dwt');
        $more = 0;
        if ($bonus['paginated']['more'] == 0) {
            $more = 1;
        }
        ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page', 'is_last' => $more));
    }
    
    public static function async_is_used() {
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $cur_date = RC_Time::gmtime();
//         $status = empty($_SESSION['bonus_type'])? 'allow_use' : $_SESSION['bonus_type'];
        $status = 'is_used';
        $bonus = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_BONUS)->data(array('pagination' => array('page' => $page, 'count' => $limit), 'bonus_type' => $status))->send()->getBody();
        $bonus = json_decode($bonus,true);
        $token = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
        ecjia_front::$controller->assign('bonus', $bonus['data']);
        $sayList = ecjia_front::$controller->fetch('user_bonus.dwt');
        $more = 0;
        if ($bonus['paginated']['more'] == 0) {
            $more = 1;
        }
        ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page', 'is_last' => $more));
    }
    
    public static function async_expired() {
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $cur_date = RC_Time::gmtime();
//         $status = empty($_SESSION['bonus_type'])? 'allow_use' : $_SESSION['bonus_type'];
        $status = 'expired';
        $bonus = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_BONUS)->data(array('pagination' => array('page' => $page, 'count' => $limit), 'bonus_type' => $status))->send()->getBody();
        $bonus = json_decode($bonus,true);
        $token = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
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
        
        ecjia_front::$controller->assign_title('我的奖励');
        ecjia_front::$controller->assign('intive_total', $intive_total);
        ecjia_front::$controller->display('user_my_reward.dwt');
    }
    
    /**
     * 奖励明细
     */
    public static function reward_detail() {
        $type = !empty($_GET['type']) ? $_GET['type'] : '';
        
		$token = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
    	$invite_reward = ecjia_touch_manager::make()->api(ecjia_touch_api::INVITE_REWARD)->data(array('token' => $token['access_token']))->run();
    	ecjia_front::$controller->assign('month', $invite_reward['invite_record']);
    	
    	$max_key = array_keys($invite_reward['invite_record'], max($invite_reward['invite_record']));
    	$max_month = $invite_reward['invite_record'][$max_key[0]]['invite_data'];

    	$arr = array(
    	    'token'        => $token['access_token'], 
    	    'pagination'   => array('page' => 1, 'count' => 10), 
    	    'date'         => $max_month
    	);
    	$invite_record = ecjia_touch_manager::make()->api(ecjia_touch_api::INVITE_RECORD)->data($arr)->send()->getBody();
    	$data = json_decode($invite_record, true);
    	
    	ecjia_front::$controller->assign('data', $data['data']);
    	ecjia_front::$controller->assign('is_last', $data['paginated']['more']);
    	ecjia_front::$controller->assign('max_month', $max_month);
    	ecjia_front::$controller->assign_title('奖励明细');
        ecjia_front::$controller->display('user_reward_detail.dwt');
    }
    /**
     * 奖励明细异步加载
     */
    public static function async_reward_detail() {
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        
        $token = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
        $arr = array('token' => $token['access_token']);
        $arr['date'] = $_GET['date'];
        $arr['pagination'] = array('page' => $page, 'count' => $limit);
        
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::INVITE_RECORD)->data($arr)->send()->getBody();
        $data = json_decode($data, true);
        
        if (!empty($data['data'])) {
            ecjia_front::$controller->assign('data', $data['data']);
            $sayList = ecjia_front::$controller->fetch('user_reward_detail.dwt');
        }
        $res = array();
        if ($data['paginated']['more'] == 0) {
            $res['is_last'] = 1;
        } else {
            $res['data_toggle'] = 'asynclist';
            $res['url'] = RC_Uri::url('user/user_bonus/async_reward_detail', array('date' => $arr['date']));
        }
//         _dump($res,1);
        return ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList, 'is_last' => $res['is_last'], 'data' => $res));
    }
    /**
     * 赚积分
     */
    public static function get_integral() {
        ecjia_front::$controller->assign_title('赚积分');
        ecjia_front::$controller->display('user_get_integral.dwt');
    }
}

// end
