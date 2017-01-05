<?php
/**
 * 订单模块控制器代码
 */
class user_order_controller {

    /**
     * 获取全部订单
     */
    public static function order_list() {
        
        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'pagination' => array('count' => 10, 'page' => 1), 'type' => '');
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_LIST)->data($params_order)
        ->run();
//         ->send()->getBody();
        ecjia_front::$controller->assign('order_list', $data);
        ecjia_front::$controller->assign_title(RC_Lang::lang('order_list_lnk'));
        ecjia_front::$controller->assign('title', RC_Lang::lang('order_list_lnk'));
        ecjia_front::$controller->assign('active', 'orderList');
    	
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_order_list.dwt');
    }
    
    /**
     * 订单详情
     */
    public static function order_detail() {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage('订单不存在', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
    
        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'order_id' => $order_id);
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_DETAIL)->data($params_order)->run();
        ecjia_front::$controller->assign('order', $data);
        ecjia_front::$controller->assign('title', RC_Lang::lang('order_detail'));
        ecjia_front::$controller->assign_title(RC_Lang::lang('order_detail'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_order_detail.dwt');
    }

    /**
     * 取消订单
     */
    public static function order_cancel() {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage('订单不存在', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
        
        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'order_id' => $order_id);
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_CANCEL)->data($params_order)
//         ->run();
        ->send()->getBody();
        $data = json_decode($data,true);
//         _dump($data,1);
        $url = RC_Uri::url('user/user_order/order_detail', array('order_id' => $order_id));
        if ($data['status']['succeed']) {
            return ecjia_front::$controller->showmessage('取消订单成功', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_ALERT,array('pjaxurl' => $url,'is_show' => false));
        } else {
            return ecjia_front::$controller->showmessage($data['status']['error_desc'], ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR,array('pjaxurl' => $url));
        }
        
    }
    
    // 再次购买 重新加入购物车
    public static function buy_again() {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage('订单不存在', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
        
        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'order_id' => $order_id);
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_DETAIL)->data($params_order)->run();
        if (!$data) {
            return ecjia_front::$controller->showmessage('error', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
        if (isset($data['goods_list'])) {
            foreach ($data['goods_list'] as $goods) {
                $params_cart = array(
                    'token' => ecjia_touch_user::singleton()->getToken(),
                    'goods_id' => $goods['goods_id'],
                    'number' => $goods['goods_number'],
                    'location' => array(
                        'longitude' => $_COOKIE['longitude'],
                        'latitude' => $_COOKIE['latitude']
                    ),
                );
                $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_CREATE)->data($params_cart)
                ->send()->getBody();
                $rs = json_decode($rs,true);
                if (! $rs['status']['succeed']) {
                    if ($_GET['from'] == 'list') {
                        $url = RC_Uri::url('user/user_order/order_list');
                    } else {
                        $url = RC_Uri::url('user/user_order/order_detail', array('order_id' => $order_id));
                    }
                    $url = RC_Uri::url('user/user_order/order_detail', array('order_id' => $order_id));
                    return ecjia_front::$controller->showmessage($rs['status']['error_desc'], ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR,array('pjaxurl' => $url));
                }
            }
            $url = RC_Uri::url('cart/index/init');
            header('Location: ' . $url);
        }
        
    }
    

    /**
    * ajax获取订单
    */
    public static function async_order_list() {
        // $status = $_GET['status'];
        // if ($status == '' || $status == 'unpayed') {
        //     $where = array(
        //         'pay_status' => 0,
        //         'order_status' => array('neq' => OS_CANCELED),
        //         'p.pay_code' => array('neq' => 'pay_cod'),
        //     );
        //     $order = array('add_time' =>DESC );
        // } elseif($status == 'unshipped') {
        //     $where[] = '( p.pay_code = "pay_cod" OR pay_status = "2" )';
        //     $where[] .= '(shipping_status = 0 OR shipping_status = 3 OR shipping_status = 5)';
        //     $where['order_status'] = array('neq' => OS_CANCELED);
        //     $order = array('order_id' =>DESC );
        // } elseif($status == 'confiroed') {
        //     $where = array(
        //         'shipping_status' 	=> 1,
        //         'order_status' => array('neq' => OS_CANCELED),
        //     );
        //     $order = array('shipping_time' =>DESC );
        // } elseif($status == 'success_order') {
        //     $where = array(
        //         'pay_status'		=> PS_PAYED,
        //         'order_status' => array('neq' => OS_CANCELED),
        //         'shipping_status'	=> SS_RECEIVED
        //     );
        //     $order = array('confirm_time' => DESC);
        // }
        // $where['user_id'] = $_SESSION['user_id'];
        // $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        // $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        // $orders = get_user_orders($where, $size, $page, $order);
        // ecjia_front::$controller->assign('order', $orders['list']);
//         ecjia_front::$controller->assign_lang();
        // $sayList = ecjia_front::$controller->fetch('user_order_list.dwt');
        // ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page' , 'is_last' => $orders['is_last']));
        
        
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        
        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'pagination' => array('count' => $size, 'page' => $page), 'type' => '');
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_LIST)->data($params_order)
        ->send()->getBody();
        $data = json_decode($data, true);
        
        ecjia_front::$controller->assign('order_list', $data['data']);
        ecjia_front::$controller->assign_lang();
        $sayList = ecjia_front::$controller->fetch('user_order_list.dwt');
        return ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList, 'page', 'is_last' => $data['paginated']['more'] ? 0 : 1));
    }

    /**
    * 确认收货
    */
    public static function affirm_received() {
        // $user_id = $_SESSION['user_id'];
        // $order_id = intval($_GET['order_id']);
        // $arr = affirm($order_id, $user_id);
        // if (!empty($arr)) {
        //     if ($arr['error'] == 1) {
        //         ecjia_front::$controller->showmessage($arr['message'],ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        //     } else {
        //         ecjia_front::$controller->showmessage($arr['message'],ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON,array('pjaxurl' =>   RC_Uri::url('user/user_order/order_list&status='.success_order),'is_show' => false));
        //     }
        // } else {
        //     ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON , array('pjax'=>RC_Uri::url('order_list'), 'is_show' => false));
        // }
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (empty($order_id)) {
            return ecjia_front::$controller->showmessage('订单不存在', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
        
        $params_order = array('token' => ecjia_touch_user::singleton()->getToken(), 'order_id' => $order_id);
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_AFFIRMRECEIVED)->data($params_order)
        ->send()->getBody();
        $data = json_decode($data,true);
        if (isset($_GET['from']) && $_GET['from'] == 'list') {
            $url = RC_Uri::url('user/user_order/order_list');
        } else {
            $url = RC_Uri::url('user/user_order/order_detail', array('order_id' => $order_id));
        }
        if ($data['status']['succeed']) {
//             return ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_ALERT, array('pjaxurl' => $url,'is_show' => false));
            return ecjia_front::$controller->redirect($url);
        } else {
            return ecjia_front::$controller->showmessage($data['status']['error_desc'], ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => $url));
        }
    }

    /**
    * 更改支付方式的处理
    */
    public static function edit_payment() {
        // // $db_order_info = RC_Loader::load_app_model ( "order_info_model" );
        // RC_Loader::load_theme('extras/model/user/user_order_info_model.class.php');
        // $db_order_info       = new user_order_info_model();
        // /*检查支付方式*/
        // $pay_id = intval($_POST['pay_id']);
        // if ($pay_id <= 0) {
        //     ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON , array('pjax'=>RC_Uri::url('index/init')));
        // }
        // $payment_method = RC_Loader::load_app_class('payment_method','payment');
        // $payment_info = $payment_method->payment_info_by_id($pay_id);
        // if (empty($payment_info)) {
        //     ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON , array('pjax'=>RC_Uri::url('index/init')));
        // }
        // /*检查订单号*/
        // $order_id = intval($_POST['order_id']);
        // if ($order_id <= 0) {
        //     ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON , array('pjax'=>RC_Uri::url('index/init')));
        // }
        // /*取得订单*/
        // $order = order_info($order_id);
        // if (empty($order)) {
        //     ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON , array('pjax'=>RC_Uri::url('index/init')));
        // }
        // /*检查订单用户跟当前用户是否一致*/
        // if ($_SESSION['user_id'] != $order['user_id']) {
        //     ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON , array('pjax'=>RC_Uri::url('index/init')));
        // }
        // /*检查订单是否未付款和未发货 以及订单金额是否为0 和支付id是否为改变*/
        // if ($order['pay_status'] != PS_UNPAYED || $order['shipping_status'] != SS_UNSHIPPED || $order['goods_amount'] <= 0 || $order['pay_id'] == $pay_id) {
        //     $url = RC_Uri::url('order_detail', array(
        //         'order_id' => $order_id
        //     ));
        //     ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON , array('pjax'=>RC_Uri::url('index/init')));
        // }
        // $order_amount = $order['order_amount'] - $order['pay_fee'];
        // $pay_fee = pay_fee($pay_id, $order_amount);
        // $order_amount += $pay_fee;
        // $data['pay_id']         = $pay_id;
        // $data['pay_name']       = $payment_info['pay_name'];
        // $data['pay_fee']        = $pay_fee;
        // $data['order_amount']   = $order_amount;
        // $db_order_info->data($data)->where(array('order_id' => $order_id))->update();
        // $url = RC_Uri::url('order_detail', array('order_id' => $order_id));
        // ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON , array('pjax'=>$url));
    }

    /**
    * 编辑使用余额支付的处理
    */
    public static function edit_surplus() {
        /*检查订单号*/
        // $order_id = intval($_POST['order_id']);
        // $error  = new ecjia_error();
        // if ($order_id <= 0) {
        //     ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON , array('pjax'=>RC_Uri::url('index/init')));
        // }
        // /*检查余额*/
        // $surplus = floatval($_POST['surplus']);
        // if ($surplus <= 0) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('order_detail'),ecjia::MSGSTAT_ERROR |ecjia::MSGTYPE_JSON);
        // }
        // /*取得订单order_id*/
        // $order = order_info($order_id);
        // if (empty($order)) {
        //     ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON , array('pjax'=>RC_Uri::url('index/init')));
        // }
        // /*检查订单用户跟当前用户是否一致*/
        // if ($_SESSION['user_id'] != $order['user_id']) {
        //     ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON , array('pjax'=>RC_Uri::url('index/init')));
        // }
        // /*检查订单是否未付款，检查应付款金额是否大于0*/
        // if ($order['pay_status'] != PS_UNPAYED || $order['order_amount'] <= 0) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('order_detail'),ecjia::MSGSTAT_ERROR |ecjia::MSGTYPE_JSON);
        // }
        // /*计算应付款金额（减去支付费用）*/
        // $order['order_amount'] -= $order['pay_fee'];
        // /*余额是否超过了应付款金额，改为应付款金额*/
        // if ($surplus > $order['order_amount']) {
        //     $surplus = $order['order_amount'];
        // }
        // /*取得用户信息*/
        // $user = user_info($_SESSION['user_id']);
        // /*用户帐户余额是否足够*/
        // if ($surplus > $user['user_money'] + $user['credit_line']) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('order_detail'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR,    array('pjaxurl'=>RC_Uri::url('order_detail', array('order_id' => $order_id))));
        // }
        // /*修改订单，重新计算支付费用*/
        // $order['surplus'] += $surplus;
        // $order['order_amount'] -= $surplus;
        // if ($order['order_amount'] > 0) {
        //     $cod_fee = 0;
        //     if ($order['shipping_id'] > 0) {
        //         $regions = array(
        //             $order['country'],
        //             $order['province'],
        //             $order['city'],
        //             $order['district']
        //         );
        //         $shipping_method    = RC_Loader::load_app_class('shipping_method', 'shipping');
        //         $shipping           = $shipping_method->shipping_area_info($order['shipping_id'], $regions);
        //         if ($shipping['support_cod'] == '1') {
        //             $cod_fee = $shipping['pay_fee'];
        //         }
        //     }
        //     $pay_fee = 0;
        //     if ($order['pay_id'] > 0) {
        //         $pay_fee = pay_fee($order['pay_id'], $order['order_amount'], $cod_fee);
        //     }
        //     $order['pay_fee'] = $pay_fee;
        //     $order['order_amount'] += $pay_fee;
        // }
        // /*如果全部支付，设为已确认、已付款*/
        // if ($order['order_amount'] == 0) {
        //     if ($order['order_status'] == OS_UNCONFIRMED) {
        //         $order['order_status'] = OS_CONFIRMED;
        //         $order['confirm_time'] = RC_Time::gmtime();
        //     }
        //     $order['pay_status'] = PS_PAYED;
        //     $order['pay_time'] = RC_Time::gmtime();
        // }
        // update_order($order_id, $order);
        // /*更新用户余额*/
        // $change_desc = sprintf(RC_Lang::lang('pay_order_by_surplus'), $order['order_sn']);
        // log_account_change($user['user_id'], (- 1) * $surplus, 0, 0, 0, $change_desc);
        /*跳转*/
        // ecjia_front::$controller->showmessage('支付成功!', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('user/user_order/order_detail', array('order_id' => $order_id)),'is_show' => false));
    }

    /**
    * 订单跟踪
    */
    public static function order_tracking() {
        //TODO: 订单跟踪暂时不做
    }

}

// end
