<!-- {block name="ajaxinfo"} -->
<!-- {foreach from=$comment_list.list item=list} -->
<div class="assess-flat">    
	<div class="assess-wrapper">        
		<div class="assess-top">            
			<span class="user-portrait"><img src="{if $list.avatar_img}{$list.avatar_img}{else}{$theme_url}images/default_user.png{/if}"></span>           
			<div class="user-right"> 
				<span class="user-name">{$list.author}</span>     
				<span class="assess-date">{$list.add_time}</span>
			</div>
			<p class="comment-item-star score-goods" data-val="{$list.rank}"></p> 
		</div>        
		<div class="assess-bottom">            
			<p class="assess-content">{$list.content}</p>
			<!-- {if $list.picture} -->
			<div class="img-list">
				<!-- {foreach from=$list.picture item=img} -->
				<img src="{$img}" />
				<!-- {/foreach} -->
			</div>
			<!-- {/if} -->
			<p class="goods-attr">{$list.goods_attr}</p>
			{if $list.reply_content}
			<div class="store-reply">商家回复：{$list.reply_content}</div>
			{/if}
		</div>    
	</div>    
</div>
<!-- {foreachelse} -->
<div class="ecjia-nolist">
	<img src="{$theme_url}images/no_comment.png">
	<p class="tags_list_font">暂无商品评论</p>
</div>
<!-- {/foreach} -->
<!-- {/block} -->