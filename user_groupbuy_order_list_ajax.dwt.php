<?php
/*
Name: 获取团购订单模板
Description: 获取团购订单页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
<!-- {foreach from=$order_list item=list} -->
<li class="ecjia-order-item ecjia-checkout ecjia-margin-t {if $type == "whole"}ecjia-order-mt{/if}">
	<div class="order-hd">
		<a class="ecjiaf-fl nopjax external" href='{url path="merchant/index/init" args="store_id={$list.seller_id}"}'>
			{$list.store_name}<i class="iconfont icon-jiantou-right"></i>
		</a>
		<a class="ecjiaf-fr" href='{url path="user/order/groupbuy_detail" args="order_id={$list.order_id}"}'><span class="{if $list.order_status_code eq 'finished'}ecjia-color-green{else if $list.order_status_code eq 'canceled'}ecjia-color-red{/if}">{$list.label_order_status}</span></a>
	</div>
	<div class="flow-goods-list">
		<a class="ecjiaf-db" href='{url path="user/order/groupbuy_detail" args="order_id={$list.order_id}"}'>
			<ul class="{if count($list.goods_list) > 1}goods-list{else}goods-item{/if} goods_attr_ul"><!-- goods-list 多个商品隐藏商品名称,goods-item -->
				<li class="goods-img-more more-info">
					<span class="ecjiaf-ib">
						<p class="price">{$list.formated_total_fee}</p>
						<p>{t domain="h5" 1={$list.goods_number}}共%1件{/t}</p>
					</span>
				</li>
				<!-- {foreach from=$list.goods_list item=goods key=key} -->
				<!-- 判断不能大于3个 -->
				<!-- {if $key lt 3} -->
				<li class="goods-img ecjiaf-fl ecjia-margin-r ecjia-icon {if $list.goods_list|@count gt 1}goods_attr{/if}">
					<img class="ecjiaf-fl" src="{$goods.img.thumb}" alt="{$goods.name}" title="{$goods.name}" />
					{if $goods.goods_number gt 1}<span class="ecjia-icon-num top">{$goods.goods_number}</span>{/if}
				</li>
				<!-- {/if} -->
				<!-- {/foreach} -->
			</ul>
		</a>
	</div>
	<div class="order-ft">
		<span>{$list.order_time}</span>
		<span class="two-btn ecjiaf-fr">
		{if $list.order_status_code eq 'await_pay'} 
			<a class="btn btn-hollow" href='{url path="payment/pay/init" args="order_id={$list.order_id}&type=group_buy"}'>
				{if $list.has_deposit eq 1}
					{t domain="h5"}支付余额{/t} {if $list.order_amount neq 0}{$list.formated_order_amount}{/if}
				{else}
					{t domain="h5"}去支付{/t}
				{/if}
			</a>
		{/if}
		</span>
	</div>
</li>
<!-- {foreachelse} -->
<!-- {/foreach} -->
<!-- {/block} -->
{/nocache}