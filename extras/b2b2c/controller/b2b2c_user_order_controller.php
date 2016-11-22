<?php
/**
 * 收藏模块控制器代码
 * @author royalwang
 *
 */
class b2b2c_user_order_controller {

    /**
    * 获取全部订单
    */
    public static function order_list() {
        RC_Loader::load_theme('extras/b2b2c/functions/user/b2b2c_front_user_order.func.php');
        $status = empty($_GET['status']) ? 'unpayed' : $_GET['status'];
        if ($status == '' || $status == 'unpayed') {
            $where = array(
                'pay_status' => 0,
                'order_status' => array('neq' => OS_CANCELED),
                'p.pay_code' => array('neq' => 'pay_cod'),
            );
            $order = array('add_time' =>DESC );
        } elseif($status == 'unshipped') {
            $where[] = '( p.pay_code = "pay_cod" OR pay_status = "2" )';
            $where[] .= '(shipping_status = 0 OR shipping_status = 3 OR shipping_status = 5)';
            $where['order_status'] = array('neq' => OS_CANCELED);
            $order = array('order_id' =>DESC );
        } elseif($status == 'confiroed') {
            $where = array(
                'shipping_status'   => 1,
                'order_status' => array('neq' => OS_CANCELED),
            );
            $order = array('shipping_time' =>DESC );
        }elseif($status == 'success_order') {
            $where = array(
                'pay_status'        => PS_PAYED,
                'order_status' => array('neq' => OS_CANCELED),
                'shipping_status'   => SS_RECEIVED
            );
            $order = array('confirm_time' => DESC);
        }
        $where['user_id'] = $_SESSION['user_id'];
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $orders = get_orders_list($where, $size, $page, $order);
        ecjia_front::$controller->assign('title', RC_Lang::lang('order_list_lnk'));
        ecjia_front::$controller->assign('header_left', array('href' => RC_Uri::url('user/index/init')));
        ecjia_front::$controller->assign('order', $orders['list']);
        ecjia_front::$controller->assign('status', $status);
        ecjia_front::$controller->assign('page', $orders['page']);
        ecjia_front::$controller->assign_title(RC_Lang::lang('order_list_lnk'));
        ecjia_front::$controller->assign('header_left', array('href' => RC_Uri::url('user/index/init')));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_order_list.dwt');
    }

    /**
    * ajax获取订单
    */
    public static function async_order_list() {
        RC_Loader::load_theme('extras/b2b2c/functions/user/b2b2c_front_user_order.func.php');
        $status = $_GET['status'];
        if ($status == '' || $status == 'unpayed') {
            $where = array(
                'pay_status' => 0,
                'order_status' => array('neq' => OS_CANCELED),
                'p.pay_code' => array('neq' => 'pay_cod'),
            );
            $order = array('add_time' =>DESC );
        } elseif($status == 'unshipped') {
            $where[] = '( p.pay_code = "pay_cod" OR pay_status = "2" )';
            $where[] .= '(shipping_status = 0 OR shipping_status = 3 OR shipping_status = 5)';
            $where['order_status'] = array('neq' => OS_CANCELED);
            $order = array('order_id' =>DESC );
        } elseif($status == 'confiroed') {
            $where = array(
                'shipping_status'   => 1,
                'order_status' => array('neq' => OS_CANCELED),
            );
            $order = array('shipping_time' =>DESC );
        } elseif($status == 'success_order') {
            $where = array(
                'pay_status'        => PS_PAYED,
                'order_status' => array('neq' => OS_CANCELED),
                'shipping_status'   => SS_RECEIVED
            );
            $order = array('confirm_time' => DESC);
        }
        $where['user_id'] = $_SESSION['user_id'];
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $orders = get_orders_list($where, $size, $page, $order);
        ecjia_front::$controller->assign('order', $orders['list']);
        ecjia_front::$controller->assign_lang();
        $sayList = ecjia_front::$controller->fetch('user_order_list.dwt');
        ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page' , 'is_last' => $orders['is_last']));
    }

