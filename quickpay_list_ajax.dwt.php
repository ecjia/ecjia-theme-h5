<?php
/*
Name: 获取全部订单模板
Description: 获取全部订单页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
<!-- {foreach from=$data item=list} -->
<li class="ecjia-order-item ecjia-checkout ecjia-margin-t">
	<div class="order-hd">
		<a class="ecjiaf-fl nopjax external" href='{url path="merchant/index/init" args="store_id={$list.store_id}"}'>
			<i class="iconfont icon-shop"></i>{$list.store_name} <i class="iconfont icon-jiantou-right"></i>
		</a>
		<a class="ecjiaf-fr" href='{url path="user/quickpay/quickpay_detail" args="order_id={$list.order_id}"}'><span class="{if $list.order_status_str eq 'paid'}ecjia-color-green{else}ecjia-color-red{/if}">{$list.label_order_status}</span></a>
	</div>
	<div class="flow-goods-list">
		<a class="ecjiaf-db" href='{url path="user/quickpay/quickpay_detail" args="order_id={$list.order_id}"}'>
			<ul class="quickpay-info-list">
				<li class="goods-img ecjiaf-fl ecjia-margin-r ecjia-icon quickpay-w">
					<img class="ecjiaf-fl" src="{$list.store_logo}" alt="{$list.store_name}" title="{$list.store_name}" />
				    <ul>
				        <li class="quickpay-info-li">
				            <span class="quickpay-info">{t domain="h5"}订单编号{/t}</span>{$list.order_sn}
				        </li>
				        <li class="quickpay-info-li">
				            <span class="quickpay-info">{t domain="h5"}优惠金额{/t}</span>{$list.formated_total_discount}
				        </li>
				        <li class="quickpay-info-li">
				            <span class="quickpay-info">{t domain="h5"}实付金额{/t}</span>{$list.formated_order_amount}
				        </li>
				        <li class="quickpay-info-li">
				            <span class="quickpay-info">{t domain="h5"}买单时间{/t}</span>{$list.formated_add_time}
				        </li>
				    </ul>
				</li>
			</ul>
		</a>
	</div>
</li>
<!-- {/foreach} -->		
<!-- {/block} -->
{/nocache}