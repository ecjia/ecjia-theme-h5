<?php
/*
Name: 首页推荐商家
Description: 这是推荐商家
Libraries: suggest_store
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-mod ecjia-store-model ecjia-margin-t">
	<div class="head-title">
		<h2><i class="icon-store"></i>推荐店铺</h2>
	</div>
	<ul class="ecjia-suggest-store" id="suggest_store_list" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='index/ajax_suggest_store'}">
	</ul>
</div>