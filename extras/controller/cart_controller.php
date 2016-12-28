<?php
/**
 * 购物车模块控制器代码
 */
class cart_controller {
    /**
     * 购物车列表
     */
    public static function init() {
    	$addr = $_GET['addr'];
    	$name = $_GET['name'];
    	$latng = explode(",", $_GET['latng']) ;
    	$longitude = !empty($latng[1]) ? $latng[1] : $_COOKIE['longitude'];
    	$latitude  = !empty($latng[0]) ? $latng[0] : $_COOKIE['latitude'];
    	
    	if(!empty($addr)){
    		setcookie("location_address", $addr);
        	setcookie("location_name", $name);
        	setcookie("longitude", $longitude);
        	setcookie("latitude", $latitude);
        	setcookie("location_address_id", 0);
    		ecjia_front::$controller->redirect(RC_Uri::url('cart/index/init'));
    	}
    	
    	$token = ecjia_touch_user::singleton()->getToken();
    	$arr = array(
    		'token' 	=> $token,
    		'location' 	=> array('longitude' => $longitude, 'latitude' => $latitude)
    	);
    	//店铺购物车商品
    	$cart_list = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($arr)->run();
    	if (!empty($cart_list['cart_list'])) {
    		foreach ($cart_list['cart_list'] as $k => $v) {
    			$cart_list['cart_list'][$k]['total']['check_all'] = true;
    			$cart_list['cart_list'][$k]['total']['check_one'] = false;
    			
    			if (!empty($v['goods_list'])) {
    				foreach ($v['goods_list'] as $key => $val) {
    					if ($val['is_checked'] == 0) {
    						$cart_list['cart_list'][$k]['total']['check_all'] = false;	//全部选择
    					} elseif ($val['is_disabled'] == 0) {
    						$cart_list['cart_list'][$k]['total']['check_one'] = true;	//至少选择了一个
    					}
    					
    					if ($val['is_disabled'] == 0 && $val['is_checked'] == 1) {
    						if ($key == 0) {
    							$cart_list['cart_list'][$k]['total']['data_rec'] = $val['rec_id'];
    						} else {
    							$cart_list['cart_list'][$k]['total']['data_rec'] .= ','.$val['rec_id'];
    						}
    					}
    					$cart_list['cart_list'][$k]['total']['data_rec'] = trim($cart_list['cart_list'][$k]['total']['data_rec'], ',');
    				}
    			}
    		}
    	}

    	ecjia_front::$controller->assign('cart_list', $cart_list['cart_list']);
    	ecjia_front::$controller->assign('referer_url', urlencode(RC_Uri::url('cart/index/init')));
    	
    	if (!ecjia_touch_user::singleton()->isSignin()) {
    		ecjia_front::$controller->assign('not_login', true);
    	}
    	
    	if (isset($_COOKIE['location_address_id']) && $_COOKIE['location_address_id'] > 0) {
    		ecjia_front::$controller->assign('address_id', $_COOKIE['location_address_id']);
    		$address_info = user_function::address_info(ecjia_touch_user::singleton()->getToken(), $_COOKIE['location_address_id']);
    		ecjia_front::$controller->assign('address_info', $address_info);
            ecjia_front::$controller->assign('address_id', $_COOKIE['location_address_id']);
    	}
    	
        ecjia_front::$controller->assign_lang();
    	ecjia_front::$controller->assign('active', 'cartList');
    	
    	ecjia_front::$controller->assign_title('购物车列表');
        ecjia_front::$controller->display('cart_list.dwt');
    }
    
    public static function update_cart() {
    	if (!ecjia_touch_user::singleton()->isSignin()) {
    		$url = RC_Uri::site_url() . substr($_SERVER['HTTP_REFERER'], strripos($_SERVER['HTTP_REFERER'], '/'));
    		$referer_url = RC_Uri::url('user/privilege/login', array('referer_url' => urlencode($url)));
    		return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('referer_url' => $referer_url));
    	}
    	 
    	$rec_id 	= is_array(($_POST['rec_id'])) ? $_POST['rec_id'] : $_POST['rec_id'];
    	$new_number = intval($_POST['val']);
    	$store_id 	= intval($_POST['store_id']);
    	$goods_id   = intval($_POST['goods_id']);
    	$checked	= isset($_POST['checked']) ? $_POST['checked'] : '';
    	$response   = isset($_POST['response']) ? true : false;
    
