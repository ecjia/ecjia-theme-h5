<?php
/*
Name: 用户中心模板
Description: 这是用户中心首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript" xmlns="http://www.w3.org/1999/html">ecjia.touch.user.init();</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<!-- TemplateBeginEditable name="标题区域" -->
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->
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
<div class="nav-header">
	<a href="{url path='user/user_order/order_list'}">
		<i class="iconfont icon icon-icon04"></i>
		<span class="icon-name">我的订单</span>
		<span>查看全部订单<i class="iconfont  icon-jiantou-right"></i></span>
	</a>
</div>
<ul class="ecjia-list ecjia-nav-child ecjia-user-order ecjia-list-four">
	<li>
		<a href="{url path='user/user_order/order_list' args='status=unpayed'}">
			<i class="iconfont icon-vipcard"></i>
			<p>待付款</p>
			{if $order_num.unpayed}
			<span class="ecjia-icon ecjia-icon ecjia-icon-num">{$order_num.unpayed}</span>
			{/if}
		</a>
	</li>
	<li>
		<a href="{url path='user/user_order/order_list' args='status=unshipped'}">
			<i class="iconfont icon-deliver"></i>
			<p>待发货</p>
			{if $order_num.unshipped}
			<span class="ecjia-icon ecjia-icon ecjia-icon-num">{$order_num.unshipped}</span>
			{/if}
		</a>
	</li>
	<li>
		<a href="{url path='user/user_order/order_list' args='status=confiroed'}">
			<i class="iconfont icon-form"></i>
			<p>待确认</p>
			{if $order_num.confiroed}
			<span class="ecjia-icon ecjia-icon ecjia-icon-num">{$order_num.confiroed}</span>
			{/if}
		</a>
	</li>
	<li>
		<a href="{url path='user/user_order/order_list' args='status=success_order'}">
			<i class="iconfont icon-success_order"></i>
			<p>已完成</p>
			{if $order_num.success_order}
			<span class="ecjia-icon ecjia-icon ecjia-icon-num">{$order_num.success_order}</span>
			{/if}
		</a>
	</li>
</ul>
<div class="nav-header ecjia-margin-t">
	<a href="{url path='user/user_account/account_detail'}">
		<i class="iconfont icon red icon-qianbao"></i>
		<span class="icon-name">我的钱包</span>
		<span class="ecjiaf-fr"><i class="iconfont  icon-jiantou-right"></i></span>
	</a>
</div>
<ul class="ecjia-list bonus ecjia-nav-child ecjia-list-three">
	<li>
		<a href="{url path='user/user_account/account_detail'}">
			<p>{$surplus_amount}</p>
			<p>账户余额</p>
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
<section class="container-fluid user-nav ecjia-margin-t">
	<ul class="row ecjia-row-nav user">
		<li class="col-sm-3 col-xs-3">
			<a href="{url path='user/user_address/address_list'}">
				<i class="iconfont icon-location"></i>
				<p class="text-center">{$lang.label_address}</p>
			</a>
		</li>
		<li class="col-sm-3 col-xs-3">
			<a href="{url path='user/user_share/share'}">
				<i class="iconfont icon-fenxiang"></i>
				<p class="text-center">我的分享</p>
			</a>
		</li>
		<li class="col-sm-3 col-xs-3">
			<a href="{url path='user_collection/collection_list'}">
				<i class="iconfont icon-shoucang"></i>
				<p class="text-center">{$lang.label_collection}</p>
			</a>
		</li>
		<li class="col-sm-3 col-xs-3">
			<a href="{url path='index/history'}">
				<i class="iconfont icon-attention"></i>
				<p class="text-center">{$lang.view_history}</p>
			</a>
		</li>
		<li class="col-sm-3 col-xs-3">
			<a href="{url path='user/user_comment/comment_list'}">
				<i class="iconfont icon-comment"></i>
				<p class="text-center">我的评论</p>
			</a>
		</li>
		<li class="col-sm-3 col-xs-3">
			<a href="{url path='user/user_tag/tag_list'}">
				<i class="iconfont icon-tag"></i>
				<p class="text-center">我的标签</p>
			</a>
		</li>
		<li class="col-sm-3 col-xs-3">
			<a href="{url path='user/user_booking/booking_list'}">
				<i class="iconfont icon-shortage"></i>
				<p class="text-center">缺货登记</p>
			</a>
		</li>
		<li class="col-sm-3 col-xs-3">
			<a href="{url path='user/user_package/service'}">
				<i class="iconfont icon-kefu"></i>
				<p class="text-center">客户服务</p>
			</a>
		</li>
	</ul>
</section>
<!-- #BeginLibraryItem "/library/showcase_14533892235205.lbi" --><!-- #EndLibraryItem -->
<div class="ecjia-margin-t ecjia-margin-b">
	<a class="btn btn-info btn-loginout nopjax loginout" href="{url path='index/logout'}">{t}退出登录{/t}</a>
</div>
<!-- {/block} -->
