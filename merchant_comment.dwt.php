<?php
/*
Name: 店铺商品
Description: 这是店铺商品页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.category.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-mod page_hearder_hide ecjia-fixed">
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->
</div>

<!-- #BeginLibraryItem "/library/merchant_head.lbi" --><!-- #EndLibraryItem -->
<div class="ecjia-mod ecjia-store-ul">
	<ul>
		<li class="ecjia-store-li" data-url="{$url}"><span class="">购物</span></li>
		<li class="ecjia-store-li"><span class="active">评价</span></li>
		<li class="ecjia-store-li"><span>商家</span></li>
	</ul>
</div>

<div class="ecjia-mod ecjia-store-comment ecjia-store-toggle">
	<div class="ecjia-seller-comment">
		<div class="comment-body">
			<div class="store-hr"></div>
			<div class="store-header-title">
				<div class="store-score">
					<div class="score-name">商品评分 ({$store_info.comment.comment_goods})</div>
					<span class="score-val" data-val="{$store_info.comment.comment_goods_val}"></span>
				</div>
				<div class="store-option">
					<dl class="active" data-url="{$ajax_url}&action_type=all&status=toggle" data-type="all">
						<dt>全部</dt>
						<dd>{$comment_number.all}</dd>
					</dl>
					<dl data-url="{$ajax_url}&action_type=good&status=toggle" data-type="good">
						<dt>好评</dt>
						<dd>{$comment_number.good}</dd>
					</dl>
					<dl data-url="{$ajax_url}&action_type=general&status=toggle" data-type="general">
						<dt>中评</dt>
						<dd>{$comment_number.general}</dd>
					</dl>
					<dl data-url="{$ajax_url}&action_type=low&status=toggle" data-type="low">
						<dt>差评</dt>
						<dd>{$comment_number.low}</dd>
					</dl>
					<dl data-url="{$ajax_url}&action_type=picture&status=toggle" data-type="picture">
						<dt>晒图</dt>
						<dd>{$comment_number.picture}</dd>
					</dl>
				</div>
			</div>
			<div class="store-container" id="store-scroll">
				<div class="store-comment-container">
					<div id="store-comment" class="store-comment" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{$ajax_url}" data-type="all">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- #BeginLibraryItem "/library/merchant_detail.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->