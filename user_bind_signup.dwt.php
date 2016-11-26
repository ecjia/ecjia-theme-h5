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
    <div class="tab-pane{if $enabled_sms_signin neq 1} active{/if}" id="two">
		<form class="ecjia-form ecjia-login ecjia-login-margin-top" name="formUser" action="{url path='user/index/signup'}" method="post">
			<input type="hidden" name="flag" id="flag" value="register" />
			<div class="form-group ecjia-margin-t margin-right-left">
				<label class="input">
					<i class="iconfont icon-mobilefill icon-set"></i>
					<input name="username" type="text" id="username" name="username" datatype="s3-15|m|e" errormsg="{$lang.msg_mast_length}" placeholder="请输入手机号" />
				</label>
			</div>
			<div class="form-group small-text ecjia-margin-t">
				<label class="input-1">
					<input name="email" type="email" id="email" datatype="e" errormsg="请输入正确格式的邮箱" placeholder="{$lang.input_verification}" />
				</label>
			</div>
			<div class="small-submit ecjia-margin-t">
                    <input type="hidden" name="referer" value="{$smarty.get.referer}" />
                    <span><input type="submit" class="btn btn-info login-btn" value="{$lang.return_verification}" /></span>
        	</div>
			<div class="form-group bf margin-right-left five-margin-top">
				<label class="input">
					<i class="iconfont icon-yanzhengma"></i>
					<input name="password" id="password1" type="password" datatype="*6-16" placeholder="邀请码6位数字或字母" errormsg="邀请码6位数字或字母">
				</label>
			</div>
			<div class="form-group ecjia-margin-t margin-right-left">
				<label class="input">
					<i class="iconfont icon-yanzhengma"></i>
					<input name="password" id="password1" type="password" datatype="*6-16" placeholder="我的音乐" errormsg="我的音乐">
				</label>
			</div>
			<div class="form-group ecjia-margin-t margin-right-left">
				<label class="input">
					<i class="iconfont icon-unlock"></i>
					<i class="iconfont icon-attention ecjia-login-margin-l"></i>
					<input name="password" id="password1" type="password" datatype="*6-16" placeholder="请输入密码" errormsg="请输入密码">
				</label>
			</div>
			<div class="ecjia-login-b ">
				<input name="act" type="hidden" value="act_register" />
				<input name="enabled_sms" type="hidden" value="0" />
				<input type="hidden" name="back_act" value="{$back_act}" />
				<div class="around margin-top">
				<button class="btn btn-info login-btn" href="flow_consignee.html" name="Submit" type="submit">{t}注册{/t}</button>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- {/block} -->
