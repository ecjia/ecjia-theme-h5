<?php
/*
Name: 售后订单模板
Description: 售后订单页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	{foreach from=$lang.merge_order_js item=item key=key}
		var {$key} = "{$item}";
	{/foreach}
	ecjia.touch.enter_search();
</script>
<!-- {/block} -->
<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="ecjia-order-list ">
    {if $order_list}
	<ul class="ecjia-margin-b" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='order/async_return_order_list'}" data-size="10" data-page="1">
		<!-- 订单异步加载 -->
	</ul>
	{else}
    <div class="ecjia-nolist">
    	{t}暂无相关订单{/t}
    </div>
	{/if}
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
<!-- {foreach from=$order_list item=list} -->
<li class="ecjia-order-item ecjia-checkout ecjia-margin-t {if $type == "whole"}ecjia-order-mt{/if}">
	<div class="order-hd">
		<a class="ecjiaf-fl" href='{url path="merchant/index/init" args="store_id={$list.store_id}"}'>
			<i class="iconfont icon-shop"></i>{$list.store_name} <i class="iconfont icon-jiantou-right"></i>
		</a>
		<a class="ecjiaf-fr" href='{url path="user/order/order_detail" args="order_id={$list.order_id}"}'><span class="ecjia-color-green">{$list.label_service_status}</span></a>
	</div>
	<div class="flow-goods-list">
		<a class="ecjiaf-db" href='{url path="user/order/order_detail" args="order_id={$list.order_id}&type=detail"}'>
			<ul class="{if count($list.goods_list) > 1}goods-list{else}goods-item{/if} goods_attr_ul"><!-- goods-list 多个商品隐藏商品名称,goods-item -->
				<!-- {foreach from=$list.goods_list item=goods name=goods} -->
				<!-- {if $smarty.foreach.goods.iteration gt 3} -->
				<!-- 判断不能大于4个 -->
				<li class="goods-img-more">
					<i class="icon iconfont">&#xe62e;</i>
					<p class="ecjiaf-ib">共{$list.total_goods_number}件</p>
				</li>
				<!-- {break} -->
				<!-- {/if} -->
				<li class="goods-img ecjiaf-fl ecjia-margin-r ecjia-icon {if $list.goods_list|@count gt 1}goods_attr{/if}">
					<img class="ecjiaf-fl" src="{$goods.img.thumb}" alt="{$goods.name}" title="{$goods.name}" />
					{if $goods.goods_number gt 1}<span class="ecjia-icon-num top">{$goods.goods_number}</span>{/if}
					{if $list.goods_list|@count eq 1}
					<div class="goods_attr_list">
						<p class="ecjiaf-fl goods-name">{$goods.name}</p>
						{if $goods.goods_attr}
    					<div class="order_list_attr">
    						<!-- {foreach from=$goods.goods_attr item=attr} -->
    					   	{if $attr.name}{$attr.name}:{$attr.value}{/if}
    						<!-- {/foreach} -->
    					</div>
    					{/if}
    				</div>
					{/if}
				</li>
				<!-- {/foreach} -->
			</ul>
		</a>
	</div>
	<div class="order-ft">
		<span>退款金额：<span class="ecjia-color-red">{$list.total_refund_amount}</span></span>
		<span class="two-btn ecjiaf-fr">
			{if $list.service_status_code eq 'refunded'} 
				<a class="btn btn-hollow" href='{url path="user/order/return_detail" args="refund_sn={$list.refund_sn}&type=return_money"}'>查看退款</a>
			{/if}
			{if $list.service_status_code eq 'refunded' || $list.service_status_code eq 'canceled'} 
				<a class="btn btn-hollow" href='{url path="user/order/buy_again" args="order_id={$list.order_id}&from=list"}'>再次购买</a>
			{/if}
		</span>
	</div>
</li>
<!-- {foreachelse} -->
<!-- {/foreach} -->
<!-- {/block} -->
{/nocache}