<?php
/*
Name: 商品列表
Description: 这是商品列表模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="list-page-wrapper text-center">
	<form method="GET" class="sort" name="listform">
		<div class="list-page-nav">
			<a class="{if $sort eq 'last_update' && $order eq 'ASC' }active list-page-nav-color list-page-nav-select{/if}"  href="{url path='category/goods_list' args="cid={$id}&display={$display}&brand={$brand}&category={$cid}&price_min={$price_min}&price_max={$price_max}&filter_attr={$filter_attr}&sort=last_update&order=ASC&keywords={$keywords}&view={$view}"}">
				{$lang.sort_default}
			</a>
			<a class="{if $sort eq 'click_count' && $order eq 'DESC'}list-page-nav-color list-page-nav-select{elseif $sort =='click_count' && $order eq 'ASC'}list-page-nav-color{else}{/if}" href="{url path='category/goods_list' args="cid={$id}&brand={$brand}&display={$display}&brand={$brand_id}&price_min={$price_min}&price_max={$price_max}&filter_attr={$filter_attr}&sort=click_count&keywords={$keywords}"}&order={if $sort eq 'click_count' && $order eq 'ASC'}DESC{else}ASC{/if}&view={$view}">
				{$lang.sort_popularity}
				<i class="iconfont icon-jiantou-top"></i>
			</a>
			<a class="{if $sort eq 'sales_volume' && $order eq 'DESC'}list-page-nav-color list-page-nav-select{elseif $sort =='sales_volume' && $order eq 'ASC'}list-page-nav-color{else}{/if}" href="{url path='category/goods_list' args="cid={$id}&brand={$brand}&display={$display}&brand={$brand_id}&price_min={$price_min}&price_max={$price_max}&filter_attr={$filter_attr}&sort=sales_volume&keywords={$keywords}"}&order={if $sort eq 'sales_volume' && $order eq 'ASC'}DESC{else}ASC{/if}&view={$view}">
				{$lang.sort_sales} <i class="iconfont icon-jiantou-top"></i>
			</a>

			<a class="{if $sort eq 'shop_price' && $order eq 'DESC'}list-page-nav-color list-page-nav-select{elseif $sort =='shop_price' && $order eq 'ASC'}list-page-nav-color{else}{/if}" href="{url path='category/goods_list' args="cid={$id}&brand={$brand}&display={$display}&brand={$brand_id}&price_min={$price_min}&price_max={$price_max}&filter_attr={$filter_attr}&sort=shop_price&keywords={$keywords}"}&order={if $sort eq 'shop_price' && $order eq 'ASC'}DESC{else}ASC{/if}&view={$view}">
				{$lang.sort_price}
				<i class="iconfont icon-jiantou-top"></i>
			</a>
			<a class="category-list" href="{url path='category/goods_list' args="cid={$id}&brand={$brand_id}&display={$display}&brand={$brand_id}&price_min={$price_min}&price_max={$price_max}&filter_attr={$filter_attr}&sort={$sort}&keywords={$keywords}"}&view={if $view eq '1'}2{elseif $view eq '2'}0{else}1{/if}">
				<i class="iconfont {if $view eq '1'}icon-shitu{elseif $view eq '2'}icon-datuliebiao{else}icon-liebiaoshitu{/if}"></i>
			</a>
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
</div>

<!--{if $show_asynclist eq 1}-->
<div>
	<ul id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-page="{$page}" data-url="{url path='category/asynclist' args="cid={$id}&brand={$brand}&price_min={$price_min}&price_max={$price_max}&filter_attr={$filter_attr}&page={$page}&sort={$sort}&order={$order}&keywords={$keywords}"}">
		<li class="single_item"></li>
		<a class="get_more" href="javascript:;"></a>
	</ul>
</div>
<!--{else}-->
<div>
	<ul class="ecjia-margin-b ecjia-list list-page {if $view eq '1'}ecjia-list-two list-page-two ecjia-margin-t{elseif $view eq '2'}list-page-three{else}list-page-one{/if}" id="J_ItemList" data-toggle="asynclist" data-page="{$page}" data-url="{url path='category/asynclist' args="cid={$id}&brand={$brand_id}&price_min={$price_min}&price_max={$price_max}&filter_attr={$filter_attr}&page={$page}&sort={$sort}&order={$order}&keywords={$keywords}"}">
	</ul>
	<!-- {$pages} -->
</div>
<!--{/if} -->

<!--筛选开始-->
<form class="goods-filter" id="form" method="post" action="{url path='category/goods_list'}">
	<div id="goFilter">
		<div class="goods-filter-box">
			<header class="ecjia-header">
				<div class="ecjia-header-left">
					<a href="javascript:;" data-toggle="closeSelection"><i class="iconfont icon-jiantou-left"></i></a>
				</div>
				<div class="ecjia-header-title">{$lang.goods_filter}</div>
				<div class="ecjia-header-right">
					<a href="javascript:document.getElementById('form').submit()"></a>
				</div>

			</header>

			<div class="goods-filter-box-content">
				<div class="goods-filter-box-listtype" data-tpa="H5_SEARCH_FILTER">
					<input class="cat" type="hidden" name="id" value="{$id}"/>
					<a class="title" id="filter_brand" href="javascript:;" data-url="touchweb_mod_Brand">
						{$lang.brand}
						<span class="range">
							<!--{foreach from=$brands item=brand name=brand}-->
								{if $brand.brand_id eq $brand_id}{$brand.brand_name}{/if}
							<!--{/foreach}-->
						</span> <i class="iconfont icon-jiantou-bottom"></i>
					</a>
					<ul>
						<!--{foreach from=$brands item=brand name=brands}-->
						<li class="av-selected">
							<a class="child-title" href="javascript:;" id="brand_{$brand.brand_id}" value="{$brand.brand_id}"  name="{$brand.brand_name}">{$brand.brand_name}</a>
						</li>
						<!--{/foreach}-->
					</ul>
					<input class="brandname" type="hidden" name="brand" value="{$brand_id}"/>
					<a class="title" id="filter_price" href="javascript:;" data-url="attr_price">
						{$lang.sort_price}
						<span class="range">
							<!--{foreach from=$price_grade item=grade name=grade}-->
							{if $grade.start == $price_min && $grade.end == $price_max }{$grade.price_range}{/if}
							<!--{/foreach}-->
						</span> <i class="iconfont icon-jiantou-bottom"></i>
					</a>
					<ul>
						<!--{foreach from=$price_grade item=grade name=grade}-->
						<li class="av-selected">
							<a class="child-title" id="grade_{$grade.sn}" name="{$grade.price_range}" href="javascript:;" value="{$grade.start}|{$grade.end}">{$grade.price_range}</a>
						</li>
						<!--{/foreach}-->
					</ul>
					<input type="hidden" name="price_min" value="{$price_min}" />
					<input type="hidden" name="price_max" value="{$price_max}" />

					<!-- {foreach from=$filter_attr_list item=filter name=filter} -->
					<a class="title" href="javascript:;" name="{$filter.filter_attr_name}" id="filter_attr_25544" data-tcd="ATTRIBUTE.25544" data-tcs="SEARCH.0" data-url="attr_25544">
						<!-- {$filter.filter_attr_name} -->
						<span class="range">
							<!-- {foreach from=$filter.attr_list item=attr name=attr} -->
							{if $attr.selected}{$attr.attr_value}{/if}
							<!-- {/foreach} -->
						</span>
						<i class="iconfont icon-jiantou-bottom"></i>
					</a>
					<ul class="filter" data="{$smarty.foreach.filter.index}">
						<!-- {foreach from=$filter.attr_list item=attr name=attr} -->
						<li class="filter_attr{if $attr.selected} av-selected{/if}" >
							<a class="child-title" href="javascript:;" id="brand_{$attr.attr_id}" value="{$attr.attr_id}"  name="{$attr.attr_value|escape:html}">{$attr.attr_value|escape:html}</a>
						</li>
						<!-- {/foreach} -->
					</ul>
					<!-- {/foreach} -->
					<input type="hidden" name="filter_attr" value="{$filter_attr}"/>
				</div>
				<input type="hidden" name="cid" value="{$id}" />
				<input type="hidden" name="keywords" value="{$keywords}" />
				<div class="btns two-btn ecjia-margin-t ecjia-margin-r ecjia-margin-l ecjia-margin-b">
					<input type="button" class="btn btn-default" data-toggle="clear_filter" value="{$lang.clear_filter}"/>
					<input type="submit" class="btn btn-info" name="sub" value="{$lang.button_submit}"/>
				</div>
			</div>
		</div>
	</div>
</form>

<!--筛选结束-->
