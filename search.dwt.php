<?php 
/*
Name: 搜索模板
Description: 这是搜索页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<header class="ecjia-header">
	<div class="ecjia-header-left">
		<a class="ecjia-header-icon" href="javascript:history.go(-1)"><i class="iconfont icon-jiantou-left"></i></a>
	</div>
	<div class="ecjia-search-header">
		<div class="ecjia-form" data-url="{url path='goods/category/store_list'}">
			<input id="keywordBox" name="keywords" type="search" placeholder="搜索附近商品和门店" autofocus="autofocus" {if $keywords}value="{$keywords}"{/if}>
			<button type="button" class="btn-search"><i class="iconfont icon-search"></i></button>
		</div>
	</div>
</header>

<div class="hot-search">
	<p class="title">
		{$lang.hot_search}<a href="">{t}换一批{/t}</a>
	</p>
	<div class="hot-search-list">
		<!-- {foreach from=$tags item=ky} -->
		<a href="{url path='goods/category/store_list' args="keywords={$ky}"}">{$ky}</a> 
		<!-- {/foreach} -->
	</div>
</div>
<!-- {if $searchs} -->
<div class="search-history ecjia-margin-t hot-search">
	<p class="title">
		{t}搜索历史{/t}<a class="nopjax" href="{url path='touch/index/del_search'}">{t}清除记录{/t}</a>
	</p>
	<div class="ecjia-list">
		<ul>
			<!-- {foreach from=$searchs item=search} -->
			<li><a href="{url path='goods/category/goods_list' args="keywords={$search}"}">{$search}</a></li>
			<!-- {/foreach} -->
		</ul>
	</div>
</div>
<!-- {/if} -->

<!-- {/block} -->