<?php
defined ( 'IN_ECJIA' ) or exit ( 'No permission resources.' );

/**
 * 获得指定国家的所有省份
 * @param type $type
 * @param type $parent
 * @return type
 */
function get_regions($type = 0, $parent = 0) {
	// $db_region = RC_Loader::load_app_model ( "region_model" );
	 RC_Loader::load_theme('extras/model/cart/cart_region_model.class.php');
    $db_region = new cart_region_model();
	$condition['region_type'] = $type;
	$condition['parent_id'] = $parent;
	return $db_region->field('region_id, region_name')->where($condition)->select();
}

/**
 * 取得收货人地址列表
 * @param   int     $user_id    用户编号
 * @param   int     $id         收货地址id
 * @return  array
 */
function get_consignee_list($user_id, $id = 0,$size = 10, $page = 1) {
	// $db_user_address = RC_Loader::load_app_model ( "user_viewmodel" );
	RC_Loader::load_theme('extras/model/cart/cart_user_viewmodel.class.php');
    $db_user_address = new cart_user_viewmodel();

	$db_user_address->view = array(
		'user_address'=>array(
			'type'  => Component_Model_View::TYPE_RIGHT_JOIN,
			'alias'	=> 'ua',
			'on'   	=> 'ua.address_id = u.address_id'
		)
	);

	if (!empty($id)) {
		return get_consignee_info($user_id, $id);
	} else {
		$count = $db_user_address->where(array('ua.user_id'=>$user_id))->count('*');
		$pages = new touch_page($count, $size, 6, '', $page);
		$field = 'ua.*,u.address_id | a_id';
		$res = $db_user_address->field($field)->join('user_address')->where(array('ua.user_id'=>$user_id))->order(array('u.address_id'=>'DESC'))->limit($pages->limit())->select();
	}
	$is_last = $page >= $pages->total_pages ? 1 : 0;
	return array('list'=> $res, 'page'=> $pages->show(5), 'desc'=> $pages->page_desc(), 'is_last'=>$is_last, 'default_address'=>$addressid);
}

/**
 * 获取收货地址信息
 * @param unknown $user_id
 * @param number $id
 */
function get_consignee_info($user_id, $id) {
	// $db_user_address = RC_Loader::load_app_model ( "user_address_model" );
	RC_Loader::load_theme('extras/model/cart/cart_user_address_model.class.php');
    $db_user_address = new cart_user_address_model();
	$where['address_id'] = $id;
	$where['user_id'] = $user_id;
	return $db_user_address->where($where)->find();
}

/**
* 查询购物车（订单id为0）或订单中是否有实体商品
* @param   int     $order_id   订单id
* @param   int     $flow_type  购物流程类型
* @return  bool
*/
function exist_real_goods($order_id = 0, $flow_type = CART_GENERAL_GOODS) {
	// $db_cart = RC_Loader::load_app_model('cart_model');
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db_cart = new cart_model();
	// $db_order_goods = RC_Loader::load_app_model('order_goods_model');
	RC_Loader::load_theme('extras/model/cart/cart_order_goods_model.class.php');
    $db_order_goods = new cart_order_goods_model();
	if ($order_id <= 0) {
		$count = $db_cart->where(array('session_id'=>SESS_ID, 'is_real'=>1, 'rec_type'=>$flow_type))->count('*');
	} else {
		$count = $db_order_goods->where(array('order_id'=>$order_id, 'is_real'=>1))->count('*');
	}
	return $count > 0;
}

/**
* 递归方式的对变量中的特殊字符去除转义
*
* @access  public
* @param   mix     $value
*
* @return  mix
*/
function stripslashes_deep($value) {
	if (empty($value)) {
		return $value;
	} else {
		return is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
	}
}

/**
 * 保存用户的收货人信息
 * 如果收货人信息中的 id 为 0 则新增一个收货人信息
 *
 * @access  public
 * @param   array   $consignee
 * @param   boolean $default        是否将该收货人信息设置为默认收货人信息
 * @return  boolean
 */
function save_consignee($consignee, $default = false) {
	// $db_user_address = RC_Loader::load_app_model ( "user_address_model" );
	RC_Loader::load_theme('extras/model/cart/cart_user_address_model.class.php');
    $db_user_address = new cart_user_address_model();
	// $db_users = RC_Loader::load_app_model ( "cart_users_model" );
	RC_Loader::load_theme('extras/model/cart/cart_users_model.class.php');
    $db_users = new cart_users_model();
	if ($consignee['address_id'] > 0) {
		/* 修改地址 */
		$where['address_id'] = $consignee['address_id'];
		$where['user_id'] = $_SESSION['user_id'];
		$res = $db_user_address->where($where)->update($consignee);
	} else {
		/* 添加地址 */
		$consignee['address_id'] = $res = $db_user_address->insert($consignee);
	}
	if ($default) {
		/* 保存为用户的默认收货地址 */
		$db_users->where(array('user_id'=>$_SESSION['user_id']))->update(array('address_id'=>$consignee['address_id']));
	}
	return $res !== false;
}

/**
 * 检查收货人信息是否完整
 * @param   array   $consignee  收货人信息
 * @param   int     $flow_type  购物流程类型
 * @return  bool    true 完整 false 不完整
 */
function check_consignee_info($consignee, $flow_type) {
	if (exist_real_goods(0, $flow_type)) {
		/* 如果存在实体商品 */
		$res = !empty($consignee['consignee']) &&
		!empty($consignee['country']) &&
		!empty($consignee['mobile']);
		if ($res) {
			if (empty($consignee['province'])) {
				/* 没有设置省份，检查当前国家下面有没有设置省份 */
				$pro = get_regions(1, $consignee['country']);
				$res = empty($pro);
			} elseif (empty($consignee['city'])) {
				/* 没有设置城市，检查当前省下面有没有城市 */
				$city = get_regions(2, $consignee['province']);
				$res = empty($city);
			} elseif (empty($consignee['district'])) {
				$dist = get_regions(3, $consignee['city']);
				$res = empty($dist);
			}
		}
		return $res;
	} else {
		/* 如果不存在实体商品 */
		return !empty($consignee['consignee']);
	}
}

/**
 * 删除一个收货地址
 */
function drop_consignee_addres($id) {
	// $db_user = RC_Loader::load_app_model('user_address_model');
	RC_Loader::load_theme('extras/model/cart/cart_user_address_model.class.php');
    $db_user = new cart_user_address_model();
	$res = $db_user->where(array('address_id'=>$id, 'user_id'=>$_SESSION['user_id']))->delete();
}

/**
 * 检查购物车中是否有商品
 */
function check_cart_goods($rec_id ) {
	// $db_cart = RC_Loader::load_app_model('cart_model');
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db_cart = new cart_model();
	$where = array(
		'session_id'	=> SESS_ID,
		'parent_id'		=> 0,
		'is_gift'		=> 0,
		'rec_type'		=> $_SESSION ['flow_type']
	);
	return $db_cart->where($where)->in(array('rec_id' => $rec_id))->count();
}

/**
 * 取得收货人信息
 * @param   int     $user_id    用户编号
 * @return  array
 */
function get_consignee($user_id) {
	// $db_user_viewmodel = RC_Loader::load_app_model ( "user_viewmodel" );
	RC_Loader::load_theme('extras/model/cart/cart_user_viewmodel.class.php');
    $db_user_viewmodel = new cart_user_viewmodel();
	if (isset($_SESSION['flow_consignee'])) {
		/* 如果存在session，则直接返回session中的收货人信息 */
		return $_SESSION['flow_consignee'];
	} else {
		/* 如果不存在，则取得用户的默认收货人信息 */
		$arr = array();
		if ($user_id > 0) {
			/* 取默认地址 */
			$arr = $db_user_viewmodel->join('user_address')->field('ua.*')->where(array('u.user_id'=>$user_id))->find();
		}
		return $arr;
	}
}

/**
 * 取得购物车商品
 * @param   int     $type   类型：默认普通商品
 * @return  array   购物车商品数组
 */
function cart_goods($type = CART_GENERAL_GOODS, $rec_id) {
	// $db_cart_viewmodel = RC_Loader::load_app_model ( "cart_viewmodel" );
	RC_Loader::load_theme('extras/model/cart/cart_viewmodel.class.php');
    $db_cart_viewmodel = new cart_viewmodel();
	$field = 'c.rec_id, c.user_id, c.goods_id, c.goods_name, c.goods_sn, c.goods_number, g.goods_thumb, g.goods_img, c.market_price, c.goods_price, c.goods_attr, c.is_real, c.extension_code, c.parent_id, c.is_gift, c.is_shipping, c.goods_price * c.goods_number|subtotal';
	$where = array('session_id'=>SESS_ID, 'rec_type'=>$type);
	if(empty($rec_id)){
		return false;
	}
	$arr = $db_cart_viewmodel->join('goods')->field($field)->where($where)->in(array('c.rec_id' => $rec_id))->select();

	/* 格式化价格及礼包商品 */
	foreach ($arr as $key => $value) {
		$arr[$key]['formated_market_price'] = price_format($value['market_price'], false);
		$arr[$key]['formated_goods_price'] = price_format($value['goods_price'], false);
		$arr[$key]['formated_subtotal'] = price_format($value['subtotal'], false);
		$arr[$key]['goods_thumb'] = get_image_path('', $value['goods_thumb']);
		$arr[$key]['goods_img'] = get_image_path('', $value['goods_img']);
		//TODO: 礼包购买
	}
	return $arr;
}

/**
 * 获得订单信息
 *
 * @access  private
 * @return  array
 */
function flow_order_info() {
	$order = isset($_SESSION['flow_order']) ? $_SESSION['flow_order'] : array();
	/* 初始化配送和支付方式 */
	if (!isset($order['shipping_id']) || !isset($order['pay_id'])) {
		/* 如果还没有设置配送和支付 */
		if ($_SESSION['user_id'] > 0) {
			/* 用户已经登录了，则获得上次使用的配送和支付 */
			$arr = last_shipping_and_payment();
			if (!isset($order['shipping_id'])) {
				$order['shipping_id'] = $arr['shipping_id'];
			}
			if (!isset($order['pay_id'])) {
				$order['pay_id'] = $arr['pay_id'];
			}
		} else {
			if (!isset($order['shipping_id'])) {
				$order['shipping_id'] = 0;
			}
			if (!isset($order['pay_id'])) {
				$order['pay_id'] = 0;
			}
		}
	}
	if (!isset($order['pack_id'])) {
		$order['pack_id'] = 0;  // 初始化包装
	}
	if (!isset($order['card_id'])) {
		$order['card_id'] = 0;  // 初始化贺卡
	}
	if (!isset($order['bonus'])) {
		$order['bonus'] = 0;    // 初始化红包
	}
	if (!isset($order['integral'])) {
		$order['integral'] = 0; // 初始化积分
	}
	if (!isset($order['surplus'])) {
		$order['surplus'] = 0;  // 初始化余额
	}
	/* 扩展信息 */
	if (isset($_SESSION['flow_type']) && intval($_SESSION['flow_type']) != CART_GENERAL_GOODS) {
		$order['extension_code'] = $_SESSION['extension_code'];
		$order['extension_id'] = $_SESSION['extension_id'];
	}
	return $order;
}

