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
		<li><a class="nopjax goods-tab tab1" href="#goods-info-one" role="tab" data-toggle="tab" data-type="1">商品</a></li>
		<li><a class="nopjax goods-tab tab2" href="#goods-info-two" role="tab" data-toggle="tab" data-type="2">详情</a></li>
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
					{if $goods_info.pictures}
					<!--{foreach from=$goods_info.pictures item=picture}-->
						<div class="swiper-slide">
							<img  src="{$picture.url}"/>
						</div>
					<!--{/foreach}-->
					{else}
						<div class="swiper-slide">
							<img  src="{$theme_url}images/default-goods-pic.png"/>
						</div>
					{/if}
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
	        <div class="goods-info-property  goods-info-property-new ecjia-margin-b">
	            <!--商品描述-->
	            <div class="goods-style-name goods-style-name-new">
	                <div class=" ecjiaf-fl goods-name-new">{if $goods_info.merchant_info.manage_mode eq 'self'}<span>自营</span>{/if}{$goods_info.goods_name}</div>
	            </div>
	            <div class="goods-price goods-price-new">
	                <!-- $goods.is_promote and $goods.gmt_end_time -->
	                <!--{if ($goods_info.promote_price gt 0) AND ($goods_info.promote_start_date lt $goods_info.promote_end_date) } 促销-->
		                <div class="ecjia-price-time">
		                	<div class="time-left">
			                	<span class="ecjia-promote_price-span">{$goods_info.formated_promote_price}</span>
			                	<del> 原价：{$goods_info.shop_price}</del></br>
			                	<div class="ecjia-left-time">
			                		<span class="detail-clock-icon"></span>
									<span class="promote-time" data-type="1" value="{$goods_info.promote_end_time}"></span>
			                	</div>
			                </div>
			                <div class="cart-plus-right">
			                	{if $rec_id eq 0}	          			
			                		<a class="goods-add-cart add-cart-a" data-toggle="add-to-cart" rec_id="{$rec_id}" goods_id="{$goods_info.id}"  href="javascript:void 0;" style="display: none;"><span>加入购物车</span></a>
			                	{else}
				                	<div class="ecjia-goods-plus-box" id="goods_{$goods_info.id}">
					                     <span class="reduce show" data-toggle="remove-to-cart">减</span>
				                         <label class="show">{$num}</label>
				                         <span class="add storeSearchCart" data-toggle="add-to-cart" rec_id="{$rec_id}" goods_id="{$goods_info.id}">加</span>
				                    </div>
			                    {/if}
		                    </div>
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
	                {if $rec_id eq 0}                
	                	<a class="goods-add-cart market-goods-add-cart add-cart-a" data-toggle="add-to-cart" rec_id="{$rec_id}" goods_id="{$goods_info.id}" href="javascript:void 0;" ><span>加入购物车</span></a>
	                {else}
		                <div class="ecjia-goods-plus-box ecjia-market-plus-box" style="display: none;">
		                     <span class="reduce show" data-toggle="remove-to-cart">减</span>
	                         <label class="show">{$num}</label>
	                         <span class="add storeSearchCart" data-toggle="add-to-cart" rec_id="{$rec_id}" goods_id="{$goods_info.id}">加</span>
	                    </div>
                    {/if}
	                <!-- {/if} -->
	            </div>
	            <input type="hidden" value="{RC_Uri::url('goods/category/update_cart')}" name="update_cart_url" />
				<input type="hidden" value="{$goods_info.seller_id}" name="store_id" />
	        </div>
	        <a href='{url path="goods/category/store_goods" args="store_id={$goods_info.seller_id}"}'>
		        <div class="bd goods-type ecjia-margin-t store-name">
		            <div class="goods-option-con goods-num goods-option-con-new">
		                <div class="ecjia-merchants-name" >
		                	<span class="seller-name-icon"></span>
		                		<span class="style-store-name">{$goods_info.seller_name}</span>
		                	<i class="iconfont icon-jiantou-right"></i>
		                </div>
		            </div>
		        </div>
		    </a>
	        <!-- {if $goods_info.related_goods} -->
		        <div class="address-warehouse ecjia-margin-t address-warehouse-new">
		            <div class="ecjia-form may-like-literal">
		               <span class="may-like">也许你还喜欢</span>
		            </div>
		            <div class="ecjia-margin-b form-group ecjia-form">
		                <div class="bd">
							<ul class="ecjia-list ecjia-like-goods-list">
								<!--{foreach from=$goods_info.related_goods item=goods name=goods}-->
								<!-- {if $smarty.foreach.goods.index < 6 } -->
								<li>
									<a href='{url path="goods/index/init" args="id={$goods.goods_id}"}'>
										<img src="{$goods.img.url}"/>
									</a>
									<p class="link-goods-name ecjia-goods-name-new">{$goods.name}</p>
									<div class="link-goods-price">
										<!--{if $goods.promote_price}-->
										<span>{$goods.promote_price}</span>
										<div class="goods-price-plus"></div>
										<!--{else}-->
										<span>{$goods.market_price}</span>
										<div class="goods-price-plus"></div>
										<!--{/if}-->
									</div>
								</li>
								<!--{/if}-->
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
	<ul class="ecjia-list ecjia-list-new ecjia-list-two ecjia-list-two-new ecjia-nav goods-desc-nav-new">
		<li class="active">
			<a class="nopjax a1" href="#one" role="tab" data-toggle="tab">图文详情</a>
			<span class="goods-detail-title-border"></span>
		</li>
		<li style="border-left:none;"><a class="nopjax a2" href="#two" role="tab" data-toggle="tab">规格参数</a></li>
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
		<div class="goods-describe goods-describe-new ecjia-margin-b" id="two" style="padding:0 0 0 17px;">
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
				<img  src="{$theme_url}images/property.png">
				<p class="tags_list_font">{t}暂无任何规格参数{/t}</p>
			</div>
			<!-- {/if} -->
		</div>
	</div>
</div>
<!-- 切换详情页面end -->

<!-- {/block} -->

