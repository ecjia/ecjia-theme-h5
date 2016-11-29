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
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
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
				<li>商品金额:<span class="ecjiaf-fr">￥155.50</span></li>
				<li>商品金额:<span class="ecjiaf-fr">￥155.50</span></li>
				<li>商品金额:<span class="ecjiaf-fr">￥155.50</span></li>
				<li>商品金额:<span class="ecjiaf-fr">￥155.50</span></li>
				<li>商品金额:<span class="ecjiaf-fr">￥155.50</span></li>
				<li>商品金额:<span class="ecjiaf-fr">￥155.50</span></li>
				<li>商品金额:<span class="ecjiaf-fr">￥155.50</span></li>
				<li>商品金额:<span class="ecjiaf-fr">￥155.50</span></li>
			</ul>
			<div class="order-ft-link">
				<a class="btn btn-small" href="#">联系卖家</a>
				<a class="btn btn-small" href="#">再次购买</a>
				<a class="btn btn-small" href="#">取消订单</a>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->
