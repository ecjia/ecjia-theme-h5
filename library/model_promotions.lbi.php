<?php
/*
Name: 促销专场模块
Description: 这是首页的促销专场模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-mod ecjia-sales-model ecjia-margin-t">
	<div class="hd ecjia-sales-hd">
		<h2><i class="iconfont icon-cuxiao"></i>促销商品<a href="{$more_sales}" class="more_info">更多</a></h2>
	</div>
	<ul class="ecjia-list list-page ecjia-list-two list-page-two ">
		<!-- {foreach from=$best_goods item=sales} 循环商品 -->
		<li class="single_item">
			<a class="list-page-goods-img" href="{$sales.url}">
				<span class="goods-img"><img src="" alt="{$sales.name}"></span>
				<span class="list-page-box">
					<span class="goods-name">{$sales.name}</span>
					<span class="list-page-goods-price">
						<!--{if $sales.promote_price}-->
						<span>{$sales.promote_price}</span>
						<!--{else}-->
						<span>{$sales.shop_price}</span>
						<!--{/if}-->
					</span>
				</span>
			</a>
			<img class="sales-icon" src="{$theme_url}images/sales.png">
		</li>
	<!-- {/foreach} -->
	</ul>
</div>
<style media="screen">
{literal}
.ecjia-sales-model .hd {color:#FF5000}
{/literal}
</style>
