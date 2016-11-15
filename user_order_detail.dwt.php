<?php
/*
Name: 订单详情模板
Description: 这是订单详情页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.goods.init();ecjia.touch.user.init();</script>
<!-- {/block} -->

<!-- {block name="ecjia"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div class="flow-checkout">
	<section class="checkout-add">
		<a href="{url path='flow/consignee_list'}">
			<div class="consignee-icon"><i class="iconfont icon-location"></i></div>
			<div class="consignee-msg" for="addressId{$con_list.address_id}">
				<p class="title">
					<span class="ecjiaf-fl ecjia-margin-r">{t}收货人{/t}：{$order.consignee}</span>
					<span class="ecjia-margin-l ecjiaf-fl">{t}手机{/t}：{$order.mobile}</span>
				</p>
				<p class="ecjia-margin-t ecjiaf-wwb">{$order.address}</p>
			</div>
		</a>
	</section>
</div>

<section class="order-status-msg ecjia-margin-t">
	<div  class="consignee-ico"><i class="iconfont icon-icon04"></i></div>
	<div class="user-orders">
		<p class="ecjia-margin-b">
			{$lang.order_status}：
			<span>
                <!-- {if $order.pay_code != 'pay_cod'} -->
                    <!-- {if $order.pay_status == '未付款'} -->
                         未付款
                    <!-- {/if} -->
                <!-- {/if} -->

                <!-- {if $order.pay_code == 'pay_cod'} -->
                    <!-- {if $order.shipping_status == '未发货'} -->
                        待发货
                    <!-- {else} -->
                        <!-- {if $order.shipping_status == '已发货'} -->
                            待收货
                        <!-- {else} -->
                            <!-- {if $order.shipping_status == '收货确认'} -->
                                已完成
                            <!-- {/if} -->
                        <!-- {/if} -->
                    <!-- {/if} -->
                <!-- {else} -->
                    <!-- {if $order.pay_status == '已付款'} -->
                        <!-- {if $order.shipping_status == '已发货'} -->
                            待收货
                        <!-- {else} -->
                            <!-- {if $order.shipping_status == '收货确认'} -->
                                已完成
                                <!-- {else} -->
		                        待发货
                            <!-- {/if} -->
                        <!-- {/if} -->
                    <!-- {/if} -->
                <!-- {/if} -->
			</span>
		</p>
		<p class="ecjia-margin-b">
			{$lang.order_number}：
			<span>{$order.order_sn}</span>
		</p>
		<p {if $virtual_card} class="ecjia-margin-b"{/if}>
			{$lang.order_addtime}：
			<span>{$order.formated_add_time}</span>
		</p>
		<!--{if $order.to_buyer}-->
		<p>{$lang.detail_to_buyer}：{$order.to_buyer}</p>
		<!-- {/if} -->
		<!--{if $virtual_card}-->
		<p class="ecjia-margin-b">
			{$lang.virtual_card_info}：
			<br>
			<!--{foreach from=$virtual_card item=vgoods}-->
			<!--{foreach from=$vgoods.info item=card}-->
			<hr class="order_detail-user"/>
			<!--{if $card.card_sn}-->
			{$lang.card_sn}:
			<span>{$card.card_sn}</span>
			<br>
			<!--{/if}-->
			<!--{if $card.card_password}-->
			{$lang.card_password}:
			<span>{$card.card_password}</span>
			<br>
			<!--{/if}-->
			<!--{if $card.end_date}-->
			{$lang.end_date}:{$card.end_date}
			<br>
			<!--{/if}-->
			<!--{/foreach}-->
			<!--{/foreach}-->
		</p>
		<!-- {/if} -->
		<!-- {if $order.invoice_no}-->
		<!-- {if $order.invoice_no}-->
		<p {if $order.invoice_no}class="ecjia-margin-t"{/if}>
			发货单号：<span>{$order.invoice_no}</span>
		</p>
		<!-- {/if}-->
		<!--<p>
			<a class="btn btn-info ect-btn-info ect-colorf ect-bg" href="{url path='user/order_tracking' args="order_id={$order.order_id}"}" type="button">{$lang.order_tracking}</a>
		</p>-->
		<!--{/if}-->
	</div>
</section>

<section>
	<div>
		<ul class="ecjia-list order-detail-list ecjia-margin-t">
			<li class="hd">
				<p class="ecjiaf-fl">{$shop_name}</p>
				<p class="ecjiaf-fr"><!-- 共{$goods.goods_number}件商品  --><i class="iconfont icon-jiantou-bottom"></i></p>
			</li>
			<li class="order-goods-detail">

			<!-- {foreach from=$goods_list item=goods} -->
				<div class="order-goods-t ecjia-margin-b">
					<div class="ecjiaf-fl">
						<a href="{url path='goods/index/init' args="id={$goods.goods_id}"}" target="_blank">
							<img src="{$goods.goods_thumb}">
						</a>
					</div>
					<div class="ecjiaf-fl">
						<p class=" goods-name-order">
							<a class="ecjiaf-wwb ecjiaf-fl" href="{url path='goods/index/init' args="id={$goods.goods_id}"}">
								{$goods.goods_name}
							</a>
							<span class="ecjiaf-fr">{$goods.goods_price} <br><del>￥123</del></span>
						</p>
						<p class="goods-attr">
						<!-- {if $goods.goods_attr} -->
						{$goods.goods_attr}
						<!-- {/if} -->
						{$lang.number_to}：{$goods.goods_number}
						</p>
						{$lang.ws_subtotal}：<span class="ect-colory">{$goods.subtotal}</span>
					</div>
				</div>
			<!-- {/foreach} -->
			</li>
		</ul>
	</div>
</section>

<section class="ecjia-order-detail">
    <ul class="ecjia-list">

    	<!-- {if $order.shipping_id >0} -->
    	<li>
    		{$lang.shipping}：<span class="ecjiaf-fr">{$order.shipping_name}</span>
    	</li>
    	<!-- {/if} -->
    	<!-- {if $order.pay_id >0} -->
    	<li>
    		{$lang.payment}：<span class="ecjiaf-fr">{$order.pay_name}</span>
    	</li>
    	<!-- {/if} -->
    	<li>
    		{$lang.goods_all_price}：
    		<!-- {if $order.extension_code eq "group_buy"} -->
    		<span class="ecjiaf-fr ecjia-order-color">{$lang.gb_deposit}</span>
    		<!-- {/if} -->
    		<span class="ecjiaf-fr ecjia-order-color">{$order.formated_goods_amount}</span>
    	</li>

    	<!-- {if $order.tax gt 0} -->
    	<li>{$lang.tax}:<span class="ecjiaf-fr ecjia-order-color">{$order.formated_tax}</span></li>
    	<!-- {/if} -->

    	<!-- {if $order.shipping_fee >0} -->
    	<li>{$lang.shipping_fee}:<span class="ecjiaf-fr ecjia-order-color">{$order.formated_shipping_fee}</span></li>
    	<!-- {/if} -->

    	<!-- {if $order.insure_fee >0} -->
    	<li>{$lang.insure_fee}:<span class="ecjiaf-fr ecjia-order-color">{$order.formated_insure_fee}</span></li>
    	<!-- {/if} -->

    	<!-- {if $order.pay_fee >0} -->
    	<li>{$lang.pay_fee}:<span class="ecjiaf-fr ecjia-order-color">{$order.formated_pay_fee}</span></li>
    	<!-- {/if} -->

    	<!-- {if $order.pack_fee >0} -->
    	<li>{$lang.pack_fee}:<span class="ecjiaf-fr ecjia-order-color">{$order.formated_pack_fee}</span></li>
    	<!-- {/if} -->

    	<!-- {if $order.card_fee >0} -->
    	<li>{$lang.card_fee}:<span class="ecjiaf-fr ecjia-order-color">{$order.formated_card_fee}</span></li>
    	<!-- {/if} -->

    	<!-- {if $order.money_paid >0} -->
    	<li>{$lang.order_money_paid}:<span class="ecjiaf-fr ecjia-order-color">{$order.formated_money_paid}</span></li>
    	<!-- {/if} -->

    	<!-- {if $order.surplus >0} -->
    	<li>{$lang.use_surplus}:<span class="ecjiaf-fr ecjia-order-color">{$order.formated_surplus}</span></li>
    	<!-- {/if} -->

    	<!-- {if $order.integral_money >0} -->
    	<li>{$lang.use_integral}:<span class="ecjiaf-fr ecjia-order-color">{$order.formated_integral_money}</span></li>
    	<!-- {/if} -->

    	<!-- {if $order.bonus >0} -->
    	<li>{$lang.use_bonus}:<span class="ecjiaf-fr ecjia-order-color">{$order.formated_bonus}</span></li>
    	<!-- {/if} -->

    	<!-- {if $order.postscript} 是否有订单附言 -->
    	<li>
    		{$lang.order_postscript}：<span class="ecjiaf-fr">{$order.postscript}</span>
    	</li>
    	<!-- {/if} -->

    	<!-- {if $order.inv_payee && $order.inv_content} 是否开发票 -->
    	<li>
    		{$lang.invoice_title}：<span class="ecjiaf-fr">{$order.inv_payee}</span>
    	</li>

    	<li>
    		{$lang.invoice_content}：<span class="ecjiaf-fr ecjia-order-color">{$order.inv_content}</span>
    	</li>
    	<!-- {/if} -->
    	<!-- {if $order.integral >0} 是否使用积分 -->
    	<li>
    		{$lang.use_integral}：<span class="ecjiaf-fr">{$order.integral}</span>
    	</li>
    	<!-- {/if} 是否使用积分 -->

    	<!-- {if $order.card_name} 是否使用贺卡 -->
    	<li>
    		{$lang.use_card}：<span class="ecjiaf-fr">{$order.card_name}</span>
    	</li>
    	<!-- {/if} -->
    	<!-- {if $order.card_message} 是否使用贺卡 -->
    	<li>
    		{$lang.bless_note}：<span class="ecjiaf-fr">{$order.card_message}</span>
    	</li>
    	<!-- {/if} 是否使用贺卡 -->
    	<!-- {if $order.pack_name} 是否使用包装 -->
    	<li>
    		{$lang.use_pack}：<span class="ecjiaf-fr">{$order.pack_name}</span>
    	</li>
    	<!-- {/if} 是否使用包装 -->

    	<li>
    		{$lang.discount}：<span class="ecjiaf-fr ecjia-order-color">{$order.formated_discount}</span>
    	</li>

    	<li>
    		{$lang.order_amount}：<span class="ecjiaf-fr ecjia-order-color">{$order.formated_order_amount}</span>
    	</li>
    </ul>

    <!-- {if $allow_edit_surplus} 如果可以编辑使用余额数 -->
    <form class="ecjia-form" name="formFee" action="{url path='user/user_order/edit_surplus'}" method="post">
    	<div class="order-detail-info">
    		<ul class="ecjia-list order-detail-list ">
    			<li class="hd">
    				{t}余额支付{/t}
    				<i class="iconfont icon-jiantou-bottom ecjiaf-fr"></i>
    			</li>
    			<li class="order-goods-detail">
    				<!-- <p>{$max_surplus}</p> -->
    				<p class="ecjia-order-color">{t}当前账户余额{/t}：<span class="ecjia-margin-l">{$order.user_money}</span></p>
    				<p class="ecjia-margin-t ecjia-order-input ecjia-margin-b">
    					<input name="surplus" type="number" value="0" />
    					<input class="btn btn_info ecjiaf-fr" type="submit" value="{$lang.use_surplus}">
    				</p>
    			</li>
    		</ul>
    		<input name="order_id" type="hidden" value="{$smarty.get.order_id}" />
    	</div>
    </form>
    <!--{/if}-->
</section>
<div class="ecjia-margin-t {if $order.handler_left} two-btn{/if} order-btn">
		<!-- {if $order.handler_left }-->{$order.handler_left}<!-- {/if} -->
		{$order.handler}
</div>
<!-- {/block} -->
