<?php
/*
Name: 售后详情模板
Description: 这是售后详情页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.cancel_order();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="ecjia-order-detail">
	<div class="ecjia-checkout ecjia-margin-b">
		<div class="flow-goods-list">
		    <div class="order-status-head">
		    <a href="{url path='user/order/return_detail'}&order_id={$order_id}&type={'status'}">
		        <span class="order-status-img"><p></p><img src="{$theme_url}images/icon/list_h_circle_50.png"></span>
		        <div class="order-status-msg">
    		        <span><span class="order-head-font">{$headInfo.order_status}</span><span class="ecjiaf-fr order-color">{$headInfo.time}</span></span>
    		        <p class="ecjia-margin-t h-1"><span class="order-color order-status">{$headInfo.message}</span><span class="ecjiaf-fr order-more-color">更多状态 ></span></p>
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
			
				<li>
				    <a href='{url path="goods/index/show" args="goods_id={$goods.goods_id}"}'>
						<div class="ecjiaf-fl goods-img">
							<img src="" alt="{$goods.name}" title="{$goods.name}" />
						</div>
						<div class="ecjiaf-fl goods-info">
							<p class="ecjia-truncate2">精品红霞草莓32粒</p>
							<p class="ecjia-goods-attr goods-attr">
							<!-- {foreach from=$goods.goods_attr item=attr} -->
							{if $attr.name}{$attr.name}:{$attr.value}{/if}
							<!-- {/foreach} -->
							</p>
							<p class="ecjia-color-red goods-attr-price">￥19.90</p>
						</div>
						<span class="ecjiaf-fr goods-price"> x 1</span>
					</a>
				</li>
			</ul>
			
			<div class="return-item">
				<div class="c9">
					<p><i class="c6">¥6.01</i><b>退商品金额</b></p>
					<p><i class="c6">¥6.01</i><b>退配送费</b><i class="k0"></i></p>
					<p><i class="c6 ecjia-red">¥6.01</i><b>退总金额</b></p>
					<p class="ca"><span>温馨提示:</span><b>退商品金额是按照您实际支付的商品金额进行退回，如有问题，请联系商家到家客服。</b></p>
				</div>
			</div>
			
			<p class="select-title ecjiaf-fwb ecjia-margin-l">问题描述</p>
			<div class="co">
				<p class="cp"><span>售后原因：</span><b>误购</b></p>
				<p class="cp"><span>问题描述：</span><b>没看清，不好意思</b></p>
				<p class="cq">
					<span>售后图片：</span>
					<b>
						<img src="{$theme_url}images/no_goods.png">
						<img src="{$theme_url}images/no_goods.png">
						<img src="{$theme_url}images/no_goods.png">
						<img src="{$theme_url}images/no_goods.png">
						<img src="{$theme_url}images/no_goods.png">
					</b>
				</p>
			</div>
			
			<p class="select-title ecjiaf-fwb ecjia-margin-l">取货信息</p>
			<div class="co">
				<p class="cp"><span>取货方式：</span><b>上门取货</b></p>
				<p class="cp"><span>取货时间：</span><b>2017-12-27 14:00-14:30</b></p>
				<p class="cp"><span>取货地址：</span><b>上海市普陀区长风街道伸大厦301室</b></p>
			</div>

			<div class="order-ft-link">
				<a class="btn btn-small btn-hollow external" href="{if $order.service_phone}tel://{$order.service_phone}{else}javascript:alert('无法联系卖家');{/if}">联系卖家</a>
				<a class="btn btn-small btn-hollow undo_reply" href='{url path="user/order/undo_reply" args="order_id={$order.order_id}"}'>撤销申请</a>
			</div>
		</div>
	</div>
	<input type="hidden" name="reason_list" value='{$reason_list}'>
</div>
<!-- {/block} -->