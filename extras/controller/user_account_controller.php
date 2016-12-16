<?php
use Guzzle\Http\Message\Header;
/**
 * 资金模块控制器代码
 */
class user_account_controller {

    /**
    * 资金管理
    */
    public static function account_detail() {
        $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
        ecjia_front::$controller->assign('user', $user);
        ecjia_front::$controller->assign_title('我的钱包');
        ecjia_front::$controller->display('user_account_detail.dwt');
    }
    /**
     * 查看明细
     */
    public static function account_list(){
        $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
        
        ecjia_front::$controller->assign_title('我的余额');
        ecjia_front::$controller->assign('user', $user);
        ecjia_front::$controller->display('user_account_list.dwt');
    }
    /**
    * 充值
    */
    public static function recharge() {
        $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
        $pay = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_PAYMENT)->run();
        foreach ($pay['payment'] as $key => $val) {
            if ($val['pay_name'] != '余额支付' && $val['pay_name'] != '货到付款') {
                $payment[$key] = $val;
            }
        }
        ecjia_front::$controller->assign('payment', $payment);
        ecjia_front::$controller->assign('user', $user);
        ecjia_front::$controller->assign_title('充值');
        ecjia_front::$controller->display('user_account_recharge.dwt');
    }

    /**
     *  对会员余额申请的处理
     */
    public static function recharge_account() {
        $amount = is_numeric($_POST['amount']) ? trim($_POST['amount']) : '';
        $payment_id = !empty($_POST['payment']) ? trim($_POST['payment']) : '';
        if (!empty($amount)) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_ACCOUNT_DEPOSIT)->data(array('amount' => $amount, 'payment_id' => $payment_id))->send()->getBody();
            $data = json_decode($data,true);
            $data_payment_id = $data['data']['payment']['payment_id'];
            $data_account_id = $data['data']['payment']['account_id'];
            $pay = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_ACCOUNT_PAY)->data(array('account_id' => $data_account_id, 'payment_id' => $data_payment_id))->send()->getBody();
            $pay = json_decode($pay,true);
            $pay_online = $pay['data']['payment']['pay_online'];
            ecjia_front::$controller->redirect($pay_online); 
        } else {
            return ecjia_front::$controller->showmessage(__('金额不能为空'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
    * 提现
    */
    public static function withdraw() {
        $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
        ecjia_front::$controller->assign('user', $user);
        
        ecjia_front::$controller->assign_title('提现');
        ecjia_front::$controller->display('user_account_withdraw.dwt');
    }

    /*
     * 账单详情
     */
    public static function detail(){
        ecjia_front::$controller->display('user_account_log_detail.dwt');
    }

    /**
     *  对会员余额申请的处理
     */
    public static function withdraw_account() {
        $amount = !empty($_POST['amount']) ? $_POST['amount'] : '';
        $note   = !empty($_POST['user_note']) ? $_POST['user_note'] : '';
        $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
        $user_money = ltrim($user['formated_user_money'], '￥');
        if ($amount > $user_money) {
            return ecjia_front::$controller->showmessage(__('余额不足，请确定提现金额'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (strlen($note) > '300') {
            return ecjia_front::$controller->showmessage(__('输入的文字超过规定字数'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($amount)) {
            return ecjia_front::$controller->showmessage(__('请输入提现金额'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        } else {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_ACCOUNT_RAPLY)->data(array('amount' => $amount, 'note' => $note))->run();
            return ecjia_front::$controller->showmessage(__($data), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/user_account/account_list')));
        }
    }
    
    /**
     * 充值提现列表
     */
    public static function record() {
        $_SESSION['status'] = !empty($_GET['status']) ? $_GET['status'] : '';
        
        ecjia_front::$controller->assign_title('交易记录');
    	ecjia_front::$controller->display('user_record.dwt');
    }
    
    public static function ajax_record() {
    	$type = htmlspecialchars($_SESSION['status']);
    	$limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
    	$page = intval($_GET['page']) ? intval($_GET['page']) : 1;
    	$data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_ACCOUNT_RECORD)->data(array('pagination' => array('page' => $page, 'count' => $limit), 'type' => $type))->send()->getBody();
    	$data = json_decode($data,true);
    	$now_mon =  substr(date('Y-m-d H:i:s',time()),5,2);
    	$now_day =  substr(date('Y-m-d H:i:s',time()),0,10);
    	$time = '';
    	foreach ($data['data'] as $key => $val) {
    	    if ($time != substr($val['add_time'],5,2)) {
    	        $time = substr($val['add_time'],5,2);
    	        $day = substr($val['add_time'],8,2);
    	    }
    	    $arr[$time][$key] = $data['data'][$key];
    	    $day = substr($val['add_time'],0,10);
    	    if ($day == $now_day) {
    	        $arr[$time][$key]['add_time'] = '今天'.substr($val['add_time'],11,5);
    	    } else {
    	        $arr[$time][$key]['add_time'] = substr($val['add_time'],5,11);
    	    }
    	}
    	foreach ($arr as $key => $val) {
            ecjia_front::$controller->assign('key'.$key, $key);    	    
    	}
    	$user_img = RC_Theme::get_template_directory_uri().'/images/user_center/icon-login-in2x.png';
    	$user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
    	if (!empty($user['avatar_img'])) {
    	    $user_img = $user['avatar_img'];
    	}
    	ecjia_front::$controller->assign('user_img', $user_img);
    	ecjia_front::$controller->assign('type', $type);
    	ecjia_front::$controller->assign('now_mon', $now_mon);
    	ecjia_front::$controller->assign('now_day', $now_day);
    	ecjia_front::$controller->assign('sur_amount', $arr);
    	ecjia_front::$controller->assign_lang();
    	$sayList = ecjia_front::$controller->fetch('user_record.dwt');
    	if ($data['paginated']['more'] == 0) {
    	    $more = 1;
    	}
    	return ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList, 'page', 'is_last' => $more));
    }

    /**
     * 充值提现详情
     */
    public static function record_info() {
        $account_id = !empty($_GET['account_id']) ? $_GET['account_id'] : '';
        $user_img = RC_Theme::get_template_directory_uri().'/images/user_center/icon-login-in2x.png';
        ecjia_front::$controller->assign('user_img', $user_img);
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_ACCOUNT_RECORD)->data(array('page' => $page, 'count' => $limit,'type' => $type))->send()->getBody();
        $data = json_decode($data,true);
        $account_key = '';
        foreach ($data['data'] as $key => $val) {
            if ($data['data'][$key]['account_id'] == $account_id) {
                $account_key = $key;
            }
        }
        $user = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_INFO)->run();
        $user_img = RC_Theme::get_template_directory_uri().'/images/user_center/icon-login-in2x.png';
        if (!empty($user['avatar_img'])) {
            $user_img = $user['avatar_img'];
        }
        ecjia_front::$controller->assign('user_img', $user_img);
        ecjia_front::$controller->assign('user', $user);
        ecjia_front::$controller->assign_title('交易明细');
        ecjia_front::$controller->assign('sur_amount', $data['data'][$account_key]);
        $_SESSION['status'] = !empty($_GET['status']) ? $_GET['status'] : '';
        ecjia_front::$controller->display('user_record_info.dwt');
    }
    
    /**
     * 提现充值取消
     */
    public static function record_cancel() {
        $account_id = !empty($_POST['account_id']) ? $_POST['account_id'] : '';
        $record_type = !empty($_POST['record_type']) ? $_POST['record_type'] : '';
        $submit = !empty($_POST['submit']) ? $_POST['submit'] : '';
        $payment_id = !empty($_POST['payment_id']) ? $_POST['payment_id'] : '';
        if ($submit == '取消') {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_ACCOUNT_CANCEL)->data(array('account_id' => $account_id))->send()->getBody();
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => RC_Uri::url('user/user_account/record'), 'msg' => '取消该交易记录'));
        } elseif ($submit == '充值') {
            $pay = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_ACCOUNT_PAY)->data(array('account_id' => $account_id, 'payment_id' => $payment_id))->send()->getBody();
            $pay = json_decode($pay,true);
            $pay_online = $pay['data']['payment']['pay_online'];
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pay_online' => $pay_online));
//             ecjia_front::$controller->redirect($pay_online); 
        }
    }
    
    
}

// end
