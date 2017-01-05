<?php
/**
 * 支付控制器代码
 */
class pay_controller {
    /**
     * 
     */
    public static function init() {
    	
        $order_id = !empty($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        $pay_id = !empty($_GET['pay_id']) ? intval($_GET['pay_id']) : 0;
        $pay_code = !empty($_GET['pay_code']) ? trim($_GET['pay_code']) : '';
        $tips_show = !empty($_GET['tips_show']) ? trim($_GET['tips_show']) : 0;
        
        if (empty($order_id)) {
			return ecjia_front::$controller->showmessage('订单不存在', ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR );
        }
        
        if ($pay_id && $pay_code) {
            //修改支付方式，更新订单
            $params = array(
                'token' => ecjia_touch_user::singleton()->getToken(),
                'order_id' => $order_id,
                'pay_id' => $pay_id,
            );
            $rs_update = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_UPDATE)->data($params)
            ->send()->getBody();
            $rs_update = json_decode($rs_update,true);
            if (! $rs_update['status']['succeed']) {
				return ecjia_front::$controller->showmessage($rs_update['status']['error_desc'], ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
            }
        }
        /*获取订单信息*/
        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'order_id' => $order_id);
        $detail = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_DETAIL)->data($params_order)->run();
        //支付方式信息
        $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
        $payment_info = $payment_method->payment_info_by_id($detail['pay_id']);
        /* 调起微信支付*/
        if ( $pay_code == 'pay_wxpay' || $payment_info['pay_code'] == 'pay_wxpay') {
        	// 取得支付信息，生成支付代码
        	$payment_config = $payment_method->unserialize_config($payment_info['pay_config']);
        	
        	$handler = $payment_method->get_payment_instance($payment_info['pay_code'], $payment_config);
        	$handler->set_orderinfo($detail);
        	$handler->set_mobile(false);
        	$rs_pay = $handler->get_code(payment_abstract::PAYCODE_PARAM);
        	$order = $rs_pay;
        	ecjia_front::$controller->assign('pay_button', $rs_pay['pay_online']);
        	unset($order['pay_online']);
        } else {
        	//获得订单支付信息
        	$params = array(
        			'token' => ecjia_touch_user::singleton()->getToken(),
        			'order_id'	=> $order_id,
        	);
        	$rs_pay = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_PAY)->data($params)
        	->send()->getBody();
        	$rs_pay = json_decode($rs_pay,true);
        	
        	if (isset($rs_pay) && !$rs_pay['status']['succeed']) {
        		return ecjia_front::$controller->showmessage($rs_pay['status']['error_desc'], ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
        	}
        	if (isset($rs_pay) && $rs_pay['data']['payment']['error_message']) {
        		ecjia_front::$controller->assign('pay_error', $rs_pay['data']['payment']['error_message']);
        	}
        	
        	$order = $rs_pay['data']['payment'];
        	
        	$need_other_payment = 0;
        	if ($order ['pay_code'] == 'pay_balance') {
        		if ($rs_pay['data']['payment']['error_message']) {
        			$need_other_payment = 1;
        		}
        	} else {
        		//其他支付方式
        		$not_need_otherpayment_arr = array('pay_cod');
        		if (in_array($order ['pay_code'], $not_need_otherpayment_arr)) {
        			$need_other_payment = 0;
        		} else {
        			$need_other_payment = 1;
        		}
        	}
        	
        	if ($need_other_payment && $order['order_pay_status'] == 0) {
        		$params = array(
        				'token' => ecjia_touch_user::singleton()->getToken(),
        		);
        		$rs_payment = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_PAYMENT)->data($params)
        		->send()->getBody();
        		$rs_payment = json_decode($rs_payment,true);
        	
        		if (! $rs_payment['status']['succeed']) {
        			return ecjia_front::$controller->showmessage($rs_payment['status']['error_desc'], ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
        		}
        		$payment_list = touch_function::change_array_key($rs_payment['data']['payment'], 'pay_code');
        		//过滤当前支付方式
        		unset($payment_list[$pay_code]);
        		//非自营过滤货到付款
        		if($detail['manage_mode'] != 'self') {
        			unset($payment_list['pay_cod']);
        		}
        		ecjia_front::$controller->assign('payment_list', $payment_list);
        	}
        	
        	if ($order['pay_code'] != 'pay_balance') {
        		$order['formated_order_amount'] = price_format($order['order_amount']);
        	}
        }
        
        $order['order_id'] = $order_id;
        
        ecjia_front::$controller->assign('detail', $detail);
        ecjia_front::$controller->assign('data', $order);
        ecjia_front::$controller->assign('pay_online', $order['pay_online']);
        ecjia_front::$controller->assign('tips_show', $tips_show);
        
        ecjia_front::$controller->display('pay.dwt');
    }
    
    public static function notify($mag) {
       
        ecjia_front::$controller->assign('mag', $mag);
        ecjia_front::$controller->assign('theme_url', str_replace('notify/', '', RC_Theme::get_template_directory_uri() . '/'));
        
        ecjia_front::$controller->display('pay_notify.dwt');
    }
    
}

// end