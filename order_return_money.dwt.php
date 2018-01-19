<?php
/*
Name: 退款详情模板
Description: 这是退款详情页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="return-status-content">
	<ul class="aam">
		<li>退回金额<span class="aan ecjia-red">￥19.90</span></li>
		<li>退回账户<span class="aan">微信支付账户</span></li>
		<li>退款进度<span class="aan">退款到账</span></li>
	</ul>
	
	<div class="q5">
		<div class="qi">
			<span class="qj"></span>
			<span class="qk"></span>
			<span class="qk"></span>
			
			<div class="q6">
				<i class="or ot iconState6"></i>
				<span class="firstLine"></span>
				<div class="q8">
					<span class="q7">ECJia到家审核通过</span>
				</div>
				<div class="q9">01-17 09:20</div>
			</div>
			
			<div class="q6">
				<i class="or ot iconState6"></i>
				<span class="firstLine"></span>
				<div class="q8">
					<span class="q7">微信支付审核通过</span>
				</div>
				<div class="q9">01-17 09:20</div>
				<div class="qa">微信支付已将43.22元退至您的微信支付账户</div>  
			</div>
			
		</div>
	</div>
</div>
<!-- {/block} -->