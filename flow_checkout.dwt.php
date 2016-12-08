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
<!-- #EndLibraryItem -->
<div class="ecjia-checkout ecjia-padding-b">
	<form id="theForm" name="theForm" action="{url path='flow/done'}" method="post">
		<div class="flow-address ecjia-margin-b">
			<label class="ecjiaf-fl">送至：</label>
			<div class="ecjiaf-fl address-info">
				<span>{$data.consignee.consignee|escape}</span>
				<span>{$data.consignee.mobile}</span>
				<p class="ecjia-truncate2 address-desc">{$data.consignee.address}{$data.consignee.address_info}</p>
			</div>
		</div>

		<section class="flow-goods-list ecjia-margin-b">
			<a href='{url path="cart/flow/goods_list" args="address_id={$address_id}&rec_id={$rec_id}"}'>
			<ul class="{if count($data.goods_list) > 1}goods-list{else}goods-item{/if}"><!-- goods-list 多个商品隐藏商品名称,goods-item -->
				<!-- {foreach from=$data.goods_list item=goods name=goods} -->
				<!-- {if $smarty.foreach.goods.iteration gt 3} -->
				<!-- 判断不能大于4个 -->
				<li class="goods-img-more">
					<i class="icon iconfont">&#xe62e;</i>
					<p class="ecjiaf-ib">共{$total_goods_number}件</p>
					<i class="icon iconfont icon-right">&#xe6aa;</i>
				</li>
				<!-- {break} -->
				<!-- {/if} -->
				<li class="goods-img ecjiaf-fl ecjia-margin-r ecjia-icon">
					<img class="ecjiaf-fl" src="{$goods.img.thumb}" alt="{$goods.goods_name}" title="{$goods.goods_name}" />
					{if $goods.goods_number gt 1}<span class="ecjia-icon-num top">{$goods.goods_number}</span>{/if}
					<span class="ecjiaf-fl goods-name ecjia-truncate2">{$goods.goods_name}</span>
				</li>
				<!-- {/foreach} -->
			</ul>
			</a>
		</section>

		<section class="checklist">
			<a href='{url path="cart/flow/pay" args="address_id={$address_id}&rec_id={$rec_id}&pay_id={$selected_payment.pay_id}"}'>
				<span>{$lang.payment_method}</span>
				<i class="iconfont icon-jiantou-right"></i>
				<span class="ecjiaf-fr select_nav ecjia-truncate">{$selected_payment.pay_name}</span>
				<input type="hidden" name="pay_id" value="{$selected_payment.pay_id}" />
			</a>
		</section>
		<section class="checklist">
			<a href='{url path="cart/flow/shipping" args="address_id={$address_id}&rec_id={$rec_id}&shipping_id={$selected_shipping.shipping_id}"}'>
				<span>{$lang.shipping_method}</span>
				<i class="iconfont icon-jiantou-right"></i>
				<span class="ecjiaf-fr select_nav ecjia-truncate">{$selected_shipping.shipping_name}</span>
				<input type="hidden" name="shipping_id" value="{$selected_shipping.shipping_id}" />
			</a>
		</section>
		<section class="checklist "><!-- error -->
			<a href='{url path="cart/flow/invoice" args="address_id={$address_id}&rec_id={$rec_id}"}'>
				<span>发票信息<!-- invoice --></span>
				<i class="iconfont icon-jiantou-right"></i>
				<span class="ecjiaf-fr select_nav ecjia-truncate">{$temp.inv_payee} {$temp.inv_content} {$temp.inv_type}</span>
				<input type="hidden" name="inv_payee" value="{$temp.inv_payee}" />
				<input type="hidden" name="inv_content" value="{$temp.inv_content}" />
				<input type="hidden" name="inv_type" value="{$temp.inv_type}" />
			</a>
		</section>
		<section class="checklist ecjia-margin-b">
			<a href='{url path="cart/flow/note" args="address_id={$address_id}&rec_id={$rec_id}"}'>
				<span>备注留言</span>
				<i class="iconfont icon-jiantou-right"></i>
				<span class="ecjiaf-fr select_nav ecjia-truncate">{$temp.note}</span>
				<input type="hidden" name="note" value="{$temp.note}" />
			</a>
		</section>
		
		{if $data.allow_use_bonus}
		<section class="checklist">
			<a href='{url path="cart/flow/bonus" args="address_id={$address_id}&rec_id={$rec_id}"}'>
				<span>{$lang.use_bonus}</span>
				<span class="ecjia-tag">无可用</span>
				<i class="iconfont icon-jiantou-right"></i>
				<!-- <span class="ecjiaf-fr select_nav ecjia-truncate">xxx红包</span> -->
			</a>
		</section>
		{/if}
		{if $data.allow_use_integral}
		<section class="checklist ecjia-margin-b">
				{if $data.order_max_integral eq 0}
				<a href='javascript:;' title="不可用">
				    <span class="ecjia-color-999">{$lang.use_integral}</span>
				    <span class="ecjia-tag">不可用</span>
				</a>
				{else}
				<a href='{url path="cart/flow/integral" args="address_id={$address_id}&rec_id={$rec_id}"}'>
				    <span>{$lang.use_integral}</span>
    				{if $temp.integral lte 0}<span class="ecjia-tag">{$data.your_integral}积分可用</span>{/if}
    				<i class="iconfont icon-jiantou-right"></i>
    				{if $temp.integral gt 0}
    				<span class="ecjiaf-fr select_nav ecjia-truncate">{$temp.integral}积分</span>
    				<input type="hidden" name="integral" value="{$temp.integral}" />
    				{/if}
				</a>
				{/if}
				
			
		</section>
		{/if}

		<section class="ecjia-margin-t checkout-select checkout-pro-list">
			<!-- #BeginLibraryItem "/library/order_total.lbi" --><!-- #EndLibraryItem -->
		</section>
		<p class="ecjia-margin-t ecjia-margin-l ecjia-color-green">本订单由{$data.goods_list.0.seller_name}发货并提供售后服务</p>

		<section class="ecjia-margin-t">
			<input type="hidden" name="rec_id" value="{$rec_id}">
			<input type="hidden" name="address_id" value="{$address_id}">
			<input class="btn btn-info" name="submit" type="submit" value="提交订单"/>
			<input name="step" type="hidden" value="done" />
		</section>
	</form>
</div>

{if 0}
<div class="flow-checkout">
	<form id="theForm" name="theForm" action="{url path='flow/done'}" method="post">
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
	</form>
</div>
{/if}
<!-- {/block} -->
