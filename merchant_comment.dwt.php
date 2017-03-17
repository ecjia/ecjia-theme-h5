<?php
/*
Name: 店铺商品
Description: 这是店铺商品页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.store.init();
	ecjia.touch.category.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-mod page_hearer_hide ecjia-fixed">
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->
</div>

<div class="ecjia-mod ecjia-header ecjia-store-banner">
	<div class="ecjia-header-left">
		<img src="{if $store_info.seller_banner}{$store_info.seller_banner}{else}{$theme_url}images/default_store_banner.png{/if}">
	</div>
	<div class="ecjia-store-brief">
		<li class="store-info">
			<div class="basic-info">
				<div class="store-left">
					<img src="{if $store_info.seller_logo}{$store_info.seller_logo}{else}{$theme_url}images/store_default.png{/if}">
				</div>
				<div class="store-right">
					<div class="store-title">
						<span class="store-name">{$store_info.seller_name}</span>
						{if $store_info.distance} <span class="seller-distance">{$store_info.distance}</span>{/if}
						{if $store_info.manage_mode}<span class="manage-mode">自营</span>{/if}
					</div>
					<div class="store-range">
						<i class="iconfont icon-remind"></i>{$store_info.label_trade_time}
					</div>
					<div class="store-description"><i class="iconfont icon-notification"></i>{$store_info.seller_description}</div>
				</div>
			</div>
		</li>
		{if $store_info.favourable_list}
		<ul class="store-promotion" id="promotion-scroll">
			<!-- {foreach from=$store_info.favourable_list item=list} -->
			<li class="promotion">
				<span class="promotion-label">{$list.type_label}</span>
				<span class="promotion-name">{$list.name}</span>
			</li>
			<!-- {/foreach} -->
		</ul>
		{/if}
		<li class="favourable_notice">共{if $store_info.favourable_count}{$store_info.favourable_count}{else}0{/if}个活动<i class="iconfont icon-jiantou-right"></i></li>
	</div>
	<div class="ecjia-header-right">
		<!-- {if $header_right.icon neq ''} -->
		<i class="{$header_left.icon}"></i>
		<!-- {else} -->
			<!-- {if $header_right.search neq ''} -->
			<a href="{$header_right.search_url}" class="m_r5"><span>{$header_right.search}</span></a>
			<!-- {/if} -->
			<!-- {if $header_right.location neq ''} -->
			<a href="{$header_right.location_url}" class="nopjax external"><span>{$header_right.location}</span></a>
			<!-- {/if} -->
		<!-- {/if} -->
	</div>
</div>
<div class="ecjia-mod ecjia-store-ul">
	<ul>
		<li class="ecjia-store-li" data-url="{$url}"><span class="">购物</span></li>
		<li class="ecjia-store-li"><span class="active">评价</span></li>
		<li class="ecjia-store-li"><span>商家</span></li>
	</ul>
</div>

<div class="ecjia-mod ecjia-store-comment ecjia-store-toggle">
	<div class="ecjia-seller-comment">
		<div class="store-hr"></div>
		<div class="store-score">
			<div class="score-name">商品评分 ({$store_info.comment.comment_goods})</div>
			<span class="score-val" data-val="{$store_info.comment.comment_goods_val}"></span>
		</div>
		<div class="store-comment-container">
		<!-- #BeginLibraryItem "/library/store_comment.lbi" --><!-- #EndLibraryItem -->
		</div>
	</div>
</div>
<!-- #BeginLibraryItem "/library/merchant_detail.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->