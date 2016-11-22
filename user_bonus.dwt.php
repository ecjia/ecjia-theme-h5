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

<ul class="ecjia-list ecjia-list-three ecjia-bonus ecjia-margin-b ecjia-bonus-border-right">
	<li {if $status eq 'notused'} class="active three-btn"{/if}><a href="{url path='user/user_bonus/bonus' args='status=notused'}">{t}可使用{/t}</a></li>
	<li {if $status eq 'used'} class="active three-btn"{/if}><a href="{url path='user/user_bonus/bonus' args='status=used'}">{t}已使用{/t}</a></li>
	<li {if $status eq 'overdue'} class="active three-btn"{/if}><a href="{url path='user/user_bonus/bonus' args='status=overdue'}">{t}已过期{/t}</a></li>
</ul>

<div>
	<ul class="ecjia-list ecjia-bonus ecjia-list-two" id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='async_bonus_list' args="status={$status}"}" data-size="10">
	</ul>
</div>
<!-- {/block} -->
<!-- {block name="ajaxinfo"} -->
	<!--{foreach from=$bonus item=item}-->
		<li class="ecjia-margin-b list-l-size">
			<div class="{if $item.status eq '未使用'}user-bonus-head{else}user-bonus-head-expired{/if}">
				<div class="type-l {if $item.status eq '未使用'}no-type-money{else}type-money{/if}">￥20.00</div>
				<div class="type-r">
					<p class="type-name">{$item.type_name}</p>
					<p class="min_goods_amount">满￥39.90使用</p>
					<p class="type-date">2016.11.01-2016.12.01</p>
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