<?php
/*
Name: 首页header模块
Description: 这是首页的header模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<header class="ecjia-header ecjia-header-index">
	<div class="ecjia-header-left">
		<a class="ecjia-header-logo" href="javascript:;"><img src="{$logo_url}" /></a>
	</div>
	<div class="ecjia-header-left close-search">
		<a class="ecjia-header-icon" href="javascript:;" onclick="ecjia.touch.index.close_search()"><i class="iconfont icon-jiantou-left"></i></a>
	</div>
	<div class="ecjia-search-header">
		<form action="{url path='goods/category/goods_list'}<!-- {if $id} -->&id={$id}<!-- {/if} -->"  method="post" id="searchForm" name="searchForm">
			<input id="keywordBox" name="keywords" type="search" placeholder="{$lang.no_keywords}">
			<button type="submit" value="{$lang.search}"><i class="iconfont icon-search"></i></button>
		</form>
	</div>
	<div class="ecjia-header-right">
		<a class="ecjia-header-right category-icon" href="{url path='goods/category/top_all'}"><i class="iconfont icon-sort"></i></a>
	</div>
</header>
<div class="ecjia-hot-search-index">
    <!-- {if $searchs} -->
    <div class="hot-search">
    	<p class="title">
    		{t}搜索历史{/t}<a class="nopjax" href="{url path='touch/index/del_search'}">{t}清除记录{/t}</a>
    	</p>
    	<div class="hot-search-list">
    		<!-- {foreach from=$searchs item=search} -->
            <a href="{url path='goods/category/goods_list' args="keywords={$search}"}">{$search}</a>
    		<!-- {/foreach} -->
    	</div>
    </div>
    <!-- {/if} -->
</div>
