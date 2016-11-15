<?php 
/*
Name: å•†å“æè¿°æ¨¡æ¿
Description: è¿™æ˜¯å•†å“æè¿°é¦–é¡µ
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.b2b2c.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<div class="shop-message shop-detail-titel  ecjia-margin-t">
    <div class="shop-title ecjia-margin-b">
        <div class="shop-img ecjia-margin-r ecjiaf-fl"><a href='{url path="touch/index/merchant_shop" args="ru_id={$shop.id}"}'><img src="{$shop.seller_logo}" /></a></div>
        <div class="ecjia-margin-l seller_name ecjiaf-fl"><a href='{url path="touch/index/merchant_shop" args="ru_id={$shop.id}"}'><p>{$shop.seller_name}</p>{$shop.follower}人关注</a></div>
        <div class="ecjiaf-fr"><a class="btn shop-into btn-info"  data-toggle="is_attention" data-url="{url path='touch/index/add_attention'}" data-pjaxurl="{url path='touch/index/shop_init' args="id={$id}"}" value="{$id}" data-is_attention="{if $shop.attention }1{/if}">{if $shop.attention}已关注{else}<i class="iconfont icon-add"></i>关注{/if}</a></div>
    </div>
    <ul class="ecjia-list ecjia-list-four ecjia-margin-b ecjia-shop-goods">
        <li>{$shop.goods_type_count.count}<br>全部商品</li>
        <li>{$shop.goods_type_count.new_goods}<br>上新</li>
        <li>{$shop.goods_type_count.best_goods}<br>精品</li>
        <li>{$shop.goods_type_count.hot_goods}<br>热推</li>
    </ul>
    <div class="shop-score">
        <ul>
            <div>商品评分：{$shop.comment.comment_goods}</div>
            <div>物流评分：{$shop.comment.comment_delivery}</div>
            <div>服务评分：{$shop.comment.comment_server}</div>
        </ul>
    </div>
</div>
    <div class="ecjia-margin-t">
        <ul class="ecjia-list">
            <li>商家电话：{$shop_info.kf_tel}</li>
        </ul>
    </div>
    <div class="ecjia-margin-t ecjia-margin-b">
        <ul class="ecjia-list">
            <li>公司名称：{$shop_info.shop_name}</li>
            <li>公司地区：{$shop_info.province} {$shop_info.city}&nbsp;{$shop_info.shop_address}</li>
            <li>店铺公告：{$shop_info.notice}</li>
        </ul>
    </div>
<!-- {/block} -->