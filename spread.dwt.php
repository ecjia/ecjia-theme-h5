<?php
/*
Name: 用户中心模板
Description: 这是推广页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.category.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div class="ecjia-my-reward">
	<a href="javascript:;"><span class="ecjia-my-reward-literal" style="color:#fff;font-size:16px;">我的奖励</span></a>
</div>
<div class="ecjia-spread">
	<div class="ecjia-bg-qr-code">
		<div class="bg-img"></div>
		<div class="qrcode_image">
			<img  src="{$invite_user.invite_qrcode_image}" />
		</div>
		<div class="my-invite-code">
			<p>我的邀请码</p>
			<div class="code-style">{$invite_user.invite_code}</div>
		</div>
	</div>
	<div class="invite-template">
		<div class="invite-template-style">{$invite_user.invite_template}</div>
	</div>
	<div class="go-to-spread">
		<a class="" href="javascript:;"><div class="would-spread">我要推广</div></a>
	</div>
	<div class="invite_explain"> 
		<p class="invite_explain-literal">邀请说明：</p>
		<div class="invite_explain-content">
			<p>{$invite_user.invite_explain}</p>
		</div>
		
	</div>
</div>



<!-- {/block} -->
