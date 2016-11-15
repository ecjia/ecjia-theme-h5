<?php 
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获得购物车中的商品
 *
 * @access  public
 * @return  array
 */
function get_cart_list() {
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
	RC_Loader::load_theme('extras/model/cart/cart_goods_model.class.php');
	RC_Loader::load_theme('extras/model/cart/cart_goods_attr_model.class.php');
	RC_Loader::load_theme('extras/model/cart/cart_favourable_activity_model.class.php');
	RC_Loader::load_theme('extras/b2b2c/model/cart/cart_ware_cart_viewmodel.class.php');
	RC_Loader::load_theme('extras/model/cart/cart_group_goods_model.class.php');
	$db_cart = new cart_model();
	$db_goods = new cart_goods_model();
	$db_goods_attr = new cart_goods_attr_model();
	$db_goods_activity = new cart_favourable_activity_model();
	$db_ware_cart = new cart_ware_cart_viewmodel();
	$db_group = new cart_group_goods_model();
	
	/* 初始化 */
	$goods_list = array();
	$total = array(
		'goods_price' 	=> 0, // 本店售价合计（有格式）
		'market_price' 	=> 0, // 市场售价合计（有格式）
		'saving' 		=> 0, // 节省金额（有格式）
		'save_rate' 	=> 0, // 节省百分比
		'goods_amount' 	=> 0, // 本店售价合计（无格式）
		'total_number' 	=> 0,
	);
	/* 循环、统计 */
	$where = array(
		'c.session_id'	=> SESS_ID,
		'c.rec_type'		=> CART_GENERAL_GOODS
	);
	$res = $db_ware_cart->field('*,c.parent_id | cparentid, IF(c.parent_id, c.parent_id, c.goods_id)|pid, rw.region_name')->where($where)->order('pid,cparentid')->select();

	/* 用于统计购物车中实体商品和虚拟商品的个数 */
	$virtual_goods_count = 0;
	$real_goods_count = 0;
	foreach ($res as $row) {
		$total['total_number']	+= $row['goods_number'];
		$total['goods_price'] 	+= $row['goods_price'] * $row['goods_number'];
		$total['market_price'] 	+= $row['market_price'] * $row['goods_number'];
		$row['subtotal'] 		= price_format($row['goods_price'] * $row['goods_number'], false);
		$row['goods_price'] 	= price_format($row['goods_price'], false);
		$row['market_price'] 	= price_format($row['market_price'], false);
		/* 统计实体商品和虚拟商品的个数 */
		$row['is_real'] ? $real_goods_count++ : $virtual_goods_count++;
		/* 增加是否在购物车里显示商品图 */
		if ((ecjia::config('show_goods_in_cart') == "2" || ecjia::config('show_goods_in_cart') == "3") && $row['extension_code'] != 'package_buy') {
			$goods_thumb = $db_goods->where(array('goods_id'=>$row['goods_id']))->get_field('goods_thumb');
			$row['goods_thumb'] = get_image_path($row['goods_id'], $goods_thumb, true);
		}
		if ($row['extension_code'] == 'package_buy') {
			$row['package_goods_list'] = get_package_goods($row['goods_id']);
		}
		$row['favourable'] = favourable_list_flow($_SESSION['user_rank']);
		/*获取库存*/
		$row['goods_max_number'] = $db_goods->where(array('goods_id'=>$row['goods_id']))->get_field('goods_number');
		$goods_list[] = $row;
	}
	/* 取得商品配件  */
	$fitting = array_column($db_group->field('parent_id')->group('parent_id')->select(), 'parent_id');
	foreach ($goods_list as $key => $value) {
		if(in_array($value['goods_id'], $fitting)){
			$goods_list[$key]['fitting'] = $value['goods_id'];
		}
	}
	$total['goods_amount'] = $total['goods_price'];
	$total['saving'] = price_format($total['market_price'] - $total['goods_price'], false);
	if ($total['market_price'] > 0) {
		$total['save_rate'] = $total['market_price'] ? round(($total['market_price'] - $total['goods_price']) * 100 / $total['market_price']) . '%' : 0;
	}
	$total['goods_price'] = price_format($total['goods_price'], false);
	$total['market_price'] = price_format($total['market_price'], false);
	$total['real_goods_count'] = $real_goods_count;
	$total['virtual_goods_count'] = $virtual_goods_count;
	return array('goods_list' => $goods_list, 'total' => $total);

	/* 查询规格 */
//		if (trim($row['goods_attr']) != '') {
//			$row['goods_attr'] = addslashes($row['goods_attr']);
//			$attr_list = $db_goods_attr->field('attr_value')->in(array('goods_attr_id' => $row['goods_attr_id']))->find();
//			foreach ($attr_list as $attr) {
//				$row['goods_name'] .= ' [' . $attr . '] ';
//			}
//		}
}


