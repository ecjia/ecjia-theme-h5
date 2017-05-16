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
				<div class="swiper-slide"><a href="{RC_Uri::url('user/index/spread')}"><img src="{$theme_url}images/discover/200_1.png" /><span>百宝箱</span></a></div>
				<div class="swiper-slide"><a href="{$signup_reward_url}"><img src="{$theme_url}images/user_center/newbie_gift75_1.png" /><span>新人有礼</span></a></div>
				<div class="swiper-slide"><a href="{RC_Uri::url('user/index/spread')}"><img src="{$theme_url}images/user_center/expand.png" /><span>推广</span></a></div>
				<div class="swiper-slide"><a href="{RC_Uri::url('goods/index/new')}"><img src="{$theme_url}images/discover/200_3.png" /><span>新品推荐</span></a></div>
				<div class="swiper-slide"><a href="{RC_Uri::url('goods/index/promotion')}"><img src="{$theme_url}images/discover/200_4.png" /><span>促销商品</span></a></div>
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
	
	<div class="ecjia-article article-list">
		<div class="article clearfix"> 
			<a href="{RC_Uri::url('discover/article/detail')}&article_id=1">
				<div class="article-left"> 
					<p class="article-title line-clamp2"> 考试季你还差点儿啥 </p> 
					<p class="article-summary line-clamp2"> 考试，是个令人纠结的事情。想到考试就会想到放假，恨不得日子如梭,立马奔向悠长的暑假,却又巴不得日子一点一点挪动,不要靠近放假前的那道门槛——考试。 讨厌考试吗?当然！但是又没得选择。随着高考、中考的临近和各学校期末考试的到来，“考试季”正在悄悄逼近，小商品城的“文具经济”开始升温发酵，考试除了要准备文具还要准备些什么呢，跟着我们一起来看一看吧！</p> 
					<div class="article-author clearfix" data-lazy="false"> 
						<img class="lazy-img article-author-pic" src="{$theme_url}images/store_default.png"> 
						<span class="lazy-img article-author-name">测试店铺名称</span> 
					</div> 
				</div> 
				<div class="article-right" data-lazy="false"> 
					<div class="img-box"> 
						<img class="lazy-img" src="{$theme_url}images/screenshot.png"> 
					</div> 
					<div class="article-info clearfix"> 
						<div class="article-time"> 
							<div class="clock little-icon"></div> 
							<span>16小时前</span> 
						</div> 
						<div class="article-viewed"> 
							<span>21497</span> 
							<div class="eye little-icon"></div> 
						</div> 
					</div> 
				</div>
			</a> 
		</div>
		
		<div class="article clearfix"> 
			<div class="article-left"> 
				<p class="article-title line-clamp2"> 考试季你还差点儿啥 </p> 
				<p class="article-summary line-clamp2"> 考试，是个令人纠结的事情。想到考试就会想到放假，恨不得日子如梭,立马奔向悠长的暑假,却又巴不得日子一点一点挪动,不要靠近放假前的那道门槛——考试。 讨厌考试吗?当然！但是又没得选择。随着高考、中考的临近和各学校期末考试的到来，“考试季”正在悄悄逼近，小商品城的“文具经济”开始升温发酵，考试除了要准备文具还要准备些什么呢，跟着我们一起来看一看吧！</p> 
				<div class="article-author clearfix" data-lazy="false"> 
					<img class="lazy-img article-author-pic" src="{$theme_url}images/store_default.png"> 
					<span class="lazy-img article-author-name">测试店铺名称</span> 
				</div> 
			</div> 
			<div class="article-right" data-lazy="false"> 
				<div class="img-box"> 
					<img class="lazy-img" src="{$theme_url}images/screenshot.png"> 
				</div> 
				<div class="article-info clearfix"> 
					<div class="article-time"> 
						<div class="clock little-icon"></div> 
						<span>16小时前</span> 
					</div> 
					<div class="article-viewed"> 
						<span>21497</span> 
						<div class="eye little-icon"></div> 
					</div> 
				</div> 
			</div> 
		</div>
		
		<div class="article clearfix"> 
			<div class="article-left"> 
				<p class="article-title line-clamp2"> 考试季你还差点儿啥 </p> 
				<p class="article-summary line-clamp2"> 考试，是个令人纠结的事情。想到考试就会想到放假，恨不得日子如梭,立马奔向悠长的暑假,却又巴不得日子一点一点挪动,不要靠近放假前的那道门槛——考试。 讨厌考试吗?当然！但是又没得选择。随着高考、中考的临近和各学校期末考试的到来，“考试季”正在悄悄逼近，小商品城的“文具经济”开始升温发酵，考试除了要准备文具还要准备些什么呢，跟着我们一起来看一看吧！</p> 
				<div class="article-author clearfix" data-lazy="false"> 
					<img class="lazy-img article-author-pic" src="{$theme_url}images/store_default.png"> 
					<span class="lazy-img article-author-name">测试店铺名称</span> 
				</div> 
			</div> 
			<div class="article-right" data-lazy="false"> 
				<div class="img-box"> 
					<img class="lazy-img" src="{$theme_url}images/screenshot.png"> 
				</div> 
				<div class="article-info clearfix"> 
					<div class="article-time"> 
						<div class="clock little-icon"></div> 
						<span>16小时前</span> 
					</div> 
					<div class="article-viewed"> 
						<span>21497</span> 
						<div class="eye little-icon"></div> 
					</div> 
				</div> 
			</div> 
		</div>
		
		<div class="article clearfix"> 
			<div class="article-left"> 
				<p class="article-title line-clamp2"> 考试季你还差点儿啥 </p> 
				<p class="article-summary line-clamp2"> 考试，是个令人纠结的事情。想到考试就会想到放假，恨不得日子如梭,立马奔向悠长的暑假,却又巴不得日子一点一点挪动,不要靠近放假前的那道门槛——考试。 讨厌考试吗?当然！但是又没得选择。随着高考、中考的临近和各学校期末考试的到来，“考试季”正在悄悄逼近，小商品城的“文具经济”开始升温发酵，考试除了要准备文具还要准备些什么呢，跟着我们一起来看一看吧！</p> 
				<div class="article-author clearfix" data-lazy="false"> 
					<img class="lazy-img article-author-pic" src="{$theme_url}images/store_default.png"> 
					<span class="lazy-img article-author-name">测试店铺名称</span> 
				</div> 
			</div> 
			<div class="article-right" data-lazy="false"> 
				<div class="img-box"> 
					<img class="lazy-img" src="{$theme_url}images/screenshot.png"> 
				</div> 
				<div class="article-info clearfix"> 
					<div class="article-time"> 
						<div class="clock little-icon"></div> 
						<span>16小时前</span> 
					</div> 
					<div class="article-viewed"> 
						<span>21497</span> 
						<div class="eye little-icon"></div> 
					</div> 
				</div> 
			</div> 
		</div>
		
		<div class="article clearfix"> 
			<div class="article-left"> 
				<p class="article-title line-clamp2"> 考试季你还差点儿啥 </p> 
				<p class="article-summary line-clamp2"> 考试，是个令人纠结的事情。想到考试就会想到放假，恨不得日子如梭,立马奔向悠长的暑假,却又巴不得日子一点一点挪动,不要靠近放假前的那道门槛——考试。 讨厌考试吗?当然！但是又没得选择。随着高考、中考的临近和各学校期末考试的到来，“考试季”正在悄悄逼近，小商品城的“文具经济”开始升温发酵，考试除了要准备文具还要准备些什么呢，跟着我们一起来看一看吧！</p> 
				<div class="article-author clearfix" data-lazy="false"> 
					<img class="lazy-img article-author-pic" src="{$theme_url}images/store_default.png"> 
					<span class="lazy-img article-author-name">测试店铺名称</span> 
				</div> 
			</div> 
			<div class="article-right" data-lazy="false"> 
				<div class="img-box"> 
					<img class="lazy-img" src="{$theme_url}images/screenshot.png"> 
				</div> 
				<div class="article-info clearfix"> 
					<div class="article-time"> 
						<div class="clock little-icon"></div> 
						<span>16小时前</span> 
					</div> 
					<div class="article-viewed"> 
						<span>21497</span> 
						<div class="eye little-icon"></div> 
					</div> 
				</div> 
			</div> 
		</div>
	</div>
	<!-- #BeginLibraryItem "/library/model_bar.lbi" --><!-- #EndLibraryItem -->
</div>

<div class="ecjia-down-navi clearfix down-transition"> 
	<div class="navi-title">已有分类</div>
	<span class="close_div">X</span>
	<ul class="navi-list">
		<li class="navi active"><p class="navi-name">精选</p></li>
		<li class="navi"><p class="navi-name">家居家装</p></li>
		<li class="navi"><p class="navi-name">服装首饰</p></li>
		<li class="navi"><p class="navi-name">电脑办公</p></li>
		<li class="navi"><p class="navi-name">食品饮料</p></li>
		<li class="navi"><p class="navi-name">手机数码</p></li>
		<li class="navi"><p class="navi-name">运动户外</p></li>
		<li class="navi"><p class="navi-name">家用电器</p></li>
	</ul>
</div>
<!-- {/block} -->