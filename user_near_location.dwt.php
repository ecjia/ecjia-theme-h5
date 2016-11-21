<?php 
/*
Name: 定位当前位置模板
Description: 定位当前位置页
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
	<div class="address-backgroundw">
		<span>上海市</span>
		<i class="iconfont icon-jiantou-bottom"></i>
		<i class="iconfont icon-search"></i>
		<input id="keywordBox" name="keywords" type="search" placeholder="请输入搜索关键词！">
	</div>
	<ul class="list-one user-address-list">
		<li>
			<div class="form-group form-group-text">
				<i class="iconfont icon-location"></i><span>华东师范大学（中北校区）</span>
				<p>普陀区中山北路3556号</p>
			</div>
		</li>
		<li>
			<div class="form-group form-group-text">
				<i class="iconfont icon-location"></i><span>伸大厦-东门</span>
				<p>普陀区中山北路3553号</p>
			</div>
		</li>
		<li>
			<div class="form-group form-group-text">
				<i class="iconfont icon-location"></i><span>智学教育</span>
				<p>普陀区中山北路3556号</p>
			</div>
		</li>
	</ul>
</form>
<!-- {/block} -->