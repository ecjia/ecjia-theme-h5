<?php
/*
Name: 自定义橱窗_大BUY年
Description: 首页顶部大BUY年广告
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-margin-t custom_showcase8">
	<a href="http://192.168.1.101:8080/ecjia-touch/sites/touch/index.php?m=topic&c=index&a=info&id=6"><img src="{$theme_url}images/showcase8_1.png"></a>
	<div class="showcase8_2">
		<img class="ecjia-margin-t" src="{$theme_url}images/showcase8_2.png">
		<a class="showcase8-3" href="http://test.weshop.ecjia.com/index.php?m=goods&c=index&a=init&id=136"></a>
		<a class="showcase8-2" href="http://test.weshop.ecjia.com/index.php?m=goods&c=index&a=init&id=132"></a>
		<a class="showcase8-1" href="http://test.weshop.ecjia.com/index.php?m=goods&c=index&a=init&id=107"></a>
	</div>
	<img class="ecjia-margin-t" src="{$theme_url}images/showcase8_3.png">
	<div class="showcase8-goods">
		<ul class="ecjia-margin-b ecjia-list list-page ecjia-list-two list-page-two ">
			<!-- {foreach from=$best_goods item=sales} 循环商品 -->
			<li class="single_item">
				<a class="list-page-goods-img" href="{$sales.url}">
					<span class="goods-img"><img src="{$sales.goods_img}" alt="{$sales.name}"></span>
					<span class="list-page-box">
						<span class="goods-name">{$sales.name}</span>
						<span class="list-page-goods-price">
							<!--{if $sales.promote_price}-->
							<span>{$sales.promote_price}</span>
							<!--{else}-->
							<span>{$sales.shop_price}</span>
							<!--{/if}-->
							<!--{if $sales.market_price}-->
							<del>{$sales.market_price}</del>
							<!--{/if}-->
						</span>
					</span>
				</a>
			</li>
			<!-- {/foreach} -->
		</ul>
	</div>
</div>
<style type="text/css">
{literal}
.custom_showcase8 {padding: 0 .5em;}
.custom_showcase8 img {width:100%;}
.showcase8-goods {background-color: #ef3030;}
.showcase8_2{position: relative;}
.showcase8_2 a {position: absolute; width: 32%; height: 100%;top:0;}
.showcase8_2 .showcase8-1 {left: 0;}
.showcase8_2 .showcase8-2 {left: 34%;}
.showcase8_2 .showcase8-3 {left: 68%;}
{/literal}
</style>