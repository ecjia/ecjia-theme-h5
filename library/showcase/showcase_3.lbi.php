<?php
/*
Name: 首页-新年特惠商品列表
Description: 首页新年特惠商品列表
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="showcase8-goods ecjia-margin-t">
    <img src="{$theme_url}images/showcase8_3.png" />
    <ul class="ecjia-margin-b ecjia-list list-page ecjia-list-two list-page-two ">
        <!-- {foreach from=$best_goods item=sales} 循环商品 -->
        <li class="single_item">
            <a class="list-page-goods-img" href="{$sales.url}">
                <span class="goods-img"><img src="{$sales.goods_img}" alt="{$sales.name}"></span>
                <span class="list-page-box">
                    <span class="goods-name">{$sales.name}</span>
                    <span class="list-page-goods-price">
                        <!--{if $sales.promote_price}-->
                        <span>{$sales.promote_price}</span>
                        <!--{else}-->
                        <span>{$sales.shop_price}</span>
                        <!--{/if}-->
                        <!--{if $sales.market_price}-->
                        <del>{$sales.market_price}</del>
                        <!--{/if}-->
                    </span>
                </span>
            </a>
        </li>
        <!-- {/foreach} -->
    </ul>
</div>
<style media="screen">
{literal}
.showcase8-goods {background-color: #ef3030;}
.showcase8-goods>img {width:100%;background-color:#efeff4;}
{/literal}
</style>
