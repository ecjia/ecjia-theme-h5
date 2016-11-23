<?php
/*
Name: 首页header模块
Description: 这是首页的header模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.searchbox_foucs();</script>
<!-- {/block} -->

<header class="ecjia-header ecjia-header-index">
	<div class="ecjia-search-header">
		<span class="bg" data-url="{RC_Uri::url('touch/index/search')}" {if $keywords}style="text-align: left;" data-val="{$keywords}"{/if}>
			<i class="iconfont icon-search"></i>{if $keywords}<span class="keywords">{$keywords}</span>{else}搜索附近商品和门店{/if}
		</span>
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
