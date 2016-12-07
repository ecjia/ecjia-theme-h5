<?php
/**
 * 购物车模块控制器代码
 */
class cart_controller {
    /**
     * 购物车列表
     */
    public static function init() {
        // $_SESSION['flow_type'] = CART_GENERAL_GOODS;
        // /* 如果是一步购物，跳到结算中心 */
        // if (ecjia::config('one_step_buy') == '1') {
        //     ecjia_front::$controller->showmessage('一步购物，直接进入结算中心', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl'=>RC_Uri::url('flow/checkout')));
        // }
        // /*取得商品列表，计算合计*/
        // $cart_goods = get_cart_goods();
        // ecjia_front::$controller->assign('goods_list', $cart_goods ['goods_list']);
        // ecjia_front::$controller->assign('total', $cart_goods ['total']);
        // if ($cart_goods['goods_list']) {
        //     /*相关产品*/
        //     $linked_goods = get_linked_goods($cart_goods ['goods_list']);
        //     ecjia_front::$controller->assign('linked_goods', $linked_goods);
        // }
        // /*购物车的描述的格式化*/
        // ecjia_front::$controller->assign('shopping_money', sprintf(RC_Lang::lang('shopping_money'), $cart_goods ['total'] ['goods_price']));
        // ecjia_front::$controller->assign('market_price_desc', sprintf(RC_Lang::lang('than_market_price'), $cart_goods ['total'] ['market_price'], $cart_goods ['total'] ['saving'], $cart_goods ['total'] ['save_rate']));
        // /*计算折扣*/
        // $discount = compute_discount();
        // ecjia_front::$controller->assign('discount', $discount ['discount']);
        // /*折扣信息*/
        // $favour_name = empty($discount ['name']) ? '' : join(',', $discount ['name']);
        // ecjia_front::$controller->assign('your_discount', sprintf(RC_Lang::lang('your_discount'), $favour_name, price_format($discount ['discount'])));
        // /*增加是否在购物车里显示商品图*/
        // ecjia_front::$controller->assign('show_goods_thumb', ecjia::config('show_goods_in_cart'));
        // /*增加是否在购物车里显示商品属性*/
        // ecjia_front::$controller->assign('show_goods_attribute', ecjia::config('show_attr_in_cart'));
        //
        // ecjia_front::$controller->assign('currency_format', ecjia::config('currency_format'));
        // ecjia_front::$controller->assign('integral_scale', ecjia::config('integral_scale'));
        // ecjia_front::$controller->assign('step', 'cart');
        ecjia_front::$controller->assign('title', RC_Lang::lang('shopping_cart'));
        ecjia_front::$controller->assign_title(RC_Lang::lang('shopping_cart'));
        ecjia_front::$controller->assign_lang();
    	ecjia_front::$controller->assign('active', 3);
        ecjia_front::$controller->display('cart_list.dwt');
    }
    /**
     * 立即购买
     */
    public static function add_to_cart() {
        // $db_goods = RC_Loader::load_app_model ( "cart_goods_model" );
        // $db_attribute_viewmodel = RC_Loader::load_app_model ( "attribute_viewmodel" );
        // RC_Loader::load_theme('extras/model/cart/cart_goods_model.class.php');
        // RC_Loader::load_theme('extras/model/cart/cart_attribute_viewmodel.class.php');
        // $db_goods                = new cart_goods_model();
        // $db_attribute_viewmodel  = new cart_attribute_viewmodel();
        // /*对goods处理*/
        // $goods = $_POST['goods'];
        // if (empty($goods)) {
        //     ecjia_front::$controller->showmessage('添加到购物车失败', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // }
        // /*初始化返回数组*/
        // $result = array(
        //     'error'     => 0,
        //     'message'   => '',
        //     'content'   => '',
        //     'goods_id'  => ''
        // );
        // /*检查：如果商品有规格，而post的数据没有规格，把商品的规格属性通过JSON传到前台*/
        // if (empty($goods['spec']) && empty($goods['quick'])) {
        //     $where = array(
        //         'a.attr_type'	=> array('neq'=>0),
        //         'ga.goods_id'	=> $goods['goods_id']
        //     );
        //     $orderby = array(
        //         'a.sort_order'		=> 'desc',
        //         'ga.attr_price'		=> 'desc',
        //         'ga.goods_attr_id'	=> 'desc'
        //     );
        //     $res = $db_attribute_viewmodel->join('goods_attr')->where($where)->field('a.attr_id, a.attr_name, a.attr_type, ga.goods_attr_id, ga.attr_value, ga.attr_price')->order($orderby)->select();
        //     if (!empty($res)) {
        //         $spe_arr = array();
        //         foreach ($res as $row) {
        //             $spe_arr [$row ['attr_id']] ['attr_type'] = $row ['attr_type'];
        //             $spe_arr [$row ['attr_id']] ['name'] = $row ['attr_name'];
        //             $spe_arr [$row ['attr_id']] ['attr_id'] = $row ['attr_id'];
        //             $spe_arr [$row ['attr_id']] ['values'] [] = array(
        //                 'label' 		=> $row ['attr_value'],
        //                 'price' 		=> $row ['attr_price'],
        //                 'format_price'	=> price_format($row ['attr_price'], false),
        //                 'id'			=> $row ['goods_attr_id']
        //             );
        //         }
        //         $i = 0;
        //         $spe_array = array();
        //         foreach ($spe_arr as $row) {
        //             $spe_array [] = $row;
        //         }
        //         $result ['error']    = ERR_NEED_SELECT_ATTR;
        //         $result ['goods_id'] = $goods['goods_id'];
        //         $result ['parent']   = $goods['parent'];
        //         $result ['message']  = $spe_array;
        //         ecjia_front::$controller->showmessage('选择商品规格', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, $result);
        //     }
        // }
        // /* 更新：如果是一步购物，先清空购物车 */
        // if (ecjia::config('one_step_buy') == '1') {
        //     clear_cart();
        // }
        // /*查询：系统启用了库存，检查输入的商品数量是否有效*/
        // $arrGoods		= $db_goods->field('goods_name,goods_number,extension_code')->where(array('goods_id'=>$goods['goods_id']))->find();
        // $goodsnmber		= get_goods_number($goods['goods_id']);
        // $goodsnmber		+= $goods['number'];
        // if (intval(ecjia::config('use_storage')) > 0 && $arrGoods['extension_code'] != 'package_buy') {
        //     if ($arrGoods ['goods_number'] < $goodsnmber) {
        //         $message = sprintf(RC_Lang::lang('stock_insufficiency'), $arrGoods ['goods_name'], $arrGoods ['goods_number'], $arrGoods ['goods_number']);
        //         ecjia_front::$controller->showmessage($message, ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        //     }
        // }
        // /*检查：商品数量是否合法*/
        // if (!is_numeric($goods['number']) || intval($goods['number']) <= 0) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('invalid_number'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // } else {
        //     /*更新：添加到购物车*/
        //     // var_dump($goods['goods_id'], $goods['number'], $goods['spec'], $goods['parent']);die;
        //     $res_add = addto_cart($goods['goods_id'], $goods['number'], $goods['spec'], $goods['parent']);
        //     if (!is_ecjia_error($res_add)){
        //         if (ecjia::config('cart_confirm') > 2) {
        //             $message = '';
        //         } else {
        //             $message = ecjia::config('cart_confirm') == 1 ? RC_Lang::lang('addto_cart_success_1') : RC_Lang::lang('addto_cart_success_2');
        //         }
        //         ecjia_front::$controller->showmessage('商品成功加入购物车', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON,array('is_show' => true,'pjaxurl' =>RC_Uri::url('goods/index/init&id='.$goods['goods_id'])));
        //     } else {
        //         ecjia_front::$controller->showmessage($res_add->get_error_message(), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        //     }
        // }
    }
    /**
     * 点击刷新购物车
     */
    public static function ajax_update_cart() {
        // $db_cart = RC_Loader::load_app_model('cart_model');
        // $db_goods_viewmodel = RC_Loader::load_app_model('goods_viewmodel');
        // $db_cart_viewmodel   = RC_Loader::load_app_model('cart_viewmodel');
        // $db_products         = RC_Loader::load_app_model('products_model');
        // RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
        // RC_Loader::load_theme('extras/model/cart/cart_goods_viewmodel.class.php');
        // RC_Loader::load_theme('extras/model/cart/cart_products_model.class.php');
        // RC_Loader::load_theme('extras/model/cart/cart_viewmodel.class.php');
        // $db_goods_viewmodel = new cart_goods_viewmodel();
        // $db_cart            = new cart_model();
        // $db_products        = new cart_products_model();
        // $db_cart_viewmodel  = new cart_viewmodel();
        // /*是否有接收值*/
        // if(!empty($_POST['rec_id']) && !empty($_POST['goods_number'])){
        //     $key = $_POST ['rec_id'];
        //     $val = intval(make_semiangle($_POST ['goods_number']));
        //     if ($val <= 0 && $key <= 0) {
        //         $message = '刷新购物车失败';
        //         ecjia_front::$controller->showmessage($message,ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON,array('error'=>99));
        //     }
        //     /*查询：*/
        //     $where = array(
        //         'rec_id'     => $key,
        //         'session_id' =>SESS_ID
        //     );
        //     $goods = $db_cart->field('goods_id,goods_attr_id,product_id,extension_code')->where($where)->find();
        //     $row = $db_goods_viewmodel->join('cart')->field('g.goods_name,g.goods_number')->where(array('c.rec_id'=>$key))->find();
        //     /*查询：系统启用了库存，检查输入的商品数量是否有效*/
        //     if (intval(ecjia::config('use_storage')) > 0 && $goods ['extension_code'] != 'package_buy') {
        //         if ($row ['goods_number'] < $val) {
        //             ecjia_front::$controller->showmessage(sprintf(RC_Lang::lang('stock_insufficiency'), $row ['goods_name'], $row ['goods_number'], $row ['goods_number']),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('error'=>1, 'err_max_number'=>$row ['goods_number']));
        //         }
        //         /* 是货品 */
        //         $goods ['product_id'] = trim($goods ['product_id']);
        //         if (!empty($goods ['product_id'])) {
        //             $where 		= " goods_id = '" . $goods ['goods_id'] . "' AND product_id = '" . $goods ['product_id'] . "'";
        //             $product_number =$db_products->field('product_number')->where($where)->get_field();
        //             if ($product_number < $val) {
        //                 ecjia_front::$controller->showmessage(sprintf(RC_Lang::lang('stock_insufficiency'), $row ['goods_name'], $product_number, $product_number),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON,array('error'=>2));
        //             }
        //         }
        //     } elseif (intval(ecjia::config('use_storage')) > 0 && $goods ['extension_code'] == 'package_buy') {
        //         if (judge_package_stock($goods ['goods_id'], $val)) {
        //             ecjia_front::$controller->showmessage(RC_Lang::lang('package_stock_insufficiency'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON,array('error'=>3));
        //         }
        //     }
        //     /* 查询：检查该项是否为基本件 以及是否存在配件 */
        //     /* 此处配件是指添加商品时附加的并且是设置了优惠价格的配件 此类配件都有parent_id goods_number为1 */
        //     $where = array(
        //         'c.rec_id'			=> $key,
        //         'c.session_id'		=> SESS_ID,
        //         'c.extension_code'	=> array('neq'=>'package_buy'),
        //         'cb.session_id'		=> SESS_ID
        //     );
        //     $offers_accessories_res = $db_cart_viewmodel->join('cart')->field('cb.goods_number,cb.rec_id')->where($where)->select();
        //
        //     /*订货数量大于0*/
        //     if ($val > 0) {
        //         /* 判断是否为超出数量的优惠价格的配件 删除 */
        //         $row_num = 1;
        //         foreach ($offers_accessories_res as $offers_accessories_row) {
        //             if ($row_num > $val) {
        //                 $db_cart->where(array('session_id'=>SESS_ID, 'rec_id'=>$offers_accessories_row ['rec_id']))->delete();
        //             }
        //             $row_num++;
        //         }
        //         /* 处理超值礼包 */
        //         if ($goods ['extension_code'] == 'package_buy') {
        //             /*更新购物车中的商品数量*/
        //             $db_cart->where(array('rec_id'=>$key, 'session_id'=>SESS_ID))->update(array('goods_number'=>$val));
        //         }
        //         /* 处理普通商品或非优惠的配件 */
        //         else {
        //             $attr_id = empty($goods ['goods_attr_id']) ? array() : explode(',', $goods ['goods_attr_id']);
        //             $goods_price = get_final_price($goods ['goods_id'], $val, true, $attr_id);
        //             /*更新购物车中的商品数量*/
        //             $db_cart->where(array('rec_id'=>$key, 'session_id'=>SESS_ID))->update(array('goods_number'=>$val, 'goods_price'=>$goods_price));
        //         }
        //     } else {
        //         /* 如果是基本件并且有优惠价格的配件则删除优惠价格的配件 */
        //         foreach ($offers_accessories_res as $offers_accessories_row) {
        //             $db_cart->where(array('rec_id'=>$offers_accessories_row['rec_id'], 'session_id'=>SESS_ID))->delete();
        //         }
        //         $db_cart->where(array('rec_id'=>$key, 'session_id'=>SESS_ID))->delete();
        //     }
        //     /* 删除所有赠品 */
        //     $db_cart->where(array('session_id'=>SESS_ID, 'is_gift'=>array('neq'=>0)))->delete();
        //     $result ['rec_id'] 			= $key;
        //     $result ['goods_number'] 	= $val;
        //     $result ['goods_subtotal'] 	= '';
        //     $result ['total_desc'] 		= '';
        //     $result ['cart_info'] 		= insert_cart_info();
        //     /* 计算合计 */
        //     $cart_goods = get_cart_goods();
        //     foreach ($cart_goods ['goods_list'] as $goods) {
        //         if ($goods ['rec_id'] == $key) {
        //             $result ['goods_subtotal'] = $goods ['subtotal'];
        //             break;
        //         }
        //     }
        //     $market_price_desc 			= sprintf(RC_Lang::lang('than_market_price'), $cart_goods ['total'] ['market_price'], $cart_goods ['total'] ['saving'], $cart_goods ['total'] ['save_rate']);
        //     $discount 					= compute_discount();// 计算折扣
        //     $favour_name 				= empty($discount ['name']) ? '' : join(',', $discount ['name']);
        //     $your_discount				= sprintf('', $favour_name, price_format($discount ['discount']));
        //     $result ['total_desc'] 		= $cart_goods ['total'] ['goods_price'];
        //     $result ['total_number']	= $cart_goods ['total'] ['total_number'];
        //     $result['market_total'] 	= $cart_goods['total']['market_price'];//市场价格
        //     ecjia_front::$controller->showmessage('',ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON,$result);
        // } else {
        //     $message = '刷新购物车失败';
        //     ecjia_front::$controller->showmessage($message ,ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('error'=>100));
        // }
    }

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
    public static function add_favourable() {
        /* 取得优惠活动信息 */
        // $db_cart = RC_Loader::load_app_model('cart_model');
        // RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
        // $db_cart       = new cart_model();
        // $act_id = intval($_POST ['act_id']);
        // $favourable = favourable_info($act_id);
        // if (empty($favourable)) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('favourable_not_exist'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // }
        // /* 判断用户能否享受该优惠 */
        // if (!favourable_available($favourable)) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('favourable_not_available'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // }
        // /* 检查购物车中是否已有该优惠 */
        // $cart_favourable = cart_favourable();
        // if (favourable_used($favourable, $cart_favourable)) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('favourable_used'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // }
        // /* 赠品（特惠品）优惠 */
        // if ($favourable ['act_type'] == FAT_GOODS) {
        //     /* 检查是否选择了赠品 */
        //     if (empty($_POST ['gift'])) {
        //         ecjia_front::$controller->showmessage(RC_Lang::lang('pls_select_gift'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        //     }
        //     /* 检查是否已在购物车 */
        //     $condition = " session_id = '" . SESS_ID . "'" . " AND rec_type = '" . CART_GENERAL_GOODS . "'" . " AND is_gift = '$act_id'" . " AND goods_id " . db_create_in($_POST ['gift']);
        //     $gift_name = $db_cart->field('goods_name')->where($condition)->getCol();
        //     if (!empty($gift_name)) {
        //         ecjia_front::$controller->showmessage(sprintf(RC_Lang::lang('gift_in_cart'), join(',', $gift_name)),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        //     }
        //     /* 检查数量是否超过上限 */
        //     $count = isset($cart_favourable [$act_id]) ? $cart_favourable [$act_id] : 0;
        //     if ($favourable ['act_type_ext'] > 0 && $count + count($_POST ['gift']) > $favourable ['act_type_ext']) {
        //         ecjia_front::$controller->showmessage(RC_Lang::lang('gift_count_exceed'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        //     }
        //     /* 添加赠品到购物车 */
        //     foreach ($favourable ['gift'] as $gift) {
        //         if (in_array($gift ['id'], $_POST ['gift'])) {
        //             add_gift_to_cart($act_id, $gift ['id'], $gift ['price']);
        //         }
        //     }
        // } elseif ($favourable ['act_type'] == FAT_DISCOUNT) {
        //     add_favourable_to_cart($act_id, $favourable ['act_name'], cart_favourable_amount($favourable) * (100 - $favourable ['act_type_ext']) / 100);
        // } elseif ($favourable ['act_type'] == FAT_PRICE) {
        //     add_favourable_to_cart($act_id, $favourable ['act_name'], $favourable ['act_type_ext']);
        // }
        // /* 刷新购物车 */
        // ecjia_front::$controller->showmessage('成功加入购物车', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl'=> RC_Uri::url('cart/index/init')));
    }