//获取主订单信息
function get_main_order_info($order_id = 0, $type = 0){
	RC_Loader::load_theme('extras/model/cart/cart_order_info_model.class.php');
	$orderinfo_db = new cart_order_info_model();
	// 	$sql = "select * from " .$GLOBALS['ecs']->table('order_info'). " where order_id = '$order_id'";
	// 	$row = $GLOBALS['db']->getRow($sql);
	$row = $orderinfo_db->find(array('order_id' => $order_id));

	if($type == 1){
		$row['all_ruId'] = get_main_order_goods_info($order_id, 1); //订单中所有商品所属商家ID,0代表自营商品，其它商家商品
		$ru_id = explode(",", $row['all_ruId']['ru_id']);
		if(count($ru_id) > 1){
			$row['order_goods'] = get_main_order_goods_info($order_id);
			$row['newInfo'] = get_new_ru_goods_info($row['all_ruId'], $row['order_goods']);
			$row['newOrder'] = get_new_order_info($row['newInfo']);
			$row['orderBonus'] = get_new_order_info($row['newInfo'],1, $row['bonus_id']); //处理商家分单红包
//			TODO: 商家分单优惠活动
//			$row['orderFavourable'] = get_new_order_info($row['newInfo'],2); //处理商家分单优惠活动
		}
	}

	return $row;
}

//获取订单信息--或者--订单中所有商品所属商家ID,0代表自营商品，其它商家商品
function get_main_order_goods_info($order_id = 0, $type = 0) {
	RC_Loader::load_theme('extras/b2b2c/model/cart/cart_order_order_goods_viewmodel.class.php');
	$ordergoods_viewdb = new cart_order_order_goods_viewmodel();
	// 	$sql = "select og.*, g.goods_weight as goodsWeight from " .$GLOBALS['ecs']->table('order_goods') ." as og, " .$GLOBALS['ecs']->table('goods') ." as g". " where og.goods_id = g.goods_id and og.order_id = '$order_id'";
	// 	$res = $GLOBALS['db']->getAll($sql);
	$res = $ordergoods_viewdb->join(array('goods'))->field('o.*, g.goods_weight as goodsWeight')->where(array('order_id' => $order_id))->select();

	$arr = array();
	if($type == 1){
		$arr['ru_id'] = '';
	}
	foreach($res as $key=>$row){
		if($type == 0){
			$arr[] = $row;
		}else{
			$arr['ru_id'] .= $row['ru_id'] . ',';
		}
	}

	if($type == 1){
		$arr['ru_id'] = explode(',', substr($arr['ru_id'], 0, -1));
		$arr['ru_id'] = array_unique($arr['ru_id']);
		$arr['ru_id'] = implode(',', $arr['ru_id']);
	}

	return $arr;
}

//主次订单拆分新数组
function get_new_ru_goods_info($all_ruId = '', $order_goods = array()){
	$all_ruId = $all_ruId['ru_id'];
	$arr = array();

	if(!empty($all_ruId)){
		$all_ruId = explode(',', $all_ruId);
		$all_ruId = array_values($all_ruId);
	}

	if($all_ruId){
		for($i=0; $i<count($order_goods); $i++){
			for($j=0; $j<count($all_ruId); $j++){
				if($order_goods[$i]['ru_id'] == $all_ruId[$j]){
					$arr[$all_ruId[$j]][$i] = $order_goods[$i];
				}
			}
		}
	}

	//get_print_r($arr);
	return $arr;
}