    	$token = ecjia_touch_user::singleton()->getToken();
    	$arr = array(
    		'token' 	=> $token,
    		'location' 	=> array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
    	);
    	if (!empty($store_id)) {
    		$arr['seller_id'] = $store_id;
    	}
    	//修改购物车中商品选中状态
    	if ($checked !== '') {
    		if (is_array($rec_id)) {
    			$arr['rec_id'] = implode(',', $rec_id);
    		} else {
    			$arr['rec_id'] = $rec_id;
    		}
    		$arr['is_checked'] = $checked;
    		ecjia_touch_manager::make()->api(ecjia_touch_api::CART_CHECKED)->data($arr)->run();
    	} else {
    		//清空购物车
    		if (is_array($rec_id)) {
    			$arr['rec_id'] = implode(',', $rec_id);
    			$data = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_DELETE)->data($arr)->run();
    
    			return ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON);
    		} else {
    			if (!empty($new_number)) {
    				$arr['new_number'] = $new_number;
    				if (!empty($rec_id)) {
    					//更新购物车中商品
    					$arr['rec_id'] = $rec_id;
    					$data = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_UPDATE)->data($arr)->send()->getBody();
    					$data = json_decode($data, true);
    					if ($data['status']['succeed'] == 0) {
    						return ecjia_front::$controller->showmessage($data['status']['error_desc'], ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    					}
    				} elseif (!empty($goods_id)) {
    					//添加商品到购物车
    					$arr['goods_id'] = $goods_id;
    					$data = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_CREATE)->data($arr)->send()->getBody();
    					$data = json_decode($data, true);
    					if ($data['status']['succeed'] == 0) {
    						return ecjia_front::$controller->showmessage($data['status']['error_desc'], ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    					}
    				}
    			} else {
    				if (!empty($rec_id)) {
    					//从购物车中删除商品
    					$arr['rec_id'] = $rec_id;
    					ecjia_touch_manager::make()->api(ecjia_touch_api::CART_DELETE)->data($arr)->run();
    				}
    			}
    		}
    	}
    	 
    	$paramater = array(
    		'token' 	=> $token,
    		'seller_id' => $store_id,
    		'location' 	=> array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude'])
    	);
    	 
    	//店铺购物车商品
    	$cart_list = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($paramater)->run();
    	$cart_goods_list = $cart_list['cart_list'][0]['goods_list'];
    	$cart_count = $cart_list['cart_list'][0]['total'];
    
    	$data_rec = '';
    	if (!empty($cart_goods_list)) {
    		foreach ($cart_goods_list as $k => $v) {
    			if ($v['is_disabled'] == 0 && $v['is_checked'] == 1) {
    				if ($k == 0) {
    					$data_rec = $v['rec_id'];
    				} else {
    					$data_rec .= ','.$v['rec_id'];
    				}
    			}
    		}
    		$data_rec = trim($data_rec, ',');
    	}
    	 
    	//购物车列表 切换状态直接返回
    	if ($response) {
    		return ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('count' => $cart_count, 'response' => $response, 'data_rec' => $data_rec));
    	}
    	 
    	$sayList = '';
    	if ($_POST['checked'] === '') {
    		ecjia_front::$controller->assign('list', $cart_goods_list);
    		$sayList = ecjia_front::$controller->fetch('merchant.dwt');
    	}
    
    	return ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('say_list' => $sayList, 'list' => $cart_goods_list, 'count' => $cart_count, 'data_rec' => $data_rec));
    }
    
    /**
     * 立即购买
     */
    public static function add_to_cart() {}
    /**
     * 点击刷新购物车
     */
    public static function ajax_update_cart() {}

    /**
     * 优惠活动（赠品）
     */
    public static function label_favourable() {
        /*取得优惠活动*/
        // // $favourable = RC_Loader::load_app_model('favourable_activity_model');
        // RC_Loader::load_theme('extras/model/cart/cart_favourable_activity_model.class.php');
        // $favourable       = new cart_favourable_activity_model();
        // $favourable_list = favourable_list_flow($_SESSION ['user_rank']);
        // usort($favourable_list, array("FlowModel", "cmp_favourable"));
        // ecjia_front::$controller->assign('favourable_list', $favourable_list);
        // ecjia_front::$controller->assign('step', 'label_favourable');
        // ecjia_front::$controller->assign('title', RC_Lang::lang('label_favourable'));
        // ecjia_front::$controller->assign_title(RC_Lang::lang('label_favourable'));
        // ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('cart_label_favourable.dwt');
    }


    /**
     *  把优惠活动赠品加入购物车
     */
    public static function add_favourable() {}

    /**
     * 删除购物车中的商品
     */
    public static function drop_goods() {}

    /**
     * 获取购物车内的相关配件
     */
    public static function goods_fittings() {}

    /**
     * 订单确认
     */
    public static function checkout() {
        
//         $_POST['address_id'] = 540;
//         $_POST['rec_id'] = '8466,8467,8468,8469';
        $address_id = empty($_REQUEST['address_id']) ? 0 : intval($_REQUEST['address_id']);
        $rec_id = empty($_REQUEST['rec_id']) ? 0 : trim($_REQUEST['rec_id']);
        
        $url = RC_Uri::site_url() . substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], '/'));
        
        $pjax_url = RC_Uri::url('cart/flow/checkout', array('address_id' => $address_id, 'rec_id' => $rec_id));
        if(empty($rec_id)) {
            return ecjia_front::$controller->showmessage('请选择商品再进行结算', ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        if (empty($address_id)) {
            return ecjia_front::$controller->showmessage('请选择收货地址', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        
        $params_cart = array(
            'token' => ecjia_touch_user::singleton()->getToken(),
            'address_id' => $address_id,
            'rec_id' => $rec_id,
            'location' => array(
                'longitude' => $_COOKIE['longitude'],
                'latitude' => $_COOKIE['latitude']
            ),
        );
        $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::FLOW_CHECKORDER)->data($params_cart)
        ->send()->getBody();
        $rs = json_decode($rs,true);
        if (! $rs['status']['succeed']) {
            $url = RC_Uri::url('cart/index/init');
            return ecjia_front::$controller->showmessage($rs['status']['error_desc'], ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT,array('pjaxurl' => $url));
        }
        //红包改键
        if ($rs['data']['bonus']) {
            $rs['data']['bonus'] = touch_function::change_array_key($rs['data']['bonus'], 'bonus_id');
        }
        if ($rs['data']['payment_list']) {
            $rs['data']['payment_list'] = touch_function::change_array_key($rs['data']['payment_list'], 'pay_id');
        }
        if ($rs['data']['shipping_list']) {
            $rs['data']['shipping_list'] = touch_function::change_array_key($rs['data']['shipping_list'], 'shipping_id');
        }
        $cart_key = md5($address_id.$rec_id);
        $_SESSION['cart'][$cart_key]['data'] = $rs['data'];
//         _dump($_SESSION,2);
        //支付方式
        $payment_id = 0;
        if ($_POST['payment_update']) {
            $payment_id = $_SESSION['cart'][$cart_key]['temp']['pay_id'] = empty($_POST['payment']) ? 0 : intval($_POST['payment']);
        } else {
            if (isset($_SESSION['cart'][$cart_key]['temp']['pay_id'])) {
                $payment_id = $_SESSION['cart'][$cart_key]['temp']['pay_id'];
            }
        }
        if ($payment_id) {
            $selected_payment = $_SESSION['cart'][$cart_key]['data']['payment_list'][$payment_id];
        } else {
            $selected_payment = array();
            if ($rs['data']['payment_list']) {
                foreach ($rs['data']['payment_list'] as $payment) {
                    $selected_payment = $payment;break;
                }
            }
        }
        
        //配送方式
        $shipping_id = 0;
        if ($_POST['shipping_update']) {
            $shipping_id = $_SESSION['cart'][$cart_key]['temp']['shipping_id'] = empty($_POST['shipping']) ? 0 : intval($_POST['shipping']);
        } else {
            if (isset($_SESSION['cart'][$cart_key]['temp']['shipping_id'])) {
                $shipping_id = $_SESSION['cart'][$cart_key]['temp']['shipping_id'];
            }
        }
        if ($shipping_id) {
            $selected_shipping = $_SESSION['cart'][$cart_key]['data']['shipping_list'][$shipping_id];
        } else {
            $selected_shipping = array();
            if ($rs['data']['shipping_list']) {
                foreach ($rs['data']['shipping_list'] as $tem_shipping) {
                    $selected_shipping = $tem_shipping;break;
                }
            }
        }
        if (isset($selected_shipping['shipping_date'])) {
            $selected_shipping['shipping_date_enable'] = 1;
        }
//         _dump($selected_shipping,1);
        //配送时间
        if ($_POST['shipping_date_update']) {
            $_SESSION['cart'][$cart_key]['temp']['shipping_date'] = empty($_POST['shipping_date']) ? '' : trim($_POST['shipping_date']);
            $_SESSION['cart'][$cart_key]['temp']['shipping_time'] = empty($_POST['shipping_time']) ? '' : trim($_POST['shipping_time']);
        } else {
            if ($selected_shipping['shipping_date_enable']) {
                $_SESSION['cart'][$cart_key]['temp']['shipping_date'] = $selected_shipping['shipping_date'][0]['date'];
                $_SESSION['cart'][$cart_key]['temp']['shipping_time'] = $selected_shipping['shipping_date'][0]['time'][0]['start_time'] . '-' . $selected_shipping['shipping_date'][0]['time'][0]['end_time'];
            }
        }
        
        //发票
        if ($_POST['inv_update']) {
            if (empty($_POST['inv_content']) || empty($_POST['inv_type']) || empty($_POST['inv_payee'])) {
                return ecjia_front::$controller->showmessage('请填写完整的发票信息', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => ''));
            }
            $_SESSION['cart'][$cart_key]['temp']['inv_payee'] = empty($_POST['inv_payee']) ? '' : trim($_POST['inv_payee']);
            $_SESSION['cart'][$cart_key]['temp']['inv_content'] = empty($_POST['inv_content']) ? '' : trim($_POST['inv_content']);
            $_SESSION['cart'][$cart_key]['temp']['inv_type'] = empty($_POST['inv_type']) ? '' : trim($_POST['inv_type']);
            $_SESSION['cart'][$cart_key]['temp']['need_inv'] = 1;
        }
        //发票清空
        if ($_POST['inv_clear']) {
            $_SESSION['cart'][$cart_key]['temp']['inv_payee'] = '';
            $_SESSION['cart'][$cart_key]['temp']['inv_content'] = '';
            $_SESSION['cart'][$cart_key]['temp']['inv_type'] = '';
            $_SESSION['cart'][$cart_key]['temp']['need_inv'] = 0;
        }
        
        //留言
        if ($_POST['note_update']) {
            $_SESSION['cart'][$cart_key]['temp']['note'] = empty($_POST['note']) ? '' : trim($_POST['note']);
        }
        //红包
        if ($_POST['bonus_update']) {
            $_SESSION['cart'][$cart_key]['temp']['bonus'] = empty($_POST['bonus']) ? '' : trim($_POST['bonus']);
        }
        //红包清空
        if ($_POST['bonus_clear']) {
            $_SESSION['cart'][$cart_key]['temp']['bonus'] = '';
        }
        
        //积分
        if ($_POST['integral_update']) {
            if ($_POST['integral'] >  $_SESSION['cart'][$cart_key]['data']['order_max_integral']) {
                return ecjia_front::$controller->showmessage('积分使用超出订单限制', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else if ($_POST['integral'] >  $_SESSION['cart'][$cart_key]['data']['your_integral']) {
                return ecjia_front::$controller->showmessage('积分不足', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            } else {
                $_SESSION['cart'][$cart_key]['temp']['integral'] = empty($_POST['integral']) ? 0 : intval($_POST['integral']);
                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $pjax_url));
            }
        }
        
        //total
        $total['goods_number'] = 0;
        $total['goods_price'] = 0;
        foreach ($rs['data']['goods_list'] as $item) {
            $total['goods_number'] += $item['goods_number'];
            $total['goods_price'] += $item['subtotal'];
        }
        $total['goods_price_formated'] = price_format($total['goods_price']);
        $total['shipping_fee'] = $selected_shipping['shipping_fee']; //$rs['data']['shipping_list'];
        $total['shipping_fee_formated'] = price_format($total['shipping_fee']);
        $total['discount_bonus'] = 0;
        if ($_SESSION['cart'][$cart_key]['temp']['bonus']) {
            $temp_bonus_id = $_SESSION['cart'][$cart_key]['temp']['bonus'];
            $total['discount_bonus'] = $_SESSION['cart'][$cart_key]['data']['bonus'][$temp_bonus_id]['bonus_amount'];
        }
        $total['discount_integral'] = 0;
        if ($_SESSION['cart'][$cart_key]['temp']['integral']) {
            $total['discount_integral'] = $_SESSION['cart'][$cart_key]['temp']['integral']/100;
        }

        $total['discount'] = $rs['data']['discount'] + $total['discount_bonus'] + $total['discount_integral'];//优惠金额 -红包 -积分
        $total['discount_formated'] = price_format($total['discount']);
        
        $total['pay_fee'] = $selected_payment['pay_fee']; 
        $total['pay_fee_formated'] = price_format($total['pay_fee']);
        $total['amount'] = $total['goods_price'] + $total['shipping_fee'] + $total['pay_fee'] - $total['discount']; 
        //发票税费
        $total['tax_fee'] = 0;
        if ($_SESSION['cart'][$cart_key]['temp']['inv_type']) {
            foreach ($_SESSION['cart'][$cart_key]['data']['inv_type_list'] as $type) {
                if ($type['label_value'] == $_SESSION['cart'][$cart_key]['temp']['inv_type']) {
                    $rate = floatval($type['rate']) / 100;
                    $total['tax_fee'] = $rate * $total['amount'];
                    break;
                }
            }
        }
        $total['tax_fee_formated'] = price_format($total['tax_fee']);
        $total['amount'] += $total['tax_fee'];
        $total['amount_formated'] = price_format($total['amount']);
//         _dump($total,2);
//         _dump($rs,2);
        ecjia_front::$controller->assign('data', $rs['data']);
        ecjia_front::$controller->assign('total_goods_number', $total['goods_number']);
        ecjia_front::$controller->assign('selected_payment', $selected_payment);
        ecjia_front::$controller->assign('selected_shipping', $selected_shipping);
        ecjia_front::$controller->assign('total', $total);
        ecjia_front::$controller->assign('address_id', $address_id);
        ecjia_front::$controller->assign('rec_id', $rec_id);
        ecjia_front::$controller->assign('temp', $_SESSION['cart'][$cart_key]['temp']);
        
        ecjia_front::$controller->assign('title', '结算');
        ecjia_front::$controller->assign_title('结算');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('flow_checkout.dwt');
    }

    //商品清单
    public static function goods_list() {
//         $_GET['address_id'] = 540;
//         $_GET['rec_id'] = '7223,7701,8025,8026,8027';
        $address_id = empty($_GET['address_id']) ? 0 : intval($_GET['address_id']);
        $rec_id = empty($_GET['rec_id']) ? 0 : trim($_GET['rec_id']);
        
        $url = RC_Uri::site_url() . substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], '/'));
        if(empty($rec_id)) {
            return ecjia_front::$controller->showmessage('请选择商品再进行结算', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        if (empty($address_id)) {
            return ecjia_front::$controller->showmessage('请选择收货地址', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        
        $params_cart = array(
            'token' => ecjia_touch_user::singleton()->getToken(),
            'address_id' => $address_id,
            'rec_id' => $rec_id,
            'location' => array(
                'longitude' => $_COOKIE['longitude'],
                'latitude' => $_COOKIE['latitude']
            ),
        );
        $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::FLOW_CHECKORDER)->data($params_cart)
        ->send()->getBody();
        $rs = json_decode($rs,true);
        if (! $rs['status']['succeed']) {
            $url = '';
            return ecjia_front::$controller->showmessage($rs['status']['error_desc'], ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT,array('pjaxurl' => $url));
        }
        $total_goods_number = 0;
        foreach ($rs['data']['goods_list'] as $cart) {
            $total_goods_number += $cart['goods_number'];
        }
        _dump($rs,2);
        ecjia_front::$controller->assign('list', $rs['data']['goods_list']);
        ecjia_front::$controller->assign('total_goods_number', $total_goods_number);
        
        ecjia_front::$controller->assign('title', '商品清单');
        ecjia_front::$controller->assign_title('商品清单');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('flow_goodslist.dwt');
    }

    /**
     * 改变配送方式
     */
    public static function select_shipping() {}


    /**
     * 改变支付方式
     */
    public static function select_payment() {}


    /**
     *  提交订单
     */
    public static function done() {
    
            $address_id = empty($_POST['address_id']) ? 0 : intval($_POST['address_id']);
            $rec_id = empty($_POST['rec_id']) ? 0 : trim($_POST['rec_id']);
            $pay_id = empty($_POST['pay_id']) ? 0 : intval($_POST['pay_id']);
            $shipping_id = empty($_POST['shipping_id']) ? 0 : intval($_POST['shipping_id']);
            $shipping_date = empty($_POST['shipping_date']) ? '' : trim($_POST['shipping_date']);
            $shipping_time = empty($_POST['shipping_time']) ? '' : trim($_POST['shipping_time']);
            $inv_payee = empty($_POST['inv_payee']) ? '' : trim($_POST['inv_payee']);
            $inv_content = empty($_POST['inv_content']) ? '' : trim($_POST['inv_content']);
            $inv_type = empty($_POST['inv_type']) ? '' : trim($_POST['inv_type']);
            $need_inv = empty($_POST['need_inv']) ? '' : trim($_POST['need_inv']);
            $postscript = empty($_POST['note']) ? '' : trim($_POST['note']);
            $integral = empty($_POST['integral']) ? 0 : intval($_POST['integral']);
            $bonus = empty($_POST['bonus']) ? 0 : intval($_POST['bonus']);
            
//             RC_Logger::getlogger('debug')->info($_POST);
            if(empty($rec_id)) {
                return ecjia_front::$controller->showmessage('请选择商品再进行结算', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => ''));
            }
            if (empty($address_id)) {
                return ecjia_front::$controller->showmessage('请选择收货地址', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => ''));
            }
            
            $params = array(
                'token' => ecjia_touch_user::singleton()->getToken(),
                'address_id' => $address_id,
                'rec_id' => $rec_id,
                'shipping_id' => $shipping_id,
                'expect_shipping_time' => $shipping_date .' '. $shipping_time,
                'pay_id' => $pay_id,
                'inv_payee'		=> $inv_payee,
                'inv_type'		=> $inv_type,
    			'inv_content'	=> $inv_content,
                'need_inv'      => $need_inv,
                'postscript' => $postscript,
                'integral' => $integral,
                'bonus' => $bonus,
                'location' => array(
                    'longitude' => $_COOKIE['longitude'],
                    'latitude' => $_COOKIE['latitude']
                ),
            );
//             _dump($params,1);
//             RC_Logger::getlogger('debug')->info($params);
            $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::FLOW_DONE)->data($params)
            ->send()->getBody();
            $rs = json_decode($rs,true);
