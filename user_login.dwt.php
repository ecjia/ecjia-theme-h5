<?php
/*
Name: 用户登录模板
Description: 这是用户登录页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.user.init();</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<form class="ecjia-form ecjia-icon-form ecjia-login-form ecjia-margin-t" name="formLogin" action="{url path='user/index/signin'}" method="post">
	<div class="form-group">
		<label class="input">
			<i class="iconfont icon-dengluyonghuming"></i>
			<input placeholder="{$lang.username}/{$lang.mobile}/{$lang.email}" name="username" datatype="s3-15|m|e" errormsg="用户名错误请重新输入！" autocomplete="off" />
		</label>
	</div>
	<div class="form-group">
		<label class="input">
			<i class="iconfont icon-lock"></i>
			<input class="validate" placeholder="{$lang.label_password}"  name="password" type="password" datatype="*6-16" errormsg="密码错误请重新输入！" autocomplete="off" />
		</label>
	</div>
	<!-- 判断是否启用验证码{if $enabled_captcha} -->
	<div class="form-group">
		<label class="input captcha-img">
			<i class="iconfont icon-pic"></i>
			<input data-rule='notEmpty' name="captcha" placeholder="{$lang.comment_captcha}" />
			<img src="{url path='captcha/index/init'}" alt="captcha" onClick="this.src='{url path='captcha/index/init'}&t='+Math.random();" />
		</label>
	</div>
	<!--{/if}-->
	<div class="ecjia-margin-t ecjia-margin-b login-foot">
		<a class="ecjiaf-fl ecjia-margin-l" href="{url path='user/index/register'}">注册新账号</a>
		<a class="ecjiaf-fr ecjia-margin-r" href="{url path='index/get_password_email'}">{$lang.forgot_password}?</a>
		<!-- {if $anonymous_buy eq 1 && $step eq 'flow'} 是否允许未登录用户购物 -->
		<a class="ecjiaf-fr ecjia-margin-r" href="{url path='cart/flow/consignee' args="direct_shopping=1"}">{$lang.direct_shopping}</a>
		<!-- {/if} -->
	</div>
	<div class="ecjia-margin-t ecjia-margin-b">
		<input type="hidden" name="referer" value="{$smarty.get.referer}" />
		<input type="submit" class="btn btn-info" value="{$lang.now_landing}" />
	</div>
</form>
<!-- {/block} -->
