<?php

RC_Loader::load_app_class('touch', 'touch', false);

RC_Loader::load_theme('extras/controller/touch_controller.php');
RC_Hook::add_action('touch/index/init', array('touch_controller', 'init'));
RC_Hook::add_action('touch/index/my_location', array('touch_controller', 'my_location'));
RC_Hook::add_action('touch/index/download', array('touch_controller', 'download'));
RC_Hook::add_action('touch/index/ajax_goods', array('touch_controller', 'ajax_goods'));
RC_Hook::add_action('touch/index/search', array('touch_controller', 'search'));
RC_Hook::add_action('touch/index/del_search', array('touch_controller', 'del_search'));


//定位
RC_Loader::load_theme('extras/controller/location_controller.php');
RC_Hook::add_action('location/index/select_location', array('location_controller', 'select_location'));
RC_Hook::add_action('location/index/search_location', array('location_controller', 'search_location'));
RC_Hook::add_action('location/index/search_list', 	  array('location_controller', 'search_list'));
RC_Hook::add_action('location/index/select_city', 	  array('location_controller', 'select_city'));


//商品
RC_Loader::load_theme('extras/controller/goods_controller.php');
RC_Hook::add_action('goods/category/init', array('goods_controller', 'init'));
RC_Hook::add_action('goods/category/all', array('goods_controller', 'all'));
RC_Hook::add_action('goods/category/goods_list', array('goods_controller', 'goods_list'));
RC_Hook::add_action('goods/category/asynclist', array('goods_controller', 'asynclist'));
RC_Hook::add_action('goods/category/store_list', array('goods_controller', 'store_list'));//店铺分类列表
RC_Hook::add_action('goods/category/seller_list', array('goods_controller', 'seller_list'));//店铺分类列表

//店铺
RC_Loader::load_theme('extras/controller/merchant_controller.php');
RC_Hook::add_action('merchant/index/init', array('merchant_controller', 'init'));//店铺首页
RC_Hook::add_action('merchant/index/ajax_goods', array('merchant_controller', 'ajax_goods'));//获取店铺商品
RC_Hook::add_action('merchant/detail/init', array('merchant_controller', 'detail'));//店铺详情
RC_Hook::add_action('merchant/index/position', array('merchant_controller', 'position'));//店铺位置

RC_Hook::add_action('goods/index/show', array('goods_controller', 'goods_info'));//商品详情页
RC_Hook::add_action('goods/index/promotion', array('goods_controller', 'goods_promotion'));
RC_Hook::add_action('goods/index/ajax_goods', array('goods_controller', 'ajax_goods'));
RC_Hook::add_action('goods/index/new', array('goods_controller', 'goods_new'));
RC_Hook::add_action('goods/index/price', array('goods_controller', 'goods_price'));
RC_Hook::add_action('goods/index/add_tags', array('goods_controller', 'add_tags'));
RC_Hook::add_action('goods/index/tag', array('goods_controller', 'tags_list'));
RC_Hook::add_action('goods/index/comment', array('goods_controller', 'comment'));

//文章
RC_Loader::load_theme('extras/controller/article_controller.php');
RC_Hook::add_action('article/help/init', array('article_controller', 'init'));
RC_Hook::add_action('article/index/art_list', array('article_controller', 'art_list'));
RC_Hook::add_action('article/index/asynclist', array('article_controller', 'asynclist'));
RC_Hook::add_action('article/help/detail', array('article_controller', 'detail'));
RC_Hook::add_action('article/shop/detail', array('article_controller', 'shop_detail'));

