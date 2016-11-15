<?php
/*
Name: 文章详情模板
Description: 文章详情页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div class="article-info">
	<!-- <h3>{$article.title}</h3> -->
	<div class="article-info-con"> {$article.content} </div>
</div>
<!-- {/block} -->
