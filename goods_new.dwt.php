<?php 
/*
Name: 促销商品模版
Description: 促销商品列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.index.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<div class="ecjia-mod ecjia-margin-b goods-index-list ecjia-new-goods" style="border-bottom:none;" >
	<div class="bd">
		<ul class="ecjia-margin-b ecjia-list ecjia-list-two list-page-two" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='index/ajax_goods' args='type=new'}" >
		</ul>
	</div>
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
	<!-- 异步商品列表 start-->
	<!-- {foreach from=$goods_list item=goods} 循环商品 -->
	<li class="single_item">
		<a class="list-page-goods-img" href="{$goods.url}">
			<span class="goods-img">
				<img src="{$goods.thumb}" alt="{$goods.name}">
			</span>
			<span class="list-page-box">
				<p class="merchants-name"><i class="iconfont icon-shop"></i>宝美生活馆专营店</p>
				<span class="goods-name">{$goods.name}</span>
				<span class="list-page-goods-price">
					<!--{if $goods.promote_price}-->
					<span>{$goods.promote_price}</span>
					<!--{else}-->
					<span>{$goods.shop_price}</span>
					<!--{/if}-->
				</span>
			</span>
		</a>
	</li>
	<!-- {/foreach} -->
	<!-- 异步商品列表end -->
<!-- {/block} -->