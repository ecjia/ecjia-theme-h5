<?php 
/*
Name: 活动商品列表
Description: 这是优惠活动的商品列表
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<form method="GET" class="sort" name="listform">
	<div class="list-page-wrapper text-center">
		<div class="list-page-nav">
			<a class="{if $sort eq 'g.goods_id' && $order eq 'ASC'}list-page-nav-color list-page-nav-select{/if}" href="{url path='favourable/index/goods_list' args="id={$id}&cat={$cat}&display={$display}&brand={$id}&price_min={$price_min}&price_max={$price_max}&filter_attr={$filter_attr}&sort=g.goods_id&keywords={$keywords}"}&order=ASC">
				{$lang.sort_default}
			</a>
			<a class="{if $sort eq 'click_count' && $order eq 'ASC'}list-page-nav-color list-page-nav-select{elseif $sort eq 'click_count' && $order eq 'DESC'}list-page-nav-color{else}{/if}" href="{url path='favourable/index/goods_list' args="id={$id}&cat={$cat}&display={$display}&brand={$id}&price_min={$price_min}&price_max={$price_max}&filter_attr={$filter_attr}&sort=click_count&keywords={$keywords}"}&order={if $sort eq 'click_count' && $order eq 'DESC'}ASC{else}DESC{/if}">
				{$lang.sort_popularity} 
				<i class="iconfont icon-jiantou-top"></i>
			</a>
			<a class="{if $sort eq 'last_update' && $order eq 'ASC'}list-page-nav-color list-page-nav-select{elseif $sort eq 'last_update' && $order eq 'DESC'}list-page-nav-color{else}{/if}" href="{url path='favourable/index/goods_list' args="id={$id}&cat={$cat}&display={$display}&brand={$id}&price_min={$price_min}&price_max={$price_max}&filter_attr={$filter_attr}&sort=last_update&keywords={$keywords}"}&order={if $sort eq 'last_update' && $order eq 'DESC'}ASC{else}DESC{/if}">
				最新
				<i class="iconfont icon-jiantou-top"></i>
			</a>
			<a class="{if $sort eq 'shop_price' && $order eq 'DESC'}list-page-nav-color list-page-nav-select{elseif $sort eq 'shop_price' && $order eq 'ASC'}list-page-nav-color{else}{/if}" href="{url path='favourable/index/goods_list' args="id={$id}&cat={$cat}&display={$display}&brand={$id}&price_min={$price_min}&price_max={$price_max}&filter_attr={$filter_attr}&sort=shop_price&keywords={$keywords}"}&order={if $sort eq 'shop_price' && $order eq 'ASC'}DESC{else}ASC{/if}">
				{$lang.sort_price} 
				<i class="iconfont icon-jiantou-top"></i>
			</a>
			<a class="category-list" href="{url path='favourable/index/goods_list' args="id={$id}&brand={$brand_id}&display={$display}&brand={$brand_id}&price_min={$price_min}&price_max={$price_max}&filter_attr={$filter_attr}&sort={$sort}&keywords={$keywords}"}&view={if $view eq '1'}2{elseif $view eq '2'}0{else}1{/if}">
				<i class="iconfont {if $view eq '1'}icon-shitu{elseif $view eq '2'}icon-datuliebiao{else}icon-liebiaoshitu{/if}"></i>
			</a>
		</div>
	</div>
	<input type="hidden" name="id" value="{$id}" />
	<input type="hidden" name="display" value="{$display}" id="display" />
	<input type="hidden" name="brand" value="{$brand_id}" />
	<input type="hidden" name="price_min" value="{$price_min}" />
	<input type="hidden" name="price_max" value="{$price_max}" />
	<input type="hidden" name="filter_attr" value="{$filter_attr}" />
	<input type="hidden" name="page" value="{$page}" />
	<input type="hidden" name="sort" value="{$sort}" />
	<input type="hidden" name="order" value="{$order}" />
	<input type="hidden" name="keywords" value="{$keywords}" />
</form>
<!--{if $show_asynclist}-->
<div>
	<ul id="J_ItemList" class="ecjia-list list-page list-page-one">
		<li class="single_item"></li>
		<a href="javascript:;" class="get_more"></a>
	</ul>
</div>
<!--{else}-->
<div>
	<ul id="J_ItemList"  class="ecjia-list list-page {if $view eq '1'}ecjia-list-two list-page-two{elseif $view eq '2'}list-page-three{else}list-page-one{/if}">
	<!--{foreach name=goods_list from=$goods_list item=act_goods}-->
		<li class="single_item">
			<a class="list-page-goods-img" href="{$act_goods.url}">
				<span class="goods-img">
					<img src="{$act_goods.goods_img}" alt="{$act_goods.name}">
				</span>
				<span class="list-page-box">
					<span class="goods-name">{$act_goods.name}</span>
					<span class="list-page-goods-price">
						<!--{if $act_goods.promote_price}-->
						<span>{$act_goods.promote_price}</span>
						<!--{else}-->
						<span>{$act_goods.shop_price}</span>
						<!--{/if}-->
						<del>{$act_goods.market_price}</del>
					</span>
					<!-- <span class="goods-attr"><span class="ecjiaf-fl">销量:{$goods.sales_count}件 </span><span class="ecjiaf-fl">喜欢:4个</span></span> -->
				</span>
			</a>
		</li>
	<!--{/foreach}-->
	</ul>
</div>
<!-- 这里调用分页类 -->
<!--{/if} -->