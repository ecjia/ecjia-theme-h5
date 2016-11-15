<?php
/*
Name: 商品详情模板
Description: 这是商品详情首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.touch.goods.init();
    ecjia.touch.goods.goods_img();
    ecjia.touch.goods.goods_link();
    ecjia.touch.b2b2c.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<!--商品图片相册-->
<div class="goods-img" id="focus">
	<div class="bd">
		<!-- Swiper -->
		<div class="swiper-container goods-imgshow">
			<div class="swiper-wrapper">
				<!--{foreach from=$pictures item=picture}-->
					<div class="swiper-slide">
						<img src="{$picture.img_url}" />
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
            <div class="goods-price">
                <!-- $goods.is_promote and $goods.gmt_end_time -->
                <!--{if 0 } 促销-->
                {$lang.promote_price}
                <!--{else if 0}-->
                {$lang.shop_price}
                <!--{/if}-->
                <!--{if $goods.is_promote and $goods.gmt_end_time } 促销-->
                {$goods.promote_price}
                <!--{else }-->
                {$goods.shop_price_formated}
                <!--{/if}-->
                <!-- {if $goods.market_price} 市场价格-->
                <del>
                    <!-- {if $cfg.show_marketprice} 市场价格-->
                    {$goods.market_price}
                    <!-- {/if} -->
                </del>
                <!-- {/if} -->
                <span class="hidden">{$cfg.use_storage}</span>
                <!-- {if $cfg.use_storage eq 1 && $goods.goods_number eq 0} -->
                <span class="no-goods-number">{$lang.goods_booking}</span>
                <!-- {/if} -->
            </div>
            <div class="goods-style-name">
                <div class="goods-name ecjiaf-fl">{$goods.goods_style_name}</div>
                <div class="goods-sort-like ecjiaf-fr">
                    <span>{$lang.sort_sales} <span>{$sales_count}</span> {$lang.piece}</span>
                    <span>{$lang.like} <span>{$goods.sc}</span> {$lang.like_last}</span>
                </div>
            </div>
            <!-- {if $goods.goods_brief} -->
            <div class="goods-describe ecjiaf-wwb">
                {$goods.goods_brief}
            </div>
            <!-- {/if} -->

            <div class="goods-attrbute"></div>
        </div>

        <div class="bd goods-type ecjia-margin-t">
            <!-- {foreach name=spec from=$specification item=spec key=spec_key} -->
            <div class="goods-option-con">
                <span class="spec-name">{$spec.name}</span>
                <div class="goods-option-conr">
                    <!-- {* 判断属性是复选还是单选 *} -->
                    <!-- {if $spec.attr_type eq 1} -->
                        <!-- {foreach from=$spec.values item=value key=key} -->
                        <input id="spec_value_{$value.id}" name="spec_{$spec_key}" type="radio" value="{$value.id}" {if $key eq 0}checked{/if} data-toggle="changeprice_parts" data-id="{$goods.goods_id}" data-url="{url path='goods/index/price'}" />
                        <label class="option-radio{if $key eq 0} active{/if}" for="spec_value_{$value.id}">{$value.label}<!-- [if $value.price gt 0$lang.pluselseif $value.price lt 0$lang.minus/if$value.format_price}] --></label>
                        <!-- {/foreach} -->
                        <input type="hidden" name="spec_list" value="{$key}" />
                    <!-- {else} -->
                        <!-- {foreach from=$spec.values item=value key=key} -->
                        <input id="spec_value_{$value.id}" name="spec_{$spec_key}" type="checkbox" value="{$value.id}" data-toggle="changeprice_parts" data-id="{$goods.goods_id}" data-url="{url path='goods/index/price'}" />
                        <label class="option-checkbox" for="spec_value_{$value.id}">
                            <i class="glyphicon glyphicon-ok"></i>
                            {$value.label} <!-- [if $value.price gt 0$lang.pluselseif $value.price lt 0$lang.minus/if$value.format_price] -->
                        </label>
                        <!-- {/foreach} -->
                    <!-- {/if} -->
                </div>
            </div>
            <!-- {/foreach} -->
            <div class="goods-option-con goods-num">
                <div class="spec-name">{$lang.number}</div>
                <!-- {if $goods.goods_id gt 0 && $goods.is_gift eq 0 && $goods.parent_id eq 0} 普通商品可修改数量 -->
                <div class="ecjia-input-number">
                    <span class="ecjia-number-group-addon"  data-toggle="changeprice" data-option="del" data-id="{$goods.goods_id}" data-url="{url path='goods/index/price'}">－</span>
                    <input class="ecjia-number-contro" type="text" class="form-contro form-num" name="number" id="goods_number" type="text"  autocomplete="off" value="1"/>
                    <span class="ecjia-number-group-addon" data-toggle="changeprice" data-id="{$goods.goods_id}" data-url="{url path='goods/index/price'}" data-option="add">＋</span>
                </div>
                <!-- {else} -->
                <input type="text" class="form-contro form-num" readonly="1" value="{$goods.goods_number} "/>
                <!-- {/if} -->
            </div>
        </div>

        <!-- {if $promotion} 优惠活动 -->
        <section class="ecjia-margin-t">
            <ul class="ecjia-list goods-activity-list">
                <!-- {foreach from=$promotion item=item key=key} 优惠活动-->
                <!-- {if $item.type eq "snatch"} -->
                <li>
                    <a href="{$item.url}" title="{$lang.snatch}">
                        <i class="label tbqb">{$lang.snatch_act}</i>
                        [{$lang.snatch}]
                    </a>
                </li>
                <!-- {elseif $item.type eq "group_buy"} -->
                <li>
                    <a href="" title="{$lang.group_buy}">
                        <i class="label tuan">{$lang.group_buy_act}</i>
                        [{$lang.group_buy}]
                    </a>
                </li>
                <!-- {elseif $item.type eq "auction"} -->
                <li>
                    <a href="" title="{$lang.auction}">
                        <i class="label pm">{$lang.auction_act}</i>
                        [{$lang.auction}]
                    </a>
                </li>
                <!-- {elseif $item.type eq "favourable"} -->
                <li>
                    <a href="{$item.url}" title="{$lang.$item.type} {$item.act_name}{$item.time}">
                        <!--{if $item.act_type eq 0}-->
                        <i class="label mz">{$lang.favourable_mz}</i>
                        <!--{elseif $item.act_type eq 1}-->
                        <i class="label mj">{$lang.favourable_mj}</i>
                        <!--{elseif $item.act_type eq 2}-->
                        <i class="label zk">{$lang.favourable_zk}</i>
                        <!--{/if}-->
                        {$item.act_name}
                    </a>
                </li>
                <!-- {/if} -->
                <!-- {/foreach} -->
            </ul>
        </section>
        <!-- {/if} -->

        <div class="address-warehouse ecjia-margin-t">
            <div class="ecjia-form">
                <span>配送地址：</span>
                <select class="form-select" id="selProvinces" name="province" data-toggle="region_change" data-city="{$city_id}" data-url="index.php?m=goods&c=index&a=region" data-type="2" data-target="selCities">
                    <option value="0">{$lang.please_select}{$name_of_region[1]}</option>
                    <!-- {foreach from=$province_list item=province} -->
                        <option value="{$province.region_id}" {if $province_id eq $province.region_id}selected="selected"{/if}>{$province.region_name}</option>
                    <!-- {/foreach} -->
                </select>
                <select class="form-select" id="selCities" name="city" data-toggle="region_change" data-url="index.php?m=goods&c=index&a=region" data-type="3" data-target="selDistricts">
                    <option value="0">{$lang.please_select}{$name_of_region[2]}</option>
                    <!-- {foreach from=$city_list item=city} -->
                    <option value="{$city.region_id}">{$city.region_name}</option>
                    <!-- {/foreach} -->
                </select>

                <select class="form-select" id="selDistricts" name="district" {if !$district_list}style="display:none"{/if}  data-toggle="district" data-url="{url path='goods/index/get_goods'}" data-id="{$goods.goods_id}">
                    <option value="0">{$lang.please_select}{$name_of_region[3]}</option>
                    <!-- {foreach from=$district_list item=district} -->
                    <option value="{$district.region_id}" {if $consignee.district eq $district.region_id}selected{/if}>{$district.region_name}</option>
                    <!-- {/foreach} -->
                </select>
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
<!-- {/block} -->
