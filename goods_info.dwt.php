<?php
/*
Name: 商品描述模板
Description: 这是商品描述首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.touch.goods_detail.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div class="ecjia-goods-detail-header-title">
	<ul>
		<li><a class="nopjax goods-p" href="#goods-info-one" role="tab" data-toggle="tab" data-type="1">商品</a><p class="p1">—</p></li>
		<li><a class="nopjax goods-p" href="#goods-info-two" role="tab" data-toggle="tab" data-type="2">详情</a><p class="p2">—</p></li>
	</ul>
</div>

<!-- 切换商品页面start -->
<div class="ecjia-goods-basic-info"  id="goods-info-one">
<!--商品图片相册start-->
	<div class="focus" id="focus">
		<div class="hd">
			<ul></ul>
		</div>
		<div class="bd">
			<!-- Swiper -->
			<div class="swiper-container swiper-goods-img">
				<div class="swiper-wrapper">
					<!--{foreach from=$goods_info.pictures item=picture}-->
						<div class="swiper-slide">
							<img src="{$picture.url}"/>
						</div>
					<!--{/foreach}-->
				</div>
				<!-- Add Pagination -->
				<div class="swiper-pagination"></div>
			</div>
		</div>
	</div>
<!--商品图片相册end-->
	<!--商品属性介绍-->
	<form action="{url path='cart/index/add_to_cart'}" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY" >
	    <div class="goods-info">
	        <div class="goods-info-property ecjia-margin-b">
	            <!--商品描述-->
	            <div class="goods-style-name goods-style-name-new">
	                <div class="goods-name ecjiaf-fl">{if $goods_info.merchant_info.manage_mode eq 'self'}<span>自营</span>{/if}{$goods_info.goods_name}</div>
	            </div>
	            <div class="goods-price goods-price-new">
	                <!-- $goods.is_promote and $goods.gmt_end_time -->
	                <!--{if ($goods_info.promote_price gt 0) AND ($goods_info.promote_start_date lt $goods_info.promote_end_date) } 促销-->
	                	<span class="ecjia-promote_price-span">{$goods_info.formated_promote_price}</span>
	                	<del> 原价：{$goods_info.shop_price}</del></br>
	                	<div class="ecjia-left-time">
	                		<i class="iconfont icon-remind"></i>
							<span class="promote-time" data-type="1" value="{$goods_info.promote_end_time}"></span>
	                	</div>	          			
	                	<a class="goods-add-cart add-cart-a" href="javascript:void 0;" ><span>加入购物车</span></a>
	                	<div class="ecjia-goods-plus-box" style="display: none;">
		                     <span class="reduce show" data-toggle="remove-to-cart">减</span>
	                         <label class="show">1</label>
	                         <span class="add storeSearchCart" data-toggle="add-to-cart">加</span>
	                    </div>
	                	<!-- {if $goods_info.favourable_list} -->
			                	<div class="ecjia-favourable-goods-list">
				                	<ul class="store-promotion">
				                	<!-- {foreach from=$goods_info.favourable_list item=favour  name=foo} -->
				                	<!-- {if $smarty.foreach.foo.index < 2 } -->
										<li class="promotion">
										<span class="promotion-label">{$favour.type_label}</span>
										<span class="promotion-name">{$favour.name}</span>
										</li>
									 <!-- {/if} -->
									<!-- {/foreach} -->
									</ul>
								</div>
						<!-- {/if} -->
	                <!--{else}-->
	                {$goods_info.shop_price}
	                <del>市场价：{$goods_info.market_price}</del>	                
	                <a class="goods-add-cart market-goods-add-cart add-cart-a" href="javascript:void 0;" ><span>加入购物车</span></a>
	                <div class="ecjia-goods-plus-box" style="display: none;">
	                     <span class="reduce show" data-toggle="remove-to-cart">减</span>
                         <label class="show">1</label>
                         <span class="add storeSearchCart" data-toggle="add-to-cart">加</span>
                    </div>
	                <!-- {/if} -->
	            </div>
	        </div>
	        <div class="bd goods-type ecjia-margin-t">
	            <div class="goods-option-con goods-num goods-option-con-new">
	                <a class="ecjia-merchants-name" href='{url path="goods/category/store_goods" args="store_id={$goods_info.seller_id}"}'>
	                	<i class="iconfont icon-shop"></i>
	                	{$goods_info.seller_name}
	                	<i class="iconfont icon-jiantou-right"></i>
	                </a>
	            </div>
	        </div>
	        <!-- {if $goods_info.related_goods} -->
		        <div class="address-warehouse ecjia-margin-t address-warehouse-new">
		            <div class="ecjia-form may-like-literal">
		               <p class="may-like">也许你还喜欢</p>
		            </div>
					<div class="ecjia-may-like-border"></div>
		            <div class="ecjia-margin-b form-group ecjia-form">
		                <div class="bd">
							<ul class="ecjia-list ecjia-like-goods-list">
								<!--{foreach from=$goods_info.related_goods item=goods name=goods}-->
								<li>
									<a href='{url path="goods/index/init" args="id={$goods.goods_id}"}'>
										<img src="{$goods.img.url}" />
									</a>
									<p class="link-goods-name ecjia-goods-name-new">{$goods.name|truncate:16}</p>
									<p class="link-goods-price">
										<!--{if $goods.promote_price}-->
										{$goods.formated_promote_price}
										<!--{else}-->
										{$goods.market_price}
										<!--{/if}-->
									</p>
								</li>
								<!--{/foreach}-->
							</ul>
						</div>
		            </div>
		        </div>
		     <!-- {/if} -->
	    </div>
	</form>
</div>
<!-- 切换商品页面end -->


<!-- 切换详情页面start -->
<div class="goods-desc-info active" id="goods-info-two">
	<!--商品描述-->
	<!-- Nav tabs -->
	<ul class="ecjia-list ecjia-list-two ecjia-nav goods-desc-nav-new">
		<li class="active">
			<a class="nopjax a1" href="#one" role="tab" data-toggle="tab">图文详情</a>
		</li>
		<li><a class="nopjax a2" href="#two" role="tab" data-toggle="tab">规格参数</a></li>
	</ul>
	<!-- Tab panes -->
	<div class="bd">
		<div class="goods-describe ecjia-margin-b active" id="one">
			<!-- {if $goods_desc} -->
			{$goods_desc}
			<!-- {else} -->
			<div class="ecjia-nolist">
				<p class="tags_list_font">{t}此商品暂时没有详情{/t}</p>
			</div>
			<!-- {/if} -->
		</div>
		<div class="goods-describe ecjia-margin-b" id="two" style="padding:0;">
		<!-- {if $goods_info.properties} -->
			<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#dddddd">
				<!-- {foreach from=$goods_info.properties item=property_group} -->
				<tr>
					<td bgcolor="#FFFFFF" align="left" width="30%" class="f1">{$property_group.name|escape:html}</td>
					<td bgcolor="#FFFFFF" align="left" width="70%">{$property_group.value}</td>
				</tr>
				<!-- {/foreach}-->
			</table>
			<!-- {else} -->
			<div class="ecjia-nolist">
				<p class="tags_list_font">{t}此商品暂时没有属性{/t}</p>
			</div>
			<!-- {/if} -->
		</div>
	</div>
</div>
<!-- 切换详情页面end -->



<div class="store-add-cart a4w" style="">
	<div class="a52"></div>
	<a href="javascript:void 0;" class="a4x light show_cart" style="transform: translateY(0px);" show="false"><i class="a4y">1</i></a>
	<div class="a4z" style="transform: translateX(0px);">
		<div class="">￥6.90</div>
	</div>
	<a class="a51 " href="javascript:void 0;">去结算</a>
	<div class="minicart-content" style="transform: translateY(0px); display: block;">
		<i class="a57"></i>
		<div class="a58 ">
			<span class="a69 a6a checked" checkallgoods="" onclick="">全选</span>
			<p class="a6c">(已选1件，共0.75kg)</p>
			<a href="javascript:void 0;" class="a59" data-toggle="deleteall">清空购物车</a>
		</div>
		<div class="a5b" style="height: auto;">
			<div class="a5l single">
				<ul class="minicart-goods-list single"> 
					<li class="a5n single last">
						<span class="a69 a5o checked" checkgoods=""></span>
						<a class="a5r" href="">
							<table class="a5s">
								<tbody>
									<tr>
										<td style=" width:62px;"><img class="a5t" src=""> </td>
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
	<div class="a53" cartmask="" clstag="pageclick|keycount|cart_close_20160623_1|1" style="display: none;"></div>
</div>

<!-- {/block} -->
