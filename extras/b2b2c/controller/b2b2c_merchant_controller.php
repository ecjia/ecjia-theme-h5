<?php

class b2b2c_merchant_controller {
	/**
	 * 商户列表
	 */
	public static function init() {
        RC_Loader::load_theme('extras/b2b2c/functions/merchant/b2b2c_front_merchant.func.php');
		$size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
		$page = intval($_GET['page']) ? intval($_GET['page']) : 1;
		$merchant = get_merchant('',$size, $page);
		ecjia_front::$controller->assign('merchant', $merchant['list']);
		ecjia_front::$controller->assign_title('店铺街');
		ecjia_front::$controller->assign('title', '店铺街');
        ecjia_front::$controller->assign('header_left', array('href' => RC_Uri::url('touch/index/init')));
		ecjia_front::$controller->display('merchant.dwt');
	}

	/**
	 * 商户列表
	 */
	public static function ansy_merchant_list() {
		RC_Loader::load_theme('extras/b2b2c/functions/merchant/b2b2c_front_merchant.func.php');
		$size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
		$page = intval($_GET['page']) ? intval($_GET['page']) : 1;
		$merchant = get_merchant('',$size, $page);
		ecjia_front::$controller->assign('merchant', $merchant['list']);
		ecjia_front::$controller->assign_lang();
		$sayList = ecjia_front::$controller->fetch('merchant.dwt');
		ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page' , 'is_last' => $merchant['is_last']));
	}
	/**
	* 商户首页信息
	*/
	public static function merchant_init() {
        RC_Loader::load_theme('extras/b2b2c/functions/merchant/b2b2c_front_merchant.func.php');
		$size   = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
		$page   = intval($_GET['page']) ? intval($_GET['page']) : 1;
		$ru_id  = intval($_REQUEST['ru_id']);
        $view   = intval($_REQUEST['view']);
        $sort   = htmlspecialchars($_REQUEST['sort']);
        $order  = htmlspecialchars($_REQUEST['order']);

		$merchant_goods = get_user_goods($ru_id, $size, $page, $sort, $order );
        $shop_message = get_shop_msg($ru_id);
		ecjia_front::$controller->assign('goods_list',	    $merchant_goods['list']);
		ecjia_front::$controller->assign('ru_id',	        $ru_id);
		ecjia_front::$controller->assign('id',	            $ru_id);
		ecjia_front::$controller->assign('view',	        $view);
		ecjia_front::$controller->assign('sort',	        $sort);
        ecjia_front::$controller->assign('order',	        $order);
        ecjia_front::$controller->assign('shop_message',	$shop_message);
        ecjia_front::$controller->assign('title',           $shop_message['seller_name']);


        ecjia_front::$controller->assign('header_left', array('href' => RC_Uri::url('touch/index/merchant_list')));
        ecjia_front::$controller->assign_title($shop_message['seller_name']);
		ecjia_front::$controller->display('merchant_index.dwt');
	}

    /*
     * 店铺详情
     */

    public static function shop_init(){
        RC_Loader::load_theme('extras/b2b2c/functions/merchant/b2b2c_front_merchant.func.php');

        $id = intval($_GET['id']);
        $shop_msg = get_shop_msg($id);
        $shop_info = get_shop_info($id);

        ecjia_front::$controller->assign('shop', $shop_msg);
        ecjia_front::$controller->assign('id', $id);
        ecjia_front::$controller->assign('shop_info', $shop_info);
        ecjia_front::$controller->assign('header_left', array('href' =>RC_Uri::url('touch/index/merchant_shop&ru_id='.$id)));
        ecjia_front::$controller->assign('title', $shop_msg['seller_name']);
        ecjia_front::$controller->display('shop_index.dwt');
    }

	/**
	 *增加关注
	 * 
	 */
	public static function add_attention() {
		RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_collect_store_model.class.php');
		$db = new merchant_collect_store_model();
		$ru_id = intval($_GET['ru_id']);
		if(empty($_SESSION['user_id'])){
			ecjia_front::$controller->showmessage('请登录后在关注店铺', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('user/index/login')));
		}
        $url = $_GET['pjaxurl'];
        $url = empty($url) ? RC_Uri::url('user/user_collection/shop_collection') : $url;
		$is_attention = intval($_GET['is_attention']);
		if(empty($is_attention)){
			$data = array(
				'user_id'	=> $_SESSION['user_id'],
				'ru_id'		=> $ru_id,
				'add_time'	=> RC_Time::gmtime(),
				'is_attention' => 1,
			);
			$res = $db->insert($data);
			if($res){
				ecjia_front::$controller->showmessage('已关注', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => $url));
			}
		}else{
			$db->where(array('user_id' => $_SESSION['user_id'], 'ru_id' => $ru_id))->delete();
			ecjia_front::$controller->showmessage('已取消关注', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => $url));
		}
		
	}

	/**
	 * 异步加载商品列表
	 */
	public static function ajax_goods() {
        RC_Loader::load_theme('extras/b2b2c/functions/merchant/b2b2c_front_merchant.func.php');
		$user_id = $_REQUEST['ru_id'];
		$size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
		$page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $sort = htmlspecialchars($_GET['sort']);
        $order = htmlspecialchars($_GET['order']);
		$merchant_goods = get_user_goods($user_id, $size, $page, $sort, $order);
		ecjia_front::$controller->assign('goods_list',	$merchant_goods['list']);
		$sayList = ecjia_front::$controller->fetch('merchant_index.dwt');
		ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page' , 'is_last' => $merchant_goods['is_last']));
	}
   
}

// end