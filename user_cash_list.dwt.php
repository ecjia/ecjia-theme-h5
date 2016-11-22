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

<ul class="ecjia-list ecjia-list-three ecjia-nav ecjia-margin-b ecjia-bonus-border-right">
	<li {if $status eq 'notused'} class="active"{/if}><a href="{url path='user/user_bonus/bonus' args='status=notused'}">{t}全部{/t}</a></li>
	<li {if $status eq 'used'} class="active"{/if}><a href="{url path='user/user_bonus/bonus' args='status=used'}">{t}提现{/t}</a></li>
	<li {if $status eq 'overdue'} class="active"{/if}><a href="{url path='user/user_bonus/bonus' args='status=overdue'}">{t}充值{/t}</a></li>
</ul>

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
						<span class="user-photo"><img src="{$theme_url}/images/default_user.png" /></span>
					</div>
					<div class="record-r">
						<div class="record-r-l">
							<p>wu21st-充值</p>
							<p>今天</p>
						</div>
						<div class="record-r-r">
							<p>100.00</p>
							<p>交易进行中</p>
						</div>
					</div>
				</li>
				<li class="record-single">
					<div class="record-l">
						<span class="user-photo"><img src="{$theme_url}/images/default_user.png" /></span>
					</div>
					<div class="record-r">
						<div class="record-r-l">
							<p>wu21st-充值</p>
							<p>今天</p>
						</div>
						<div class="record-r-r">
							<p>100.00</p>
							<p>交易进行中</p>
						</div>
					</div>
				</li>
				<li class="record-single">
					<div class="record-l">
						<span class="user-photo"><img src="{$theme_url}/images/default_user.png" /></span>
					</div>
					<div class="record-r">
						<div class="record-r-l">
							<p>wu21st-充值</p>
							<p>今天</p>
						</div>
						<div class="record-r-r">
							<p>100.00</p>
							<p>交易进行中</p>
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