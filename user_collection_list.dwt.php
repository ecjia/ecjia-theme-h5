<?php
/*
Name: 收藏商品列表模板
Description: 收藏商品列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.goods.init();</script>
<script type="text/javascript">
	var compare_no_goods = "{$lang.compare_no_goods}";
	var btn_buy = "{$lang.btn_buy}";
	var is_cancel = "{$lang.is_cancel}";
	var select_spe = "{$lang.select_spe}";
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div>
	<ul class="ecjia-collection ecjia-list list-page ecjia-list-two list-page-two" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='async_collection_list'}" data-size="10">
	</ul>
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
<!-- {foreach from=$collection_list item=val} 循环商品 -->
<li class="single_item">
	<a class="list-page-goods-img" href="{url path='goods/index/init' args="id={$val.goods_id}"}">
		<span class="goods-img">
			<img src="{$val.goods_thumb}" alt="{$val.goods_name}">
		</span>
		<span class="list-page-box">
			<span class="goods-name ecjia-margin-t">{$val.goods_name}</span>
			<span class="list-page-goods-price ecjiaf-fl">
				<span>{$val.shop_price}</span>
				<del>{$val.market_price}</del>
			</span>
			<a class="ecjiaf-fr ecjia-collect-del" href="javascript:" data-toggle="del_list" data-id="{$val.rec_id}" data-url="{url path='user/user_collection/delete_collection'}" data-msg="{t}您确定要把该商品移除收藏列表吗？{/t}">
				<i class="iconfont icon-delete"></i>
			</a>
		</span>
	</a>
</li>
<!--{foreachelse}-->
<div class="ecjia-nolist">
	<i class="iconfont icon-shoucang"></i>
	<p>{t}您还没有收藏过商品~{/t}</p>
</div>
<!-- {/foreach} -->
<!-- {/block} -->