//购物车
RC_Loader::load_theme('extras/controller/cart_controller.php');
RC_Hook::add_action('cart/index/init', array('cart_controller', 'init'));
RC_Hook::add_action('cart/index/update_cart', array('cart_controller', 'update_cart'));//更新购物车中商品
RC_Hook::add_action('cart/index/add_to_cart', array('cart_controller', 'add_to_cart'));
RC_Hook::add_action('cart/index/ajax_update_cart', array('cart_controller', 'ajax_update_cart'));
RC_Hook::add_action('cart/index/goods_fittings', array('cart_controller', 'goods_fittings'));
RC_Hook::add_action('cart/index/drop_goods', array('cart_controller', 'drop_goods'));
RC_Hook::add_action('cart/index/add_favourable', array('cart_controller', 'add_favourable'));
RC_Hook::add_action('cart/index/label_favourable', array('cart_controller', 'label_favourable'));
RC_Hook::add_action('cart/flow/checkout', array('cart_controller', 'checkout'));
RC_Hook::add_action('cart/flow/pay', array('cart_controller', 'pay'));
RC_Hook::add_action('cart/flow/shipping', array('cart_controller', 'shipping'));
RC_Hook::add_action('cart/flow/invoice', array('cart_controller', 'invoice'));
RC_Hook::add_action('cart/flow/note', array('cart_controller', 'note'));
RC_Hook::add_action('cart/flow/bonus', array('cart_controller', 'bonus'));
RC_Hook::add_action('cart/flow/integral', array('cart_controller', 'integral'));
RC_Hook::add_action('cart/flow/select_shipping', array('cart_controller', 'select_shipping'));
RC_Hook::add_action('cart/flow/shipping_date', array('cart_controller', 'shipping_date'));
RC_Hook::add_action('cart/flow/select_payment', array('cart_controller', 'select_payment'));
RC_Hook::add_action('cart/flow/done', array('cart_controller', 'done'));
RC_Hook::add_action('cart/flow/change_surplus', array('cart_controller', 'change_surplus'));
RC_Hook::add_action('cart/flow/change_integral', array('cart_controller', 'change_integral'));
RC_Hook::add_action('cart/flow/change_bonus', array('cart_controller', 'change_bonus'));
RC_Hook::add_action('cart/flow/change_needinv', array('cart_controller', 'change_needinv'));
RC_Hook::add_action('cart/flow/get_total', array('cart_controller', 'get_total'));
RC_Hook::add_action('cart/flow/check_surplus', array('cart_controller', 'check_surplus'));
RC_Hook::add_action('cart/flow/check_integral', array('cart_controller', 'check_integral'));
RC_Hook::add_action('cart/flow/validate_bonus', array('cart_controller', 'validate_bonus'));
RC_Hook::add_action('cart/flow/select_address', array('cart_controller', 'select_address'));
RC_Hook::add_action('cart/flow/change_payment', array('cart_controller', 'change_payment'));
RC_Hook::add_action('cart/flow/consignee_list', array('cart_controller', 'consignee_list'));
RC_Hook::add_action('cart/flow/consignee', array('cart_controller', 'consignee'));
RC_Hook::add_action('cart/flow/update_consignee', array('cart_controller', 'update_consignee'));
RC_Hook::add_action('cart/flow/async_addres_list', array('cart_controller', 'async_addres_list'));
RC_Hook::add_action('cart/flow/drop_consignee', array('cart_controller', 'drop_consignee'));
RC_Hook::add_action('cart/flow/goods_list', array('cart_controller', 'goods_list'));

//支付
RC_Loader::load_theme('extras/controller/pay_controller.php');
RC_Hook::add_action('pay/index/init', array('pay_controller', 'init'));

//评论
RC_Loader::load_theme('extras/controller/comment_controller.php');
RC_Hook::add_action('comment/index/init', array('comment_controller', 'init'));
RC_Hook::add_action('comment/index/async_comment_list', array('comment_controller', 'async_comment_list'));
RC_Hook::add_action('comment/index/add_comment', array('comment_controller', 'add_comment'));

//优惠活动
RC_Loader::load_theme('extras/controller/favourable_controller.php');
RC_Hook::add_action('favourable/index/init', array('favourable_controller', 'init'));
RC_Hook::add_action('favourable/index/goods_list', array('favourable_controller', 'goods_list'));

