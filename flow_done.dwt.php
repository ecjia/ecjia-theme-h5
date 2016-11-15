<?php 
/*
Name: 提交订单结算模板
Description: 提交订单结算页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.goods.init();</script>
<!-- {/block} -->

<!-- {block name="ecjia"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<section class="flow-done"> 
	<div class="done-message">
		<i class="iconfont icon-check"></i>
		<p>{t}感谢您在本店购物！您的订单已提交成功！{/t}</p>
	</div>
	<p>
		{$lang.remember_order_number}
		<b>{$order.order_sn}</b>
	</p>
	<p>
		<!--{if $order.shipping_name}-->
		{$lang.select_shipping}：
		<b>{$order.shipping_name}</b>
		<!--{/if}-->
	</p>
	<p>
		{$lang.order_amount}：
		<b>{$total.amount_formated}</b>
	</p>
	<!--{if $virtual_card}-->
	<div class="alert alert-warning" role="alert">
		<!--{foreach from=$virtual_card item=vgoods}-->
		<h3 style="color:#2359B1; font-size:15px;">{$vgoods.goods_name}</h3>
		<!--{foreach from=$vgoods.info item=card}-->
		<ul style="list-style:none;padding:0;margin:0;clear:both">
			<!--{if $card.card_sn}-->
			<li> 
				<strong>{$lang.card_sn}：</strong>
				<span style="color:red;">{$card.card_sn}</span>
			</li>
			<!--{/if}-->
			<!--{if $card.card_password}-->
			<li> 
				<strong>{$lang.card_password}：</strong>
				<span style="color:red;">{$card.card_password}</span>
			</li>
			<!--{/if}-->
			<!--{if $card.end_date}-->
			<li>
				<strong>{$lang.end_date}：</strong>
				{$card.end_date}
			</li>
			<!--{/if}-->
		</ul>
		<!--{/foreach}-->
		<!--{/foreach}-->
	</div>
	<!-- {/if} -->
	<!-- <p class="text-center">{$order_submit_back}</p> -->
</section>
<section class="ecjia-margin-t">
	<!-- {if $pay_online} -->
	<p class="text-center nopjax">{$pay_online}</p>
	<!-- {else} -->
	<div class="two-btn cart-flow-done">
		<a class="btn btn-info" href="{url path='user/user_order/order_list&status=unshipped'}">查看订单</a>
		<a class="btn btn-info flow-done-shop" href="{url path='touch/index/init'}">继续购物</a>
	</div>
	<!--{/if}-->
</section>
<!-- {/block} -->