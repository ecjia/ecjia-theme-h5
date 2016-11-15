<?php 
/*
Name: 文章列表模板
Description: 文章列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="con"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<div class="article-list">
	<form class="article_search" action="{url path='index/art_list'}" name="search_form" method="post">
		<div class="input-search"> 
			<span>
				<input class="J_SearchInput inputSear" autocomplete="off" placeholder="{$lang.art_no_keywords}"  name="keywords" id="requirement" type="search">
			</span>
			<input name="id" type="hidden" value="{$cat_id}" />
			<input name="cur_url" id="cur_url" type="hidden" value="" />
			<button class="input-delete J_InputDelete" type="button" disabled="true"> <span></span> </button>
			<button type="submit" ><i class="glyphicon glyphicon-search"></i></button>
		</div>
	</form>
</div>
<div class="article-list-ol">
	<ol id="J_ItemList" data-toggle="asynclist" data-flag="add_load_more_btn" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='index/asynclist' args="id={$id}&keywords={$keywords}"}" data-size="10">
		<!-- 文章列表 start-->
		<!-- 文章列表end -->
	</ol>
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
	<!-- 文章列表 start-->
	<!-- {foreach from=$artciles_list item=value} -->
	<li class="single_item"><a href="{$value.url}" >{$value.index}、{$value.short_title}</a></li>
	<!-- {/foreach} -->
	<!-- 文章列表end -->
<!-- {/block} -->