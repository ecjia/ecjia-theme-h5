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
 * 入驻申请页面
 */
class franchisee_controller {

	public static function add() {
		ecjia_front::$controller->assign('form_action', RC_Uri::url('franchisee/index/insert'));
		ecjia_front::$controller->assign_lang();
		ecjia_front::$controller->assign_title('店铺入驻');
		ecjia_front::$controller->display('franchisee_add.dwt');
	}

	public static function insert() {
		if(empty($_POST['f_name'])) {
			return ecjia_front::$controller->showmessage('请输入真实姓名', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		}else if (empty($_POST['f_email'])) {
			return ecjia_front::$controller->showmessage('请输入电子邮箱', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		}else if (empty($_POST['f_mobile'])) {
			return ecjia_front::$controller->showmessage('请输入手机号码', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		}else if (empty($_POST['f_code'])) {
			return ecjia_front::$controller->showmessage('验证码不能为空', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
		}else{
		    $_SESSION['f_name'] 	= $_POST['f_name'];
		    $_SESSION['f_email'] 	= $_POST['f_email'];
		    $_SESSION['f_mobile'] 	= $_POST['f_mobile'];
		    $_SESSION['f_code'] 	= $_POST['f_code'];
		    return ecjia_front::$controller->redirect(RC_Uri::url('franchisee/index/store'));
		}
	}

	public static function validate_msg() {
	    $mobile = !empty($_GET['mobile']) ? $_GET['mobile'] : '';
	    if (!empty($mobile)) {
			$params = array(
				'token' => ecjia_touch_user::singleton()->getToken(),
				'type' 	=> 'mobile',
				'value' =>  $mobile
			);
			$rs = ecjia_touch_manager::make()->api(ecjia_touch_api::ADMIN_MERCHANT_VALIDATE)->data($params)->run();
			if (is_ecjia_error($rs)) {
				return ecjia_front::$controller->showmessage($rs->get_error_message(), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => ''));
			} else {
				return ecjia_front::$controller->showmessage("短信已发送到手机".$mobile."，请注意查看", ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
			}
	    }
	}
	
	public static function store_msg() {
	    $token = ecjia_touch_user::singleton()->getToken();
	    $category = ecjia_touch_manager::make()->api(ecjia_touch_api::SELLER_CATEGORY)->data(array('token' => $token))->send()->getBody();

	    $longitude = !empty($_GET['longitude']) ? $_GET['longitude'] : '';
	    $latitude = !empty($_GET['latitude']) ? $_GET['latitude'] : '';
	    if (!empty($longitude) && !empty($latitude)) {
	    	ecjia_front::$controller->assign('longitude', $longitude);
	    	ecjia_front::$controller->assign('latitude', $latitude);
	    }
	    
	    $province = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_REGION)->data(array('token' => $token, 'type' => 1))->send()->getBody();
	    $city_list = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_REGION)->data(array('token' => $token, 'type' => 2))->send()->getBody();
        
	    ecjia_front::$controller->assign('form_action', RC_Uri::url('franchisee/index/finish'));
	    
		ecjia_front::$controller->assign('province', $province);
		ecjia_front::$controller->assign('city', $city_list);
		ecjia_front::$controller->assign('category', $category);
		ecjia_front::$controller->assign_title('店铺入驻');
		ecjia_front::$controller->assign_lang();
		ecjia_front::$controller->display('franchisee_store_msg.dwt');
	}

	public static function finish() {
	    $token = ecjia_touch_user::singleton()->getToken();
	    
	    $responsible_person = !empty($_SESSION['f_name']) ? $_SESSION['f_name'] : '';
	    $email 				= !empty($_SESSION['f_email']) ? $_SESSION['f_email'] : '';
	    $mobile 			= !empty($_SESSION['f_mobile']) ? $_SESSION['f_mobile'] : '';
	    $seller_name 		= !empty($_POST['seller_name']) ? $_POST['seller_name'] : '';
	    $seller_category 	= !empty($_POST['seller_category']) ? $_POST['seller_category'] : '';
	    $validate_type 		= !empty($_POST['validate_type']) == '个人入驻'? '1' : '2';
	    $province 			= !empty($_POST['province_id']) ? $_POST['province_id'] : '';
	    $city 				= !empty($_POST['city_id']) ? $_POST['city_id'] : '';
	    $address 			= !empty($_POST['address']) ? $_POST['address'] : '';
	    $longitude 			= !empty($_POST['longitude']) ? $_POST['longitude'] : '';
	    $latitude 			= !empty($_POST['latitude']) ? $_POST['latitude'] : '';
	    $validate_code 		= !empty($_SESSION['f_code']) ? $_SESSION['f_code'] : '';
	    
	    $parameter = array(
	        'token'              => $token,
	    	
	        'responsible_person' => $responsible_person,
	        'email'              => $email,
	        'mobile'             => $mobile,
	        'seller_name'        => $seller_name,
	        'seller_category'    => $seller_category,
	        'validate_type'      => $validate_type,
	        'province'           => $province,
	        'city'               => $city,
	    	'address'            => $address,
	    		 
	        'location' => array(
	        	'longitude'      => $longitude,
	            'latitude'       => $latitude,
	        ),
	    	'validate_code'  	 => $validate_code,
	  
	    );
	    _dump($parameter,1);
	    
	    $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ADMIN_MERCHANT_SIGNUP)->data($parameter)->run();
	    
    	if (is_ecjia_error($data)) {
			return ecjia_front::$controller->showmessage($data->get_error_message(), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => ''));
		} else {
			return ecjia_front::$controller->showmessage("短信已发送到手机".$mobile."，请注意查看", ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
		}
	    
	}

	public static function search() {
	    ecjia_front::$controller->assign('form_action', RC_Uri::url('franchisee/index/progress'));
	    
	    ecjia_front::$controller->assign_lang();
	    
	    ecjia_front::$controller->assign_title('进度查询');
	    ecjia_front::$controller->display('franchisee_search.dwt');
	}
	
	public static function progress() {
	    if(empty($_POST['f_mobile'])) {
	        return ecjia_front::$controller->showmessage('请输入手机号码', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }
	    
	    if (empty($_POST['f_code'])) {
	        return ecjia_front::$controller->showmessage('验证码不能为空', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }
	    
	    $mobile        = !empty($_POST['f_mobile']) ? $_POST['f_mobile'] : '';
	    $code          = !empty($_POST['f_code']) ? trim($_POST['f_code']) : '';
	    $params = array(
    		'token' 		=> ecjia_touch_user::singleton()->getToken(),
    		'mobile' 		=> $mobile,
    		'validate_code' => $code,	    		 
	    );

	    $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::ADMIN_MERCHANT_PROCESS)->data($params)->run();
	    if (is_ecjia_error($rs)) {
	    	return ecjia_front::$controller->showmessage($rs->get_error_message(), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => ''));
	    } else {
	    	$check_status  = $rs['data']['check_status'];
	   		$info      	   = $rs['data']['merchant_info'];
	    }
	    
	    ecjia_front::$controller->assign('check_status', $check_status);
	    ecjia_front::$controller->assign('info', $info);
	    
		ecjia_front::$controller->assign_lang();
		ecjia_front::$controller->assign_title('申请进度');
		ecjia_front::$controller->display('franchisee_progress.dwt');
		
	}

	public static function get_location() {
		$city = !empty($_GET['city']) ? $_GET['city'] : '';
		$address = !empty($_GET['address']) ? $_GET['address'] : '';
		$shop_address = $city.$address;
		$shop_point = file_get_contents("https://api.map.baidu.com/geocoder/v2/?address='".$shop_address."&output=json&ak=E70324b6f5f4222eb1798c8db58a017b");
		$shop_point = (array)json_decode($shop_point);
		$shop_point['result'] = (array)$shop_point['result'];
		$location = (array)$shop_point['result']['location'];

		$longitude = $location['lng'];
		$latitude = $location['lat'];
		ecjia_front::$controller->assign('longitude', $longitude);
		ecjia_front::$controller->assign('latitude', $latitude);
		
		ecjia_front::$controller->assign_lang();
		ecjia_front::$controller->assign_title('店铺精确位置');
		ecjia_front::$controller->display('franchisee_get_location.dwt');
	}
}

// end