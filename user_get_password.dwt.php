<?php
/*
Name: 安全问题找回密码模板
Description: 安全问题找回密码页
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

<div class="border_bottom_getpassword"></div>
<form class="ecjia-form ecjia-login ecjia-login-margin-top" name="getPassword" action="{url path='user/get_password/get_password_email'}" method="post">
	<!-- 添加id，js用到 -->
	<div class="form-group margin-right-left">
		<label class="input-1">
			<input name="mobile" type="text" placeholder="{$lang.name_or_mobile}" errormsg="请输入用户名" />
		</label>
	</div>
	<!-- 判断是否启用验证码{if $enabled_captcha} -->
		<div class="form-group margin-right-left">
			<label class="input captcha-img">
				<i class="glyphicon glyphicon-picture"></i>
				<input type="text" placeholder="{$lang.comment_captcha}" name="mobile" datatype="*" />
			</label>
		</div>
	<!--{/if}-->
	<input name="act" type="hidden" value="send_pwd_email" />
	<div class="ecjia-login-b">
	   <div class="around margin-top">
	       <input class="btn btn-info login-btn" name="get_password" type="submit" value="{$lang.next}" data-url="{RC_Uri::url('user/get_password/get_password_email')}"/>
	   </div>
	</div>
</form>
<!-- {/block} -->
