<?php
/*
Name: 精选大牌
Description: 这是首页的精选大牌模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {if $brand_list} -->
<div class="ecjia-mod ecjia-mod-brand ecjia-margin-t">
	<div class="hd">
		<h2><i class="iconfont icon-dapai"></i>{t}精选大牌{/t}</h2>
	</div>
	<div class="bd">
		<!--{foreach from=$brand_list item=brand}-->
		<a href="{url path='goods/category/goods_list' args="cid=0&brand={$brand.brand_id}"}"><div class="ecjia-div"><img src="{$brand.brand_logo}" alt="{$brand.brand_name}" /></div></a>
		<!--{/foreach}-->
	</div>
</div>
<!-- {/if} -->
