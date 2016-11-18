<?php
/*
Name:  会员中心：编辑个人资料模板
Description:  会员中心：编辑个人资料首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<form class="ecjia-login ecjia-form ecjia-login-user-profile-form" name="user_profile" action="{url path='user/user_profile/update_profile'}" method="post">
	<div class="form-group ecjia-login-margin-lr ecjia-margin-t ecjiaf-bt">
		<label class="input">
			<input name="email ecjiaf-fl" type="email" placeholder="test测试"  value="{$profile.name}" datatype="e" errormsg="请输入正确格式的邮箱" />
		</label>
	</div>
	<p class="ecjia-margin-l">4-20个字符，可由中英文、数字、"——"、"-"组成</p>
</form>
<!-- {/block} -->
