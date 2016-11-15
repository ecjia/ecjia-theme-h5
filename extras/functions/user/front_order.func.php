<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 *  获取用户指定范围的订单列表
 */
function get_user_orders($where = 1, $num = 10, $page, $order) {
	// $db_order_info = RC_Loader::load_app_model ('order_info_viewmodel');
	 RC_Loader::load_theme('extras/model/user/user_order_info_viewmodel.class.php');
        $db_order_info       = new user_order_info_viewmodel();
	/* 取得订单列表 */
	$arr = array();
	$where = array_merge($where, array('user_id' => $_SESSION['user_id']));
	$field = 'oi.order_id, oi.order_sn, oi.shipping_id, p.pay_code, oi.order_status, oi.shipping_status, oi.pay_status, oi.add_time, (oi.goods_amount + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee + oi.tax - oi.discount)| total_fee, og.goods_name, SUM(og.goods_number) | goods_number, og.goods_price, og.goods_id';
	$count = $db_order_info->join(array('order_goods','payment'))->where($where)->count('distinct oi.order_id');
	$pages = new touch_page($count, $num, 6, '', $page);
	$res = $db_order_info->join(array('order_goods','payment'))->field($field)->where($where)->order($order)->group('oi.order_id')->limit($pages->limit())->select();
    if (!empty($res)) {
		foreach ($res as $key => $value) {
            if( $value['pay_status'] == PS_UNPAYED && $value['pay_code'] != 'pay_code'){
                //待付款
                $value['handler'] = "<a class='nopjax btn btn-default' href=\"" . RC_Uri::url('user_order/cancel_order', array('order_id' => $value['order_id'])) . "\" onclick=\"if (!confirm('" . RC_Lang::lang('confirm_cancel') . "')) return false;\">" . RC_Lang::lang('cancel') . "</a>";
            }elseif ($value['pay_status'] == PS_PAYED && $value['shipping_status'] == 1) {
                //待收货
                @$value['handler'] = "<a class='nopjax btn' href=\"" . RC_Uri::url('user_order/affirm_received', array('order_id' => $value['order_id'])) . "\" onclick=\"if (!confirm('" . RC_Lang::lang('confirm_received') . "')) return false;\">" . RC_Lang::lang('received') . "</a>";
            } elseif ($value['pay_status'] == PS_PAYED && $value['shipping_status'] == SS_RECEIVED ) {
                //已完成
                $value['handler'] = '<a class="nopjax btn " href="'.RC_Uri::url('goods/index/comment&id=').$value['goods_id'].'">去评论</a>';
            }
            if (($value['pay_status'] == 0 && $value['pay_code'] != 'pay_code')){
                //待付款
                $value['order_status'] =  RC_Lang::lang('ps/' . PS_UNPAYED);
            }elseif((($value['shipping_status'] == 0 || $value['shipping_status'] == 3 || $value['shipping_status'] == 5 ) && $value['pay_status'] == 2) || $value['pay_code'] == 'cod' && $value['shipping_status'] == 0 ) {
                //待发货
                $value['order_status'] =  RC_Lang::lang('ss/' . SS_UNSHIPPED);
            }elseif ($value['shipping_status'] == 1 ) {
                //待收货
                $value['order_status'] =  RC_Lang::lang('os/' . OS_UNCONFIRMED);
            } elseif ($value['pay_status'] == PS_PAYED && $value['shipping_status'] == SS_RECEIVED ) {
                //已完成
                $value['order_status'] = '已完成';
            }
			$arr[] = array(
				'order_id' => $value['order_id'],
				'order_sn' => $value['order_sn'],
				'img' => get_image_path(0, get_order_thumb($value['order_id'])),
				'order_time' => RC_Time::local_date('Y-m-d', $value['add_time']),
				'order_status' => $value['order_status'],
				'shipping_id' => $value['shipping_id'],
				'goods_name' => $value['goods_name'],
				'goods_number' => $value['goods_number'],
				'total_fee' => price_format($value['total_fee'], false),
				'url' => RC_Uri::url('user/order_detail', array('order_id' => $value['order_id'])),
				'handler' => $value['handler'],
				'order_price'=>order_info($value['order_id'], $value['order_sn']),
				'goods_price'=>$value['goods_price']
			);
		}
	}
	$is_last = $page >= $pages->total_pages ? 1 : 0;
	return array('list'=>$arr, 'page'=>$pages->show(5), 'desc'=>$pages->page_desc(), 'is_last'=>$is_last);
}

