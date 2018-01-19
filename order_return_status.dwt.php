<?php
/*
Name: 售后进度模板
Description: 这是售后进度页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="return-status-content">
	<div class="q5">
		<div class="qi">
			<span class="qj"></span>
			<span class="qk"></span>
			<span class="qk"></span>
			
			<div class="q6">
				<i class="or ot iconState6"></i>
				<span class="firstLine"></span>
				<div class="q8">
					<span class="q7">退款到账</span>
				</div>
				<div class="q9">01-17 09:20</div>
				<div class="qa"> 您的退款43.22元已退回至您的支付账户，请查收。 <a class="qb data-pjax" href="{url path='user/order/return_detail'}&order_id={$order_id}&type=return_money" >查看退款详情</a></div>  
			</div>
			
			<div class="q6">
				<i class="or ot iconState6"></i>
				<span class="firstLine"></span>
				<div class="q8">
					<span class="q7">退款到账</span>
				</div>
				<div class="q9">01-17 09:20</div>
				<div class="qa"> 您的退款43.22元已退回至您的支付账户，请查收。 <a class="qb data-pjax" href="{url path='user/order/return_detail'}&order_id={$order_id}&type=return_money">查看退款详情</a></div>  
			</div>
			
		</div>
	</div>
</div>
<!-- {/block} -->