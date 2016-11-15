<?php 
/*
Name:品牌列表模板
Description: 这是品牌列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.goods.init();</script>
<script type="text/javascript">
	<!--{if $show_asynclist}-->
		get_asynclist("{url path='brand/list_asynclist' args="id={$id'],'brand={$brand_id'],'price_min={$price_min'],'price_max={$price_max'],'filter_attr={$filter_attr'],'page={$page'],'sort={$sort'],'order={$order'],'keywords={$keywords}"}" , '{$theme_url}dist/images/loader.gif');
	<!--{/if}-->
</script>
<!-- {/block} -->

<!-- {block name="ecjia"} -->
<div style="height:7.2em;"></div>
<header class="ecjia-header">
	<a class="ecjia-header-icon" href="javascript:history.go(-1)"><i class="glyphicon glyphicon-menu-left"></i></a>
	<p>{$title}</p>
</header>
<!-- #BeginLibraryItem "/library/goods_list_brand.lbi" -->
<!-- #EndLibraryItem -->

<!-- {/block} -->