/**
 * 取消一个用户订单
 */
function cancel_orders ($order_id, $user_id = 0){
	// $db = RC_Loader::load_app_model('order_info_model');
	RC_Loader::load_theme('extras/model/user/user_order_info_model.class.php');
    $db       = new user_order_info_model();
	/* 查询订单信息，检查状态 */
	$order = $db->field('user_id, order_id, order_sn , surplus , integral , bonus_id, order_status, shipping_status, pay_status')->find(array('order_id' => $order_id));
	if (empty($order)) {
		return new ecjia_error('order_exist', RC_Lang::lang('order_exist'));
	}
	/* 如果用户ID大于0，检查订单是否属于该用户 */
	if ($user_id > 0 && $order['user_id'] != $user_id) {
		return new ecjia_error('no_priv', RC_Lang::lang('no_priv'));
	}
	/* 订单一旦确认，不允许用户取消 */
	if ($order['order_status'] == OS_CONFIRMED) {
		return new ecjia_error('current_os_already_confirmed', RC_Lang::lang('current_os_already_confirmed'));
	}
	/* 发货状态只能是“未发货” */
	if ($order['shipping_status'] != SS_UNSHIPPED) {
		return new ecjia_error('current_ss_not_cancel', RC_Lang::lang('current_ss_not_cancel'));
	}
	/* 如果付款状态是“已付款”、“付款中”，不允许取消，要取消和商家联系 */
	if ($order['pay_status'] != PS_UNPAYED) {
		return new ecjia_error('current_ps_not_cancel', RC_Lang::lang('current_ps_not_cancel'));
	}
	/* 将用户订单设置为取消 */
	$query = $db->where(array('order_id' => $order_id))->update(array('order_status' => OS_CANCELED));
	if ($query) {
		order_action($order['order_sn'], OS_CANCELED, $order['shipping_status'], PS_UNPAYED, RC_Lang::lang('buyer_cancel'), 'buyer');
		/* 退货用户余额、积分、红包 */
		if ($order['user_id'] > 0 && $order['surplus'] > 0) {
			$options = array(
				'user_id'		=> $order['user_id'],
				'user_money'	=> $order['surplus'],
				'change_desc'	=> sprintf(RC_Lang::lang('return_surplus_on_cancel'), $order['order_sn'])
			);
			$result = RC_Api::api('user', 'account_change_log',$options);
			if (is_ecjia_error($result)) {
				return $result;
			}
		}
		if ($order['user_id'] > 0 && $order['integral'] > 0) {
			$options = array(
					'user_id'		=> $order['user_id'],
					'pay_points'	=> $order['integral'],
					'change_desc'	=> sprintf(RC_Lang::lang('return_integral_on_cancel'), $order['order_sn'])
			);
			$result = RC_Api::api('user', 'account_change_log',$options);
			if (is_ecjia_error($result)) {
				return $result;
			}
		}
		if ($order['user_id'] > 0 && $order['bonus_id'] > 0) {
			//TODO:: 红包方法
			change_user_bonus($order['bonus_id'], $order['order_id'], false);
		}
		/* 如果使用库存，且下订单时减库存，则增加库存 */
		if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
			change_order_goods_storage($order['order_id'], false, 1);
		}
		/* 修改订单 */
		$arr = array(
			'bonus_id' => 0,
			'bonus' => 0,
			'integral' => 0,
			'integral_money' => 0,
			'surplus' => 0
		);
		update_order($order['order_id'], $arr);
		return true;
	} else {
		return new ecjia_error('database_query_error', $db->error());
	}
}

/**
 * 处理红包（下订单时设为使用，取消（无效，退货）订单时设为未使用
 * @param   int     $bonus_id   红包编号
 * @param   int     $order_id   订单号
 * @param   int     $is_used    是否使用了
 */
