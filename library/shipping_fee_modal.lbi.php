<?php
/*
Name: 配送费说明
Description: 这是配送费说明弹窗
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-shipping-fee-modal">
	<div class="modal-inners">
		<div class="title">配送费说明</div>
		<div class="item">
			<span class="item-left">总计</span>
			<span class="item-right big-font">￥5.00</span>
		</div>
		<div class="item">
			<div class="item-li">
				<span class="item-left">运费</span><span class="item-right">￥4.50</span>
			</div>
			<div class="item-li">
				<span class="item-left">包装费</span><span class="item-right">￥0.50</span>
			</div>
		</div>
		<div class="item">
			<div class="notice-title">说明</div>
			<div class="notice">运费：原订单实际支付的运费金额</div>
		</div>
	</div>
</div>
<div class="ecjia-shipping-fee-overlay ecjia-shipping-fee-overlay-visible"></div>

