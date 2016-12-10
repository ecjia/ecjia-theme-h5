<?php

class user_function
{
	/**
	 * 记录搜索历史
	 */
	public static function insert_search($keywords, $store_id = 0) {
		$ecjia_search = 'ECJia[search]';
		if (!empty($store_id)) {
			$cookie_search = $_COOKIE ['ECJia'] ['search'][$store_id];
			$ecjia_search .= '['.$store_id.']';
		} else {
			$cookie_search = $_COOKIE ['ECJia'] ['search']['other'];
			$ecjia_search .= '[other]';
		}
		
		if (isset($keywords)) {
			if (!empty($cookie_search)) {
				$history = explode(',', $cookie_search);
				array_unshift($history, $keywords);
				$history = array_unique($history);
				while (count($history) > ecjia::config('history_number')) {
					array_pop($history);
				}
				setcookie($ecjia_search, implode(',', $history), RC_Time::gmtime() + 3600 * 24 * 30);
			} else {
				setcookie($ecjia_search, $keywords, RC_Time::gmtime() + 3600 * 24 * 30);
			}
		}
	}
	
	/**
	 * 调用搜索历史
	 */
	public static function get_search($store_id = 0) {
		$str = '';
		if (!empty($store_id)) {
			return empty($_COOKIE ['ECJia'] ['search'][$store_id]) ? array() : explode(',', $_COOKIE ['ECJia'] ['search'][$store_id]);
		} else {
			return empty($_COOKIE ['ECJia'] ['search']['other']) ? array() : explode(',', $_COOKIE ['ECJia'] ['search']['other']);
		}
	}
	
	/**
	 * 获取用户默认address_id
	 */
	public static function default_address_id($token) {
		//所有地址
		$cache_key = 'address_list_'.$token;
		$address_list = RC_Cache::app_cache_get($cache_key, 'user_address');
		if (!$address_list) {
			$address_list = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_LIST)->data(array('token' => $token))->run();
			RC_Cache::app_cache_set($cache_key, $address_list, 'user_address', 60*24);//24小时缓存
		}
		$address_id = '';
		if (!empty($address_list)) {
			foreach ($address_list as $k => $v) {
				if ($v['default_address'] == 1) {
					$address_id = $v['id'];
				}
			}
		}
		return $address_id;
	}
}