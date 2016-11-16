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

		<section class="flow-goods-list ecjia-margin-b">
			<ul class="goods-item">
				<!-- {foreach from=$goods_list item=goods} -->
				<li class="ecjia-margin-b">
					<div class="ecjiaf-fl goods-img">
						<img src="{$goods.goods_img}"/>
					</div>
					<div class="ecjiaf-fl goods-info">
						<p class="ecjia-truncate2">{$goods.goods_name}</p>
						<p>{$goods.formated_goods_price}</p>
					</div>
					<span class="ecjiaf-fr"> X {$goods.goods_number}</span>
				</li>
				<!-- {/foreach} -->
			</ul>
			<ul class="goods-list">
				<!-- {foreach from=$goods_list item=goods} -->
				<li class="goods-img ecjiaf-fl ecjia-margin-r  ecjia-icon">
					<img src="{$goods.goods_img}" />
					<span class="ecjia-icon-num top">{$goods.goods_number}</span>
				</li>
				<!-- {/foreach} -->
			</ul>
		</section>

		<section class="checklist">
			<a href="{url path='cart/flow/pay'}">
				<span>{$lang.shipping_method}</span>
				<i class="iconfont icon-jiantou-right"></i>
				<span class="ecjiaf-fr select_nav ecjia-truncate">{$shipping_default}</span>
			</a>
		</section>
		<section class="checklist">
			<a href="{url path='cart/flow/shipping'}">
				<span>{$lang.payment_method}</span>
				<i class="iconfont icon-jiantou-right"></i>
				<span class="ecjiaf-fr select_nav ecjia-truncate">{$payment_default}</span>
			</a>
		</section>
		<section class="checklist error">
			<a href="{url path='cart/flow/invoice'}">
				<span>{$lang.invoice}</span>
				<i class="iconfont icon-jiantou-right"></i>
				<span class="ecjiaf-fr select_nav ecjia-truncate">{$shipping_default}</span>
			</a>
		</section>
		<section class="checklist">
			<a href="{url path='cart/flow/note'}">
				<span>备注留言</span>
				<i class="iconfont icon-jiantou-right"></i>
				<span class="ecjiaf-fr select_nav ecjia-truncate">{$shipping_default}</span>
			</a>
		</section>
		<section class="checklist">
			<a href="{url path='cart/flow/bonus'}">
				<span>{$lang.use_integral}</span>
				<i class="iconfont icon-jiantou-right"></i>
				<span class="ecjiaf-fr select_nav ecjia-truncate">{$shipping_default}</span>
			</a>
		</section>
		<section class="checklist ecjia-margin-b">
			<a href="{url path='cart/flow/integral'}">
				<span>{$lang.use_bonus}</span>
				<i class="iconfont icon-jiantou-right"></i>
				<span class="ecjiaf-fr select_nav ecjia-truncate">{$shipping_default}</span>
			</a>
		</section>


	</form>
</div>
<div class="flow-checkout">
	<form id="theForm" name="theForm" action="{url path='flow/done'}" method="post">

{if 0}

		<section class="checkout-select checkout-pro-list ecjia-margin-t">
			<li class="order-check"><input name="postscript" type="text" placeholder="{t}给卖家留言{/t}"></li>
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
		{/if}
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
