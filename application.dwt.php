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
	    <span>&bull;&nbsp;&nbsp;&nbsp;{t domain="h5"}功能管理{/t}&nbsp;&nbsp;&nbsp;&bull;</span>
	</div>
	<nav class="ecjia-mod container-fluid user-nav">
		<ul class="row ecjia-row-nav index">
			<li class="col-sm-3 col-xs-2">
				<a href="{$signup_reward_url}">
					<img src="{$theme_url}images/discover/200_1.png" />
					<p class="text-center">{t domain="h5"}新人有礼{/t}</p>
				</a>
			</li>
			<li class="col-sm-3 col-xs-2">
				<a href="{url path='user/index/spread'}">
					<img src="{$theme_url}images/discover/200_2.png" />
					<p class="text-center">{t domain="h5"}推广{/t}</p>
				</a>
			</li>
		</ul>
		
		<div class="application-class-code">
		   <img src="{$theme_url}images/discover/50_1.png" />
			<span>{t domain="h5"}促销活动{/t}</span>
		</div>
		<ul class="row ecjia-row-nav index">
			<li class="col-sm-3 col-xs-2">
				<a href="{url path='goods/index/new'}">
					<img src="{$theme_url}images/discover/200_3.png" />
					<p class="text-center">{t domain="h5"}新品推荐{/t}</p>
				</a>
			</li>
			<li class="col-sm-3 col-xs-2">
				<a href="{url path='goods/index/promotion'}">
					<img src="{$theme_url}images/discover/200_4.png" />
					<p class="text-center">{t domain="h5"}促销商品{/t}</p>
				</a>
			</li>
		</ul>
		
		<div class="application-class-code">
		   <img src="{$theme_url}images/discover/50_1.png" />
			<span>{t domain="h5"}百宝箱{/t}</span>
		</div>
		
		<ul class="row ecjia-row-nav index">
		<!--{foreach from=$data item=item}-->
			<li class="col-sm-3 col-xs-2">
				<a href="{$item.url}">
					<img src="{$item.image}" />
					<p class="text-center">{$item.text}</p>
				</a>
			</li>
		<!-- {/foreach} -->
		</ul>
	</nav>
</div>
<!-- {/block} -->