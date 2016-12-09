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
		<p class="ecjia-truncate2 address-desc">{$default_address.address}{$default_address.address_info}</p>
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
						{if $val.manage_mode eq 'self'}<span class="self-store">自营</span>{/if}
					</a>
					<span class="shop-edit" data-store="{$val.seller_id}" data-type="edit">编辑</span>
				</div>
			</div>
			<ul class="items">
				<!-- {foreach $val.goods_list item=v} -->
				<li class="item-goods cart_item_{$val.seller_id}">
					<span class="cart-checkbox checkbox_{$val.seller_id} {if $v.is_checked eq 1}checked{/if}" data-store="{$val.seller_id}" rec_id="{$v.rec_id}" goods_id="{$v.goods_id}" data-num="{$v.goods_number}"></span>
					<div class="cart-product">
						<a class="cart-product-photo" href="{RC_Uri::url('goods/index/show')}&goods_id={$v.goods_id}">
							<img src="{$v.img.thumb}">
							{if $v.is_disabled}
							<div class="product_empty">库存不足</div>
							{/if}
						</a>
						<div class="cart-product-info">
							<div class="cart-product-name {if $v.is_disabled}disabled{/if}"><a href="{RC_Uri::url('goods/index/show')}&goods_id={$v.goods_id}">{$v.goods_name}</a></div>
							<div class="cart-product-price {if $v.is_disabled}disabled{/if}">{$v.formated_goods_price}</div>
							<div class="ecjia-input-number input_number_{$val.seller_id} {if $v.is_disabled}disabled{/if}" data-store="{$val.seller_id}">
		                        <span class="ecjia-number-group-addon" data-toggle="remove-to-cart" rec_id="{$v.rec_id}" goods_id="{$v.goods_id}">－</span>
		                        <input type="tel" class="ecjia-number-contro" value="{$v.goods_number}" autocomplete="off" rec_id="{$v.rec_id}"/>
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
				<a class="check_cart check_cart_{$val.seller_id} {if !$val.total.check_one}disabled{/if}" href="{RC_Uri::url('cart/flow/checkout')}" data-store="{$val.seller_id}" data-address="{$default_address.id}" data-rec="{$val.total.data_rec}">去结算</a>
			</div>
		</li>
		<input type="hidden" name="update_cart_url" value="{RC_Uri::url('goods/category/update_cart')}">
		<!-- {/foreach} -->
	</ul>
	<div class="flow-nomore-msg"></div>
</div>
<div class="flow-no-pro ecjia-margin-t ecjia-margin-b {if $cart_list}hide{/if}" style="margin-bottom: 48px;">
	<div class="ecjia-nolist">
		您还没有添加商品
		<a class="btn btn-small" type="button" href="{url path='touch/index/init'}">{t}去逛逛{/t}</a>
	</div>
</div>
<!-- #BeginLibraryItem "/library/model_bar.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->