function change_user_bonus($bonus_id, $order_id, $is_used = true) {
	// $db_user_bonus_model = RC_Loader::load_app_model('user_bonus_model','user');
	RC_Loader::load_theme('extras/model/user/user_bonus_model.class.php');
    $db_user_bonus_model       = new user_bonus_model();
	if ($is_used) {
//		$sql = 'UPDATE ' . $this->pre . 'user_bonus SET ' .
//			'used_time = ' . gmtime() . ', ' .
//			"order_id = '$order_id' " .
//			"WHERE bonus_id = '$bonus_id'";
		$data = array('user_time' => RC_Time::gmtime(), 'order_id' => $order_id);
		$db_user_bonus_model->where(array('bonus_id' => $bonus_id))->update($data);
	} else {
//		$sql = 'UPDATE ' . $this->pre . 'user_bonus SET ' .
//			'used_time = 0, ' .
//			'order_id = 0 ' .
//			"WHERE bonus_id = '$bonus_id'";
		$data = array('user_time' => 0, 'order_id' => 0);
		$db_user_bonus_model->where(array('bonus_id' => $bonus_id))->update($data);
	}
}

/**
 * 记录订单操作记录
 */
function order_action($order_sn, $order_status, $shipping_status, $pay_status, $note = '', $username = null, $place = 0) {
	// $db_action = RC_Loader::load_app_model ( 'order_action_model' );
	RC_Loader::load_theme('extras/model/user/user_order_action_model.class.php');
    $db_action       = new user_order_action_model();
	// $db_info = RC_Loader::load_app_model ( 'order_info_model' );
	RC_Loader::load_theme('extras/model/user/user_order_info_model.class.php');
    $db_info       = new user_order_info_model();
	if (is_null ( $username )) {
		$username = $_SESSION ['admin_name'];
	}

	$row = $db_info->field('order_id')->find(array('order_sn' => $order_sn));
	$data = array (
		'order_id'           => $row ['order_id'],
		'action_user'        => $username,
		'order_status'       => $order_status,
		'shipping_status'    => $shipping_status,
		'pay_status'         => $pay_status,
		'action_place'       => $place,
		'action_note'        => $note,
		'log_time'           => RC_Time::gmtime()
	);
	$db_action->insert($data);
}

/**
 * 改变订单中商品库存
 */
function change_order_goods_storage($order_id, $is_dec = true, $storage = 0) {
	// $db			= RC_Loader::load_app_model('order_goods_model');
	RC_Loader::load_theme('extras/model/user/user_order_goods_model.class.php');
    $db       = new user_order_goods_model();
	// $db_package	= RC_Loader::load_app_model('package_goods_model');
	RC_Loader::load_theme('extras/model/user/user_package_goods_model.class.php');
    $db_package       = new user_package_goods_model();
	// $db_goods	= RC_Loader::load_app_model('goods_model','goods');
	RC_Loader::load_theme('extras/model/user/user_goods_model.class.php');
    $db_goods       = new user_goods_model();
	/* 查询订单商品信息  */
	$data = $db->field('goods_id, SUM(goods_number) as num, MAX(extension_code) as extension_code, product_id')
	->where(array('order_id' => $order_id , 'is_real' => 1))->group(array('goods_id','product_id'))->select();
	if (!empty($data)) {
		foreach ($data as $row) {
			if ($row['extension_code'] != "package_buy") {
				if ($is_dec) {
					change_goods_storage($row['goods_id'], $row['product_id'], - $row['num']);
				} else {
					change_goods_storage($row['goods_id'], $row['product_id'], $row['num']);
				}
			} else {
				$data = $db_package->field('goods_id, goods_number')->where('package_id = "' . $row['goods_id'] . '"')->select();
				if (!empty($data)) {
					foreach ($data as $row_goods) {
						$is_goods = $db_goods->field('is_real')->find('goods_id = "'. $row_goods['goods_id'] .'"');
						if ($is_dec) {
							change_goods_storage($row_goods['goods_id'], $row['product_id'], - ($row['num'] * $row_goods['goods_number']));
						} elseif ($is_goods['is_real']) {
							change_goods_storage($row_goods['goods_id'], $row['product_id'], ($row['num'] * $row_goods['goods_number']));
						}
					}
				}
			}
		}
	}
}

