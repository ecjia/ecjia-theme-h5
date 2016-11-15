<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 查询会员余额的数量
 */
function get_user_surplus($user_id) {
	// $db_account_log = RC_Loader::load_app_model ( "account_log_model" );
	RC_Loader::load_theme('extras/model/user/user_account_log_model.class.php');
    $db_account_log       = new user_account_log_model();
	$condition['user_id'] = $user_id;
	return $db_account_log->field('SUM(user_money)')->where($condition)->get_field();
}

/**
 * 插入会员账目明细
 */
function insert_user_account($surplus, $amount)
{
	// $db = RC_Loader::load_app_model('user_account_model');
	RC_Loader::load_theme('extras/model/user/user_account_model.class.php');
    $db       = new user_account_model();
	$data = array(
		'user_id'		=> $surplus['user_id'] ,
		'admin_user'	=> '' ,
		'amount'		=> $amount ,
		'add_time'		=> RC_Time::gmtime() ,
		'paid_time'		=> 0 ,
		'admin_note'	=> '' ,
		'user_note'		=> $surplus['user_note'] ,
		'process_type'	=> $surplus['process_type'] ,
		'payment'		=> $surplus['payment'] ,
		'is_paid'		=> 0
	);
	return $db->insert($data);
}

/**
 * 获得订单需要支付的支付费用
 */
function pay_fee($payment_id, $order_amount, $cod_fee=null) {
	$payment_method = RC_Loader::load_app_class('payment_method','payment');
	$pay_fee = 0;
	if (empty($payment_method)) return false;
	$payment = $payment_method->payment_info($payment_id);
	$rate	= ($payment['is_cod'] && !is_null($cod_fee)) ? $cod_fee : $payment['pay_fee'];
	if (strpos($rate, '%') !== false) {
		/* 支付费用是一个比例 */
		$val		= floatval($rate) / 100;
		$pay_fee	= $val > 0 ? $order_amount * $val /(1- $val) : 0;
	} else {
		$pay_fee	= floatval($rate);
	}
	return round($pay_fee, 2);
}

/**
 * 将支付LOG插入数据表
 */
function insert_pay_log($id, $amount, $type = PAY_SURPLUS, $is_paid = 0) {
	// $db_pay_log = RC_Loader::load_app_model ( "user_pay_log_model" );
	RC_Loader::load_theme('extras/model/user/user_pay_log_model.class.php');
    $db_pay_log       = new user_pay_log_model();
	$data = array(
		'order_id'		=> $id,
		'order_amount'	=> $amount,
		'order_type'	=> $type,
		'is_paid'		=> $is_paid
	);
	return $db_pay_log->insert($data);
}

// end
