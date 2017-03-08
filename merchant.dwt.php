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
					<div class="store-name">
						<span class="seller-name">{$store_info.seller_name}</span>
						{if $store_info.distance} <span class="seller-distance">{$store_info.distance}</span>{/if}
						{if $store_info.manage_mode eq 'self'}<span class="manage-mode">自营</span>{/if}
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
<div class="ecjia-mode ecjia-store-ul">
	<ul>
		<li class="ecjia-store-li"><span class="active">购物</span></li>
		<li class="ecjia-store-li"><span class="">评价</span></li>
		<li class="ecjia-store-li"><span class="">商家</span></li>
	</ul>
</div>
<div class="ecjia-mod ecjia-store-goods ecjia-store-toggle">
	<div class="a1n a2g">
		<div class="a21 clearfix">
			<ul class="a1o">
				<!-- {if $store_info.goods_count.best_goods gt 0} -->
				<li class="a1p {if $action_type eq 'best'}a1r{/if}">
					<strong class="a1s" data-href="{RC_Uri::url('merchant/index/ajax_goods')}&store_id={$store_id}&type=best" data-toggle="toggle-category" data-type="best">精选</strong>
				</li>
				<!-- {/if} -->

				<!-- {if $store_info.goods_count.hot_goods gt 0} -->
				<li class="a1p {if $action_type eq 'hot'}a1r{/if}">
					<strong class="a1s" data-href="{RC_Uri::url('merchant/index/ajax_goods')}&store_id={$store_id}&type=hot" data-toggle="toggle-category" data-type="hot">热销</strong>
				</li>
				<!-- {/if} -->

				<!-- {if $store_info.goods_count.new_goods gt 0} -->
				<li class="a1p {if $action_type eq 'new'}a1r{/if}">
					<strong class="a1s" data-href="{RC_Uri::url('merchant/index/ajax_goods')}&store_id={$store_id}&type=new" data-toggle="toggle-category" data-type="new">新品</strong>
				</li>
				<!-- {/if} -->

				<li class="a1p {if (!$category_id && !$action_type) || $action_type eq 'all'}a1r{/if}">
					<strong class="a1s" data-href="{RC_Uri::url('merchant/index/ajax_goods')}&store_id={$store_id}&type=all" data-toggle="toggle-category" data-type="all">全部</strong>
				</li>

				<!-- {if $store_category} -->
					<!-- {foreach from=$store_category item=val} -->
					<li class="a1p {if $val.id eq $category_id}a1r{/if}">
						<strong class="a1s" data-href="{RC_Uri::url('merchant/index/ajax_goods')}&store_id={$store_id}" data-category="{$val.id}" data-toggle="toggle-category">{$val.name}</strong>
						<!-- {if $val.children} -->
							<strong class="a1v">
							<!-- {foreach from=$val.children item=v} -->
							<span class="a1u h a1w" data-href="{RC_Uri::url('merchant/index/ajax_goods')}&store_id={$store_id}" data-category="{$v.id}" data-toggle="toggle-category">
								{$v.name}
							</span>
							<!-- {/foreach} -->
							</strong>
						<!-- {/if} -->
					</li>
					<!-- {/foreach} -->
				<!-- {/if} -->
			</ul>
			<div class="a20">
				{$type_name}({$goods_num})
			</div>
			<div class="a1x wd" id="wd_list">
				<div class="a1z r2 a0h">
					<ul class="store_goods_{$action_type}" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='merchant/index/ajax_goods'}&store_id={$store_id}" data-type="{$action_type}">
					</ul>
				</div>
			</div>
			<input type="hidden" value="{RC_Uri::url('cart/index/update_cart')}" name="update_cart_url" />
			<input type="hidden" value="{$store_id}" name="store_id" />
			<input type="hidden" value="{$action_type}" name="type" />
		</div>
	</div>
</div>

<div class="ecjia-mod ecjia-store-comment ecjia-store-toggle hide">
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

