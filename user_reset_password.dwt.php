<?php
/*
Name: 找回密码设置新密码模板
Description: 这是设置新密码
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.user.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<form class="ecjia-form  ecjia-login ecjia-login-margin-top" name="formLogin" action="{url path='user/index/reset_password'}" method="post">
	
    	<div class="form-group">
    		<label class="input">
    			<i class="iconfont icon-attention icon-left"></i>
    			<input class="padding-left05" placeholder="{$lang.input_new_password}" name="password" type="password" datatype="*6-16" errormsg="密码错误请重新输入！" autocomplete="off" />
    		</label>
    	</div>
	
    	<div class="form-group">
    		<label class="input">
    			<i class="iconfont icon-attention icon-left"></i>
    			<input class="padding-left05" data-rule='notEmpty' name="captcha" placeholder="{$lang.input_new_password_again}"/>
    		</label>
    	</div>

	<div class="ecjia-login-b margin-top4">
	    <div class="around">
            <input type="hidden" name="referer" value="{$smarty.get.referer}" />
            <input type="submit" class="btn btn-info login-btn" value="{$lang.login_finish}" />
	    </div>	
	</div>
</form>
<!-- {/block} -->
