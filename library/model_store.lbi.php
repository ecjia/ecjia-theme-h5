<?php
/*
Name: 首页推荐商家
Description: 这是推荐商家
Libraries: suggest_store
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {if $data} -->
<div class="ecjia-mod ecjia-store-model ecjia-margin-t">
    <div class="head-title">
        <h2><i class="icon-store"></i>{t domain="h5"}推荐店铺{/t}</h2>
    </div>
    <div class="ecjia-suggest-store-content">
        <ul class="ecjia-suggest-store" id="suggest_store_list" {if $is_last neq 1}data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{RC_Uri::url('touch/index/ajax_suggest_store')}" data-page="2" {/if}>
        <!-- {foreach from=$data item=val} -->
        <li class="store-info">
            <div class="basic-info">
                <div class="store-left">
                    <a class="seller-logo nopjax external" href="{RC_Uri::url('merchant/index/init')}&store_id={$val.id}">
                        <img src="{$val.seller_logo}">
                        {if $val.shop_closed eq 1}
                        <div class="shop_closed_mask">{t domain="h5"}休息中{/t}</div>
                        {/if}
                    </a>
                </div>
                <div class="store-right">
                    <a class="nopjax external" href="{RC_Uri::url('merchant/index/init')}&store_id={$val.id}">
                        <div class="store-title">
                            <span class="store-name">{$val.seller_name}</span>
                            {if $val.manage_mode eq 'self'}<span class="manage_mode">{t domain="h5"}自营{/t}</span>{/if}
                            {if $val.is_follower eq 1}<img class="followed" src="{$theme_url}images/user_center/icon_follow.png">{/if}
                            <span class="store-distance">{$val.distance}</span>
                        </div>
                        <div class="store-range">
                            <i class="icon-shop-time"></i>{$val.label_trade_time}

                            <!-- {if $val.allow_use_quickpay eq 1} -->
                            <a href="{RC_Uri::url('user/quickpay/init')}&store_id={$val.id}"><span class="store-quickpay-btn">{t domain="h5"}买单{/t}</span></a>
                            <!-- {/if} -->

                        </div>
                        {if $val.seller_notice}
                        <div class="store-notice">
                            <i class="icon-shop-notice"></i>{$val.seller_notice}
                        </div>
                        {/if}
                        <!-- {if $val.favourable_list} -->
                        <ul class="store-promotion">
                            <!-- {foreach from=$val.favourable_list item=list} -->
                            <li class="promotion">
                                <span class="promotion-label">{$list.type_label}</span>
                                <span class="promotion-name">{$list.name}</span>
                            </li>
                            <!-- {/foreach} -->
                        </ul>
                        <!-- {/if} -->

                        <!-- {if $val.allow_use_quickpay eq 1 && $val.quickpay_activity_list} -->
                        <ul class="store-promotion">
                            <!-- {foreach from=$val.quickpay_activity_list item=list key=key} -->
                            {if $key eq 0}
                            <li class="quick">
                                <span class="quick-label">{t domain="h5"}买单{/t}</span>
                                <span class="promotion-name">{$list.title}</span>
                            </li>
                            {/if}
                            <!-- {/foreach} -->
                        </ul>
                        <!-- {/if} -->

                    </a>
                    {if $val.seller_goods}
                    <div class="suggest-goods-list">
                        <!-- {foreach from=$val.seller_goods item=goods key=key} -->
                        <!-- {if $key < 4} -->
                        <a class="nopjax external" href="{RC_Uri::url('merchant/index/init')}&store_id={$val.id}">
                            <img src="{$goods.img.small}">
                            <span class="goods_price">{$goods.shop_price}</span>
                        </a>
                        <!-- {/if} -->
                        <!-- {/foreach} -->
                    </div>
                    {/if}
                </div>
                <div class="clear_both"></div>
            </div>
        </li>
        <!-- {/foreach} -->
        </ul>
    </div>
</div>
<!-- {/if} -->