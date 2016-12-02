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

<div class="page_hearer_hide ecjia-fixed">
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
</div>

<div class="ecjia-header ecjia-store-banner">
	<div class="ecjia-header-left">
		<a href="javascript:ecjia.touch.history.back();">
			<i class="iconfont icon-jiantou-left"></i>
			<img src="{$store_info.seller_banner}">
		</a>
	</div>
</div>
<div class="ecjia-store-brief">
	<li class="store-info">
		<a href="{RC_Uri::url('goods/category/store_detail')}&store_id={$store_info.id}">
			<div class="basic-info">
				<div class="store-left">
					<img src="{$store_info.seller_logo}">
				</div>
				<div class="store-right">
					<div class="store-name">
						{$store_info.seller_name}
						{if $store_info.distance} {$store_info.distance}m{/if}
						{if $store_info.manage_mode eq 'self'}<span>自营</span>{/if}
						<label class="store-distance"><i class="iconfont icon-jiantou-right"></i></label>
					</div>
					<div class="store-range">
						<i class="iconfont icon-remind"></i>{$store_info.label_trade_time}
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</a>
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
	</li>
</div>
<div class="ecjia-store-goods">
	<div class="a1n a2g">
		<div class="wg">
			<div class="wh search-goods" data-url="{RC_Uri::url('touch/index/search')}&store_id={$store_id}" {if $keywords}style="text-align: left;" data-val="{$keywords}"{/if}>
				<span class="wp"><i class="iconfont icon-search"></i>搜索店内商品</span>
			</div>
		</div>
		<div class="a21 clearfix">
			<ul class="a1o">
				<!-- {if $store_info.goods_count.best_goods gt 0} -->
				<li class="a1p {if $action_type eq 'best'}a1r{/if}">
					<strong class="a1s" data-href="{RC_Uri::url('goods/category/ajax_category_goods')}&store_id={$store_id}&type=best" data-toggle="toggle-category">精选</strong>
				</li>
				<!-- {/if} -->

				<!-- {if $store_info.goods_count.hot_goods gt 0} -->
				<li class="a1p {if $action_type eq 'hot'}a1r{/if}">
					<strong class="a1s" data-href="{RC_Uri::url('goods/category/ajax_category_goods')}&store_id={$store_id}&type=hot" data-toggle="toggle-category">热销</strong>
				</li>
				<!-- {/if} -->

				<!-- {if $store_info.goods_count.new_goods gt 0} -->
				<li class="a1p {if $action_type eq 'new'}a1r{/if}">
					<strong class="a1s" data-href="{RC_Uri::url('goods/category/ajax_category_goods')}&store_id={$store_id}&type=new" data-toggle="toggle-category">新品</strong>
				</li>
				<!-- {/if} -->

				<li class="a1p {if (!$category_id && !$action_type) || $action_type eq 'all'}a1r{/if}">
					<strong class="a1s" data-href="{RC_Uri::url('goods/category/ajax_category_goods')}&store_id={$store_id}&type=all" data-toggle="toggle-category">全部</strong>
				</li>

				<!-- {if $store_category} -->
					<!-- {foreach from=$store_category item=val} -->
					<li class="a1p {if $val.id eq $category_id}a1r{/if}">
						<strong class="a1s" data-href="{RC_Uri::url('goods/category/ajax_category_goods')}&store_id={$store_id}" data-category="{$val.id}" data-toggle="toggle-category">{$val.name}</strong>
						<!-- {if $val.children} -->
							<strong class="a1v">
							<!-- {foreach from=$val.children item=v} -->
							<span class="a1u h a1w" data-href="{RC_Uri::url('goods/category/ajax_category_goods')}&store_id={$store_id}" data-category="{$v.id}" data-toggle="toggle-category">
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
			<div class="a1x wd ">
				<div class="a1z r2 a0h">
					<ul>
						<!-- {if $goods_list} -->
							<!-- {foreach from=$goods_list item=goods} -->
							<li>
								<a class="linksGoods w">
									<img class="pic" src="{$goods.img.small}">
									<dl>
										<dt>{$goods.name}</dt>
										<dd><label>{$goods.shop_price}</label></dd>
									</dl>
									<div class="box" id="goods_{$goods.id}">
	                                    <span class="reduce {if $goods.num}show{else}hide{/if}" data-toggle="remove-to-cart" rec_id="{$goods.rec_id}">减</span>
                                		<label class="{if $goods.num}show{else}hide{/if}">{$goods.num}</label>
                                		<span class="add" data-toggle="add-to-cart" rec_id="{$goods.rec_id}" goods_id="{$goods.id}">加</span>
                                	</div>
								</a>
							</li>
							<!-- {/foreach} -->
						<!-- {/if} -->
					</ul>
				</div>
			</div>
			<input type="hidden" value="{RC_Uri::url('goods/category/update_cart')}" name="update_cart_url" />
			<input type="hidden" value="{$store_id}" name="store_id" />
		</div>
	</div>
