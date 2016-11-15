<?php 
/*
Name: 文章分类模板
Description: 文章分类首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="ecjia"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<div class="article-list">
	<form class="article_search" name="search_form" action="{url path='index/art_list'}" method="post">
		<div class="input-search">
			<span>
				<input class="J_SearchInput autocomplete="off" id="requirement" name="keywords" placeholder="{$lang.art_no_keywords}"  inputSear" type="search">
			</span>
			<input name="id" type="hidden" value="{$cat_id}" />
			<input id="cur_url" name="cur_url" type="hidden" value="" />
			<button class="input-delete J_InputDelete" type="button" disabled="true" > <span></span> </button>
			<button type="submit" ><i class="glyphicon glyphicon-search"></i></button>
		</div>
	</form>
	<!-- {if $article_categories} -->
	<div class="nav">
		<ul>
			<!--{foreach from=$article_categories item=cat name="article_cat"}-->
			<li><a href="{url path='index/art_list' args="id={$cat.id}"}">{$cat.name|escape:html}</a></li>
			<!--{/foreach}-->
		</ul>
	</div>
	<!--{else}-->
	<div class="article-list-ol">
		<ol>
			<!-- {foreach from=$artciles_list item=article name="artciles_list"} -->
			<li>
				<a href="{$article.url}">
					<span class="num">{$smarty.foreach.artciles_list.iteration}</span>{$article.short_title}
				</a> 
			</li>
			<!-- {/foreach} --> 
			<!-- #BeginLibraryItem "/library/pages.lbi" --><!-- #EndLibraryItem -->
		</ol>
	</div>
	<!-- {/if} --> 
</div>

<!-- {/block} -->