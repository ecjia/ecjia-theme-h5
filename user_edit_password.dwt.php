<?php
/*
Name: 修改密码页面模板
Description: 这是修改密码页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	{foreach from=$lang.profile_js item=item key=key}
		var {$key} = "{$item}";
	{/foreach}
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<form class="ecjia-form edit-password-form" name="formPassword" action="{url path='user/index/update_password'}" method="post" >
	<div class="form-group">
		<label class="input">
			<input name="old_password" placeholder="{$lang.old_password}" type="password" datatype="s6-16" errormsg="请输入6-16位格式的密码">
		</label>
	</div>
	<div class="form-group">
		<label class="input">
			<input name="new_password" placeholder="{$lang.new_password}" datatype="s6-16" type="password" errormsg="请输入6-16位格式的密码">
		</label>
	</div>
	<div class="form-group">
		<label class="input">
			<input name="comfirm_password" placeholder="{$lang.confirm_password}" type="password" datatype="s6-16" errormsg="请输入6-16位格式的密码">
		</label>
	</div>
	<input name="act" type="hidden" value="edit_password" />
	<div class="ecjia-margin-t ecjia-margin-b">
		<input class="btn btn-info edit_password_user_submit" name="submit" type="submit" value="{$lang.confirm_edit}" />
	</div>
</form>
<!-- {/block} -->
