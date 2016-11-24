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

<form class="ecjia-login ecjia-form ecjia-login-user-profile-form ecjia-login-margin-top" name="user_profile" action="{url path='user/user_profile/update_profile'}" method="post">
	<div class="form-group ecjia-login-margin-lr ecjiaf-bt">
		<label class="input">
			<input name="email ecjiaf-fl" type="email" placeholder="test测试"  value="{$profile.name}" datatype="e" errormsg="请输入正确格式的邮箱" />
		</label>
	</div>
	<p class="ecjia-margin-l">4-20个字符，可由中英文、数字、"——"、"-"组成</p>
	<div class="ecjia-login-b">
	    <div class="around p-top3">
            <input type="hidden" name="referer" value="{$smarty.get.referer}" />
            <input type="submit" class="btn btn-info login-btn" value="确定" />
	    </div>	
	</div>
</form>
<!-- {/block} -->
