<?php
/*
Name: 邮件找回密码模板
Description: 邮件找回密码首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.resetpwd.init();</script>
<script type="text/javascript">
{foreach from=$lang.password_js item=item key=key}
var {$key} = "{$item}";
{/foreach}
</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<form class="ecjia-form ecjia-margin-t" name="getPassword2" action="{url path='user/index/update_password'}" method="post">
	<div class="form-group">
		<div>
			<span>
				用户名: {$username}
			</span>
		</div>
	</div>
	<div class="form-group">
		<div>
			<span>
				<input class="inputBg" placeholder="{$lang.new_password}" name="new_password" type="password" />
			</span>
		</div>
	</div>
	<div class="form-group">
		<div>
			<span>
				<input class="inputBg" name="confirm_password" placeholder="{$lang.confirm_password}" type="password"/>
			</span>
		</div>
	</div>
	<div class="ecjia-margin-t ecjia-margin-b">
		<input type="hidden" name="uid" value="{$uid}" />
		<!--{if $code}-->
		<input type="hidden" name="code" value="{$code}" />
		<!--{/if}-->
		<!--{if $mobile}-->
		<input type="hidden" name="mobile" value="{$mobile}" />
		<!--{/if}-->
		<!--{if $question}-->
		<input type="hidden" name="question" value="{$question}" />
		<!--{/if}-->
		<input class="btn btn-info" name="Submit" type="submit" value="{$lang.submit}">
	</div>
</form>
<!-- {/block} -->
