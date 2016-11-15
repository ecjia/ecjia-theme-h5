<?php 
/*
Name: 购物车列表模板
Description: 购物车列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
	<script type="text/javascript">
	ecjia.touch.flow.init();
	$('.checkbox').change();
	ecjia.touch.delete_list_click();
	</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<!-- {if $goods_list } -->
	<ul class="ecjia-list cart-goods-list ecjia-margin-b">
		<!-- {foreach from=$goods_list item=goods key=k} -->
		<li>
			<label class="ecjiaf-fl ecjia-margin-r" for="cat_{$goods.rec_id}">
				<input class="checkbox" data-trigger="checkbox" id="cat_{$goods.rec_id}" type="checkbox" checked="checked" value="{$goods.rec_id}" name="check_goods" >
			</label>
			<div class="ecjiaf-fl ecjia-margin-l cart-goods-img">
				<a href="{url path='goods/index/init' args="id={$goods.goods_id}"}">
					<img src="{$goods.goods_thumb}" title="{$goods.goods_name}">
				</a>
			</div>
			<div class="ecjiaf-fl cart-goods-sort">
				<div class="cart-goods-hd">
					<div class="cart-goods-name">
						<a href="{url path='goods/index/init' args="id={$goods.goods_id}"}">
							{$goods.goods_name}
						</a>
					<!-- {if $goods.parent_id gt 0} 配件 -->
						<span style="color:#FF0000">（{$lang.accessories}）</span>
						<!-- {/if} -->
						<!-- {if $goods.is_gift gt 0} 赠品 -->
						<span style="color:#FF0000">（{$lang.largess}）</span>
						<!-- {/if} -->
						<!-- {if $show_goods_attribute eq 1 && $goods.goods_attr} 显示商品属性 -->
						<p class="goods-attribute">{$goods.goods_attr|nl2br}</p>
						<!-- {/if} -->
					</div>
				</div>
				
				<div>{$goods.goods_price}</div>
				<div class="cart-goods-drop">
					<div class="ecjia-input-number ecjia-margin-t">
						<span class="ecjia-number-group-addon" data-toggle="change_goods_number" data-status="del" data-url="{url path='cart/index/ajax_update_cart'}" data-rec_id="{{$goods.rec_id}}">－</span>
						<input class="ecjia-number-contro" id="back_number{$goods.rec_id}" type="hidden" value="{$goods.goods_number}" />
						<input class="ecjia-number-contro" id="goods_number{$goods.rec_id}" name="{$goods.rec_id}" type="text" autocomplete="off" value="{$goods.goods_number}" data-toggle="change_goods_number_blur" data-url="{url path='cart/index/ajax_update_cart'}" data-rec_id="{{$goods.rec_id}}" />
						<span class="ecjia-number-group-addon" data-toggle="change_goods_number" data-status="add" data-url="{url path='cart/index/ajax_update_cart'}" data-rec_id="{{$goods.rec_id}}" >＋</span>
					</div>
					<a href="javascript:void(0)" data-toggle="del_list"  data-url="{url path='cart/index/drop_goods'}" data-msg="{$lang.drop_goods_confirm}" data-id="{$goods.rec_id}" ><i class="iconfont icon-delete"></i></a>
				</div>
				
				<!-- {if $goods.fitting || $goods.favourable} -->
				<div class="ecjia-favourable-btn ecjia-margin-t two-btn">
					<!-- {if $goods.fitting} -->
					<a class="btn btn-info goods-fitting ecjia-margin-l" href="{url path='cart/index/goods_fittings'}">相关配件</a>
					<!-- {/if} -->

					<!-- {if $goods.favourable }-->
					<a class="btn btn-info goods-acitivty ecjia-margin-t" onClick="location.href='{url path='cart/index/label_favourable'}'">优惠活动</a>
					<!-- {/if} -->
				</div>
				<!-- {/if} -->
			</div>
		</li>
		<!-- {/foreach} -->
	</ul>
	<div class="cart-btn-checkout ecjia-margin-t">
		<div class="ecjia-margin-l ecjia-margin-b">{$lang.goods_price}：<span class="cart-goods-price" id="goods_subtotal">{$total.goods_price}</span></div>
		<a class="btn btn-info goods-checkout ecjia-margin-b nopjax" type="button"data-url="{url path='flow/checkout'}"   href="{url path='flow/checkout'}">{$lang.check_out}<!-- （<b id="total_number">{$total.total_number}</b>） --></a>
	</div> 
<!--{else}-->
<div class="flow-no-pro ecjia-margin-t ecjia-margin-b">
	<!-- <img src="{$theme_url}images/gwc.png">
	<p class="text-center">{$lang.empty_shopping}</p> -->
	<div class="ecjia-nolist">
		<i class="iconfont icon-gouwuche"></i>
		<p>{t}您的购物车空空如也{/t}</p>
	</div>
	<a class="btn btn-info" type="button" href="{url path='touch/index/init'}">{$lang.go_shopping}</a>
</div>
<!-- {/if} -->
<!-- {/block} -->