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
<form class="ecjia-user ecjia-login-user-profile-form ecjia-login-margin-top" name="user_profile" action="{url path='user/user_profile/modify_username_account'}" method="post">
	<div class="ecjia-form">
    	<div class="form-group ecjia-login-margin-lr ecjiaf-bt right-angle">
    		<label class="input ecjia-login-pa-left">
    			<input name="username" type="text" placeholder="test测试"  value="{$user.name}">
    		</label>
    	</div>
    	<p class="ecjia-margin-l ecjia-margin-t">4-20个字符，可由中英文、数字、"——"、"-"组成</p>
    	<div class="ecjia-login-b ecjia-login">
    	    <div class="p-top3">
                <input type="hidden" name="referer" value="{$smarty.get.referer}" />
                <input type="submit" class="btn btn-info nopjax" value="确定" />
    	    </div>	
    	</div>
	</div>
</form>
<!-- {/block} -->
