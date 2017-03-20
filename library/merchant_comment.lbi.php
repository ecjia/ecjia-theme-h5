<?php
/*
Name: 店铺评论及商品评论
Description: 这是店铺及商品评论页面
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="store-option">
	<dl class="active" data-url="{$ajax_url}&action_type=all&status=toggle" data-type="all">
		<dt>全部</dt>
		<dd>({$comment_number.all})</dd>
	</dl>
	<dl data-url="{$ajax_url}&action_type=good&status=toggle" data-type="good">
		<dt>好评</dt>
		<dd>({$comment_number.good})</dd>
	</dl>
	<dl data-url="{$ajax_url}&action_type=general&status=toggle" data-type="general">
		<dt>中评</dt>
		<dd>({$comment_number.general})</dd>
	</dl>
	<dl data-url="{$ajax_url}&action_type=low&status=toggle" data-type="low">
		<dt>差评</dt>
		<dd>({$comment_number.low})</dd>
	</dl>
	<dl data-url="{$ajax_url}&action_type=picture&status=toggle" data-type="picture">
		<dt>晒图</dt>
		<dd>({$comment_number.picture})</dd>
	</dl>
</div>
<div class="store-comment" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{$ajax_url}" data-type="all" data-page="{if $comment_list.list}2{else}1{/if}">
</div>