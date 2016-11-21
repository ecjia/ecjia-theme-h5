<?php
/*
Name: 显示注册页面模板
Description: 显示注册页面首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.touch.user.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<form class="ecjia-form ecjia-login ecjia-login-margin-top" action="{url path='user/index/signup'}" method="post">
    <p class="text-st">请输入收到的短信验证码</p>
	<div class="form-group small-text">
		<label class="input-1">
			<input name="email" type="email" id="email" datatype="e" errormsg="请输入正确格式的邮箱" placeholder="{$lang.input_verification}" />
		</label>
	</div>
	<div class="small-submit">
            <input type="hidden" name="referer" value="{$smarty.get.referer}" />
            <span><input type="submit" class="btn btn-info login-btn" value="{$lang.return_verification}" /></span>
	</div>
	<input type="hidden" name="username" value="{$mobile}">
	<input type="hidden" name="enabled_sms" value="1">
	<input class="btn btn-info ecjia-login-margin-top" type="submit" value="下一步">
</form>
<!-- {/block} -->
