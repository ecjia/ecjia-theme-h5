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
<form class="ecjia-form ecjia-login-edit-password-form ecjia-login-margin-top" name="formPassword" action="{url path='user/user_profile/edit_password'}" method="post" >
	<div class="ecjia-user ecjia-account ecjia-form">
        <ul>
            <div class="ecjia-list list-short form-group right-angle">
                <li>
                	<label class="input">
            			<input class="ecjia-account-passwd-on ecjia-user-height-2" name="old_password" placeholder="请输入旧密码" type="password">
            		</label>
                </li>
                <li>
                	<label class="input">
            			<input class="ecjia-account-passwd-on ecjia-user-height-2" name="new_password" placeholder="请输入新密码" type="password">
            		</label>
                </li>
                 <li>
            		<label class="input">
            			<input class="ecjia-account-passwd-on ecjia-user-height-2" name="comfirm_password" placeholder="请确认新密码" type="password">
            		</label>
                </li>
            </div>
        </ul>
    </div>
    <input name="act" type="hidden" value="edit_password" />
    <div class="ecjia-login-margin-top ecjia-margin-b">
    	<input class="btn btn-info" name="submit" type="submit" value="确定" />
    </div>
</form>
<!-- {/block} -->
