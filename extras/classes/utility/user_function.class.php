<?php

class user_function
{
	/**
	 * 记录搜索历史
	 */
	public static function insert_search($keywords) {
		if (!empty($keywords)) {
			if (!empty($_COOKIE ['ECJia'] ['search'])) {
				$history = explode(',', $_COOKIE ['ECJia'] ['search']);
				array_unshift($history, $keywords);
				$history = array_unique($history);
				while (count($history) > ecjia::config('history_number')) {
					array_pop($history);
				}
				setcookie('ECJia[search]', implode(',', $history), RC_Time::gmtime() + 3600 * 24 * 30);
			} else {
				setcookie('ECJia[search]', $keywords, RC_Time::gmtime() + 3600 * 24 * 30);
			}
		}
	}
	
	/**
	 * 调用搜索历史
	 */
	public static function get_search() {
		$str = '';
		return empty($_COOKIE ['ECJia'] ['search']) ? array() : explode(',', $_COOKIE ['ECJia'] ['search']);
	}
}