<?php 
/*
Name: 红包模板
Description: 红包页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
var bonus_sn_error = '{$lang.bonus_sn_error}';
var bonus_sn_empty = '{$lang.bonus_sn_empty}';
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-account-list-f">
    <div class="ecjia-account-list">
        <ul class="ecjia-list ecjia-list-three ecjia-nav ecjia-account ecjia-bonus-border-right1">
        	<li><a {if $smarty.get.status eq ''}class="ecjia-green left-bottom ecjia-green-rf"{else}class="left-bottom ecjia-green-rf"{/if} id="left-bottom" href="{url path='user/user_account/record' args='status='}">{t}全部{/t}</a></li>
        	<li><a {if $smarty.get.status eq 'raply'}class="ecjia-green ecjia-green-rf"{else}class="ecjia-green-rf"{/if} href="{url path='user/user_account/record' args='status=raply'}">{t}提现{/t}</a></li>
        	<li><a {if $smarty.get.status eq 'deposit'}class="ecjia-green right-bottom ecjia-green-rf"{else}class="right-bottom ecjia-green-rf"{/if} id="right-bottom" href="{url path='user/user_account/record' args='status=deposit'}">{t}充值{/t}</a></li>
        </ul>
    </div>
</div>
<div>
	<ul class="ecjia-list ecjia-account-record" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/user_account/ajax_record' args="type={$type}"}" data-size="10">
	</ul>
</div>
<!-- {/block} -->
<!-- {block name="ajaxinfo"} -->
<!--{foreach from=$sur_amount key=key item=group}-->
	<ul class="account-record-list">
		<p class="record-time">{if $key eq $now_mon}{'本月'}{else}{$key}{'月'}{/if}</p>
		<li class="ecjia-margin-b record-list">
			<ul>
			{foreach from=$group item=item}
				<li class="record-single">
				<a href="{RC_Uri::url('user/user_account/record_info')}&account_id={$item.account_id}">
					<div class="record-l">
						<span class="user-photo"><img src="{$user_img}" alt=""></span>
					</div>
					<div class="record-r">
						<div class="record-r-l">
							<p class="account-record-big">{$item.type_lable}</p>
							<p class="record-time account-record-sm">{$item.add_time}</p>
						</div>
						<div class="record-r-r">
							<p class="account-record-big">{$item.amount}</p>
							<p class="account-record-sm">{$item.pay_status}</p>
						</div>
					</a>
				</form>
				</li>
			{/foreach}
			</ul>
		</li>
	</ul>
<!-- {foreachelse} -->
	<div class="ecjia-nolist">
		<div class="no-record"></div>
		<p>{t}暂无明细记录{/t}</p>
	</div>
<!--{/foreach}-->
<!-- {/block} -->