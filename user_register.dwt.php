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
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div class="user-register">
    <!--{if $enabled_sms_signin eq 1} 支持手机短信功能-->
	<ul class="ecjia-list ecjia-list-two ecjia-nav" role="tablist">
		<li class="active"><a href="#one" role="tab" data-toggle="tab">{$lang.mobile_login}</a></li>
		<li><a href="#two" role="tab" data-toggle="tab">{$lang.emaill_login}</a></li>
	</ul>
    <!-- {/if} -->
    <div class="tab-pane{if $enabled_sms_signin neq 1} active{/if}" id="two">
		<form class="ecjia-form ecjia-login ecjia-login-margin-top" name="form" action="{url path='user/index/set_password'}" method="post">
			<input type="hidden" name="flag" id="flag" value="register" />
			<div class="form-group margin-right-left">
				<label class="input">
					<i class="iconfont icon-mobilefill icon-set"></i>
					<input name="mobile" type="text" id=""mobile"" name=""mobile"" datatype="s3-15|m|e" errormsg="{$lang.msg_mast_length}" placeholder="请输入手机号" />
				</label>
			</div>
			 <li class="remark-size">{$lang.message_authentication_code}</li>
			<div class="form-group small-text">
				<label class="input-1">
					<input name="code" type="code" id="code" placeholder="{$lang.input_verification}" />
				</label>
			</div>
			<div class="small-submit">
                    <input type="hidden" name="referer" value="{$smarty.get.referer}" />
                    <input type="button" class="btn btn-info login-btn" value="{$lang.return_verification}" data-url="{url path='user/index/signup'}" id="get_code" />
        	</div>
    		<li class="remark-size">{$lang.invitation_code}</li>
			<div class="form-group bf margin-right-left">
				<label class="input">
					<i class="iconfont icon-yanzhengma"></i>
					<input name="text" id="text" type="text" datatype="*6-16"  errormsg="请输入6 ~ 16 位的密码">
				</label>
			</div>
			<div class="ecjia-login-b">
				<input name="act" type="hidden" value="act_register" />
				<input name="enabled_sms" type="hidden" value="0" />
				<input type="hidden" name="back_act" value="{$back_act}" />
				<div class="around margin-top">
				<button class="btn btn-info next-btn" type="button" data-url="{RC_Uri::url('user/index/get_password_validate')}">{$lang.next}</button>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- {/block} -->
