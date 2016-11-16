<?php
/*
Name: 首页模板
Description: 这是首页
Libraries: page_menu,page_header,model_banner,model_nav,model_brand_list
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.touch.index.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->

<!-- TemplateBeginEditable name="页面内容" -->
<!-- #BeginLibraryItem "/library/index_header.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/model_banner.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/model_nav.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/showcase_14533870648923.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/showcase_14533874072177.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/win_custom.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/model_brand_list.lbi" --><!-- #EndLibraryItem -->
<!-- {if $promotion_goods} -->
<!-- #BeginLibraryItem "/library/model_promotions.lbi" --><!-- #EndLibraryItem -->
<!-- {/if} -->

<!-- {if $new_goods} -->
<!-- #BeginLibraryItem "/library/model_newgoods.lbi" --><!-- #EndLibraryItem -->
<!-- {/if} -->

<!-- #BeginLibraryItem "/library/model_hotgoods.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/model_footer.lbi" --><!-- #EndLibraryItem -->
<!-- TemplateEndEditable -->

<!-- {/block} -->


<!-- {block name="ajaxinfo"} -->
	<!-- 异步商品列表 start-->
	<!-- {foreach from=$goods_list item=goods} 循环商品 -->
	<li class="single_item">
		<a class="list-page-goods-img" href="{$goods.url}">
			<span class="goods-img">
				<img src="" alt="{$goods.name}">
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