/**
* 商品库存增与减 货品库存增与减
*/
function change_goods_storage($goods_id, $product_id, $number = 0) {
	// $db_goods		= RC_Loader::load_app_model('goods_model','goods');
	RC_Loader::load_theme('extras/model/user/user_goods_model.class.php');
    $db_goods       = new user_goods_model();
	// $db_products	= RC_Loader::load_app_model('products_model','goods');
	RC_Loader::load_theme('extras/model/user/user_products_model.class.php');
    $db_products       = new user_products_model();
	if ($number == 0) {
		return true; // 值为0即不做、增减操作，返回true
	}
	if (empty($goods_id) || empty($number)) {
		return false;
	}
	/* 处理货品库存 */
	$products_query = true;
	if (!empty($product_id)) {
		$products_query = $db_products->inc('product_number','goods_id='.$goods_id.' and product_id='.$product_id,$number);
	}
	/* 处理商品库存 */
	$query = $db_goods->inc('goods_number','goods_id='.$goods_id,$number);
	if ($query && $products_query) {
		return true;
	} else {
		return false;
	}
}

/**
 * 修改订单
 */
function update_order($order_id, $order) {
	// $db = RC_Loader::load_app_model('order_info_model');
	RC_Loader::load_theme('extras/model/user/user_order_info_model.class.php');
    $db       = new user_order_info_model();
	return $db->where(array('order_id'=>$order_id))->update($order);
}

/**
 * 获取订单第一个商品的缩略图
 */
function get_order_thumb($order_id) {
	// $db_goods_viewmodel = RC_Loader::load_app_model('goods_viewmodel');
	 RC_Loader::load_theme('extras/model/user/user_goods_viewmodel.class.php');
        $db_goods_viewmodel       = new user_goods_viewmodel();
	$db_goods_viewmodel->view = array(
			'order_goods' => array(
					'type' 	=> Component_Model_View::TYPE_RIGHT_JOIN,
					'alias'	=> 'og',
					'on'	=> "og.goods_id = g.goods_id"
			),
	);
	return $db_goods_viewmodel->where(array('og.order_id'=>$order_id))->get_field('g.goods_thumb');
}