/**
 * 获得上一次用户采用的支付和配送方式
 *
 * @access  public
 * @return  void
 */
function last_shipping_and_payment() {
	// $db_order_info = RC_Loader::load_app_model ( "order_info_model" );
	RC_Loader::load_theme('extras/model/cart/cart_order_info_model.class.php');
    $db_order_info = new cart_order_info_model();
	$row = $db_order_info->field('shipping_id, pay_id')->where(array('user_id'=>$_SESSION['user_id']))->order('order_id DESC')->find();
	if (empty($row)) {
		/* 如果获得是一个空数组，则返回默认值 */
		$row = array('shipping_id' => 0, 'pay_id' => 0);
	}
	return $row;
}

// /**
//  * 获得订单中的费用信息
//  *
//  * @access  public
//  * @param   array   $order
//  * @param   array   $goods
//  * @param   array   $consignee
//  * @param   bool    $is_gb_deposit  是否团购保证金（如果是，应付款金额只计算商品总额和支付费用，可以获得的积分取 $gift_integral）
//  * @return  array
//  */
// function order_fee($order, $goods, $consignee) {
// 	$db_cart = RC_Loader::load_app_model ( "cart_model" );
// 	/* 初始化订单的扩展code */
// 	if (!isset($order['extension_code'])) {
// 		$order['extension_code'] = '';
// 	}
// 	//TODO: 团购
// 	$total = array('real_goods_count' 	=> 0,
// 		'gift_amount' 		=> 0,
// 		'goods_price'		=> 0,
// 		'market_price' 		=> 0,
// 		'discount' 			=> 0,
// 		'pack_fee' 			=> 0,
// 		'card_fee' 			=> 0,
// 		'shipping_fee'	 	=> 0,
// 		'shipping_insure' 	=> 0,
// 		'integral_money' 	=> 0,
// 		'bonus' 			=> 0,
// 		'surplus' 			=> 0,
// 		'cod_fee' 			=> 0,
// 		'pay_fee' 			=> 0,
// 		'tax' 				=> 0
// 	);
// 	$weight = 0;
// 	/* 商品总价 */
// 	foreach ($goods AS $val) {
// 		/* 统计实体商品的个数 */
// 		if ($val['is_real']) {
// 			$total['real_goods_count']++;
// 		}
// 		$total['goods_price'] += $val['goods_price'] * $val['goods_number'];
// 		$total['market_price'] += $val['market_price'] * $val['goods_number'];
// 	}
// 	$total['saving'] = $total['market_price'] - $total['goods_price'];
// 	$total['save_rate'] = $total['market_price'] ? round($total['saving'] * 100 / $total['market_price']) . '%' : 0;
// 	$total['goods_price_formated'] = price_format($total['goods_price'], false);
// 	$total['market_price_formated'] = price_format($total['market_price'], false);
// 	$total['saving_formated'] = price_format($total['saving'], false);
// 	/* 折扣 */
// 	if ($order['extension_code'] != 'group_buy') {
// 		$discount = compute_discount();
// 		$total['discount'] = $discount['discount'];
// 		if ($total['discount'] > $total['goods_price']) {
// 			$total['discount'] = $total['goods_price'];
// 		}
// 	}
// 	$total['discount_formated'] = price_format($total['discount'], false);
// 	/* 税额 */
// 	if (!empty($order['need_inv']) && $order['inv_type'] != '') {
// 		/* 查税率 */
// 		$rate = 0;
// 		$invoice_type = ecjia::config('invoice_type');
// 		foreach ($invoice_type['type'] as $key => $type) {
// 			if ($type == $order['inv_type']) {
// 				$rate = floatval($invoice_type['rate'][$key]) / 100;
// 				break;
// 			}
// 		}
// 		if ($rate > 0) {
// 			$total['tax'] = $rate * $total['goods_price'];
// 		}
// 	}
// 	$total['tax_formated'] = price_format($total['tax'], false);
// 	/* 包装费用 */
// 	//TODO: 包装
// // 	if (!empty($order['pack_id'])) {
// // 		$total['pack_fee'] = pack_fee($order['pack_id'], $total['goods_price']);
// // 	}
// 	$total['pack_fee_formated'] = price_format($total['pack_fee'], false);
// 	/* 贺卡费用 */
// 	//TODO: 贺卡
// // 	if (!empty($order['card_id'])) {
// // 		$total['card_fee'] = card_fee($order['card_id'], $total['goods_price']);
// // 	}
// 	$total['card_fee_formated'] = price_format($total['card_fee'], false);
// 	/* 红包 */
// 	if (!empty($order['bonus_id'])) {
// 		$bonus = bonus_info($order['bonus_id']);
// 		$total['bonus'] = $bonus['type_money'];
// 	}
// 	$total['bonus_formated'] = price_format($total['bonus'], false);

// 	/* 线下红包 */
// 	if (!empty($order['bonus_kill'])) {
// 		$bonus = bonus_info(0, $order['bonus_kill']);
// 		$total['bonus_kill'] = $order['bonus_kill'];
// 		$total['bonus_kill_formated'] = price_format($total['bonus_kill'], false);
// 	}
// 	/* 配送费用 */
// // 	$order['shipping_id'] = 5;
// 	$shipping_cod_fee = NULL;
// 	if ($order['shipping_id'] > 0 && $total['real_goods_count'] > 0) {
// 		$region['country'] = $consignee['country'];
// 		$region['province'] = $consignee['province'];
// 		$region['city'] = $consignee['city'];
// 		$region['district'] = $consignee['district'];
// 		$shipping_method	= RC_Loader::load_app_class('shipping_method', 'shipping');
// 		$shipping_info = empty($shipping_method) ? array() : $shipping_method->shipping_info($order['shipping_id']);
// 		if (!empty($shipping_info)) {
// 			if ($order['extension_code'] == 'group_buy') {
// 				$weight_price = cart_weight_price(CART_GROUP_BUY_GOODS);
// 			} else {
// 				$weight_price = cart_weight_price();
// 			}
// 			// 查看购物车中是否全为免运费商品，若是则把运费赋为零
// 			$where = array(
// 					'session_id'		=> SESS_ID,
// 					'extension_code'	=> array('neq'=>'package_buy'),
// 					'is_shipping'		=> 0
// 			);
// 			$shipping_count = $db_cart->where($where)->count('*');
// 			$total['shipping_fee'] = ($shipping_count == 0 AND $weight_price['free_shipping'] == 1) ? 0 : $shipping_method->shipping_fee($shipping_info['shipping_code'], $shipping_info['configure'], $weight_price['weight'], $total['goods_price'], $weight_price['number']);
// 			if (!empty($order['need_insure']) && $shipping_info['insure'] > 0) {
// 				$total['shipping_insure'] = shipping_insure_fee($shipping_info['shipping_code'], $total['goods_price'], $shipping_info['insure']);
// 			} else {
// 				$total['shipping_insure'] = 0;
// 			}

// 			if ($shipping_info['support_cod']) {
// 				$shipping_cod_fee = $shipping_info['pay_fee'];
// 			}
// 		}
// 	}
// 	$total['shipping_fee_formated'] = price_format($total['shipping_fee'], false);
// 	$total['shipping_insure_formated'] = price_format($total['shipping_insure'], false);
// 	/*购物车中的商品能享受红包支付的总额*/
// 	$bonus_amount = compute_discount_amount();
// 	/*红包和积分最多能支付的金额为商品总额*/
// 	$max_amount = $total['goods_price'] == 0 ? $total['goods_price'] : $total['goods_price'] - $bonus_amount;

// 	/* 计算订单总额 */
// 	//TODO:团购
// 	$total['amount'] = $total['goods_price'] - $total['discount'] + $total['tax'] + $total['pack_fee'] + $total['card_fee'] +
// 	$total['shipping_fee'] + $total['shipping_insure'] + $total['cod_fee'];
// 	/*减去红包金额*/
// 	$use_bonus = min($total['bonus'], $max_amount); // 实际减去的红包金额
// 	if (isset($total['bonus_kill'])) {
// 		$use_bonus_kill = min($total['bonus_kill'], $max_amount);
// 		$total['amount'] -= $price = number_format($total['bonus_kill'], 2, '.', ''); // 还需要支付的订单金额
// 	}
// 	$total['bonus'] = $use_bonus;
// 	$total['bonus_formated'] = price_format($total['bonus'], false);
// 	$total['amount'] -= $use_bonus; // 还需要支付的订单金额
// 	$max_amount -= $use_bonus; // 积分最多还能支付的金额
// 	/* 余额 */
// 	$order['surplus'] = $order['surplus'] > 0 ? $order['surplus'] : 0;
// 	if ($total['amount'] > 0) {
// 		if (isset($order['surplus']) && $order['surplus'] > $total['amount']) {
// 			$order['surplus'] = $total['amount'];
// 			$total['amount'] = 0;
// 		} else {
// 			$total['amount'] -= floatval($order['surplus']);
// 		}
// 	} else {
// 		$order['surplus'] = 0;
// 		$total['amount'] = 0;
// 	}
// 	$total['surplus'] = $order['surplus'];
// 	$total['surplus_formated'] = price_format($order['surplus'], false);
// 	/* 积分 */
// 	$order['integral'] = $order['integral'] > 0 ? $order['integral'] : 0;
// 	if ($total['amount'] > 0 && $max_amount > 0 && $order['integral'] > 0) {
// 		$integral_money = value_of_integral($order['integral']);
// 		/*使用积分支付*/
// 		$use_integral = min($total['amount'], $max_amount, $integral_money);
// 		$total['amount'] -= $use_integral;
// 		$total['integral_money'] = $use_integral;
// 		$order['integral'] = integral_of_value($use_integral);
// 	} else {
// 		$total['integral_money'] = 0;
// 		$order['integral'] = 0;
// 	}
// 	$total['integral'] = $order['integral'];
// 	$total['integral_formated'] = price_format($total['integral_money'], false);
// 	/* 保存订单信息 */
// 	$_SESSION['flow_order'] = $order;
// 	$se_flow_type = isset($_SESSION['flow_type']) ? $_SESSION['flow_type'] : '';
// 	/* 支付费用 */
// 	if (!empty($order['pay_id']) && ($total['real_goods_count'] > 0 || $se_flow_type != CART_EXCHANGE_GOODS)) {
// 		$total['pay_fee'] = pay_fee($order['pay_id'], $total['amount'], $shipping_cod_fee);
// 	}
// 	$total['pay_fee_formated'] = price_format($total['pay_fee'], false);
// 	$total['amount'] += $total['pay_fee']; // 订单总额累加上支付费用
// 	$total['amount_formated'] = price_format($total['amount'], false);
// 	/* 取得可以得到的积分和红包 */
// 	//TODO:团购
// 	if ($order['extension_code'] == 'exchange_goods') {
// 		$total['will_get_integral'] = 0;
// 	} else {
// 		$total['will_get_integral'] = get_give_integral($goods);
// 	}
// 	$total['will_get_bonus'] = $order['extension_code'] == 'exchange_goods' ? 0 : price_format(get_total_bonus(), false);
// 	$total['formated_goods_price'] = price_format($total['goods_price'], false);
// 	$total['formated_market_price'] = price_format($total['market_price'], false);
// 	$total['formated_saving'] = price_format($total['saving'], false);
// 	if ($order['extension_code'] == 'exchange_goods') {
// 		$db_cart_viewmodel = RC_Loader::load_app_model('cart_viewmodel');
// 		$where = array(
// 			'c.session_id'	=> SESS_ID,
// 			'c.rec_type'	=> CART_EXCHANGE_GOODS,
// 			'c.is_gift'		=> 0,
// 			'c.goods_id'	=> array('gt'=>0),
// 			);
// 		$res = $db_cart->join('exchange_goods')->field('SUM(eg.exchange_integral) | SUM')->where($where)->group('eg.goods_id')->find();
// 		$exchange_integral = $res['sum'];
// 		$total['exchange_integral'] = $exchange_integral;
// 	}
// 	return $total;
// }

