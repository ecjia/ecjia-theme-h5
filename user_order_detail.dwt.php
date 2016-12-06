<?php
/*
Name: 订单详情模板
Description: 这是订单详情页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.goods.init();ecjia.touch.user.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="ecjia-order-detail">
	<ul class="ecjia-list ecjia-list-two ecjia-nav">
		<li class="active"><a class="nopjax" href="#one" role="tab" data-toggle="tab">订单状态</a></li>
		<li class=""><a class="nopjax" href="#two" role="tab" data-toggle="tab"	>订单详情</a></li>
	</ul>
	<div class="goods-describe ecjia-margin-t active order-log-list" id="one">
		<!-- {foreach from=$order.order_status_log item=info} -->
		<div class="order-log-item">
			<div class="order-log">
				<span>{$info.order_status}</span><span class="ecjiaf-fr order-time">{$info.time}</span>
				<p>{$info.message}</p>
			</div>
		</div>
		<!-- {/foreach} -->
	</div>
	<div class="ecjia-checkout goods-describe ecjia-margin-b" id="two">
		<div class="flow-goods-list">
			<ul class="goods-item">
				<!-- {foreach from=$order.goods_list item=goods} -->
				<li>
					<div class="ecjiaf-fl goods-img">
						<img src="{$goods.img.thumb}" alt="{$goods.name}" title="{$goods.name}" />
					</div>
					<div class="ecjiaf-fl goods-info">
						<p class="ecjia-truncate2">{$goods.name}</p>
						<p>{$goods.formated_shop_price}</p>
					</div>
					<span class="ecjiaf-fr goods-price"> X {$goods.goods_number}</span>
				</li>
				<!-- {/foreach} -->
			</ul>
			<ul class="ecjia-list ecjia-margin-t">
				<li>商品金额：<span class="ecjiaf-fr">{$order.formated_goods_amount}</span></li>
				<li>积分抵扣：<span class="ecjiaf-fr">{$order.formated_integral_money}</span></li>
				<li>红包抵扣：<span class="ecjiaf-fr">{$order.formated_bonus}</span></li>
				<li>税费金额：<span class="ecjiaf-fr">{$order.formated_tax}</span></li>
				<li>优惠：<span class="ecjiaf-fr">{$order.formated_discount}</span></li>
				<li>运费：<span class="ecjiaf-fr">{$order.formated_shipping_fee}</span></li>
				<li>共计：<span class="ecjiaf-fr">{$order.formated_total_fee}</span></li>
			</ul>
			<ul class="ecjia-list ecjia-margin-t">
			    <li>发货时间：<span class="">{if $order.shipping_time}{$order.shipping_time}{else}未发货{/if}</span></li>
				<li>收货人：<span class="">{$order.consignee} {$order.mobile}</span></li>
				<li>收货地址：<span class="">{$order.province} {$order.city} {$order.district}{$order.address}</span></li>
				<li>配送方式：<span class="">{$order.shipping_name}</span></li>
			</ul>
			<ul class="ecjia-list ecjia-margin-t">
				<li>订单号：<span class="">{$order.order_sn}</span></li>
				<li>下单时间：<span class="">{$order.formated_add_time}</span></li>
				<li>支付方式：<span class="">{$order.pay_name}</span></li>
				<li>备注：<span class="">{if $order.postscript}{$order.postscript}{else}无{/if}</span></li>
				<li>商家电话：<span class="">{$order.service_phone}</span></li>
			</ul>
			<div class="order-ft-link">
				<a class="btn btn-small btn-hollow" href="tel://{$order.service_phone}">联系卖家</a>
				{if $order.pay_status eq 0 && $order.order_status lt 2}<a class="btn btn-small btn-hollow" href='{url path="user/user_order/order_cancel" args="order_id={$order.order_id}"}'>取消订单</a> <a class="btn btn-small btn-hollow" href='{url path="pay/index/init" args="order_id={$order.order_id}"}'>去支付</a>{/if}
				{if $order.order_status gt 1} <a class="btn btn-small btn-hollow" href='{url path="user/user_order/buy_again" args="order_id={$order.order_id}"}'>再次购买</a>{/if}
				{if $order.shipping_status eq '1'} <a class="btn btn-small btn-hollow" href='{url path="user/user_order/affirm_received" args="order_id={$order.order_id}"}'>确认收货</a>{/if}
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->
