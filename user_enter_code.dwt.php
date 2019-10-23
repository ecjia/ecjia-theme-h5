<?php
/*
Name: 手机验证码模板
Description: 这是手机验证码登录页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {nocache} -->
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.init();

    document.addEventListener('paste', e => {
        const text = e.clipboardData.getData('text/plain');
        console.log('Got pasted text: ', text);
        console.log('1:', text.substring(0,1));
        console.log('2:', text.substring(1,2));
        console.log('3:', text.substring(2,3));
        console.log('4:', text.substring(3,4));
        console.log('5:', text.substring(4,5));
        console.log('6:', text.substring(5,6));

        $(".input:eq(0)").val(text.substring(0,1));
        $(".input:eq(1)").val(text.substring(1,2));
        $(".input:eq(2)").val(text.substring(2,3));
        $(".input:eq(3)").val(text.substring(3,4));
        $(".input:eq(4)").val(text.substring(4,5));
        $(".input:eq(5)").val(text.substring(5,6));
    })
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->
<div class="ecjia-form ecjia-login">
	<p class="ecjiaf-tac ecjia-margin-b">{t domain="h5"}验证码已发送至{/t}+86 {$mobile}</p>
	
	<div id="payPassword_container">
		<div class="pass_container">
			<input class="input" type="tel" maxlength="1">  
			<input class="input" type="tel" maxlength="1">
			<input class="input" type="tel" maxlength="1">
			<input class="input" type="tel" maxlength="1">
			<input class="input" type="tel" maxlength="1">
			<input class="input" type="tel" maxlength="1">
		</div>
	</div>
	
	<input type="hidden" name="type" value="{$type}" />
	<input type="hidden" name="url" value="{$url}" />
	
    <p class="ecjiaf-tac blue resend_sms" data-url="{$resend_url}">{t domain="h5"}重新发送验证码{/t}</p>
</div>
<!-- {/block} -->
<!-- {/nocache} -->
