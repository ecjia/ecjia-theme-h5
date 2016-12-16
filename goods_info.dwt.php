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
    ecjia.touch.category.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-goods-detail-header-title ecjia-header-index" style="background:#47aa4d none repeat scroll 0 0;">
	<ul>
		<li><a class="goods-tab tab1" href="javascript:;" data-type="1">商品</a></li>
		<li><a class="goods-tab tab2" href="javascript:;" data-type="2">详情</a></li>
	</ul>
</div>
{if $no_goods_info eq 1}
<div class="ecjia-no-goods-info">不存在的信息</div>
{/if}
<!-- 切换商品页面start -->
{if $no_goods_info neq 1}
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
						<div class="swiper-slide" style="margin-top:3.5em;">
							<img src="{$picture.thumb}"/>
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
			                	<span class="goods-add-cart add-cart-a {if $rec_id}hide{/if}" data-toggle="add-to-cart" goods_id="{$goods_info.id}">加入购物车</span>
                                <div class="ecjia-goods-plus-box {if !$rec_id}hide{/if} box" id="goods_{$goods_info.id}">
                                    <span class="reduce" data-toggle="remove-to-cart" rec_id="{$rec_id}">减</span>
                                    <label>{if !$rec_id}0{else}{$num}{/if}</label>
                                    <span class="add storeSearchCart" data-toggle="add-to-cart" rec_id="{$rec_id}" goods_id="{$goods_info.id}">加</span>
                                </div>
		                    </div>
		                 </div>
	                <!--{else}-->
	                {$goods_info.shop_price}
	                <del>市场价：{$goods_info.market_price}</del>	
                	<span class="goods-add-cart market-goods-add-cart add-cart-a {if $rec_id}hide{/if}" data-toggle="add-to-cart" rec_id="{$rec_id}" goods_id="{$goods_info.id}">加入购物车</span>
              		<div class="ecjia-goods-plus-box ecjia-market-plus-box {if !$rec_id}hide{/if} box" id="goods_{$goods_info.id}">
              			<span class="reduce show" data-toggle="remove-to-cart" rec_id="{$rec_id}">减</span>
                     	<label>{if !$rec_id}0{else}{$num}{/if}</label>
              			<span class="add storeSearchCart" data-toggle="add-to-cart" rec_id="{$rec_id}" goods_id="{$goods_info.id}">加</span>
                    </div>
	                <!-- {/if} -->
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
	            <input type="hidden" value="{RC_Uri::url('goods/category/update_cart')}" name="update_cart_url" />
				<input type="hidden" value="{$goods_info.seller_id}" name="store_id" />
	        </div>
	        <a href='{url path="goods/category/store_goods" args="store_id={$goods_info.seller_id}"}'>
		        <div class="bd goods-type ecjia-margin-t store-name">
		            <div class="goods-option-con goods-num goods-option-con-new">
		                <div class="ecjia-merchants-name" >
		                	<span class="shop-title-name"><i class="iconfont icon-shop"></i>{$goods_info.seller_name}</span>
		                	<i class="iconfont icon-jiantou-right"></i>
		                </div>
		            </div>
		        </div>
		    </a>
	        <!-- {if $goods_info.related_goods} -->
		        <div class="address-warehouse ecjia-margin-t address-warehouse-new">
		            <div class="ecjia-form">
		               <div class="may-like-literal"><span class="may-like">也许你还喜欢</span></div>
		            </div>
		            <div class="ecjia-margin-b form-group ecjia-form">
		                <div class="bd">
							<ul class="ecjia-list ecjia-like-goods-list">
								<!--{foreach from=$goods_info.related_goods item=goods name=goods}-->
								<!-- {if $smarty.foreach.goods.index < 6 } -->
								<li>
									<a href='{url path="goods/index/show" args="goods_id={$goods.goods_id}"}'>
										<img src="{$goods.img.url}" alt="{$goods.name}" title="{$goods.name}"/>
									</a>
									<p class="link-goods-name ecjia-goods-name-new">{$goods.name}</p>
									<div class="link-goods-price">
										<!--{if $goods.promote_price}-->
										<span>{$goods.promote_price}</span>
										<!--{else}-->
										<span>{$goods.market_price}</span>
										<!--{/if}-->
										<span class="goods-price-plus" data-toggle="add-to-cart" rec_id="{$goods.rec_id}" goods_id="{$goods.goods_id}" data-num="{$goods.num}"></span>
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
{/if}
<!-- 切换商品页面end -->


