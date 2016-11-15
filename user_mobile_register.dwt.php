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
<form class="ecjia-form" action="{url path='user/index/signup'}" method="post">
	<div class="form-group">
		<label class="input">
			<i class="iconfont icon-dianziyoujian"></i>
			<input name="email" id="email" type="email" datatype="e" errormsg="请输入正确格式的邮箱" placeholder="{$lang.email}" />
		</label>
	</div>
	<div class="form-group">
		<label class="input">
			<i class="iconfont icon-lock"></i>
			<input name="password" id="password" type="password" datatype="*6-16" errormsg="请输入6 ~ 16 位的密码" placeholder="{$lang.password}" />
		</label>
	</div>
	<div class="ecjia-margin-t ecjia-margin-b">
		<input type="hidden" name="username" value="{$mobile}">
		<input type="hidden" name="enabled_sms" value="1">
		<input class="btn btn-info" type="submit" value="完成">
	</div>
</form>
<!-- {/block} -->