/**
 * 获得订单中的费用信息
 *
 * @access  public
 * @param   array   $order
 * @param   array   $goods
 * @param   array   $consignee
 * @param   bool    $is_gb_deposit  是否团购保证金（如果是，应付款金额只计算商品总额和支付费用，可以获得的积分取 $gift_integral）
 * @return  array
 */
function order_fee($order, $goods, $consignee) {
	// 	$sql = 'SELECT count(*) FROM ' . $GLOBALS['ecs']->table('cart') . " WHERE  `session_id` = '" . SESS_ID. "' AND `extension_code` != 'package_buy' AND `is_shipping` = 0";
	// 	$shipping_count = $GLOBALS['db']->getOne($sql);

// 	RC_Loader::load_app_func('common','goods');
// 	RC_Loader::load_app_func('cart','cart');
	// $db 	= RC_Loader::load_app_model('cart_model');
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db = new cart_model();

	// $dbview = RC_Loader::load_app_model('cart_exchange_viewmodel');
	RC_Loader::load_theme('extras/model/cart/cart_exchange_viewmodel.class.php');
    $dbview = new cart_exchange_viewmodel();
	/* 初始化订单的扩展code */
	if (!isset($order['extension_code'])) {
		$order['extension_code'] = '';
	}

	//     TODO: 团购等促销活动注释后暂时给的固定参数
	$order['extension_code'] = '';
	$group_buy ='';
	//     TODO: 团购功能暂时注释
	//     if ($order['extension_code'] == 'group_buy') {
	//         $group_buy = group_buy_info($order['extension_id']);
	//     }

	$total  = array('real_goods_count' => 0,
			'gift_amount'      => 0,
			'goods_price'      => 0,
			'market_price'     => 0,
			'discount'         => 0,
			'pack_fee'         => 0,
			'card_fee'         => 0,
			'shipping_fee'     => 0,
			'shipping_insure'  => 0,
			'integral_money'   => 0,
			'bonus'            => 0,
			'surplus'          => 0,
			'cod_fee'          => 0,
			'pay_fee'          => 0,
			'tax'              => 0

	);
	$weight = 0;
	/* 商品总价 */
	foreach ($goods AS $val) {
		/* 统计实体商品的个数 */
		if ($val['is_real']) {
			$total['real_goods_count']++;
		}

		$total['goods_price']  += $val['goods_price'] * $val['goods_number'];
		$total['market_price'] += $val['market_price'] * $val['goods_number'];
	}

	$total['saving']    = $total['market_price'] - $total['goods_price'];
	$total['save_rate'] = $total['market_price'] ? round($total['saving'] * 100 / $total['market_price']) . '%' : 0;

	$total['goods_price_formated']  = price_format($total['goods_price'], false);
	$total['market_price_formated'] = price_format($total['market_price'], false);
	$total['saving_formated']       = price_format($total['saving'], false);

	/* 折扣 */
	//TODO:: 团购暂时不做
// 	if ($order['extension_code'] != 'group_buy') {
// 		RC_Loader::load_app_func('cart','cart');
// 		$discount = compute_discount();
// 		$total['discount'] = $discount['discount'];
// 		if ($total['discount'] > $total['goods_price']) {
// 			$total['discount'] = $total['goods_price'];
// 		}
// 	}
	$total['discount_formated'] = price_format($total['discount'], false);

	/* 税额 */
	if (!empty($order['need_inv']) && $order['inv_type'] != '') {
		/* 查税率 */
		$rate = 0;
		$invoice_type=ecjia::config('invoice_type');
		foreach ($invoice_type['type'] as $key => $type) {
			if ($type == $order['inv_type']) {
				$rate_str = $invoice_type['rate'];
				$rate = floatval($rate_str[$key]) / 100;
				break;
			}
		}
		if ($rate > 0) {
			$total['tax'] = $rate * $total['goods_price'];
		}
	}
	$total['tax_formated'] = price_format($total['tax'], false);
	//	TODO：暂时注释
	/* 包装费用 */
	//     if (!empty($order['pack_id'])) {
	//         $total['pack_fee']      = pack_fee($order['pack_id'], $total['goods_price']);
	//     }
	//     $total['pack_fee_formated'] = price_format($total['pack_fee'], false);

	//	TODO：暂时注释
	//    /* 贺卡费用 */
	//    if (!empty($order['card_id'])) {
	//        $total['card_fee']      = card_fee($order['card_id'], $total['goods_price']);
	//    }
		$total['card_fee_formated'] = price_format($total['card_fee'], false);

		// RC_Loader::load_app_func('bonus');
		// RC_Loader::load_theme('extras/functions/bonus/bonus.func.php');
		/* 红包 */
		if (!empty($order['bonus_id'])) {
			$bonus          = bonus_info($order['bonus_id']);
			$total['bonus'] = $bonus['type_money'];
		}
		$total['bonus_formated'] = price_format($total['bonus'], false);
		/* 线下红包 */
		if (!empty($order['bonus_kill'])) {

			$bonus  = bonus_info(0,$order['bonus_kill']);
			$total['bonus_kill'] = $order['bonus_kill'];
			$total['bonus_kill_formated'] = price_format($total['bonus_kill'], false);
		}

		/* 配送费用 */
		$shipping_cod_fee = NULL;
		if ($order['shipping_id'] > 0 && $total['real_goods_count'] > 0) {
			$region['country']  = $consignee['country'];
			$region['province'] = $consignee['province'];
			$region['city']     = $consignee['city'];
			$region['district'] = $consignee['district'];

			$shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
			$shipping_info = $shipping_method->shipping_area_info($order['shipping_id'], $region);

			if (!empty($shipping_info)) {

				if ($order['extension_code'] == 'group_buy') {
					$weight_price = cart_weight_price(CART_GROUP_BUY_GOODS);
				} else {
					$weight_price = cart_weight_price();
				}

				// 查看购物车中是否全为免运费商品，若是则把运费赋为零
				if ($_SESSION['user_id']) {
					$shipping_count = $db->where(array('user_id' => $_SESSION['user_id'] , 'extension_code' => array('neq' => 'package_buy') , 'is_shipping' => 0))->count();
				} else {
					$shipping_count = $db->where(array('session_id' => SESS_ID , 'extension_code' => array('neq' => 'package_buy') , 'is_shipping' => 0))->count();
				}
				$total['shipping_fee'] = ($shipping_count == 0 AND $weight_price['free_shipping'] == 1) ? 0 :  $shipping_method->shipping_fee($shipping_info['shipping_code'],$shipping_info['configure'], $weight_price['weight'], $total['goods_price'], $weight_price['number']);

				if (!empty($order['need_insure']) && $shipping_info['insure'] > 0) {
					$total['shipping_insure'] = shipping_insure_fee($shipping_info['shipping_code'],$total['goods_price'], $shipping_info['insure']);
				} else {
					$total['shipping_insure'] = 0;
				}

				if ($shipping_info['support_cod']) {
					$shipping_cod_fee = $shipping_info['pay_fee'];
				}
			}
		}

		$total['shipping_fee_formated']    = price_format($total['shipping_fee'], false);
		$total['shipping_insure_formated'] = price_format($total['shipping_insure'], false);

		// 购物车中的商品能享受红包支付的总额
		$bonus_amount = compute_discount_amount();
		// 红包和积分最多能支付的金额为商品总额
		$max_amount = $total['goods_price'] == 0 ? $total['goods_price'] : $total['goods_price'] - $bonus_amount;

		/* 计算订单总额 */
		if ($order['extension_code'] == 'group_buy' && $group_buy['deposit'] > 0) {
			$total['amount'] = $total['goods_price'];
		} else {
			$total['amount'] = $total['goods_price'] - $total['discount'] + $total['tax'] + $total['pack_fee'] + $total['card_fee'] + $total['shipping_fee'] + $total['shipping_insure'] + $total['cod_fee'];
			// 减去红包金额
			$use_bonus        = min($total['bonus'], $max_amount); // 实际减去的红包金额
			if(isset($total['bonus_kill'])) {
				$use_bonus_kill   = min($total['bonus_kill'], $max_amount);
				$total['amount'] -=  $price = number_format($total['bonus_kill'], 2, '.', ''); // 还需要支付的订单金额
			}

			$total['bonus']   			= $use_bonus;
			$total['bonus_formated'] 	= price_format($total['bonus'], false);

			$total['amount'] -= $use_bonus; // 还需要支付的订单金额
			$max_amount      -= $use_bonus; // 积分最多还能支付的金额
		}

		/* 余额 */
		$order['surplus'] = $order['surplus'] > 0 ? $order['surplus'] : 0;
		if ($total['amount'] > 0) {
			if (isset($order['surplus']) && $order['surplus'] > $total['amount']) {
				$order['surplus'] = $total['amount'];
				$total['amount']  = 0;
			} else {
				$total['amount'] -= floatval($order['surplus']);
			}
		} else {
			$order['surplus'] = 0;
			$total['amount']  = 0;
		}
		$total['surplus'] 			= $order['surplus'];
		$total['surplus_formated'] 	= price_format($order['surplus'], false);

		/* 积分 */
		$order['integral'] = $order['integral'] > 0 ? $order['integral'] : 0;
		if ($total['amount'] > 0 && $max_amount > 0 && $order['integral'] > 0) {
			$integral_money = value_of_integral($order['integral']);
			// 使用积分支付
			$use_integral            = min($total['amount'], $max_amount, $integral_money); // 实际使用积分支付的金额
			$total['amount']        -= $use_integral;
			$total['integral_money'] = $use_integral;
			$order['integral']       = integral_of_value($use_integral);
		} else {
			$total['integral_money'] = 0;
			$order['integral']       = 0;
		}
		$total['integral'] 			 = $order['integral'];
		$total['integral_formated']  = price_format($total['integral_money'], false);

		/* 保存订单信息 */
		$_SESSION['flow_order'] = $order;
		$se_flow_type = isset($_SESSION['flow_type']) ? $_SESSION['flow_type'] : '';

		/* 支付费用 */
		if (!empty($order['pay_id']) && ($total['real_goods_count'] > 0 || $se_flow_type != CART_EXCHANGE_GOODS)) {
			$total['pay_fee']      	= pay_fee($order['pay_id'], $total['amount'], $shipping_cod_fee);
		}
		$total['pay_fee_formated'] 	= price_format($total['pay_fee'], false);
		$total['amount']           += $total['pay_fee']; // 订单总额累加上支付费用
		$total['amount_formated']  	= price_format($total['amount'], false);

		/* 取得可以得到的积分和红包 */
		if ($order['extension_code'] == 'group_buy') {
			$total['will_get_integral'] = $group_buy['gift_integral'];
		} elseif ($order['extension_code'] == 'exchange_goods') {
			$total['will_get_integral'] = 0;
		} else {
			$total['will_get_integral'] = get_give_integral($goods);
		}
		$total['will_get_bonus']        = $order['extension_code'] == 'exchange_goods' ? 0 : price_format(get_total_bonus(), false);
		$total['formated_goods_price']  = price_format($total['goods_price'], false);
		$total['formated_market_price'] = price_format($total['market_price'], false);
		$total['formated_saving']       = price_format($total['saving'], false);

		if ($order['extension_code'] == 'exchange_goods') {
			//         $sql = 'SELECT SUM(eg.exchange_integral) '.
			//                'FROM ' . $GLOBALS['ecs']->table('cart') . ' AS c,' . $GLOBALS['ecs']->table('exchange_goods') . 'AS eg '.
			//                "WHERE c.goods_id = eg.goods_id AND c.session_id= '" . SESS_ID . "' " .
			//                "  AND c.rec_type = '" . CART_EXCHANGE_GOODS . "' " .
			//                '  AND c.is_gift = 0 AND c.goods_id > 0 ' .
			//                'GROUP BY eg.goods_id';
			//         $exchange_integral = $GLOBALS['db']->getOne($sql);
			if ($_SESSION['user_id']) {
				$exchange_integral = $dbview->join('exchange_goods')->where(array('c.user_id' => $_SESSION['user_id'] , 'c.rec_type' => CART_EXCHANGE_GOODS , 'c.is_gift' => 0 ,'c.goods_id' => array('gt' => 0)))->group('eg.goods_id')->sum('eg.exchange_integral');
			} else {
				$exchange_integral = $dbview->join('exchange_goods')->where(array('c.session_id' => SESS_ID , 'c.rec_type' => CART_EXCHANGE_GOODS , 'c.is_gift' => 0 ,'c.goods_id' => array('gt' => 0)))->group('eg.goods_id')->sum('eg.exchange_integral');
			}
			$total['exchange_integral'] = $exchange_integral;
		}
		return $total;
}

