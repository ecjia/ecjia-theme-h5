<?php 
/*
Name: 分类店铺
Description: 这是分类店铺页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.category.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/index_header.lbi" -->
<!-- #EndLibraryItem -->

<ul class="ecjia-store-list">
	<!-- {foreach from=$data item=val} -->
	<li class="single_item">
		<ul class="single_store">
			<li class="store-info">
				<a href="{RC_Uri::url('goods/category/store_goods')}&store_id={$val.id}">
				<div class="basic-info">
					<div class="store-left">
						<img src="{$val.seller_logo}">
					</div>
					<div class="store-right">
						<div class="store-name">{$val.seller_name}{if $val.manage_mode eq 'self'}<span>自营</span>{/if}</div>
						<div class="store-range">
							<i class="iconfont icon-remind"></i>{$val.label_trade_time}
							{if $val.distance}
							<span class="store-distance">{$val.distance}m</span>
							{/if}
						</div>
					</div>
					<div class="clear"></div>
				</div>
				{if $val.favourable_list}
				<ul class="store-promotion">
					<!-- {foreach from=$val.favourable_list item=list} -->
					<li class="promotion">
						<span class="promotion-label">{$list.type_label}</span>
						<span class="promotion-name">{$list.name}</span>
					</li>
					<!-- {/foreach} -->
				</ul>
				{/if}
				</a>
				{if $val.seller_goods}
				<ul class="store-goods">
					<!-- {foreach from=$val.seller_goods key=key item=goods} -->
						<li class="goods-info {if $key gt 3}goods-hide-list{/if}">
							<span class="goods-image"><img src="{$goods.img.thumb}"></span>
							<span class="goods-name">{$goods.name}</span>
							<span class="goods-price">{$goods.shop_price}</span>
						</li>
					<!-- {/foreach} -->
				</ul>
				{/if}
			</li>
		</ul>
		{if $val.goods_count > 3}
		<ul>
			<li class="goods-info view-more">
				查看更多（{$val.goods_count-3}）<i class="iconfont icon-jiantou-bottom"></i>
			</li>
			
			<li class="goods-info view-more retract hide">
				收起<i class="iconfont icon-jiantou-top"></i>
			</li>
		</ul>
		{/if}
	</li>
	<!-- {/foreach} -->
</ul>
<!-- {/block} -->