<?php 
/*
Name: 品牌列表模板
Description: 这是品牌列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.goods.init();</script>
<script type="text/javascript">
	get_asynclist("{url path='brand/asynclist' args="page={$page}&sort={$sort}&order={$order}"}" , '{$theme_url}images/loader.gif');
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="activity_con"></div>
<header class="ecjia-header">
	<a class="ecjia-header-icon" href="javascript:history.go(-1)"><i class="glyphicon glyphicon-menu-left"></i></a>
	<p>{$title}</p>
</header>
<div class="bran_list" id="J_ItemList">
	<ul class="single_item"></ul>
	<a class="get_more" href="javascript:;"></a>
</div>
<!-- {/block} -->