/**
 * 取得红包信息
 * @param   int     $bonus_id   红包id
 * @param   string  $bonus_sn   红包序列号
 * @param   array   红包信息
 */
function bonus_info($bonus_id, $bonus_sn = ''){
	// $db_bonus = RC_Loader::load_app_model('bonus_type_viewmodel');
	RC_Loader::load_theme('extras/model/cart/cart_bonus_type_viewmodel.class.php');
    $db_bonus = new cart_bonus_type_viewmodel();
	if ($bonus_id > 0){
		$where = array('b.bonus_id'=>$bonus_id);
	}
	else{
		$where = array('b.bonus_sn'=>$bonus_sn);
	}
	$res = $db_bonus->join('user_bonus')->where($where)->find();
	return $res;
}

/**
 * 获得购物车中商品的总重量、总价格、总数量
 *
 * @access  public
 * @param   int     $type   类型：默认普通商品
 * @return  array
 */
function cart_weight_price($type = CART_GENERAL_GOODS) {
	// $db_cart = RC_Loader::load_app_model ( "cart_model" );
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db_cart = new cart_model();
	// $db_cart_viewmodel = RC_Loader::load_app_model ( "cart_viewmodel" );
	RC_Loader::load_theme('extras/model/cart/cart_viewmodel.class.php');
    $db_cart_viewmodel = new cart_viewmodel();
	// $db_goods_viewmodel = RC_Loader::load_app_model ( "goods_viewmodel" );
	RC_Loader::load_theme('extras/model/cart/cart_goods_viewmodel.class.php');
    $db_goods_viewmodel = new cart_goods_viewmodel();
	$db_goods_viewmodel->view = array(
		'package_goods' => array(
			'type'		=> Component_Model_View::TYPE_INNER_JOIN,
			'alias'		=> 'pg',
			'on'		=> 'g.goods_id = pg.goods_id'
		)
	);
	$package_row['weight'] = 0;
	$package_row['amount'] = 0;
	$package_row['number'] = 0;
	$packages_row['free_shipping'] = 1;
	/* 算超值礼包内商品的相关配送参数 */
	$where = array(
		'extension_code'	=> 'package_buy',
		'session_id'		=> SESS_ID
	);
	$row = $db_cart->field('goods_id, goods_number, goods_price')->where($where)->select();
	if ($row) {
		$packages_row['free_shipping'] = 0;
		$free_shipping_count = 0;
		foreach ($row as $val) {
			// 如果商品全为免运费商品，设置一个标识变量
			$where = array(
				'g.is_shipping'	=> 0,
				'pg.package_id'	=> $val['goods_id']
			);
			$shipping_count = $db_goods_viewmodel->join('package_goods')->where($where)->count('*');
			if ($shipping_count > 0) {
				// 循环计算每个超值礼包商品的重量和数量，注意一个礼包中可能包换若干个同一商品
				$goods_row = $db_goods_viewmodel->join('package_goods')->field('SUM(g.goods_weight * pg.goods_number)|weight, SUM(pg.goods_number)|number')->
				where($where)->find();
				$package_row['weight'] += floatval($goods_row['weight']) * $val['goods_number'];
				$package_row['amount'] += floatval($val['goods_price']) * $val['goods_number'];
				$package_row['number'] += intval($goods_row['number']) * $val['goods_number'];
			} else {
				$free_shipping_count++;
			}
		}
		$packages_row['free_shipping'] = $free_shipping_count == count($row) ? 1 : 0;
	}
	/* 获得购物车中非超值礼包商品的总重量 */
	$where = array(
		'c.session_id'	=> SESS_ID,
		'rec_type'	=> $type,
		'g.is_shipping'	=> 0,
		'c.extension_code'	=> array('neq'=>'package_buy')
	);
	$row = $db_cart_viewmodel->join('goods')->field('SUM(g.goods_weight * c.goods_number)|weight, SUM(c.goods_price * c.goods_number)|amount, SUM(c.goods_number)|number ')->
	where($where)->find();
	$packages_row['weight'] = floatval($row['weight']) + $package_row['weight'];
	$packages_row['amount'] = floatval($row['amount']) + $package_row['amount'];
	$packages_row['number'] = intval($row['number']) + $package_row['number'];
	/* 格式化重量 */
	$packages_row['formated_weight'] = formated_weight($packages_row['weight']);
	return $packages_row;
}

/**
 * 格式化重量：小于1千克用克表示，否则用千克表示
 *
 * @param float $weight
 *        	重量
 * @return string 格式化后的重量
 */
function formated_weight($weight) {
	$weight = round(floatval($weight), 3);
	if ($weight > 0) {
		if ($weight < 1) {
			/* 小于1千克，用克表示 */
			return intval($weight * 1000) . RC_Lang::lang('gram');
		} else {
			/* 大于1千克，用千克表示 */
			return $weight . RC_Lang::lang('kilogram');
		}
	} else {
		return 0;
	}
}

/**
 * 计算购物车中的商品能享受红包支付的总额
 * @return  float   享受红包支付的总额
 */
