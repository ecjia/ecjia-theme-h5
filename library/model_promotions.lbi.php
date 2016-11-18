<?php
/*
Name: 促销专场模块
Description: 这是首页的促销专场模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-mod ecjia-promotion-model ecjia-margin-t">
	<div class="hd ecjia-sales-hd">
		<h2><i class="iconfont icon-cuxiao"></i>促销商品<a href="{$more_sales}" class="more_info">更多</a></h2>
	</div>
	<div class="swiper-container swiper-promotion">
		<div class="swiper-wrapper">
			<!-- {foreach from=$promotion_goods item=val} 循环商品 -->
			<div class="swiper-slide">
				<a class="list-page-goods-img" href="{$val.url}">
					<span class="goods-img">
                        <img src="{$val.thumb}" alt="{$val.name}">
                        <span class="promote-time" value="{$val.promote_end_date}"></span>
                    </span>
					<span class="list-page-box">
						<span class="goods-name">{$val.name}</span>
						<span class="list-page-goods-price">
							<!--{if $val.promote_price}-->
							<span>{$val.promote_price}</span>
							<!--{else}-->
							<span>{$val.shop_price}</span>
							<!--{/if}-->
							<!--{if $val.market_price}-->
                    		<span><del>{$val.market_price}</del></span>
                    		<!--{/if}-->
						</span>
					</span>
				</a>
				<img class="sales-icon" src="{$theme_url}images/icon-promote@2x.png">
			</div>
			<!-- {/foreach} -->
		</div>
	</div>
</div>
<style media="screen">
{literal}
.ecjia-promotion-model .hd {color:#FF5000}
{/literal}
</style>
