<?php 
/*
Name: 帮助中心
Description: 帮助中心首页
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
<form class="ecjia-list ecjia-article" action="" method="post" id="searchForm" name="searchForm">
	<ul class="list-one user-address-list">
		<span>购物流程</span>
		<li>
			<div class="form-group form-group-text">
				<span>如何注册账号</span>
				<i class="ecjiaf-fr iconfont icon-jiantou-right"></i>
			</div>
		</li>
		<li>
			<div class="form-group form-group-text">
				<span>购物流程</span>
				<i class="ecjiaf-fr iconfont icon-jiantou-right"></i>
			</div>
		</li>
		<li>
			<div class="form-group form-group-text">
				<span>如何购买下单</span>
				<i class="ecjiaf-fr iconfont icon-jiantou-right"></i>
			</div>
		</li>
		<li>
			<div class="form-group form-group-text">
				<span>如何查找想要的商品</span>
				<i class="ecjiaf-fr iconfont icon-jiantou-right"></i>
			</div>
		</li>
	</ul>
</form>
<!-- {/block} -->