    /**
     * 删除购物车中的商品
     */
    public static function drop_goods() {
        // $rec_id = intval($_GET ['id']);
        // /*删除购物车中的商品*/
        // flow_drop_cart_goods($rec_id);
        // ecjia_front::$controller->showmessage('删除成功', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('is_show' => false, 'pjaxurl'=>RC_Uri::url('cart/index/init')));
    }

    /**
     * 获取购物车内的相关配件
     */
    public static function goods_fittings() {
        // $parent_list = get_cart_parentid_list();
        // /*根据基本件id获取 购物车中商品配件列表*/
        // $fittings_list = get_goods_fittings($parent_list);
        // /*赋值于模板*/
        // ecjia_front::$controller->assign('fitting',$fittings_list);
        // ecjia_front::$controller->assign('title', RC_Lang::lang('goods_fittings'));
        // ecjia_front::$controller->assign_title(RC_Lang::lang('goods_fittings'));
        // ecjia_front::$controller->assign_lang();
        // ecjia_front::$controller->display('goods_fittings.dwt');
    }

    /**
     * 订单确认
     */
    public static function checkout() {
        // $db_users = RC_Loader::load_app_model ( "users_model" );
//        RC_Loader::load_theme('extras/model/cart/cart_users_model.class.php');
//        $db_users       = new cart_users_model();
        // $db_cart = RC_Loader::load_app_model('cart_model');
        // RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
        // $db_cart       = new cart_model();
        // /* 取得购物类型 */
        // $flow_type = isset($_SESSION ['flow_type']) ? intval($_SESSION ['flow_type']) : CART_GENERAL_GOODS;
        // $rec_id = $_GET['rec_id'];
        // ecjia_front::$controller->assign('rec_id',$rec_id);
        // $url = RC_Uri::site_url() . substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], '/'));
        // if(empty($rec_id)){
        //     ecjia_front::$controller->showmessage('请选择商品再进行结算', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT,array('pjaxurl' => RC_Uri::url('cart/index/init')));
        // }
        // ecjia_front::$controller->assign('goods_id', $rec_id);
        // /* 团购标志 */
        // if ($flow_type == CART_GROUP_BUY_GOODS) {
        //     ecjia_front::$controller->assign('is_group_buy', 1);
        // } /* 积分兑换商品 */
        // elseif ($flow_type == CART_EXCHANGE_GOODS) {
        //     ecjia_front::$controller->assign('is_exchange_goods', 1);
        // } else {
        //     /*正常购物流程 清空其他购物流程情况*/
        //     $_SESSION ['flow_order'] ['extension_code'] = '';
        // }
        // /* 检查购物车中是否有商品 */
        // if (!check_cart_goods($rec_id)) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('no_goods_in_cart'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl'=>RC_Uri::url('touch/index/init')));
        // }
        // /* 检查用户是否已经登录 如果用户已经登录了则检查是否有默认的收货地址 如果没有登录则跳转到登录和注册页面*/
        // if (empty($_SESSION ['direct_shopping']) && $_SESSION ['user_id'] == 0) {
        //
        //     ecjia_front::$controller->showmessage('请您先登录再进行购买商品',ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl'=>RC_Uri::url('user/index/login',array('step' => 'flow', 'referer' =>urlencode($url)))));
        // }
        // /*获取收货人信息*/
        // $consignee = get_consignee($_SESSION['user_id']);
        // /* 检查收货人信息是否完整 */
        // if (!check_consignee_info($consignee, $flow_type)) {
        //     ecjia_front::$controller->redirect(RC_Uri::url('cart/flow/consignee', array('id'=>$consignee['address_id'],'referer' => urlencode($url))));
        // }
        // /*获取配送地址*/
        // $consignee_list = get_consignee_list($_SESSION ['user_id'], 0, 5, 1);
        // ecjia_front::$controller->assign('consignee_list', $consignee_list['list']);
        // ecjia_front::$controller->assign('address_id', $consignee['address_id']);
        // $_SESSION ['flow_consignee'] = $consignee;
        //
        // if ($consignee['country']) {
        //     $address .= get_region_name($consignee['country']);
        // }
        // if ($consignee['city']) {
        //     $address .= get_region_name($consignee['city']);
        // }
        // if ($consignee['district']) {
        //     $address .= get_region_name($consignee['district']);
        // }
        // $address .= $consignee['address'];
        // $consignee['address'] = $address;
        // ecjia_front::$controller->assign('consignee', $consignee);
        // /* 对商品信息赋值 */
        // $cart_goods = cart_goods($flow_type,$rec_id); // 取得商品列表，计算合计
        // $goods_number = array_column($cart_goods,'goods_number');
        // $num = count($goods_number);
        // $number = 0;
        // for($i=0;$i<$num;$i++){
        //     $number += $goods_number[$i];
        // }
        // ecjia_front::$controller->assign('goods_number',$number);
        // ecjia_front::$controller->assign('goods_list', $cart_goods);
        // /* 对是否允许修改购物车赋值 */
        // if ($flow_type != CART_GENERAL_GOODS || ecjia::config('one_step_buy') == '1') {
        //     ecjia_front::$controller->assign('allow_edit_cart', 0);
        // } else {
        //     ecjia_front::$controller->assign('allow_edit_cart', 1);
        // }
        // /*取得购物流程设置*/
        // ecjia_front::$controller->assign('config', ecjia::config());
        // /*取得订单信息*/
        // $order = flow_order_info();
        // ecjia_front::$controller->assign('order', $order);
        // /* 计算折扣 */
        // if ($flow_type != CART_EXCHANGE_GOODS && $flow_type != CART_GROUP_BUY_GOODS) {
        //     $discount		= compute_discount();//model('Order')->
        //     $favour_name	= empty($discount ['name']) ? '' : join(',', $discount ['name']);
        //     ecjia_front::$controller->assign('discount', $discount ['discount']);
        //     ecjia_front::$controller->assign('your_discount', sprintf(RC_Lang::lang('your_discount'), $favour_name, price_format($discount ['discount'])));
        // }
        // /*计算订单的费用*/
        // $total = order_fee($order, $cart_goods, $consignee);
        // ecjia_front::$controller->assign('total', $total);
        // ecjia_front::$controller->assign('shopping_money', sprintf(RC_Lang::lang('shopping_money'), $total ['formated_goods_price']));
        // ecjia_front::$controller->assign('market_price_desc', sprintf(RC_Lang::lang('than_market_price'), $total ['formated_market_price'], $total ['formated_saving'], $total ['save_rate']));
        // /* 取得可以得到的积分和红包 */
        // $total_integral = intval(cart_amount(false, $flow_type)) - intval($total ['bonus']) - intval($total ['integral_money']);
        // ecjia_front::$controller->assign('total_integral', $total_integral);
        // ecjia_front::$controller->assign('total_bonus', price_format(get_total_bonus(), false));
        // /* 取得配送列表 */
        // $region = array(
        //     $consignee ['country'],
        //     $consignee ['province'],
        //     $consignee ['city'],
        //     $consignee ['district']
        // );
        // // $shipping_method	= RC_Loader::load_app_class('shipping_method', 'shipping');
        // // $shipping_list		= empty($shipping_method) ? array() : $shipping_method->available_shipping_list($region);
        // $cart_weight_price	= cart_weight_price($flow_type);
        // $insure_disabled	= true;
        // $cod_disabled		= true;
        // /*查看购物车中是否全为免运费商品，若是则把运费赋为零*/
        // $where = array(
        //     'session_id'		=> SESS_ID,
        //     'extension_code'	=> array('neq'=>'package_buy'),
        //     'is_shipping'		=> 0
        // );
        // $shipping_count	= $db_cart->where($where)->in(array('rec_id' => $rec_id))->count('*');
        // $payment_method = RC_Loader::load_app_class('payment_method','payment');
        // foreach ($shipping_list as $key => $val) {
        //     $shipping_cfg 									= $payment_method->unserialize_config($val['configure']);
        //     $shipping_fee 									= ($shipping_count == 0 and $cart_weight_price ['free_shipping'] == 1) ? 0 : $shipping_method->shipping_fee($val ['shipping_code'], unserialize($val ['configure']), $cart_weight_price ['weight'], $cart_weight_price ['amount'], $cart_weight_price ['number']);
        //     $shipping_list [$key] ['format_shipping_fee'] 	= price_format($shipping_fee, false);
        //     $shipping_list [$key] ['shipping_fee'] 			= $shipping_fee;
        //     $shipping_list [$key] ['free_money'] 			= price_format($shipping_cfg ['free_money'], false);
        //     $shipping_list [$key] ['insure_formated'] 		= strpos($val ['insure'], '%') === false ? price_format($val ['insure'], false) : $val ['insure'];
        //     /* 当前的配送方式是否支持保价 */
        //     if ($val ['shipping_id'] == $order ['shipping_id']) {
        //         $insure_disabled 	= ($val ['insure'] == 0);
        //         $cod_disabled 		= ($val ['support_cod'] == 0);
        //     }
        // }
	    // reset($shipping_list);
	    // $shipping_list[key($shipping_list)]['default'] = 1;
	    // $shipping_default = $shipping_list[key($shipping_list)]['shipping_name'].$shipping_list[key($shipping_list)]['format_shipping_fee'];
	    // ecjia_front::$controller->assign('shipping_default',$shipping_default);
        // ecjia_front::$controller->assign('rec_id', $rec_id);
        // ecjia_front::$controller->assign('shipping_list', $shipping_list);
        // ecjia_front::$controller->assign('insure_disabled', $insure_disabled);
        // ecjia_front::$controller->assign('cod_disabled', $cod_disabled);
        // if ($order ['shipping_id'] == 0) {
        //     $cod 		= true;
        //     $cod_fee 	= 0;
        // } else {
        //     $shipping	= empty($shipping_method) ? array() : $shipping_method->shipping_info($order ['shipping_id']);
        //     $cod 		= $shipping ['support_cod'];
        //     if ($cod) {
        //         //TODO:团购
        //         if ($cod) {
        //             $shipping_method    = RC_Loader::load_app_class('shipping_method', 'shipping');
        //             $shipping_area_info = $shipping_method->shipping_area_info($order['shipping_id'], $region);
        //             $cod_fee 			= $shipping_area_info ['pay_fee'];
        //         }
        //     } else {
        //         $cod_fee = 0;
        //     }
        // }
        // /*给货到付款的手续费加<span id>，以便改变配送的时候动态显示*/
        // $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
        // $payment_list 	= empty($payment_method) ? array() : $payment_method->available_payment_list(1, $cod_fee);
        // /*过滤支付方式*/
        // $pay = array('pay_balance','pay_koolyun','pay_cash');
        // if (isset($payment_list)) {
        //     foreach ($payment_list as $key => $payment) {
        //         $payment_list [$key] ['format_pay_fee'] = strpos($payment['pay_fee'], '%') !== false ? $payment['pay_fee'] : price_format($payment['pay_fee'], false);
        //         if ($payment ['is_cod'] == '1') {
        //             $payment_list [$key] ['format_pay_fee'] = '<span id="ECS_CODFEE">' . $payment_list [$key] ['format_pay_fee'] . '</span>';
        //         }
        //         /* 如果有易宝神州行支付 如果订单金额大于300 则不显示 */
        //         if ($payment ['pay_code'] == 'yeepayszx' && $total ['amount'] > 300) {
        //             unset($payment_list [$key]);
        //         }
        //         /* 如果有余额支付 不显示*/
        //         if(in_array($payment['pay_code'],$pay)){
        //             unset($payment_list[$key]);
        //         }
        //         if ($_SESSION ['flow_order'] ['pay_id'] == $payment ['pay_id']) {
        //             ecjia_front::$controller->assign('disable_surplus', 1);
        //         }
        //     }
        // }
	    // reset($payment_list);
	    // $payment_list[key($payment_list)]['default'] = 1;
	    // $payment_default = $payment_list[key($payment_list)]['pay_name'].$payment_list[key($payment_list)]['format_pay_fee'];
	    // ecjia_front::$controller->assign('payment_default',$payment_default);
        // ecjia_front::$controller->assign('payment_list', $payment_list);
        // //TODO:包装与贺卡
        // $user_info = user_info($_SESSION ['user_id']);
        // /* 如果使用余额，取得用户余额 */
        // $use_surplus = ecjia::config('use_surplus');
        // if ((!isset($use_surplus) || ecjia::config('use_surplus') == '1') && $_SESSION ['user_id'] > 0 && $user_info ['user_money'] > 0) {
        //     ecjia_front::$controller->assign('allow_use_surplus', 1);
        //     ecjia_front::$controller->assign('your_surplus', $user_info ['user_money']);
        // }
        // /* 如果使用积分，取得用户可用积分及本订单最多可以使用的积分 */
        // $use_integral = ecjia::config('use_integral');
        // if ((!isset($use_integral) || ecjia::config('use_integral') == '1') && $_SESSION ['user_id'] > 0 && $user_info ['pay_points'] > 0 && ($flow_type != CART_GROUP_BUY_GOODS && $flow_type != CART_EXCHANGE_GOODS)) {
        //     /*能使用积分*/
        //     ecjia_front::$controller->assign('allow_use_integral', 1);
        //     ecjia_front::$controller->assign('order_max_integral', flow_available_points()); // 可用积分// model('Flow')->
        //     ecjia_front::$controller->assign('your_integral', $user_info ['pay_points']); // 用户积分
        // }
        // /* 如果使用红包，取得用户可以使用的红包及用户选择的红包 */
        // $use_bonus = ecjia::config('use_bonus');
        //
        // if ((!isset($use_bonus) || ecjia::config('use_bonus') == '1') && ($flow_type != CART_GROUP_BUY_GOODS && $flow_type != CART_EXCHANGE_GOODS)) {
        //     /*取得用户可用红包*/
        //     $user_bonus = user_bonus($_SESSION ['user_id'], $total ['goods_price']);
        //     if (!empty($user_bonus)) {
        //         foreach ($user_bonus as $key => $val) {
        //             $user_bonus [$key] ['bonus_money_formated'] = price_format($val ['type_money'], false);
        //         }
        //         ecjia_front::$controller->assign('bonus_list', $user_bonus);
        //     }
        //     /*能使用红包*/
        //     ecjia_front::$controller->assign('allow_use_bonus', 1);
        // }
        // /* 如果使用缺货处理，取得缺货处理列表 */
        // $use_how_oos = ecjia::config('use_how_oos');
        // if (!isset($use_how_oos) || $use_how_oos == '1') {
        //     $oos = RC_Lang::lang('oos');
        //     if (is_array($oos) && !empty($oos)) {
        //         ecjia_front::$controller->assign('how_oos_list', RC_Lang::lang('oos'));
        //     }
        // }
        // /* 如果能开发票，取得发票内容列表 */
        // $can_invoice = ecjia::config('can_invoice');
        // $invoice_content = ecjia::config('invoice_content');
        // if ((!isset($can_invoice) || $can_invoice == '1') && isset($invoice_content) && trim($invoice_content) != '' && $flow_type != CART_EXCHANGE_GOODS) {
        //     $inv_content_list = explode("\n", str_replace("\r", '', ecjia::config('invoice_content')));
        //     ecjia_front::$controller->assign('inv_content_list', $inv_content_list);
        //     $inv_type_list = array();
        //     $invoice_type = ecjia::config('invoice_type');
        //     foreach ($invoice_type['type'] as $key => $type) {
        //         if (!empty($type)) {
        //             $inv_type_list [$type] = $type . ' [' . floatval($invoice_type['rate'] [$key]) . '%]';
        //         }
        //     }
        //     ecjia_front::$controller->assign('inv_type_list', $inv_type_list);
        // }
        // /* 保存 session */
        // $_SESSION ['flow_order'] = $order;
        // ecjia_front::$controller->assign('currency_format', ecjia::config('currency_format'));
        // ecjia_front::$controller->assign('integral_scale', ecjia::config('integral_scale'));
        // ecjia_front::$controller->assign('step', ROUTE_A);
        
//         $_POST['address_id'] = 540;
//         $_POST['rec_id'] = '8466,8467,8468,8469';
        $address_id = empty($_REQUEST['address_id']) ? 0 : intval($_REQUEST['address_id']);
        $rec_id = empty($_REQUEST['rec_id']) ? 0 : trim($_REQUEST['rec_id']);
        
        $url = RC_Uri::site_url() . substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], '/'));
        if(empty($rec_id)) {
            ecjia_front::$controller->showmessage('请选择商品再进行结算', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        if (empty($address_id)) {
            ecjia_front::$controller->showmessage('请选择收货地址', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        
        $params_cart = array(
            'token' => ecjia_touch_user::singleton()->getToken(),
            'address_id' => $address_id,
            'rec_id' => $rec_id,
            'location' => array(
                'longitude' => '121.41709899974',
                'latitude' => '31.235476867103'
            ),
        );
        $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::FLOW_CHECKORDER)->data($params_cart)
        ->send()->getBody();
        $rs = json_decode($rs,true);
        if (! $rs['status']['succeed']) {
            $url = RC_Uri::url('cart/index/init');
            ecjia_front::$controller->showmessage($rs['status']['error_desc'], ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT,array('pjaxurl' => $url));
        }
        $cart_key = md5($address_id.$rec_id);
        $_SESSION['cart'][$cart_key]['data'] = $rs['data'];
        
        //支付方式
        $payment_id = 0;
        if ($_POST['payment_update']) {
            $payment_id = $_SESSION['cart'][$cart_key]['pay_id'] = empty($_POST['payment']) ? 0 : intval($_POST['payment']);
        } else {
            if (isset($_SESSION['cart'][$cart_key]['pay_id'])) {
                $payment_id = $_SESSION['cart'][$cart_key]['pay_id'];
            }
        }
        if ($payment_id) {
            $payment_list = touch_function::change_array_key($rs['data']['payment_list'], 'pay_id');
            $selected_payment = $payment_list[$payment_id];
            
        } else {
            $selected_payment = $rs['data']['payment_list'][0];
        }
        
        //配送方式
        $shipping_id = 0;
        if ($_POST['shipping_update']) {
            $shipping_id = $_SESSION['cart'][$cart_key]['shipping_id'] = empty($_POST['shipping']) ? 0 : intval($_POST['shipping']);
        } else {
            if (isset($_SESSION['cart'][$cart_key]['shipping_id'])) {
                $shipping_id = $_SESSION['cart'][$cart_key]['shipping_id'];
            }
        }
        if ($shipping_id) {
            $shipping_list = touch_function::change_array_key($rs['data']['shipping_list'], 'shipping_id');
            $selected_shipping = $shipping_list[$shipping_id];
        } else {
            $selected_shipping = $rs['data']['shipping_list'][0];
        }
        
        //留言
        if ($_POST['note_update']) {
            $_SESSION['cart'][$cart_key]['note'] = empty($_POST['note']) ? '' : trim($_POST['note']);
        }
        ecjia_front::$controller->assign('note', $_SESSION['cart'][$cart_key]['note']);
        //积分
        if ($_POST['integral_update']) {
            $_SESSION['cart'][$cart_key]['integral'] = empty($_POST['integral']) ? '' : intval($_POST['integral']);
        }
        
        //total
        $total['goods_number'] = 0;
        $total['goods_price'] = 0;
        foreach ($rs['data']['goods_list'] as $cart) {
            $total['goods_number'] += $cart['goods_number'];
            $total['goods_price'] += $cart['subtotal'];
        }
        $total['goods_price_formated'] = price_format($total['goods_price']);
        $total['shipping_fee'] = $selected_shipping['shipping_fee']; //$rs['data']['shipping_list'];
        $total['shipping_fee_formated'] = price_format($total['shipping_fee']);
        $total['discount'] = $rs['data']['discount'];
        $total['discount_formated'] = $rs['data']['discount_formated'];
        
        $total['pay_fee'] = $selected_payment['pay_fee']; 
        $total['pay_fee_formated'] = price_format($total['pay_fee']);
        $total['amount'] = $total['goods_price'] + $total['shipping_fee'] + $total['pay_fee'] - $total['discount']; 
        $total['amount_formated'] = price_format($total['amount']);
        
        _dump($rs,2);
        ecjia_front::$controller->assign('data', $rs['data']);
        ecjia_front::$controller->assign('total_goods_number', $total['goods_number']);
        ecjia_front::$controller->assign('selected_payment', $selected_payment);
        ecjia_front::$controller->assign('selected_shipping', $selected_shipping);
        ecjia_front::$controller->assign('total', $total);
        ecjia_front::$controller->assign('address_id', $address_id);
        ecjia_front::$controller->assign('rec_id', $rec_id);
        
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
            ecjia_front::$controller->showmessage('请选择商品再进行结算', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        if (empty($address_id)) {
            ecjia_front::$controller->showmessage('请选择收货地址', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        
        $params_cart = array(
            'token' => ecjia_touch_user::singleton()->getToken(),
            'address_id' => $address_id,
            'rec_id' => $rec_id,
            'location' => array(
                'longitude' => '121.41709899974',
                'latitude' => '31.235476867103'
            ),
        );
        $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::FLOW_CHECKORDER)->data($params_cart)
        ->send()->getBody();
        $rs = json_decode($rs,true);
        if (! $rs['status']['succeed']) {
            $url = '';
            ecjia_front::$controller->showmessage($rs['status']['error_desc'], ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT,array('pjaxurl' => $url));
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
    public static function select_shipping() {
        // 格式化返回数组
        // $result = array(
        //     'error' 		=> '',
        //     'content'		=> '',
        //     'need_insure'	=> 0
        // );
        // $rec_id = $_REQUEST['rec_id'];
        // /* 取得购物类型 */
        // $flow_type = isset($_SESSION ['flow_type']) ? intval($_SESSION ['flow_type']) : CART_GENERAL_GOODS;
        // /* 获得收货人信息 */
        // $consignee = get_consignee($_SESSION ['user_id']);
        // /* 对商品信息赋值 */
        // $cart_goods = cart_goods($flow_type,$rec_id); // 取得商品列表，计算合计
        // if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type)) {
        //     $result ['error'] 		= RC_Lang::lang('no_goods_in_cart');
        // } else {
        //     /* 取得购物流程设置 */
        //     ecjia_front::$controller->assign('config', ecjia::config('CFG'));
        //     /* 取得订单信息 */
        //     $order 					= flow_order_info();
        //     $order ['shipping_id']	= intval($_REQUEST ['shipping']);
        //     $regions = array(
        //         $consignee ['country'],
        //         $consignee ['province'],
        //         $consignee ['city'],
        //         $consignee ['district']
        //     );
        //     $shipping_method    = RC_Loader::load_app_class('shipping_method', 'shipping');
        //     $shipping_info      = $shipping_method->shipping_area_info($order['shipping_id'], $regions);
        //     $total              = order_fee($order, $cart_goods, $consignee);/* 计算订单的费用 */
        //     ecjia_front::$controller->assign('total', $total);
        //     /* 取得可以得到的积分和红包 */
        //     ecjia_front::$controller->assign('total_integral', intval(cart_amount(false, $flow_type)) - intval($total ['bonus']) - intval($total ['integral_money']));
        //     ecjia_front::$controller->assign('total_bonus', price_format(get_total_bonus(), false));
        //     /* 团购标志 */
        //     if ($flow_type == CART_GROUP_BUY_GOODS) {
        //         ecjia_front::$controller->assign('is_group_buy', 1);
        //     }
        //     $result ['cod_fee'] = $shipping_info ['pay_fee'];
        //     if (strpos($result ['cod_fee'], '%') === false) {
        //         $result ['cod_fee'] = price_format($result ['cod_fee'], false);
        //     }
        //     $result ['need_insure'] = ($shipping_info ['insure'] > 0 && !empty($order ['need_insure'])) ? 1 : 0;
        //     ecjia_front::$controller->assign_lang();
        //     $result ['content'] = ecjia_front::$controller->fetch('library/order_total.lbi');
        // }
        // ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON,$result);
    }


    /**
     * 改变支付方式
     */
    public static function select_payment() {
        // $result		= array('error' => '', 'content' => '', 'need_insure' => 0, 'payment' => 1);
        // /* 取得购物类型 */
        // $flow_type	= isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;
        // /* 获得收货人信息 */
        // $consignee	= get_consignee($_SESSION['user_id']);
        // $rec_id = $_REQUEST['rec_id'];
        // /* 对商品信息赋值 */
        // $cart_goods = cart_goods($flow_type,$rec_id); // 取得商品列表，计算合计
        // if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type)) {
        //     $result['error'] = RC_Lang::lang('no_goods_in_cart');
        // } else {
        //     /* 取得购物流程设置 */
        //     ecjia_front::$controller->assign('config', ecjia::config('CFG'));
        //     /* 取得订单信息 */
        //     $order = flow_order_info();
        //     $order['pay_id'] = intval($_REQUEST['payment']);
        //     $payment_method = RC_Loader::load_app_class('payment_method','payment');
        //     $payment_info = $payment_method->payment_info_by_id($order['pay_id']);
        //     $result['pay_code'] = $payment_info['pay_code'];
        //     /* 保存 session */
        //     $_SESSION['flow_order'] = $order;
        //     /* 计算订单的费用 */
        //     $total = order_fee($order, $cart_goods, $consignee);
        //     ecjia_front::$controller->assign('total', $total);
        //     /* 取得可以得到的积分和红包 */
        //     ecjia_front::$controller->assign('total_integral', cart_amount(false, $flow_type) - $total['bonus'] - $total['integral_money']);
        //     ecjia_front::$controller->assign('total_bonus', price_format(get_total_bonus(), false));
        //     /* 团购标志 */
        //     if ($flow_type == CART_GROUP_BUY_GOODS) {
        //         ecjia_front::$controller->assign('is_group_buy', 1);
        //     }
        //     ecjia_front::$controller->assign_lang();
        //     $result['content'] = ecjia_front::$controller->fetch('library/order_total.lbi');
        // }
        // ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, $result);
    }


    /**
     *  提交订单
     */
    public static function done() {
    //     // $db_cart = RC_Loader::load_app_model ( "cart_model" );
    //      RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    //     $db_cart       = new cart_model();
    //     // $db_shipping = RC_Loader::load_app_model ( "shipping_model" );
    //      RC_Loader::load_theme('extras/model/cart/cart_shipping_model.class.php');
    //     $db_shipping       = new cart_shipping_model();
    //     // $db_order_info = RC_Loader::load_app_model ( "order_info_model" );
    //     RC_Loader::load_theme('extras/model/cart/cart_order_info_model.class.php');
    //     $db_order_info       = new cart_order_info_model();
    //     // $db_order_goods = RC_Loader::load_app_model ( "order_goods_model" );
    //     RC_Loader::load_theme('extras/model/cart/cart_order_goods_model.class.php');
    //     $db_order_goods       = new cart_order_goods_model();
    //     // $db_goods_activity = RC_Loader::load_app_model ("goods_activity_model");
    //     RC_Loader::load_theme('extras/model/cart/cart_goods_activity_model.class.php');
    //     $db_goods_activity       = new cart_goods_activity_model();
    //     // $db_user_bonus = RC_Loader::load_app_model("user_bonus_model");
    //     RC_Loader::load_theme('extras/model/cart/cart_user_bonus_model.class.php');
    //     $db_user_bonus       = new cart_user_bonus_model();
    //     /* 取得购物类型 */
    //     $rec_id = $_POST['rec_id'];
    //     if(empty($rec_id)){
    //         ecjia_front::$controller->showmessage('请选择商品再进行结算', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
    //     }
    //     $payment = $_POST['payment'];
    //     if(empty($payment)){
    //         ecjia_front::$controller->showmessage('请选择支付方式', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
    //     }
    //     $shipping = $_POST['shipping'];
    //     if(empty($shipping)){
    //         ecjia_front::$controller->showmenssage('请选择配送方式', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
    //     }
    //     $flow_type = isset($_SESSION ['flow_type']) ? intval($_SESSION ['flow_type']) : CART_GENERAL_GOODS;
    //     /* 检查购物车中是否有商品 */
    //     $where = array(
    //         'session_id'    => SESS_ID,
    //         'parent_id'     => 0,
    //         'is_gift'       => 0,
    //         'rec_type'      => $flow_type,
    //         'rec_id'        => $rec_id,
    //     );
    //     $count = $db_cart->where($where)->count('*');
    //     if (empty($count)) {
    //         ecjia_front::$controller->showmessage(RC_Lang::lang('no_goods_in_cart'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('touch/index/init')));
    //     }
    //     /* 如果使用库存，且下订单时减库存，则减少库存 */
    //     if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
    //         $cart_goods_stock = get_cart_goods();
    //         $_cart_goods_stock = array();
    //         foreach ($cart_goods_stock ['goods_list'] as $value) {
    //             $_cart_goods_stock [$value ['rec_id']] = $value ['goods_number'];
    //         }
    //         $result = flow_cart_stock($_cart_goods_stock);
    //         if (is_ecjia_error($result)) {
    //             ecjia_front::$controller->showmessage($result->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
    //         }
    //         unset($cart_goods_stock, $_cart_goods_stock);
    //     }
    //     /*检查用户是否已经登录 如果用户已经登录了则检查是否有默认的收货地址 如果没有登录则跳转到登录和注册页面*/
    //     if (empty($_SESSION ['direct_shopping']) && $_SESSION ['user_id'] == 0) {
    //         //TODO: 增加语言包“请您登陆或者选择匿名购买”
    //         ecjia_front::$controller->showmessage('请您登陆或者选择匿名购买', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON,array('pjaxurl'=>RC_Uri::url('user/login')));
    //     }
    //     /*获取收货人信息*/
    //     $consignee = get_consignee($_SESSION ['user_id']);
    //     /* 检查收货人信息是否完整 */
    //     if (!check_consignee_info($consignee, $flow_type)) {
    //         /* 如果不完整则转向到收货人信息填写界面 */
    //         ecjia_front::$controller->showmessage('您填写的收货人信息不完整', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl'=> RC_Uri::url('flow/consignee')));
    //     }
    //     /*处理接收信息*/
    //     $how_oos        = htmlspecialchars($_POST['how_oos']);
    //     $card_message   = htmlspecialchars($_POST['card_message']);
    //     $inv_type       = htmlspecialchars($_POST['inv_type']);
    //     $inv_payee      = htmlspecialchars($_POST['inv_payee']);
    //     $inv_content    = htmlspecialchars($_POST['inv_content']);
    //     $postscript     = htmlspecialchars($_POST['postscript']);
    //     $oos            = RC_Lang::lang('oos.' . $how_oos);
    //     /*订单信息*/
    //     $order = array(
    //         'shipping_id'       => htmlspecialchars($_POST['shipping']),
    //         'pay_id'            => htmlspecialchars($_POST['payment']),
    //         'pack_id'           => htmlspecialchars($_POST['pack'], 0),
    //         'card_id'           => isset($_POST ['card']) ? intval($_POST ['card']) : 0,
    //         'card_message'      => trim($_POST ['card_message']),
    //         'surplus'           => isset($_POST ['surplus']) ? floatval($_POST ['surplus']) : 0.00,
    //         'integral'          => isset($_POST ['integral']) ? intval($_POST ['integral']) : 0,
    //         'bonus_id'          => isset($_POST ['bonus']) ? intval($_POST ['bonus']) : 0,
    //         'need_inv'          => empty($_POST ['need_inv']) ? 0 : 1,
    //         'inv_type'          => $_POST ['inv_type'],
    //         'inv_payee'         => trim($_POST ['inv_payee']),
    //         'inv_content'       => $_POST ['inv_content'],
    //         'postscript'        => trim($_POST ['postscript']),
    //         'how_oos'           => isset($oos) ? addslashes("$oos") : '',
    //         'need_insure'       => isset($_POST ['need_insure']) ? intval($_POST ['need_insure']) : 0,
    //         'user_id'           => $_SESSION ['user_id'],
    //         'add_time'          => RC_Time::gmtime(),
    //         'order_status'      => OS_UNCONFIRMED,
    //         'shipping_status'   => SS_UNSHIPPED,
    //         'pay_status'        => PS_UNPAYED,
    //         'mobile_order'      => 1,
    //         'mobile_pay'        => 1,
    //         'agency_id'         => get_agency_by_regions(array($consignee ['country'], $consignee ['province'], $consignee ['city'], $consignee ['district']))
    //     );
    //     /* 扩展信息 */
    //     if (isset($_SESSION ['flow_type']) && intval($_SESSION ['flow_type']) != CART_GENERAL_GOODS) {
    //         $order ['extension_code'] = $_SESSION ['extension_code'];
    //         $order ['extension_id'] = $_SESSION ['extension_id'];
    //     } else {
    //         $order ['extension_code'] = '';
    //         $order ['extension_id'] = 0;
    //     }
    //     /* 检查积分余额是否合法 */
    //     $user_id = $_SESSION ['user_id'];
    //     if ($user_id > 0) {
    //         $user_info = user_info($user_id);
    //         $order ['surplus'] = min($order ['surplus'], $user_info ['user_money'] + $user_info ['credit_line']);
    //         if ($order ['surplus'] < 0) {
    //             $order ['surplus'] = 0;
    //         }
    //         /*查询用户有多少积分*/
    //         $flow_points = flow_available_points(); // 该订单允许使用的积分
    //         $user_points = $user_info ['pay_points']; // 用户的积分总数
    //         $order ['integral'] = min($order ['integral'], $user_points, $flow_points);
    //         if ($order ['integral'] < 0) {
    //             $order ['integral'] = 0;
    //         }
    //     } else {
    //         $order ['surplus'] = 0;
    //         $order ['integral'] = 0;
    //     }
    //     /* 检查红包是否存在 */
    //     if ($order ['bonus_id'] > 0) {
    //         $bonus = bonus_info($order ['bonus_id']);
    //         if (empty($bonus) || $bonus ['user_id'] != $user_id || $bonus ['order_id'] > 0 || $bonus ['min_goods_amount'] > cart_amount(true, $flow_type)) {
    //             $order ['bonus_id'] = 0;
    //         }
    //     } elseif (isset($_POST ['bonus_sn'])) {
    //         $bonus_sn = trim($_POST ['bonus_sn']);
    //         $bonus = bonus_info(0, $bonus_sn);
    //         $now = RC_Time::gmtime();
    //         if (empty($bonus) || $bonus ['user_id'] > 0 || $bonus ['order_id'] > 0 || $bonus ['min_goods_amount'] > cart_amount(true, $flow_type) || $now > $bonus ['use_end_date']) {
    //         } else {
    //             if ($user_id > 0) {
    //                 $data = array(
    //                     'user_id' => $user_id
    //                 );
    //                 $user_bonus = $db_user_bonus->where(array('bonus_id'=>$bonus['bonus_id']))->limit(1)->update($data);
    //             }
    //             $order ['bonus_id'] = $bonus ['bonus_id'];
    //             $order ['bonus_sn'] = $bonus_sn;
    //         }
    //     }
    //     /* 订单中的商品 */
    //     $cart_goods = cart_goods($flow_type,$rec_id);
    //     if (empty($cart_goods)) {
    //         ecjia_front::$controller->showmessage(RC_Lang::lang('no_goods_in_cart'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
    //     }
    //     /* 检查商品总额是否达到最低限购金额 */
    //     if ($flow_type == CART_GENERAL_GOODS && cart_amount(true, CART_GENERAL_GOODS) < ecjia::config('min_goods_amount')) {
    //         ecjia_front::$controller->showmessage(sprintf(RC_Lang::lang('goods_amount_not_enough'), price_format(ecjia::config('min_goods_amount'), false)),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
    //     }
    //     /* 收货人信息 */
    //     foreach ($consignee as $key => $value) {
    //         $order [$key] = addslashes($value);
    //     }
    //     /* 判断是不是实体商品 */
    //     foreach ($cart_goods as $val) {
    //         /* 统计实体商品的个数 */
    //         if ($val ['is_real']) {
    //             $is_real_good = 1;
    //         }
    //     }
    //     $shipping_method    = RC_Loader::load_app_class('shipping_method', 'shipping');
    //     $payment_method     = RC_Loader::load_app_class('payment_method', 'payment');
    //     if (isset($is_real_good)) {
    //         $res = $shipping_method->shipping_info($order ['shipping_id']);
    //         if (!$res) {
    //             ecjia_front::$controller->showmessageg(RC_Lang::lang('flow_no_shipping'),ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
    //         }
    //     }
    //     /* 订单中的总额 */
    //     $total                      = order_fee($order, $cart_goods, $consignee);
    //     $order ['bonus']            = $total ['bonus'];
    //     $order ['goods_amount']     = $total ['goods_price'];
    //     $order ['discount']         = $total ['discount'];
    //     $order ['surplus']          = $total ['surplus'];
    //     $order ['tax']              = $total ['tax'];
    //     /*购物车中的商品能享受红包支付的总额*/
    //     $discount_amout = compute_discount_amount();
    //     /*红包和积分最多能支付的金额为商品总额*/
    //     $temp_amout = $order ['goods_amount'] - $discount_amout;
    //     if ($temp_amout <= 0) {
    //         $order ['bonus_id'] = 0;
    //     }
    //     /* 配送方式 */
    //     if ($order ['shipping_id'] > 0) {
    //         $shipping = $shipping_method->shipping_info($order ['shipping_id']);
    //         $order ['shipping_name'] = addslashes($shipping ['shipping_name']);
    //     }
    //     $order ['shipping_fee'] = $total ['shipping_fee'];
    //     $order ['insure_fee'] = $total ['shipping_insure'];
    //     /* 支付方式 */
    //     if ($order ['pay_id'] > 0) {
    //         $payment            = $payment_method->payment_info($order ['pay_id']);
    //         $order ['pay_name'] = addslashes($payment ['pay_name']);
    //     }
    //     $order ['pay_fee']      = $total ['pay_fee'];
    //     $order ['cod_fee']      = $total ['cod_fee'];
    //     $order ['card_fee']     = $total ['card_fee'];
    //     $order ['order_amount'] = number_format($total ['amount'], 2, '.', '');
    //     /* 如果全部使用余额支付，检查余额是否足够 */
    //     if ($payment ['pay_code'] == 'balance' && $order ['order_amount'] > 0) {
    //         if ($order ['surplus'] > 0) {// 余额支付里如果输入了一个金额
    //             $order ['order_amount'] = $order ['order_amount'] + $order ['surplus'];
    //             $order ['surplus'] = 0;
    //         }
    //         if ($order ['order_amount'] > ($user_info ['user_money'] + $user_info ['credit_line'])) {
    //             ecjia_front::$controller->showmessage(RC_Lang::lang('balance_not_enough'),ecjia::MSGSTAT_ERROR |ecjia::MSGTYPE_JSON);
    //         } else {
    //             $order ['surplus'] = $order ['order_amount'];
    //             $order ['order_amount'] = 0;
    //         }
    //     }
    //     /* 如果订单金额为0（使用余额或积分或红包支付），修改订单状态为已确认、已付款 */
    //     if ($order ['order_amount'] <= 0) {
    //         $order ['order_status'] = OS_CONFIRMED;
    //         $order ['confirm_time'] = RC_Time::gmtime();
    //         $order ['pay_status']   = PS_PAYED;
    //         $order ['pay_time']     = RC_Time::gmtime();
    //         $order ['order_amount'] = 0;
    //     }
    //     $order ['integral_money']   = $total ['integral_money'];
    //     $order ['integral']         = $total ['integral'];
    //     if ($order ['extension_code'] == 'exchange_goods') {
    //         $order ['integral_money']   = 0;
    //         $order ['integral']         = $total ['exchange_integral'];
    //     }
    //     $order ['from_ad']              = !empty($_SESSION ['from_ad']) ? $_SESSION ['from_ad'] : '0';
    //     $order ['referer']              = !empty($_SESSION ['referer']) ? addslashes($_SESSION ['referer']) : '';
    //     /* 记录扩展信息 */
    //     if ($flow_type != CART_GENERAL_GOODS) {
    //         $order ['extension_code']   = $_SESSION ['extension_code'];
    //         $order ['extension_id']     = $_SESSION ['extension_id'];
    //     }
    //     $affiliate = unserialize(ecjia::config('affiliate'));
    //     if (isset($affiliate ['on']) && $affiliate ['on'] == 1 && $affiliate ['config'] ['separate_by'] == 1) {
    //         /*推荐订单分成*/
    //         $parent_id = get_affiliate();
    //         if ($user_id == $parent_id) {
    //             $parent_id = 0;
    //         }
    //     } elseif (isset($affiliate ['on']) && $affiliate ['on'] == 1 && $affiliate ['config'] ['separate_by'] == 0) {
    //         /*推荐注册分成*/
    //         $parent_id = 0;
    //     } else {
    //         /*分成功能关闭*/
    //         $parent_id = 0;
    //     }
    //     $order ['parent_id'] = $parent_id;
    //     /* 插入订单表 */
    //     $order ['order_sn'] = get_order_sn();
    //     $new_order          = $db_order_info->auto($order);
    //     $order ['order_id'] = $new_order_id = $db_order_info->insert();
    //     /* 插入订单商品 */
    //     $field = 'goods_id, goods_name, goods_sn, product_id, goods_number, market_price,goods_price, goods_attr, is_real, extension_code, parent_id, is_gift, goods_attr_id';
    //     if ($_SESSION['user_id']) {
    //         $data_row = $db_cart->field($field)->where(array('session_id' =>SESS_ID, 'rec_type' => $flow_type))->in(array('rec_id' => $rec_id))->select();
    //     } else {
    //         $data_row = $db_cart->field($field)->where(array('session_id' =>SESS_ID, 'rec_type' => $flow_type))->in(array('rec_id' => $rec_id))->select();
    //     }
    //     if (!empty($data_row)) {
    //         foreach ($data_row as $row) {
    //             $arr = array(
    //                 'order_id' => $new_order_id,
    //                 'goods_id' => $row['goods_id'],
    //                 'goods_name' => $row['goods_name'],
    //                 'goods_sn' => $row['goods_sn'],
    //                 'product_id' => $row['product_id'],
    //                 'goods_number' => $row['goods_number'],
    //                 'market_price' => $row['market_price'],
    //                 'goods_price' => $row['goods_price'],
    //                 'goods_attr' => $row['goods_attr'],
    //                 'is_real' => $row['is_real'],
    //                 'extension_code' => $row['extension_code'],
    //                 'parent_id' => $row['parent_id'],
    //                 'is_gift' => $row['is_gift'],
    //                 'goods_attr_id' => $row['goods_attr_id'],
    //             );
    //             $db_order_goods->insert($arr);
    //         }
    //     }
       //
    //     /* 修改拍卖活动状态 */
    //     if ($order ['extension_code'] == 'auction') {
    //         $db_goods_activity->where(array('act_id'=>$order['extension_id']))->update(array('is_finished'=>2));
    //     }
    //     /* 处理余额、积分、红包 */
    //     if ($order ['user_id'] > 0 && $order ['surplus'] > 0) {
    //         log_account_change($order ['user_id'], $order ['surplus'] * (- 1), 0, 0, 0, sprintf(RC_Lang::lang('pay_order'), $order ['order_sn']));
    //     }
    //     if ($order ['user_id'] > 0 && $order ['integral'] > 0) {
    //         log_account_change($order ['user_id'], 0, 0, 0, $order ['integral'] * (- 1), sprintf(RC_Lang::lang('pay_order'), $order ['order_sn']));
    //     }
    //     if ($order ['bonus_id'] > 0 && $temp_amout > 0) {
    //         use_bonus($order ['bonus_id'], $new_order_id);
    //     }
    //     /* 如果使用库存，且下订单时减库存，则减少库存 */
    //     if (ecjia::config('use_storage') == '1' && ecjia::config('stock_dec_time') == SDT_PLACE) {
    //         change_order_goods_storage($order ['order_id'], true, SDT_PLACE);
    //     }
    //     /* 给商家发邮件 */
    //     if (ecjia::config('send_service_email') && ecjia::config('service_email') != '') {
    //         $tpl = get_mail_template('remind_of_new_order');
    //         ecjia_front::$controller->assign('order', $order);
    //         ecjia_front::$controller->assign('goods_list', $cart_goods);
    //         ecjia_front::$controller->assign('shop_name', ecjia::config('shop_name'));
    //         ecjia_front::$controller->assign('send_date', date(ecjia::config('time_format')));
    //         $content = ecjia_front::$controller->fetch_string($tpl ['template_content']);
    //         RC_Mail::send_mail(ecjia::config('shop_name'), ecjia::config('service_email'), $tpl ['template_subject'], $content, $tpl ['is_html']);
    //     }
    //     //TODO:短信通知
    //     //TODO:微信通知
    //     /* 如果订单金额为0 处理虚拟卡 */
    //     if ($order ['order_amount'] <= 0) {
    //         $where = array(
    //             'is_real'           => 0,
    //             'extension_code'    => 'virtual_card',
    //             'session_id'        => SESS_ID,
    //             'rec_type'          => $flow_type
    //         );
    //         $res = $db_cart->field('goods_id,goods_name,goods_number | num')->where($where)->select();
    //         $virtual_goods = array();
    //         foreach ($res as $row) {
    //             $virtual_goods ['virtual_card'] []  = array(
    //                 'goods_id'      => $row ['goods_id'],
    //                 'goods_name'    => $row ['goods_name'],
    //                 'num'           => $row ['num']
    //             );
    //         }
    //         if ($virtual_goods && $flow_type != CART_GROUP_BUY_GOODS) {
    //             /* 虚拟卡发货 */
    //             if (virtual_goods_ship($virtual_goods, '', $order ['order_sn'], true)) {
    //                 RC_Loader::load_theme('extras/model/cart/cart_order_goods_model.class.php');
    //                 $db_order_goods  = new cart_order_goods_model();
       //
       //
    //                 /* 如果没有实体商品，修改发货状态，送积分和红包 */
    //                 $where = array(
    //                     'order_id'  => $order[order_id],
    //                     'is_real'   => 1
    //                 );
    //                 $count = $db_order_goods->where($where)->get_field('COUNT(*)');
    //                 if ($count <= 0) {
    //                     /* 修改订单状态 */
    //                     update_order($order ['order_id'], array(
    //                     'shipping_status' => SS_SHIPPED,
    //                     'shipping_time' => RC_Time::gmtime()
    //                     ));
    //                     /* 如果订单用户不为空，计算积分，并发给用户；发红包 */
    //                     if ($order ['user_id'] > 0) {
    //                         /* 取得用户信息 */
    //                         $user = user_info($order ['user_id']);
    //                         /* 计算并发放积分 */
    //                         $integral = integral_to_give($order);
    //                         log_account_change($order ['user_id'], 0, 0, intval($integral ['rank_points']), intval($integral ['custom_points']), sprintf(RC_Lang::lang('order_gift_integral'), $order ['order_sn']));//model('ClipsBase')->
    //                         /* 发放红包 */
    //                         send_order_bonus($order ['order_id']);
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     /* 清空购物车 */
    //    clear_cart($flow_type, $rec_id);
    //     /* 清除缓存，否则买了商品，但是前台页面读取缓存，商品数量不减少 */
    //     //TODO:缓存处理
    //     /* 插入支付日志 */
    //     $order ['log_id'] = insert_pay_log($new_order_id, $order ['order_amount'], PAY_ORDER);
    //     /* 取得支付信息，生成支付代码 */
    //     if ($order ['order_amount'] > 0) {
    //         RC_Loader::load_app_class('payment_abstract', 'payment', false);
    //         $payment_method = RC_Loader::load_app_class('payment_method','payment');
    //         $payment_info = $payment_method->payment_info_by_id($order ['pay_id']);
    //         /*取得支付信息，生成支付代码*/
    //         $payment_config = $payment_method->unserialize_config($payment_info['pay_config']);
    //         $handler = $payment_method->get_payment_instance($payment_info['pay_code'], $payment_config);
    //         $handler->set_orderinfo($order);
    //         $handler->set_mobile(true);
    //         /* 这是一个支付的抽象类payment_abstract */
    //         $pay_online = $handler->get_code(payment_abstract::PAYCODE_PARAM);
    //         // $db_payment_model = RC_loader::load_app_model('payment_model', 'payment');
    //         RC_Loader::load_theme('extras/model/cart/cart_payment_model.class.php');
    //         $db_payment_model  = new cart_payment_model();
    //         $pay_code = $payment_method->payment_info_by_name($pay_online['pay_name']);
    //         $pay_code = array_column($pay_code,'pay_code');
    //         if(in_array('pay_cod',$pay_code)|| in_array('pay_bank', $pay_code)){
    //             if(in_array('pay_cod',$pay_code)){
    //                 $link = RC_uri::url('user/user_order/order_list').'&status=unshipped';
    //             }elseif(in_array('pay_bank', $pay_code)){
    //                 $link = RC_uri::url('user/user_order/order_list');
    //             }
    //             $pay_online_btn = '<a class="btn btn-info nopjax" href="' . $link . '">去订单列表查看订单</a>';
    //         }else{
    //             $pay_online_btn = '<a class="btn btn-info nopjax" href="' . $pay_online['pay_online'] . '">去' . $pay_online['pay_name'] . '支付</a>';
    //         }
    //         ecjia_front::$controller->assign('pay_online', $pay_online_btn);
    //     }
    //     if (!empty($order ['shipping_name'])) {
    //         $order ['shipping_name'] = trim(stripcslashes($order ['shipping_name']));
    //     }
    //     /*货到付款不显示*/
    //     if ($payment ['pay_code'] != 'balance') {
    //         /* 生成订单后，修改支付，配送方式 */
    //         /*支付方式*/
    //         $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
    //         $payment_list   = empty($payment_method) ? array() : $payment_method->available_payment_list(1, $cod_fee);
    //         if (isset($payment_list)) {
    //             foreach ($payment_list as $key => $payment) {
    //                 /* 如果有易宝神州行支付 如果订单金额大于300 则不显示 */
    //                 if ($payment ['pay_code'] == 'yeepayszx' && $total ['amount'] > 300) {
    //                     $payment_list [$key];
    //                 }
    //                 /*过滤掉当前的支付方式*/
    //                 if ($payment ['pay_id'] == $order ['pay_id']) {
    //                     unset($payment_list [$key]);
    //                 }
    //                 /* 如果有余额支付 */
    //                 if ($payment ['pay_code'] == 'balance') {
    //                     /* 如果未登录，不显示 */
    //                     if ($_SESSION ['user_id'] == 0) {
    //                         unset($payment_list [$key]);
    //                     } else {
    //                         if ($_SESSION ['flow_order'] ['pay_id'] == $payment ['pay_id']) {
    //                             ecjia_front::$controller->assign('disable_surplus', 1);
    //                         }
    //                     }
    //                 }
    //             }
    //         }
    //         ecjia_front::$controller->assign('payment_list', $payment_list);
    //         ecjia_front::$controller->assign('pay_code', 'no_balance');
    //     }
    //     /* 订单信息 */
    //     ecjia_front::$controller->assign('order', $order);
    //     ecjia_front::$controller->assign('total', $total);
    //     ecjia_front::$controller->assign('goods_list', $cart_goods);
    //     ecjia_front::$controller->assign('order_submit_back', sprintf(RC_Lang::lang('order_submit_back'), RC_Lang::lang('back_home'), RC_Lang::lang('goto_user_center')));
    //     user_uc_call('add_feed', array($order ['order_id'], BUY_GOODS));// 推送feed到uc
    //     unset($_SESSION ['flow_consignee']); // 清除session中保存的收货人信息
    //     unset($_SESSION ['flow_order']);
    //     unset($_SESSION ['direct_shopping']);
    //     ecjia_front::$controller->assign('currency_format', ecjia::config('currency_format'));
    //     ecjia_front::$controller->assign('integral_scale', ecjia::config('integral_scale'));
    //     ecjia_front::$controller->assign('step', ROUTE_A);
    //     ecjia_front::$controller->assign('title', RC_Lang::lang('order_submit'));
    //     ecjia_front::$controller->assign_title(RC_Lang::lang('order_submit'));
    //     ecjia_front::$controller->assign_lang();
    
            $address_id = empty($_POST['address_id']) ? 0 : intval($_POST['address_id']);
            $rec_id = empty($_POST['rec_id']) ? 0 : trim($_POST['rec_id']);
            $pay_id = empty($_POST['pay_id']) ? 0 : intval($_POST['pay_id']);
            $shipping_id = empty($_POST['shipping_id']) ? 0 : intval($_POST['shipping_id']);
            $postscript = empty($_POST['note']) ? 0 : trim($_POST['note']);
            
            $url = RC_Uri::site_url() . substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], '/'));
            if(empty($rec_id)) {
                ecjia_front::$controller->showmessage('请选择商品再进行结算', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => RC_Uri::url('cart/flow/checkout')));
            }
            if (empty($address_id)) {
                ecjia_front::$controller->showmessage('请选择收货地址', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => RC_Uri::url('cart/flow/checkout')));
            }
            
            $params = array(
                'token' => ecjia_touch_user::singleton()->getToken(),
                'address_id' => $address_id,
                'rec_id' => $rec_id,
                'shipping_id' => $shipping_id,
                'pay_id' => $pay_id,
                'postscript' => $postscript,
                'location' => array(
                    'longitude' => '121.41709899974',
                    'latitude' => '31.235476867103'
                ),
            );
            $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::FLOW_DONE)->data($params)
            ->send()->getBody();
            $rs = json_decode($rs,true);
            if (! $rs['status']['succeed']) {
                $url = RC_Uri::url('cart/flow/checkout');
                ecjia_front::$controller->showmessage($rs['status']['error_desc'], ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => $url));
            }
