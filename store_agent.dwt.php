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
<script type="text/javascript">
{if $is_weixin}
var config = '{$config}';
{/if}

ecjia.touch.store_agent.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->

<div class="ecjia-store-agent">

	<div class="bg-img"></div>
	<div class="ecjia-bg-qr-code">
		<div class="qrcode_image">
			<img src="{$invite_user.invite_qrcode_image}" />
		</div>
		
		<div class="my-invite-code">
			<div class="code-style">{t domain="h5"}扫一扫或长按保存至相册分享到朋友圈{/t}</div>
		</div>
	</div>
	
	<div class="go-to-spread">
		<a class="show_spread_share nopjax external" href="javascript:;"><div class="would-store-agent">{t domain="h5"}分享二维码{/t}</div></a>
	</div>
	
	<div class="ecjia-store-agent-share hide"><img src="{$theme_url}images/spread.png"></div>

	<input type="hidden" name="share_title" value="{$share_title}">
	<input type="hidden" name="share_desc" value="{$invite_user.invite_template}">
	<input type="hidden" name="share_image" value="{$image}">
	<input type="hidden" name="share_link" value="{$invite_user.invite_url}">
	<input type="hidden" name="share_page" value="1">
	
</div>
<!-- {/block} -->