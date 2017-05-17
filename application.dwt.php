<?php
/*
Name: 百宝箱模板
Description: 这是百宝箱首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-application-menu">
<div class="function-management">
    &bull;<span>功能管理</span>&bull;
</div>
<nav class="ecjia-mod container-fluid user-nav">
	<ul class="row ecjia-row-nav index">
		<li class="col-sm-3 col-xs-2">
			<a href="{$signup_reward_url}">
				<img src="{$theme_url}images/discover/200_1.png" />
				<p class="text-center">新人有礼</p>
			</a>
		</li>
		<li class="col-sm-3 col-xs-2">
			<a href="{url path='user/index/spread'}">
				<img src="{$theme_url}images/discover/200_2.png" />
				<p class="text-center">推广</p>
			</a>
		</li>
	</ul>
	
	<div class="application-class-code">
	   <img src="{$theme_url}images/discover/50_1.png" />
		<span>促销活动</span>
	</div>
	<ul class="row ecjia-row-nav index">
		<li class="col-sm-3 col-xs-2">
			<a href="{url path='goods/index/new'}">
				<img src="{$theme_url}images/discover/200_3.png" />
				<p class="text-center">新品推荐</p>
			</a>
		</li>
		<li class="col-sm-3 col-xs-2">
			<a href="{url path='goods/index/promotion'}">
				<img src="{$theme_url}images/discover/200_4.png" />
				<p class="text-center">促销商品</p>
			</a>
		</li>
	</ul>
	
	<div class="application-class-code">
	   <img src="{$theme_url}images/discover/50_1.png" />
		<span>百宝箱</span>
	</div>
	
	<ul class="row ecjia-row-nav index">
		<li class="col-sm-3 col-xs-2">
			<a href="https://ecjia.com/daojia.html">
				<img src="{$theme_url}images/discover/200_5.png" />
				<p class="text-center">到家简介</p>
			</a>
		</li>
		<li class="col-sm-3 col-xs-2">
			<a href="https://ecjia.com/wiki/%E5%B8%B8%E8%A7%81%E9%97%AE%E9%A2%98">
				<img src="{$theme_url}images/discover/200_6.png" />
				<p class="text-center">常见问题</p>
			</a>
		</li>
		<li class="col-sm-3 col-xs-2">
			<a href="{url path='user/address/address_list'}">
				<img src="{$theme_url}images/discover/200_7.png" />
				<p class="text-center">收货地址</p>
			</a>
		</li>
		<li class="col-sm-3 col-xs-2">
			<a href="https://ecjia.com/">
				<img src="{$theme_url}images/discover/200_8.png" />
				<p class="text-center">EC+官网</p>
			</a>
		</li>
		<li class="col-sm-3 col-xs-2">
			<a href="https://ecjia.com/wiki/%E5%B8%AE%E5%8A%A9:ECJia%E5%88%B0%E5%AE%B6">
				<img src="{$theme_url}images/discover/200_9.png" />
				<p class="text-center">帮助手册</p>
			</a>
		</li>
		<li class="col-sm-3 col-xs-2">
			<a href="{url path='article/help/init'}">
				<img src="{$theme_url}images/discover/200_10.png" />
				<p class="text-center">帮助中心</p>
			</a>
		</li>
	</ul>
</nav>

</div>
<!-- {/block} -->