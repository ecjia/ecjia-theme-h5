<?php 
/*
Name: 店长推荐模版
Description: 店长推荐推荐列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.index.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-mod ecjia-margin-b goods-index-list ecjia-new-goods" style="border-bottom:none;">
	<div class="bd">
		<ul class="ecjia-margin-b ecjia-list ecjia-list-two list-page-two" id="J_ItemList" data-toggle="asynclist"
		 data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='index/ajax_goods' args='type=best'}">
		</ul>
	</div>
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
<!-- 异步商品列表 start-->
<!-- {if $goods_list} -->
<!-- {foreach from=$goods_list item=goods} 循环商品 -->
<li class="single_item">
	<a class="list-page-goods-img nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$goods.id}">
		<span class="goods-img">
			<img src="{$goods.img.thumb}" alt="{$goods.name}">
		</span>
		<span class="list-page-box">
			<span class="merchants-name"><i class="iconfont icon-shop"></i>{$goods.seller_name}{if $goods.manage_mode eq 'self'}<span class="manage_mode">{t domain="h5"}自营{/t}</span>{/if}
			</span>
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
<!-- {else} -->
<div class="ecjia-mod search-no-pro ecjia-margin-t ecjia-margin-b">
	<div class="ecjia-nolist">
		<p><img src="{$theme_url}images/wallet/null280.png"></p>
		{t domain="h5"}暂无商品{/t}
	</div>
</div>
<!-- {/if} -->
<!-- 异步商品列表end -->
<!-- {/block} -->
{/nocache}