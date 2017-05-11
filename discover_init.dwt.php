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
<script type="text/javascript">
	ecjia.touch.index.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-discover clearfix">
	<div class="ecjia-discover-icon">
		<div class="swiper-container" id="swiper-discover-icon">
			<div class="swiper-wrapper">
				<div class="swiper-slide"><a href="{RC_Uri::url('user/index/spread')}"><img src="{$theme_url}images/user_center/expand.png" /><span>推广</span></a></div>
				<div class="swiper-slide"><a href="{RC_Uri::url('user/account/init')}"><img src="{$theme_url}images/user_center/50x50_1.png" /><span>钱包</span></a></div>
				<div class="swiper-slide"><a href="{RC_Uri::url('goods/index/new')}"><img src="{$theme_url}images/icon/new.png" /><span>新品推荐</span></a></div>
				<div class="swiper-slide"><a href="{RC_Uri::url('goods/index/promotion')}"><img src="{$theme_url}images/icon/promotion.png" /><span>促销商品</span></a></div>
				<div class="swiper-slide"><a href="{RC_Uri::url('merchant/index/position')}&shop_address={$smarty.cookies.location_name}"><img src="{$theme_url}images/user_center/50x50_6.png" /><span>地图</span></a></div>
				<div class="swiper-slide"><a href="{$signup_reward_url}"><img src="{$theme_url}images/user_center/newbie_gift75_1.png" /><span>新人有礼</span></a></div>
				<div class="swiper-slide"><a href="{url path='article/help/init'}"><img src="{$theme_url}images/user_center/help_center.png" /><span>帮助中心</span></a></div>
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
				<div class="swiper-slide active">精选</div>
				<div class="swiper-slide">家居家装</div>
				<div class="swiper-slide">服装首饰</div>
				<div class="swiper-slide">电脑办公</div>
				<div class="swiper-slide">食品饮料</div>
				<div class="swiper-slide">手机数码</div>
				<div class="swiper-slide">运动户外</div>
			</div>
		</div>
		<div class="article-add"><i class="iconfont icon-add"></i></div>
	</div>
</div>
<!-- {/block} -->