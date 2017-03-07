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