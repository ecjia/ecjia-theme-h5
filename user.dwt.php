<?php
/*
Name: 用户中心模板
Description: 这是用户中心首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript" xmlns="http://www.w3.org/1999/html">ecjia.touch.user.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- TemplateBeginEditable name="标题区域" -->
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->
<!-- TemplateEndEditable -->

<!-- #BeginLibraryItem "/library/model_bar.lbi" --><!-- #EndLibraryItem -->
<!-- TemplateEndEditable -->
<div class="ecjia-user-info user-new-info">
	<div class="user-img ecjiaf-fl"><a href="{url path='user/user_profile/edit_profile'}"><img src="{$user_img}" alt=""></a></div>
	<div class="ecjiaf-fl ecjia-margin-l user-rank-name">
		<span>{$info.username}</span>
		<span>{$rank_name}</span>
	</div>
	<a href="{url path='user/user_message/msg_list'}">
		<i class="iconfont icon-pinglun"></i>
		{if $order_num.msg_num}
		<span class="ecjia-icon ecjia-icon ecjia-icon-num">{$order_num.msg_num}</span>
		{/if}
	</a>
</div>

<div class="ecjia-login-nav-header">
	<a href="{url path='user/user_account/account_detail'}">
		<i class="iconfont icon red icon-qianbao"></i>
		<span class="icon-name">{t}我的钱包{/t}</span>
		<span class="ecjiaf-fr"><i class="iconfont  icon-jiantou-right"></i></span>
	</a>
</div>
<ul class="ecjia-list bonus ecjia-nav-child ecjia-list-three">
	<li>
		<a href="{url path='user/user_account/account_detail'}">
			<p>{$surplus_amount}</p>
			<p>余额</p>
		</a>
	</li>
	<li>
		<a href="{url path='user/user_bonus/bonus'}">
			<p>{$order_num.bonus}</p>
			<p>红包</p>
		</a>
	</li>
	<li>
		<a href="{url path='user/user_bonus/bonus'}">
			<p>{$integral}</p>
			<p>积分</p>
		</a>
	</li>
</ul>

<div class="ecjia-login-nav-header ecjia-margin-t ecjia-margin-b">
	<a href="{url path='user/user_address/address_list'}">
		<i class="iconfont icon icon-location"></i>
		<span class="icon-name">地址管理</span>
		<span class="ecjiaf-fr"><i class="iconfont  icon-jiantou-right"></i>
	</a>
</div>

<div class="ecjia-login-nav-header ecjia-margin-t ecjiaf-bt">
	<a href="{url path='user/user_order/order_list'}">
		<i class="iconfont icon icon-homefill"></i>
		<span class="icon-name">掌柜管理</span>
		<span class="ecjiaf-fr"><i class="iconfont  icon-jiantou-right"></i>
	</a>
</div>
<div class="ecjia-login-nav-header">
	<a href="{url path='user/user_address/address_list'}">
		<i class="iconfont icon icon-searchlist"></i>
		<span class="icon-name">店铺入驻查询</span>
		<span class="ecjiaf-fr"><i class="iconfont  icon-jiantou-right"></i>
	</a>
</div>
<div class="ecjia-login-nav-header ecjia-margin-t ecjiaf-bt">
	<a href="{url path='user/user_package/service'}">
		<i class="iconfont icon icon-kefu"></i>
		<span class="icon-name">官网客服</span>
		<span class="ecjiaf-fr"><i class="iconfont  icon-jiantou-right"></i>
	</a>
</div>
<div class="ecjia-login-nav-header">
	<a href="{url path='user/user_address/address_list'}">
		<i class="iconfont icon icon-eclogo"></i>
		<span class="icon-name">官网网站</span>
		<span class="ecjiaf-fr"><i class="iconfont  icon-jiantou-right"></i>
	</a>
</div>
<div class="ecjia-login-nav-header ecjia-margin-t ecjiaf-bt">
	<a href="{url path='user/user_order/order_list'}">
		<i class="iconfont icon icon-kefu"></i>
		<span class="icon-name">帮助中心</span>
		<span class="ecjiaf-fr"><i class="iconfont  icon-jiantou-right"></i>
	</a>
</div>
<div class="ecjia-login-nav-header">
	<a href="{url path='user/user_address/address_list'}">
		<i class="iconfont icon icon-eclogo"></i>
		<span class="icon-name">公司介绍</span>
		<span class="ecjiaf-fr"><i class="iconfont  icon-jiantou-right"></i>
	</a>
</div>












<div class="ecjia-list">
	<a href="{url path='user/user_address/address_list'}">
		<i class="iconfont icon icon-searchlist"></i>
		<span class="icon-name">店铺入驻查询</span>
		<span class="ecjiaf-fr"><i class="iconfont  icon-jiantou-right"></i>
	</a>
</div>
<div class="ecjia-login-nav-header ecjia-margin-t ecjiaf-bt">
	<a href="{url path='user/user_package/service'}">
		<i class="iconfont icon icon-kefu"></i>
		<span class="icon-name">官网客服</span>
		<span class="ecjiaf-fr"><i class="iconfont  icon-jiantou-right"></i>
	</a>
</div>
<div class="ecjia-login-nav-header">
	<a href="{url path='user/user_address/address_list'}">
		<i class="iconfont icon icon-eclogo"></i>
		<span class="icon-name">官网网站</span>
		<span class="ecjiaf-fr"><i class="iconfont  icon-jiantou-right"></i>
	</a>
</div>
<div class="ecjia-margin-t">
123
</div>
<ul class="ecjia-list list-short" style="margin-bottom:100px;">
	<li>
		<i class="iconfont icon-eclogo"></i>
		<span>我的订单</span>
		<i class="iconfont icon-jiantou-right"></i>
	</li>
	<li>
		<i class="iconfont icon-eclogo"></i>
		<span>我的订单</span>
		<i class="iconfont icon-jiantou-right"></i>
	</li>
	<li>
		<i class="iconfont icon-eclogo"></i>
		<span>我的订单</span>
		<i class="iconfont icon-jiantou-right"></i>
	</li>
</ul>








<!-- {/block} -->
