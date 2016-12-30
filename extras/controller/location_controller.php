<?php
/**
 * 定位模块控制器代码
 */
class location_controller {
	//首页定位触发进入页面
	//1、获取当前位置2、搜索位置  最终返回首页顶部定位更换信息
    public static function select_location() {
    	ecjia_front::$controller->assign('hideinfo', '1');
    	ecjia_front::$controller->assign('title', '上海');
        ecjia_front::$controller->assign_title('定位');
        
        if (ecjia_touch_user::singleton()->isSignin()) {
        	ecjia_front::$controller->assign('login', 1);
        }
        $address_list = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_LIST)->data(array('token' => ecjia_touch_user::singleton()->getToken()))->run();
        ecjia_front::$controller->assign('address_list', $address_list);
        
        $referer_url = !empty($_GET['referer_url']) ? $_GET['referer_url'] : '';
        if (!empty($referer_url)) {
        	ecjia_front::$controller->assign('referer_url', urlencode($referer_url));
        }
        
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('select_location.dwt');
    }
    
    //根据关键词搜索周边位置定位
    public static function search_location() {
    	ecjia_front::$controller->assign('hideinfo', '1');
    	ecjia_front::$controller->assign('title', '上海');
    	ecjia_front::$controller->assign_title('定位');
    
    	ecjia_front::$controller->assign_lang();
    	ecjia_front::$controller->display('search_location.dwt');
    }
    
    //请求接口返回数据
    public static function search_list() {
    	$region   = $_GET['region'];
    	$keywords = $_GET['keywords'];
    	$key       = "HVNBZ-HHR3P-HVBDP-LID55-D2YM3-2AF2W";
    	$url       = "https://apis.map.qq.com/ws/place/v1/suggestion/?region=".$region."&keyword=".$keywords."&key=".$key;
    	$response = RC_Http::remote_get($url);
    	$content  = json_decode($response['body']);
    	return ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('content' => $content));
    }
    
    //选择城市
    public static function select_city() {
        $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_CONFIG)
        ->send()->getBody();
        $rs = json_decode($rs,true);
        if (! $rs['status']['succeed']) {
            return ecjia_front::$controller->showmessage($rs['status']['error_desc'], ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_ALERT,array('pjaxurl' => ''));
        }
        ecjia_front::$controller->assign('citylist', $rs['data']['recommend_city']);
        
        $referer_url = !empty($_GET['referer_url']) ? $_GET['referer_url'] : '';
        if (!empty($referer_url)) {
        	ecjia_front::$controller->assign('referer_url', urlencode($referer_url));
        }
        
    	ecjia_front::$controller->assign('hideinfo', '1');
    	ecjia_front::$controller->assign_title('选择城市');
    	ecjia_front::$controller->assign_lang();
    	ecjia_front::$controller->display('select_location_city.dwt');
    }
    

    //请求接口返回数据
    public static function get_location_msg() {
    	$old_locations = $_GET['lat'].','.$_GET['lng'];
    	$href_url = $_GET['href_url'];
    	$key = "HVNBZ-HHR3P-HVBDP-LID55-D2YM3-2AF2W";
    	$change_location = "https://apis.map.qq.com/ws/coord/v1/translate?locations=".$old_locations."&type=1"."&key=".$key;
    	$response_location  = RC_Http::remote_get($change_location);
    	$content = json_decode($response_location['body'],true);
//     	$tencent_locations = '31.229259,121.40934';
    	$tencent_locations =$content['locations'][0]['lat'].','.$content['locations'][0]['lng'];
    	$url       = "https://apis.map.qq.com/ws/geocoder/v1/?location=".$tencent_locations."&key=".$key."&get_poi=1";
    	$response_address= RC_Http::remote_get($url);
    	$content   = json_decode($response_address['body'],true);
    	$location_content = $content['result']['pois'][0];
    	$location_name    = $location_content['title'];
    	$location_address = $location_content['address'];
    	$latng = $location_content['location'];
    	$longitude = $latng['lng'];
    	$latitude  = $latng['lat'];

    	//写入cookie
    	setcookie("location_address", $location_address);
    	setcookie("location_name", $location_name);
    	setcookie("longitude", $longitude);
    	setcookie("latitude", $latitude);
    	setcookie("location_address_id", 0);
    	
    	$url = RC_Uri::url('touch/index/init');
    	return ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('url' => $url));
    } 
    
    public static function get_location_info() {
    	$location_msg = array();
    	
    	$location_msg['location_address_id']= $_COOKIE['location_address_id'];
    	$location_msg['location_address']   = $_COOKIE['location_address'];
    	$location_msg['location_name'] 		= $_COOKIE['location_name'];
    	$location_msg['longitude'] 			= $_COOKIE['longitude'];
    	$location_msg['latitude'] 			= $_COOKIE['latitude'];
    	
    	return $location_msg;
    } 
}

// end
