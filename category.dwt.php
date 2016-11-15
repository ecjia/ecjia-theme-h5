<?php 
/*
Name: 商品分类模板
Description: 这是商品分类页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.category.init();</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<header class="ecjia-header ecjia-header-index ecjia-category-search">
	<div class="ecjia-header-left">
		<a href="{if $header_left.href}{$header_left.href}{else}javascript:history.go(-1){/if}"><i class="iconfont icon-jiantou-left"></i></a>
	</div>
	<div class="ecjia-header-title ecjia-search-header goods-list-search">
		<a class="ecjia-header-div ecjia-search" href="{url path='touch/index/search'}">
			<i class="iconfont icon-search"></i>&nbsp;{if $keywords}{$keywords}{else}{$lang.no_keywords}{/if}
		</a>
	</div>
	<div class="ecjia-header-right">
		<a href="javascript:;"  data-toggle="openSelection">
			<!-- <i class="iconfont icon-filter"></i> -->
			筛选
		</a>
	</div>
</header>
<!-- #BeginLibraryItem "/library/goods_list.lbi" -->
<!-- #EndLibraryItem -->
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
	<!-- 异步商品列表 start-->
	<!-- {foreach from=$goods_list item=goods} 循环贺卡 -->
		<li class="single_item">
			<a class="list-page-goods-img" href="{$goods.url}">
				<span class="goods-img">
					<img src="{$goods.goods_img}" alt="{$goods.name}">
				</span>
				<span class="list-page-box">
					<span class="goods-name">{$goods.name}</span>
					<span class="list-page-goods-price">
						<!--{if $goods.promote_price}-->
						<span>{$goods.promote_price}</span>
						<!--{else}-->
						<span>{$goods.shop_price}</span>
						<!--{/if}-->
						<!--{if $goods.market_price}-->
						<del>{$goods.market_price}</del>
						<!--{/if}-->
					</span>
					<!-- <span class="goods-attr"><span class="ecjiaf-fl">销量:{$goods.sales_count}件 </span><span class="ecjiaf-fl">喜欢:4个</span></span> -->
				</span>
			</a>
		</li>
	<!--{foreachelse}-->
	<!-- 异步商品列表end -->
	<div class="ecjia-nolist">
		<i class="iconfont icon-goods"></i>
		<p>{t}暂无此类商品{/t}</p>
	</div>
	<!-- {/foreach} -->
<!-- {/block} -->