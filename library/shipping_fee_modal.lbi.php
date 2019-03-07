<?php
/*
Name: 配送费说明
Description: 这是配送费说明弹窗
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-shipping-fee-modal">
	<div class="modal-inners">
		<div class="title">{t domain="h5"}配送费说明{/t}</div>
		<div class="item">
			<span class="item-left">{t domain="h5"}总计{/t}</span>
			<span class="item-right big-font"></span>
		</div>
		<div class="item">
			<div class="item-li">
				<span class="item-left">{t domain="h5"}配送费{/t}</span><span class="item-right"></span>
			</div>
			<div class="item-li">
				<span class="item-left">{t domain="h5"}保价费{/t}</span><span class="item-right"></span>
			</div>
		</div>
		<div class="item">
			<div class="notice-title">{t domain="h5"}说明{/t}</div>
			<div class="notice">{t domain="h5"}运费：原订单实际支付的运费金额{/t}</div>
		</div>
	</div>
</div>
<div class="ecjia-shipping-fee-overlay ecjia-shipping-fee-overlay-visible"></div>