<!-- 切换详情页面start -->
{if $no_goods_info neq 1}
<div class="goods-desc-info active" id="goods-info-two" style="margin-top:3.5em;">
	<!--商品描述-->
	<!-- Nav tabs -->
	<ul class="ecjia-list ecjia-list-new ecjia-list-two ecjia-list-two-new ecjia-nav ecjia-nav-new goods-desc-nav-new">
		<li class="active goods-desc-li-info one-li" data-id="1">
			<a class="a1" href="javascript:;">图文详情</a>
			<span class="goods-detail-title-border"></span>
		</li>
		<li class="goods-desc-li-info two-li" style="border-left:none;" data-id="2"><a class="a2" href="javascript:;">规格参数</a></li>
	</ul>
	<!-- Tab panes -->
	<div class="bd">
		<div class="goods-describe ecjia-margin-b active" id="one-info">
			<!-- {if $goods_desc} -->
			{$goods_desc}
			<!-- {else} -->
			<div class="ecjia-nolist">
				<p class="tags_list_font">{t}此商品暂时没有详情{/t}</p>
			</div>
			<!-- {/if} -->
		</div>
		<div class="goods-describe goods-describe-new ecjia-margin-b" id="two-info" >
		<!-- {if $goods_info.properties} -->
			<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#dddddd" style="margin:0 0 0 5px;">
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
{/if}
<!-- 切换详情页面end -->
<div class="store-add-cart a4w">
    <div class="a52"></div>
    <a href="javascript:void 0;" class="a4x {if $real_count.goods_number}light{else}disabled{/if} outcartcontent show show_cart" show="false">
        {if $real_count.goods_number}
        <i class="a4y">
        {$real_count.goods_number}
        </i>
        {/if}
    </a>
    <div class="a4z" style="transform: translateX(0px);">
        {if !$real_count.goods_number}
            <div class="a50">购物车是空的</div>
        {else}
        <div>
            {$count.goods_price}{if $count.discount neq 0}<label>(已减{$count.discount})</label>{/if}
        </div>
        {/if}
    </div>
    <a class="a51 {if !$count.check_one}disabled{/if} check_cart" data-href="{RC_Uri::url('cart/flow/checkout')}" data-store="{$goods_info.seller_id}" data-address="{$address_id}" data-rec="{$data_rec}" href="javascript:;">去结算</a>
    <div class="minicart-content" style="transform: translateY(0px); display: block;">
        <a href="javascript:void 0;" class="a4x {if $count.goods_number}light{else}disabled{/if} incartcontent show_cart" show="false">
            {if $real_count.goods_number}
            <i class="a4y">
            {$real_count.goods_number}
            </i>
            {/if}
        </a>
        <i class="a57"></i>
        <div class="a58 ">
            <span class="a69 a6a {if $count.check_all}checked{/if}" data-toggle="toggle_checkbox" data-children=".checkbox" id="checkall">全选</span>
            <p class="a6c">(已选{$count.goods_number}件)</p>
            <a href="javascript:void 0;" class="a59" data-toggle="deleteall" data-url="{RC_Uri::url('goods/category/update_cart')}">清空购物车</a>
        </div>
        
        <div class="a5b" style="max-height: 21em;">
            <div class="a5l single">
                {if $goods_info.favourable_list}
                <ul class="store-promotion" id="store-promotion">
                    <!-- {foreach from=$goods_info.favourable_list item=list} -->
                    <li class="promotion">
                        <span class="promotion-label">{$list.type_label}</span>
                        <span class="promotion-name">{$list.name}</span>
                    </li>
                    <!-- {/foreach} -->
                </ul>
                {/if}
                <ul class="minicart-goods-list single">
                    <!-- {foreach from=$cart_list item=cart} -->
                    <li class="a5n single {if $cart.is_disabled eq 1}disabled{/if}">
                        <span class="a69 a5o {if $cart.is_checked}checked{/if} checkbox {if $cart.is_disabled eq 1}disabled{/if}" data-toggle="toggle_checkbox" rec_id="{$cart.rec_id}"></span>
                        <table class="a5s">
                            <tbody>
                                <tr>
                                    <td style="width:75px; height:75px">
                                        <img class="a7g" src="{$cart.img.small}">
                                        <div class="product_empty">
                                        {if $cart.is_disabled eq 1}库存不足{/if}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="a7j">{$cart.goods_name}</div> 
                                        <span class="a7c">
                                        {if $cart.goods_price eq 0}免费{else}{$cart.formated_goods_price}{/if}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="box" id="goods_cart_{$cart.goods_id}">
                            <span class="a5u reduce {if $cart.is_disabled eq 1}disabled{/if}" data-toggle="remove-to-cart" rec_id="{$cart.rec_id}"></span>
                            <lable class="a5x">{$cart.goods_number}</lable>
                            <span class="a5v {if $cart.is_disabled eq 1}disabled{/if}" data-toggle="add-to-cart" rec_id="{$cart.rec_id}" goods_id="{$cart.goods_id}"></span>
                        </div>
                    </li>
                    <input type="hidden" name="rec_id" value="{$cart.rec_id}" />
                    <!-- {/foreach} -->
                </ul>
                <div class="a5m single"></div>
            </div>
        </div>
        <div style="height:50px;"></div>
    </div>
    <!-- 遮罩层 -->
    <div class="a53" style="display: none;"></div>
</div>
<!-- #BeginLibraryItem "/library/choose_address_modal.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->