//会员
RC_Loader::load_theme('extras/controller/user_controller.php');
RC_Hook::add_action('touch/my/init', array('user_controller', 'init'));
RC_Hook::add_action('user/index/spread', array('user_controller', 'spread'));
// RC_Hook::add_action('user/index/validate_email', array('user_controller', 'validate_email'));
// RC_Hook::add_action('user/index/get_password_question', array('user_controller', 'get_password_question'));
// RC_Hook::add_action('user/index/question_get_password', array('user_controller', 'question_get_password'));
// RC_Hook::add_action('user/index/send_pwd_email', array('user_controller', 'send_pwd_email'));
// RC_Hook::add_action('user/index/update_password', array('user_controller', 'update_password'));
// RC_Hook::add_action('user/index/history', array('user_controller', 'history'));
// RC_Hook::add_action('user/index/clear_history', array('user_controller', 'clear_history'));
// RC_Hook::add_action('user/index/send_captcha', array('user_controller', 'send_captcha'));
// RC_Hook::add_action('user/index/act_register', array('user_controller', 'phone_register'));


//登陆注册
RC_Loader::load_theme('extras/controller/user_privilege_controller.php');
RC_Hook::add_action('user/privilege/login', array('user_privilege_controller', 'login'));
RC_Hook::add_action('user/privilege/signin', array('user_privilege_controller', 'signin'));
RC_Hook::add_action('user/privilege/signup', array('user_privilege_controller', 'signup'));
RC_Hook::add_action('user/privilege/register', array('user_privilege_controller', 'register'));
RC_Hook::add_action('user/privilege/bind_signup', array('user_privilege_controller', 'bind_signup'));
RC_Hook::add_action('user/privilege/bind_signup_do', array('user_privilege_controller', 'bind_signup_do'));
RC_Hook::add_action('user/privilege/bind_signin', array('user_privilege_controller', 'bind_signin'));
RC_Hook::add_action('user/privilege/bind_signin_do', array('user_privilege_controller', 'bind_signin_do'));
RC_Hook::add_action('user/privilege/bind_login', array('user_privilege_controller', 'bind_login'));
RC_Hook::add_action('user/privilege/validate_code', array('user_privilege_controller', 'validate_code'));
RC_Hook::add_action('user/privilege/set_password', array('user_privilege_controller', 'set_password'));
RC_Hook::add_action('user/privilege/logout', array('user_privilege_controller', 'logout'));

//找回密码
RC_Loader::load_theme('extras/controller/user_get_password_controller.php');
RC_Hook::add_action('user/get_password/mobile_register', array('user_get_password_controller', 'mobile_register'));
RC_Hook::add_action('user/get_password/mobile_register_account', array('user_get_password_controller', 'mobile_register_account'));
RC_Hook::add_action('user/get_password/reset_password', array('user_get_password_controller', 'reset_password'));

RC_Loader::load_theme('extras/controller/user_account_controller.php');
RC_Hook::add_action('user/user_account/account_detail', array('user_account_controller', 'account_detail'));
RC_Hook::add_action('user/user_account/recharge', array('user_account_controller', 'recharge'));
RC_Hook::add_action('user/user_account/recharge_account', array('user_account_controller', 'recharge_account'));
RC_Hook::add_action('user/user_account/withdraw', array('user_account_controller', 'withdraw'));
RC_Hook::add_action('user/user_account/withdraw_account', array('user_account_controller', 'withdraw_account'));
RC_Hook::add_action('user/user_account/detail', array('user_account_controller', 'detail'));
RC_Hook::add_action('user/user_account/account_list', array('user_account_controller', 'account_list'));
RC_Hook::add_action('user/user_account/record', array('user_account_controller', 'record'));
RC_Hook::add_action('user/user_account/ajax_record', array('user_account_controller', 'ajax_record'));
RC_Hook::add_action('user/user_account/ajax_record_raply', array('user_account_controller', 'ajax_record_raply'));
RC_Hook::add_action('user/user_account/ajax_record_deposit', array('user_account_controller', 'ajax_record_deposit'));
RC_Hook::add_action('user/user_account/record_info', array('user_account_controller', 'record_info'));
RC_Hook::add_action('user/user_account/record_cancel', array('user_account_controller', 'record_cancel'));