/**
* 获取指订单的详情
*/
function get_order_detail ($order_id, $user_id = 0){
	// $db = RC_Loader::load_app_model('shipping_model');
	RC_Loader::load_theme('extras/model/user/user_shipping_model.class.php');
    $db       = new user_shipping_model();
	// $dbview = RC_Loader::load_app_model('package_goods_viewmodel');
	RC_Loader::load_theme('extras/model/user/user_package_goods_viewmodel.class.php');
        $dbview       = new user_package_goods_viewmodel();
	$pay_method = RC_Loader::load_app_class('payment_method', 'payment');
	// $db_user		= RC_Loader::load_app_model('users_model');
	 RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
        $db_user       = new touch_users_model();
	$user_money = $db_user->field('user_money')->where(array('user_name'=>$_SESSION['user_name']))->find();
	$order_id = intval($order_id);
	if ($order_id <= 0) {
		return false;
	}
	$order = order_info($order_id);
	/* 检查订单是否属于该用户 */
	if ($user_id > 0 && $user_id != $order['user_id']) {
		return false;
	}
	/* 对发货号处理 */
	if (! empty($order['invoice_no'])) {
		$shipping_code = $db->where(array('shipping_id' => $order[shipping_id]))->get_field('shipping_code');
	}
	/* 只有未确认才允许用户修改订单地址 */
	if ($order['order_status'] == OS_UNCONFIRMED) {
		$order['allow_update_address'] = 1; // 允许修改收货地址
	} else {
		$order['allow_update_address'] = 0;
	}
	/* 获取订单中实体商品数量 */
	$order['exist_real_goods'] = exist_real_goods($order_id);
	$order['user_name'] = $_SESSION['user_name'];
	/* 如果是未付款状态，生成支付按钮 */
	/* 无配送时的处理 */
	$order['shipping_id'] == - 1 and $order['shipping_name'] = RC_Lang::lang('shipping_not_need');
	/* 其他信息初始化 */
	$order['how_oos_name'] = $order['how_oos'];
	$order['how_surplus_name'] = $order['how_surplus'];
	/* 虚拟商品付款后处理 */
	if ($order['pay_status'] != PS_UNPAYED) {
		/* 取得已发货的虚拟商品信息 */
		$virtual_goods = get_virtual_goods($order_id, true);
		$virtual_card = array();
		foreach ($virtual_goods as $code => $goods_list) {
			/* 只处理虚拟卡 */
			if ($code == 'virtual_card') {
				foreach ($goods_list as $goods) {
					if ($info) {
						$virtual_card[] = array(
							'goods_id' => $goods['goods_id'],
							'goods_name' => $goods['goods_name'],
							'info' => $info
						);
					}
				}
			}
			/* 处理超值礼包里面的虚拟卡 */
			if ($code == 'package_buy') {
				foreach ($goods_list as $goods) {
					$dbview->view = array(
						'goods' => array(
							'type' => Component_Model_View::TYPE_LEFT_JOIN,
							'alias' => 'g',
							'field' => 'g.goods_id',
							'on' => 'pg.goods_id = g.goods_id'
						)
					);
					$vcard_arr = $dbview->where('pg.package_id = ' . $goods['goods_id'] . ' AND extension_code = "virtual_card" ')->select();
					if (! empty($vcard_arr)) {
						foreach ($vcard_arr as $val) {
							$info = virtual_card_result($order['order_sn'], $val);
							if ($info) {
								$virtual_card[] = array(
									'goods_id' => $goods['goods_id'],
									'goods_name' => $goods['goods_name'],
									'info' => $info
								);
							}
						}
					}
				}
			}
		}
		$var_card = deleteRepeat($virtual_card);
		ecjia::$view_object->assign('virtual_card', $var_card);
	}
	/* 确认时间 支付时间 发货时间 */
	if ($order['confirm_time'] > 0 && ($order['order_status'] == OS_CONFIRMED || $order['order_status'] == OS_SPLITED || $order['order_status'] == OS_SPLITING_PART)) {
		$order['confirm_time'] = sprintf(RC_Lang::lang('confirm_time'), RC_Time::local_date('Y-m-d', $order['confirm_time']));
	} else {
		$order['confirm_time'] = '';
	}
	if ($order['pay_time'] > 0 && $order['pay_status'] != PS_UNPAYED) {
		$order['pay_time'] = sprintf(RC_Lang::lang('pay_time'), RC_Time::local_date('Y-m-d', $order['pay_time']));
	} else {
		$order['pay_time'] = '';
	}
	if ($order['shipping_time'] > 0 && in_array($order['shipping_status'], array(
		SS_SHIPPED,
		SS_RECEIVED
	))) {
		$order['shipping_time'] = sprintf(RC_Lang::lang('shipping_time'), RC_Time::local_date('Y-m-d', $order['shipping_time']));
	} else {
		$order['shipping_time'] = '';
	}
	$order['user_money'] = $user_money['user_money'];
	return $order;
}

/**
 * 取得订单信息
 */
function order_info($order_id, $order_sn = '') {
    // $db = RC_Loader::load_app_model('order_info_viewmodel');
     RC_Loader::load_theme('extras/model/user/user_order_info_viewmodel.class.php');
     $db       = new user_order_info_viewmodel();
     RC_Loader::load_theme('extras/user/goods/user_order_info_viewmodel.class.php');
        $db       = new user_order_info_viewmodel();
    /* 计算订单各种费用之和的语句 */
    $total_fee = " (goods_amount - discount + tax + shipping_fee + insure_fee + oi.pay_fee + pack_fee + card_fee) AS total_fee ";
    $order_id = intval($order_id);
    if ($order_id > 0) {
        $order = $db->join('payment')->field('oi.*,p.pay_code,'.$total_fee)->where(array('order_id' => $order_id))->find();
    } else {
        $order = $db->join('payment')->field('oi.*,p.pay_code,'.$total_fee)->where(array('order_sn' => $order_sn))->find();
    }
	/* 格式化金额字段 */
	if ($order) {
		$order['formated_goods_amount']		= price_format($order['goods_amount'], false);
		$order['formated_discount']			= price_format($order['discount'], false);
		$order['formated_tax']				= price_format($order['tax'], false);
		$order['formated_shipping_fee']		= price_format($order['shipping_fee'], false);
		$order['formated_insure_fee']		= price_format($order['insure_fee'], false);
		$order['formated_pay_fee']			= price_format($order['pay_fee'], false);
		$order['formated_pack_fee']			= price_format($order['pack_fee'], false);
		$order['formated_card_fee']			= price_format($order['card_fee'], false);
		$order['formated_total_fee']		= price_format($order['total_fee'], false);
		$order['formated_money_paid']		= price_format($order['money_paid'], false);
		$order['formated_bonus']			= price_format($order['bonus'], false);
		$order['formated_integral_money']	= price_format($order['integral_money'], false);
		$order['formated_surplus']			= price_format($order['surplus'], false);
		$order['formated_order_amount']		= price_format(abs($order['order_amount']), false);
		$order['formated_add_time']			= RC_Time::local_date(ecjia::config('time_format'), $order['add_time']);
	}
	return $order;
}

