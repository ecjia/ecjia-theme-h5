<?php
/*
Name: 获取全部订单模板
Description: 获取全部订单页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	{foreach from=$lang.merge_order_js item=item key=key}
		var {$key} = "{$item}";
	{/foreach}
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div class="ecjia-order-list ">
	<ul class="ecjia-margin-b">
		<li class="ecjia-order-item ecjia-checkout ecjia-margin-t">
			<div class="order-hd">
				<i class="iconfont icon-shop"></i>华联-申隆店专营店 <i class="iconfont icon-jiantou-right"></i>
				<span class="ecjiaf-fr">待收货</span>
			</div>
			<div class="flow-goods-list">
				<ul class="goods-list">
					<li class="goods-img ecjiaf-fl ecjia-margin-r  ecjia-icon">
						<img class="ecjiaf-fl" src="http://www.ecjia-city.dev/content/uploads/images/201611/thumb_img/1020_G_1479340294572.jpg" alt="" />
						<span class="ecjia-icon-num top">1</span>
						<span class="ecjiaf-fl goods-name ecjia-truncate2">爱大厨四菜私人厨师上门做饭</span>
					</li>
				</ul>
			</div>
			<div class="order-ft">
				<span>订单金额：￥155.50</span>
				<span class="two-btn ecjiaf-fr">
					<a class="btn  ecjiaf-fr" href="#">确认收货</a>
					<a class="btn  ecjiaf-fr" href="#">再次购买</a>
				</span>
			</div>
		</li>

		<li class="ecjia-order-item ecjia-checkout ecjia-margin-t">
			<div class="order-hd">
				<i class="iconfont icon-shop"></i>华联-申隆店专营店 <i class="iconfont icon-jiantou-right"></i>
				<span class="ecjiaf-fr">待收货</span>
			</div>
			<div class="flow-goods-list">
				<ul class="goods-item">
					<li class="goods-img ecjiaf-fl ecjia-margin-r  ecjia-icon">
						<img class="ecjiaf-fl" src="http://www.ecjia-city.dev/content/uploads/images/201611/thumb_img/1020_G_1479340294572.jpg" alt="" />
						<span class="ecjia-icon-num top">1</span>
						<span class="ecjiaf-fl goods-name ecjia-truncate2">爱大厨四菜私人厨师上门做饭</span>
					</li>
				</ul>
			</div>
			<div class="order-ft">
				<span>订单金额：￥155.50</span>
				<span class="two-btn ecjiaf-fr">
					<a class="btn  ecjiaf-fr" href="#">再次购买</a>
				</span>
			</div>
		</li>
	</ul>
</div>
<ul class="ecjia-list ecjia-list-four ecjia-nav">
	<li{if $status eq 'unpayed'} class="active"{/if}><a data-rh="1" href="{url path='user_order/order_list' args='status=unpayed'}">{t}待付款{/t}</a></li>
	<li{if $status eq 'unshipped'} class="active"{/if}><a data-rh="1" href="{url path='user/user_order/order_list' args='status=unshipped'}">{t}待发货{/t}</a></li>
	<li{if $status eq 'confiroed'} class="active"{/if}><a data-rh="1" href="{url path='user/user_order/order_list' args='status=confiroed'}">{t}待确认{/t}</a></li>
	<li{if $status eq 'success_order'} class="active"{/if}><a data-rh="1" href="{url path='user/user_order/order_list' args='status=success_order'}">{t}已完成{/t}</a></li>
</ul>
<div>
	<ul class="ecjia-list user-order-list ecjia-margin-b" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user_order/async_order_list' args="status={$status}"}" data-size="10" data-pay="1">
		<!-- 用户订单 start-->
		<li class="ecjia-margin-t ecjia-order">

		</li>
		<!-- 用户订单end-->
	</ul>
	<!-- {$page} -->
</div>
<!-- {/block} -->
<!-- {block name="ajaxinfo"} -->
<!-- {foreach from=$order item=orders} 循环订单列表 -->
	<li class="ecjia-margin-t">
		<div class="hd">
			<p>{$orders.order_time}</p>
			<p class="order-status">{$orders.order_status}</p>
		</div>
		<a href="{url path='user_order/order_detail' args="order_id={$orders.order_id}" }">
			<div class="bd">
				<div class="order-goods-img">
					<img src="{$orders.img}">
				</div>
				<div  class="order-goods-sort">
					<p>{$orders.goods_name}</p>
					<p class="price-num">{t}价格{/t}：<span>{$orders.goods_price}</span></p>
				</div>
			</div>
		</a>
		<div class="order-list-foot">
			<p>{t}共{/t}{$orders.goods_number}{t}件商品{/t}</p>
			<p class="sum-goods-price">{t}合计{/t}：<span>{$orders.order_price.formated_total_fee}</span></p>
			<div class="order-bottom-btn{if $orders.handler} two-btn{/if}">
				{if $orders.handler}{$orders.handler}{/if}
				<a class='btn nopjax' href="{url path='user_order/order_detail' args="order_id={$orders.order_id}" }">{t}查看详情{/t}</a>
			</div>

		</div>
	</li>
<!-- {foreachelse} -->
<div class="ecjia-nolist">
	<i class="iconfont icon-icon04"></i>
	<p>{t}您还没有订单~{/t}</p>
</div>
<!-- {/foreach} -->
<!-- {/block} -->
