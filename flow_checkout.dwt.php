<?php
/*
Name: 订单确认模板
Description: 订单确认页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.flow.init();
	ecjia.touch.flow.init_pay();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div class="ecjia-checkout">
	<form id="theForm" name="theForm" action="{url path='flow/done'}" method="post">
		<div class="flow-address ecjia-margin-b">
			<span class="ecjiaf-fl">送至：</span>
			<div class="ecjiaf-fl address-info">
				<span>{$consignee.consignee|escape}</span>
				<span>{$consignee.mobile}</span>
				<p class="ecjia-truncate2 address-desc">{$consignee.address}{$consignee.address_info}</p>
			</div>
		</div>
	</form>
</div>
<div class="flow-checkout">
	<form id="theForm" name="theForm" action="{url path='flow/done'}" method="post">

		<section class="checkout-select ecjia-margin-t">
			<!--{if $total.real_goods_count neq 0}-->
			<a class="select nopjax" href="javascript:;">
				<p>
					<span>{$lang.shipping_method}</span>
					<span class="label">{$lang.require_field}</span>
					<i class="iconfont icon-jiantou-bottom"></i>
					<span class="ecjiaf-fr select_nav">{$shipping_default}</span>
				</p>
			</a>
			<div>
				<ul class="ecjia-list attr-bgcolr">
					<!-- {foreach from=$shipping_list item=shipping} 循环配送方式 -->
					<li>
						<label for="shipping_{$shipping.shipping_id}">
							<input data-trigger="radio" class="cart-check-radio" id="shipping_{$shipping.shipping_id}" name="shipping" type="radio" value="{$shipping.shipping_id}"  {if $shipping.default}checked="true"{/if} supportCod="{$shipping.support_cod}" insure="{$shipping.insure}" data-toggle="selectShipping" data-url="{url path='cart/flow/select_shipping'}" />
							{$shipping.shipping_name} [{$shipping.format_shipping_fee}]
						</label>
					</li>
					<!-- {/foreach} 循环配送方式 -->
				</ul>
			</div>
			<!--{else}-->
			<label>
				<input data-trigger="radio" class="cart-check-radio" name="shipping"  type="radio" value = "-1" checked="checked" />
			</label>
			<!--{/if}-->

			<!--{if $is_exchange_goods neq 1 || $total.real_goods_count neq 0}-->
			<a class="select nopjax" href="javascript:;">
				<p>
					<span>{$lang.payment_method}</span>
					<span class="label">{$lang.require_field}</span>
					<i class="iconfont icon-jiantou-bottom"></i>
					<span class="ecjiaf-fr select_nav">{$payment_default}</span>
				</p>
			</a>
			<div>
				<ul class="ecjia-list payment attr-bgcolr">
					<!-- {foreach from=$payment_list item=payment} -->
					<li>
						<label for="payment_{$payment.pay_id}">
							<input data-trigger="radio" class="cart-check-radio" id="payment_{$payment.pay_id}" name="payment" type="radio" value="{$payment.pay_id}" {if $payment.default}checked="true"{/if} isCod="{$payment.is_cod}" data-toggle="selectPayment" data-url="{url path='cart/flow/select_payment'}" >
							{$payment.pay_name} [{$payment.format_pay_fee}]
						</label>
					</li>
					<!-- {/foreach} -->
				</ul>
			</div>
			<!--{else}-->
			<label>
				<input data-trigger="radio" class="cart-check-radio" name = "payment" type="radio" value = "-1" checked="checked"/>
			</label>
			<!--{/if}-->
		</section>

		<section class="checkout-select checkout-pro-list ecjia-margin-t">
			<ul class="ecjia-list">
				<li class="goods-list">
					<span>{$lang.goods_list}</span>
					<span class="ecjiaf-fr">{t}共{/t}{$goods_number}{t}件商品{/t}</span>
				</li>
			</ul>
			<ul class="ecjia-list checkout-goods-list">
				<!-- {foreach from=$goods_list item=goods} -->
				<li>
					<!-- {if $goods.goods_id gt 0 && $goods.extension_code eq 'package_buy'} -->
					<a href="javascript:void(0)" onClick="setSuitShow({$goods.goods_id})" >
						{$goods.goods_name}
						<span>（{$lang.remark_package}）</span>
					</a>
					<!-- {else} -->
					<div class="ecjiaf-fl check-goods-list"><a href="{url path='goods/index/init' args="id={$goods.goods_id}"}" target="_blank" ><img src="{$goods.goods_img}" /></a></div>
					<a href="{url path='goods/index/init' args="id={$goods.goods_id}"}" target="_blank" >
						<div class="ecjiaf-fl flow-checkout-goodsname ecjiaf-wwb">
							{$goods.goods_name}
							<div class="ecjia-margin-t goods-attr">{$goods.goods_attr}</div>
							<!-- {if $goods.parent_id >0} -->
							<span>（{$lang.accessories}）</span>
							<!-- {elseif $goods.is_gift} -->
							<span>（{$lang.largess}）</span>
							<!-- {/if} -->
							<!-- {/if} -->
							<!-- {if $goods.is_shipping} -->
							(<span>{$lang.free_goods}</span>)
							<!-- {/if} -->
						</div>
					</a>
					<div class="ecjiaf-fr goods-price">
						<span class="ecjiaf-fr cart-formated-subtotal ecjia-margin-b">{$goods.formated_goods_price}<br/><del>￥{$goods.market_price}{t}元{/t}</del></span>
						<div>{t}数量{/t}：{$goods.goods_number}</div>
					</div>
				</li>
				<!-- {/foreach} -->
				<li class="order-check"><input name="postscript" type="text" placeholder="{t}给卖家留言{/t}"></li>
				<input type="hidden" name="rec_id" value="{$rec_id}"/>
			</ul>
			</section>

			<section class="checkout-select ecjia-margin-t">

			<!-- {if $inv_content_list} 能否开发票 -->
			<a class="select nopjax" href="javascript:;">
				<p>
					<span>{$lang.invoice}</span>
					<i class="iconfont icon-jiantou-bottom"></i>
				</p>
			</a>
			<div class="check-order-invoice nopjax ecjia-form" href="javascript:;">
				<ul class="attr-bgcolr">
					<li class="b_no ecjia-margin-b">
						<label>
							{t}是否需要开发票{/t}
							<input class="input" id="ECS_NEEDINV" name="need_inv" data-trigger="checkbox" type="checkbox" value="1"  {if $order.need_inv}checked="true"{/if} data-toggle="click_need_inv" data-url="{url path='cart/flow/change_needinv'}"/>
						</label>
					</li>
					<!-- {if $inv_type_list} -->
					<li class="ecjia-margin-b">
						{$lang.invoice_type}:
						<select class="form-select ecjiaf-fl" id="ECS_INVTYPE" name="inv_type"  data-toggle="change_need_inv" data-url="{url path='cart/flow/change_needinv'}">
							{html_options options=$inv_type_list selected=$order.inv_type}
						</select>
					</li>
					<!-- {/if} -->
					<li class="ecjia-margin-b">
						<input class="input" name="inv_payee" type="text"  placeholder="{$lang.please_invoice_title}" size="20" value="{$order.inv_payee}" data-toggle="blur_need_inv" data-url="{url path='cart/flow/change_needinv'}" />
					</li>
					<li class="ecjia-margin-b">
						<div class="form-select ecjiaf-fl">
							{$lang.invoice_content}:
							<select class="from-select" id="ECS_INVCONTENT" name="inv_type"  data-toggle="change_need_inv" data-url="{url path='cart/flow/change_needinv'}">
								{html_options values=$inv_content_list output=$inv_content_list selected=$order.inv_content}
							</select>
						</div>
					</li>
				</ul>
			</div>
			<!--{/if}-->
			<!-- {if $allow_use_bonus and $bonus_list} 是否使用红包 -->
			<a class="select nopjax" href="javascript:;">
				<p>
					<span>{$lang.use_bonus}</span>
					<i class="iconfont icon-jiantou-bottom"></i>
					<span class="ecjiaf-fr select_nav">{$lang.no_use_bonus}</span>
				</p>
			</a>
			<div>
				<ul class="ecjia-list attr-bgcolr">
					<li>
						<label for="bonus_{$bonus.bonus_id}">
							<input data-trigger="radio" class="cart-check-radio" id="bonus_{$bonus.bonus_id}"  name="bonus"  type="radio" value="0" {if $order.bonus_id eq 0}checked="true"{/if} data-toggle="change_bonus" data-url="{url path='cart/flow/change_bonus'}">
							{$lang.no_use_bonus}
							<i></i>
						</label>
					</li>
					<!-- {foreach from=$bonus_list item=bonus} 循环红包 -->
					<li>
						<label for="bonus_{$bonus.bonus_id}">
							<input data-trigger="radio" class="cart-check-radio" id="bonus_{$bonus.bonus_id}" name="bonus" type="radio" value="{$bonus.bonus_id}" {if $order.bonus_id eq $bonus.bonus_id}checked="true"{/if} data-toggle="change_bonus" data-url="{url path='cart/flow/change_bonus'}" />
							{$bonus.type_name}[{$bonus.bonus_money_formated}]
						</label>
					</li>
					<!-- {/foreach} 循环红包 -->
				</ul>
			</div>
			<!-- {/if} 是否使用红包 -->
			<!-- {if $allow_use_surplus} 是否使用余额 -->
			<a class="select nopjax" href="javascript:;">
				<p>
					<span>{$lang.use_surplus}</span>
					<i class="iconfont icon-jiantou-bottom"></i>
				</p>
			</a>
			<div>
				<ul class="ecjia-list" >
					<li><label>{$lang.your_surplus}：{$your_surplus|default:0}</label></li>
					<li><label><input name="surplus" type="text" size="10" value="{$order.surplus|default:0}" data-toggle="change_surplus" data-url="{url path='cart/flow/change_surplus'}"/></label></li>
				</ul>
			</div>
			<!-- {/if} 是否使用余额 -->

			<!-- {if $allow_use_integral} 是否使用积分 -->
			<a class="select nopjax" href="javascript:;">
				<p>
					<span>{$lang.use_integral}</span>
					<i class="iconfont icon-jiantou-bottom"></i>
				</p>
			</a>
			<div>
				<ul class="ecjia-list">
					<li>{$lang.can_use_integral}:{$your_integral|default:0} {$points_name}，{$lang.noworder_can_integral}{$order_max_integral}  {$points_name}积分</li>
					<li><input name="integral" type="text" value="{$order.integral|default:0}" size="10" data-toggle="change_integral" data-url="{url path='cart/flow/change_integral'}"/></li>
				</ul>
			</div>
			<!-- {/if} 是否使用积分 -->

		</section>
		<section class="ecjia-margin-t checkout-select checkout-pro-list">
			<!-- #BeginLibraryItem "/Library/order_total.lbi" -->
			<!-- #EndLibraryItem -->
		</section>

		<section class="ecjia-margin-t ecjia-margin-b">
			<input type="hidden" class="hidden_rec_id" value="{$rec_id}">
			<input class="btn btn-info" name="submit" type="submit" value="{$lang.order_submit}"/>
			<input name="step" type="hidden" value="done" />
		</section>
	</form>
</div>
<!-- {/block} -->
