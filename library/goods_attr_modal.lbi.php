<?php
/*
Name: 选择商品规格
Description: 这是选择商品规格弹窗
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-goodsAttr-modal">
	<div class="modal-inners">
		<span class="ecjia-close-modal-icon"><i class="iconfont icon-close"></i></span>
		<div class="modal-title">{$goods_info.goods_name}</div>
		<div class="goods-attr-list">
			<!-- {foreach from=$goods_info.specification item=value} -->
			<div class="goods-attr">
				<p class="attr-name">{$value.name}</p>
				<ul>
					<!-- {foreach from=$value.value item=val key=key} -->
					<li class="{if $key eq 0}active{/if}" data-attr="{$val.id}">{$val.label}</li>
					<!-- {/foreach} -->
				</ul>
			</div>
			<!-- {/foreach} -->
		</div>
	</div>
	<div class="modal-buttons modal-buttons-2 modal-buttons-vertical">
		{if $current.rec_id}
		<div class="modal-left">
			<span class="goods-attr-price">{$current.goods_price}</span>
			<span class="goods-attr-name">{$current.attr}</span>
		</div>
		<div class="ecjia-choose-attr-box {if !$rec_id}hide{/if} box" id="goods_{$goods_info.id}">
			<span class="reduce" data-toggle="remove-to-cart" rec_id="{$rec_id}"></span>
		    <label>{if !$rec_id}1{else}{$num}{/if}</label>
		    <span class="add storeSearchCart" data-toggle="add-to-cart" rec_id="{$rec_id}" goods_id="{$goods_info.id}"></span>
		</div>                          
		{else}
		<div class="modal-left">
			<span class="goods-attr-price"></span>
			<span class="goods-attr-name"></span>
		</div>
		<a class="add-tocart add_spec" data-toggle="add-to-cart" goods_id="{$goods_info.id}">加入购物车</a>
		{/if}
	</div>
</div>
<div class="ecjia-goodsAttr-overlay ecjia-goodsAttr-overlay-visible"></div>