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
<form class="ecjia-login ecjia-login-margin-top" action="{url path='user/get_password/mobile_register'}" method="post">
    <div class="ecjia-form">
        <p class="text-st">请输入收到的短信验证码{$mobile}</p>
    	<div class="form-group small-text">
    		<label class="input-1">
    			<input name="code" type="code" id="code" placeholder="{$lang.input_verification}" />
    		</label>
    	</div>
    	<div class="small-submit">
    	    <input name="mobile1" type="hidden" value={$mobile} />
            <input type="button" class="btn login-btn" value="{$lang.return_verification}" data-url="{url path='user/get_password/mobile_register_account'}" id="get_code1" />
        </div>
    	 <div class="around">
	       <input class="btn btn-info login-btn ecjia-login-margin-top" id="mobile_register" name="mobile_register" type="submit" data-url="{RC_Uri::url('user/get_password/mobile_register')}" value="下一步" />
    	 </div>
	 </div> 
</form>
<!-- {/block} -->
