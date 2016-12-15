<?php
/*
Name: 用户登录模板
Description: 这是用户登录页
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
<form class="ecjia-form  ecjia-login" name="formLogin" action= method="post">
	<div class="user-img"><img src="{$user_img}"></div>
	<div class="form-group margin-right-left">
		<label class="input">
			<i class="iconfont icon-dengluyonghuming"></i>
			<input placeholder="{$lang.name_or_mobile}" name="username">
		</label>
	</div>
	<div class="form-group ecjia-margin-t margin-right-left">
		<label class="input">
			<i class="iconfont icon-lock "></i>
			<i class="iconfont icon-attention ecjia-login-margin-l" id="password1"></i>
			<input placeholder="{$lang.input_passwd}" id="password-1" name="password" type="password">
		</label>
	</div>
	<div class="ecjia-login-login-foot ecjia-margin-b">
		<a class="ecjiaf-fr ecjia-margin-t" href="{url path='user/get_password/mobile_register'}">{$lang.forgot_password}?</a>
	</div>
    <div class="around">
        <input type="hidden" name="referer" value="{$smarty.get.referer}" />
        <input type="submit" class="btn btn-info login-btn" name="ecjia-login" value="{$lang.login}" data-url="{url path='user/privilege/signin'}"/>
    </div>	
	<ul>
	<li style="text-align:center;">其他帐号登录</li>
	<li class="thirdparty-qq"></li>
	<li class="thirdparty-weixin"></li>
	</ul>
</form>
<!-- {/block} -->
