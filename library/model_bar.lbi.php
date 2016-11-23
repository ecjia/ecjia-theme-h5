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
			<li><span class="ecjia-bar-img"><a href="{RC_Uri::url('touch/index/init')}"><img src="{$theme_url}images/bar/bar_1{if $active eq 1}_active{/if}.png"></a></span></li>
			<li><span class="ecjia-bar-img"><a href="{RC_Uri::url('goods/category/top_all')}"><img src="{$theme_url}images/bar/bar_2{if $active eq 2}_active{/if}.png"></a></span></li>
			<li><span class="ecjia-bar-img"><a href="{RC_Uri::url('cart/index/init')}"><img src="{$theme_url}images/bar/bar_3{if $active eq 3}_active{/if}.png"></a></span></li>
			<li><span class="ecjia-bar-img"><a href="{RC_Uri::url('user/user_order/order_list')}"><img src="{$theme_url}images/bar/bar_4{if $active eq 4}_active{/if}.png"></a></span></li>
			<li><span class="ecjia-bar-img"><a href="{RC_Uri::url('user/index/init')}"><img src="{$theme_url}images/bar/bar_5{if $active eq 5}_active{/if}.png"></a></span></li>
		</ul>
	</div>
</div>