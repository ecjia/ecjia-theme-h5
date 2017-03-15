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
<div class="store-comment" {if $is_last neq 1}data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{$ajax_url}&type=ajax_get{if $store_id}&store_id={$store_id}{/if}" data-page="2"{/if}>
	{if $comment_list.list}
	<!-- {foreach from=$comment_list.list item=list} -->
	<div class="assess-flat">    
		<div class="assess-wrapper">        
			<div class="assess-top">            
				<span class="user-portrait"><img src="{$theme_url}images/default_user.png"></span>           
				<div class="user-right"> 
					<span class="user-name">{$list.author}</span>     
					<span class="assess-date">{$list.add_time}</span>
				</div>
				<p class="comment-item-star score-goods" data-val="{$list.rank}"></p> 
			</div>        
			<div class="assess-bottom">            
				<p class="assess-content">{$list.content}</p>
				<!-- {if $comment.picture} -->
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
	<!-- {/foreach} -->
	{else}
	<div class="ecjia-merchant-goods ecjia-nolist">
		<p><img src="{$theme_url}images/no_comment.png"></p>
		暂无商品评论
	</div>
	{/if}
</div>