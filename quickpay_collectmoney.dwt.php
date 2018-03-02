<?php
/*
Name: 优惠买单页面
Description: 优惠买单页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.quickpay.init();
</script>
<!-- {/block} -->
<!-- {block name="main-content"} -->

<div class="ecjia-mod ecjia-header ecjia-store-banner" style="background: url('{if $store_info.seller_banner}{$store_info.seller_banner}{else}{$theme_url}images/default_store_banner.png{/if}') center center no-repeat;background-size: 144% 100%;">
	<div class="ecjia-store-brief quickpay-brief">
		<a href="{RC_Uri::url('merchant/index/init')}&store_id={$store_id}">
			<img src="{if $store_info.seller_logo}{$store_info.seller_logo}{else}{$theme_url}images/store_default.png{/if}">
		</a>
		<div class="store-name"><a href="{RC_Uri::url('merchant/index/init')}&store_id={$store_id}">{$store_info.seller_name}</a></div>
	</div>
</div>

<input type="hidden" name="from" value="{$smarty.get.from}" class="ecjia-from-page {if $smarty.get.out eq 1}out-range{/if}" />

<div class="ecjia-quickpay-form">
	<form name="quickpayForm" action="{url path='user/quickpay/done'}" method="post" data-url="{url path='user/quickpay/flow_checkorder'}">
		<div class="ecjia-quickpay-content">
			<div class="quickpay-content-title">
				消费总金额（元）
			</div>
			<div class="quickpay-content-input">
				<div class="logo">￥</div>
				<input type="number" placeholder='请询问店员后输入' step="0.01" name="order_money" maxlength="9" />
			</div>
			<div class="quickpay-content-block">
				<a class="more-discount external" href="{RC_Uri::url('user/quickpay/init')}&store_id={$store_id}">更多优惠选择 >>></a>
			</div>
		</div>
		<div class="ecjia-service-content-bottom">
			<input type="hidden" name="store_id" value="{$store_id}">
			<input class="btn quickpay_done external" type="submit" value="我要买单" />
		</div>
	</form>
</div>      

<!-- {/block} -->

{/nocache}