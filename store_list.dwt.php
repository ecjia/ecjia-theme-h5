<?php 
/*
Name: 分类店铺
Description: 这是分类店铺页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.category.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/index_header.lbi" --><!-- #EndLibraryItem -->

<!-- {if $data} -->
<div class="ecjia-mod ecjia-store-goods-list" {if $store_id && $count_search > 6}style="padding-bottom:7em;"{/if}>
	<ul class="ecjia-store-list" {if $is_last neq 1}data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='goods/category/store_list'}&type=ajax_get{if $store_id}{/if}&store_id={$store_id}&keywords={$keywords}" data-page="2"{/if}>
		<!-- {foreach from=$data item=val} -->
		<!-- {if !$store_id} -->
		<li class="single_item">
			<ul class="single_store">
				<li class="store-info">
					<a href="{RC_Uri::url('merchant/index/init')}&store_id={$val.id}">
					<div class="basic-info">
						<div class="store-left">
							<img src="{if $val.seller_logo}{$val.seller_logo}{else}{$theme_url}images/store_default.png{/if}">
						</div>
						<div class="store-right">
							<div class="store-name">{$val.seller_name}{if $val.manage_mode eq 'self'}<span>自营</span>{/if}</div>
							<div class="store-range">
								<i class="iconfont icon-remind"></i>{$val.label_trade_time}
								{if $val.distance}
								<span class="store-distance">{$val.distance}m</span>
								{/if}
							</div>
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
					</a>
					{if $val.seller_goods}
					<ul class="store-goods">
						<!-- {foreach from=$val.seller_goods key=key item=goods} -->
							<a href="{RC_Uri::url('goods/index/show')}&goods_id={$goods.goods_id}">
							<li class="goods-info {if $key gt 2}goods-hide-list{/if}">
								<span class="goods-image"><img src="{$goods.img.thumb}"></span>
								<p>
									{$goods.name}
									<label class="price">{$goods.shop_price}</label>
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
					查看更多（{$val.goods_count-3}）<i class="iconfont icon-jiantou-bottom"></i>
				</li>
				<li class="goods-info view-more retract hide">
					收起<i class="iconfont icon-jiantou-top"></i>
				</li>
			</ul>
			{/if}
		</li>
		<!-- {else} -->
		<li class="search-goods-list">
			<a class="linksGoods w"  href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}">
				<img class="pic" src="{$val.img.small}">
				<dl>
					<dt>{$val.name}</dt>
					<dd><label>{$val.shop_price}</label></dd>
				</dl>
			</a>
			<div class="box" id="goods_{$val.id}">
				<span class="reduce {if $val.num}show{else}hide{/if}" data-toggle="remove-to-cart" rec_id="{$val.rec_id}">减</span>
				<label class="{if $val.num}show{else}hide{/if}">{$val.num}</label>
				<span class="add" data-toggle="add-to-cart" rec_id="{$val.rec_id}" goods_id="{$val.id}">加</span>
			</div>
		</li>
		<!-- {/if} -->
		<!-- {/foreach} -->
	</ul>
</div>
<!-- {else} -->
<div class="ecjia-mod search-no-pro ecjia-margin-t ecjia-margin-b">
	<div class="ecjia-nolist">
		{if !$store_id}
		<p><img src="{$theme_url}images/no_store.png"></p>
		{else}
		<p><img src="{$theme_url}images/no_goods.png"></p>
		{/if}
		{if $keywords}
		暂无搜索结果
		{else}
		暂时没有商家
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
		{$real_count.goods_number}
		</i>
		{/if}
	</a>
	<div class="a4z" style="transform: translateX(0px);">
		{if !$real_count.goods_number}
			<div class="a50">购物车是空的</div>
		{else}
		<div>
			{$count.goods_price}{if $count.discount neq 0}<label>(已减{$count.discount})</label>{/if}
		</div>
		{/if}
	</div>
	<a class="a51 {if !$count.check_one}disabled{/if} check_cart" data-href="{RC_Uri::url('cart/flow/checkout')}" data-store="{$store_id}" data-address="{$address_id}" data-rec="{$rec_id}" href="javascript:;">去结算</a>
	<div class="minicart-content" style="transform: translateY(0px); display: block;">
		<a href="javascript:void 0;" class="a4x {if $count.goods_number}light{else}disabled{/if} incartcontent show_cart" show="false">
			{if $real_count.goods_number}
			<i class="a4y">
			{$real_count.goods_number}
			</i>
			{/if}
		</a>
		<i class="a57"></i>
		<div class="a58 ">
			<span class="a69 a6a {if $count.check_all}checked{/if}" data-toggle="toggle_checkbox" data-children=".checkbox" id="checkall">全选</span>
			<p class="a6c">(已选{$count.goods_number}件)</p>
			<a href="javascript:void 0;" class="a59" data-toggle="deleteall" data-url="{RC_Uri::url('goods/category/update_cart')}">清空购物车</a>
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
										<div class="product_empty">库存不足</div>
										{/if}
									</td>
									<td>
										<div class="a7j">{$cart.goods_name}</div> 
										<span class="a7c">
										{if $cart.goods_price eq 0}免费{else}{$cart.formated_goods_price}{/if}
										</span>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="box" id="goods_cart_{$cart.goods_id}">
							<span class="a5u reduce {if $cart.is_disabled eq 1}disabled{/if}" data-toggle="remove-to-cart" rec_id="{$cart.rec_id}"></span>
							<lable class="a5x">{$cart.goods_number}</lable>
							<span class="a5v {if $cart.is_disabled eq 1}disabled{/if}" data-toggle="add-to-cart" rec_id="{$cart.rec_id}" goods_id="{$cart.goods_id}"></span>
						</div>
					</li>
					<input type="hidden" name="rec_id" value="{$cart.rec_id}" />
					<!-- {/foreach} -->
				</ul>
				<div class="a5m single"></div>
			</div>
		</div>
		<div style="height:50px;"></div>
	</div>
	<!-- 遮罩层 -->
	<div class="a53" style="display: none;"></div>
</div>
<input type="hidden" value="{RC_Uri::url('goods/category/update_cart')}" name="update_cart_url" />
<input type="hidden" value="{$store_id}" name="store_id" />
<!-- {/if} -->
<!-- #BeginLibraryItem "/library/choose_address_modal.lbi" --><!-- #EndLibraryItem -->	
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
	<!-- {foreach from=$goods_list item=val} -->
		<li class="search-goods-list">
			<a class="linksGoods w" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}">
				<img class="pic" src="{$val.img.small}">
				<dl>
					<dt>{$val.name}</dt>
					<dd></dd>
					<dd><label>{$val.shop_price}</label></dd>
				</dl>
			</a>
			<div class="box" id="goods_{$val.id}">
				<span class="reduce {if $val.num}show{else}hide{/if}" data-toggle="remove-to-cart" rec_id="{$val.rec_id}">减</span>
				<label class="{if $val.num}show{else}hide{/if}">{$val.num}</label>
				<span class="add" data-toggle="add-to-cart" rec_id="{$val.rec_id}" goods_id="{$val.id}">加</span>
			</div>
		</li>
	<!-- {/foreach} -->
<!-- {/block} -->