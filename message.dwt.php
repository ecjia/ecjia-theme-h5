<?php 
/*
Name: 信息留言模板
Description: 这是信息留言首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<header class="ecjia-header">
	<a class="ecjia-header-icon" href="javascript:history.go(-1)"><i class="glyphicon glyphicon-menu-left"></i></a>
	<p>{$title}</p>
</header>
<div class="message-div">
	<p>{$message.content}</p>
	<!-- {if $message.url_info} -->
	<div>
		<!--{foreach from=$message.url_info key=info item=url}-->
		<span class="p-link" style="margin-right:0.2em;">
			<a href="{$url}">{$info}</a>
		</span>
		<!--{/foreach}-->
	</div>
	<!--{/if}-->
	<div class="message-user">{foreach from=$lang.p_y item=pv}{$pv}{/foreach}</div>
</div>
<!-- {/block} -->