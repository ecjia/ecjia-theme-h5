<?php
/*
Name: 购物车列表模板
Description: 购物车列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
	<script type="text/javascript">
	ecjia.touch.flow.init();
	$('.checkbox').change();
	ecjia.touch.delete_list_click();
	</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
	
<div class="flow-address ecjia-margin-b">
	<span class="ecjiaf-fl">{t}送至：{/t}</span>
	<div class="ecjiaf-fl address-info">
		<span>{$default_address.consignee}</span>
		<span>{$default_address.mobile}</span>
		<p class="ecjia-truncate2 address-desc">{$default_address.address}</p>
	</div>
</div>
<!-- {if $cart_list} -->
<div class="ecjia-flow-cart">
	<ul>
		<!-- {foreach from=$cart_list item=val} -->
		<li class="cart-single">
			<div class="cart-title">
				<span class="cart-check-all" data-toggle="toggle_checkbox"></span>
				<span class="store-title">{$val.store_name}</span>
				<span class="edit-title">编辑</span>
			</div>
			
		</li>
		<!-- {/foreach} -->
	</ul>
</div>
<!-- {else} -->
<div class="flow-no-pro ecjia-margin-t ecjia-margin-b">
	<div class="ecjia-nolist">
		您还没有添加商品
		<a class="btn btn-small" type="button" href="{url path='touch/index/init'}">{t}去逛逛{/t}</a>
	</div>
</div>
<!-- {/if} -->
<!-- #BeginLibraryItem "/library/model_bar.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->