function compute_discount_amount() {
	// $db_favourable_activity = RC_Loader::load_app_model ("favourable_activity_model");
	RC_Loader::load_theme('extras/model/cart/cart_favourable_activity_model.class.php');
    $db_favourable_activity = new cart_favourable_activity_model();
	// $db_cart_viewmodel = RC_Loader::load_app_model ( "cart_viewmodel" );
	RC_Loader::load_theme('extras/model/cart/cart_viewmodel.class.php');
    $db_cart_viewmodel = new cart_viewmodel();
	/* 查询优惠活动 */
	$now = RC_Time::gmtime();
	$user_rank = ',' . $_SESSION['user_rank'] . ',';
	$where = "start_time <= '$now' AND end_time >= '$now' AND CONCAT(',', user_rank, ',') LIKE '%" . $user_rank . "%'" ." AND act_type " . db_create_in(array(FAT_DISCOUNT, FAT_PRICE));
	$favourable_list = $db_favourable_activity->where($where)->select();
	if (empty($favourable_list)) {
		return 0;
	}
	/* 查询购物车商品 */
	$where = array(
		'c.session_id'	=> SESS_ID,
		'c.parent_id'	=> 0,
		'c.is_gift'		=> 0,
		'rec_type'		=> CART_GENERAL_GOODS
	);
	$goods_list = $db_cart_viewmodel->join('goods')->where($where)->select();
	if (empty($goods_list)) {
		return 0;
	}
	/* 初始化折扣 */
	$discount = 0;
	$favourable_name = array();
	/* 循环计算每个优惠活动的折扣 */
	foreach ($favourable_list as $favourable) {
		$total_amount = 0;
		if ($favourable['act_range'] == FAR_ALL) {
			foreach ($goods_list as $goods) {
				$total_amount += $goods['subtotal'];
			}
		} elseif ($favourable['act_range'] == FAR_CATEGORY) {
			/* 找出分类id的子分类id */
			$id_list = array();
			$raw_id_list = explode(',', $favourable['act_range_ext']);
			foreach ($raw_id_list as $id) {
				$id_list = array_merge($id_list, array_keys(cat_list($id, 0, false)));
			}
			$ids = join(',', array_unique($id_list));
			foreach ($goods_list as $goods) {
				if (strpos(',' . $ids . ',', ',' . $goods['cat_id'] . ',') !== false) {
					$total_amount += $goods['subtotal'];
				}
			}
		} elseif ($favourable['act_range'] == FAR_BRAND) {
			foreach ($goods_list as $goods) {
				if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['brand_id'] . ',') !== false) {
					$total_amount += $goods['subtotal'];
				}
			}
		} elseif ($favourable['act_range'] == FAR_GOODS) {
			foreach ($goods_list as $goods) {
				if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['goods_id'] . ',') !== false) {
					$total_amount += $goods['subtotal'];
				}
			}
		} else {
			continue;
		}
		if ($total_amount > 0 && $total_amount >= $favourable['min_amount'] && ($total_amount <= $favourable['max_amount'] || $favourable['max_amount'] == 0)) {
			if ($favourable['act_type'] == FAT_DISCOUNT) {
				$discount += $total_amount * (1 - $favourable['act_type_ext'] / 100);
			} elseif ($favourable['act_type'] == FAT_PRICE) {
				$discount += $favourable['act_type_ext'];
			}
		}
	}
	return $discount;
}

/**
 * 取得购物车该赠送的积分数
 * @return  int     积分数
 */
function get_give_integral(){
	// $db_cart_viewmodel = RC_Loader::load_app_model('cart_viewmodel');
	RC_Loader::load_theme('extras/model/cart/cart_viewmodel.class.php');
    $db_cart_viewmodel = new cart_viewmodel();
	$where = array(
			'c.session_id'	=> SESS_ID,
			'c.goods_id'	=> array('gt'=>0),
			'c.parent_id'	=> 0,
			'c.rec_type'	=> 0,
			'c.is_gift'		=> 0
	);
	$field = 'SUM(IF(g.give_integral > -1, g.give_integral, c.goods_price)) | num';
	$res = $db_cart_viewmodel->join('goods')->field($field)->where($where)->find();
	return intval($res['num']);
}

/**
* 取得当前用户应该得到的红包总额
*/
function get_total_bonus() {
	// $db_cart = RC_Loader::load_app_model ( "cart_model" );
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db_cart = new cart_model();
	// $db_cart_viewmodel = RC_Loader::load_app_model ( "cart_viewmodel" );
	RC_Loader::load_theme('extras/model/cart/cart_viewmodel.class.php');
    $db_cart_viewmodel = new cart_viewmodel();
	// $db_bonus_type = RC_Loader::load_app_model ( "bonus_type_model" );
	RC_Loader::load_theme('extras/model/cart/cart_bonus_type_model.class.php');
    $db_bonus_type = new cart_bonus_type_model();
	$day = getdate();
	$today = RC_Time::local_mktime(23, 59, 59, $day['mon'], $day['mday'], $day['year']);

	/* 按商品发的红包 */
	$where = array(
		'c.session_id'			=> SESS_ID,
		'c.is_gift'				=> 0,
		'bt.send_type'			=> SEND_BY_GOODS,
		'bt.send_start_date'	=> $today,
		'bt.send_end_date'		=> $today,
		'c.rec_type'			=> CART_GENERAL_GOODS
	);
	$count = $db_cart_viewmodel->join(array('bonus_type', 'goods'))->where($where)->get_field('SUM(c.goods_number * bt.type_money)');
	$goods_total = floatval($count);
	/* 取得购物车中非赠品总金额 */
	$where = array(
		'session_id'	=> SESS_ID,
		'is_gift'		=> 0,
		'rec_type'		=> CART_GENERAL_GOODS
	);
	$count = $db_cart->where($where)->get_field('SUM(goods_price * goods_number)');
	$amount = floatval($count);

	/* 按订单发的红包 */
	$where = array(
		'send_type'			=> SEND_BY_ORDER,
		'send_start_date'	=> array('elt'=>$today),
		'send_end_date'		=> array('gt'=>$today),
		'min_amount'		=> array('gt'=>0)
	);
	$count = $db_bonus_type->where($where)->get_field("FLOOR('$amount' / min_amount) * type_money ");
	$order_total = floatval($count);
	return $goods_total + $order_total;
}

/**
 * 取得购物车总金额
 * @params  boolean $include_gift   是否包括赠品
 * @param   int     $type           类型：默认普通商品
 * @return  float   购物车总金额
 */
function cart_amount($include_gift = true, $type = CART_GENERAL_GOODS){
	// $db_cart = RC_Loader::load_app_model('cart_model');
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db_cart = new cart_model();
	$where = array(
			'session_id'	=> SESS_ID,
			'rec_type'		=> $type
		);
    if (!$include_gift){
        $where = array('is_gift'=>0,'goods_id'=>array('gt'=>0));
    }
	$res = $db_cart->where($where)->get_field('SUM(goods_price * goods_number)');
	return $res;
}

/**
 * 取得用户信息
 * @param   int     $user_id    用户id
 * @return  array   用户信息
 */
