<?php
/*
Name: 商家入驻验证码模板
Description: 这是商家入驻验证码页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.franchisee.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="ecjia-form ecjia-login">
	<p class="ecjiaf-tac ecjia-margin-b">已发送验证码到{$mobile}</p>
	<div id="payPassword_container" class="alieditContainer" data-busy="0">
		<div class="i-block" data-error="i_error">
			<div class="i-block six-password">
				<input class="i-text sixDigitPassword" id="payPassword_rsainput" type="password" autocomplete="off" required="required" name="payPassword_rsainput" data-role="sixDigitPassword" tabindex="" maxlength="6" minlength="6" aria-required="true">
				<div tabindex="0" class="sixDigitPassword-box">
					<i><b></b></i>
					<i><b></b></i>
					<i><b></b></i>
					<i><b></b></i>
					<i><b></b></i>
					<i><b></b></i>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="url" value="{$url}" />
	
    <p class="ecjiaf-tac blue resend_sms" data-url="{$resend_url}">重新发送验证码</p>
</div>
<!-- {/block} -->
{/nocache}