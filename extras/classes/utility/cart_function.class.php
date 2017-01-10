<?php

class cart_function
{
	/**
	 * 判断浏览器是否是微信自带浏览器
	 * @return boolean
	 */
	public static function is_weixin(){
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
			return true;
		}
		return false;
	}
}