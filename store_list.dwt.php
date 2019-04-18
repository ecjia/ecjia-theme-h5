<?php 
/*
Name: 分类店铺
Description: 这是分类店铺页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.touch.category.init();
{if $releated_goods}
var releated_goods = {$releated_goods};
{/if}
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/index_header.lbi" --><!-- #EndLibraryItem -->
<!-- {if $data} -->
<div class="ecjia-mod ecjia-store-goods-list" {if $store_id && $count_search > 6}style="padding-bottom:7em;"{/if}>
	<ul class="ecjia-store-list" {if $is_last neq 1}data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='goods/category/store_list'}&type=ajax_get{if $store_id}&store_id={$store_id}{/if}&keywords={$keywords}{if $cid}&cid={$cid}{/if}" data-page="2"{/if}>
		<!-- {foreach from=$data item=val} -->
		<!-- {if !$store_id} -->
		<li class="single_item">
			<ul class="single_store">
				<li class="store-info">
					<a class="nopjax external" href="{RC_Uri::url('merchant/index/init')}&store_id={$val.id}">
					<div class="basic-info">
						<div class="store-left">
							<img src="{if $val.seller_logo}{$val.seller_logo}{else}{$theme_url}images/store_default.png{/if}">
							{if $val.shop_closed eq 1}
								<div class="shop_closed_mask">{t domain="h5"}休息中{/t}</div>
							{/if}
						</div>
						<div class="store-right">
							<div class="store-title">
								<span class="store-name">{$val.seller_name}</span>
								{if $val.manage_mode eq 'self'}<span class="manage_mode">{t domain="h5"}自营{/t}</span>{/if}
								{if $val.distance}<span class="store-distance">{$val.distance}</span>{/if}
							</div>
							<div class="store-range">
								<i class="icon-shop-time"></i>{$val.label_trade_time}
								<!-- {if $val.allow_use_quickpay eq 1} -->
								<a href="{RC_Uri::url('user/quickpay/init')}&store_id={$val.id}"><span class="store-quickpay-btn">{t domain="h5"}买单{/t}</span></a>
								<!-- {/if} -->
							</div>
							{if $val.seller_notice neq ''}
							<div class="store-notice">
								<i class="icon-shop-notice"></i>{$val.seller_notice}
							</div>
							{/if}
						</div>
						<div class="clear"></div>
					</div>
					{if $val.favourable_list}
					<ul class="store-promotion">
						<!-- {foreach from=$val.favourable_list item=list} -->
						<li class="promotion">
							<span class="promotion-label">{$list.type_label}</span>
							<span class="promotion-name">{$list.name}</span>
						</li>
						<!-- {/foreach} -->
					</ul>
					{/if}
					<!-- {if $val.allow_use_quickpay eq 1 && $val.quickpay_activity_list} -->
					<ul class="store-promotion">
						<!-- {foreach from=$val.quickpay_activity_list item=list key=key} -->
						{if $key eq 0}
						<li class="quick">
							<span class="quick-label">{t domain="h5"}买单{/t}</span>
							<span class="promotion-name">{$list.title}</span>
						</li>
						{/if}
						<!-- {/foreach} -->
					</ul>
					<!-- {/if} -->
					</a>
					{if $val.seller_goods}
					<ul class="store-goods">
						<!-- {foreach from=$val.seller_goods key=key item=goods} -->
							<a class="nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$goods.goods_id}&product_id={$goods.product_id}">
							<li class="goods-info {if $key gt 2}goods-hide-list{/if}">
								<span class="goods-image"><img src="{$goods.img.small}"></span>
								<p>
									{$goods.name}
									<label class="price">{if $goods.promote_price}{$goods.promote_price}{else}{$goods.shop_price}{/if}</label>
								</p>
							</li>
							</a>
						<!-- {/foreach} -->
					</ul>
					{/if}
				</li>
			</ul>
			{if $val.goods_count > 3}
			<ul>
				<li class="goods-info view-more">
					{t domain="h5"}查看更多{/t}（{$val.goods_count-3}）<i class="iconfont icon-jiantou-bottom"></i>
				</li>
				<li class="goods-info view-more retract hide">
					{t domain="h5"}收起{/t}<i class="iconfont icon-jiantou-top"></i>
				</li>
			</ul>
			{/if}
		</li>
		<!-- {else} -->
		<li class="search-goods-list">
			<a class="linksGoods w nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}&product_id={$val.product_id}">
				<img class="pic" src="{$val.img.small}">
				<dl>
					<dt>{$val.name}</dt>
					<dd><label>{if $val.unformatted_promote_price neq 0 && $val.unformatted_promote_price lt $val.unformatted_shop_price}{$val.promote_price}{else}{$val.shop_price}{/if}</label></dd>
				</dl>
			</a>
			{if $store_info.shop_closed neq 1}
			<div class="box" id="goods_{$val.id}">
				<!-- {if $val.specification} -->
				<div class="goods_attr goods_spec_{$val.id}">
					<span class="choose_attr spec_goods" rec_id="{$val.rec_id}" goods_id="{$val.id}" data-num="{$val.num}" data-spec="{$val.default_spec}" data-url="{RC_Uri::url('cart/index/check_spec')}&store_id={$val.store_id}">{t domain="h5"}选规格{/t}</span>
					{if $val.num}<i class="attr-number">{$val.num}</i>{/if}
				</div>
				<!-- {else} -->
				<span class="reduce {if $val.num}show{else}hide{/if}" data-toggle="remove-to-cart" rec_id="{$val.rec_id}">{t domain="h5"}减{/t}</span>
				<label class="{if $val.num}show{else}hide{/if}">{$val.num}</label>
				<span class="add" data-toggle="add-to-cart" rec_id="{$val.rec_id}" goods_id="{$val.id}">{t domain="h5"}加{/t}</span>
				<!-- {/if} -->
			</div>
			{/if}
		</li>
		<!-- {/if} -->
		<!-- {/foreach} -->
	</ul>
	{if $store_id}
	<div class="ecjia-h48"></div>
	{/if}
</div>
<!-- #BeginLibraryItem "/library/goods_attr_static_modal.lbi" --><!-- #EndLibraryItem -->
<!-- {else} -->
<div class="ecjia-mod search-no-pro ecjia-margin-t ecjia-margin-b">
	<div class="ecjia-nolist">
		{if !$store_id}
		<p><img src="{$theme_url}images/wallet/null280.png"></p>
		{else}
		<p><img src="{$theme_url}images/wallet/null280.png"></p>
		{/if}
		{if $keywords}
		{t domain="h5"}暂无搜索结果{/t}
		{else}
		{t domain="h5"}暂时没有商家{/t}
		{/if}
	</div>
</div>
<!-- {/if} -->

<!-- {if $store_id} -->
<div class="ecjia-mod store-add-cart a4w">
	<div class="a52"></div>
	<a href="javascript:void 0;" class="a4x {if $real_count.goods_number}light{else}disabled{/if} outcartcontent show show_cart" show="false">
		{if $real_count.goods_number}
		<i class="a4y">
		{if $real_count.goods_number gt 99}99+{else}{$real_count.goods_number}{/if}
		</i>
		{/if}
	</a>
	<div class="a4z" style="transform: translateX(0px);">
		{if $store_info.shop_closed eq 1}
			<div class="a61">{t domain="h5"}商家打烊了{/t}</div>
			<div class="a62">{t domain="h5"}营业时间{/t} {$store_info.label_trade_time}</div>
		{else}
			{if !$real_count.goods_number}
				<div class="a50">{t domain="h5"}购物车是空的{/t}</div>
			{else}
			<div>
				{$count.goods_price}{if $count.discount neq 0}<label>{t domain="h5" 1={$count.discount}}(已减%1){/t}</label>{/if}
			</div>
			{/if}
		{/if}
	</div>
	<a class="a51 {if !$count.check_one || $count.meet_min_amount neq 1}disabled{/if} check_cart" data-href="{RC_Uri::url('cart/flow/checkout')}" data-store="{$store_id}" data-address="{$address_id}" data-rec="{$rec_id}" href="javascript:;">{if $count.meet_min_amount eq 1 || !$count.label_short_amount}{t domain="h5"}去结算{/t}{else}{t domain="h5" 1={$count.label_short_amount}}还差%1起送{/t}{/if}</a>
	<div class="minicart-content" style="transform: translateY(0px); display: block;">
		<a href="javascript:void 0;" class="a4x {if $count.goods_number}light{else}disabled{/if} incartcontent show_cart" show="false">
			{if $real_count.goods_number}
			<i class="a4y">
			{if $real_count.goods_number gt 99}99+{else}{$real_count.goods_number}{/if}
			</i>
			{/if}
		</a>
		<i class="a57"></i>
		<div class="a58 ">
			<span class="a69 a6a {if $count.check_all}checked{/if}" data-toggle="toggle_checkbox" data-children=".checkbox" id="checkall">{t domain="h5"}全选{/t}</span>
			<p class="a6c">{t domain="h5" 1={$count.goods_number}}(已选%1件){/t}</p>
			<a href="javascript:void 0;" class="a59" data-toggle="deleteall" data-url="{RC_Uri::url('cart/index/update_cart')}">{t domain="h5"}清空购物车{/t}</a>
		</div>
		<div class="a5b" style="max-height: 21em;">
			<div class="a5l single">
				{if $store_info.favourable_list}
				<ul class="store-promotion" id="store-promotion">
					<!-- {foreach from=$store_info.favourable_list item=list} -->
					<li class="promotion">
						<span class="promotion-label">{$list.type_label}</span>
						<span class="promotion-name">{$list.name}</span>
					</li>
					<!-- {/foreach} -->
				</ul>
				{/if}
				<ul class="minicart-goods-list single"> 
					<!-- {foreach from=$cart_list item=cart} -->
					<li class="a5n single {if $cart.is_disabled eq 1}disabled{/if}">
						<span class="a69 a5o {if $cart.is_checked}checked{/if} checkbox {if $cart.is_disabled eq 1}disabled{/if}" data-toggle="toggle_checkbox" rec_id="{$cart.rec_id}"></span>
						<table class="a5s">
							<tbody>
								<tr>
									<td style="width:75px; height:75px">
										<img class="a7g" src="{$cart.img.small}">
										{if $cart.is_disabled eq 1}
										<div class="product_empty">{$cart.disabled_label}</div>
										{/if}
									</td>
									<td>
										<div class="a7j">{$cart.goods_name}</div> 
										{if $cart.attr}<div class="a7s">{$cart.attr}</div>{/if}
										<span class="a7c">
										{if $cart.goods_price eq 0}{t domain="h5"}免费{/t}{else}{$cart.formated_goods_price}{/if}
										</span>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="box" id="goods_cart_{$cart.goods_id}">
							<span class="a5u reduce {if $cart.is_disabled eq 1}disabled{/if}" data-toggle="remove-to-cart" rec_id="{$cart.rec_id}" goods_id="{$cart.goods_id}"></span>
							<lable class="a5x" {if $cart.is_disabled neq 1}data-toggle="change-number"{/if} rec_id="{$cart.rec_id}" goods_id="{$cart.goods_id}" goods_num="{$cart.goods_number}">{$cart.goods_number}</lable>
							<span class="a5v {if $cart.is_disabled eq 1}disabled{/if}" data-toggle="add-to-cart" rec_id="{$cart.rec_id}" goods_id="{$cart.goods_id}"></span>
						</div>
					</li>
					<input type="hidden" name="rec_id" value="{$cart.rec_id}" />
					<!-- {/foreach} -->
				</ul>
				<div class="a5m single"></div>
			</div>
		</div>
	</div>
</div>
<!-- 遮罩层 -->
<div class="a53" style="display: none;"></div>
<input type="hidden" value="{RC_Uri::url('cart/index/update_cart')}" name="update_cart_url" />
<input type="hidden" value="{$store_id}" name="store_id" />
<!-- {/if} -->
<!-- #BeginLibraryItem "/library/address_modal.lbi" --><!-- #EndLibraryItem -->	
<!-- #BeginLibraryItem "/library/change_goods_num.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
	<!-- {foreach from=$goods_list item=val} -->
	<li class="search-goods-list">
		<a class="linksGoods w nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}&product_id={$val.product_id}">
			<img class="pic" src="{$val.img.small}">
			<dl>
				<dt>{$val.name}</dt>
				<dd></dd>
				<dd><label>{if $val.unformatted_promote_price neq 0 && $val.unformatted_promote_price lt $val.unformatted_shop_price}{$val.promote_price}{else}{$val.shop_price}{/if}</label></dd>
			</dl>
		</a>
		{if $store_info.shop_closed neq 1}
		<div class="box" id="goods_{$val.id}">
			<!-- {if $val.specification} -->
			<div class="goods_attr goods_spec_{$val.id}">
				<span class="choose_attr spec_goods" rec_id="{$val.rec_id}" goods_id="{$val.id}" data-num="{$val.num}" data-spec="{$val.default_spec}" data-url="{RC_Uri::url('cart/index/check_spec')}&store_id={$val.store_id}">{t domain="h5"}选规格{/t}</span>
				{if $val.num}<i class="attr-number">{$val.num}</i>{/if}
			</div>
			<!-- {else} -->
			<span class="reduce {if $val.num}show{else}hide{/if}" data-toggle="remove-to-cart" rec_id="{$val.rec_id}">{t domain="h5"}减{/t}</span>
			<label class="{if $val.num}show{else}hide{/if}">{$val.num}</label>
			<span class="add" data-toggle="add-to-cart" rec_id="{$val.rec_id}" goods_id="{$val.id}">{t domain="h5"}加{/t}</span>
			<!-- {/if} -->
		</div>
		{/if}
	</li>
	<!-- {/foreach} -->
<!-- {/block} -->
{/nocache}