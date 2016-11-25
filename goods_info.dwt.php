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
<!-- <script type="text/javascript">ecjia.touch.goods.init();</script> -->
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div class="ecjia-goods-detail-header-title">
	<ul>
		<li class="active"><a class="nopjax" href="#goods-info-one" role="tab" data-toggle="tab">商品</a></li>
		<li><a class="nopjax" href="#goods-info-two" role="tab" data-toggle="tab">详情</a></li>
	</ul>
</div>

<!-- 切换商品页面start -->
<div class="ecjia-goods-basic-info"  id="goods-info-one">
<!--商品图片相册-->
	<div class="goods-img" id="focus">
		<div class="bd">
			<!-- Swiper -->
			<div class="swiper-container goods-imgshow">
				<div class="swiper-wrapper">
					<!--{foreach from=$goods_info.pictures item=picture}-->
						<div class="swiper-slide">
							<img src="{$picture.url}" />
						</div>
					<!--{/foreach}-->
					 <div class="scroller-slidenext">
	                    <i class="slidenext-icon iconfont icon-roundrightfill"></i>
	                    <span class="slidenext-msg">滑动查看详情</span>
	                </div>
				</div>
				<!-- Add Pagination -->
				<div class="swiper-pagination"></div>
			</div>
		</div>
	</div>	
	<!--商品属性介绍-->
	<form action="{url path='cart/index/add_to_cart'}" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY" >
	    <div class="goods-info">
	        <div class="goods-info-property ecjia-margin-b">
	            <!--商品描述-->
	            <div class="goods-style-name goods-style-name-new">
	                <div class="goods-name ecjiaf-fl">{$goods_info.goods_name}</div>
	            </div>
	            <div class="goods-price goods-price-new">
	                <!-- $goods.is_promote and $goods.gmt_end_time -->
	                <!--{if ($goods_info.promote_price gt 0) AND ($goods_info.promote_start_date lt $goods_info.promote_end_date) } 促销-->
	                	{$goods_info.formated_promote_price}
	                	<del> 原价：{$goods_info.shop_price}</del>
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
	        <div class="address-warehouse ecjia-margin-t">
	            <div class="ecjia-form may-like-literal">
	               <p class="may-like">也许你还喜欢</p>
	            </div>
				
	            <div class="ecjia-margin-t ecjia-margin-b form-group ecjia-form">
	                <span>默认仓库：</span>
	                <select name="region_id" id="" data-toggle="warehouse" data-url="{url path='goods/index/get_goods'}" data-id="{$goods.goods_id}">
	                    <!-- {foreach from=$warehouse item=val} -->
	                    <option value="{$val.region_id}" {if $house eq $val.region_id}selected="selected"{/if}>{$val.region_name}</option>
	                    <!-- {/foreach} -->
	                </select>
	            </div>
	        </div>
	
	        <ul class="sort-comment-list goods-comment-list ecjia-list ecjia-margin-t {if $related_goods}{else}goodsinfo-bottom{/if}">
	            <!-- {if $comment_list} -->
	            <li>
	                <a href="{url path='comment/index/init' args="id={$goods.goods_id}"}">
	                    <span class="ecjiaf-fl">商品评论</span>
	                    <i class="ecjiaf-fr iconfont icon-jiantou-right"></i>
	                    <span class="ecjiaf-fr">{$comments.count}条</span>
	                    <span class="rating rating{$comments.rank} ecjia-margin-r ecjiaf-fr">
	                        <span class="star"></span>
	                        <span class="star"></span>
	                        <span class="star"></span>
	                        <span class="star"></span>
	                        <span class="star"></span>
	                    </span>
	                </a>
	            </li>
	            <!-- {/if} -->
	            <!-- {foreach from=$comment_list item=comment} -->
	            <li class="comment-content">
	                <div class="comment-top user-img">
	                    <img class="ecjiaf-fl ecjia-margin-r" src="{$comment.user_img}">
	                    <span class="ecjiaf-fl">
	                        <p>
	                            <!--{if $comment.username}-->
	                            {$comment.username|escape:html}
	                            <!--{else}-->
	                            {$lang.anonymous}
	                            <!--{/if}-->
	                        </p>
	                        <p>
	                            <span class="rating rating{$comment.rank}">
	                                <span class="star"></span>
	                                <span class="star"></span>
	                                <span class="star"></span>
	                                <span class="star"></span>
	                                <span class="star"></span>
	                            </span>
	                        </p>
	                    </span>
	                    <span class="comment-add-time ecjiaf-fr">{$comment.add_time}</span>
	                </div>
	                <div class="comment-bottom">
	                    <p class="ecjia-margin-t ecjiaf-wwb">{$comment.content}</p>
	                </div>
	            </li>
	            <!--{foreachelse}-->
	            <li class="no-comment-list">该商品暂时没有评论</li>
	            <!--{/foreach}-->
	            <li class="add-comment">
	                <a href="{url path='goods/index/comment' args="id={$goods.goods_id}"}">发表评论</a>
	            </li>
	
	            <!-- <li class="ecjia-margin-t goods-info-msg">
	                <a href="{url path='goods/index/tag' args="id={$goods.goods_id}"}">
	                    商品标签
	                    <i class="iconfont icon-jiantou-right ecjiaf-fr"></i>
	                </a>
	            </li> -->
	        </ul>
	
	        <!-- 店铺信息 STRAT -->
	            <!-- {if $shop} -->
	            <div class="shop-message  ecjia-margin-t">
	                <div class="shop-title">
	                    <div class="shop-img ecjiaf-fl"><a href='{url path="touch/index/merchant_shop" args="ru_id={$shop.id}"}'><img src="{$shop.seller_logo}" /></a></div>
	                    <div class="ecjia-margin-l into-btn seller_name ecjiaf-fl"><a href='{url path="touch/index/merchant_shop" args="ru_id={$shop.id}"}'><p>{$shop.seller_name}</p>{$shop.follower}人关注</a></div>
	                    <div class="ecjiaf-fr"><a class="btn shop-into btn-info" href='{url path="touch/index/merchant_shop" args="ru_id={$shop.id}"} '>进入店铺</a></div>
	                </div>
	                <div class="ecjia-margin-t service">
	                    <ul class="ecjia-list ecjia-list-three">
	                        <li>评分：{$shop.comment.comment_goods}</li>
	                        <li>服务：{$shop.comment.comment_server}</li>
	                        <li>时效：{$shop.comment.comment_delivery}</li>
	                    </ul>
	                </div>
	            </div>
	            <!-- {else} -->
	            <div class="ecjia-margin-t service">
	                <ul class="ecjia-list">
	                    <li><a href="{url path='touch/index/merchant_shop' args="ru_id={$goods.user_id}"}"><p class="ecjiaf-fl">服务：</p><p class="ecjiaf-fl ecjia-margin-l">由{$service}从总部发货并提供售后服务</p></a></li>
	                </ul>
	            </div>
	            <!-- {/if} -->
	        <!-- 店铺信息 END -->
	
	        <!-- {if $related_goods} 猜你喜欢 -->
	        <div class="goods-link-like ecjia-margin-t">
	            <div class="hd"><span>{$lang.releate_goods}</span></div>
	            <div class="bd">
	                <!-- Swiper -->
	                <div class="swiper-container goods-link-likeshow">
	                    <div class="swiper-wrapper">
	                        <!--{foreach from=$related_goods item=relatedgoods }-->
	                        <div class="swiper-slide">
	                            <a href="{$relatedgoods.url}">
	                                <img src="{$relatedgoods.goods_thumb}" />
	                                <p class="link-goods-name">{$relatedgoods.short_name}</p>
	                                <p class="link-goods-price">
	                                    <!--{if $relatedgoods.promote_price}-->
	                                    {$relatedgoods.formated_promote_price}
	                                    <!--{else}-->
	                                    {$relatedgoods.shop_price}
	                                    <!--{/if}-->
	                                </p>
	                            </a>
	                        </div>
	                        <!--{/foreach}-->
	                    </div>
	                    <!-- Add Scroll Bar -->
	                    <div class="swiper-scrollbar"></div>
	                </div>
	            </div>
	        </div>
	        <!-- {/if} -->
	        <div class="goods-detail">
	            <a href="{url path='goods/index/show' args="id={$goods.goods_id}"}">
	                点击查看图文详情
	                <!-- <i class="iconfont icon-jiantou-right ecjiaf-fr"></i> -->
	            </a>
	        </div>
	
	    </div>
	    <!-- {if $cfg.use_storage eq 1 && $goods.goods_number eq 0} -->
	    <div class="goods-foot-button">
	        <p>{t}此商品已售罄，可进行缺货登记通知商家。{/t}</p>
	        <a class="btn btn-info add-to-cart" data-toggle="booking" data-pjaxurl="{url path='user/user_booking/add_booking' args="id={$goods.goods_id}"}">{$lang.add_to_cart}</a>
	    </div>
	    <!-- {else} -->
	
	    <div class="goods-foot-button">
	        <div class="buttom-collect-cart ecjiaf-fl">
	            <a class="collect<!--{if $sc eq 1}--> active<!--{/if}-->" href="javascript:void(0)" data-toggle="collect" data-url="{url path='user/user_collection/add_collection'}" data-id="{$goods.goods_id}">
	                <i class="iconfont {if $sc eq 1} icon-icon47 {else} icon-shoucang{/if}"></i>
	                <p>收藏</p>
	            </a>
	            <a href="{url path='cart/index/init'}">
	                <i class="iconfont icon-gouwuche"></i>
	                <p>购物车<sup>{$cart_num}</sup></p>
	            </a>
	        </div>
	        <div class="shopping-btn">
	            <a class="btn btn-info join-to-cart" data-toggle="addToCart" data-id="{$goods.goods_id}" data-url="{url path='cart/index/add_to_cart'}" href="javascript:;" data-pjaxurl="{url path='cart/index/init'}">{$lang.add_to_cart}</a>
	            <a class="btn btn-info nopjax go-shop"  data-toggle="addToCart" data-id="{$goods.goods_id}" data-url="{url path='cart/index/add_to_cart'}" data-message="1" href="javascript:;" data-pjaxurl="{url path='cart/index/init' args="goods_id={$goods.goods_id}"}">{$lang.buy_now}</a>
	        </div>
	    </div>
	    <!-- {/if} -->
	</form>
</div>
<!-- 切换商品页面end -->


<!-- 切换详情页面start -->
<div class="goods-desc-info active" id="goods-info-two">
	<!--商品描述-->
	<!-- Nav tabs -->
	<ul class="ecjia-list ecjia-list-two ecjia-nav goods-desc-nav goods-desc-nav-new">
		<li class="">
			<a class="nopjax" href="#one" role="tab" data-toggle="tab">图文详情</a>
		</li>
		<li><a class="nopjax" href="#two" role="tab" data-toggle="tab">规格参数</a></li>
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
	<!-- 相关商品 -->
	<!-- {if $related_goods} 猜你喜欢 -->
	<div class="goods-link-like ecjia-margin-b">
		<div class="hd"><span>{$lang.releate_goods}</span></div>
		<div class="bd">
			<ul class="ecjia-list">
				<!--{foreach from=$related_goods item=goods name=goods}-->
				<li>
					<a href="{$goods.url}">
						<img src="{$goods.goods_thumb}" />
					</a>
					<p class="link-goods-name">{$goods.short_name}</p>
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
	<!-- {/if} -->
</div>
<!-- 切换详情页面end -->
<!-- {/block} -->