</div>

<div class="store-add-cart a4w">
	<div class="a52"></div>
	<a href="javascript:void 0;" class="a4x {if $count.goods_number}light{else}disabled{/if} outcartcontent show show_cart" show="false">
		{if $count.goods_number}
		<i class="a4y">
		{$count.goods_number}
		</i>
		{/if}
	</a>
	<div class="a4z" style="transform: translateX(0px);">
		{if !$count.goods_number}
			<div class="a50">购物车是空的</div>
		{else}
		<div>
			{$count.goods_price}{if $count.discount neq 0}<label>(已减{$count.discount})</label>{/if}
		</div>
		{/if}
	</div>
	<a class="a51 {if !$count.goods_number}disabled{/if}" href="javascript:void 0;">去结算</a>
	<div class="minicart-content" style="transform: translateY(0px); display: block;">
		<a href="javascript:void 0;" class="a4x {if $count.goods_number}light{else}disabled{/if} incartcontent show_cart" show="false">
			{if $count.goods_number}
			<i class="a4y">
			{$count.goods_number}
			</i>
			{/if}
		</a>
		<i class="a57"></i>
		<div class="a58 ">
			<span class="a69 a6a checked" checkallgoods="" onclick="">全选</span>
			<p class="a6c">(已选{$count.goods_number}件)</p>
			<a href="javascript:void 0;" class="a59" data-toggle="deleteall" data-url="{RC_Uri::url('goods/category/update_cart')}">清空购物车</a>
		</div>
		<div class="a5b" style="max-height: 18em;">
			<div class="a5l single">
				<ul class="minicart-goods-list single"> 
					<!-- {foreach from=$cart_list item=cart} -->
					<li class="a5n single">
						<span class="a69 a5o checked" checkgoods=""></span>
						<table class="a5s">
							<tbody>
								<tr>
									<td style="width:75px; height:75px">
										<img class="a7g" src="{$cart.img.small}">
									</td>
									<td>
										<div class="a7j">{$cart.goods_name}</div> 
										<span class="a7c">{$cart.formated_goods_price}</span>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="box" id="goods_cart_{$cart.goods_id}">
							<a class="a5u reduce" data-toggle="remove-to-cart" rec_id="{$cart.rec_id}"></a>
							<lable class="a5x">{$cart.goods_number}</lable>
							<a class="a5v " data-toggle="add-to-cart" rec_id="{$cart.rec_id}" goods_id="{$cart.goods_id}"></a>
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
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
	<!-- 异步购物车列表 start-->
	<!-- {foreach from=$list item=val} 循环商品 -->
	<li class="a5n single">
		<span class="a69 a5o checked" checkgoods=""></span>
		<table class="a5s">
			<tbody>
				<tr>
					<td style="width:75px; height:75px">
						<img class="a7g" src="{$val.img.small}">
					</td>
					<td>
						<div class="a7j">{$val.goods_name}</div> 
						<span class="a7c">{$val.formated_goods_price}</span>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="box" id="goods_cart_{$val.goods_id}">
			<a class="a5u reduce" data-toggle="remove-to-cart" rec_id="{$val.rec_id}"></a>
			<lable class="a5x">{$val.goods_number}</lable>
			<a class="a5v" data-toggle="add-to-cart" rec_id="{$val.rec_id}" goods_id="{$val.goods_id}"></a>
		</div>
	</li>
	<input type="hidden" name="rec_id" value="{$val.rec_id}" />
	<!-- {/foreach} -->
	<!-- 异步购物车列表end -->
<!-- {/block} -->