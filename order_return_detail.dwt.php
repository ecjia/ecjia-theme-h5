<?php
/*
Name: 售后详情模板
Description: 这是售后详情页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.return_order();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="ecjia-order-detail">
	<div class="ecjia-checkout ecjia-margin-b">
		<div class="flow-goods-list">
			<div class="order-status-head">
			    <a href="{url path='user/order/return_detail'}&refund_sn={$order.refund_sn}&type={'status'}">
			        <span class="order-status-img"><p></p><img src="{$theme_url}images/address_list/50X50_2.png"></span>
			        <div class="order-status-msg">
	    		        <span><span class="order-head-font">{if $refund_logs.log_description}{$refund_logs.log_description}{else}暂无{/if}</span><span class="ecjiaf-fr order-color">{$refund_logs.formatted_action_time}</span></span>
	    		        <p class="ecjia-margin-t status"><span class="order-color order-status">操作员：{$refund_logs.action_user}</span><span class="ecjiaf-fr more-status">更多状态 ></span></p>
			        </div>
		        </a>
	        </div>

		    <ul class="goods-item">
				<!-- {foreach from=$order.goods_list item=goods} -->
				<li>
				    <a href='{url path="goods/index/show" args="goods_id={$goods.goods_id}"}'>
					<div class="ecjiaf-fl goods-img">
						<img src="{$goods.img.thumb}" alt="{$goods.name}" title="{$goods.name}" />
					</div>
					<div class="ecjiaf-fl goods-info">
						<p class="ecjia-truncate2">{$goods.name}</p>
						<p class="ecjia-goods-attr goods-attr">
						<!-- {foreach from=$goods.goods_attr item=attr} -->
						{if $attr.name}{$attr.name}:{$attr.value}{/if}
						<!-- {/foreach} -->
						</p>
						<p class="ecjia-color-red goods-attr-price">{$goods.formated_shop_price}</p>
					</div>
					<span class="ecjiaf-fr goods-price"> x {$goods.goods_number}</span>
					</a>
				</li>
				<!-- {/foreach} -->
			</ul>
			
			<div class="return-item">
				<div class="c9">
					<p><i class="c6">{$order.refund_goods_amount}</i><b>退商品金额</b></p>
					<p><i class="c6">{$order.shipping_fee}</i><b>退配送费</b><i class="k0 shipping_fee_notice"></i></p>
					<p><i class="c6 ecjia-red">{$order.refund_total_amount}</i><b>退总金额</b></p>
					<p class="ca"><span>温馨提示:</span><b>退商品金额是按照您实际支付的商品金额进行退回，如有问题，请联系商家到家客服。</b></p>
				</div>
			</div>
			
			<p class="select-title ecjiaf-fwb ecjia-margin-l">问题描述</p>
			<div class="co">
				<p class="cp"><span>售后原因：</span><b>{$order.reason}</b></p>
				<p class="cp"><span>问题描述：</span><b>暂无</b></p>
				{if $order.return_images}
				<p class="cq">
					<span>售后图片：</span>
					<b>
						<!-- {foreach from=$order.return_images item=img} -->
						<img src="{$img}">
						<!-- {/foreach} -->
					</b>
				</p>
				{/if}
			</div>
			
			{if $order.selected_returnway_info}
			<p class="select-title ecjiaf-fwb ecjia-margin-l">取货信息{$order.refund_type}</p>
			<div class="co">
				<p class="cp"><span>取货方式：</span><b>{$order.selected_returnway_info.return_way_name}</b></p>
				<p class="cp"><span>取货时间：</span><b>{$order.selected_returnway_info.expect_pickup_time}</b></p>
				<p class="cp"><span>取货地址：</span><b>{$order.selected_returnway_info.pickup_address}</b></p>
			</div>
			{/if}

			<div class="order-ft-link">
				{if $order.status eq 'canceled'}
				<span class="canceled">本次申请已撤销</span>
				{else}
				<a class="btn btn-small btn-hollow external" href="{if $order.store_service_phone}tel://{$order.store_service_phone}{else}javascript:alert('无法联系卖家');{/if}">联系卖家</a>
				{/if}
				
				{if $order.refund_type eq 'refund' && $order.refund_status neq 'refunded'}
					{if $order.status eq 'agree' || $order.refund_status eq 'refunded'}
						<a class="btn btn-small btn-hollow external" href="{url path='user/order/return_detail'}&refund_sn={$order.refund_sn}&type=return_money">退款详情</a>
					{/if}
					
					{if $order.status eq 'agree' || $order.status eq 'uncheck'}
						<a class="btn btn-small btn-hollow undo_reply" href='{url path="user/order/undo_reply" args="order_id={$order_id}&refund_sn={$order.refund_sn}"}'>撤销申请</a>
					{/if}
					
					{if $order.status eq 'refused'}
						<a class="btn btn-small btn-hollow" href='{url path="user/order/return_reply" args="order_id={$order_id}"}'>重新申请</a>
					{/if}
				{/if}
				
				{if $order.refund_type eq 'return' && $order.refund_status neq 'refunded'}
					{if $order.status eq 'uncheck' || $order.status eq 'agree'}
						<a class="btn btn-small btn-hollow undo_reply" href='{url path="user/order/undo_reply" args="order_id={$order_id}&refund_sn={$order.refund_sn}"}'>撤销申请</a>
					{/if}
					
					{if $order.status eq 'agree'}
						<a class="btn btn-small btn-hollow data-pjax" href='{url path="user/order/return_way_list" args="refund_sn={$order.refund_sn}"}'>返还方式</a>
					{/if}
					
					{if $order.status eq 'refused'}
						<a class="btn btn-small btn-hollow" href='{url path="user/order/return_reply" args="order_id={$order_id}"}'>重新申请</a>
					{/if}
				{/if}
				
				{if $order.refund_status eq 'refunded'}
					<a class="btn btn-small btn-hollow external" href="{url path='user/order/return_detail'}&refund_sn={$order.refund_sn}&type=return_money">退款详情</a>
				{/if}
			</div>
		</div>
	</div>
	<input type="hidden" name="reason_list" value='{$reason_list}'>
</div>
<!-- #BeginLibraryItem "/library/shipping_fee_modal.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->
{/nocache}