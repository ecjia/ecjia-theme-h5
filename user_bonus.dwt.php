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

<ul class="ecjia-list ecjia-list-three ecjia-bonus ecjia-nav ecjia-margin-b ecjia-bonus-border-right">
	<li {if $smarty.get.status eq 'allow_use'} class="green-bottom"{else}class=""{/if}><a {if $status eq 'allow_use'} class="active three-btn"{/if} href="{url path='user/user_bonus/bonus' args='status=allow_use'}">{t}可使用{/t}</a></li>
	<li {if $smarty.get.status eq 'expired'} class="green-bottom"{else}class=""{/if}><a {if $status eq 'expired'} class="active three-btn"{/if} href="{url path='user/user_bonus/bonus' args='status=expired'}">{t}已使用{/t}</a></li>
	<li {if $smarty.get.status eq 'is_used'} class="green-bottom"{else}class=""{/if}><a {if $status eq 'is_used'} class="active three-btn"{/if} href="{url path='user/user_bonus/bonus' args='status=is_used'}">{t}已过期{/t}</a></li>
</ul>
<div>
	<ul class="ecjia-list ecjia-bonus ecjia-list-two" id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='async_bonus_list' args="status={$status}"}" data-size="10">
	</ul>
</div>
<!-- {/block} -->
<!-- {block name="ajaxinfo"} -->
	<!--{foreach from=$bonus item=item}-->
		<li class="ecjia-margin-b list-l-size">
			<div class="user-bonus-info {if $item.label_status eq '未使用'}user-bonus-head{else}user-bonus-head-expired{/if}">
				<div class="type-l {if $item.label_status eq '未使用'}no-type-money{else}type-money{/if}">{$item.formatted_bonus_amount}</div>
				<div class="type-r">
					<p class="type-name">{$item.bonus_name}</p>
					<p class="min_goods_amount">{$item.seller_name}</p>
					<p class="type-date">{$item.formatted_start_date}{'-'}{$item.formatted_end_date}</p>
				</div>
			</div>
		</li>
	<!-- {foreachelse} -->
		<div class="ecjia-nolist">
			<i class="iconfont icon-redpacket"></i>
			<p>{t}还没有红包哦~{/t}</p>
		</div>
	<!--{/foreach}-->
<!-- {/block} -->