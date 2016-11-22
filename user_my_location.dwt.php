<?php 
/*
Name: 我的位置模板
Description: 我的位置
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.region_change();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<form class="ecjia-list ecjia-address-list" action="" method="post" id="searchForm" name="searchForm">
	<div class="address-background-mylocation">
		<i class="iconfont icon-search"></i>
		<input id="keywordBox" name="keywords" type="search" placeholder="搜索地点">
	</div>
	
</form>
<!-- {/block} -->