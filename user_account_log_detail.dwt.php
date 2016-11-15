<?php 
/*
Name: 资金管理模板
Description: 资金管理页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="con"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div class="ecjia-user-info ecjia_user-info-edit log_detail">
	<div class="user-img"><img src="{$user_img}" /></div>
	<p>{$smarty.session.user_name}</p>
</div>
<ul class="ecjia-list user-account-log">
	<li>
		{if $account.change_type eq 0 }充值：{elseif $account.change_type eq 1 }支出：{elseif $account.user_money > 0 }充值：{else}支出：{/if}
		<span class="log-style ecjiaf-fr">{$account.user_money}</span>
	</li>
	<li>交易类型：<span class="ecjiaf-fr">{if $account.change_type eq 0 }充值{elseif $account.change_type eq 1 }支出{elseif $account.user_money > 0 }充值{else}支出{/if}</span></li>
	<li>申请时间：<span class="ecjiaf-fr">{$time}</span></li>
	<li>当前状态：<span class="log-style ecjiaf-fr">交易成功</span></li>
</ul>
<!-- {/block} -->