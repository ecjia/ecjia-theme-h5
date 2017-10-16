<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 闪惠模块控制器代码
 */
class quickpay_controller {

    /**
     * 闪惠模块
     */
    public static function quickpay_list() {
    	$token = ecjia_touch_user::singleton()->getToken();
    	$param = array('token' => $token, 'pagination' => array('count' => 10, 'page' => 1));
    	 
    	$data = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_ORDER_LIST)->data($param)->run();
    	$data = is_ecjia_error($data) ? array() : $data;
    	ecjia_front::$controller->assign('order_list', $data);
    	
        ecjia_front::$controller->assign_title('我的买单');
        ecjia_front::$controller->display('quickpay_list.dwt');
    }
    
    /**
     * 闪惠列表异步
     */
    public static function async_quickpay_list() {
    	$size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
    	$pages = intval($_GET['page']) ? intval($_GET['page']) : 1;
    	
    	$param = array('token' => ecjia_touch_user::singleton()->getToken(), 'pagination' => array('count' => $size, 'page' => $pages));
    	$data = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_ORDER_LIST)->data($param)->hasPage()->run();
    	if (!is_ecjia_error($data)) {
    		list($orders, $page) = $data;
    		if (isset($page['more']) && $page['more'] == 0) $is_last = 1;
    		$say_list = '';
    		if (!empty($orders)) {
    			ecjia_front::$controller->assign('data', $orders);
    			ecjia_front::$controller->assign_lang();
    			$say_list = ecjia_front::$controller->fetch('quickpay_list.dwt');
    		}
    		return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $is_last));
    	}
    }
    
    public static function quickpay_detail() {
    	$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
    	
    	$params_order = array('token' => $token, 'order_id' => $order_id);
    	$data = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_ORDER_DETAIL)->data($params_order)->run();
		if (!is_ecjia_error($data)) {
			if (!empty($data)) {
				if (cart_function::is_weixin() == true) {
					if ($data['pay_code'] == 'pay_alipay') {
						unset($data['pay_code']);
					}
				} else {
					if ($data['pay_code'] == 'pay_wxpay') {
						unset($data['pay_code']);
					}
				}
			}
			ecjia_front::$controller->assign('data', $data);
		}
    	ecjia_front::$controller->assign_title('买单详情');
        ecjia_front::$controller->display('quickpay_detail.dwt');
    }
    
    
    public static function checkout() {
        $token = ecjia_touch_user::singleton()->getToken();
        
        $city_id = !empty($_COOKIE['city_id']) ? $_COOKIE['city_id'] : '';
        $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        ecjia_front::$controller->assign('store_id', $store_id);
        
        //红包
        if ($_POST['bonus_update']) {
        	$_SESSION['quick_pay']['temp']['bonus'] = $_POST['bonus'];
        }
        //红包清空
        if ($_POST['bonus_clear']) {
        	unset($_SESSION['quick_pay']['temp']['bonus']);
        }
        
        //积分
        if ($_POST['integral_update']) {
        	if ($_POST['integral'] >  $_SESSION['quick_pay']['data']['order_max_integral']) {
        		return ecjia_front::$controller->showmessage('积分使用超出订单限制', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        	} else if ($_POST['integral'] >  $_SESSION['quick_pay']['data']['user_integral']) {
        		return ecjia_front::$controller->showmessage('积分不足', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        	} else {
        		if ($_POST['integral_clear']) {
        			unset($_SESSION['quick_pay']['temp']['integral']);
        		} else {
        			$_SESSION['quick_pay']['temp']['integral'] = empty($_POST['integral']) ? 0 : intval($_POST['integral']);
        			if (!empty($_POST['integral'])) {
        				$params_integral = array('token' => $token, 'integral' => $_POST['integral']);
        				$data_integral = ecjia_touch_manager::make()->api(ecjia_touch_api::VALIDATE_INTEGRAL)->data($params_integral)->run();
        				$_SESSION['quick_pay']['temp']['integral_bonus'] = $data_integral['bonus'];
        			}
        		}
        	}
        }

        if (!empty($_SESSION['quick_pay'])) {
        	$_SESSION['quick_pay']['data']['bonus_list'] = touch_function::change_array_key($_SESSION['quick_pay']['data']['bonus_list'], 'bonus_id');
        	ecjia_front::$controller->assign('data', $_SESSION['quick_pay']['data']);
        	ecjia_front::$controller->assign('temp', $_SESSION['quick_pay']['temp']);
        	$data = $_SESSION['quick_pay']['data'];
        	$temp = $_SESSION['quick_pay']['temp'];
        	
        	$total_fee = $data['goods_amount']-$data['exclude_amount']-$data['discount']-($temp['integral']/100)-$data['bonus_list'][$temp['bonus']]['type_money'];
        	if ($total_fee < 0) {
        		$total_fee = 0;
        	}
        	ecjia_front::$controller->assign('total_fee', $total_fee);
        }
        ecjia_front::$controller->assign_title('优惠买单');
        ecjia_front::$controller->display('quickpay_checkout.dwt');
    }
    
    public static function flow_checkorder() {
    	$order_money = !empty($_POST['order_money']) ? $_POST['order_money'] : 0;
    	$drop_out_money = !empty($_POST['drop_out_money']) ? $_POST['drop_out_money'] : 0;
    	$store_id = !empty($_POST['store_id']) ? intval($_POST['store_id']) : 0;
    	if (!empty($order_money) && !empty($store_id)) {
    		$param = array(
    			'token' 		=> $token,
    			'store_id'		=> $store_id,
    			'goods_amount'	=> $order_money,
    			'exclude_amount'=> $drop_out_money
    		);
    		$_SESSION['quick_pay']['goods_amount'] = $order_money;
    		$_SESSION['quick_pay']['exclude_amount'] = $drop_out_money;
    		$data = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_FLOW_CHECKORDER)->data($param)->run();
    		if (!is_ecjia_error($data)) {
    			/*根据浏览器过滤支付方式，微信自带浏览器过滤掉支付宝支付，其他浏览器过滤掉微信支付*/
    			if (!empty($data['payment_list'])) {
    				if (cart_function::is_weixin() == true) {
    					foreach ($data['payment_list'] as $key => $val) {
    						if ($val['pay_code'] == 'pay_alipay') {
    							unset($data['payment_list'][$key]);
    						}
    					}
    				} else {
    					foreach ($data['payment_list'] as $key => $val) {
    						if ($val['pay_code'] == 'pay_wxpay') {
    							unset($data['payment_list'][$key]);
    						}
    					}
    				}
    			}
    			$_SESSION['quick_pay']['data'] = $data;
    			unset($_SESSION['quick_pay']['temp']);
    			ecjia_front::$controller->assign('data', $data);
    			$total_fee = $data['goods_amount']-$data['exclude_amount']-$data['discount'];
    			if ($total_fee < 0) {
    				$total_fee = 0;
    			}
    			ecjia_front::$controller->assign('total_fee', $total_fee);
    			ecjia_front::$controller->assign('store_id', $store_id);
    			$say_list = ecjia_front::$controller->fetch('quickpay_checkout.dwt');
    			return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'content' => $data));
    		}
    	}
    }
    
    public static function explain() {
    	$store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
    	$param = array('store_id' => $store_id, 'pagination' => array('count' => 10, 'page' => 1));
    	
    	$cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING'].'-'.$store_id));
    	if (!ecjia_front::$controller->is_cached('quickpay_explain.dwt', $cache_id)) {
    		$data = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_ACTIVIRY_LIST)->data($param)->run();
    		ecjia_front::$controller->assign('data', $data);
    	}
        ecjia_front::$controller->display('quickpay_explain.dwt', $cache_id);
    }
    
    public static function bonus() {
    	$store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
    	ecjia_front::$controller->assign('store_id', $store_id);

    	if (!empty($_SESSION['quick_pay'])) {
    		ecjia_front::$controller->assign('temp', $_SESSION['quick_pay']['temp']);
    		ecjia_front::$controller->assign('data', $_SESSION['quick_pay']['data']);
    	}
        ecjia_front::$controller->display('quickpay_bonus.dwt', $cache_id);
    }
    
    public static function integral() {
    	$store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
    	ecjia_front::$controller->assign('store_id', $store_id);
    	
    	if (!empty($_SESSION['quick_pay'])) {
    		ecjia_front::$controller->assign('temp', $_SESSION['quick_pay']['temp']);
    		ecjia_front::$controller->assign('data', $_SESSION['quick_pay']['data']);
    	}
        ecjia_front::$controller->display('quickpay_integral.dwt', $cache_id);
    }
    
    public static function notify() {
        ecjia_front::$controller->display('quickpay_notify.dwt', $cache_id);
    }
    
    public static function payment() {
    	$val = !empty($_POST['val']) ? intval($_POST['val']) : 0;
    	$_SESSION['quick_pay']['temp']['payment_id'] = $val;
    }
    
    public static function done() {
    	$token = ecjia_touch_user::singleton()->getToken();
    	$store_id = !empty($_POST['store_id']) ? intval($_POST['store_id']) : 0;
    	
    	$goods_amount = !empty($_POST['order_money']) ? $_POST['order_money'] : 0;
    	if (empty($goods_amount)) {
    		return ecjia_front::$controller->showmessage('订单金额不能为空', ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
    	}
    	$exclude_amount = !empty($_POST['drop_out_money']) ? $_POST['drop_out_money'] : 0;
    	$activity_id = !empty($_POST['activity_id']) ? intval($_POST['activity_id']) : 0;
    	$bonus_id = !empty($_POST['bonus']) ? intval($_POST['bonus']) : 0;
    	$integral = !empty($_POST['integral']) ? intval($_POST['integral']) : 0;
    	$pay_id = !empty($_POST['payment_id']) ? intval($_POST['payment_id']) : 0;
    	
    	$params = array(
    		'token' 			=> $token, 
    		'store_id' 			=> $store_id, 
    		'goods_amount' 		=> $goods_amount, 
    		'exclude_amount' 	=> $exclude_amount, 
    		'activity_id' 		=> $activity_id,
    		'bonus_id'			=> $bonus_id,
    		'integral'			=> $integral,
    		'pay_id'			=> $pay_id
    	);
    	$rs = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_FLOW_DONE)->data($params)->run();
    	if (!is_ecjia_error($rs)) {
    		$order_id = $rs['order_id'];
    		ecjia_front::$controller->redirect(RC_Uri::url('user/quickpay/pay', array('order_id' => $order_id)));
    	} else {
    		return ecjia_front::$controller->showmessage($rs->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
    	}
    }
    
    public static function pay() {
    	$order_id = !empty($_GET['order_id']) ? intval($_GET['order_id']) : 0;
    	
    	if (empty($order_id)) {
    		return ecjia_front::$controller->showmessage('订单不存在', ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
    	}
    	
    	$token = ecjia_touch_user::singleton()->getToken();
    	/*获取订单信息*/
    	$params_order = array('token' => $token, 'order_id' => $order_id);
    	$detail = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_ORDER_DETAIL)->data($params_order)->run();
    	if (is_ecjia_error($detail)) {
    		return ecjia_front::$controller->showmessage($detail->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
    	}
    	
    	//支付方式信息
    	$payment_method = RC_Loader::load_app_class('payment_method', 'payment');
    	$payment_info = $payment_method->payment_info_by_code($detail['pay_code']);
    	
    	//获得订单支付信息
    	$params = array(
    		'token' 	=> $token,
    		'order_id'	=> $order_id,
    	);
    	if ($payment_info['pay_code'] == 'pay_wxpay') {
    		$handler = with(new Ecjia\App\Payment\PaymentPlugin)->channel($payment_info['pay_code']);
    		$open_id = $handler->get_open_id();
    		$params['wxpay_open_id'] = $open_id;
    	}
    	$rs_pay = ecjia_touch_manager::make()->api(ecjia_touch_api::QUICKPAY_ORDER_PAY)->data($params)->run();
    	RC_Logger::getlogger('info')->info($rs_pay);
    	
    	//微信支付$rs_pay返回空
    	if (is_ecjia_error($rs_pay)) {
    		return ecjia_front::$controller->showmessage($rs_pay->get_error_message(), ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
    	}
    	
    	if (isset($rs_pay) && $rs_pay['payment']['error_message']) {
    		return ecjia_front::$controller->showmessage($rs_pay['payment']['error_message'], ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
    	}
    	$order = $rs_pay['payment'];

    	$order_amount = ltrim($order['order_amount'], '￥');
    	$order_surplus = ltrim($order['order_surplus'], '￥');
    	$order_amount = !empty($order_amount) ? $order_amount : $order_surplus;

    	//生成返回url cookie
    	RC_Cookie::set('pay_response_index', RC_Uri::url('touch/index/init'));
    	RC_Cookie::set('pay_response_order', RC_Uri::url('user/quickpay/quickpay_detail', array('order_id' => $order_id)));

    	RC_Logger::getlogger('info')->info($order);
    	//免费商品直接余额支付
    	if ($detail['pay_code'] != 'pay_balance' && $order_amount !== 0) {
    		$pay_online = array_get($order, 'private_data.pay_online', array_get($order, 'pay_online'));
    		ecjia_front::$controller->redirect($pay_online);
    	} else {
    		$url = RC_Uri::url('user/quickpay/quickpay_detail', array('order_id' => $order_id));
    		ecjia_front::$controller->redirect($url);
    	}
    }
}

// end