//运算分单后台每个订单商品总金额以及划分红包类型使用所属商家
function get_new_order_info($newInfo, $type = 0, $bonus_id = 0){
// 	RC_Loader::load_app_func('order', 'orders');
	$arr = array();

	if ($type == 0) {
		foreach($newInfo as $key=>$row){
			$arr[$key]['goods_amount'] = 0;
			$arr[$key]['shopping_fee'] = 0;
			$arr[$key]['goods_id'] = 0;

			$arr[$key]['ru_list'] = get_cart_goods_combined_freight($row, 2); //计算商家运费

			$row = array_values($row);
			for ($j=0; $j<count($row); $j++) {
				$arr[$key]['goods_id'] = $row[$j]['goods_id'];
				// 				TODO:
				//ecmoban模板堂 --zhuo start 商品金额促销
				$goods_amount = $row[$j]['goods_price'] * $row[$j]['goods_number'];
				if ($goods_amount > 0) {
					$goods_con = get_con_goods_amount($goods_amount, $row[$j]['goods_id'], 0, 0, $row[$j]['parent_id']);

					$goods_con['amount'] = explode(',', $goods_con['amount']);
					$amount = min($goods_con['amount']);

					$arr[$key]['goods_amount'] += $amount;
				} else {
					$arr[$key]['goods_amount'] += $row[$j]['goods_price'] * $row[$j]['goods_number']; //原始
				}

				$arr[$key]['shopping_fee'] = $arr[$key]['ru_list']['shipping_fee'];
				//ecmoban模板堂 --zhuo end 商品金额促销
			}
		}
	} elseif($type == 1) { //红包
		foreach($newInfo as $key=>$row){

			$arr[$key]['user_id'] = $key;
			$bonus = get_bonus_merchants($bonus_id, $key); //红包信息
			$arr[$key]['bonus'] = $bonus;
		}
	} elseif($type == 2) { //优惠活动
		foreach($newInfo as $key=>$row){
			$arr[$key]['user_id'] = $key;
			$arr[$key]['compute_discount'] = compute_discount($type, $row);
		}
	}

	return $arr;
}

//查询订单中所使用的红包等归属信息，所属商家(ID : bt.user_id)
function get_bonus_merchants($bonus_id = 0, $user_id = 0){
	RC_Loader::load_theme('extras/model/cart/cart_bonus_type_viewmodel.class.php');
	$bt_viewdb = new cart_bonus_type_viewmodel();

	// 	$sql = "select bt.user_id, bt.type_money from " .$GLOBALS['ecs']->table('user_bonus'). " as ub" .
	// 			" left join " .$GLOBALS['ecs']->table('bonus_type'). " as bt on ub.bonus_type_id = bt.type_id" .
	// 			" where ub.bonus_id = '$bonus_id' and bt.user_id = '$user_id'";
	$row = $bt_viewdb->field('t.user_id')->where(array('b.bonus_id' => $bonus_id, 't.user_id' => $user_id))->find();
	// 	return $GLOBALS['db']->getRow($sql);
	return $row;
}