function user_info($user_id) {
	// $db_users = RC_Loader::load_app_model ( "cart_users_model" );
	RC_Loader::load_theme('extras/model/cart/cart_users_model.class.php');
    $db_users = new cart_users_model();
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
* 获得用户的可用积分
*
* @access private
* @return integral
*/
function flow_available_points() {
	// $db_cart_viewmodel = RC_Loader::load_app_model ( "cart_viewmodel" );
	RC_Loader::load_theme('extras/model/cart/cart_viewmodel.class.php');
    $db_cart_viewmodel = new cart_viewmodel();
	$where = array(
		'c.session_id'	=> SESS_ID,
		'c.is_gift'		=> 0,
		'g.integral'	=> array('gt'=>0),
		'c.rec_type'	=> CART_GENERAL_GOODS
	);
	$sum = $db_cart_viewmodel->join('goods')->where($where)->get_field('SUM(g.integral * c.goods_number)');
	$val = intval($sum);
	return integral_of_value($val);
}

/**
* 计算指定的金额需要多少积分
*
* @access  public
* @param   integer $value  金额
* @return  void
*/
function integral_of_value($value) {
	$scale = floatval(ecjia::config('integral_scale'));
	return $scale > 0 ? round($value / $scale * 100) : 0;
}

/**
* 取得用户当前可用红包
* @param   int     $user_id        用户id
* @param   float   $goods_amount   订单商品金额
* @return  array   红包数组
*/
function user_bonus($user_id, $goods_amount = 0) {
	if (empty($user_id)) return array();
	// $db_user_bonus_viewmodel = RC_Loader::load_app_model ( "user_bonus_viewmodel" );
	RC_Loader::load_theme('extras/model/cart/cart_user_bonus_viewmodel.class.php');
    $db_user_bonus_viewmodel = new cart_user_bonus_viewmodel();
	$day = getdate();
	$today = RC_Time::local_mktime(23, 59, 59, $day['mon'], $day['mday'], $day['year']);
	$where = array(
		'bt.use_start_date'		=> array('elt'=>$today),
		'bt.use_end_date'		=> array('gt'=>$today),
		'bt.min_goods_amount'	=> array('elt'=>$goods_amount),
		'ub.user_id'			=> array('neq'=>0),
		'ub.user_id'			=> $user_id,
		'ub.order_id'			=> 0
	);
	return $db_user_bonus_viewmodel->join('bonus_type')->field('bt.type_id, bt.type_name, bt.type_money, ub.bonus_id')->where($where)->select();
}

/**
 * 指定默认配送地址
 *
 */
function save_consignee_default($address_id) {
	/* 保存为用户的默认收货地址 */
	// $db_users = RC_Loader::load_app_model('cart_users_model');
	RC_Loader::load_theme('extras/model/cart/cart_users_model.class.php');
    $db_users = new cart_users_model();
	$data['address_id'] = $address_id;
	$where['user_id'] 	= $_SESSION['user_id'];
	$res = $db_users->where($where)->update($data);
	return $res;
}

/**
 * 检查订单中商品库存
 *
 * @access  public
 * @param   array   $arr
 *
 * @return  void
 */
function flow_cart_stock($arr) {
	// $db_goods_viewmodel = RC_Loader::load_app_model('goods_viewmodel');
	RC_Loader::load_theme('extras/model/cart/cart_goods_viewmodel.class.php');
    $db_goods_viewmodel = new cart_goods_viewmodel();
	// $db_products_model = RC_Loader::load_app_model('products_model');
	RC_Loader::load_theme('extras/model/cart/cart_products_model.class.php');
    $db_products_model = new cart_products_model();
	// $db_cart = RC_Loader::load_app_model('cart_model');
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db_cart = new cart_model();
	foreach ($arr AS $key => $val) {
		$val = intval(make_semiangle($val));
		if ($val <= 0 || !is_numeric($key)) {
			continue;
		}
		$goods = $db_cart->field('goods_id,goods_attr_id,extension_code')->where(array('rec_id'=>$key,'session_id'=>SESS_ID))->find();
		$row = $db_goods_viewmodel->join('cart')->field('g.goods_name,g.goods_number,c.product_id')->where(array('c.rec_id'=>$key,))->find();
		//系统启用了库存，检查输入的商品数量是否有效
		if (intval(ecjia::config('use_storage')) > 0 && $goods['extension_code'] != 'package_buy') {
			if ($row['goods_number'] < $val) {
				return new ecjia_error('low_stocks', sprintf(RC_Lang::lang('stock_insufficiency'), $row['goods_name'], $row['goods_number'], $row['goods_number']));
			}
			/* 是货品 */
			$row['product_id'] = trim($row['product_id']);
			if (!empty($row['product_id'])) {
				$product_number = $db_products_model->where(array('goods_id'=>$goods['goods_id'],'product_id'=>$row['product_id']))->get_field('product_number');
				if ($product_number < $val) {
					return new ecjia_error('low_stocks', sprintf(RC_Lang::lang('stock_insufficiency'), $row['goods_name'], $row['goods_number'], $row['goods_number']));
				}
			}
		} elseif (intval(ecjia::config('use_storage')) > 0 && $goods['extension_code'] == 'package_buy') {
			if (judge_package_stock($goods['goods_id'], $val)) {
				return new ecjia_error('low_stocks', sprintf(RC_Lang::lang('stock_insufficiency'), $row['goods_name'], $row['goods_number'], $row['goods_number']));
			}
		}
	}
}

/**
* 查询配送区域属于哪个办事处管辖
* @param   array   $regions    配送区域（1、2、3、4级按顺序）
* @return  int     办事处id，可能为0
*/
function get_agency_by_regions($regions) {
	// $db_region = RC_Loader::load_app_model ( "region_model" );
	RC_Loader::load_theme('extras/model/cart/cart_region_model.class.php');
    $db_region = new cart_region_model();
	if (!is_array($regions) || empty($regions)) {
		return 0;
	}
	$arr = array();
	$where = array(
		'region_id'	=> array('gt'=>0),
		'agency_id'	=> array('gt'=>0)
	);
	$res = $db_region->field('region_id, agency_id')->where($where)->in($regions)->select();
	foreach ($res as $row) {
		$arr[$row['region_id']] = $row['agency_id'];
	}
	if (empty($arr)) {
		return 0;
	}
	$agency_id = 0;
	for ($i = count($regions) - 1; $i >= 0; $i--) {
		if (isset($arr[$regions[$i]])) {
			return $arr[$regions[$i]];
		}
	}
}

/**
 * 获得订单需要支付的支付费用
 *
 * @access  public
 * @param   integer $payment_id
 * @param   float   $order_amount
 * @param   mix	 $cod_fee
 * @return  float
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
 * 获取推荐uid
 *
 * @access  public
 * @param   void
 *
 * @return int
 * @author xuanyan
 *
 */
function get_affiliate() {
	// $db_users = RC_Loader::load_app_model ( "cart_users_model" );
	RC_Loader::load_theme('extras/model/cart/cart_users_model.class.php');
    $db_users = new cart_users_model();
	if (!empty($_COOKIE['ecshop_affiliate_uid'])) {
		$uid = intval($_COOKIE['ecshop_affiliate_uid']);
		$user_id = $db_users->field('user_id')->where(array('user_id'=>$uid))->get_field();
		if ($user_id) {
			return $uid;
		} else {
			setcookie('ecshop_affiliate_uid', '', 1);
		}
	}
	elseif($_SESSION['user_id'] !== 0){
		//推荐 by ecmoban
		$reg_info = $db_users->field('reg_time, parent_id')->where(array('user_id'=>$_SESSION['user_id']))->find();
		//推荐信息
		$config = unserialize(ecjia::config('affiliate'));
		if (!empty($config['config']['expire'])) {
			if ($config['config']['expire_unit'] == 'hour') {
				$c = 1;
			} elseif ($config['config']['expire_unit'] == 'day') {
				$c = 24;
			} elseif ($config['config']['expire_unit'] == 'week') {
				$c = 24 * 7;
			} else {
				$c = 1;
			}
			//有效时间
			$eff_time = 3600 * $config['config']['expire'] * $c;
			//有效时间内
			if(RC_Time::gmtime() - $reg_info['reg_time'] <= $eff_time){
				return $reg_info['parent_id'];
			}
		}
	}
	return 0;
}

/**
* 得到新订单号
* @return  string
*/
function get_order_sn() {
	/* 选择一个随机的方案 */
	mt_srand((double) microtime() * 1000000);
	return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}

/**
 * 记录帐户变动
 *
 * @param int $user_id
 *        	用户id
 * @param float $user_money
 *        	可用余额变动
 * @param float $frozen_money
 *        	冻结余额变动
 * @param int $rank_points
 *        	等级积分变动
 * @param int $pay_points
 *        	消费积分变动
 * @param string $change_desc
 *        	变动说明
 * @param int $change_type
 *        	变动类型：参见常量文件
 * @return void
 */
function log_account_change($user_id, $user_money = 0, $frozen_money = 0, $rank_points = 0, $pay_points = 0, $change_desc = '', $change_type = ACT_OTHER) {
	// 链接数据库
	// $db_account_log = RC_Loader::load_app_model ( "account_log_model", "user" );
	RC_Loader::load_theme('extras/model/cart/cart_account_log_model.class.php');
    $db_account_log = new cart_account_log_model();
	// $db_users = RC_Loader::load_app_model ( "cart_users_model" );
	RC_Loader::load_theme('extras/model/cart/cart_users_model.class.php');
    $db_users = new cart_users_model();
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

/**
 * 设置红包为已使用
 * @param   int     $bonus_id   红包id
 * @param   int     $order_id   订单id
 * @return  bool
 */
function use_bonus($bonus_id, $order_id){
	// $db_bonus = RC_Loader::load_app_model('user_bonus_model');
	RC_Loader::load_theme('extras/model/cart/cart_user_bonus_model.class.php');
    $db_bonus = new cart_user_bonus_model();
	$data['order_id'] = $order_id;
	$data['used_time'] = RC_Time::gmtime();
	$where = array('bonus_id'=>$bonus_id);
	return $db_bonus->where($where)->update($data);
}

/**
 * 改变订单中商品库存
 * @param   int	 $order_id   订单号
 * @param   bool	$is_dec	 是否减少库存
 * @param   bool	$storage	 减库存的时机，1，下订单时；0，发货时；
 */
function change_order_goods_storage($order_id, $is_dec = true, $storage = 0) {
	// $db			= RC_Loader::load_app_model('order_goods_model');
	RC_Loader::load_theme('extras/model/cart/cart_order_goods_model.class.php');
    $db = new cart_order_goods_model();
	// $db_package	= RC_Loader::load_app_model('package_goods_model');
	RC_Loader::load_theme('extras/model/cart/cart_package_goods_model.class.php');
    $db_package = new cart_package_goods_model();
	// $db_goods	= RC_Loader::load_app_model('cart_goods_model');
	RC_Loader::load_theme('extras/model/cart/cart_goods_model.class.php');
    $db_goods = new cart_goods_model();
	/* 查询订单商品信息  */
	//	$sql = "SELECT goods_id, SUM(send_number) AS num, MAX(extension_code) AS extension_code, product_id FROM " . $GLOBALS['ecs']->table('order_goods') .
//	" WHERE order_id = '$order_id' AND is_real = 1 GROUP BY goods_id, product_id";
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
*
* @param   int	$good_id		 商品ID
* @param   int	$product_id	  货品ID
* @param   int	$number		  增减数量，默认0；
*
* @return  bool			   true，成功；false，失败；
*/
function change_goods_storage($goods_id, $product_id, $number = 0) {
	// $db_goods		= RC_Loader::load_app_model('cart_goods_model');
	RC_Loader::load_theme('extras/model/cart/cart_goods_model.class.php');
    $db_goods = new cart_goods_model();
	// $db_products	= RC_Loader::load_app_model('products_model');
	RC_Loader::load_theme('extras/model/cart/cart_products_model.class.php');
    $db_products = new cart_products_model();
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
* 获取邮件模板
* @access  public
* @param:  $tpl_name[string]       模板代码
* @return array
*/
function get_mail_template($tpl_name) {
	// $db_mail_templates = RC_Loader::load_app_model ( "mail_templates_model");
		RC_Loader::load_theme('extras/model/cart/cart_mail_templates_model.class.php');
    $db_mail_templates = new cart_mail_templates_model();
	$field = 'template_subject, is_html, template_content';
	$where = array('template_code'=>$tpl_name);
	return $db_mail_templates->field($field)->where($where)->find();
}

/**
 * 虚拟商品发货
 *
 * @access public
 * @param array $virtual_goods
 *        	虚拟商品数组
 * @param string $msg
 *        	错误信息
 * @param string $order_sn
 *        	订单号。
 * @param string $process
 *        	设定当前流程：split，发货分单流程；other，其他，默认。
 *
 * @return bool
 */
function virtual_goods_ship(&$virtual_goods, &$msg, $order_sn, $return_result = false, $process = 'other') {
	$virtual_card = array ();
	foreach ( $virtual_goods as $code => $goods_list ) {
		/* 只处理虚拟卡 */
		if ($code == 'virtual_card') {
			foreach ( $goods_list as $goods ) {
				if (virtual_card_shipping ( $goods, $order_sn, $msg, $process )) {
					if ($return_result) {
						$virtual_card [] = array (
							'goods_id' => $goods ['goods_id'],
							'goods_name' => $goods ['goods_name'],
							'info' => virtual_card_result ( $order_sn, $goods )
						);
					}
				} else {
					return false;
				}
			}
			ecjia::$view_object->assign ( 'virtual_card', $virtual_card );
		}
	}
	return true;
}

/**
 * 修改订单
 * @param   int	 $order_id   订单id
 * @param   array   $order	  key => value
 * @return  bool
 */
function update_order($order_id, $order) {
	// $db = RC_Loader::load_app_model('order_info_model','orders');
		RC_Loader::load_theme('extras/model/cart/cart_order_info_model.class.php');
    $db = new cart_order_info_model();
	return $db->where(array('order_id'=>$order_id))->update($order);
}

/**
 * 取得某订单应该赠送的积分数
 * @param   array   $order  订单
 * @return  int	 积分数
 */
function integral_to_give($order) {
	// $dbview = RC_Loader::load_app_model('goods_order_goods_viewmodel');
		RC_Loader::load_theme('extras/model/cart/cart_goods_order_goods_viewmodel.class.php');
    $dbview = new cart_goods_order_goods_viewmodel();
	//TODO:团购
	$dbview->view = array(
			'goods' => array(
					'type'  => Component_Model_View::TYPE_LEFT_JOIN,
					'alias' => 'g',
					'field' => 'SUM(o.goods_number * IF(g.give_integral > -1, g.give_integral, o.goods_price)) AS custom_points, SUM(o.goods_number * IF(g.rank_integral > -1, g.rank_integral, o.goods_price)) AS rank_points',
					'on'    => 'o.goods_id = g.goods_id ',
			)
	);
	return $dbview->where(array('o.order_id' => $order[order_id] , 'o.goods_id' => array('gt' => 0 ) , 'o.parent_id' => 0 , 'o.is_gift' => 0 , 'o.extension_code' => array('neq' => 'package_buy')))->find();
}

/**
 * 返回虚拟卡信息
 *
 * @access public
 * @param
 *
 * @return void
 */
function virtual_card_result($order_sn, $goods) {
//TODO: 虚拟卡发货
	// $db = RC_Loader::load_app_model ( 'virtual_card_model', 'goods' );
			RC_Loader::load_theme('extras/model/cart/cart_virtual_card_model.class.php');
    $db = new cart_virtual_card_model();

	$res = $db->field('card_sn, card_password, end_date, crc32')->where(array('goods_id' => $goods ['goods_id'], 'order_sn' => $order_sn))->select();
	$cards = array ();
	if (!empty ( $res )) {
		$auth_key = ecjia::config('auth_key');
		foreach ( $res as $row ) {
			/* 卡号和密码解密 */
			if ($row ['crc32'] == 0 || $row ['crc32'] == crc32 ( $auth_key )) {
				$row ['card_sn'] = RC_Crypt::decrypt ( $row ['card_sn'] );
				$row ['card_password'] = RC_Crypt::decrypt ( $row ['card_password'] );
			}  else {
				$row ['card_sn'] = '***';
				$row ['card_password'] = '***';
			}

			$cards [] = array (
					'card_sn' => $row ['card_sn'],
					'card_password' => $row ['card_password'],
					'end_date' => date ( ecjia::config('date_format'), $row ['end_date'] )
			);
		}
	}
	return $cards;
}

/**
 *  虚拟卡发货
 *
 * @access  public
 * @param   string      $goods      商品详情数组
 * @param   string      $order_sn   本次操作的订单
 * @param   string      $msg        返回信息
 * @param   string      $process    设定当前流程：split，发货分单流程；other，其他，默认。
 *
 * @return  boolen
 */
function virtual_card_shipping($goods, $order_sn, &$msg, $process = 'other') {
//TODO: 虚拟卡发货
    /* 检查有没有缺货 */
	// $db_order_info = RC_Loader::load_app_model ('order_info_model');
	RC_Loader::load_theme('extras/model/cart/cart_order_info_model.class.php');
    $db_order_info = new cart_order_info_model();
	// $db_order_goods = RC_Loader::load_app_model('order_goods_model');
	RC_Loader::load_theme('extras/model/cart/cart_order_goods_model.class.php');
    $db_order_goods = new cart_order_goods_model();
	// $db_virtual_card = RC_Loader::load_app_model ( 'virtual_card_model', 'goods' );
	RC_Loader::load_theme('extras/model/cart/cart_virtual_card_model.class.php');
    $db_virtual_card = new cart_virtual_card_model();
    $num = $db_virtual_card->where(array('goods_id' => $goods['goods_id'], is_saled => 0))->count('*');
    if ($num < $goods['num']) {
        touch::err()->add('virtual_card_oos', sprintf(RC_Lang::lang('virtual_card_oos'), $goods['goods_name']));
        return false;
    }

    /* 取出卡片信息 */
    $arr = $db_virtual_card->field('card_id, card_sn, card_password, end_date, crc32')->where(array('goods_id' => $goods['goods_id'], is_saled => 0))->limit($goods['num'])->select();

    $card_ids = array();
    $cards = array();
    defined('AUTH_KEY') && define('AUTH_KEY', ecjia::config('auth_key'));

    foreach ($arr as $virtual_card) {
        $card_info = array();
        /* 卡号和密码解密 */
        if ($virtual_card['crc32'] == 0 || $virtual_card['crc32'] == crc32(AUTH_KEY)) {
            $card_info['card_sn'] = RC_Crypt::decrypt($virtual_card['card_sn']);
            $card_info['card_password'] = RC_Crypt::decrypt($virtual_card['card_password']);
        } elseif ($virtual_card['crc32'] == crc32(OLD_AUTH_KEY)) {
            $card_info['card_sn'] = RC_Crypt::decrypt($virtual_card['card_sn'], OLD_AUTH_KEY);
            $card_info['card_password'] = RC_Crypt::decrypt($virtual_card['card_password'], OLD_AUTH_KEY);
        } else {
            touch::err()->add('error key', 'error key');
            return false;
        }
        $card_info['end_date'] = date(ecjia::config('date_format'), $virtual_card['end_date']);
        $card_ids[] = $virtual_card['card_id'];
        $cards[] = $card_info;
    }
    /* 标记已经取出的卡片 */
	$data = array(
		'is_saled'	=> 1,
		'order_sn'	=> $order_sn
	);
    $update = $db_virtual_card->in(array('card_id'=>$card_ids))->update($data);
    if (empty($update)) {
        touch::err()->add('update', '虚拟卡更新失败');
        return false;
    }

    /* 更新库存 */
    $db_virtual_card->where(array('goods_id' => $goods['goods_id']))->update(array('goods_number' => "goods_number - '$goods[num]'"));

    if (true) {
        /* 获取订单信息 */
    	$order = $db_order_info->field('order_id, order_sn, consignee, email')->where(array('order_sn' => $order_sn))->find();
        /* 更新订单信息 */
        if ($process == 'split') {
			$update_order_goods = $db_order_goods->where(array('order_id' => $order['order_id'], 'goods_id' => $goods['goods_id']))->update(array('send_number' => "send_number + " . $goods['num']));
        } else {
        	$update_order_goods = $db_order_goods->where(array('order_id' => $order['order_id'], 'goods_id' => $goods['goods_id']))->update(array('send_number' => $goods['num']));
        }

        if (empty($update_order_goods)) {
            return false;
        }
    }

    /* 发送邮件 */
    //TODO: 发邮件
//     touch::view()->assign('virtual_card', $cards);
//     touch::view()->assign('order', $order);
//     touch::view()->assign('goods', $goods);

//     touch::view()->assign('send_time', date('Y-m-d H:i:s'));
//     touch::view()->assign('shop_name', C('shop_name'));
//     touch::view()->assign('send_date', date('Y-m-d'));
//     touch::view()->assign('sent_date', date('Y-m-d'));

//     $tpl = model('Base')->get_mail_template('virtual_card');
//     $this->assign_lang();
//     $content = fetch('str:' . $tpl['template_content']);
//     send_mail($order['consignee'], $order['email'], $tpl['template_subject'], $content, $tpl['is_html']);

    return true;
}

// /**
//  * 获得指定页面的动态内容
//  * @access  public
//  * @param   string  $tmp    模板名称
//  * @return  void
//  */
// function assign_dynamic($tmp) {
// 	$db_template = RC_Loader::load_sys_model ( "template_model");
// 	$where = array(
// 			'filename'	=> $tmp,
// 			'type'		=> array('gt'=>0),
// 			'remarks'	=> '',
// 			'theme'		=> ecjia::config('template')
// 	);
// 	$res = $db_template->field('id, number, type')->where($where)->select();
// 	foreach ($res AS $row) {
// 		switch ($row['type']) {
// 			case 1:
// 				/* 分类下的商品 */
// 				ecjia_front::$controller->assign('goods_cat_' . $row['id'], assign_cat_goods($row['id'], $row['number']));
// 				break;
// 			case 2:
// 				/* 品牌的商品 */
// 				$brand_goods = assign_brand_goods($row['id'], $row['number']);

// 				ecjia_front::$controller->assign('brand_goods_' . $row['id'], $brand_goods['goods']);
// 				ecjia_front::$controller->assign('goods_brand_' . $row['id'], $brand_goods['brand']);
// 				break;
// 			case 3:
// 				/* 文章列表 */
// 				$cat_articles = assign_articles($row['id'], $row['number']);//model('Article')->

// 				ecjia_front::$controller->assign('articles_cat_' . $row['id'], $cat_articles['cat']);
// 				ecjia_front::$controller->assign('articles_' . $row['id'], $cat_articles['arr']);
// 				break;
// 		}
// 	}
// 	//$sql = 'SELECT id, number, type FROM ' . $this->pre .
// 	//"template WHERE filename = '$tmp' AND type > 0 AND remarks ='' AND theme='" . C('template') . "'";
// 	//$res = $this->query($sql);
// }

/**
 * 发红包：发货时发红包
 * @param   int	 $order_id   订单号
 * @return  bool
 */
function send_order_bonus($order_id) {
// 	RC_Loader::load_app_func('common','goods');
// 	$db		=  RC_Loader::load_app_model('user_bonus_model');
// 	$dbview	=  RC_Loader::load_app_model('users_viewmodel');
// 	/* 取得订单应该发放的红包 */
// 	$bonus_list = order_bonus($order_id);
// 	/* 如果有红包，统计并发送 */
// 	if ($bonus_list) {
// 		/* 用户信息 */
// 		$dbview->view = array(
// 			'order_info' => array(
// 				'type'	=> Component_Model_View::TYPE_RIGHT_JOIN,
// 				'alias'	=> 'o',
// 				'field'	=> 'u.user_id, u.user_name, u.email',
// 				'on'	=> 'o.user_id = u.user_id ',
// 			)
// 		);
// 		$user = $dbview->find(array('o.order_id' => $order_id));
// 		/* 统计 */
// 		$count = 0;
// 		$money = '';
// 		foreach ($bonus_list AS $bonus) {
// 			$count += $bonus['number'];
// 			$money .= price_format($bonus['type_money']) . ' [' . $bonus['number'] . '], ';
// 			/* 修改用户红包 */
// 			$data = array(
// 					'bonus_type_id' => $bonus['type_id'],
// 					'user_id'	   => $user['user_id']
// 			);
// 			for ($i = 0; $i < $bonus['number']; $i++) {
// 				if(!$db->insert($data)) {
// 					return $db->errorMsg();
// 				}
// 			}
// 		}
// 		/* 如果有红包，发送邮件 */
// 		if ($count > 0) {
// 			$tpl_name = 'send_bonus';
// 			$tpl   = RC_Api::api('mail', 'mail_template', $tpl_name);
// 			ecjia_admin::$controller->assign('user_name'	, $user['user_name']);
// 			ecjia_admin::$controller->assign('count'		, $count);
// 			ecjia_admin::$controller->assign('money'		, $money);
// 			ecjia_admin::$controller->assign('shop_name'	, ecjia::config('shop_name'));
// 			ecjia_admin::$controller->assign('send_date'	, RC_Time::local_date(ecjia::config('date_format')));

// 			$content = ecjia_admin::$controller->fetch_string($tpl['template_content']);
// 			RC_Mail::send_mail($user['user_name'], $user['email'] , $tpl['template_subject'], $content, $tpl['is_html']);
// 		}
// 	}
	return true;
}

/**
 * 清空购物车
 * @param   int     $type   类型：默认普通商品
 */
function clear_cart($type = CART_GENERAL_GOODS, $rec_id) {
	// $db_cart = RC_Loader::load_app_model ("cart_model");
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db_cart = new cart_model();
	$db_cart->where(array('session_id'=>SESS_ID, 'rec_type'=>$type))->in(array('rec_id' => $rec_id))->delete();
}

/**
 * 将支付LOG插入数据表
 * @access  public
 * @param   integer     $id         订单编号
 * @param   float       $amount     订单金额
 * @param   integer     $type       支付类型
 * @param   integer     $is_paid    是否已支付
 * @return  int
 */
function insert_pay_log($id, $amount, $type = PAY_SURPLUS, $is_paid = 0) {
	// $db_pay_log = RC_Loader::load_app_model ( "pay_log_model", "orders" );
	RC_Loader::load_theme('extras/model/cart/cart_pay_log_model.class.php');
    $db_pay_log = new cart_pay_log_model();
	$data = array(
		'order_id'		=> $id,
		'order_amount'	=> $amount,
		'order_type'	=> $type,
		'is_paid'		=> $is_paid
	);
	return $db_pay_log->insert($data);
}

/**
* 调用使用UCenter插件时的函数
*
* @param   string  $func
* @param   array   $params
*
* @return  mixed
*/
function user_uc_call($func, $params = null) {
	$integrate_code = ecjia::config('integrate_code');
	if (isset($integrate_code) && ecjia::config('integrate_code') == 'ucenter') {
		restore_error_handler();
		$res = call_user_func_array($func, $params);
		set_error_handler('exception_handler');
		return $res;
	}
}

/**
 * 获取地区名称
 * @param type $id
 * @return type
 */
function get_region_name($id = 0) {
	// $db_region = RC_Loader::load_app_model ( "region_model" );
	RC_Loader::load_theme('extras/model/cart/cart_region_model.class.php');
    $db_region = new cart_region_model();
	$condition['region_id'] = $id;
	return $db_region->field('region_name')->where($condition)->get_field();
}

/**
* 计算积分的价值（能抵多少钱）
* @param   int	 $integral   积分
* @return  float   积分价值
*/
function value_of_integral($integral) {
	$scale = floatval(ecjia::config('integral_scale'));
	return $scale > 0 ? round(($integral / 100) * $scale, 2) : 0;
}
































// 	/**
// 	 * 更新用户SESSION,COOKIE及登录时间、登录次数。
// 	 *
// 	 * @access  public
// 	 * @return  void
// 	 */
// 	function update_user_info() {
// 		if (!$_SESSION['user_id']) {
// 			return false;
// 		}
// 		/* 查询会员信息 */
// 		$db_user_viewmodel = RC_Loader::load_app_model ( "user_viewmodel" );
// 		$db_user_rank = RC_Loader::load_app_model ( "user_rank_model" );
// 		$db_users = RC_Loader::load_app_model ( "cart_users_model" );

// 		$row = $db_user_viewmodel->join(array('bonus_type','user_bonus'))->field('u.user_money,u.email, u.pay_points, u.user_rank, u.rank_points, IFNULL(b.type_money, 0)|user_bonus, u.last_login, u.last_ip')->where(array('u.user_id'=>$_SESSION[user_id]))->find();
// 		if ($row) {
// 			/* 更新SESSION */
// 			$_SESSION['last_time'] = $row['last_login'];
// 			$_SESSION['last_ip'] = $row['last_ip'];
// 			$_SESSION['login_fail'] = 0;
// 			$_SESSION['email'] = $row['email'];
// 			/* 判断是否是特殊等级，可能后台把特殊会员组更改普通会员组 */
// 			if ($row['user_rank'] > 0) {
// 				$special_rank = $db_user_rank->where(array('rank_id'=>$row[user_rank]))->get_field('special_rank');
// 				if ( empty($special_rank)) {
// 					$row['user_rank'] = $data['user_rank'] = 0;
// 					$db_users->where(array('user_id'=>$_SESSION[user_id]))->update($data);
// 				}
// 			}
// 			/* 取得用户等级和折扣 */
// 			if ($row['user_rank'] == 0) {
// 				/*非特殊等级，根据等级积分计算用户等级（注意：不包括特殊等级）*/
// 				$row = $db_user_rank->field('rank_id, discount')->where(array('special_rank'=>0, 'min_points'=>array('elt'=>intval($row['rank_points'])), 'max_points'=>array('gt'=>intval($row['rank_points']))))->find();
// 				if ($row) {
// 					$_SESSION['user_rank'] = $row['rank_id'];
// 					$_SESSION['discount'] = $row['discount'] / 100.00;
// 				} else {
// 					$_SESSION['user_rank'] = 0;
// 					$_SESSION['discount'] = 1;
// 				}
// 			} else {
// 				// 特殊等级
// 				$row = $db_user_rank->field('rank_id, discount')->where(array('rank_id'=>$row['user_rank']))->find();
// 				if ($row) {
// 					$_SESSION['user_rank'] = $row['rank_id'];
// 					$_SESSION['discount'] = $row['discount'] / 100.00;
// 				} else {
// 					$_SESSION['user_rank'] = 0;
// 					$_SESSION['discount'] = 1;
// 				}
// 			}
// 		}
// 		$db_users->where(array('user_id'=>$_SESSION['user_id']))->update(array('visit_count'=>'visit_count + 1', 'last_ip'=>RC_Ip::client_ip(), 'last_login'=>RC_Time::gmtime()));
// 	}

// 	/**
// 	 * 重新计算购物车中的商品价格：目的是当用户登录时享受会员价格，当用户退出登录时不享受会员价格
// 	 * 如果商品有促销，价格不变
// 	 *
// 	 * @access  public
// 	 * @return  void
// 	 */
// 	function recalculate_price() {
// 		/* 取得有可能改变价格的商品：除配件和赠品之外的商品 */
// 		$db_cart_viewmodel = RC_Loader::load_app_model ( "cart_viewmodel" );
// 		$db_cart = RC_Loader::load_app_model ( "cart_model" );
// 		$res = $db_cart_viewmodel->join(array('goods', 'member_price'))
// 		->field('c.rec_id, c.goods_id, c.goods_attr_id, g.promote_price, g.promote_start_date, c.goods_number,g.promote_end_date,' ." IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]')|member_price ")
// 		->where(array('session_id'=>SESS_ID, 'c.parent_id'=>0, 'c.is_gift'=>0, 'c.goods_id'=>array('gt'=>0), 'c.rec_type'=>CART_GENERAL_GOODS, 'c.extension_code'=>array('neq'=>'package_buy')))->select();

// 		foreach ($res AS $row) {
// 			$attr_id = empty($row['goods_attr_id']) ? array() : explode(',', $row['goods_attr_id']);
// 			$goods_price = get_final_price($row['goods_id'], $row['goods_number'], true, $attr_id);
// 			$db_cart->where(array('goods_id'=>$row['goods_id'], 'session_id'=> SESS_ID, 'rec_id'=>$row['rec_id']))->update(array('goods_price'=>$goods_price));
// 		}
// 		/* 删除赠品，重新选择 */
// 		$db_cart->where(array('session_id'=> SESS_ID, 'is_gift'=>array('neq'=>0)))->delet();
// 	}

// /**
// * 清除模版编译和缓存文件
// *
// * @access  public
// * @param   mix     $ext    模版文件名后缀
// * @return  void
// */
// function clear_all_files($ext = '') {
// 	del_dir(ROOT_PATH . 'data/cache');
// 	@mkdir(ROOT_PATH . 'data/cache', 0777);
// }

// 	/**
// 	* 遍历删除目录和目录下所有文件
// 	* @param unknown $dir
// 	* @return boolean
// 	*/
// 	function del_dir($dir) {
// 		if (!is_dir($dir)) {
// 			return false;
// 		}
// 		$handle = opendir($dir);
// 		while (($file = readdir($handle)) !== false) {
// 			if ($file != "." && $file != "..") {
// 				is_dir("$dir/$file") ? del_dir("$dir/$file") : @unlink("$dir/$file");
// 			}
// 		}
// 		if (readdir($handle) == false) {
// 			closedir($handle);
// 			@rmdir($dir);
// 		}
// 	}

// 	/**
// 	 * 取得订单信息
// 	 * @param   int	 $order_id   订单id（如果order_id > 0 就按id查，否则按sn查）
// 	 * @param   string  $order_sn   订单号
// 	 * @return  array   订单信息（金额都有相应格式化的字段，前缀是formated_）
// 	 */
// 	function order_info($order_id, $order_sn = '') {
// 		$db = RC_Loader::load_app_model('order_info_model');
// 		/* 计算订单各种费用之和的语句 */
// 		$total_fee = " (goods_amount - discount + tax + shipping_fee + insure_fee + pay_fee + pack_fee + card_fee) AS total_fee ";
// 		$order_id = intval($order_id);
// 		if ($order_id > 0) {
// 			$order = $db->field('*,'.$total_fee)->where(array('order_id' => $order_id))->find();
// 		} else {
// 			$order = $db->field('*,'.$total_fee)->where(array('order_sn' => $order_sn))->find();
// 		}
// 		/* 格式化金额字段 */
// 		if ($order) {
// 			$order['formated_goods_amount']		= price_format($order['goods_amount'], false);
// 			$order['formated_discount']			= price_format($order['discount'], false);
// 			$order['formated_tax']				= price_format($order['tax'], false);
// 			$order['formated_shipping_fee']		= price_format($order['shipping_fee'], false);
// 			$order['formated_insure_fee']		= price_format($order['insure_fee'], false);
// 			$order['formated_pay_fee']			= price_format($order['pay_fee'], false);
// 			$order['formated_pack_fee']			= price_format($order['pack_fee'], false);
// 			$order['formated_card_fee']			= price_format($order['card_fee'], false);
// 			$order['formated_total_fee']		= price_format($order['total_fee'], false);
// 			$order['formated_money_paid']		= price_format($order['money_paid'], false);
// 			$order['formated_bonus']			= price_format($order['bonus'], false);
// 			$order['formated_integral_money']	= price_format($order['integral_money'], false);
// 			$order['formated_surplus']			= price_format($order['surplus'], false);
// 			$order['formated_order_amount']		= price_format(abs($order['order_amount']), false);
// 			$order['formated_add_time']			= RC_Time::local_date(ecjia::config('time_format'), $order['add_time']);
// 		}
// 		return $order;
// 	}



// end
