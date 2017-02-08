<?php
// b2b2c路由重定向方法

// 所在地区列表
RC_Loader::load_theme('extras/b2b2c/controller/b2b2c_touch_controller.php');

RC_Hook::remove_action	('touch/index/init', 		array('touch_controller', 'init'));
RC_Hook::add_action		('touch/index/init', 		array('b2b2c_touch_controller', 'init'));
RC_Hook::add_action		('touch/index/region_list', array('b2b2c_touch_controller', 'region_list'));
RC_Hook::add_action		('touch/index/set_area', 	array('b2b2c_touch_controller', 'set_area'));

// 商品 
RC_Loader::load_theme('extras/b2b2c/controller/b2b2c_goods_controller.php');

RC_Hook::remove_action	('goods/category/goods_list', 	array('goods_controller', 'goods_list'));
RC_Hook::remove_action	('goods/index/init', 			array('goods_controller', 'goods_index'));
RC_Hook::add_action		('goods/category/goods_list', 	array('b2b2c_goods_controller', 'goods_list'));
RC_Hook::add_action		('goods/index/init', 			array('b2b2c_goods_controller', 'goods_index'));
RC_Hook::add_action		('goods/index/region', 			array('b2b2c_goods_controller', 'region'));
RC_Hook::add_action		('goods/index/get_goods', 		array('b2b2c_goods_controller', 'goods_modal'));

// 购物车
RC_Loader::load_theme('extras/b2b2c/controller/b2b2c_cart_controller.php');

RC_Hook::remove_action	('cart/index/init', array('cart_controller', 'init'));
RC_Hook::remove_action	('cart/index/add_to_cart', array('cart_controller', 'add_to_cart'));
RC_Hook::remove_action	('cart/flow/done', 	array('cart_controller', 'done'));
RC_Hook::add_action		('cart/index/init', array('b2b2c_cart_controller', 'init'));
RC_Hook::add_action		('cart/flow/done', 	array('b2b2c_cart_controller', 'done'));
RC_Hook::add_action		('cart/index/add_to_cart', 	array('b2b2c_cart_controller', 'add_to_cart'));

// 商户
RC_Loader::load_theme('extras/b2b2c/controller/b2b2c_merchant_controller.php');

RC_Hook::add_action('touch/index/merchant_list', 		array('b2b2c_merchant_controller', 'init'));
RC_Hook::add_action('touch/index/ansy_merchant_list', 	array('b2b2c_merchant_controller', 'ansy_merchant_list'));
RC_Hook::add_action('touch/index/merchant_shop', 		array('b2b2c_merchant_controller', 'merchant_init'));
RC_Hook::add_action('touch/index/merchant_ajax_goods', 	array('b2b2c_merchant_controller', 'ajax_goods'));
RC_Hook::add_action('touch/index/add_attention', 		array('b2b2c_merchant_controller', 'add_attention'));
RC_Hook::add_action('touch/index/shop_init', 			array('b2b2c_merchant_controller', 'shop_init'));

// 订单
RC_Loader::load_theme('extras/b2b2c/controller/b2b2c_user_order_controller.php');

RC_Hook::remove_action	('user/order/order_list', array('user_order_controller', 'order_list'));
RC_Hook::remove_action	('user/order/order_detail', array('user_order_controller', 'order_detail'));
RC_Hook::add_action		('user/order/order_detail', array('b2b2c_user_order_controller', 'order_detail'));
RC_Hook::add_action		('user/order/order_list', array('b2b2c_user_order_controller', 'order_list'));

// 红包
RC_Loader::load_theme('extras/b2b2c/controller/b2b2c_user_bonus_controller.php');

RC_Hook::remove_action	('user/bonus/init', 				array('user_bonus_controller', 'bonus'));
RC_Hook::remove_action	('user/bonus/async_bonus_list', 	array('user_bonus_controller', 'async_bonus_list'));
RC_Hook::add_action		('user/bonus/init', 				array('b2b2c_user_bonus_controller', 'bonus'));
RC_Hook::add_action		('user/bonus/async_bonus_list', 	array('b2b2c_user_bonus_controller', 'async_bonus_list'));

// 关注店铺
RC_Loader::load_theme('extras/b2b2c/controller/b2b2c_user_collection_controller.php');

RC_Hook::add_action		('user/user_collection/shop_collection', array('b2b2c_user_collection_controller', 'shop_collection'));

// 商家入驻
RC_Loader::load_theme('extras/b2b2c/controller/b2b2c_user_merchant_controller.php');

RC_Hook::add_action('user/user_merchant/step_list', array('b2b2c_user_merchant_controller', 'step_list'));
RC_Hook::add_action('user/user_merchant/init', array('b2b2c_user_merchant_controller', 'init'));
RC_Hook::add_action('user/user_merchant/update', array('b2b2c_user_merchant_controller', 'update'));
RC_Hook::add_action('user/user_merchant/get_cat_name', array('b2b2c_user_merchant_controller', 'get_cat_name'));
RC_Hook::add_action('user/user_merchant/addChildCate_checked', array('b2b2c_user_merchant_controller', 'addChildCate_checked'));
RC_Hook::add_action('user/user_merchant/deleteChildCate_checked', array('b2b2c_user_merchant_controller', 'deleteChildCate_checked'));
RC_Hook::add_action('user/user_merchant/deleteBrand', array('b2b2c_user_merchant_controller', 'deleteBrand'));
