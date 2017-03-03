<?php
/*
Name: 店铺评论及商品评论
Description: 这是店铺及商品评论页面
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>

<div class="store-option">
	<li class="active">全部(290)</li>
	<li>晒图(55)</li>
	<li>好评(13)</li>
	<li>中评(22)</li>
	<li>差评(4)</li>
</div>
<div class="store-comment">
	<!-- 测试数据 -->
	<div class="assess-flat">    
		<span class="assess-wrapper">        
			<div class="assess-top">            
				<span class="user-portrait">                
				<img src="{$theme_url}images/default_user.png"></span>            
				
				<span class="user-name">j***9</span>     
				<span class="assess-date">2017-03-03</span>
				<span class="comment-item-star">         
					<span class="real-star comment-stars-width5"></span>
				</span> 
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
			</div>    
		</span>    
	</div>
</div>

<!-- {block name="ajaxinfo"} -->
<!-- {foreach from=$comment_list item=list} -->
<div class="assess-flat">    
	<span class="assess-wrapper">        
		<div class="assess-top">            
			<span class="user-portrait">                
			<img src="{$theme_url}images/default_user.png"></span>            
			
			<span class="user-name">j***9</span>     
			<span class="assess-date">2017-03-03</span>
			<span class="comment-item-star">         
				<span class="real-star comment-stars-width5"></span>
			</span> 
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
		</div>    
	</span>    
</div>
<!-- {foreachelse} -->	
<div class="ecjia-nolist">
	<p><img src=""></p>
	暂无评论
</div>
<!-- {/foreach} -->	
<!-- {/block} -->