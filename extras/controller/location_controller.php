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
        
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('select_location.dwt');
    }
   
    public static function near_address() {
    	$region   = $_GET['region'];
    	$keywords = $_GET['keywords'];
    	$key       = "HVNBZ-HHR3P-HVBDP-LID55-D2YM3-2AF2W";
    	$url       = "http://apis.map.qq.com/ws/place/v1/suggestion/?region=".$region."&keyword=".$keywords."&key=".$key;
    	$response = RC_Http::remote_get($url);
    	$content  = json_decode($response['body']);
    	ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('content' => $content));
    
    }
}

// end