RC_Loader::load_theme('extras/controller/user_address_controller.php');
RC_Hook::add_action('user/user_address/address_list', array('user_address_controller', 'address_list'));
RC_Hook::add_action('user/user_address/async_address_list', array('user_address_controller', 'async_address_list'));
RC_Hook::add_action('user/user_address/add_address', array('user_address_controller', 'add_address'));
RC_Hook::add_action('user/user_address/insert_address', array('user_address_controller', 'insert_address'));
RC_Hook::add_action('user/user_address/edit_address', array('user_address_controller', 'edit_address'));
RC_Hook::add_action('user/user_address/update_address', array('user_address_controller', 'update_address'));
RC_Hook::add_action('user/user_address/del_address', array('user_address_controller', 'del_address'));
RC_Hook::add_action('user/user_address/save_temp_data', array('user_address_controller', 'save_temp_data'));
RC_Hook::add_action('user/user_address/region', array('user_address_controller', 'region'));
RC_Hook::add_action('user/user_address/location', array('user_address_controller', 'location'));
RC_Hook::add_action('user/user_address/near_location', array('user_address_controller', 'near_location'));
RC_Hook::add_action('user/user_address/async_location', array('user_address_controller', 'async_location'));
RC_Hook::add_action('user/user_address/city', array('user_address_controller', 'city'));
RC_Hook::add_action('user/user_address/near_address', array('user_address_controller', 'near_address'));
RC_Hook::add_action('user/user_address/set_default', array('user_address_controller', 'set_default'));
RC_Hook::add_action('user/user_address/choose_address', array('user_address_controller', 'choose_address'));

RC_Loader::load_theme('extras/controller/user_bonus_controller.php');
RC_Hook::add_action('user/user_bonus/bonus', array('user_bonus_controller', 'bonus'));
RC_Hook::add_action('user/user_bonus/add_bonus', array('user_bonus_controller', 'add_bonus'));
// RC_Hook::add_action('user/user_bonus/async_bonus_list', array('user_bonus_controller', 'async_bonus_list'));
RC_Hook::add_action('user/user_bonus/async_allow_use', array('user_bonus_controller', 'async_allow_use'));
RC_Hook::add_action('user/user_bonus/async_is_used', array('user_bonus_controller', 'async_is_used'));
RC_Hook::add_action('user/user_bonus/async_expired', array('user_bonus_controller', 'async_expired'));
RC_Hook::add_action('user/user_bonus/my_reward', array('user_bonus_controller', 'my_reward'));
RC_Hook::add_action('user/user_bonus/reward_detail', array('user_bonus_controller', 'reward_detail'));
RC_Hook::add_action('user/user_bonus/get_integral', array('user_bonus_controller', 'get_integral'));
RC_Hook::add_action('user/user_bonus/async_reward_detail', array('user_bonus_controller', 'async_reward_detail'));

RC_Loader::load_theme('extras/controller/user_collection_controller.php');
RC_Hook::add_action('user/user_collection/collection_list', array('user_collection_controller', 'collection_list'));
RC_Hook::add_action('user/user_collection/async_collection_list', array('user_collection_controller', 'async_collection_list'));
RC_Hook::add_action('user/user_collection/add_attention', array('user_collection_controller', 'add_attention'));
RC_Hook::add_action('user/user_collection/del_attention', array('user_collection_controller', 'del_attention'));
RC_Hook::add_action('user/user_collection/delete_collection', array('user_collection_controller', 'delete_collection'));
RC_Hook::add_action('user/user_collection/add_collection', array('user_collection_controller', 'add_collection'));


RC_Loader::load_theme('extras/controller/user_message_controller.php');
RC_Hook::add_action('user/user_message/msg_list', array('user_message_controller', 'msg_list'));
RC_Hook::add_action('user/user_message/async_msg_list', array('user_message_controller', 'async_msg_list'));
RC_Hook::add_action('user/user_message/msg_detail', array('user_message_controller', 'msg_detail'));
RC_Hook::add_action('user/user_message/del_msg', array('user_message_controller', 'del_msg'));