//             RC_Logger::getlogger('debug')->info($rs);
            if (! $rs['status']['succeed']) {
                $url = RC_Uri::url('cart/flow/checkout');
                return ecjia_front::$controller->showmessage($rs['status']['error_desc'], ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => $url));
            }
//             RC_Logger::getlogger('debug')->info($rs);
//             $_SESSION['cart']['order_info'][$rs['data']['order_id']] = $rs['data'];
            $order_id = $rs['data']['order_id'];
            ecjia_front::$controller->redirect(RC_Uri::url('pay/index/init', array('order_id' => $order_id, 'tips_show' => 1)));
    }

    /**
     * 获取配送地址列表
     */
    public static function consignee_list() {}

	/**
	 * 异步加载收货地址
	 */
	public static function async_addres_list(){}
    /**
     * 收货信息
     */
    public static function consignee() {}

    /**
     * 修改收货信息的方法
     */
    public static function update_consignee() {}

    /**
     *
     * 删除收货人信息
     *
     */
    public static function drop_consignee() {}

    /**
     * 改变余额
     */
    public static function change_surplus() {}

    /**
     * 改变积分
     */
    public static function change_integral() {}

    /**
     * 改变红包
     */
    public static function change_bonus() {}

    /**
     * 改变发票的设置
     */
    public static function change_needinv() {}

    /**
     * 检查用户输入的余额
     */
    public static function check_surplus() {}

    /**
     * 检查用户输入的余额
     */
    public static function check_integral() {}


    /**
     *  验证红包序列号
     */
    public static function validate_bonus() {}

    /**
     * 改变配送地址
     */
    public static function select_address() {}

    /**
     * 改变支付方式
     */
    public static function pay() {
        $address_id = empty($_GET['address_id']) ? 0 : intval($_GET['address_id']);
        $rec_id = empty($_GET['rec_id']) ? 0 : trim($_GET['rec_id']);
        
        $url = RC_Uri::site_url() . substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], '/'));
        if(empty($rec_id)) {
            ecjia_front::$controller->showmessage('请选择商品再进行结算', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        if (empty($address_id)) {
            ecjia_front::$controller->showmessage('请选择收货地址', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        
        $cart_key = md5($address_id.$rec_id);
        $data = $_SESSION['cart'][$cart_key]['data'];
//         _dump($_SESSION['cart'],2);
        //分离线上支付线下支付
        $format_payment_list['online'] = array();
        $format_payment_list['offline'] = array();
        if ($data['payment_list']) {
            foreach ($data['payment_list'] as $tem_payment) {
                if ($tem_payment['is_online'] == 1) {
                    $format_payment_list['online'][$tem_payment['pay_id']] = $tem_payment;
                } else {
                    $format_payment_list['offline'][$tem_payment['pay_id']] = $tem_payment;
                }
            }
        }
        
        ecjia_front::$controller->assign('payment_list', $format_payment_list);
        ecjia_front::$controller->assign('address_id', $address_id);
        ecjia_front::$controller->assign('rec_id', $rec_id);
        ecjia_front::$controller->assign_lang();
        
        ecjia_front::$controller->assign('title', RC_Lang::lang('payment_method'));
        ecjia_front::$controller->assign_title(RC_Lang::lang('payment_method'));
        ecjia_front::$controller->display('flow_pay.dwt');
    }

    /**
     * 改变配送方式
     */
    public static function shipping() {
        
        $address_id = empty($_GET['address_id']) ? 0 : intval($_GET['address_id']);
        $rec_id = empty($_GET['rec_id']) ? 0 : trim($_GET['rec_id']);
        
        $url = RC_Uri::site_url() . substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], '/'));
        if(empty($rec_id)) {
            ecjia_front::$controller->showmessage('请选择商品再进行结算', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        if (empty($address_id)) {
            ecjia_front::$controller->showmessage('请选择收货地址', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        
        $cart_key = md5($address_id.$rec_id);
        $data = $_SESSION['cart'][$cart_key]['data'];
        _dump($_SESSION['cart'],2);
        ecjia_front::$controller->assign('shipping_list', $data['shipping_list']);
        ecjia_front::$controller->assign('address_id', $address_id);
        ecjia_front::$controller->assign('rec_id', $rec_id);
        
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->assign('title', RC_Lang::lang('shipping_method'));
        ecjia_front::$controller->assign_title(RC_Lang::lang('shipping_method'));
        ecjia_front::$controller->display('flow_shipping.dwt');
    }
    
    public static function shipping_date() {
        $address_id = empty($_GET['address_id']) ? 0 : intval($_GET['address_id']);
        $rec_id = empty($_GET['rec_id']) ? 0 : trim($_GET['rec_id']);
        
        if(empty($rec_id)) {
            ecjia_front::$controller->showmessage('请选择商品再进行结算', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => ''));
        }
        if (empty($address_id)) {
            ecjia_front::$controller->showmessage('请选择收货地址', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => ''));
        }
        
        $cart_key = md5($address_id.$rec_id);
        $data = $_SESSION['cart'][$cart_key]['data'];
//         _dump($_SESSION['cart'],2);
        _dump($data['shipping_list'][$_SESSION['cart'][$cart_key]['temp']['shipping_id']],2);

        $shipping = $data['shipping_list'][$_SESSION['cart'][$cart_key]['temp']['shipping_id']];
        if ($shipping['shipping_date']) {
            $shipping['shipping_date'] = touch_function::change_array_key($shipping['shipping_date'], 'date');
        }
//         _dump($shipping,1);
        ecjia_front::$controller->assign('shipping', $shipping);
        ecjia_front::$controller->assign('address_id', $address_id);
        ecjia_front::$controller->assign('rec_id', $rec_id);
        ecjia_front::$controller->assign('temp', $_SESSION['cart'][$cart_key]['temp']);
        
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->assign('title', '配送时间');
        ecjia_front::$controller->assign_title('配送时间');
        ecjia_front::$controller->display('flow_shipping_date.dwt');
    }

    /**
     * 开发票
     */
    public static function invoice() {

        $address_id = empty($_GET['address_id']) ? 0 : intval($_GET['address_id']);
        $rec_id = empty($_GET['rec_id']) ? 0 : trim($_GET['rec_id']);
        
        $url = RC_Uri::site_url() . substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], '/'));
        if(empty($rec_id)) {
            ecjia_front::$controller->showmessage('请选择商品再进行结算', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        if (empty($address_id)) {
            ecjia_front::$controller->showmessage('请选择收货地址', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        
        $cart_key = md5($address_id.$rec_id);
        $data = $_SESSION['cart'][$cart_key]['data'];
        $temp = $_SESSION['cart'][$cart_key]['temp'];
//         _dump($data,2);
        ecjia_front::$controller->assign('inv_content_list', $data['inv_content_list']);
        ecjia_front::$controller->assign('inv_type_list', $data['inv_type_list']);
        ecjia_front::$controller->assign('temp', $temp);
        unset($data);unset($temp);
        ecjia_front::$controller->assign('address_id', $address_id);
        ecjia_front::$controller->assign('rec_id', $rec_id);
        
        ecjia_front::$controller->assign('title', RC_Lang::lang('invoice'));
        ecjia_front::$controller->assign_title(RC_Lang::lang('invoice'));
        ecjia_front::$controller->display('flow_invoice.dwt');
    }

    /**
     * 增加订单留言
     */
    public static function note() {
        
        $address_id = empty($_GET['address_id']) ? 0 : intval($_GET['address_id']);
        $rec_id = empty($_GET['rec_id']) ? 0 : trim($_GET['rec_id']);
        
        $url = RC_Uri::site_url() . substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], '/'));
        if(empty($rec_id)) {
            ecjia_front::$controller->showmessage('请选择商品再进行结算', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        if (empty($address_id)) {
            ecjia_front::$controller->showmessage('请选择收货地址', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        
        $cart_key = md5($address_id.$rec_id);
        $data = $_SESSION['cart'][$cart_key]['temp'];
        ecjia_front::$controller->assign('note', $data['note']);
        ecjia_front::$controller->assign('address_id', $address_id);
        ecjia_front::$controller->assign('rec_id', $rec_id);

        ecjia_front::$controller->assign('title', '备注留言');
        ecjia_front::$controller->assign_title('备注留言');
        ecjia_front::$controller->display('flow_note.dwt');
    }

    /**
     * 选择使用红包
     */
    public static function bonus() {
        $address_id = empty($_GET['address_id']) ? 0 : intval($_GET['address_id']);
        $rec_id = empty($_GET['rec_id']) ? 0 : trim($_GET['rec_id']);
        
        $url = RC_Uri::site_url() . substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], '/'));
        if(empty($rec_id)) {
            return ecjia_front::$controller->showmessage('请选择商品再进行结算', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => ''));
        }
        if (empty($address_id)) {
            return ecjia_front::$controller->showmessage('请选择收货地址', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => ''));
        }
        
        $cart_key = md5($address_id.$rec_id);
        $data = $_SESSION['cart'][$cart_key]['data'];
        if ($data['allow_use_bonus'] == 0) {
            return ecjia_front::$controller->showmessage('红包不可用', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => ''));
        }
        ecjia_front::$controller->assign('data', $data);
        ecjia_front::$controller->assign('temp', $_SESSION['cart'][$cart_key]['temp']);
        ecjia_front::$controller->assign('address_id', $address_id);
        ecjia_front::$controller->assign('rec_id', $rec_id);
        
        ecjia_front::$controller->assign('title', RC_Lang::lang('use_bonus'));
        ecjia_front::$controller->assign_title(RC_Lang::lang('use_bonus'));
        ecjia_front::$controller->display('flow_bonus.dwt');
    }

    /**
     * 使用积分
     */
    public static function integral() {
        $address_id = empty($_GET['address_id']) ? 0 : intval($_GET['address_id']);
        $rec_id = empty($_GET['rec_id']) ? 0 : trim($_GET['rec_id']);
        
        $url = RC_Uri::site_url() . substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], '/'));
        if(empty($rec_id)) {
            return ecjia_front::$controller->showmessage('请选择商品再进行结算', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => ''));
        }
        if (empty($address_id)) {
            return ecjia_front::$controller->showmessage('请选择收货地址', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => ''));
        }
        
        $cart_key = md5($address_id.$rec_id);
        $data = $_SESSION['cart'][$cart_key]['data'];
        if ($data['order_max_integral'] == 0) {
            return ecjia_front::$controller->showmessage('积分不可用', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => ''));
        }
        ecjia_front::$controller->assign('data', $data);
        ecjia_front::$controller->assign('temp', $_SESSION['cart'][$cart_key]['temp']);
        ecjia_front::$controller->assign('address_id', $address_id);
        ecjia_front::$controller->assign('rec_id', $rec_id);
        
//         ecjia_front::$controller->assign('title', RC_Lang::lang('use_integral'));
        ecjia_front::$controller->assign_title(RC_Lang::lang('use_integral'));
        ecjia_front::$controller->display('flow_integral.dwt');
    }

}


// end