//分单插入数据
function get_insert_order_goods_single($orderInfo, $row, $order_id){
	$newOrder = $orderInfo['newOrder'];
	$orderBonus = $orderInfo['orderBonus'];
	$newInfo = $orderInfo['newInfo'];
	$orderFavourable = $orderInfo['orderFavourable'];
	$surplus = $row['surplus'];//余额
	$integral_money = $row['integral_money'];//积分
	$use_bonus = 0;

	$bonus_id = $row['bonus_id'];//红包ID
	$bonus = $row['bonus'];//红包金额

	$usebonus_type = get_bonus_all_goods($bonus_id); //全场通用红包 val:1
	$payment_method = RC_Loader::load_app_class('payment_method','payment');
	RC_Loader::load_theme('extras/model/cart/cart_order_goods_model.class.php');
	$db_order_goods = new cart_order_goods_model();
	$arr = array();

	foreach($newInfo as $key=>$info){

		$arr[$key] = $info;

		// 插入订单表 start

		$error_no = 0;
		do
		{
			// 			$row['order_sn'] = get_order_child_sn(); //获取新订单号
			$row['order_sn'] = get_order_sn(); //获取新订单号
			$row['main_order_id'] = $order_id; //获取主订单ID
			$row['goods_amount'] = $newOrder[$key]['goods_amount']; //商品总金额

			$row['discount'] = $orderFavourable[$key]['compute_discount']['discount']; //折扣金额
			$row['shipping_fee'] = $newOrder[$key]['shopping_fee']; //运费金额
//			TODO: 优惠活动折扣
//			$row['order_amount'] = $newOrder[$key]['goods_amount'] - $row['discount'] + $row['shipping_fee']; //订单应付金额
			$row['order_amount'] = $newOrder[$key]['goods_amount'] + $row['shipping_fee']; //订单应付金额

			// 减去红包 start
			if($usebonus_type == 1){
				if($bonus > 0){
					if($row['order_amount'] >= $bonus){
						$row['order_amount'] = $row['order_amount'] - $bonus;
						$row['bonus'] = $bonus;
						$bonus = 0;
					}else{
						$bonus = $bonus - $row['order_amount'];
						$row['bonus'] = $row['order_amount'];
						$row['order_amount'] = 0;
					}

					$row['bonus_id'] = $bonus_id;
				}else{
					$row['bonus'] = 0;
					$row['bonus_id'] = 0;
				}

			} else {
				if(isset($orderBonus[$key]['bonus']['type_money'])){
					$use_bonus = min($orderBonus[$key]['bonus']['type_money'], $row['order_amount']); // 实际减去的红包金额
					$row['order_amount'] -= $use_bonus;
					$row['bonus'] = $orderBonus[$key]['bonus']['type_money'];
					$row['bonus_id'] = $row['bonus_id'];
				}else{
					$row['bonus'] = 0;
					$row['bonus_id'] = 0;
				}
			}
			// 减去红包 end

			//余额 start
			if($surplus > 0){
				if($surplus >= $row['order_amount']){
					$surplus = $surplus - $row['order_amount'];
					$row['surplus'] = $row['order_amount']; //订单金额等于当前使用余额
					$row['order_amount'] = 0;
				}else{
					$row['order_amount'] = $row['order_amount'] - $surplus;
					$row['surplus'] = $surplus;
					$surplus = 0;
				}
			}else{
				$row['surplus'] = 0;
			}
			//余额 end

			//积分 start
			if($integral_money > 0){
				if($integral_money >= $row['order_amount']){
					$integral_money = $integral_money - $row['order_amount'];
					$row['integral_money'] = $row['order_amount']; //订单金额等于当前使用余额
					$row['integral'] = $row['order_amount'];
					$row['order_amount'] = 0;
				}else{
					$row['order_amount'] = $row['order_amount'] - $integral_money;
					$row['integral_money'] = $integral_money;
					$row['integral'] = $integral_money;
					$integral_money = 0;
				}
			}else{
				$row['integral_money'] = 0;
				$row['integral'] = 0;
			}
			//积分 end

			$row['order_amount'] = number_format( $row['order_amount'] ,  2 ,  '.',  ''); //格式化价格为一个数字

			/* 如果订单金额为0（使用余额或积分或红包支付），修改订单状态为已确认、已付款 */
			if ($row['order_amount'] <= 0)
			{
				$row['order_status'] = OS_CONFIRMED;
				$row['confirm_time'] = RC_Time::gmtime();
				$row['pay_status']   = PS_PAYED;
				$row['pay_time']     = RC_Time::gmtime();
			}else{
				$row['order_status'] = 0;
				$row['confirm_time'] = 0;
				$row['pay_status']   = 0;
				$row['pay_time']     = 0;
			}

			unset($row['order_id']);

			// 			$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_info'), $row, 'INSERT');
			// 			$new_orderId = $GLOBALS['db']->insert_id();
			RC_Loader::load_theme('extras/model/cart/cart_order_info_model.class.php');
			$db_order_info = new cart_order_info_model();
			$new_orderId = $db_order_info->insert($row);
			// 			$error_no = $GLOBALS['db']->errno();

			// 			if ($error_no > 0 && $error_no != 1062)
			// 			{
			// 				die($GLOBALS['db']->errorMsg());
				// 			}

				// 			$sql = "SELECT seller_email FROM " .$GLOBALS['ecs']->table('seller_shopinfo'). " WHERE ru_id = '$key'";
				// 			$seller_email = $GLOBALS['db']->getOne($sql);

				// 			/* 给商家发邮件 */
				// 			/* 增加是否给客服发送邮件选项 */
				// 			if ($GLOBALS['_CFG']['send_service_email'] && $seller_email != '' && $GLOBALS['_CFG']['seller_email'] == 1)
				// 			{
				// 				$cart_goods = $arr[$key];

				// 				$order['order_sn']          = $row['order_sn']; //订单号
				// 				$order['order_amount']      = $row['order_amount']; //订单金额
				// 				$order['consignee']         = $row['consignee']; //收货人
				// 				$order['address']           = $row['address']; //收货人地址
				// 				$order['tel']               = $row['tel']; //收货人电话
				// 				$order['mobile']            = $row['mobile']; //收货人手机
				// 				$order['shipping_name']     = $row['shipping_name']; //配送方式
				// 				$order['shipping_fee']      = $row['shipping_fee'];  //运费
				// 				$order['pay_id']            = $row['pay_id']; //付款ID
				// 				$order['pay_name']          = $row['pay_name']; //付款名称
				// 				$order['pay_fee']           = $row['pay_fee']; //付款金额
				// 				$order['surplus']           = $row['surplus']; //余额支付
				// 				$order['integral_money']    = $row['integral_money']; //使用积分
				// 				$order['bonus']             = $row['bonus']; //使用红包

				// 				$tpl = get_mail_template('remind_of_new_order');
				// 				$GLOBALS['smarty']->assign('order', $order);
				// 				$GLOBALS['smarty']->assign('goods_list', $cart_goods);
				// 				$GLOBALS['smarty']->assign('shop_name', $GLOBALS['_CFG']['shop_name']);
				// 				$GLOBALS['smarty']->assign('send_date', date($GLOBALS['_CFG']['time_format']));
				// 				$content = $GLOBALS['smarty']->fetch('str:' . $tpl['template_content']);
				// 				send_mail($GLOBALS['_CFG']['shop_name'], $seller_email, $tpl['template_subject'], $content, $tpl['is_html']);
				// 			}
			}
			while ($error_no == 1062); //如果是订单号重复则重新提交数据

			$arr[$key] = array_values($arr[$key]);
			for($j=0; $j<count($arr[$key]); $j++){

				$arr[$key][$j]['order_id'] = $new_orderId;
				unset($arr[$key][$j]['rec_id']);
				$db_order_goods->insert($arr[$key][$j]);
				// 			$GLOBALS['db']->autoExecute($GLOBALS['ecs']->table('order_goods'), $arr[$key][$j], 'INSERT');
			}

			/* 插入支付日志 by wanganlin */
			// 		$row['log_id'] = insert_pay_log($new_orderId, $row['order_amount'], PAY_ORDER);
			/* 插入支付日志 */
			$row['log_id'] = $payment_method->insert_pay_log($new_orderId, $row['order_amount'], PAY_ORDER);
	}
}