//订单
RC_Loader::load_theme('extras/controller/user_order_controller.php');
RC_Hook::add_action('user/user_order/order_list', array('user_order_controller', 'order_list'));
RC_Hook::add_action('user/user_order/order_cancel', array('user_order_controller', 'order_cancel'));
RC_Hook::add_action('user/user_order/async_order_list', array('user_order_controller', 'async_order_list'));
RC_Hook::add_action('user/user_order/order_tracking', array('user_order_controller', 'order_tracking'));
RC_Hook::add_action('user/user_order/order_detail', array('user_order_controller', 'order_detail'));
RC_Hook::add_action('user/user_order/affirm_received', array('user_order_controller', 'affirm_received'));
RC_Hook::add_action('user/user_order/edit_payment', array('user_order_controller', 'edit_payment'));
RC_Hook::add_action('user/user_order/edit_surplus', array('user_order_controller', 'edit_surplus'));
RC_Hook::add_action('user/user_order/buy_again', array('user_order_controller', 'buy_again'));

RC_Loader::load_theme('extras/controller/user_package_controller.php');
RC_Hook::add_action('user/user_package/service', array('user_package_controller', 'service'));
RC_Hook::add_action('user/user_package/add_server', array('user_package_controller', 'add_server'));

RC_Loader::load_theme('extras/controller/user_profile_controller.php');
RC_Hook::add_action('user/user_profile/edit_profile', array('user_profile_controller', 'edit_profile'));
RC_Hook::add_action('user/user_profile/modify_username', array('user_profile_controller', 'modify_username'));
RC_Hook::add_action('user/user_profile/modify_username_account', array('user_profile_controller', 'modify_username_account'));
RC_Hook::add_action('user/user_profile/update_profile', array('user_profile_controller', 'update_profile'));
RC_Hook::add_action('user/user_profile/edit_password', array('user_profile_controller', 'edit_password'));

RC_Loader::load_theme('extras/controller/user_share_controller.php');
RC_Hook::add_action('user/user_share/share', array('user_share_controller', 'share'));
RC_Hook::add_action('user/user_share/create_qrcode', array('user_share_controller', 'create_qrcode'));

RC_Loader::load_theme('extras/controller/user_tag_controller.php');
RC_Hook::add_action('user/user_tag/tag_list', array('user_tag_controller', 'tag_list'));
RC_Hook::add_action('user/user_tag/del_tag', array('user_tag_controller', 'del_tag'));



/**
 * step：3
 * 这里开始 注册“方法函数”自动加载列表 到Hook自动加载列表，为自动加载做准备
 */
RC_Hook::add_action('class_touch_function',     function () {RC_Loader::load_theme('extras/classes/utility/touch_function.class.php');});
RC_Hook::add_action('class_article_function',   function () {RC_Loader::load_theme('extras/classes/utility/article_function.class.php');});
RC_Hook::add_action('class_cart_function',      function () {RC_Loader::load_theme('extras/classes/utility/cart_function.class.php');});
RC_Hook::add_action('class_goods_function',     function () {RC_Loader::load_theme('extras/classes/utility/goods_function.class.php');});
RC_Hook::add_action('class_orders_function',    function () {RC_Loader::load_theme('extras/classes/utility/orders_function.class.php');});
RC_Hook::add_action('class_user_function',      function () {RC_Loader::load_theme('extras/classes/utility/user_function.class.php');});

RC_Hook::add_action('class_user_front',      function () {RC_Loader::load_theme('extras/classes/user/user_front.class.php');});

/**
 * step:5
 * 这个方法在前台控制器加载后执行，这个时候环境初始化完毕，这里开始正式进入主题框架的流程
 */
RC_Hook::add_action('ecjia_front_finish_launching', function ($arg) {

    if (ROUTE_M == 'user') {
        new user_front();
    }

    ecjia_front::$controller->assign('theme_url', RC_Theme::get_template_directory_uri() . '/');
});


//第三方登录回调提示模板
RC_Hook::add_filter('connect_callback_template', function($data) {
    RC_Loader::load_theme('extras/controller/connect_controller.php');
    return connect_controller::callback_template($data);
}, 10, 1);
    
//第三方登录用户注册
RC_Hook::add_filter('connect_callback_bind_signup', function($userid, $username, $password, $email) {
    RC_Loader::load_theme('extras/functions/front_user.func.php');
//     $result = register_mbt($username, $password, $email,'',1);

    if (!is_ecjia_error($result)) {
        return $result;
    } else {
        return $userid;
    }
}, 10, 4);
    
