<?php 
/*
Name: 商品评论列表模板
Description: 商品评论列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div>
	<!-- #BeginLibraryItem "/library/comments_list.lbi" -->
	<!-- #EndLibraryItem -->
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
<!-- {foreach from=$comment_list item=comment} -->
<li>
	<div class="comment-top">
		<div class="user-img"><img class="ecjiaf-fl ecjia-margin-r" src="{$comment.user_img}"></div>
		<span class="ecjiaf-fl">
			<p>
				<!--{if $comment.username}-->
				{$comment.username|escape:html}
				<!--{else}-->
				{$lang.anonymous}
				<!--{/if}-->
			</p>
			<p>
				<span class="rating rating{$comment.rank}">
					<span class="star"></span>
					<span class="star"></span>
					<span class="star"></span>
					<span class="star"></span>
					<span class="star"></span>
				</span>
			</p>
		</span>
		<span class="comment-add-time ecjiaf-fr">{$comment.add_time}</span>
	</div>
	<div class="comment-bottom">
		<p class="ecjia-margin-t ecjiaf-wwb">{$comment.content}</p>
		<!-- {if $comment.re_content} -->
		<p class="ecjiaf-fl">
			<div class="ecjia-margin-t comment-back">商家回复:</div>
			{$comment.re_content}
		</p>
		<!-- {/if} -->
	</div>
</li>
<!-- {foreachelse} -->
<div class="ecjia-nolist">
	<i class="iconfont icon-comment"></i>
	<p>该商品还没有评价</p>
</div>
<!-- {/foreach} -->
<!-- {/block} -->