/**
 * 查询购物车（订单id为0）或订单中是否有实体商品
 */
function exist_real_goods($order_id = 0, $flow_type = CART_GENERAL_GOODS) {
	// $db_cart = RC_Loader::load_app_model('cart_model');
	RC_Loader::load_theme('extras/model/user/user_cart_model.class.php');
     $db_cart       = new user_cart_model();
	// $db_order_goods = RC_Loader::load_app_model('order_goods_model');
	RC_Loader::load_theme('extras/model/user/user_order_goods_model.class.php');
     $db_order_goods       = new user_order_goods_model();
	if ($order_id <= 0) {
		$count = $db_cart->where(array('session_id'=>SESS_ID, 'is_real'=>1, 'rec_type'=>$flow_type))->count('*');
	} else {
		$count = $db_order_goods->where(array('order_id'=>$order_id, 'is_real'=>1))->count('*');
	}
	return $count > 0;
}

/**
 * 取得订单商品
 */
function order_goods($order_id) {
	// $db = RC_Loader::load_app_model('order_goods_model');
	RC_Loader::load_theme('extras/model/user/user_order_goods_model.class.php');
     $db       = new user_order_goods_model();
	// $db_gooods = RC_Loader::load_app_model('goods_model');
     RC_Loader::load_theme('extras/model/user/user_goods_model.class.php');
     $db_gooods       = new user_goods_model();
	$data = $db->field('rec_id, goods_id, goods_name, goods_sn,product_id, market_price, goods_number,goods_price, goods_attr, is_real, parent_id, is_gift,goods_price * goods_number|subtotal, extension_code')->where(array('order_id' => $order_id))->select();
	if(!empty($data)) {
		foreach ($data as $row) {
			if ($row['extension_code'] == 'package_buy') {
				$row['package_goods_list'] = get_package_goods($row['goods_id']);
			}
			$row['goods_attr'] 		= empty($row['goods_attr'])? '' :'<span>'.str_replace(" \n", '</span><span>', $row['goods_attr']).'</span>';
			$goods_msg = $db_gooods->field('goods_img')->where(array('goods_id' => $row['goods_id']))->select();
			$row['goods_thumb'] = get_image_path($row['goods_id'], $goods_msg[0]['goods_img']);
			$goods_list[] = $row;
		}
	}
	return $goods_list;
}

/**
 * 取得用户信息
 */
function user_info($user_id) {
	// $db_users = RC_Loader::load_app_model ( "users_model" );
	RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
     $db_users       = new touch_users_model();
	$user = $db_users->where(array('user_id'=>$user_id))->find();
	unset($user['question']);
	unset($user['answer']);
	/* 格式化帐户余额 */
	if ($user) {
		$user['formated_user_money'] = price_format($user['user_money'], false);
		$user['formated_frozen_money'] = price_format($user['frozen_money'], false);
	}
	return $user;
}

/**
 * 返回订单中的虚拟商品
 */