//查询订单是否全场通用
function get_bonus_all_goods($bonus_id) {
	RC_Loader::load_theme('extras/model/cart/cart_bonus_type_viewmodel.class.php');
	$bt_viewdb = new cart_bonus_type_viewmodel();
	$type = $bt_viewdb->where(array('b.bonus_id' => $bonus_id))->get_field('usebonus_type');

	// $type = 0;
	// 	$sql = "SELECT t.usebonus_type FROM " .$GLOBALS['ecs']->table('bonus_type') ." as t, " .$GLOBALS['ecs']->table('user_bonus') ." as ub". " WHERE t.type_id = ub.bonus_type_id AND ub.bonus_id = '$bonus_id'";
	// 	return $GLOBALS['db']->getOne($sql);
	return $type;
}


//促销--商品最终金额
function get_con_goods_amount($goods_amount = 0, $goods_id = 0, $type = 0, $shipping_fee = 0, $parent_id = 0){

	if ($parent_id == 0) {
		if($type == 0){
			$table = 'goods_consumption';
		}elseif($type == 1){
			$table = 'goods_conshipping';

			if(empty($shipping_fee)){
				$shipping_fee = 0;
			}
		}

		$res = get_goods_con_list($goods_id, $table, $type);

		if($res){
			$arr = array();
			$arr['amount'] = '';
			foreach($res as $key=>$row){

				if($type == 0){
					if($goods_amount >= $row['cfull']){
						$arr[$key]['cfull'] = $row['cfull'];
						$arr[$key]['creduce'] = $row['creduce'];
						$arr[$key]['goods_amount'] = $goods_amount - $row['creduce'];

						if($arr[$key]['goods_amount'] > 0){
							$arr['amount'] .= $arr[$key]['goods_amount'] . ',';
						}
					}
				}elseif($type == 1){
					if($goods_amount >= $row['sfull']){
						$arr[$key]['sfull'] = $row['sfull'];
						$arr[$key]['sreduce'] = $row['sreduce'];
						if($shipping_fee > 0){ //运费要大于0时才参加商品促销活动
							$arr[$key]['shipping_fee'] = $shipping_fee - $row['sreduce'];
							$arr['amount'] .= $arr[$key]['shipping_fee'] . ',';
						}else{
							$arr['amount'] = '0' . ',';
						}
					}
				}
			}

			if($type == 0){
				if(!empty($arr['amount'])){
					$arr['amount'] = substr($arr['amount'], 0, -1);
				}else{
					$arr['amount'] = $goods_amount;
				}
			}elseif($type == 1){
				if(!empty($arr['amount'])){
					$arr['amount'] = substr($arr['amount'], 0, -1);
				}else{
					$arr['amount'] = $shipping_fee;
				}
			}
		}else{
			if($type == 0){
				$arr['amount'] = $goods_amount;
			}elseif($type == 1){
				$arr['amount'] = $shipping_fee;
			}
		}

		//消费满最大金额免运费
		if ($type == 1) {
			RC_Loader::load_theme('extras/model/cart/cart_goods_model.class.php');
			$db_goods = new cart_goods_model();
			$largest_amount = $db_goods->where(array('goods_id' => $goods_id))->get_field('largest_amount');
			// 			$sql = "select largest_amount from " .$GLOBALS['ecs']->table('goods'). " where goods_id = '$goods_id'";
			// 			$largest_amount = $GLOBALS['db']->getOne($sql);

			if($largest_amount > 0 && $goods_amount > $largest_amount){
				$arr['amount'] = 0;
			}
		}
	} else {
		if ($type == 0) {
			$arr['amount'] = $goods_amount;
		}elseif($type == 1){
			$arr['amount'] = $shipping_fee;
		}
	}

	return $arr;
}

