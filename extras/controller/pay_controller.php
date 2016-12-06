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
        $pay_code = !empty($_GET['pay_code']) ? trim($_GET['pay_code']) : 0;
        $tips_show = !empty($_GET['tips_show']) ? trim($_GET['tips_show']) : 0;
        
        if (empty($order_id)) {
            ecjia_front::$controller->showmessage('订单不存在', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT);
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
                ecjia_front::$controller->showmessage($rs_update['status']['error_desc'], ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT);
            }
        }
        
        //获得订单支付信息
        $params = array(
            'token' => ecjia_touch_user::singleton()->getToken(),
            'order_id' => $order_id,
        );
        $rs_pay = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_PAY)->data($params)
        ->send()->getBody();
        $rs_pay = json_decode($rs_pay,true);
        if (! $rs_pay['status']['succeed']) {
            ecjia_front::$controller->showmessage($rs_pay['status']['error_desc'], ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT);
        }
        if ($rs_pay['data']['payment']['error_message']) {
            ecjia_front::$controller->assign('pay_error', $rs_pay['data']['payment']['error_message']);
        }
        
        $order = $rs_pay['data']['payment'];
        
//         _dump($order);
        $need_other_payment = 0;
        if ($order ['pay_code'] == 'pay_balance') {
            if ($rs_pay['data']['payment']['error_message']) {
                $need_other_payment = 1;
            }
        } else {
            //其他支付方式
            $need_other_payment = 1;
        }
        
        if ($need_other_payment) {
            $params = array(
                'token' => ecjia_touch_user::singleton()->getToken(),
            );
            $rs_payment = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_PAYMENT)->data($params)
            ->send()->getBody();
            $rs_payment = json_decode($rs_payment,true);
        
            if (! $rs_payment['status']['succeed']) {
                ecjia_front::$controller->showmessage($rs_payment['status']['error_desc'], ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT);
            }
            $payment_list = touch_function::change_array_key($rs_payment['data']['payment'], 'pay_code');
            //             _dump($payment_list);
            unset($payment_list[$order['pay_code']]);
//             _dump($payment_list);
            //过滤当前支付方式
            //             foreach
            ecjia_front::$controller->assign('payment_list', $payment_list);
        }
//         _dump($rs_pay);
        
        $order['formated_order_amount'] = price_format($order['order_amount']);
        $order['order_id'] = $order_id;
        ecjia_front::$controller->assign('data', $order);
        ecjia_front::$controller->assign('pay_online', $order['pay_online']);
        ecjia_front::$controller->assign('tips_show', $tips_show);
        
        ecjia_front::$controller->display('pay.dwt');
    }
    
}

// end
