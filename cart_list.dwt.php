<?php
/*
Name: 购物车列表模板
Description: 购物车列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.category.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
	
<div class="flow-address ecjia-margin-b flow-cart">
	<span class="ecjiaf-fl">{t}送至：{/t}</span>
	<div class="ecjiaf-fl address-info">
		<span>{$default_address.consignee}</span>
		<span>{$default_address.mobile}</span>
		<p class="ecjia-truncate2 address-desc">{$default_address.address}</p>
	</div>
</div>

<div class="ecjia-flow-cart">
	<ul>
		<!-- {foreach from=$cart_list item=val} -->
		<li class="cart-single">
			<div class="item">
				<div class="check-wrapper">
					<span class="cart-checkbox check_all {if $val.total.check_all eq 1}checked{/if}" id="store_check_{$val.seller_id}" data-store="{$val.seller_id}"></span>
				</div>
				<div class="shop-title-content">
					<a href="{RC_Uri::url('goods/category/store_goods')}&store_id={$val.seller_id}">
						<span class="shop-title-name"><i class="iconfont icon-shop"></i>{$val.seller_name}</span>
					</a>
					<span class="shop-edit">编辑</span>
				</div>
			</div>
			<ul class="items">
				<!-- {foreach $val.goods_list item=v} -->
				<li class="item-goods cart_item_{$val.seller_id}">
					<span class="cart-checkbox checkbox_{$val.seller_id} {if $v.is_checked eq 1}checked{/if}" data-store="{$val.seller_id}" rec_id="{$v.rec_id}" goods_id="{$v.goods_id}" data-num="{$v.goods_number}"></span>
					<div class="cart-product">
						<a class="cart-product-photo"><img src="{$v.img.thumb}"></a>
						<div class="cart-product-info">
							<div class="cart-product-name">{$v.goods_name}</div>
							<div class="cart-product-price">{$v.formated_goods_price}</div>
							<div class="ecjia-input-number input_number_{$val.seller_id}" data-store="{$val.seller_id}">
		                        <span class="ecjia-number-group-addon" data-toggle="remove-to-cart" rec_id="{$v.rec_id}" goods_id="{$v.goods_id}">－</span>
		                        <input class="ecjia-number-contro" value="{$v.goods_number}" autocomplete="off"/>
		                        <span class="ecjia-number-group-addon" data-toggle="add-to-cart" rec_id="{$v.rec_id}" goods_id="{$v.goods_id}">＋</span>
		                    </div>
						</div>
					</div>
				</li>
				<!-- {/foreach} -->
			</ul>
			<div class="item-count">
				<span class="count">合计：</span>
				<span class="price price_{$val.seller_id}">{$val.total.goods_price}</span>
				<a class="check-cart check-cart_{$val.seller_id} {if !$val.total.check_one}disabled{/if}">去结算</a>
			</div>
		</li>
		<input type="hidden" name="update_cart_url" value="{RC_Uri::url('goods/category/update_cart')}">
		<!-- {/foreach} -->
	</ul>
</div>

<div class="flow-no-pro ecjia-margin-t ecjia-margin-b {if $cart_list}hide{/if}">
	<div class="ecjia-nolist">
		您还没有添加商品
		<a class="btn btn-small" type="button" href="{url path='touch/index/init'}">{t}去逛逛{/t}</a>
	</div>
</div>
<!-- #BeginLibraryItem "/library/model_bar.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->