//查询商品满减促销信息
function get_goods_con_list($goods_id = 0, $table, $type = 0){
	$table_model = 'cart_'.$table.'_model';
	RC_Loader::load_theme('extras/b2b2c/model/cart/' . $table_model . '.class.php');
	$db = new $table_model();
	$res = $db->where(array('goods_id' => $goods_id))->select();

	$arr = array();
	foreach($res as $key=>$row){
		$arr[$key]['id'] = $row['id'];
		if($type == 0){
			$arr[$key]['cfull'] = $row['cfull'];
			$arr[$key]['creduce'] = $row['creduce'];
		}elseif($type == 1){
			$arr[$key]['sfull'] = $row['sfull'];
			$arr[$key]['sreduce'] = $row['sreduce'];
		}
	}

	if($type == 0){
		$arr = get_array_sort($arr, 'cfull');
	}elseif($type == 1){
		$arr = get_array_sort($arr, 'sfull');
	}

	return $arr;
}

function get_array_sort($arr,$keys,$type='asc'){

	$new_array = array();
	if(is_array($arr) && !empty($arr)){
		$keysvalue = $new_array = array();
		foreach ($arr as $k=>$v){
			$keysvalue[$k] = $v[$keys];
		}
		if($type == 'asc'){
			asort($keysvalue);
		}else{
			arsort($keysvalue);
		}
		reset($keysvalue);
		foreach ($keysvalue as $k=>$v){
			$new_array[$k] = $arr[$k];
		}
	}

	return $new_array;
}

