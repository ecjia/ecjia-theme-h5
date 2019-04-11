<?php 
/*
Name: 促销商品模版
Description: 促销商品列表页
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
<div class="ecjia-promotion-model">
	<ul class="ecjia-promotion-tab">
		<li class="active"><span>今日促销</span></li>
		<li><span>明日促销</span></li>
		<li><span>后日促销</span></li>
		<li><span>更多促销</span></li>
	</ul>
	<ul class="ecjia-promotion-list" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='index/ajax_goods' args='type=promotion'}">
	</ul>
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
<!-- 异步促销商品列表 start-->
<!-- {if $goods_list} -->
<!-- {foreach from=$goods_list item=val} -->
<li class="ecjia-margin">
	<div class="list-page-goods-img">
		<div class="goods-img">
			<a class="nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}{if $val.product_id neq 0}&p_id={$val.product_id}{/if}"><img class="img" src="{$val.img.thumb}" alt="{$val.name}"></a>
			<span class="promote-time" data-type="2" value="{$val.promote_end_date}"></span>
			<img class="sales-icon" src="{$theme_url}images/icon-promote@2x.png">
		</div>
		<div class="list-page-box">
			<a class="nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}{if $val.product_id neq 0}&p_id={$val.product_id}{/if}"><span class="goods-name">{$val.name}</span></a>
			<p class="store-name">
				<span class="name"><img class="logo" src="{$theme_url}images/icon/seller-name-icon.png" />{$val.store_name}</span>
				<span class="self-label">{t domain="h5"}自营{/t}</span>
			</p>
			<div class="list-page-goods-price">
				<div class="left">
					<!--{if $val.promote_price}-->
					<p>{$val.promote_price}</p>
					<!--{else}-->
					<p>{$val.shop_price}</p>
					<!--{/if}-->

					<!--{if $val.shop_price}-->
					<del>{$val.shop_price}</del>
					<!--{/if}-->
				</div>
				<a class="btn go-buy nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}{if $val.product_id neq 0}&p_id={$val.product_id}{/if}">立即购买</a>
			</div>
		</div>
	</div>
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