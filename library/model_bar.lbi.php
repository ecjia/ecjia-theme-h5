<?php
/*
Name: 底部导航
Description: 这是底部导航模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>

<div class="ecjia-floor ecjia-bottom-bar-pannel">
	<div class="ecjia-floor-container">
		<ul class="tab5">
			<li><span class="ecjia-bar-img"><a href="javascript:void(0)"><img src="{$theme_url}images/bar_1.png"></a></span></li>
			<li><span class="ecjia-bar-img"><a href="{RC_Uri::url('goods/category/top_all')}"><img src="{$theme_url}images/bar_2.png"></a></span></li>
			<li><span class="ecjia-bar-img"><a href="{RC_Uri::url('cart/index/init')}"><img src="{$theme_url}images/bar_3.png"></a></span></li>
			<li><span class="ecjia-bar-img"><a href="{RC_Uri::url('user/user_order/order_list')}"><img src="{$theme_url}images/bar_4.png"></a></span></li>
			<li><span class="ecjia-bar-img"><a href="{RC_Uri::url('user/index/init')}"><img src="{$theme_url}images/bar_5.png"></a></span></li>
		</ul>
	</div>
</div>