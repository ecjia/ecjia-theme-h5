<?php
/*
Name: 用户中心模板
Description: 这是推广页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript"></script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-application-menu">
<div class="function-management"><hr>&bull;<span>功能管理</span>&bull;<hr></div>
<nav class="ecjia-mod container-fluid user-nav">
	<ul class="row ecjia-row-nav index">
		<li class="col-sm-3 col-xs-2">
			<a href="javascript:;">
				<!-- {if $nav.image} -->
				<img src="https://cityo2o.ecjia.com/content/uploads/data/shortcut/1493925871314835335.png" />
				<!-- {else} -->
				<img src="https://cityo2o.ecjia.com/content/uploads/data/shortcut/1493925871314835335.png" alt="">
				<!-- {/if} -->
				<p class="text-center">新品推荐</p>
			</a>
		</li>
	</ul>
</nav>

</div>
<!-- {/block} -->