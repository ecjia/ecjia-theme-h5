<?php 
/*
Name: 首页模板
Description: 这是首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.b2b2c.init();</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<!-- TemplateBeginEditable name="顶部区域" -->
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->
<!-- TemplateEndEditable -->

<div class="shop-title-bgimg">
	<div class="shop-seller-name">
		<a href="{url path='touch/index/shop_init' args="id={$id}"}"><span>{$shop_message.seller_name}</span><br><span>{$shop_message.follower}人关注</span></a>
	</div>
	<div class="shop-attention">
		<a class="ecjiaf-fr btn shop-attion btn-info" data-toggle="is_attention" data-url="{url path='touch/index/add_attention'}" data-pjaxurl="{url path='touch/index/merchant_shop' args="ru_id={$id}"}" value="{$id}" data-is_attention="{if $shop_message.attention }1{/if}">{if $shop_message.attention}已关注{else}<i class="iconfont icon-add "></i>关注{/if}</a>
	</div>
	<div class="shop-seller-img">
		<a href="{url path='touch/index/shop_init' args="id={$id}"}"><img src="{$shop_message.seller_logo}"></a>
	</div>
</div>
<div class="list-page-wrapper text-center shop-detail">
	<form method="GET" class="sort" name="listform" action="{url path='touch/index/merchant_shop'}">
		<div class="list-page-nav">
			<a class="{if $sort eq 'last_update' && $order eq 'DESC'}list-page-nav-color list-page-nav-select{elseif $sort eq 'last_update' && $order eq 'ASC'}list-page-nav-color{/if}" href="{url path='touch/index/merchant_shop' args="ru_id={$ru_id}&sort=last_update"}&order={if $sort eq 'last_update' && $order eq 'ASC'}DESC{else}ASC{/if}&view={$view}">
				最新上架
				<i class="iconfont icon-jiantou-top"></i>
			</a>
			<a class="{if $sort eq 'click_count' && $order eq 'DESC'}list-page-nav-color list-page-nav-select{elseif $sort eq 'click_count' && $order eq 'ASC'}list-page-nav-color{/if}" href="{url path='touch/index/merchant_shop' args="ru_id={$ru_id}&sort=click_count"}&order={if $sort eq 'click_count' && $order eq 'ASC'}DESC{else}ASC{/if}&view={$view}">
				人气排行<i class="iconfont icon-jiantou-top"></i>
			</a>

			<a class="{if $sort eq 'shop_price' && $order eq 'DESC'}list-page-nav-color list-page-nav-select{elseif $sort eq 'shop_price' && $order eq 'ASC'}list-page-nav-color{/if}" href="{url path='touch/index/merchant_shop' args="ru_id={$ru_id}&sort=shop_price"}&order={if $sort eq 'shop_price' && $order eq 'ASC'}DESC{else}ASC{/if}&view={$view}">
				价格排行
				<i class="iconfont icon-jiantou-top"></i>
			</a>
			<a class="category-list" href="{url path='touch/index/merchant_shop' args="ru_id={$ru_id}&sort={$sort}&keywords={$keywords}&order={$order}"}&view={if $view eq '1'}2{elseif $view eq '2'}0{else}1{/if}">
				<i class="iconfont {if $view eq '1'}icon-shitu{elseif $view eq '2'}icon-datuliebiao{else}icon-liebiaoshitu{/if}"></i>
			</a>
		</div>
		<input type="hidden" name="sort" value="{$sort}" />
		<input type="hidden" name="ru_id" value="{$ru_id}" />
		<input type="hidden" name="order" value="{$order}" />
	</form>
</div>
<div class="bd">
	<ul class="ecjia-margin-b ecjia-list list-page {if $view eq '1'}ecjia-list-two list-page-two ecjia-margin-t{elseif $view eq '2'}list-page-three{else}list-page-one{/if}" id="J_ItemList" data-toggle="asynclist" data-url="{url path='touch/index/merchant_ajax_goods' args="ru_id={$ru_id}&sort={$sort}&order={$order}&view={$view}"}" >
	</ul>
	<a class="load-list" href="javascript:;"><img src="{$theme_url}images/loader.gif" /></a>
</div>

<footer>
	<div class="footer-icon">
		<ul class="ecjia-list ecjia-list-three">
			<li><a href="{url path='touch/index/download'}"><i class="iconfont icon-app"></i><p>{t}客户端{/t}</p></a></li>
			<li><a class="active" href="javascript:;"><i class="iconfont icon-shouji"></i><p>{t}触屏版{/t}</p></a></li>
			<li><a href="{$shop_pc_url}"><i class="iconfont icon-pc"></i><p>{t}电脑版{/t}</p></a></li>
		</ul>
	</div>
</footer>
<!-- {/block} -->


<!-- {block name="ajaxinfo"} -->

<!-- 异步商品列表 start-->
<!-- {foreach from=$goods_list item=goods} 循环商品 -->
<li class="single_item">
	<a class="list-page-goods-img" href="{$goods.url}">
			<span class="goods-img">
				<img src="{$goods.img}" alt="{$goods.goods_name}">
			</span>
			<span class="list-page-box">
				<span class="goods-name">{$goods.goods_name}</span>
				<span class="list-page-goods-price">
					<!-- {if $goods.price_promote}-->
						<span>{$goods.price_promote}</span>
					<!--{else}-->
						<span>{$goods.shop_price}</span>
					<!-- {/if} -->
						<!--{if $goods.market_price}-->
						<del>{$goods.market_price}</del>
					<!--{/if}-->
				</span>
			</span>
	</a>
</li>
<!-- {/foreach} -->
<!-- 异步商品列表end -->
<!-- {/block} -->