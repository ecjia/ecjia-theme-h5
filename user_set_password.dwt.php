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
	<div class="tab-content">
		<div class="tab-pane{if $enabled_sms_signin eq 1} active{/if} phone-register" id="one">
            <form class="ecjia-form ecjia-login-form ecjia-icon-form user-register-form ecjia-margin-t" name="formUser" data-valid="novalid" action="{url path='user/index/act_register'}" method="post">
                <input type="hidden" name="flag" id="flag" value="register" />
    			<div class="form-group">
    				<label class="input">
    					<i class="iconfont icon-mobilefill"></i>
                        <input name="mobile" id="mobile_phone" type="tel" placeholder="{$lang.no_mobile}" />
    				</label>
    			</div>
    			<div class="form-group">
    				<label class="input send-code">
    					<i class="iconfont icon-yanzhengma"></i>
                        <input class="ecjiaf-fl" name="mobile_code" id="mobile_code" type="text" placeholder="{$lang.no_code}">
                        <a class="ecjiaf-fr" data-toggle="send_captcha" data-url="{url path='user/index/send_captcha'}" href="javascript:void(0)">发送验证码</a>
    				</label>
    			</div>
    			<p class="ecjia-margin-t ecjia-margin-b ecjia-margin-l user-register-agreement">
    				<a href="{url path='article/index/info' args='aid=6'}" target="_blank">
    					<input name="agreement" id="agreement" type="checkbox" data-type="checkbox" value="1" checked="checked" />{$lang.agreement}
    				《用户协议》</a>
    			</p>
    			<div class="ecjia-margin-t ecjia-margin-b">
					<input id="agreement1" name="agreement" type="hidden" value="1" checked="checked" >
					<input name="enabled_sms" type="hidden" value="1" />
					<input type="hidden" name="sms_code" value="{$sms_code}" id="sms_code" />
					<input type="hidden" name="back_act" value="{$back_act}" />
					<button class="btn btn-info" name="Submit" type="submit">同意，注册</button>
    			</div>
    		</form>
		</div>

        <div class="tab-pane{if $enabled_sms_signin neq 1} active{/if}" id="two">
    		<form class="ecjia-form ecjia-login ecjia-login-margin-top" name="formUser" action="{url path='user/index/signup'}" method="post">
    			<input type="hidden" name="flag" id="flag" value="register" />
    			<div class="form-group">
    				<label class="input">
    					<i class="iconfont icon-gerenzhongxin icon-set"></i>
    					<input name="username" type="text" id="username" name="username" datatype="s3-15|m|e" errormsg="{$lang.msg_mast_length}" placeholder="{$lang.input_name}" />
    				</label>
    			</div>
    			<div>
        			 <ul class="ecjia-login-login-foot">
        			     <li class="remark-size">{$lang.set_your_password}</li>
        			 </ul>
    			</div>

    			<div class="form-group bf">
    				<label class="input">
    					<i class="iconfont icon-unlock"></i>
    					<i class="iconfont icon-attention icon-left"></i>
    					<input name="password" id="password1" type="password" datatype="*6-16"  errormsg="请输入6 ~ 16 位的密码" placeholder="{$lang.input_passwd}">
    				</label>
    			</div>
    			<div class="ecjia-login-b">
    				<input name="act" type="hidden" value="act_register" />
    				<input name="enabled_sms" type="hidden" value="0" />
    				<input type="hidden" name="back_act" value="{$back_act}" />
    				<div class="around margin-top">
    				<button class="btn btn-info login-btn" href="flow_consignee.html" name="Submit" type="submit">{$lang.login_finish}</button>
    				</div>
    			</div>
    		</form>
    	</div>
	</div>
</div>
<!-- {/block} -->