    /**
    * 订单详情
    */
    public static function order_detail() {
        RC_Loader::load_theme('extras/functions/user/front_user_order.func.php');
        RC_Loader::load_theme('extras/b2b2c/model/user/user_order_goods_viewmodel.class.php');
        $db_order_info_viewmodel = new user_order_goods_viewmodel();
        $user_id = $_SESSION['user_id'];
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        /*订单详情*/
        $order = get_order_detail($order_id, $user_id);
        if ( $order['pay_status'] == PS_UNPAYED && $order['pay_code'] != 'pay_cod' ) {
            /* 取得支付信息，生成支付代码 */
            if ($order ['order_amount'] > 0) {
                // RC_Loader::load_app_class('payment_abstract', 'payment', false);
                // $payment_method = RC_Loader::load_app_class('payment_method','payment');
                // $payment_info = $payment_method->payment_info_by_id($order ['pay_id']);
                // /*取得支付信息，生成支付代码*/
                // $payment_config = $payment_method->unserialize_config($payment_info['pay_config']);
                // $handler = $payment_method->get_payment_instance($payment_info['pay_code'], $payment_config);
                // $handler->set_orderinfo($order);
                // $handler->set_mobile(true);
                // /* 这是一个支付的抽象类 */
                // $pay_online = $handler->get_code(payment_abstract::PAYCODE_PARAM);
                
                RC_Loader::load_app_class('payment_abstract', 'payment', false);
                $payment_method = RC_Loader::load_app_class('payment_method','payment');
                $payment_info = $payment_method->payment_info_by_id($order ['pay_id']);
                /*取得支付信息，生成支付代码*/
                $payment_config = $payment_method->unserialize_config($payment_info['pay_config']);
                $handler = $payment_method->get_payment_instance($payment_info['pay_code'], $payment_config);
                $handler->set_orderinfo($order);
                /*未付款*/
                if ($payment_info['pay_code'] == 'pay_wxpay_wap') {
                    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') && !empty($_SESSION['openid'])) {
                        $pay_online = $handler->get_code(payment_abstract::PAYCODE_PARAM);
                        $order['handler'] = '<a class="nopjax btn btn-info nopjax" href="#" onclick="callpay()">去' . $payment_info['pay_name'] . '支付</a>'.$pay_online;
                    } else {
                        $order['handler'] = '<a class="btn btn-info nopjax disabled" href="javascript:;">' . $payment_info['pay_name'] . '无法使用</a>';
                    }
                } else {
                    $handler->set_mobile(true);
                    /* 这是一个支付的抽象类 */
                    $pay_online = $handler->get_code(payment_abstract::PAYCODE_PARAM);
                    $order['handler'] = '<a class="nopjax btn btn-info nopjax" href="' . $pay_online['pay_online'] . '">去' . $payment_info['pay_name'] . '支付</a>';
                }
            }
            /*未付款*/
            $order['handler'] = '<a class="nopjax btn btn-info nopjax " href="' . $pay_online['pay_online'] . '">去' . $payment_info['pay_name'] . '支付</a>';

            $order['handler_left'] = '<a class="nopjax cancel_order ecjiaf-fl btn" href="' . RC_Uri::url('user/user_order/cancel_order',array('order_id' => $order_id)). '">' .'取消订单</a>';

        } else {
            /* 对配送状态的处理 */
            if (($order['pay_status'] == PS_PAYED && ($order['shipping_status'] == SS_UNSHIPPED || $order['shipping_status'] == 3 || $order['shipping_status'] == 5)) || (($order['shipping_status'] == SS_UNSHIPPED || $order['shipping_status'] == 3 || $order['shipping_status'] == 5) && $order['pay_code'] == 'pay_cod') ) {
                /*未发货*/
                @$order['handler'] = "<a class=\"btn nopjax\">" .RC_Lang::lang('ss/' . $order['shipping_status'])."</a>";
            } elseif( $order['shipping_status'] == SS_SHIPPED ) {
                /*待收货*/
                @$order['handler'] = "<a class=\"btn nopjax\" href=\"" . RC_Uri::url('user_order/affirm_received', array('order_id' => $order['order_id'])) . "\" onclick=\"if (!confirm('" . RC_Lang::lang('confirm_received') . "')) return false;\">" . RC_Lang::lang('received') . "</a>";
            } elseif($order['pay_status'] == PS_PAYED && $order['shipping_status'] == SS_RECEIVED) {
                $order['handler'] =  "<a class=\"btn nopjax\">" .RC_Lang::lang('ss_received')."</a>";
            }
        }
        /*订单商品*/
        $goods_list = order_goods($order_id);
        foreach ($goods_list as $key => $value) {
            $goods_list[$key]['market_price'] = price_format($value['market_price'], false);
            $goods_list[$key]['goods_price'] = price_format($value['goods_price'], false);
            $goods_list[$key]['subtotal'] = price_format($value['subtotal'], false);
            $goods_list[$key]['tags'] = get_tags($value['goods_id']);
        }
        /*设置能否修改使用余额数*/
        if ($order['order_amount'] > 0) {
            if ($order['order_status'] == OS_UNCONFIRMED || $order['order_status'] == OS_CONFIRMED) {
                $user = user_info($order['user_id']);
                if ($user['user_money'] + $user['credit_line'] > 0) {
                    ecjia_front::$controller->assign('allow_edit_surplus', 1);
                    ecjia_front::$controller->assign('max_surplus', sprintf(RC_Lang::lang('max_surplus'), $user['user_money']));
                }
            }
        }
        /*未发货，未付款时允许更换支付方式*/
        if ($order['order_amount'] > 0 && $order['pay_status'] == PS_UNPAYED && $order['shipping_status'] == SS_UNSHIPPED) {
            $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
            $payment_list   = empty($payment_method) ? array() : $payment_method->available_payment_list(1, $cod_fee);
            // $payment_list = available_payment_list(false, 0, true);
            /*过滤掉当前支付方式和余额支付方式*/
            if (is_array($payment_list)) {
                foreach ($payment_list as $key => $payment) {
                    if ($payment['pay_id'] == $order['pay_id'] || $payment['pay_code'] == 'balance') {
                        unset($payment_list[$key]);
                    }
                }
            }
            ecjia_front::$controller->assign('payment_list', $payment_list);
        }
        $merchant = $db_order_info_viewmodel->join('merchants_shop_information')->field('shoprz_brandName, shopNameSuffix')->where(array('order_id' => $order_id))->find();
        $shop = $merchant['shoprz_brandName'].$merchant['shopNameSuffix'];
        $shop_name = empty($shop) ? '自营商品' : $merchant['shoprz_brandName'].$merchant['shopNameSuffix'];

        $order['pay_desc'] = html_out($order['pay_desc']);
        /*订单 支付 配送 状态语言项*/
        $order['order_status'] = RC_Lang::lang('os/' . $order['order_status']);
        $order['pay_status'] = RC_Lang::lang('ps/' . $order['pay_status']);
        $order['shipping_status'] = RC_Lang::lang('ss/' . $order['shipping_status']);
        ecjia_front::$controller->assign('title', RC_Lang::lang('order_detail'));
        ecjia_front::$controller->assign('order', $order);
        ecjia_front::$controller->assign('shop_name', $shop_name);
        ecjia_front::$controller->assign('goods_list', $goods_list);
        ecjia_front::$controller->assign_title(RC_Lang::lang('order_detail'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_order_detail.dwt');
    }
	
}

// end