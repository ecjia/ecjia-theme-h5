<?php
/*
Name: 专题列表页
Description: 专题列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
	<ul class="ecjia-list toplic-list" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='async_topic_list'}" data-size="10">
	</ul>

<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
<!-- 专题列表 start-->
	<!-- {foreach from=$topic_list item=topic_info} -->
		<li class="topic ecjia-margin-t">
			<a href="{url path='topic/index/info' args="id={$topic_info.topic_id}"}">
				<img src="{$topic_info.topic_img}" alt="">
				<p class="topic-title">{$topic_info.title}</p>
			</a>
		</li>
	<!-- {foreachelse} -->
		<div class="ecjia-nolist">
			<i class="iconfont icon-redpacket"></i>
			<p>{t}还没有专题哦~{/t}</p>
		</div>
	<!-- {/foreach} -->
<!-- 专题列表 end-->
<!-- {/block} -->
