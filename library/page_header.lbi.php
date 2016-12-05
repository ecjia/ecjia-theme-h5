<?php
/*
Name: 页头
Description: 这是公共页头文件
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {if $smarty.cookies.hide_download neq 1 && $shop_app_icon } -->
<script type="text/javascript">ecjia.touch.close_app_download();</script>
<div class="ecjia-app-download">
    <div class="ecjiaf-fl"><i class="iconfont icon-close"></i></div>
    <div class="ecjia-app-download-bd">
        <img class="shop_app_icon" src="{$shop_app_icon}" alt="ECJia-touch">
        <p>享受流畅的商城</p>
        <p>快下载ECJiaAPP</p>
    </div>
    <a class="btn btn-info download-btn" href="{url path='touch/index/download'}">下载</a>
</div>
<!-- {/if} -->

<header class="ecjia-header">
	<div class="ecjia-header-left">
	</div>
	<div class="ecjia-header-title">{$title}</div>
	<!-- {if $header_right} -->
	<div class="ecjia-header-right">
		<a href="{$header_right.href}">
			<!-- {if $header_right.icon neq ''} -->
			<i class="{$header_left.icon}"></i>
			<!-- {elseif $header_right.info neq ''} -->
			<span>{$header_right.info}</span>
			<!-- {/if} -->
		</a>
	</div>
	<!-- {/if} -->
</header>