function get_virtual_goods($order_id, $shipping = false) {
	RC_Loader::load_theme('extras/model/user/user_order_goods_model.class.php');
	$db = new user_order_goods_model();
	if ($shipping) {
		$res = $db->field('goods_id, goods_name, send_number|num, extension_code' )->where ( 'order_id = ' . $order_id . ' AND extension_code > " " ' )->select ();
	} else {
		$res = $db->field('goods_id, goods_name, (goods_number - send_number)|num, extension_code' )->where ( 'order_id = ' . $order_id . ' AND is_real = 0 AND (goods_number - send_number) > 0 AND extension_code > " " ' )->select ();
	}

	$virtual_goods = array ();
	if (! empty ( $res )) {
		foreach ( $res as $row ) {
			$virtual_goods [$row ['extension_code']] [] = array (
				'goods_id' => $row ['goods_id'],
				'goods_name' => $row ['goods_name'],
				'num' => $row ['num']
			);
		}
	}
	return $virtual_goods;
}

/**
 * 去除虚拟卡中重复数据
 */
function deleteRepeat($array) {
	$_card_sn_record = array();
	foreach ($array as $_k => $_v) {
		foreach ($_v['info'] as $__k => $__v) {
			if (in_array($__v['card_sn'], $_card_sn_record)) {
				unset($array[$_k]['info'][$__k]);
			} else {
				array_push($_card_sn_record, $__v['card_sn']);
			}
		}
	}
	return $array;
}

/**
 * 确认一个用户订单
 */
function affirm($order_id, $user_id = 0){
	// $db = RC_Loader::load_app_model('order_info_model');
	RC_Loader::load_theme('extras/model/user/user_order_info_model.class.php');
     $db       = new user_order_info_model();
	/* 查询订单信息，检查状态 */
	$order = $db->field('user_id, order_sn , order_status, shipping_status, pay_status')->find(array('order_id' => $order_id));
	// 如果用户ID大于 0 。检查订单是否属于该用户
	$result['error']= 0;
	$result['message']= 0;
	if ($user_id > 0 && $order['user_id'] != $user_id) {
		$result['message'] =  RC_Lang::lang('no_priv');
		$result['error']=1;
		return $result;
	}    /* 检查订单 */
	elseif ($order['shipping_status'] == SS_RECEIVED) {
		$result['message'] =  RC_Lang::lang('order_already_received');
		$result['error']=1;
		return $result;
	} elseif ($order['shipping_status'] != SS_SHIPPED) {
		$result['message'] =  RC_Lang::lang('order_invalid');
		$result['error']=1;
		return $result;
	/* 修改订单发货状态为“确认收货” */
	} else {
		$data = array(
			'shipping_status' => SS_RECEIVED
		);
		$query = $db->where(array('order_id' => $order_id))->update($data);
		if ($query) {
			/* 记录日志 */
			order_action($order['order_sn'], $order['order_status'], SS_RECEIVED, $order['pay_status'], '', RC_Lang::lang('buyer'));
			$result['message'] = '确认订单成功';
			return $result;
		} else {
			$result['message'] =  $db->error();
			$result['error']=1;
			return $result;
		}
	}
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
 * 记录帐户变动
 */
function log_account_change($user_id, $user_money = 0, $frozen_money = 0, $rank_points = 0, $pay_points = 0, $change_desc = '', $change_type = ACT_OTHER) {
	// 链接数据库
	// $db_account_log = RC_Loader::load_app_model ( "account_log_model", "user" );
	RC_Loader::load_theme('extras/model/user/user_account_log_model.class.php');
    $db_account_log       = new user_account_log_model();
	// $db_users = RC_Loader::load_app_model ( "users_model", "user" );
	RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
    $db_users       = new touch_users_model();
	/* 插入帐户变动记录 */
	$account_log = array (
		'user_id'		=> $user_id,
		'user_money'	=> $user_money,
		'frozen_money'	=> $frozen_money,
		'rank_points'	=> $rank_points,
		'pay_points'	=> $pay_points,
		'change_time'	=> RC_Time::gmtime(),
		'change_desc'	=> $change_desc,
		'change_type'	=> $change_type
	);
	$db_account_log->insert ( $account_log );

	/* 更新用户信息 */
	$step = $user_money.", frozen_money = frozen_money + ('$frozen_money')," .
	" rank_points = rank_points + ('$rank_points')," .
	" pay_points = pay_points + ('$pay_points')";
	$db_users->inc('user_money' , 'user_id='.$user_id , $step);
}

//end
