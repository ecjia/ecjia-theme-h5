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

<!-- {if $data} -->
<ul class="ecjia-store-list">
	<!-- {foreach from=$data item=val} -->
	<!-- {if !$store_id} -->
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
						<li class="goods-info {if $key gt 2}goods-hide-list{/if}">
							<span class="goods-image"><img src="{$goods.img.thumb}"></span>
							<p>
								{$goods.name}
								<label class="price">{$goods.shop_price}</label>
							</p>
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
	<!-- {else} -->
	<li class="search-goods-list">
		<a class="linksGoods w">
			<img class="pic" src="{$val.img.small}">
			<dl>
				<dt>{$val.name}</dt>
				<dd><label>{$val.shop_price}</label></dd>
			</dl>
		</a>
		<div class="input-number">
			<i class="iconfont icon-roundadd" data-toggle="add-to-cart"></i>
			<span></span>
			<i></i>
		</div>
	</li>
	<!-- {/if} -->
	<!-- {/foreach} -->
	
	<!-- {if $store_id} -->
	<div class="store-add-cart a4w" style="">
		<div class="a52"></div>
		<a href="javascript:void 0;" class="a4x light show_cart" carticon="" clstag="" style="transform: translateY(0px);" show="false"><i class="a4y">1</i></a>
		<div class="a4z" pricearea="" style="transform: translateX(0px);">
			<div class="">￥6.90</div>
		</div>
		<a class="a51 " qujiesuan="" href="javascript:void 0;" onclick="">去结算</a>
		<div class="minicart-content" cartcontent="" style="transform: translateY(0px); display: block;">
			<i class="a57"></i>
			<div class="a58 ">
				<span class="a69 a6a checked" checkallgoods="" onclick="">全选</span><p class="a6c">(已选1件，共0.75kg)</p><a href="javascript:void 0;" class="a59" deleteall="" clstag="pageclick|keycount|cart_clean_20160623_1|1">清空购物车</a>
			</div>
			<div class="a5b" cartitemlist="" style="height: auto;">
				<div class="a5l single">
					<ul class="minicart-goods-list single"> 
						<li class="a5n single last" goodsid="2005033203" normalgoods_="">
							<span class="a69 a5o checked" checkgoods=""></span>
							<a class="a5r" href="">
							<table class="a5s">
								<tbody>
									<tr>
										<td style=" width:62px; "><img class="a5t" src=""> </td>
										<td>
											<div class="a5w">【热销TOP1】赣南脐橙-中果4个/份   约750-850g</div> 
											<span class="a5p">￥6.90</span>
										</td>
									</tr>
								</tbody>
							</table>
							</a>
							<a class="a5u reduce" minusgoods="" tap="" data-toggle="remove-to-cart"></a>
							<lable class="a5x">1</lable>
							<a class="a5v " addgoods="" tap="" data-toggle="add-to-cart"></a>
						</li>
						<li class="a5n single last" goodsid="2005033203" normalgoods_="">
							<span class="a69 a5o checked" checkgoods=""></span>
							<a class="a5r" href="">
							<table class="a5s">
								<tbody>
									<tr>
										<td style=" width:62px; "><img class="a5t" src=""> </td>
										<td>
											<div class="a5w">【热销TOP1】赣南脐橙-中果4个/份   约750-850g</div> 
											<span class="a5p">￥6.90</span>
										</td>
									</tr>
								</tbody>
							</table>
							</a>
							<a class="a5u reduce" minusgoods="" tap="" data-toggle="remove-to-cart"></a>
							<lable class="a5x">1</lable>
							<a class="a5v " addgoods="" tap="" data-toggle="add-to-cart"></a>
						</li>
						<li class="a5n single last" goodsid="2005033203" normalgoods_="">
							<span class="a69 a5o checked" checkgoods=""></span>
							<a class="a5r" href="">
							<table class="a5s">
								<tbody>
									<tr>
										<td style=" width:62px; "><img class="a5t" src=""> </td>
										<td>
											<div class="a5w">【热销TOP1】赣南脐橙-中果4个/份   约750-850g</div> 
											<span class="a5p">￥6.90</span>
										</td>
									</tr>
								</tbody>
							</table>
							</a>
							<a class="a5u reduce" minusgoods="" tap="" data-toggle="remove-to-cart"></a>
							<lable class="a5x">1</lable>
							<a class="a5v " addgoods="" tap="" data-toggle="add-to-cart"></a>
						</li>												
					</ul>
					<div class="a5m single" style=""></div>
				</div>
			</div>
		<div style="height:50px;" discountpromptmsgheight=""></div>
		</div>
		<div giftcontent="">  </div>
		<div class="a53" cartmask="" clstag="pageclick|keycount|cart_close_20160623_1|1" style="display: none;"></div>
	</div>
    <!-- {/if} -->
</ul>
<!-- {else} -->
<div class="search-no-pro ecjia-margin-t ecjia-margin-b">
	<div class="ecjia-nolist">
		<p>没有找到您要的商品</p>
	</div>
</div>
<!-- {/if} -->
<!-- {/block} -->