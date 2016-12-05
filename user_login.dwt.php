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
<form class="ecjia-form  ecjia-login" name="formLogin" action="{url path='user/privilege/signin'}" method="post">
	<div class="user-img"><img src="{$user_img}"></div>
	<div class="form-group margin-right-left">
		<label class="input">
			<i class="iconfont icon-dengluyonghuming"></i>
			<input placeholder="{$lang.name_or_mobile}" name="username" datatype="s3-15|m|e" errormsg="用户名错误请重新输入！" autocomplete="off" />
		</label>
	</div>
	<div class="form-group ecjia-margin-t margin-right-left">
		<label class="input">
			<i class="iconfont icon-lock "></i>
			<i class="iconfont icon-attention ecjia-login-margin-l"></i>
			<input placeholder="{$lang.input_passwd}" id="password" name="password" type="password" datatype="*6-16" errormsg="密码错误请重新输入！" autocomplete="off" />
		</label>
	</div>
	<!-- 判断是否启用验证码{if $enabled_captcha} -->
	<div class="form-group">
		<label class="input captcha-img">
			<i class="iconfont icon-pic"></i>
			<input data-rule='notEmpty' name="captcha" placeholder="{$lang.comment_captcha}" />
			<img src="{url path='captcha/privilege/init'}" alt="captcha" onClick="this.src='{url path='captcha/privilege/init'}&t='+Math.random();" />
		</label>
	</div>
	<!--{/if}-->
	<div class="ecjia-login-login-foot margin-right-left ecjia-margin-b">
		<a class="ecjiaf-fr" href="{url path='user/get_password/get_password_email'}">{$lang.forgot_password}?</a>
		<!-- {if $anonymous_buy eq 1 && $step eq 'flow'} 是否允许未登录用户购物 -->
		<a class="ecjiaf-fr" href="{url path='cart/flow/consignee' args="direct_shopping=1"}">{$lang.direct_shopping}</a>
		<!-- {/if} -->
	</div>
	<div class="ecjia-login">
	    <div class="around">
            <input type="hidden" name="referer" value="{$smarty.get.referer}" />
            <input type="submit" class="btn btn-info login-btn" value="{$lang.login}" />
	    </div>	
	</div>
	<ul>
	<li style="text-align:center;">其他帐号登陆</li>
	<li class="thirdparty-qq"></li>
	<li class="thirdparty-weixin"></li>
	</ul>
</form>
<!-- {/block} -->
