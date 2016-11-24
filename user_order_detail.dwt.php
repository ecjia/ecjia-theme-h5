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
		<div class="order-log-item">
			<div class="order-log">
				<span>已发货</span><span class="ecjiaf-fr order-time">2016-11-18 13:20</span>
				<p>订单号为20142312324的商品已发货，请您耐心等待</p>
			</div>
		</div>
		<div class="order-log-item">
			<div class="order-log">
				<span>已发货</span><span class="ecjiaf-fr order-time">2016-11-18 13:20</span>
				<p>订单号为20142312324的商品已发货，请您耐心等待</p>
			</div>
		</div>
		<div class="order-log-item">
			<div class="order-log">
				<span>已发货</span><span class="ecjiaf-fr order-time">2016-11-18 13:20</span>
				<p>订单号为20142312324的商品已发货，请您耐心等待</p>
			</div>
		</div>
	</div>
	<div class="ecjia-checkout goods-describe ecjia-margin-b" id="two">
		<div class="flow-goods-list">
			<ul class="goods-item">
				<li>
					<div class="ecjiaf-fl goods-img">
						<img src="http://www.ecjia-city.dev/content/uploads/images/201611/goods_img/1065_G_1479324537953.jpg">
					</div>
					<div class="ecjiaf-fl goods-info">
						<p class="ecjia-truncate2">乌金石茶盘组合配套干泡小茶盘水果盘茶具茶海杯垫原创设计</p>
						<p>￥168.00</p>
					</div>
					<span class="ecjiaf-fr goods-price"> X 1</span>
				</li>
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
