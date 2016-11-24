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

<div class="ecjia-header ecjia-header-index">
	<div class="ecjia-search-header">
		<span class="bg" data-url="{RC_Uri::url('touch/index/search')}" {if $keywords}style="text-align: left;" data-val="{$keywords}"{/if}>
			<i class="iconfont icon-search"></i>{if $keywords}<span class="keywords">{$keywords}</span>{else}搜索附近商品和门店{/if}
		</span>
	</div>
</div>
