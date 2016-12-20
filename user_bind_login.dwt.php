<?php
/*
Name: 安全问题找回密码模板
Description: 安全问题找回密码页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->

<div class="ecjia-login">
    <div class="user-img"><img src="{$user_img}"></div>
    <div class="margin-right-left">
        <p class="p-top3 text-size"><span class="text-color">亲爱的QQ用户：</span><span><big>我的音乐</big></span></p>
        <p class="text-size">为了给您更多的福利，请关联一个账号{$data.bind_url}{$data.login_url}</p>
    </div>
	<div class="ecjia-login-b ecjia-margin-b ecjia-margin-t">
	    <p class="select-title ecjia-margin-l ">还没有账号？</p>
        <a href="{$url.bind_signup}" class="btn">快速注册</a>
	</div>
	<div class="ecjia-login-b ecjia-margin-t">
	    <p class="select-title ecjia-margin-l ">已有账号</p>
        <a href="{$url.bind_signin}" class="btn btn-hollow">立即关联</a>
	</div>
</div>


<!-- {/block} -->
