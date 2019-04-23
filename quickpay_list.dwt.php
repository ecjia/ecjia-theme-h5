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
	ecjia.touch.enter_search();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-order-list ">
	{if $order_list}
	<ul class="ecjia-margin-b" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/quickpay/async_quickpay_list'}" data-size="10" data-page="1">
		<!-- 订单异步加载 -->
	</ul>
	{else}
    <div class="ecjia-nolist">
    	{t domain="h5"}暂无买单记录{/t}
    </div>
	{/if}
</div>
<!-- {/block} -->

{/nocache}