<?php
/*
Name: 资金管理模板
Description: 资金管理页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<div class="ecjia-account ecjia-margin-t">
	<div class="account-bonus ecjiaf-bt">
		<a href="{url path='user/user_account/account_list'}">
			<i class="iconfont icon-qianbao"></i>
			我的余额
			<span class="ecjiaf-fr">{$surplus_amount}<i class="iconfont icon-jiantou-right"></i></span>
		</a>
	</div>
	<div class="account-bonus ecjiaf-bt">
		<a href="{url path='user/user_bonus/bonus'}">
			<i class="iconfont icon-redpacket"></i>
			红包
			<span class="ecjiaf-fr">{$bonus_number}<i class="iconfont icon-jiantou-right"></i></span>
		</a>
	</div>
	<div class="account-bonus integral ecjiaf-bt">
		<i class="iconfont icon-copy"></i>
		积分
		<span class="ecjiaf-fr">{$integral}</span>
	</div>
</div>
<!-- {/block} -->
