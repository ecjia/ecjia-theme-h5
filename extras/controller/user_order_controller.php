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
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_LIST)->data($params_order)->run();
        
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
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ORDER_CANCEL)->data($params_order)->send()->getBody();
        $data = json_decode($data,true);

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
            return ecjia_front::$controller->redirect($url);
        } else {
            return ecjia_front::$controller->showmessage($data['status']['error_desc'], ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => $url));
        }
    }

    /**
    * 更改支付方式的处理
    */
    public static function edit_payment() {}

    /**
    * 编辑使用余额支付的处理
    */
    public static function edit_surplus() {}

    /**
    * 订单跟踪
    */
    public static function order_tracking() {}

}

// end