<?php 
/*
Name: 搜索模板
Description: 这是搜索页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.searchbox_foucs();</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<header class="ecjia-header">
	<div class="ecjia-header-left">
		<a class="ecjia-header-icon" href="javascript:history.go(-1)"><i class="iconfont icon-jiantou-left"></i></a>
	</div>
	<div class="ecjia-search-header">
		<form class="ecjia-form" action="{url path='goods/category/goods_list'}<!-- {if $id} -->&id={$id}<!-- {/if} -->" data-valid='novalid'  method="post" id="searchForm" name="searchForm">
			<select name="type_val" id="select_type">
				<option value="1">商品</option>
				<option value="2">店铺</option>
			</select>
			<input id="keywordBox" name="keywords" type="search" placeholder="{$lang.no_keywords}" autofocus="autofocus">
			<button type="submit" value="{$lang.search}"><i class="iconfont icon-search"></i></button>
		</form>
	</div>
</header>

<div class="hot-search">
	<p class="title">
		{$lang.hot_search}<a href="">{t}换一批{/t}</a>
	</p>
	<div class="hot-search-list">
		<!-- {foreach from=$tags item=ky} -->
		<a href="{url path='goods/category/goods_list' args="keywords={$ky}"}">{$ky}</a> 
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