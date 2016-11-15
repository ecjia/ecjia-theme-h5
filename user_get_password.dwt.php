<?php
/*
Name: 安全问题找回密码模板
Description: 安全问题找回密码页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	{foreach from=$lang.password_js item=item key=key}
		var {$key} = "{$item}";
	{/foreach}
</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<!--{if $action eq 'get_password_phone' && $enabled_sms_signin eq 1}-->
<form name="getPassword" action="{url path='user/index/get_password_phone'}" method="post">
	<div class="flow-consignee" id="tabBox1-bd">
		<!-- 添加id，js用到 -->
		<section>
			<ul>
				<li>
					<div class="input-text">
						{$lang.mobile}：
						<span>
							<input name="mobile" id="mobile_phone" type="tel" />
						</span>
					</div>
				</li>
				<li>
					<div class="input-text code">
						{$lang.code}：
						<span>
							<input id="mobile_code" name="mobile_code" type="text" />
						</span>
						<a id="zphone" name="sendsms" onclick="sendSms();" type="botton">{$lang.get_code}</a>
					</div>
				</li>
			</ul>
		</section>
	</div>
	<div>
		<input name="act" type="hidden" value="send_pwd_sms" />
		<input id="sms_code" name="sms_code" type="hidden" value="{$sms_code}" />
		<input class="btn btn-info" name="Submit" type="submit" value="{$lang.submit}" />
	</div>
	<p>
		<a class="f6" href="{url path='user/index/get_password_question'}">{$lang.get_password_by_question}</a>
		&nbsp;&nbsp;
		<a class="f6" href="{url path='user/index/get_password_email'}">{$lang.get_password_by_mail}</a>
	</p>
</form>
<!-- {/if} -->
<!--{if $action eq 'get_password_email'}-->
<div class="border_bottom_getpassword"></div>
<form class="ecjia-form ecjia-icon-form ecjia-login-form ecjia-margin-t" name="getPassword" action="{url path='user/index/send_pwd_email'}" method="post">
	<!-- 添加id，js用到 -->
	<div class="form-group">
		<label class="input">
			<i class="iconfont icon-dengluyonghuming"></i>
			<input name="user_name" type="text" placeholder="{$lang.username}" datatype="s3-15|m|e|" errormsg="请输入用户名" />
		</label>
	</div>
	<div class="form-group">
		<label class="input">
			<i class="iconfont icon-dianziyoujian"></i>
			<input name="email" type="email" placeholder="{$lang.email}" datatype="e" errormsg="请输入正确格式的邮箱" />
		</label>
	</div>
	<!-- 判断是否启用验证码{if $enabled_captcha} -->
		<div class="form-group">
			<label class="input captcha-img">
				<i class="glyphicon glyphicon-picture"></i>
				<input type="text" placeholder="{$lang.comment_captcha}" name="captcha" datatype="*" />
				<img class="captcha-img ecjiaf-fr" src="{url path='captcha/index/init' args="is_login=1&rand={$rand}"}" alt="captcha" onClick="this.src='{url path='captcha/index/init' args="is_login=1&t=Math.random()"}'" />
			</label>
		</div>
	<!--{/if}-->
	<input name="act" type="hidden" value="send_pwd_email" />
	<div class="ecjia-margin-t get-pwd-send ecjia-margin-b">
		<input class="btn btn-info" name="Submit" type="submit" value="{$lang.submit}" />
	</div>
</form>
<!--{/if}-->
<!--{if $action eq 'get_password_question'}-->
<div class="border_bottom_getpassword"></div>
<form class="ecjia-form ecjia-icon-form ecjia-login-form ecjia-margin-t" name="getPassword" action="{url path='user/index/question_get_password'}" method="post">
	<div class="flow-consignee" id="tabBox1-bd">
		<!-- 添加id，js用到 -->
		<div class="form-group">
			<label class="input">
				<i class="iconfont icon-dengluyonghuming"></i>
				<input name="user_name" type="text" placeholder="{$lang.username}" datatype="*" />
			</label>
		</div>
		<div class="form-group">
			<label class="select">
				<i class="iconfont icon-jiantou-bottom"></i>
				<select name='sel_question'>
					{foreach from=$password_question key=key item=question}
						<option value="{$key}">{$question}</option>
					{/foreach}
				</select>
			</label>
		</div>
		<div class="form-group">
			<div>
				<input name="passwd_answer" placeholder="{$lang.passwd_answer}" type="text" datatype="*"/>
			</div>
		</div>
		<!-- 判断是否启用验证码{if $enabled_captcha} -->
		<div class="form-group">
			<div>
				<span class="form-captcha">
					<input placeholder="{$lang.comment_captcha}" type="text" name="captcha"/>
				</span>
				<img class="captcha-img ecjiaf-fr" src="{url path='captcha/index/init' args="is_login=1&rand={$rand}"}" alt="captcha" onClick="this.src='{url path='captcha/index/init' args="is_login=1&t=Math.random()"}'" />
			</div>
		</div>
		<!--{/if}-->
	</div>
	<input name="act" type="hidden" value="send_pwd_email" />
	<div class="get-pwd-send ecjia-margin-t ecjia-margin-b">
		<input class="btn btn-info" name="Submit" type="submit" value="{$lang.submit}" />
	</div>
</form>
<!--{/if}-->

<!-- {/block} -->
