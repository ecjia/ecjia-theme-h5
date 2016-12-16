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
        
        $address_list = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_LIST)->data(array('token' => ecjia_touch_user::singleton()->getToken()))->run();
        ecjia_front::$controller->assign('address_list', $address_list);
        
        $referer_url = !empty($_GET['referer_url']) ? urldecode($_GET['referer_url']) : '';
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
    	$url       = "http://apis.map.qq.com/ws/place/v1/suggestion/?region=".$region."&keyword=".$keywords."&key=".$key;
    	$response = RC_Http::remote_get($url);
    	$content  = json_decode($response['body']);
    	ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('content' => $content));
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
        
    	ecjia_front::$controller->assign('hideinfo', '1');
    	ecjia_front::$controller->assign_title('选择城市');
    	ecjia_front::$controller->assign_lang();
    	ecjia_front::$controller->display('select_location_city.dwt');
    }
    
    
}

// end
