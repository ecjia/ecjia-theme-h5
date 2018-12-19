<?php
/*
Name: 资金管理模板
Description: 资金管理页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {nocache} -->
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user_account.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->


<ul class="ecjia-list ecjia-account">
	<a href="{url path='user/account/record'}">
		<p class="cash_list">交易记录</p>
	</a>
	<div class="ecjia-nolist ecjia-margin-t5">
		<i class="glyphicon glyphicon-piggy-bank"></i>
		{if $user}
		<span class="nolist-size">可用余额：<span>{$user.formated_user_money}</span></span>
		{else}
		<p>{t}暂无账单记录{/t}</p>
		{/if}
	</div>
	<div class="two-btn">
		<a href="{url path='user/account/recharge'}" class="btn nopjax external">{t}充值{/t}</a>
		{if $user.wechat_is_bind eq 1}
		<a href="{url path='user/account/withdraw'}" class="btn ecjia-btn-e5 fnUrlReplace">{t}提现{/t}</a>
		{else}
		<a href="javascript:;" class="btn ecjia-btn-e5 withdraw-btn" data-url="{RC_Uri::url('user/profile/account_bind')}&type=wechat">{t}提现{/t}</a>
		{/if}
	</div>
</ul>

<!-- {/block} -->
<!-- {/nocache} -->