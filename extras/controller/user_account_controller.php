<?php
/**
 * 资金模块控制器代码
 */
class user_account_controller {

    /**
    * 资金管理
    */
    public static function account_detail() {
        // RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
        // $db_users = new touch_users_model();
        // $user_id = $_SESSION['user_id'];
        // $status = $_GET['status'];
        // if ($status == 'recharge') {
        //     $where = array('user_money'=>array('gt'=>0));
        // }elseif ($status == 'withdraw'){
        //     $where = array('user_money'=>array('lt'=>0));
        // }else {
        //     $where = array();
        // }
        // RC_Loader::load_theme('extras/model/user/user_account_log_model.class.php');
        //     $db_account_log  = new user_account_log_model();
        // /*获取剩余余额*/
        // $surplus_amount = get_user_surplus($user_id);
        // if (empty($surplus_amount)) {
        //     $surplus_amount = 0;
        // }
        // $user = $db_users->where(array('user_id'=>$user_id))->find();
        // unset($user['question']);
        // unset($user['answer']);
        // /* 格式化帐户余额 */
        // if ($user) {
        //     $user['formated_user_money'] = price_format($user['user_money'], false);
        //     $user['formated_frozen_money'] = price_format($user['frozen_money'], false);
        // }
        // $cur_date = RC_Time::gmtime();
        // RC_Loader::load_theme('extras/model/user/user_bonus_viewmodel.class.php');
        // $db_bonus       = new user_bonus_viewmodel();
        // $db_bonus->view = array(
        //     'bonus_type' => array(
        //         'type'      => Component_Model_View::TYPE_LEFT_JOIN,
        //         'alias'     => 'bt',
        //         'on'        => 'ub.bonus_type_id = bt.type_id'
        //     )
        // );
        //
        // $bonus_where = array(
        //     'use_start_date'    => array('elt'=>$cur_date),
        //     'use_end_date'      => array('gt'=>$cur_date),
        //     'order_id'          => 0,
        //     'ub.user_id'        => $_SESSION['user_id']
        // );
        // $bonus = $db_bonus->join(array('bonus_type'))->where($bonus_where)->count('*');
        // ecjia_front::$controller->assign('integral',$user['pay_points']);
        // ecjia_front::$controller->assign('bonus_number',intval($bonus));
        // ecjia_front::$controller->assign('status',$status);
        // ecjia_front::$controller->assign('title', RC_Lang::lang('label_user_surplus'));
        // ecjia_front::$controller->assign('surplus_amount', $surplus_amount);
        // ecjia_front::$controller->assign_title(RC_Lang::lang('label_user_surplus'));
        // ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_account_detail.dwt');
    }
    /**
     * 查看明细
     */
    public static function account_list(){
        // RC_Loader::load_theme('extras/model/user/user_account_log_model.class.php');
        // $db_account_log = new user_account_log_model();
        // $user_id = $_SESSION['user_id'];
        // $status = $_GET['status'];
        // if ($status == 'recharge') {
        //     $where = array('user_money'=>array('gt'=>0));
        // }elseif ($status == 'withdraw'){
        //     $where = array('user_money'=>array('lt'=>0));
        // }else {
        //     $where = array();
        // }
        // $where = array_merge($where, array('user_id'=>$user_id));
        // /*获取余额记录*/
        // $res = $db_account_log->where($where)->order(array('log_id'=>'DESC'))->select();
        // if (!empty($res)) {
        //     foreach ($res as $k => $v) {
        //         $res[$k]['change_time'] =  RC_Time::local_date(ecjia::config('date_format'), $v['change_time']);
        //         $res[$k]['type'] = $v['user_money'] > 0 ? RC_Lang::lang('account_inc') : RC_Lang::lang('account_dec');
        //         $res[$k]['user_money'] = price_format(abs($v['user_money']), false);
        //         $res[$k]['frozen_money'] = price_format(abs($v['frozen_money']), false);
        //         $res[$k]['rank_points'] = abs($v['rank_points']);
        //         $res[$k]['pay_points'] = abs($v['pay_points']);
        //         $res[$k]['short_change_desc'] =  RC_String::sub_str($v['change_desc'], 60);
        //         $res[$k]['amount'] = $v['user_money'];
        //     }
        // }
        // ecjia_front::$controller->assign('status',$status);
        // ecjia_front::$controller->assign('title','资金明细');
        // ecjia_front::$controller->assign_title('资金明细');
        // ecjia_front::$controller->assign('account_log', $res);
        ecjia_front::$controller->display('user_account_list.dwt');
    }
    /**
    * 充值
    */
    public static function recharge() {
        // ecjia_front::$controller->assign('title', '账户充值');
        // ecjia_front::$controller->assign_title('账户充值');
        // /*给货到付款的手续费加<span id>，以便改变配送的时候动态显示*/
        // $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
        // $payment_list = empty($payment_method) ? array() : $payment_method->get_online_payment_list(false);
        // foreach ($payment_list as $key => $val) {
        //     if ($val['pay_code'] == 'pay_balance') {
        // 		unset($payment_list[$key]);
        //     }
        // }
        // if (isset($payment_list)) {
        //     foreach ($payment_list as $key => $payment) {
        //         $payment_list [$key] ['format_pay_fee'] = strpos($payment['pay_fee'], '%') !== false ? $payment['pay_fee'] : price_format($payment['pay_fee'], false);
        //         if ($payment ['is_cod'] == '1') {
        //             $payment_list [$key] ['format_pay_fee'] = '<span id="ECS_CODFEE">' . $payment_list [$key] ['format_pay_fee'] . '</span>';
        //         }
        //         /* 如果有易宝神州行支付 如果订单金额大于300 则不显示 */
        //         if ($payment ['pay_code'] == 'yeepayszx' && $total ['amount'] > 300) {
        //             unset($payment_list [$key]);
        //         }
        //         /* 如果有余额支付 */
        //         if ($payment ['pay_code'] == 'balance') {
        //             /* 如果未登录，不显示 */
        //             if ($_SESSION ['user_id'] == 0) {
        //                 unset($payment_list [$key]);
        //             } else {
        //                 if ($_SESSION ['flow_order'] ['pay_id'] == $payment ['pay_id']) {
        //                     ecjia_front::$controller->assign('disable_surplus', 1);
        //                 }
        //             }
        //         }
        //     }
        // }
        // ecjia_front::$controller->assign('payment_list', $payment_list);
        // ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_account_recharge.dwt');
    }

