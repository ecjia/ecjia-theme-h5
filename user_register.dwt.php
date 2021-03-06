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
		<li class="active"><a href="#one" role="tab" data-toggle="tab">{t domain="h5"}手机注册{/t}</a></li>
		<li><a href="#two" role="tab" data-toggle="tab">{t domain="h5"}邮箱注册{/t}</a></li>
	</ul>
    <!-- {/if} -->
    <div class="tab-pane{if $enabled_sms_signin neq 1} active{/if}" id="two">
		<form class=" ecjia-login" name="form" action="{url path='user/privilege/validate_code'}" method="post">
			<div class="ecjia-form">
    			<input type="hidden" name="flag" id="flag" value="register" />
    			<div class="form-group margin-right-left">
    				<label class="input">
    					<div class="img-register-mobile"></div>
    					<input name="mobile_verification" type="hidden" data-url="{RC_Uri::url('user/privilege/register')}" />
    					<input name="mobile" type="text" id="mobile" placeholder='{t domain="h5"}请输入手机号{/t}' />
    				</label>
    			</div>
    			 <li class="remark-size">{t domain="h5"}请输入收到的短信验证码{/t}</li>
    			<div class="form-group small-text">
    				<label class="input-1">
    					<input name="code" type="code" id="code" placeholder='{t domain="h5"}输入验证码{/t}' />
    				</label>
    			</div>
    			<div class="small-submit">
                        <input type="hidden" name="referer" value="{$referer}" />
                        <input type="button" name="get_code" class="btn btn-info login-btn" value='{t domain="h5"}获取验证码{/t}' data-url="{url path='user/privilege/signup'}" id="get_code" />
            	</div>
        		<li class="remark-size">{t domain="h5"}可输入好友的邀请码（选填）{/t}</li>
    			<div class="form-group bf margin-right-left">
    				<label class="input">
    					<div class="img-register-invitationcode"></div>
    					<input name="verification" id="verification" type="text" placeholder='{t domain="h5"}邀请码6位数字或字母{/t}' />
    				</label>
    			</div>
    			<div class="ecjia-login-b">
    				<input name="act" type="hidden" value="act_register" />
    				<input name="enabled_sms" type="hidden" value="0" />
    				<input type="hidden" name="back_act" value="{$back_act}" />
    				<div class="around margin-top">
    				<button class="btn btn-info next-btn" type="button" data-url="{RC_Uri::url('user/privilege/validate_code')}">{t domain="h5"}下一步{/t}</button>
    				</div>
    			</div>
			</div>
		</form>
	</div>
</div>
<!-- {/block} -->