//             $_SESSION['cart']['order_info'][$rs['data']['order_id']] = $rs['data'];
            $order_id = $rs['data']['order_id'];
            ecjia_front::$controller->redirect(RC_Uri::url('pay/index/init', array('order_id' => $order_id, 'tips_show' => 1)));
    }

    /**
     * 获取配送地址列表
     */
    public static function consignee_list() {
        // $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : (intval(ecjia::config('article_page_size')) > 0 ? intval(ecjia::config('article_page_size')) : 10);
        // $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        // $start = $size * ($page - 1);
        // /*获得用户所有的收货人信息*/
        // $consignee_list = get_consignee_list($_SESSION['user_id'], 0, $size, $start);
        //
        // if ($consignee_list['list']) {
        //     foreach ($consignee_list['list'] as $k => $v) {
        //         $address = '';
        //         if ($v['province']) {
        //             $address .= get_region_name($v['province']);
        //         }
        //         if ($v['city']) {
        //             $address .= get_region_name($v['city']);
        //         }
        //         if ($v['district']) {
        //             $address .= get_region_name($v['district']);
        //         }
        //         $v['address'] 	= $address . ' ' . $v['address'];
        //         $v['url'] 		= RC_Uri::url('flow/consignee', array('id' => $v ['address_id']));
        //         $address_list[] = $v;
        //     }
        // }
        // ecjia_front::$controller->assign('addres_list', $address_list);
        //
        // /*赋值于模板*/
        // ecjia_front::$controller->assign('title', RC_Lang::lang('consignee_info'));
        // /*加载user语言包*/
        // ecjia_front::$controller->assign('lang', array_merge(RC_Lang::lang(), RC_Lang::load('touch/ecsuser')));
        // ecjia_front::$controller->assign_title(RC_Lang::lang('consignee_info'));
        // ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('flow_consignee_list.dwt');
    }

	/**
	 * 异步加载收货地址
	 */
	public static function async_addres_list(){
		// $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : (intval(ecjia::config('article_page_size')) > 0 ? intval(ecjia::config('article_page_size')) : 10);
		// $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
		// $start = $size * ($page - 1);
		// $consignee_list = get_consignee_list($_SESSION['user_id'], 0, $size, $start);
        //
		// if ($consignee_list['list']) {
		// 	foreach ($consignee_list['list'] as $k => $v) {
		// 		$address = '';
		// 		if ($v['province']) {
		// 			$address .= get_region_name($v['province']);
		// 		}
		// 		if ($v['city']) {
		// 			$address .= get_region_name($v['city']);
		// 		}
		// 		if ($v['district']) {
		// 			$address .= get_region_name($v['district']);
		// 		}
		// 		$v['address'] 	= $address . ' ' . $v['address'];
		// 		$v['url'] 		= RC_Uri::url('flow/consignee', array('id' => $v ['address_id']));
		// 		$address_list[] = $v;
		// 	}
		// }
		// ecjia_front::$controller->assign('addres_list', $address_list);
		// $sayList = ecjia_front::$controller->fetch('flow_consignee_list.dwt');
		// ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page' , 'is_last' => $consignee_list['is_last']));
	}
    /**
     * 收货信息
     */
    public static function consignee() {
        /*编辑收货地址*/
        // $id = isset($_GET['id']) ? intval($_GET['id']) : '';
        // $direct_shopping = isset($_GET['direct_shopping']) ? intval($_GET['direct_shopping']) : 1;
        // $_SESSION['direct_shopping'] = $direct_shopping;
        // /*获得用户对应收货人信息*/
        // $consignee = get_consignee_list($_SESSION['user_id'], $id);
        // $province_list = get_regions(1, 1);
        // $city_list = get_regions(2, $consignee['province']);
        // $district_list = get_regions(3, $consignee['city']);
        // ecjia_front::$controller->assign('title', RC_Lang::lang('edit_address'));
        // ecjia_front::$controller->assign('consignee', $consignee);
        // /*取得国家列表、商店所在国家、商店所在国家的省列表*/
        // ecjia_front::$controller->assign('country_list', get_regions());
        // ecjia_front::$controller->assign('shop_province_list', get_regions(1, ecjia::config('shop_country')));
        // ecjia_front::$controller->assign('province_list', $province_list);
        // ecjia_front::$controller->assign('city_list', $city_list);
        // ecjia_front::$controller->assign('district_list', $district_list);
        //
        // /* 取得购物类型 */
        // $flow_type = isset($_SESSION ['flow_type']) ? intval($_SESSION ['flow_type']) : CART_GENERAL_GOODS;
        // ecjia_front::$controller->assign('real_goods_count', exist_real_goods(0, $flow_type));
        // ecjia_front::$controller->assign_title(RC_Lang::lang('edit_address'));
        // ecjia_front::$controller->assign_lang();
        // ecjia_front::$controller->display('flow_consignee.dwt');
    }

    /**
     * 修改收货信息的方法
     */
    public static function update_consignee() {
        // RC_Loader::load_theme('extras/model/cart/cart_user_address_model.class.php');
        // $db_user_address = new cart_user_address_model();
        // /* 取得购物类型 */
        // $flow_type = isset($_SESSION ['flow_type']) ? intval($_SESSION ['flow_type']) : CART_GENERAL_GOODS;
        // $referer = empty($_POST['referer']) ? RC_Uri::url('cart/index/init') :  urldecode($_POST['referer']);
        // $id = intval($_GET ['id']);
        // $address = $db_user_address->field('consignee, country, province, city, district, address, mobile')->where(array('address_id' => $id, 'user_id' => $_SESSION['user_id']))->find();
        // /*  保存收货人信息 	 */
        // $consignee = array(
        //     'address_id' 	=> empty($_POST ['address_id']) ? $id                   : intval($_POST ['address_id']),
        //     'consignee' 	=> empty($_POST ['consignee'])  ? $address['consignee'] : htmlspecialchars($_POST['consignee']),
        //     'country'	 	=> empty($_POST ['country'])    ? $address['country']   : intval($_POST ['country']),
        //     'province' 		=> empty($_POST ['province'])   ? $address['province']  : intval($_POST ['province']),
        //     'city'			=> empty($_POST ['city'])       ? $address['city']      : intval($_POST ['city']),
        //     'district' 		=> empty($_POST ['district'])   ? $address['district']  : intval($_POST ['district']),
        //     'address' 		=> empty($_POST ['address'])    ? $address['address']   : htmlspecialchars($_POST['address']),
        //     'mobile' 		=> empty($_POST ['mobile'])     ? $address['mobile']    : make_semiangle(htmlspecialchars($_POST['mobile']))
        // );
        // if ($_SESSION ['user_id'] > 0) {
        //     /* 如果用户已经登录，则保存收货人信息 */
        //     $consignee ['user_id'] = $_SESSION ['user_id'];
        //     save_consignee($consignee, true);
        // }
        // /* 保存到session */
        // $_SESSION ['flow_consignee'] = stripslashes_deep($consignee);
        // if (!check_consignee_info($_SESSION ['flow_consignee'], $flow_type)){
        //     ecjia_front::$controller->showmessage('收货人信息填写不完整', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // }else{
        //     ecjia_front::$controller->showmessage('成功修改配送地址', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl'=> $referer));
        // }
    }

    /**
     *
     * 删除收货人信息
     *
     */
    public static function drop_consignee() {
        // $consignee_id = intval($_GET['id']);
        // drop_consignee_addres($consignee_id);
        // ecjia_front::$controller->showmessage('删除收货人信息成功', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl'=>RC_Uri::url('flow/consignee_list')));
    }

    /**
     * 改变余额
     */
    public static function change_surplus() {
        // $surplus = floatval($_GET['surplus']);
        // $rec_id = $_GET['rec_id'];
        // $user_info = user_info($_SESSION['user_id']);
        // if ($user_info['user_money'] + $user_info['credit_line'] < $surplus) {
        //     $result['error'] = RC_Lang::lang('surplus_not_enough');
        // } else {
        //     /* 取得购物类型 */
        //     $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;
        //     /* 取得购物流程设置 */
        //     ecjia_front::$controller->assign('config', ecjia::config('CFG'));
        //     /* 获得收货人信息 */
        //     $consignee = get_consignee($_SESSION['user_id']);
        //     /* 对商品信息赋值 */
        //     $cart_goods = cart_goods($flow_type,$rec_id); // 取得商品列表，计算合计
        //     if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type)) {
        //         $result['error'] = RC_Lang::lang('no_goods_in_cart');
        //     } else {
        //         /* 取得订单信息 */
        //         $order = flow_order_info();
        //         $order['surplus'] = $surplus;
        //         /* 计算订单的费用 */
        //         $total = order_fee($order, $cart_goods, $consignee);
        //         ecjia_front::$controller->assign('total', $total);
        //         /* 团购标志 */
        //         if ($flow_type == CART_GROUP_BUY_GOODS) {
        //             ecjia_front::$controller->assign('is_group_buy', 1);
        //         }
        //         ecjia_front::$controller->assign_lang();
        //         $result['content'] = ecjia_front::$controller->fetch('library/order_total.lbi');
        //     }
        // }
        // ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, $result);
    }

    /**
     * 改变积分
     */
    public static function change_integral() {
        // $points = floatval($_GET['integral']);
        // $rec_id = $_GET['rec_id'];
        // $user_info = user_info($_SESSION['user_id']);//model('Order')->
        // /* 取得订单信息 */
        // $order = flow_order_info();
        // $flow_points = flow_available_points(); // 该订单允许使用的积分
        // $user_points = $user_info['pay_points']; // 用户的积分总数
        // if ($points > $user_points) {
        //     $result['error'] = RC_Lang::lang('integral_not_enough');
        // } elseif ($points > $flow_points) {
        //     $result['error'] = sprintf(RC_Lang::lang('integral_too_much'), $flow_points);
        // } else {
        //     /* 取得购物类型 */
        //     $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;
        //     $order['integral'] = $points;
        //     /* 获得收货人信息 */
        //     $consignee = get_consignee($_SESSION['user_id']);//model('Order')->
        //     /* 对商品信息赋值 */
        //     $cart_goods = cart_goods($flow_type,$rec_id); // 取得商品列表，计算合计//model('Order')->
        //     if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type)) {//model('Order')->
        //         $result['error'] = RC_Lang::lang('no_goods_in_cart');
        //     } else {
        //         /* 计算订单的费用 */
        //         $total = order_fee($order, $cart_goods, $consignee);//model('Users')->
        //         ecjia_front::$controller->assign('total', $total);
        //         ecjia_front::$controller->assign('config', ecjia::config('CFG'));
        //         /* 团购标志 */
        //         if ($flow_type == CART_GROUP_BUY_GOODS) {
        //             ecjia_front::$controller->assign('is_group_buy', 1);
        //         }
        //         ecjia_front::$controller->assign_lang();
        //         $result['content'] = ecjia_front::$controller->fetch('library/order_total.lbi');
        //         $result['error'] = '';
        //     }
        // }
        // ecjia_front::$controller->showmessage($result, ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON);

    }

    /**
     * 改变红包
     */
    public static function change_bonus() {
        // $result = array('error' => '', 'content' => '');
        // $rec_id = $_GET['rec_id'];
        // /* 取得购物类型 */
        // $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;
        // /* 获得收货人信息 */
        // $consignee = get_consignee($_SESSION['user_id']);//model('Order')->
        // /* 对商品信息赋值 */
        // $cart_goods = cart_goods($flow_type,$rec_id); // 取得商品列表，计算合计//model('Order')->
        // if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type)) {//model('Order')->
        //     $result['error'] = RC_Lang::lang('no_goods_in_cart');
        // } else {
        //     /* 取得购物流程设置 */
        //     ecjia_front::$controller->assign_lang('config', ecjia::config('CFG'));
        //     /* 取得订单信息 */
        //     $order = flow_order_info();//model('Order')->
        //     $bonus = bonus_info(intval($_GET['bonus']));//model('Order')->
        //     if ((!empty($bonus) && $bonus['user_id'] == $_SESSION['user_id']) || $_GET['bonus'] == 0) {
        //         $order['bonus_id'] = intval($_GET['bonus']);
        //     } else {
        //         $order['bonus_id'] = 0;
        //         $result['error'] = RC_Lang::lang('invalid_bonus');
        //     }
        //     /* 计算订单的费用 */
        //     $total = order_fee($order, $cart_goods, $consignee);//model('Users')->
        //     ecjia_front::$controller->assign('total', $total);
        //     /* 团购标志 */
        //     if ($flow_type == CART_GROUP_BUY_GOODS) {
        //         ecjia_front::$controller->assign('is_group_buy', 1);
        //     }
        //     ecjia_front::$controller->assign_lang();
        //     $result['content'] = ecjia_front::$controller->fetch('library/order_total.lbi');
        // }
        // ecjia_front::$controller->showmessage($result['error'], ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON,$result);
    }

    /**
     * 改变发票的设置
     */
    public static function change_needinv() {
        // $result = array('error' => '', 'content' => '');
        // $_GET['inv_type']       = !empty($_GET['inv_type'])     ? urldecode($_GET['inv_type'])      : '';
        // $_GET['invPayee']       = !empty($_GET['invPayee'])     ? urldecode($_GET['invPayee'])      : '';
        // $_GET['inv_content']    = !empty($_GET['inv_content'])  ? urldecode($_GET['inv_content'])   : '';
        // $rec_id                 = !empty($_GET['rec_id'])       ? $_GET['rec_id']                   : '';
        // /* 取得购物类型 */
        // $flow_type = isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;
        // /* 获得收货人信息 */
        // $consignee = get_consignee($_SESSION['user_id']);//model('Order')->
        // /* 对商品信息赋值 */
        // $cart_goods = cart_goods($flow_type,$rec_id); // 取得商品列表，计算合计//model('Order')->
        // if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type)) {//model('Order')->
        //     $result['error'] = RC_Lang::lang('no_goods_in_cart');
        //     ecjia_front::$controller->showmessage($result, ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        // } else {
        //     /* 取得购物流程设置 */
        //     ecjia_front::$controller->assign('config', ecjia::config('CFG'));
        //     /* 取得订单信息 */
        //     $order = flow_order_info();//model('Order')->
        //     if (isset($_GET['need_inv']) && intval($_GET['need_inv']) == 1) {
        //         $order['need_inv'] 		= 1;
        //         $order['inv_type'] 		= trim(stripslashes($_GET['inv_type']));
        //         $order['inv_payee'] 	= trim(stripslashes($_GET['inv_payee']));
        //         $order['inv_content'] 	= trim(stripslashes($_GET['inv_content']));
        //     } else {
        //         $order['need_inv'] 		= 0;
        //         $order['inv_type'] 		= '';
        //         $order['inv_payee'] 	= '';
        //         $order['inv_content'] 	= '';
        //     }
        //     /* 计算订单的费用 */
        //     $total 	= order_fee($order, $cart_goods, $consignee);//model('Users')->
        //     ecjia_front::$controller->assign('total', $total);
        //     /* 团购标志 */
        //     if ($flow_type == CART_GROUP_BUY_GOODS) {
        //         ecjia_front::$controller->assign('is_group_buy', 1);
        //     }
        //     ecjia_front::$controller->assign_lang();
        //     die(ecjia_front::$controller->fetch('library/order_total.lbi'));
        // }
    }

    /**
     * 检查用户输入的余额
     */
    public static function check_surplus() {
        /*检查用户输入的余额*/
        // $surplus = floatval($_GET['surplus']);
        // $user_info = user_info($_SESSION['user_id']);
        // if (($user_info['user_money'] + $user_info['credit_line'] < $surplus)) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('surplus_not_enough'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        // }
        // exit;
    }

    /**
     * 检查用户输入的余额
     */
    public static function check_integral() {
        // $points 		= floatval($_GET['integral']);
        // $user_info		= user_info($_SESSION['user_id']);
        // $flow_points 	= flow_available_points();  // 该订单允许使用的积分
        // $user_points 	= $user_info['pay_points']; // 用户的积分总数
        // if ($points > $user_points) {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('integral_not_enough'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        // }
        // if ($points > $flow_points) {
        //     ecjia_front::$controller->showmessage(sprintf(RC_Lang::lang('integral_too_much'), $flow_points), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        // }
        // exit;
    }


    /**
     *  验证红包序列号
     */
    public static function validate_bonus() {
        // $bonus_sn 	= trim($_REQUEST['bonus_sn']);
        // $rec_id 	= trim($_REQUEST['rec_id']);
        // if (is_numeric($bonus_sn)) {
        //     $bonus	= bonus_info(0, $bonus_sn);
        // } else {
        //     $bonus	= array();
        // }
        // $bonus_kill	= price_format($bonus['type_money'], false);
        // $result		= array('error' => '', 'content' => '');
        // /* 取得购物类型 */
        // $flow_type	= isset($_SESSION['flow_type']) ? intval($_SESSION['flow_type']) : CART_GENERAL_GOODS;
        // /* 获得收货人信息 */
        // $consignee	= get_consignee($_SESSION['user_id']);
        // /* 对商品信息赋值 */
        // $cart_goods = cart_goods($flow_type,$rec_id); // 取得商品列表，计算合计
        // if (empty($cart_goods) || !check_consignee_info($consignee, $flow_type)) {
        //     $result['error'] = RC_Lang::lang('no_goods_in_cart');
        // } else {
        //     /* 取得购物流程设置 */
        //     ecjia_front::$controller->assign('config', ecjia::config());
        //     /* 取得订单信息 */
        //     $order = flow_order_info();
        //     if (((!empty($bonus) && $bonus['user_id'] == $_SESSION['user_id']) || ($bonus['type_money'] > 0 && empty($bonus['user_id']))) && $bonus['order_id'] <= 0) {
        //         $now = RC_Time::gmtime();
        //         if ($now > $bonus['use_end_date']) {
        //             $order['bonus_id'] = '';
        //             $result['error'] = RC_Lang::lang('bonus_use_expire');
        //         } else {
        //             $order['bonus_id'] = $bonus['bonus_id'];
        //             $order['bonus_sn'] = $bonus_sn;
        //         }
        //     } else {
        //         $order['bonus_id'] = '';
        //         $result['error'] = RC_Lang::lang('invalid_bonus');
        //     }
        //     /* 计算订单的费用 */
        //     $total = order_fee($order, $cart_goods, $consignee);
        //     if ($total['goods_price'] < $bonus['min_goods_amount']) {
        //         $order['bonus_id'] = '';
        //         /* 重新计算订单 */
        //         $total = order_fee($order, $cart_goods, $consignee);
        //         $result['error'] = sprintf(RC_Lang::lang('bonus_min_amount_error'), price_format($bonus['min_goods_amount'], false));
        //     }
        //     ecjia_front::$controller->assign('total', $total);
        //     /* 团购标志 */
        //     if ($flow_type == CART_GROUP_BUY_GOODS) {
        //         ecjia_front::$controller->assign('is_group_buy', 1);
        //     }
        //     ecjia_front::$controller->assign_lang();
        //     $result['content'] = ecjia_front::$controller->fetch('library/order_total.lbi');
        // }
        // ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, $result);
    }

    /**
     * 改变配送地址
     */
    public static function select_address() {
        // $address_id = intval($_REQUEST['address']);
        // if (save_consignee_default($address_id)) {
        //     ecjia_front::$controller->showmessage('成功修改配送地址', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('need_insure' => 0, 'address' => 1));
        // } else {
        //     ecjia_front::$controller->showmessage(RC_Lang::lang('choose_ship_err'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('need_insure' => 0, 'address' => 1));
        // }
    }

    /**
     * 改变支付方式
     */
    public static function pay() {
        // $payment_method = RC_Loader::load_app_class('payment_method', 'payment');
        // $payment_list 	= empty($payment_method) ? array() : $payment_method->available_payment_list(1, $cod_fee);
        // /*过滤支付方式*/
        // $pay = array('pay_balance','pay_koolyun','pay_cash');
        // if (isset($payment_list)) {
        //     foreach ($payment_list as $key => $payment) {
        //         $payment_list [$key] ['format_pay_fee'] = strpos($payment['pay_fee'], '%') !== false ? $payment['pay_fee'] : price_format($payment['pay_fee'], false);
        //         if ($payment ['is_cod'] == '1') {
        //             $payment_list [$key] ['format_pay_fee'] = '<span id="ECS_CODFEE">' . $payment_list [$key] ['format_pay_fee'] . '</span>';
        //         }
        //         /* 如果有易宝神州行支付 如果订单金额大于300 则不显示 */
        //         if ($payment ['pay_code'] == 'yeepayszx' && $total ['amount'] > 300) {
        //             unset($payment_list [$key]);
        //         }
        //         /* 如果有余额支付 不显示*/
        //         if(in_array($payment['pay_code'],$pay)){
        //             unset($payment_list[$key]);
        //         }
        //         if ($_SESSION ['flow_order'] ['pay_id'] == $payment ['pay_id']) {
        //             ecjia_front::$controller->assign('disable_surplus', 1);
        //         }
        //     }
        // }
	    // reset($payment_list);
	    // $payment_list[key($payment_list)]['default'] = 1;
	    // $payment_default = $payment_list[key($payment_list)]['pay_name'].$payment_list[key($payment_list)]['format_pay_fee'];
	    // ecjia_front::$controller->assign('payment_default',$payment_default);
        // ecjia_front::$controller->assign('payment_list', $payment_list);
        // // _dump($payment_list,1);
        
        
        /* $data = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_PAYMENT)
        ->send()->getBody();
        $data = json_decode($data,true); */
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
        ecjia_front::$controller->assign('payment_list', $data['payment_list']);
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
        // RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
        // $db_cart            = new cart_model();
        // $shipping_method	= RC_Loader::load_app_class('shipping_method', 'shipping');
        // $consignee = get_consignee($_SESSION['user_id']);
        // $region = array(
        //     $consignee['country'],
        //     $consignee['province'],
        //     $consignee['city'],
        //     $consignee['district']
        // );
        // $payment_method = RC_Loader::load_app_class('payment_method','payment');
        // $shipping_list		= empty($shipping_method) ? array() : $shipping_method->available_shipping_list($region);
        // foreach ($shipping_list as $key => $val) {
        //     $shipping_cfg 									= $payment_method->unserialize_config($val['configure']);
        //     $shipping_fee 									= ($shipping_count == 0 and $cart_weight_price ['free_shipping'] == 1) ? 0 : $shipping_method->shipping_fee($val ['shipping_code'], unserialize($val ['configure']), $cart_weight_price ['weight'], $cart_weight_price ['amount'], $cart_weight_price ['number']);
        //     $shipping_list [$key] ['format_shipping_fee'] 	= price_format($shipping_fee, false);
        //     $shipping_list [$key] ['shipping_fee'] 			= $shipping_fee;
        //     $shipping_list [$key] ['free_money'] 			= price_format($shipping_cfg ['free_money'], false);
        //     $shipping_list [$key] ['insure_formated'] 		= strpos($val ['insure'], '%') === false ? price_format($val ['insure'], false) : $val ['insure'];
        //     /* 当前的配送方式是否支持保价 */
        //     if ($val ['shipping_id'] == $order ['shipping_id']) {
        //     $insure_disabled 	= ($val ['insure'] == 0);
        //     $cod_disabled 		= ($val ['support_cod'] == 0);
        //     }
        // }
        // reset($shipping_list);
        // ecjia_front::$controller->assign('shipping_default',$shipping_default);
        // ecjia_front::$controller->assign('shipping_list', $shipping_list);
        
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

    /**
     * 开发票
     */
    public static function invoice() {
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
        $data = $_SESSION['cart'][$cart_key];
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
            ecjia_front::$controller->showmessage('请选择商品再进行结算', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        if (empty($address_id)) {
            ecjia_front::$controller->showmessage('请选择收货地址', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT, array('pjaxurl' => RC_Uri::url('cart/index/init')));
        }
        
        $cart_key = md5($address_id.$rec_id);
        $data = $_SESSION['cart'][$cart_key];
        ecjia_front::$controller->assign('data', $data);
        ecjia_front::$controller->assign('address_id', $address_id);
        ecjia_front::$controller->assign('rec_id', $rec_id);
        
//         ecjia_front::$controller->assign('title', RC_Lang::lang('use_integral'));
        ecjia_front::$controller->assign_title(RC_Lang::lang('use_integral'));
        ecjia_front::$controller->display('flow_integral.dwt');
    }

}


// end
