<?php

class b2b2c_cart_controller {
	
	/**
     * 购物车列表
     */
    public static function init() {
        RC_Loader::load_theme('extras/b2b2c/functions/cart/b2b2c_front_cart.func.php');
        $_SESSION['flow_type'] = CART_GENERAL_GOODS;
        /* 如果是一步购物，跳到结算中心 */
        if (ecjia::config('one_step_buy') == '1') {
            ecjia_front::$controller->showmessage('一步购物，直接进入结算中心', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl'=>RC_Uri::url('flow/checkout')));
        }
        /*取得商品列表，计算合计*/
        $cart_goods = get_cart_list();
        ecjia_front::$controller->assign('goods_list', $cart_goods ['goods_list']);
        ecjia_front::$controller->assign('total', $cart_goods ['total']);
       
        /*购物车的描述的格式化*/
        ecjia_front::$controller->assign('shopping_money', sprintf(RC_Lang::lang('shopping_money'), $cart_goods ['total'] ['goods_price']));
        ecjia_front::$controller->assign('market_price_desc', sprintf(RC_Lang::lang('than_market_price'), $cart_goods ['total'] ['market_price'], $cart_goods ['total'] ['saving'], $cart_goods ['total'] ['save_rate']));
        /*计算折扣*/
        $discount = compute_discount();
        ecjia_front::$controller->assign('discount', $discount ['discount']);
        /*折扣信息*/
        $favour_name = empty($discount ['name']) ? '' : join(',', $discount ['name']);
        ecjia_front::$controller->assign('your_discount', sprintf(RC_Lang::lang('your_discount'), $favour_name, price_format($discount ['discount'])));
        /*增加是否在购物车里显示商品图*/
        ecjia_front::$controller->assign('show_goods_thumb', ecjia::config('show_goods_in_cart'));
        /*增加是否在购物车里显示商品属性*/
        ecjia_front::$controller->assign('show_goods_attribute', ecjia::config('show_attr_in_cart'));
        /*取得购物车中基本件ID*/
        /*根据基本件id获取 购物车中商品配件列表*/
        ecjia_front::$controller->assign('currency_format', ecjia::config('currency_format'));
        ecjia_front::$controller->assign('integral_scale', ecjia::config('integral_scale'));
        ecjia_front::$controller->assign('step', 'cart');
        ecjia_front::$controller->assign('title', RC_Lang::lang('shopping_cart'));
        ecjia_front::$controller->assign_title(RC_Lang::lang('shopping_cart'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('cart_list.dwt');

//        /*取得优惠活动*/
//        $favourable_list = favourable_list_flow($_SESSION ['user_rank']);
//        usort($favourable_list, array("FlowModel", "cmp_favourable"));
//        ecjia_front::$controller->assign('favourable_list', $favourable_list);
    }

    /**
     * 立即购买
     */
    public static function add_to_cart() {
        RC_Loader::load_theme('extras/function/cart/front_cart.func.php'); 
        RC_Loader::load_theme('extras/model/cart/cart_goods_model.class.php'); 
        RC_Loader::load_theme('extras/model/cart/cart_attribute_viewmodel.class.php');
        $db_goods                = new cart_goods_model();
        $db_attribute_viewmodel  = new cart_attribute_viewmodel();
        /*对goods处理*/
        $goods = $_POST['goods'];
        if (empty($goods)) {
            ecjia_front::$controller->showmessage('添加到购物车失败', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
        /*初始化返回数组*/
        $result = array(
            'error'     => 0,
            'message'   => '',
            'content'   => '',
            'goods_id'  => ''
        );
        /*检查：如果商品有规格，而post的数据没有规格，把商品的规格属性通过JSON传到前台*/
        if (empty($goods['spec']) && empty($goods['quick'])) {
            $where = array(
                'a.attr_type'   => array('neq'=>0),
                'ga.goods_id'   => $goods['goods_id']
            );
            $orderby = array(
                'a.sort_order'      => 'desc',
                'ga.attr_price'     => 'desc',
                'ga.goods_attr_id'  => 'desc'
            );
            $res = $db_attribute_viewmodel->join('goods_attr')->where($where)->field('a.attr_id, a.attr_name, a.attr_type, ga.goods_attr_id, ga.attr_value, ga.attr_price')->order($orderby)->select();
            if (!empty($res)) {
                $spe_arr = array();
                foreach ($res as $row) {
                    $spe_arr [$row ['attr_id']] ['attr_type'] = $row ['attr_type'];
                    $spe_arr [$row ['attr_id']] ['name'] = $row ['attr_name'];
                    $spe_arr [$row ['attr_id']] ['attr_id'] = $row ['attr_id'];
                    $spe_arr [$row ['attr_id']] ['values'] [] = array(
                        'label'         => $row ['attr_value'],
                        'price'         => $row ['attr_price'],
                        'format_price'  => price_format($row ['attr_price'], false),
                        'id'            => $row ['goods_attr_id']
                    );
                }
                $i = 0;
                $spe_array = array();
                foreach ($spe_arr as $row) {
                    $spe_array [] = $row;
                }
                $result ['error']    = ERR_NEED_SELECT_ATTR;
                $result ['goods_id'] = $goods['goods_id'];
                $result ['parent']   = $goods['parent'];
                $result ['message']  = $spe_array;
                ecjia_front::$controller->showmessage('选择商品规格', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, $result);
            }
        }
        /* 更新：如果是一步购物，先清空购物车 */
        if (ecjia::config('one_step_buy') == '1') {
            clear_cart();
        }
        /*查询：系统启用了库存，检查输入的商品数量是否有效*/
        $arrGoods       = $db_goods->field('goods_name,goods_number,extension_code')->where(array('goods_id'=>$goods['goods_id']))->find();
        $goodsnmber     = get_goods_number($goods['goods_id']);
        $goodsnmber     += $goods['number'];
        if (intval(ecjia::config('use_storage')) > 0 && $arrGoods['extension_code'] != 'package_buy') {
            if ($arrGoods ['goods_number'] < $goodsnmber) {
                $message = sprintf(RC_Lang::lang('stock_insufficiency'), $arrGoods ['goods_name'], $arrGoods ['goods_number'], $arrGoods ['goods_number']);
                ecjia_front::$controller->showmessage($message, ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
            }
        }
        /*检查：商品数量是否合法*/
        if (!is_numeric($goods['number']) || intval($goods['number']) <= 0) {
            ecjia_front::$controller->showmessage(RC_Lang::lang('invalid_number'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        } else {
            /*更新：添加到购物车*/
            // var_dump($goods['goods_id'], $goods['number'], $goods['spec'], $goods['parent']);die;
            $res_add = addto_cart($goods['goods_id'], $goods['number'], $goods['spec'], $goods['parent']);
            if (!is_ecjia_error($res_add)){
                if (ecjia::config('cart_confirm') > 2) {
                    $message = '';
                } else {
                    $message = ecjia::config('cart_confirm') == 1 ? RC_Lang::lang('addto_cart_success_1') : RC_Lang::lang('addto_cart_success_2');
                }
                ecjia_front::$controller->showmessage('商品成功加入购物车', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON,array('is_show' => true,'link' =>RC_Uri::url('goods/index/init&id='.$goods['goods_id'])));
            } else {
                ecjia_front::$controller->showmessage($res_add->get_error_message(), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
            }
        }
    } 

     /**
     *  提交订单
     * bonus 0 //红包
     * how_oos 0 //缺货处理
     * integral 0 //积分
     * payment 3 //支付方式
     * postscript //订单留言
     * shipping 3 //配送方式
     * surplus 0 //余额
     * inv_type 4 //发票类型
     * inv_payee 发票抬头
     * inv_content 发票内容
     */
    public static function done() {


        RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
        RC_Loader::load_theme('extras/model/cart/cart_order_info_model.class.php');
        RC_Loader::load_theme('extras/model/cart/cart_order_goods_model.class.php');
        RC_Loader::load_theme('extras/model/cart/cart_goods_activity_model.class.php');
        RC_Loader::load_theme('extras/model/cart/cart_user_bonus_model.class.php');
        $db_cart            = new cart_model();
        $db_order_info      = new cart_order_info_model();
        $db_order_goods     = new cart_order_goods_model();
        $db_goods_activity  = new cart_goods_activity_model();
        $db_user_bonus      = new cart_user_bonus_model();
        RC_Loader::load_theme("extras/b2b2c/functions/cart/b2b2c_front_cart.func.php");
        /* 取得购物类型 */
        $rec_id = $_POST['rec_id'];
        if(empty($rec_id)){
            ecjia_front::$controller->showmessage('请选择商品再进行结算', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
        $payment = $_POST['payment'];
        if(empty($payment)){
            ecjia_front::$controller->showmessage('请选择支付方式', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
        $shipping = $_POST['shipping'];
        if(empty($shipping)){
            ecjia_front::$controller->showmenssage('请选择配送方式', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
        $flow_type = isset($_SESSION ['flow_type']) ? intval($_SESSION ['flow_type']) : CART_GENERAL_GOODS;
        /* 检查购物车中是否有商品 */
        $where = array(
            'session_id'    => SESS_ID,
            'parent_id'     => 0,
            'is_gift'       => 0,
            'rec_type'      => $flow_type,
            'rec_id'        => $rec_id,
        );
        $count = $db_cart->where($where)->count('*');
        if (empty($count)) {
            ecjia_front::$controller->showmessage(RC_Lang::lang('no_goods_in_cart'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
        /* 如果使用库存，且下订单时减库存，则减少库存 */
        if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
            $cart_goods_stock = get_cart_goods();
            $_cart_goods_stock = array();
            foreach ($cart_goods_stock ['goods_list'] as $value) {
                $_cart_goods_stock [$value ['rec_id']] = $value ['goods_number'];
            }
            $result = flow_cart_stock($_cart_goods_stock);
            if (is_ecjia_error($result)) {
                ecjia_front::$controller->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            unset($cart_goods_stock, $_cart_goods_stock);
        }
        /*检查用户是否已经登录 如果用户已经登录了则检查是否有默认的收货地址 如果没有登录则跳转到登录和注册页面*/
        if (empty($_SESSION ['direct_shopping']) && $_SESSION ['user_id'] == 0) {
            //TODO: 增加语言包“请您登陆或者选择匿名购买”
            ecjia_front::$controller->showmessage('请您登陆或者选择匿名购买', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON,array('pjaxurl'=>RC_Uri::url('user/login')));
        }
        /*获取收货人信息*/
        $consignee = get_consignee($_SESSION ['user_id']);
        /* 检查收货人信息是否完整 */
        if (!check_consignee_info($consignee, $flow_type)) {
            /* 如果不完整则转向到收货人信息填写界面 */
            ecjia_front::$controller->showmessage('您填写的收货人信息不完整', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl'=> RC_Uri::url('flow/consignee')));
        }
        /*处理接收信息*/
        $how_oos        = htmlspecialchars($_POST['how_oos']);
        $card_message   = htmlspecialchars($_POST['card_message']);
        $inv_type       = htmlspecialchars($_POST['inv_type']);
        $inv_payee      = htmlspecialchars($_POST['inv_payee']);
        $inv_content    = htmlspecialchars($_POST['inv_content']);
        $postscript     = htmlspecialchars($_POST['postscript']);
        $oos            = RC_Lang::lang('oos.' . $how_oos);
        /*订单信息*/
        $order = array(
            'shipping_id'       => htmlspecialchars($_POST['shipping']),
            'pay_id'            => htmlspecialchars($_POST['payment']),
            'pack_id'           => htmlspecialchars($_POST['pack'], 0),
            'card_id'           => isset($_POST ['card']) ? intval($_POST ['card']) : 0,
            'card_message'      => trim($_POST ['card_message']),
            'surplus'           => isset($_POST ['surplus']) ? floatval($_POST ['surplus']) : 0.00,
            'integral'          => isset($_POST ['integral']) ? intval($_POST ['integral']) : 0,
            'bonus_id'          => isset($_POST ['bonus']) ? intval($_POST ['bonus']) : 0,
            'need_inv'          => empty($_POST ['need_inv']) ? 0 : 1,
            'inv_type'          => $_POST ['inv_type'],
            'inv_payee'         => trim($_POST ['inv_payee']),
            'inv_content'       => $_POST ['inv_content'],
            'postscript'        => trim($_POST ['postscript']),
            'how_oos'           => isset($oos) ? addslashes("$oos") : '',
            'need_insure'       => isset($_POST ['need_insure']) ? intval($_POST ['need_insure']) : 0,
            'user_id'           => $_SESSION ['user_id'],
            'add_time'          => RC_Time::gmtime(),
            'order_status'      => OS_UNCONFIRMED,
            'shipping_status'   => SS_UNSHIPPED,
            'pay_status'        => PS_UNPAYED,
            'mobile_order'      => 1,
            'mobile_pay'        => 1,
            'agency_id'         => get_agency_by_regions(array($consignee ['country'], $consignee ['province'], $consignee ['city'], $consignee ['district']))
        );
        
        /* 扩展信息 */
        if (isset($_SESSION['flow_type']) && intval($_SESSION['flow_type']) != CART_GENERAL_GOODS) {
            $order['extension_code'] = $_SESSION['extension_code'];
            $order['extension_id'] = $_SESSION['extension_id'];
        } else {
            $order['extension_code'] = '';
            $order['extension_id'] = 0;
        }
        /* 检查积分余额是否合法 */
        $user_id = $_SESSION['user_id'];
        if ($user_id > 0) {
            $user_info = user_info($user_id);
            $order ['surplus'] = min($order ['surplus'], $user_info ['user_money'] + $user_info ['credit_line']);
            if ($order ['surplus'] < 0) {
                $order ['surplus'] = 0;
            }
            /*查询用户有多少积分*/
            $flow_points = flow_available_points(); // 该订单允许使用的积分
            $user_points = $user_info['pay_points']; // 用户的积分总数
            
            $order['integral'] = min($order['integral'], $user_points, $flow_points);
            if ($order['integral'] < 0) {
                $order['integral'] = 0;
            }
        } else {
            $order['surplus'] = 0;
            $order['integral'] = 0;
        }

        /* 检查红包是否存在 */
        if ($order ['bonus_id'] > 0) {
            $bonus = bonus_info($order ['bonus_id']);
            if (empty($bonus) || $bonus ['user_id'] != $user_id || $bonus ['order_id'] > 0 || $bonus ['min_goods_amount'] > cart_amount(true, $flow_type)) {
                $order ['bonus_id'] = 0;
            }
        } elseif (isset($_POST['bonus_sn'])) {
            $bonus_sn = trim($_POST['bonus_sn']);
            $bonus = bonus_info(0, $bonus_sn);
            $now = RC_Time::gmtime();
            if (empty($bonus) || $bonus ['user_id'] > 0 || $bonus ['order_id'] > 0 || $bonus ['min_goods_amount'] > cart_amount(true, $flow_type) || $now > $bonus ['use_end_date']) {
            } else {
                if ($user_id > 0) {
                    $data = array(
                        'user_id' => $user_id
                    );
                    $user_bonus = $db_user_bonus->where(array('bonus_id'=>$bonus['bonus_id']))->limit(1)->update($data);
                }
                $order ['bonus_id'] = $bonus ['bonus_id'];
                $order ['bonus_sn'] = $bonus_sn;
            }
        }
        
        /* 订单中的商品 */
        $cart_goods = cart_goods($flow_type,$rec_id);
        if (empty($cart_goods)) {
            ecjia_front::$controller->showmessage(RC_Lang::lang('no_goods_in_cart'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
        /* 检查商品总额是否达到最低限购金额 */
        if ($flow_type == CART_GENERAL_GOODS && cart_amount(true, CART_GENERAL_GOODS) < ecjia::config('min_goods_amount')) {
            ecjia_front::$controller->showmessage(sprintf(RC_Lang::lang('goods_amount_not_enough'), price_format(ecjia::config('min_goods_amount'), false)),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
        /* 收货人信息 */
        foreach ($consignee as $key => $value) {
            $order [$key] = addslashes($value);
        }
        /* 判断是不是实体商品 */
        foreach ($cart_goods as $val) {
            /* 统计实体商品的个数 */
            if ($val ['is_real']) {
                $is_real_good = 1;
            }
        }
        $shipping_method    = RC_Loader::load_app_class('shipping_method', 'shipping');
        $payment_method     = RC_Loader::load_app_class('payment_method', 'payment');
        if (isset($is_real_good)) {
            $res = $shipping_method->shipping_info($order ['shipping_id']);
            if (!$res) {
                ecjia_front::$controller->showmessageg(RC_Lang::lang('flow_no_shipping'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
            }
        }
        /* 订单中的总额 */
        $total                      = order_fee($order, $cart_goods, $consignee);
        $order ['bonus']            = $total ['bonus'];
        $order ['goods_amount']     = $total ['goods_price'];
        $order ['discount']         = $total ['discount'];
        $order ['surplus']          = $total ['surplus'];
        $order ['tax']              = $total ['tax'];
        /*购物车中的商品能享受红包支付的总额*/
        $discount_amout = compute_discount_amount();
        /*红包和积分最多能支付的金额为商品总额*/
        $temp_amout = $order ['goods_amount'] - $discount_amout;
        if ($temp_amout <= 0) {
            $order ['bonus_id'] = 0;
        }
        /* 配送方式 */
        if ($order ['shipping_id'] > 0) {
            $shipping = $shipping_method->shipping_info($order ['shipping_id']);
            $order ['shipping_name'] = addslashes($shipping ['shipping_name']);
        }
        $order ['shipping_fee'] = $total ['shipping_fee'];
        $order ['insure_fee'] = $total ['shipping_insure'];
        /* 支付方式 */
        if ($order ['pay_id'] > 0) {
            $payment            = $payment_method->payment_info($order ['pay_id']);
            $order ['pay_name'] = addslashes($payment ['pay_name']);
        }
        $order ['pay_fee']      = $total ['pay_fee'];
        $order ['cod_fee']      = $total ['cod_fee'];
        $order ['card_fee']     = $total ['card_fee'];
        $order ['order_amount'] = number_format($total ['amount'], 2, '.', '');
        /* 如果全部使用余额支付，检查余额是否足够 */
        if ($payment ['pay_code'] == 'balance' && $order ['order_amount'] > 0) {
            if ($order ['surplus'] > 0) {// 余额支付里如果输入了一个金额
                $order ['order_amount'] = $order ['order_amount'] + $order ['surplus'];
                $order ['surplus'] = 0;
            }
            if ($order ['order_amount'] > ($user_info ['user_money'] + $user_info ['credit_line'])) {
                ecjia_front::$controller->showmessage(RC_Lang::lang('balance_not_enough'),ecjia::MSGSTAT_ERROR |ecjia::MSGTYPE_JSON);
            } else {
                $order ['surplus'] = $order ['order_amount'];
                $order ['order_amount'] = 0;
            }
        }
        /* 如果订单金额为0（使用余额或积分或红包支付），修改订单状态为已确认、已付款 */
        if ($order ['order_amount'] <= 0) {
            $order ['order_status'] = OS_CONFIRMED;
            $order ['confirm_time'] = RC_Time::gmtime();
            $order ['pay_status']   = PS_PAYED;
            $order ['pay_time']     = RC_Time::gmtime();
            $order ['order_amount'] = 0;
        }
        $order ['integral_money']   = $total ['integral_money'];
        $order ['integral']         = $total ['integral'];
        if ($order ['extension_code'] == 'exchange_goods') {
            $order ['integral_money']   = 0;
            $order ['integral']         = $total ['exchange_integral'];
        }
        $order ['from_ad']              = !empty($_SESSION ['from_ad']) ? $_SESSION ['from_ad'] : '0';
        $order ['referer']              = !empty($_SESSION ['referer']) ? addslashes($_SESSION ['referer']) : '';
        /* 记录扩展信息 */
        if ($flow_type != CART_GENERAL_GOODS) {
            $order ['extension_code']   = $_SESSION ['extension_code'];
            $order ['extension_id']     = $_SESSION ['extension_id'];
        }
        $affiliate = unserialize(ecjia::config('affiliate'));
        if (isset($affiliate ['on']) && $affiliate ['on'] == 1 && $affiliate ['config'] ['separate_by'] == 1) {
            /*推荐订单分成*/
            $parent_id = get_affiliate();
            if ($user_id == $parent_id) {
                $parent_id = 0;
            }
        } elseif (isset($affiliate ['on']) && $affiliate ['on'] == 1 && $affiliate ['config'] ['separate_by'] == 0) {
            /*推荐注册分成*/
            $parent_id = 0;
        } else {
            /*分成功能关闭*/
            $parent_id = 0;
        }
        $order ['parent_id'] = $parent_id;
        /* 插入订单表 */
        $order['order_sn'] = get_order_sn(); // 获取新订单号
        $new_order_id = $db_order_info->insert($order);
        $order['order_id'] = $new_order_id;

        /* 插入订单商品 */
        $field = 'goods_id, goods_name, goods_sn, product_id, goods_number, market_price,goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id, ru_id';
        if ($_SESSION['user_id']) {
            $cart_where = array_merge($cart_where, array('user_id' =>$_SESSION['user_id'], 'session_id' => SESS_ID));
            $data_row = $db_cart->field($field)->where($cart_where)->in(array('rec_id' => $rec_id))->select();
        } else {
            $cart_where = array_merge($cart_where, array('session_id' =>SESS_ID));
            $data_row = $db_cart->field($field)->where($cart_where)->in(array('rec_id' => $rec_id))->select();
        }
        if (!empty($data_row)) {
            $area_id = $consignee['province'];
            //多店铺开启库存管理以及地区后才会去判断
            $warehouse_id = 0;
            if ( $area_id > 0 ) {
                RC_Loader::load_theme('extras/b2b2c/model/cart/cart_warehouse_model.class.php');
                $warehouse_db = new cart_warehouse_model();
                $warehouse = $warehouse_db->where(array('regionId' => $area_id))->find();
                $warehouse_id = $warehouse['parent_id'];
            }
            foreach ($data_row as $row) {
                $arr = array(
                        'order_id' => $new_order_id,
                        'goods_id' => $row['goods_id'],
                        'goods_name' => $row['goods_name'],
                        'goods_sn' => $row['goods_sn'],
                        'product_id' => $row['product_id'],
                        'goods_number' => $row['goods_number'],
                        'market_price' => $row['market_price'],
                        'goods_price' => $row['goods_price'],
                        'goods_attr' => $row['goods_attr'],
                        'is_real' => $row['is_real'],
                        'extension_code' => $row['extension_code'],
                        'parent_id' => $row['parent_id'],
                        'is_gift' => $row['is_gift'],
                        'goods_attr_id' => $row['goods_attr_id'],
                        'ru_id'     => $row['ru_id'],
                        'area_id'   => $area_id,
                        'warehouse_id'  => $warehouse_id,
                );
                $db_order_goods->insert($arr);
            }
        }

        /* 修改拍卖活动状态 */
        if ($order['extension_code'] == 'auction') {
            $db_goods_activity->where(array('act_id' => $order['extension_id']))->update(array('is_finished' => 2));
        }
        
        /* 处理余额、积分、红包 */
        if ($order ['user_id'] > 0 && $order ['surplus'] > 0) {
            log_account_change($order ['user_id'], $order ['surplus'] * (- 1), 0, 0, 0, sprintf(RC_Lang::lang('pay_order'), $order ['order_sn']));
        }
        if ($order ['user_id'] > 0 && $order ['integral'] > 0) {
            log_account_change($order ['user_id'], 0, 0, 0, $order ['integral'] * (- 1), sprintf(RC_Lang::lang('pay_order'), $order ['order_sn']));
        }
        if ($order ['bonus_id'] > 0 && $temp_amout > 0) {
            use_bonus($order ['bonus_id'], $new_order_id);
        }
        /* 如果使用库存，且下订单时减库存，则减少库存 */
        if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
            change_order_goods_storage($order ['order_id'], true, SDT_PLACE);
        }
        /* 给商家发邮件 */
        if (ecjia::config('send_service_email') && ecjia::config('service_email') != '') {
            $tpl = get_mail_template('remind_of_new_order');
            ecjia_front::$controller->assign('order', $order);
            ecjia_front::$controller->assign('goods_list', $cart_goods);
            ecjia_front::$controller->assign('shop_name', ecjia::config('shop_name'));
            ecjia_front::$controller->assign('send_date', date(ecjia::config('time_format')));
            $content = ecjia_front::$controller->fetch_string($tpl ['template_content']);
            RC_Mail::send_mail(ecjia::config('shop_name'), ecjia::config('service_email'), $tpl ['template_subject'], $content, $tpl ['is_html']);
        }
        //TODO:短信通知
        //TODO:微信通知
        /* 如果订单金额为0 处理虚拟卡 */
        if ($order['order_amount'] <= 0) {
//          $cart_w = array_merge($cart_w, array('rec_id' => $cart_id));
            if ($_SESSION['user_id']) {
                $res = $db_cart->field('goods_id, goods_name, goods_number AS num')->where(array('is_real' => 0 , 'extension_code' => 'virtual_card' , 'user_id' =>  $_SESSION['user_id'] , 'rec_type' => $flow_type))->select();
            } else {
                $res = $db_cart->field('goods_id, goods_name, goods_number AS num')->where(array('is_real' => 0 , 'extension_code' => 'virtual_card' , 'session_id' =>  SESS_ID , 'rec_type' => $flow_type))->select();
            }
            $virtual_goods = array();
            foreach ($res as $row) {
                $virtual_goods['virtual_card'][] = array(
                    'goods_id' => $row['goods_id'],
                    'goods_name' => $row['goods_name'],
                    'num' => $row['num']
                );
            }

            if ($virtual_goods and $flow_type != CART_GROUP_BUY_GOODS) {
                /* 虚拟卡发货 */
                if (virtual_goods_ship($virtual_goods, $msg, $order ['order_sn'], true)) {
                    RC_Loader::load_theme("extras/model/cart/cart_order_goods_model.class.php");
                    $db_order_goods = new cart_order_goods_model(); 
                    /* 如果没有实体商品，修改发货状态，送积分和红包 */
                    $where = array(
                        'order_id'  => $order[order_id],
                        'is_real'   => 1
                    );
                    $count = $db_order_goods->where($where)->get_field('COUNT(*)');
                    if ($count <= 0) {
                        /* 修改订单状态 */
                        update_order($order ['order_id'], array(
                        'shipping_status' => SS_SHIPPED,
                        'shipping_time' => RC_Time::gmtime()
                        ));
                        /* 如果订单用户不为空，计算积分，并发给用户；发红包 */
                        if ($order ['user_id'] > 0) {
                            /* 取得用户信息 */
                            $user = user_info($order ['user_id']);
                            /* 计算并发放积分 */
                            $integral = integral_to_give($order);
                            log_account_change($order ['user_id'], 0, 0, intval($integral ['rank_points']), intval($integral ['custom_points']), sprintf(RC_Lang::lang('order_gift_integral'), $order ['order_sn']));//model('ClipsBase')->
                            /* 发放红包 */
                            send_order_bonus($order ['order_id']);
                        }
                    }
                }
            }
        }
        
        /* 清空购物车 */
       clear_cart($flow_type, $rec_id);
        /* 清除缓存，否则买了商品，但是前台页面读取缓存，商品数量不减少 */
        //TODO:缓存处理
        /* 插入支付日志 */
        $order ['log_id'] = insert_pay_log($new_order_id, $order ['order_amount'], PAY_ORDER);
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
            // /* 这是一个支付的抽象类payment_abstract */
            // $pay_online = $handler->get_code(payment_abstract::PAYCODE_PARAM);
            // $pay_code = $payment_method->payment_info_by_name($pay_online['pay_name']);
            // $pay_code = array_column($pay_code,'pay_code');
            // if(in_array('pay_cod',$pay_code)|| in_array('pay_bank', $pay_code)){
            //     if(in_array('pay_cod',$pay_code)){
            //         $link = RC_uri::url('user/user_order/order_list').'&status=unshipped';
            //     }elseif(in_array('pay_bank', $pay_code)){
            //         $link = RC_uri::url('user/user_order/order_list');
            //     }
            //     $pay_online_btn = '<a class="btn btn-info nopjax" href="' . $link . '">去订单列表查看订单</a>';
            // }else{
            //     $pay_online_btn = '<a class="btn btn-info nopjax" href="' . $pay_online['pay_online'] . '">去' . $pay_online['pay_name'] . '支付</a>';
            // }
            // ecjia_front::$controller->assign('pay_online', $pay_online_btn);
            
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
            ecjia_front::$controller->assign('pay_online', $order['handler']);
        }
        
        if (!empty($order ['shipping_name'])) {
            $order ['shipping_name'] = trim(stripcslashes($order ['shipping_name']));
        }

        if ($payment ['pay_code'] != 'balance') {
            /* 生成订单后，修改支付，配送方式 */
            /*支付方式*/
            $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
            $payment_list   = empty($payment_method) ? array() : $payment_method->available_payment_list(1, $cod_fee);
            if (isset($payment_list)) {
                foreach ($payment_list as $key => $payment) {
                    /* 如果有易宝神州行支付 如果订单金额大于300 则不显示 */
                    if ($payment ['pay_code'] == 'yeepayszx' && $total ['amount'] > 300) {
                        $payment_list [$key];
                    }
                    /*过滤掉当前的支付方式*/
                    if ($payment ['pay_id'] == $order ['pay_id']) {
                        unset($payment_list [$key]);
                    }
                    /* 如果有余额支付 */
                    if ($payment ['pay_code'] == 'balance') {
                        /* 如果未登录，不显示 */
                        if ($_SESSION ['user_id'] == 0) {
                            unset($payment_list [$key]);
                        } else {
                            if ($_SESSION ['flow_order'] ['pay_id'] == $payment ['pay_id']) {
                                ecjia_front::$controller->assign('disable_surplus', 1);
                            }
                        }
                    }
                }
            }
            ecjia_front::$controller->assign('payment_list', $payment_list);
            ecjia_front::$controller->assign('pay_code', 'no_balance');
        }

        //订单分子订单 start
        $order_id = $order['order_id'];
        $row = get_main_order_info($order_id);
        $order_info = get_main_order_info($order_id, 1);
        $ru_id = explode(",", $order_info['all_ruId']['ru_id']);

        if(count($ru_id) > 1){
            get_insert_order_goods_single($order_info, $row, $order_id);
        }
        /* 订单信息 */
        ecjia_front::$controller->assign('order', $order);
        ecjia_front::$controller->assign('total', $total);
        ecjia_front::$controller->assign('goods_list', $cart_goods);
        ecjia_front::$controller->assign('order_submit_back', sprintf(RC_Lang::lang('order_submit_back'), RC_Lang::lang('back_home'), RC_Lang::lang('goto_user_center')));
        user_uc_call('add_feed', array($order ['order_id'], BUY_GOODS));// 推送feed到uc
        unset($_SESSION ['flow_consignee']); // 清除session中保存的收货人信息
        unset($_SESSION ['flow_order']);
        unset($_SESSION ['direct_shopping']);
        ecjia_front::$controller->assign('currency_format', ecjia::config('currency_format'));
        ecjia_front::$controller->assign('integral_scale', ecjia::config('integral_scale'));
        ecjia_front::$controller->assign('step', ROUTE_A);
        ecjia_front::$controller->assign('title', RC_Lang::lang('order_submit'));
        ecjia_front::$controller->assign_title(RC_Lang::lang('order_submit'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('flow_done.dwt');
    
        // $address_id = intval($_POST['address_id']);
        // if (empty($address_id)) {
        //  $consignee = get_consignee($_SESSION['user_id']);
        // } else {
        //  $db_user_address = RC_Loader::load_app_model('user_address_model');
        //  $consignee = $db_user_address->find(array('address_id' => $address_id, 'user_id' => $_SESSION['user_id']));
        // }
        
    }
    
    
}

// end