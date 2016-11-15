<?php 
/*
Name: 收货信息模板
Description: 收货信息页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.region_change();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<section class="ect-text-style">
	<!-- 如果有收货地址，循环显示用户的收获地址 -->
	<form class="ecjia-form consignee-from address-add-form" id="theForm" name="theForm" action="{url path='flow/update_consignee'}" method="post">
		<!-- #BeginLibraryItem "/Library/consignee.lbi" -->
		<!-- #EndLibraryItem -->
	</form>
</section>

<!-- {/block} -->