<div class="ecjia-store-seller ecjia-store-toggle hide">
	<ul class="store-goods">
		<li class="goods-info">
			<span class="store-goods-count">{$store_info.goods_count.count}</span><br>
			<span class="store-goods-desc">全部商品</span>
			<span class="goods-border"></span>
		</li>
		<li class="goods-info">
			<span class="store-goods-count">{$store_info.goods_count.new_goods}</span><br>
			<span class="store-goods-desc">上新</span>
			<span class="goods-border"></span>
		</li>
		<li class="goods-info">
			<span class="store-goods-count">{$store_info.goods_count.best_goods}</span><br>
			<span class="store-goods-desc">促销</span>
			<span class="goods-border"></span>
		</li>
		<li class="goods-info">
			<span class="store-goods-count">{$store_info.goods_count.hot_goods}</span><br>
			<span class="store-goods-desc">店铺动态</span>
		</li>
	</ul>
				
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
	<div class="store-hr"></div>
	<div class="store-tel">
		<span class="tel-name"><i class="iconfont icon-phone"></i>商家电话</span>
		<p class="tel-result">{if $store_info.telephone}{$store_info.telephone}<a href="tel:{$store_info.telephone}"><i class="iconfont icon-phone"></i></a>{else}暂无{/if}</p>
	</div>
	<div class="store-hr"></div>
	<ul class="store-other-info">
		<li>
			<span class="other-info-name"><i class="iconfont icon-rank"></i>公司名称</span>
			<p class="other-info-result">{if $store_info.shop_name}{$store_info.shop_name}{else}暂无{/if}</p>
		</li>
		<li>
			<span class="other-info-name"><i class="iconfont icon-location"></i>所在地区</span>
			<p class="other-info-result">{if $store_info.shop_address}{$store_info.shop_address}{else}暂无{/if}</p>
		</li>
		<li>
			<span class="other-info-name"><i class="iconfont icon-remind"></i>营业时间</span>
			<p class="other-info-result">{if $store_info.label_trade_time}{$store_info.label_trade_time}{else}暂无{/if}</p>
		</li>
	</ul>
</div>

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
	<a class="a51 {if !$count.check_one}disabled{/if} check_cart" data-href="{RC_Uri::url('cart/flow/checkout')}" data-store="{$store_id}" data-address="{$address_id}" data-rec="{$rec_id}">去结算</a>
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
			<a href="javascript:void 0;" class="a59" data-toggle="deleteall" data-url="{RC_Uri::url('cart/index/update_cart')}">清空购物车</a>
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
</div>
<!-- 遮罩层 -->
<div class="a53" style="display: none;"></div>
<!-- #BeginLibraryItem "/library/address_modal.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/store_notice_modal.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/goods_attr_modal.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
	<!-- 异步购物车列表 start-->
	<!-- {foreach from=$list item=val} 循环商品 -->
	<li class="a5n single {if $val.is_disabled eq 1}disabled{/if}">
		<span class="a69 a5o {if $val.is_checked}checked{/if} checkbox {if $val.is_disabled eq 1}disabled{/if}" data-toggle="toggle_checkbox" rec_id="{$val.rec_id}"></span>
		<table class="a5s">
			<tbody>
				<tr>
					<td style="width:75px; height:75px">
						<img class="a7g" src="{$val.img.small}">
						
						<div class="product_empty">
						{if $val.is_disabled eq 1}库存不足{/if}
						</div>
					</td>
					<td>
						<div class="a7j">{$val.goods_name}</div> 
						<span class="a7c">
						{if $val.goods_price eq 0}免费{else}{$val.formated_goods_price}{/if}
						</span>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="box" id="goods_cart_{$val.goods_id}">
			<span class="a5u reduce {if $val.is_disabled eq 1}disabled{/if}" data-toggle="remove-to-cart" rec_id="{$val.rec_id}"></span>
			<lable class="a5x">{$val.goods_number}</lable>
			<span class="a5v {if $val.is_disabled eq 1}disabled{/if}" data-toggle="add-to-cart" rec_id="{$val.rec_id}" goods_id="{$val.goods_id}"></span>
		</div>
	</li>
	<input type="hidden" name="rec_id" value="{$val.rec_id}" />
	<!-- {/foreach} -->
	<!-- 异步购物车列表end -->
<!-- {/block} -->