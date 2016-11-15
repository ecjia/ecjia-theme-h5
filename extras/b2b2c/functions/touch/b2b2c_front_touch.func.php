<?php
defined('IN_ECJIA') or exit('No permission resources.');

	/*
	 * IP地区名称
	 */
	function get_ip_area_name($ip = '180.175.180.236'){
	    $url = "http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
	    $data = file_get_contents($url); //调用淘宝接口获取信息
	    $str = json_decode($data,true);

	    if ($str['code'] === 1) {
	        return 'IPv4地址不符合格式';
	    }else {
	        $area_name = str_replace(array('省', '市'), '', $str['data']['region']);

	        if(strstr($area_name, '香港')){
	            $area_name = "香港";
	        }elseif(strstr($area_name, '澳门')){
	            $area_name = "澳门";
	        }elseif(strstr($area_name, '内蒙古')){
	            $area_name = "内蒙古";
	        }elseif(strstr($area_name, '宁夏')){
	            $area_name = "宁夏";
	        }elseif(strstr($area_name, '新疆')){
	            $area_name = "新疆";
	        }elseif(strstr($area_name, '西藏')){
	            $area_name = "西藏";
	        }elseif(strstr($area_name, '广西')){
	            $area_name = "广西";
	        }
	        return $area_name;
	    }
	}


	/**
	 * 获取客户端IP地址
	 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
	 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
	 * @return mixed
	 */
	function get_client_ip($type = 0, $adv = false) {
	    $type = $type ? 1 : 0;
	    static $ip = NULL;
	    if ($ip !== NULL)
	        return $ip[$type];
	    if ($adv) {
	        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
	            $pos = array_search('unknown', $arr);
	            if (false !== $pos)
	                unset($arr[$pos]);
	            $ip = trim($arr[0]);
	        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
	            $ip = $_SERVER['HTTP_CLIENT_IP'];
	        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
	            $ip = $_SERVER['REMOTE_ADDR'];
	        }
	    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
	        $ip = $_SERVER['REMOTE_ADDR'];
	    }
	    // IP地址合法验证
	    $long = sprintf("%u", ip2long($ip));
	    $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
	    return $ip[$type];
	}


	/**
	 * 获取地区的ID
	 */
	function get_area_id($area, $type){
	    RC_Loader::load_theme('extras/b2b2c/model/touch/touch_region_model.class.php');
	    $region = new touch_region_model();
	    $area = $region->field('region_name, region_id, parent_id, region_type')->where(array('region_name' => $area))->select();
        if (!empty($area)) {
    	    foreach ($area as $val){
    	        $name          = $val['region_name'];
    	        $id            = $val['region_id'];
    	        $parent        = $val['parent_id'];
    	        $region_type   = $val['region_type'];
    	    }
    	    if($type ==1){
    	        return array('name' => $name, 'id' => $id);
    	    }else{
    	        $rs = $region->field('region_name, region_id, parent_id, region_type')->where(array('parent_id' => $id))->find();
    	        return array('name' => $rs['region_name'], 'id' => $rs['region_id']);
    	    }
        }
        return array('name' => '', 'id' => '');
	}

	/**
	 * 获取地区的ID
	 */
	function get_area($region_id){
	    RC_Loader::load_theme('extras/b2b2c/model/touch/touch_region_model.class.php');
	    $region = new touch_region_model();
	    $area = $region->field('region_name, region_id')->where(array('region_id' => $region_id))->select();
	    foreach ($area as $val){
	        $name          = $val['region_name'];
	        $id            = $val['region_id'];
	    }
	    return array('name' => $name, 'id' => $id);

	}

// end
