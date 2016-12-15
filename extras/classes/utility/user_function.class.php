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
				return setcookie($ecjia_search, implode(',', $history), RC_Time::gmtime() + 3600 * 24 * 30);
			} else {
				return setcookie($ecjia_search, $keywords, RC_Time::gmtime() + 3600 * 24 * 30);
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
	 * 获取单条地址信息
	 */
	public static function address_info($token, $address_id) {
		$address_info = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_INFO)->data(array('token' => $token, 'address_id' => $address_id))->run();

		return $address_info;
	}
}