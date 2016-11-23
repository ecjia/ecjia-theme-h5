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
<script type="text/javascript">ecjia.touch.category.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<header class="ecjia-header ecjia-store-banner">
	<div class="ecjia-header-left">
		<a href="javascript:ecjia.touch.history.back();">
			<i class="iconfont icon-jiantou-left"></i>
			<img src="{$store_info.seller_banner}">
		</a>
	</div>
</header>

<ul class="ecjia-store-brief">
	<li class="store-info">
		<a href="{RC_Uri::url('goods/category/store_info')}&store_id={$store_info.id}">
			<div class="basic-info">
				<div class="store-left">
					<img src="{$store_info.seller_logo}">
				</div>
				<div class="store-right">
					<div class="store-name">
						{$store_info.seller_name}
						{if $store_info.distance}&nbsp;{$store_info.distance}m{/if}
						{if $store_info.manage_mode eq 'self'}<span>自营</span>{/if}
					</div>
					<div class="store-range">
						<i class="iconfont icon-remind"></i>{$store_info.label_trade_time}
						<span class="store-distance"><i class="iconfont icon-jiantou-right"></i></span>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</a>
		{if $store_info.favourable_list}
		<ul class="store-promotion">
			<!-- {foreach from=$store_info.favourable_list item=list} -->
			<li class="promotion">
				<span class="promotion-label">{$list.type_label}</span>
				<span class="promotion-name">{$list.name}</span>
			</li>
			<!-- {/foreach} -->
		</ul>
		{/if}
	</li>
</ul>
<!-- {/block} -->