    /**
     *  对会员余额申请的处理
     */
    public static function recharge_account() {
        // $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
        // if ($amount <= 0) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('amount_gt_zero'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT);
        // }
        // /* 变量初始化 */
        // $surplus = array(
        //     'user_id'       => $_SESSION['user_id'],
        //     'process_type'  => 0,
        //     'payment_id'    => isset($_POST['payment_id'])   ? intval($_POST['payment_id'])   : 0,
        //     'user_note'     => isset($_POST['user_note'])    ? trim($_POST['user_note'])      : '',
        //     'amount'        => $amount
        // );
        // if ($surplus['payment_id'] <= 0) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('select_payment_pls'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT);
        // }
        // /* 取得支付信息，生成支付代码 */
        // RC_Loader::load_app_class('payment_abstract', 'payment', false);
        // $payment_method             = RC_Loader::load_app_class('payment_method','payment');
        // $payment_info               = $payment_method->payment_info_by_id($surplus ['payment_id']);
        // $surplus['payment']         = $payment_info['pay_name'];
        // $surplus['rec_id']          = insert_user_account($surplus, $amount); //插入会员账目明细
        // $order                      = array();
        // $order['order_sn']          = $surplus['rec_id'];
        // $order['user_name']         = $_SESSION['user_name'];
        // $order['pay_id']            = $surplus['payment_id'];
        // $order['order_amount']      = $amount;
        // $payment_info['pay_fee']    = pay_fee($order ['pay_id'], $order['surplus_amount'], 0); // 计算支付手续费用
        // $order['order_amount']      = $amount + $payment_info['pay_fee']; // 计算此次预付款需要支付的总金额
        // $order['log_id']            = insert_pay_log($surplus['rec_id'], $order['order_amount'], $type=PAY_SURPLUS, 0); // 记录支付log
        // $payment_config             = $payment_method->unserialize_config($payment_info['pay_config']); // 取得支付信息，生成支付代码
        // $handler                    = $payment_method->get_payment_instance($payment_info['pay_code'], $payment_config);
        // $handler->set_orderinfo($order);
        // $handler->set_mobile(true);
        // /* 这是一个支付的抽象类payment_abstract */
        // $pay_online = $handler->get_code(payment_abstract::PAYCODE_PARAM);
        // if (!empty($pay_online['pay_online'])) {
        //     Header("HTTP/1.1 303 See Other");
        //     Header("Location: " . $pay_online['pay_online']);
        //     exit;
        // } else {
        //     ecjia_front::$controller->showmessage('支付方式无法支付', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT);
        // }
    }

