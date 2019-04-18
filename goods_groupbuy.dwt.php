<?php 
/*
Name: 团购商品模版
Description: 团购商品列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.index.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-groupbuy-model">
	<ul class="ecjia-groupbuy-list" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='index/ajax_goods' args='type=groupbuy'}">
	</ul>
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
	<!-- 异步商品列表 start-->
	<!-- {if $goods_list} -->
	<!-- {foreach from=$goods_list item=val} -->
		<li>
			<div class="list-page-goods-img">
				<span class="goods-img">
					<a class="nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}&act_id={$val.goods_activity_id}">
                    <img src="{$val.img.thumb}">
                    </a>
                    <span class="promote-time" data-type="2" value="{$val.promote_end_date}"></span>
                    <img class="groupbuy-icon" src="{$theme_url}images/icon-groupbuy.png"> 
                </span>
				<div class="list-page-box">
					<a class="nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}&act_id={$val.goods_activity_id}"><span class="goods-name">{$val.name}</span></a>
					<div class="merchants-name"><i class="iconfont icon-shop"></i>{$val.seller_name}{if $val.manage_mode eq 'self'}<span class="manage_mode">{t domain="h5"}自营{/t}</span>{/if}</div>
					<div class="list-page-goods-price">
						<!--{if $val.promote_price}-->
						<div class="price">{$val.formated_promote_price}</div>
						<!--{else}-->
						<div class="price">{$val.formated_shop_price}</div>
						<!--{/if}-->
						<!--{if $val.market_price}-->
	          			<del>{t domain="h5"}市场价：{/t}{$val.formated_market_price}</del>
	          			<!--{/if}-->
	          			<a class="btn nopjax external" href="{RC_Uri::url('goods/index/show')}&goods_id={$val.id}&act_id={$val.goods_activity_id}">{t domain="h5"}马上抢{/t}</a>
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