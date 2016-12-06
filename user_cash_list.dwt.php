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
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div class="ecjia-account-list-f">
    <div class="ecjia-account-list">
        <ul class="ecjia-list ecjia-list-three ecjia-nav ecjia-account ecjia-bonus-border-right">
        	<li><a {if $smarty.get.status eq ''}class="ecjia-green left-bottom"{else}class="left-bottom"{/if} id="left-bottom" href="{url path='user/user_account/cash_list' args='status='}">{t}全部{/t}</a></li>
        	<li><a {if $smarty.get.status eq 'raply'}class="ecjia-green"{/if} href="{url path='user/user_account/cash_list' args='status=raply'}">{t}提现{/t}</a></li>
        	<li><a {if $smarty.get.status eq 'deposit'}class="ecjia-green right-bottom"{else}class="right-bottom"{/if} id="right-bottom" href="{url path='user/user_account/cash_list' args='status=deposit'}">{t}充值{/t}</a></li>
        </ul>
    </div>
</div>
<div>
	<ul class="ecjia-list ecjia-account-record" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/user_account/ajax_cash_list' args="type={$type}"}" data-size="10">
	</ul>
</div>
<!-- {/block} -->
<!-- {block name="ajaxinfo"} -->
<!--{foreach from=$sur_amount item=item}-->
	<ul class="account-record-list">
		<p class="record-time">本月</p>
		<li class="ecjia-margin-b record-list">
			<ul>
				<li class="record-single">
					<div class="record-l">
						<span class="user-photo"><img src="{$user_img}" alt=""></span>
					</div>
					<div class="record-r">
						<div class="record-r-l">
							<p>{$item.type_lable}</p>
							<p class="record-time">今天</p>
						</div>
						<div class="record-r-r">
							<p>{$item.amount}</p>
							<p>{$item.pay_status}</p>
						</div>
					</div>
				</li>
			</ul>
		</li>
	</ul>
<!-- {foreachelse} -->
	<div class="ecjia-nolist">
		<i class="iconfont icon-more"></i>
		<p>{t}暂无任何记录{/t}</p>
	</div>
<!--{/foreach}-->
<!-- {/block} -->