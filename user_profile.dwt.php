<?php
/*
Name:  会员中心：编辑个人资料模板
Description:  会员中心：编辑个人资料首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div class="ecjia-login">
	<div class="user-img"><img src="{$user_img}"></div>
</div>
<form class="ecjia-form ecjia-login-user-profile-form" name="user_profile" action="{url path='user/user_profile/update_profile'}" method="post">
	<div class="form-group form-group-text ecjiaf-bt ecjia-login-margin-lr">
		<label class="input">
			<span>用户名 </span>
			<input name="district" placeholder="{t}请输入用户名{/t}" type="text" href="{url path='index/logout'}" datatype="*" value=""/>
			<label class="iconfont icon-jiantou-right"></label>
		</label>
	</div>
	<div class="form-group form-group-text ecjia-login-margin-lr">
		<label class="input">
			<span>{t}用户等级{/t}</span>
			<input name="email" type="email" placeholder="{$lang.no_emaill}"  value="{$profile.name}" datatype="e" errormsg="请输入正确格式的邮箱" />
		</label>
	</div>
	<div class="edit-password ecjia-margin-t">
		<a href="{url path='user/user_profile/edit_password'}">
			<span>{t}修改密码{/t}</span>
			<label class="iconfont icon-jiantou-right a" ></label>
		</a>
	</div>
    <div class="ecjia-margin-t ecjia-login-margin-top">
		<a class="btn btn-info nopjax" href="{url path='index/logout'}">{t}退出登录{/t}</a>
	</div>
</form>
<!-- {/block} -->
