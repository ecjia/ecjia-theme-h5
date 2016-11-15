<?php
/*
Name: 商品评论
Description: 这是商品评论列表页
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<div>
	<ul class="ecjia-list ecjia-list-four comment-list-nav">
		<li class="{if $rank eq 0} active{/if}">
			<a data-rh="1" href='{url path="comment/index/init" args="rank=0&id={$id}"}' role="tab">
				<p>{$lang.all_comment}</p><p>{$comments_info.all_comment}条评论</p>
			</a>
		</li>
		<li class="{if $rank eq 1} active{/if}">
			<a data-rh="1" href='{url path="comment/index/init" args="rank=1&id={$id}"}' role="tab">
				<p>{$lang.favorable_comment}</p><p>{$comments_info.favorable_count}条评论</p>
			</a>
		</li>
		<li class="{if $rank eq 2} active{/if}">
			<a data-rh="1" href='{url path="comment/index/init" args="rank=2&id={$id}"}' role="tab">
				<p>{$lang.medium_comment}</p><p>{$comments_info.medium_count}条评论</p>
			</a>
		</li>
		<li class="{if $rank eq 3} active{/if}">
			<a data-rh="1" href='{url path="comment/index/init" args="rank=3&id={$id}"}' role="tab">
				<p>{$lang.bad_comment}</p><p>{$comments_info.bad_count}条评论</p>
			</a>
		</li>
	</ul>
</div>

<div>
	<div class="comment-content active ecjia-margin-t">
		<ul class="ecjia-list goods-comment-list" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='async_comment_list' args="rank={$rank}&id={$id}"}" data-size="5">

		</ul>
	</div>
</div>
