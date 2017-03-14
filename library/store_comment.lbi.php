<?php
/*
Name: 店铺评论及商品评论
Description: 这是店铺及商品评论页面
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="store-option">
	<dl class="active">
		<dt>全部</dt>
		<dd>(290)</dd>
	</dl>
	<dl>
		<dt>好评</dt>
		<dd>(55)</dd>
	</dl>
	<dl>
		<dt>中评</dt>
		<dd>(13)</dd>
	</dl>
	<dl>
		<dt>差评</dt>
		<dd>(22)</dd>
	</dl>
	<dl>
		<dt>晒图</dt>
		<dd>(4)</dd>
	</dl>
</div>
<div class="store-comment">
	{if $comment_list}
	<div class="assess-flat">    
		<div class="assess-wrapper">        
			<div class="assess-top">            
				<span class="user-portrait"><img src="{$theme_url}images/default_user.png"></span>
				<div class="user-right">            
					<span class="user-name">j***9</span>  
					<span class="assess-date">2017-03-03</span>
				</div>
				<span class="comment-item-star"><span class="real-star comment-stars-width5"></span></span> 
			</div>        
			<div class="assess-bottom">            
				<p class="assess-content">商品不错，很好吃，很满意的一次购物。</p>
				<div class="img-list">
					<img src="{$theme_url}images/default-goods-pic.png" />
					<img src="{$theme_url}images/default-goods-pic.png" />
					<img src="{$theme_url}images/default-goods-pic.png" />
					<img src="{$theme_url}images/default-goods-pic.png" />
					<img src="{$theme_url}images/default-goods-pic.png" />
				</div>
				<p class="goods-attr">属性：275g/进口</p>
				<div class="store-reply">商家回复：谢谢您对我们的赞赏，希望以后多多光顾！谢谢您对我们的赞赏，希望以后多多光顾！谢谢您对我们的赞赏，希望以后多多光顾！谢谢您对我们的赞赏，希望以后多多光顾！谢谢您对我们的赞赏，希望以后多多光顾！谢谢您对我们的赞赏，希望以后多多光顾！谢谢您对我们的赞赏，希望以后多多光顾！谢谢您对我们的赞赏，希望以后多多光顾！谢谢您对我们的赞赏，希望以后多多光顾！谢谢您对我们的赞赏，希望以后多多光顾！</div>
			</div>    
		</div>    
	</div>
	{else}
	<div class="ecjia-merchant-goods ecjia-nolist">
		<p><img src="{$theme_url}images/no_comment.png"></p>
		暂无商品评论
	</div>
	{/if}
</div>