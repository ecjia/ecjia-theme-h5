<?php 
/*
Name:选择定位模板
Description: 选择定位模板，当前和搜索关键词
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.region_change();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-zs">
	<div class="ecjia-zt a1">
		<input class="ecjia-zv defaultWidth" type="text" placeholder="小区， 写字楼， 学校" maxlength="50">
	</div>
	<div class="ecjia-zw">
		<div class="ecjia-zx">
			<i></i>
			<p>点击定位当前地点</p>
		</div>
	</div>
</div>

<!-- {/block} -->

