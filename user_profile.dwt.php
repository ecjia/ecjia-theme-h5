<?php
/*
Name:  会员中心：编辑个人资料模板
Description:  会员中心：编辑个人资料首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="con"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div class="ecjia-user-info ecjia_user-info-edit ecjia-margin-b">
	<div class="user-img"><img src="{$user_img}"></div>
	<a href="{url path='touch/index/download'}">{t}如需修改头像请下载APP{/t}</a>
</div>
<form class="ecjia-form user-profile-form" name="user_profile" action="{url path='user/user_profile/update_profile'}" method="post">
	<div class="form-group form-group-text">
		<label class="input">
			<span>{$lang.email}</span>
			<input name="email" type="email" placeholder="{$lang.no_emaill}"  value="{$profile.email}" datatype="e" errormsg="请输入正确格式的邮箱" />
		</label>
	</div>
	<!-- {foreach from=$extend_info_list item=field} -->
	<!-- {if $field.id neq 6} -->
	<div class="form-group form-group-text">
		<label class="input">
			<span>{$field.reg_field_name}</span>
			<input name="extend_field{$field.id}" type="text" value="{$field.content}" placeholder="{$field.reg_field_name}" />
		</label>
	</div>
	<!-- {/if} -->
	<!-- {/foreach} -->
	<div class="edit-password ecjia-margin-t">
		<a href="{url path='user/user_profile/edit_password'}">
			修改密码
			<i class="iconfont ecjiaf-fr icon-jiantou-right"></i>
		</a>
	</div>
	<input name="act" type="hidden" value="profile" />
	<div class="ecjia-margin-t ecjia-margin-b">
		<input class="btn btn-info" name="submit" type="submit" value="{$lang.confirm_edit}" />
	</div>
</form>
<!-- {/block} -->
