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

<ul class="ecjia-list ecjia-list-three user_account_list-nav ecjia-nav">
	<li{if $status eq ''} class="active"{/if}><a data-rh="1" href="{url path='user/user_account/account_list'}">{t}全部{/t}</a></li>
	<li{if $status eq 'recharge'} class="active"{/if}><a data-rh="1" href="{url path='user/user_account/account_list' args='status=recharge'}">{t}充值{/t}</a></li>
	<li{if $status eq 'withdraw'} class="active"{/if}><a data-rh="1" href="{url path='user/user_account/account_list' args='status=withdraw'}">{t}支出{/t}</a></li>
</ul>
<ul class="ecjia-list ecjia-account-list">
	<!--{foreach from=$account_log item=item}-->
	<li class="{if $item.amount gt 0} recharge {else} carries {/if}">
		<a href="{url path='user/user_account/detail' args="id={$item.log_id}"}">
			<p class="title">
				{if $item.amount gt 0} 充值:{else} 提现:{/if}
				<span class="">{$item.amount}</span>
				<span class="ecjiaf-fr change_time">{$item.change_time}</span>
			</p>
		</a>
	</li>
	<!--{foreachelse}-->
	<div class="ecjia-nolist">
		<i class="glyphicon glyphicon-piggy-bank"></i>
		<p>{t}暂无账单记录{/t}</p>
	</div>
	<!--{/foreach}-->
</ul>
<!-- {/block} -->
