<?php 
/*
Name: 发现文章详情
Description: 发现文章详情
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
<div class="ecjia-discover-detail">
	<div class="author-header"> 
		<h1 class="article-title">这只神笔1600万种颜色可任你取</h1> 
		<div class="author-head clear-fix" data-lazy="false"> 
			<img class="author-pic lazy-img" src="{$theme_url}images/default_user.png"> 
			<span class="author-name">潮流酷潮玩</span> 
		</div> 
	</div>
	<div class="article-container">
		<div class="article-content clearfix"> 
			<p class="article-p">CRONZY是一支智能画笔，它相当于一个彩色扫描仪，用笔尾贴近取色的对象，按下开关，笔中内置的墨水盒能通过微马达自动合成这种颜色。</p>  
		</div>
		
		<div class="article-content clearfix goods-list"> 
			<div class="article-content-sku clearfix" data-lazy="false"> 
				<img class="content-sku-img lazy-img" src="https://cityo2o.ecjia.com/content/uploads/images/201611/goods_img/1128_G_1478110977787.jpg"> 
				<div class="content-sku-right"> 
					<p class="content-sku-name line-clamp2">派克（PARKER）威雅系列笔 礼品/礼物 办公用品 钢笔男女 学生钢笔 文具 礼品笔 威雅钢杆白夹宝珠笔</p> 
					<div class="content-sku-bottom clearfix"> 
						<span class="sku-price ellipsis">¥118.00</span>  
						<span class="buy-btn">去购买</span> 
					</div> 
				</div> 
			</div>  
		</div>
		
		<div class="article-content clearfix goods-list"> 
			<div class="article-content-sku clearfix" data-lazy="false"> 
				<img class="content-sku-img lazy-img" src="https://cityo2o.ecjia.com/content/uploads/images/201611/goods_img/1128_G_1478110977787.jpg"> 
				<div class="content-sku-right"> 
					<p class="content-sku-name line-clamp2">派克（PARKER）威雅系列笔 礼品/礼物 办公用品 钢笔男女 学生钢笔 文具 礼品笔 威雅钢杆白夹宝珠笔</p> 
					<div class="content-sku-bottom clearfix"> 
						<span class="sku-price ellipsis">¥118.00</span>  
						<span class="buy-btn">去购买</span> 
					</div> 
				</div> 
			</div>  
		</div>
	</div>
	
	<div class="author-panel"> 
		<div class="author-pic-box" data-lazy="false"> 
		<img class="author-pic lazy-img" src="{$theme_url}images/default_user.png"> </div> 
		<div class="author-title clearfix"> 
			<span class="author-name ellipsis">潮流酷潮玩</span> 
		</div> 
		<p class="author-desc"> 
			<span>共177篇资讯</span> 
		</p>  
		<div class="enter-store">进入店铺</div> 
	</div>
	
	<div class="floor"> 
        <!-- {if $goods_info.related_goods} -->
        <div class="ecjia-margin-t">
			<div class="floor-title"> 
				<span class="floor-title-cn">相关商品</span> 
				<span class="floor-title-en">Related Products</span> 
			</div> 
            <div class="form-group ecjia-form ecjia-like-goods-list">
                <div class="bd">
					<ul class="ecjia-list ecjia-like-goods-list">
						<!--{foreach from=$goods_info.related_goods item=goods name=goods}-->
						<!-- {if $smarty.foreach.goods.index < 6 } -->
						<li>
							<a href='{url path="goods/index/show" args="goods_id={$goods.goods_id}"}'>
								<img src="{$goods.img.url}" alt="{$goods.name}" title="{$goods.name}"/>
							</a>
							<p class="link-goods-name ecjia-goods-name-new">{$goods.name}</p>
							<div class="link-goods-price">
								<!--{if $goods.promote_price}-->
								<span class="goods-price">{$goods.promote_price}</span>
								<!--{else}-->
								<span class="goods-price">{$goods.shop_price}</span>
								<!--{/if}-->
								{if $goods.specification}
									<div class="goods_attr goods_spec_{$goods.goods_id}" goods_id="{$goods_info.id}">
										<span class="choose_attr spec_goods" rec_id="{$goods.rec_id}" goods_id="{$goods.goods_id}" data-num="{$goods.num}" data-spec="{$goods.default_spec}" data-url="{RC_Uri::url('cart/index/check_spec')}" data-store="{$store_id}">选规格</span>
										{if $goods.num}<i class="attr-number">{$goods.num}</i>{/if}
									</div>
								{else}
									<span class="goods-price-plus may_like_{$goods.goods_id}" data-toggle="add-to-cart" rec_id="{$goods.rec_id}" goods_id="{$goods.goods_id}" data-num="{$goods.num}"></span>
								{/if}
							</div>
						</li>
						<!--{/if}-->
						<!--{/foreach}-->
					</ul>
				</div>
            </div>
        </div>
		<!-- {/if} -->
		<div class="view-more-goods">查看更多商品</div> 
	</div>
	
	<div class="floor comment-floor" name="floor-comment" id="floor-comment"> 
		<div class="background-fff">
			<div class="floor-title"> 
				<span class="floor-title-cn">评论</span> 
				<span class="floor-title-en">Comments</span> 
			</div> 
			<div class="floor-content">
				<ul>
					<li class="comment-item">
						<div class="comment-left">
							<img src="{$theme_url}images/default_user.png" >
						</div>
						<div class="comment-right">
							<div class="user-name">nuomi<div class="time">刚刚</div></div>
							<div class="content">8848钛金手机专为追求个性与品位的高端用户私人订制，如果你是这样的用户，并且准备趁着517电信节选购一部适合自己的手机，那这个机会一定不要错过了！</div>
						</div>
					</li>
					
					<li class="comment-item">
						<div class="comment-left">
							<img src="{$theme_url}images/default_user.png" >
						</div>
						<div class="comment-right">
							<div class="user-name">nuomi<div class="time">刚刚</div></div>
							<div class="content">8848钛金手机专为追求个性与品位的高端用户私人订制，如果你是这样的用户，并且准备趁着517电信节选购一部适合自己的手机，那这个机会一定不要错过了！</div>
						</div>
					</li>
					
					<li class="comment-item">
						<div class="comment-left">
							<img src="{$theme_url}images/default_user.png" >
						</div>
						<div class="comment-right">
							<div class="user-name">nuomi<div class="time">刚刚</div></div>
							<div class="content">8848钛金手机专为追求个性与品位的高端用户私人订制，如果你是这样的用户，并且准备趁着517电信节选购一部适合自己的手机，那这个机会一定不要错过了！</div>
						</div>
					</li>
					
					<li class="comment-item">
						<div class="comment-left">
							<img src="{$theme_url}images/default_user.png" >
						</div>
						<div class="comment-right">
							<div class="user-name">nuomi<div class="time">刚刚</div></div>
							<div class="content">8848钛金手机专为追求个性与品位的高端用户私人订制，如果你是这样的用户，并且准备趁着517电信节选购一部适合自己的手机，那这个机会一定不要错过了！</div>
						</div>
					</li>
				</ul>
			</div>
        </div>
	</div>
	
	<nav class="nav-bt-fix">
		<div class="nav-bt-center">
	        <a href="javascript:;">
	        	<i class="iconfont icon-appreciate active"><span>999999</span></i>
	        </a>
	        <a href="javascript:;">
	        	<i class="iconfont icon-bianji1"><span>999999</span></i>
	        </a>
	        <a href="#floor-comment">
	        	<i class="iconfont icon-comment"><span>999999</span></i>
	        </a>
        </div>    
    </nav>
    
    <div class="send-box">
        <div class="textarea-box">
            <textarea cols="30" rows="3"></textarea>
            <a class="xin-btn xin-btn-small send-btn" href="javascript:void(0);">发送</a>
        </div>
    </div>
    <div class="a53"></div>
</div>
<!-- {/block} -->