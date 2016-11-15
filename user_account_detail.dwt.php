<?php
/*
Name: 资金管理模板
Description: 资金管理页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="ecjia"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<div class="user-account-detail">
	<div class="hd">
		<div class="banner ecjia-margin-b">
			<p>{t}账户总额{/t}</p>
			<span class="price">￥{$surplus_amount}</span>
			<p><a href="{url path='user/user_account/account_list'}"><i class="iconfont icon-calendar"></i>查看明细</a></p>
		</div>
		<div class="nav nav-list-two">
			<a class="ecjiaf-fl" href="{url path='user/user_account/recharge'}"><i class="iconfont icon-recharge"></i>{t}充值{/t}</a>
			<a class="ecjiaf-fl" href="{url path='user/user_account/withdraw'}"><i class="iconfont icon-recharge"></i>{t}提现{/t}</a>
		</div>
	</div>
	<div class="ecjia-margin-t account-bonus">
		<a href="{url path='user/user_bonus/bonus'}">
			<i class="iconfont icon-redpacket"></i>
			红包
			<span class="ecjiaf-fr">{$bonus_number}个<i class="iconfont icon-jiantou-right"></i></span>
		</a>
	</div>
	<div class="ecjia-margin-t account-bonus integral">
		<i class="iconfont icon-copy"></i>
		积分
		<span class="ecjiaf-fr">{$integral}分</span>
	</div>
</div>
<!-- {/block} -->