/*
 *合计运费
*购物车显示
*订单分单
*$type
*/
function get_cart_goods_combined_freight($goods, $type=0, $region = '', $shipping_code = ''){

	$arr = array();
	$new_arr = array();

	if($type == 1){ //购物车显示
		foreach($goods as $key=>$row){
			foreach($row as $warehouse => $rows){
				foreach($rows as $gkey=>$grow){
					@$arr[$key][$warehouse]['weight'] 	+= $grow['goodsWeight'] * $grow['goods_number']; //商品总重量
					@$arr[$key][$warehouse]['goods_price'] 	+= $grow['goods_price'] * $grow['goods_number']; //商品总金额
					@$arr[$key][$warehouse]['number'] 	+= $grow['goods_number']; //商品总数量
					@$arr[$key][$warehouse]['ru_id']	= $key; //商家ID
					@$arr[$key][$warehouse]['warehouse_id']	 = $warehouse; //仓库ID
// 					@$arr[$key][$warehouse]['warehouse_name'] = $GLOBALS['db']->getOne("SELECT region_name FROM " .$GLOBALS['ecs']->table("region_warehouse"). " WHERE region_id = '$warehouse'"); //仓库名称
				}
			}
		}

		foreach($arr as $key=>$row){
			foreach($row as $warehouse => $rows){
				@$arr[$key][$warehouse]['shipping'] = get_goods_freight($rows, $rows['warehouse_id'], $region, $rows['goods_number'], $shipping_code);
			}
		}

		$new_arr['shipping_fee'] = 0;
		foreach($arr as $key=>$row){
			foreach($row as $warehouse => $rows){
				$new_arr['shipping_fee'] += $rows['shipping']['shipping_fee'];
			}
		}

		$arr = array('ru_list' => $arr, 'shipping' => $new_arr);
		return $arr;
	} elseif($type == 2) { //订单分单
		$arr = get_cart_goods_warehouse_list($goods);
// 		$new_arr['shipping_fee'] = 0;
		$shipping_fee = 0;
		foreach($arr as $warehouse=>$row){
			foreach($row as $gw=>$grow){
				@$new_arr[$warehouse]['weight'] 			+= $grow['goodsWeight'] * $grow['goods_number']; //商品总重量
				@$new_arr[$warehouse]['goods_price'] 	+= $grow['goods_price'] * $grow['goods_number']; //商品总金额
				@$new_arr[$warehouse]['number'] 			+= $grow['goods_number']; //商品总数量
				@$new_arr[$warehouse]['ru_id']			 = $grow['ru_id']; //商家ID
				@$new_arr[$warehouse]['warehouse_id']	 = $warehouse; //仓库ID
				@$new_arr[$warehouse]['order_id']		 = $grow['order_id']; //订单ID
// 				@$new_arr[$warehouse]['warehouse_name'] 	 = $GLOBALS['db']->getOne("SELECT region_name FROM " .$GLOBALS['ecs']->table("region_warehouse"). " WHERE region_id = '$warehouse'"); //仓库名称
			}
		}

		foreach($new_arr as $key=>$row){
			RC_Loader::load_theme('extras/model/cart/cart_order_info_model.class.php');
			$db_order_info = new cart_order_info_model();
			$order = $db_order_info->field('country, province, city, district, shipping_id')->find(array('order_id' => $row['order_id']));
// 			$sql = "SELECT country, province, city, district, shipping_id FROM " .$GLOBALS['ecs']->table('order_info'). " WHERE order_id = '" .$row['order_id']. "'";
// 			$order = $GLOBALS['db']->getRow($sql);

			RC_Loader::load_theme('extras/model/cart/cart_shipping_model.class.php');
			$db_shipping  = new cart_shipping_model();
			$shipping_code = $db_shipping->where(array('shipping_id' => $order['shipping_id']))->get_field('shipping_code');
// 			$shipping_code	 	= $GLOBALS['db']->getOne("SELECT shipping_code FROM " .$GLOBALS['ecs']->table("shipping"). " WHERE shipping_id = '" .$order['shipping_id']. "'"); //配送代码
			@$new_arr[$key]['shipping'] = get_goods_freight($row, $row['warehouse_id'], $order, $row['number'], $shipping_code);
				
// 			$new_arr['shipping_fee'] += $new_arr[$key]['shipping']['shipping_fee'];
			$shipping_fee += $new_arr[$key]['shipping']['shipping_fee'];
		}
		$new_arr['shipping_fee'] = $shipping_fee;
		$arr = $new_arr;
	}

	return $arr;
}

function get_cart_goods_warehouse_list($goods){ //仓库划分

	$warehouse_id_list = get_cart_goods_warehouse_id($goods);
	$warehouse_id_list = array_values(array_unique($warehouse_id_list));

	$arr = array();
	foreach ($warehouse_id_list as $wkey=>$warehouse) {
		foreach ($goods as $gkey=>$row) {
			if ($warehouse == $row['warehouse_id']){
				$arr[$warehouse][$gkey] = $row;
			}
		}
	}

	return $arr;
}

function get_cart_goods_warehouse_id($goods){

	$arr = array();
	foreach ($goods as $key=>$row) {
		$arr[$key] = $row['warehouse_id'];
	}

	return $arr;
}

