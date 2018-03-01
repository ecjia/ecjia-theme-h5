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

</script>
<!-- {/block} -->
<!-- {block name="main-content"} -->

<div class="ecjia-mod ecjia-header ecjia-store-banner" style="background: url('{if $store_info.seller_banner}{$store_info.seller_banner}{else}{$theme_url}images/default_store_banner.png{/if}') center center no-repeat;background-size: 144% 100%;">
	<div class="ecjia-store-brief">
		<li class="store-info {if $store_info.favourable_count}boder-eee{/if}">
			<div class="basic-info">
				<div class="store-left">
					<img src="{if $store_info.seller_logo}{$store_info.seller_logo}{else}{$theme_url}images/store_default.png{/if}">
				</div>
				<div class="store-right">
					<div class="store-title">
						<span class="store-name">{$store_info.seller_name}</span>
					</div>
				</div>
			</div>
		</li>
	</div>
</div>

<input type="hidden" name="from" value="{$smarty.get.from}" class="ecjia-from-page {if $smarty.get.out eq 1}out-range{/if}" />

<form class="ecjia-add-shipping" action="" method="post">
	<div class="ecjia-quickpay-content">
		<div class="quickpay-content-title">
			消费总金额（元）
		</div>
		<div class="quickpay-content-input">
			<div class="logo">
				￥
			</div>
			<input type="digit" placeholder='请询问店员后输入' name="order_money" maxlength="9" value="{{$order_money}}"/>
		</div>
		<div class="quickpay-content-block">
			<a href="{RC_Uri::url('user/quickpay/init')}&store_id={$store_id}" data-money="{{$order_money}}">更多优惠选择>>></a>
		</div>
	</div>
	<div class="ecjia-service-content-bottom">
		<input type="submit" class="btn" value="我要买单"/>
	</div>
</form>      

<!-- {/block} -->

{/nocache}