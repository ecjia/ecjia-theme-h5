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
	ecjia.touch.store.scroll();
	ecjia.touch.category.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-mod page_hearer_hide ecjia-fixed">
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
		<div class="store-hr"></div>
		<div class="store-score">
			<div class="score-name">商品评分 ({$store_info.comment.comment_goods})</div>
			<span class="score-val" data-val="{$store_info.comment.comment_goods_val}"></span>
		</div>
		<div class="store-comment-container">
		<!-- #BeginLibraryItem "/library/store_comment.lbi" --><!-- #EndLibraryItem -->
		</div>
	</div>
</div>
<!-- #BeginLibraryItem "/library/merchant_detail.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->