//查询商品的默认配送方式运费金额
function get_goods_freight($goods, $warehouse_id = 0, $goods_region = array(), $buy_number = 1, $shipping_code){
	$shipping_method = RC_Loader::load_app_class('shipping_method', 'shipping');
	// 	$sql = "select shipping_code, shipping_name from " .$GLOBALS['ecs']->table('shipping'). " where shipping_code = '$shipping_code'";
	// 	$shipping = $GLOBALS['db']->getRow($sql);
	if ($goods['ru_id'] > 0 ) {
		$city_configure = get_goods_freight_configure($goods, $warehouse_id, $goods_region['city'], $shipping_code);
		$province_configure = get_goods_freight_configure($goods, $warehouse_id, $goods_region['province'], $shipping_code);

		if(!empty($city_configure)){
			$configure = $city_configure;
		}else{
			$configure = $province_configure;
		}
	} else {
		RC_Loader::load_theme('extras/model/cart/cart_shipping_model.class.php');
		$db = new cart_shipping_model();
		$shipping_id = $db->where(array('shipping_code' => $shipping_code))->get_field('shipping_id');

		$result = $shipping_method->shipping_area_info($shipping_id, $goods_region);
		$configure = $result['configure'];

	}

	$shipping_cfg = sc_unserialize_config($configure);

	// 	$configure_price = goods_shipping_fee($shipping_code, $configure, $goods['weight'], $goods['goods_price'], $goods['number']);
	$configure_price = $shipping_method->shipping_fee($shipping_code, $configure, $goods['weight'], $goods['goods_price'], $goods['number']);
	$arr['shipping_fee'] = $configure_price;
	$arr['configure_price'] = price_format($configure_price, false);
	// 	$arr['shipping_name'] = $shipping['shipping_name'];

	$arr['item_fee'] = price_format($shipping_cfg['item_fee'], false); /* 单件商品的配送价格（默认） */
	$arr['base_fee'] = price_format($shipping_cfg['base_fee'], false); /* N(500或1000克)克以内的价格 */
	$arr['step_fee'] = price_format($shipping_cfg['step_fee'], false); /* 续重每N(500或1000克)克增加的价格 */
	$arr['free_money'] = price_format($shipping_cfg['free_money'], false); //免费额度
	$arr['fee_compute_mode'] = $shipping_cfg['fee_compute_mode']; //费用计算方式
	@$arr['pay_fee'] = price_format($shipping_cfg['pay_fee'], false); //货到付款支付费用

	$arr['warehouse_id'] = $warehouse_id;

	return $arr;
}

//查询商品设置配送地区运费数据
function get_goods_freight_configure($goods, $warehouse_id, $region_id, $shipping_code){

	$user_id = $goods['ru_id'];

// 	$date = array('shipping_id');
// 	$where = "shipping_code = '$shipping_code'";
// 	$shipping_id = get_table_date('shipping', $where, $date, 2);
	RC_Loader::load_theme('extras/model/cart/cart_shipping_model.class.php');
	$shiping_db = new cart_shipping_model();
	$shipping_id = $shiping_db->where(array('shipping_code' => $shipping_code))->get_field('shipping_id');

	RC_Loader::load_theme('extras/b2b2c/model/cart/cart_warehouse_freight_model.class.php');
	$db_warehouse_freight = new cart_warehouse_freight_model();
	$config = $db_warehouse_freight->where(array('user_id' => $user_id, 'warehouse_id' => $warehouse_id, 'shipping_id' => $shipping_id, 'region_id' => $region_id))->get_field('configure');
	return $config;
	
	
// 	$sql = "select configure from " .$GLOBALS['ecs']->table('warehouse_freight'). " where user_id = '$user_id' and warehouse_id = '$warehouse_id' and shipping_id = '$shipping_id' and region_id = '$region_id'";
// 	return $GLOBALS['db']->getOne($sql);
}

/**
 * 处理序列化的支付、配送的配置参数
 * 返回一个以name为索引的数组
 *
 * @access  public
 * @param   string       $cfg
 * @return  void
 */
function sc_unserialize_config($cfg)
{
	if (is_string($cfg) && ($arr = unserialize($cfg)) !== false)
	{
		$config = array();

		foreach ($arr AS $key => $val)
		{
			$config[$val['name']] = $val['value'];
		}

		return $config;
	}
	else
	{
		return false;
	}
}

//end