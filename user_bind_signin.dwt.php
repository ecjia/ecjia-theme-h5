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
<script type="text/javascript">
	{foreach from=$lang.password_js item=item key=key}
		var {$key} = "{$item}";
	{/foreach}
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<form class="ecjia-login ecjia-login-margin-top" name="getPassword" action="{url path='user/index/question_get_password'}" method="post">
    <div class="user-img"><img src="{$user_img}"></div>
    <div class="margin-right-left">
        <p class="p-top3 text-size"><span class="text-color">亲爱的QQ用户：</span><span><big>我的音乐</big></span></p>
        <p class="text-size">为了给您更多的福利，请关联一个账号</p>
    </div>
	<div class="ecjia-login-b">
	    <p class="p-bottom">还没有账号？</p>
	    <div class="around">
            <input type="hidden" name="referer" value="{$smarty.get.referer}" />
            <input type="submit" class="btn btn-info login-btn" value="快速注册" />
	    </div>	
	</div>
	<div class="ecjia-login-b margin-top4">
	    <p class="p-bottom">已有账号</p>
	    <div class="around">
            <input type="hidden" name="referer" value="{$smarty.get.referer}" />
            <input type="submit" class="btn btn-info login-btn btn-c" style="background-color: #FFFFFF, font-color: #DDD" value="立即关联" />
	    </div>	
	</div>
</form>


<!-- {/block} -->
