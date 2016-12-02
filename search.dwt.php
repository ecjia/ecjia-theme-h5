<?php 
/*
Name: 搜索模板
Description: 这是搜索页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.enter_search();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<header class="ecjia-header">
	<div class="ecjia-header-left">
		<a class="ecjia-header-icon" href="javascript:history.go(-1)"><i class="iconfont icon-jiantou-left"></i></a>
	</div>
	<div class="ecjia-search-header">
		<div class="ecjia-form" data-url="{url path='goods/category/store_list'}{if $store_id neq 0}&store_id={$store_id}{/if}">
			<input id="keywordBox" name="keywords" type="search" placeholder="{if $store_id neq 0}搜索店内商品{else}搜索附近商品和门店{/if}" {if $keywords}value={$keywords}{/if}>
			<button type="button" class="btn-search"><i class="iconfont icon-search"></i></button>
		</div>
	</div>
</header>

<div class="ecjia-search-history">
	<p class="title">
		<i class="iconfont icon-time"></i>{t}搜索历史{/t}{if $searchs}<a class="nopjax" data-toggle="del_history" href="{url path='touch/index/del_search'}{if $store_id}&store_id={$store_id}{/if}">{t}清除记录{/t}</a>{/if}
	</p>
	<!-- {if $searchs} -->
	<div class="ecjia-list">
		<ul>
			<!-- {foreach from=$searchs item=search} -->
			<li><a href='{url path="goods/category/store_list" args="{if $store_id neq 0}store_id={$store_id}&{/if}keywords={$search}"}'>{$search}</a></li>
			<!-- {/foreach} -->
		</ul>
	</div>
	<!-- {/if} -->
</div>
<!-- {/block} -->