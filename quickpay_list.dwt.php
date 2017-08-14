<?php
/*
Name: 获取全部订单模板
Description: 获取全部订单页
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
	<ul class="ecjia-margin-b" id="J_ItemList">
		<!-- 订单异步加载 -->
		<li class="ecjia-order-item ecjia-checkout ecjia-margin-t">
        	<div class="order-hd">
        		<a class="ecjiaf-fl" href='{url path="merchant/index/init" args="store_id={$list.seller_id}"}'>
        			<i class="iconfont icon-shop"></i>天天果园 <i class="iconfont icon-jiantou-right"></i>
        		</a>
        		<a class="ecjiaf-fr" href='{url path="user/order/order_detail" args="order_id={$list.order_id}"}'><span class="ecjia-color-green">买单成功</span></a>
        	</div>
        	<div class="flow-goods-list">
        		<a class="ecjiaf-db" href='{url path="user/quickpay/quickpay_detail"}'>
        			<ul class="quickpay-info-list">
        				<li class="goods-img ecjiaf-fl ecjia-margin-r ecjia-icon quickpay-w">
        					<img class="ecjiaf-fl" src="https://cityo2o.ecjia.com/content/uploads/images/201606/goods_img/1045_G_1465321882351.jpg" alt="{$goods.name}" title="{$goods.name}" />
        				    <ul>
        				        <li class="quickpay-info-li">
        				            <span class="quickpay-info">订单编号</span>2234253453342
        				        </li>
        				        <li class="quickpay-info-li">
        				            <span class="quickpay-info">优惠金额</span>￥10.00
        				        </li>
        				        <li class="quickpay-info-li">
        				            <span class="quickpay-info">实付金额</span>￥490.00
        				        </li>
        				        <li class="quickpay-info-li">
        				            <span class="quickpay-info">买单时间</span>2017-05-07 22:27
        				        </li>
        				    </ul>
        				</li>
        			</ul>
        		</a>
        	</div>
        </li>
	</ul>
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->

<!-- {/block} -->
{/nocache}