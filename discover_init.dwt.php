<?php 
/*
Name: 发现页
Description: 帮助发现首页
Libraries: model_bar
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.index.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->

<div class="ecjia-discover clearfix pb_50">
	<div class="ecjia-discover-icon">
		<div class="swiper-container" id="swiper-discover-icon">
			<div class="swiper-wrapper">
				<div class="swiper-slide"><a href="{RC_Uri::url('mobile/discover/init')}"><img src="{$theme_url}images/discover/50_6.png" /><span>百宝箱</span></a></div>
				<div class="swiper-slide"><a href="{$signup_reward_url}"><img src="{$theme_url}images/discover/50_2.png" /><span>新人有礼</span></a></div>
				<div class="swiper-slide"><a href="{RC_Uri::url('user/index/spread')}"><img src="{$theme_url}images/discover/50_3.png" /><span>推广</span></a></div>
				<div class="swiper-slide"><a href="{RC_Uri::url('goods/index/new')}"><img src="{$theme_url}images/discover/50_4.png" /><span>新品推荐</span></a></div>
				<div class="swiper-slide"><a href="{RC_Uri::url('goods/index/promotion')}"><img src="{$theme_url}images/discover/50_5.png" /><span>促销商品</span></a></div>
			</div>
		</div>
	</div>
	
	<!-- {if $cycleimage} -->
	<div class="ecjia-discover-cycleimage">
		<div class="swiper-container" id="swiper-discover-cycleimage">
			<div class="swiper-wrapper">
				<!--{foreach from=$cycleimage item=img}-->
				<div class="swiper-slide"><a href="{$img.url}"><img src="{$img.photo.url}" /></a></div>
				<!--{/foreach}-->
			</div>
			<div class="swiper-pagination"></div>
		</div>
	</div>
	<!-- {/if} -->
	
	<div class="ecjia-discover-article">
		<div class="swiper-container" id="swiper-article-cat">
			<div class="swiper-wrapper">
				<div class="swiper-slide active" data-url="{url path='article/index/ajax_article_list'}&action_type=stickie" data-type="stickie">精选</div>
				<!-- {foreach from=$article_cat item=cat key=key} -->
				<div class="swiper-slide" data-url="{url path='article/index/ajax_article_list'}&action_type={$cat.cat_id}" data-type="{$cat.cat_id}">{$cat.cat_name}</div>
				<!-- {/foreach} -->
			</div>
		</div>
		<div class="article-add"><i class="iconfont icon-add"></i></div>
	</div>
	
	<div class="article-container">
		<ul class="ecjia-article article-list" id="discover-article-list" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='article/index/ajax_article_list'}" data-type="stickie">
		</ul>
	</div>
	<!-- #BeginLibraryItem "/library/model_bar.lbi" --><!-- #EndLibraryItem -->
</div>

<div class="ecjia-down-navi clearfix down-transition"> 
	<div class="navi-title">已有分类</div>
	<span class="close_div">X</span>
	<ul class="navi-list">
		<!-- {foreach from=$article_cat item=cat key=key} -->
		<li class="navi {if $key eq 0}active{/if}" data-id="{$cat.cat_id}"><p class="navi-name">{$cat.cat_name}</p></li>
		<!-- {/foreach} -->
	</ul>
</div>
<!-- {/block} -->