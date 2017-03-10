<?php
/*
Name: 首页推荐商家
Description: 这是推荐商家
Libraries: suggest_store
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-mod ecjia-margin-b goods-index-list ecjia-new-goods" style="border-bottom:none;">
	<div class="hd">
		<h2>
			<span class="line"></span>
			<span class="goods-index-title"><i class="icon-goods-hot"></i>热门推荐</span>
		</h2>
	</div>
	<ul class="ecjia-suggest-store" id="suggest_store_list" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='index/ajax_suggest_store'}">
	</ul>
</div>