//第三方登录用户登录
RC_Hook::add_action('connect_callback_user_signin', function( $userid){
    RC_Loader::load_app_class('integrate','user', false);
    $user = integrate::init_users();
    RC_Loader::load_theme('extras/functions/front_user.func.php');
    $userinfo = $user->get_profile_by_id($userid);
    $user->set_session($userinfo['user_name']);
    $user->set_cookie($userinfo['user_name']);
    
    
    $data = array(
        'profile'		=> serialize($profile)
    );
    RC_Model::model('connect/connect_user_model')->where(array('connect_code' => $connect_user->connect_code, 'open_id' => $connect_user->open_id, 'user_id' => $_SESSION['user_id']))->update($data);
    	
    /* 获取远程用户头像信息*/
    RC_Api::api('connect', 'update_user_avatar', array('avatar_url' => $profile['avatar_img']));
    
    RC_Loader::load_app_func('user', 'user');
    $user_info = EM_user_info($_SESSION['user_id']);
    
    update_user_info(); // 更新用户信息
    RC_Loader::load_app_func('cart','cart');
    recalculate_price(); // 重新计算购物车中的商品价格
    
    //结合cookie判断返回来源url
    if(RC_Cookie::get('referer')) {
        $back_url = RC_Cookie::get('referer');
    } else {
        $back_url = isset($_POST['back_act']) ? trim($_POST['back_act']) : '';
    }
    $back_url = empty($back_url) ? RC_Uri::url('user/index/init') : $back_url;
    ecjia_front::$controller->redirect($back_url);
});
    
//授权登录用户绑定已有账号
RC_Hook::add_filter('connect_callback_signin_template', function($get) {
    RC_Loader::load_theme('extras/controller/connect_controller.php');
    $connect_controller = new connect_controller();
    return $connect_controller->user_bind($get);
}, 10, 1);
    
//授权登录用户绑定已有账号-验证用户名密码
RC_Hook::add_filter('connect_callback_bind_signin', function($uid, $username, $password) {
    RC_Loader::load_app_class('integrate','user', false);
    $user = integrate::init_users();
    RC_Loader::load_theme('extras/functions/front_user.func.php');
    if ($user->login($username, $password)) {
//         update_user_info_mbt();
        return $_SESSION['user_id'];
    } else {
        return false;
    }

}, 10, 3);

//查找用户userid
/* RC_Hook::add_filter('connect_openid_exist_userid', function ($uid, $connect_code, $open_id) {
    $db_user = RC_Loader::load_app_model('users_model','user');
    RC_Loader::load_theme('extras/model/wechat_user_member_model.class.php');
    if ($connect_code == 'sns_wechat') {
        $db_wechat_user = new wechat_user_member_model();
        $rs = $db_wechat_user->field('ect_uid AS user_id')->where("unionid = '".$open_id."'")->find();
    } else {
        if ($connect_code == 'sns_qq') {
            $rs = $db_user->field('user_id')->where("qq_id = '".$open_id."'")->find();
        } elseif ($connect_code == 'sns_weibo') {
            $rs = $db_user->field('user_id')->where("sinna_weibo_id = '".$open_id."'")->find();
        } elseif ($connect_code == 'sns_alipay') {
            $rs = $db_user->field('user_id')->where("alipay_id = '".$open_id."'")->find();
        }
    }

    if ($rs) {
        return $rs['user_id'];
    } else {
        return $uid;
    }
}, 10, 3); */

/* ecjiaopen协议 */
ecjia_open::macro('goods_seller_list', function($querys) {
    return RC_Uri::url('goods/category/store_list', array('cid' => $querys['category_id']));
});

ecjia_open::macro('goods_detail', function($querys) {
	return RC_Uri::url('goods/index/show', array('goods_id' => $querys['goods_id']));
});
	
ecjia_open::macro('seller', function($querys) {
	return RC_Uri::url('goods/category/seller_list', array('cid' => $querys['category_id']));
});

//支付响应提示模板
RC_Hook::add_filter('payment_respond_template', function($respond, $msg){
    return pay_controller::notify($msg);
}, 10, 2);