    /**
    * 提现
    */
    public static function withdraw() {
        // $sur_amount = get_user_surplus($_SESSION['user_id']);
        // ecjia_front::$controller->assign('title', '账户提现');
        // ecjia_front::$controller->assign_title('账户提现');
        // ecjia_front::$controller->assign('sur_amount', $sur_amount);
        // ecjia_front::$controller->assign_lang();
//         ecjia_front::$controller->assign('hideinfo', '123');
        ecjia_front::$controller->display('user_account_withdraw.dwt');
    }

    /*
     * 账单详情
     */
    public static function detail(){
        // RC_Loader::load_theme("extras/model/user/user_account_log_model.class.php");
        // $db_account_log = new user_account_log_model();
        //
        // $id = intval($_GET['id']);
        // $res = $db_account_log->where(array('log_id' => $id))->find();
        // $user_img = get_user_img($_SESSION['user_id']);
        // $time = RC_Time::local_date('Y-m-d:H:i:s',$res['change_time']);
        // ecjia_front::$controller->assign('account',     $res);
        // ecjia_front::$controller->assign('time',        $time);
        // ecjia_front::$controller->assign('user_img',    $user_img);
        // ecjia_front::$controller->assign('title',       '账单详情');
        // ecjia_front::$controller->assign_title('账单详情');
        ecjia_front::$controller->display('user_account_log_detail.dwt');
    }

    /**
     *  对会员余额申请的处理
     */
    public static function withdraw_account() {
        // $amount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
        // if ($amount <= 0) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('amount_gt_zero'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT);
        // }
        // /* 变量初始化 */
        // $surplus = array(
        //     'user_id'       => $_SESSION['user_id'],
        //     'process_type'  => 1,
        //     'user_note'     => isset($_POST['user_note'])    ? trim($_POST['user_note'])      : '',
        //     'amount'        => $amount
        // );
        // /* 判断是否有足够的余额的进行退款的操作 */
        // $sur_amount = get_user_surplus($_SESSION['user_id']);
        // if ($amount > $sur_amount) {
        // 	ecjia_front::$controller->showmessage(RC_Lang::lang('surplus_amount_error'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT);
        // }
        // //插入会员账目明细
        // $amount = '-'.$amount;
        // $surplus['payment'] = '';
        // $surplus['rec_id']  = insert_user_account($surplus, $amount);
        // /* 如果成功提交 */
        // ecjia_front::$controller->showmessage(RC_Lang::lang('surplus_appl_submit'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_ALERT,array('pjaxurl' => RC_Uri::url('user/user_account/account_detail')));
    }
    
    /**
     * 充值提现列表
     */
    public static function cash_list() {
        ecjia_front::$controller->assign('hideinfo', '123');
    	ecjia_front::$controller->assign('title', '交易记录');
    	ecjia_front::$controller->assign('theme_url', RC_Theme::get_template_directory_uri() . '/');
    	ecjia_front::$controller->display('user_cash_list.dwt');
       
    }
    
    public static function ajax_cash_list() {
    	$type = htmlspecialchars($_GET['type']);
    	$limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
    	$page = intval($_GET['page']) ? intval($_GET['page']) : 1;
    	
    	$data = RC_DB::table('account_log')->where('user_id', 1042)->get();
    	
    	ecjia_front::$controller->assign('sur_amount', $data);
    	ecjia_front::$controller->assign_lang();
    	$sayList = ecjia_front::$controller->fetch('user_cash_list.dwt');
    	
    	ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList, 'page', 'is_last' => $data['is_last']));
    }

}

// end
