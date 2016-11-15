<?php
/*
Name: 首页-个护彩妆模块
Description: 首页个护彩妆模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-mod ecjia-makeup-model ecjia-margin-t">
	<div class="hd">
		<h2><i class="iconfont icon-caizhuang"></i>个护彩妆</h2>
	</div>
	<div class="bd">
	    <div class="swiper-container ecjia-makeup-list">
	        <div class="swiper-wrapper">
	            <!--{foreach from=$new_goods item=relatedgoods }-->
	            <div class="swiper-slide">
	                <a href="{$relatedgoods.url}">
	                    <div class="relatedgoods-img"><img src="{$relatedgoods.goods_img}" /></div>
	                    <p class="link-goods-name">{$relatedgoods.name}</p>
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
<style media="screen">
{literal}
.ecjia-makeup-model .hd{color:#19b2f0}
.ecjia-makeup-model .bd{border:0;padding:0 .5em}
.ecjia-makeup-model .bd .ecjia-makeup-list p{text-align:left;overflow:hidden;padding:0 .2em;height:1.4em;margin-top:.2em;white-space:nowrap;text-overflow:ellipsis}
.ecjia-makeup-model p.link-goods-price{color:#ef3030;margin-bottom:.5em}
.ecjia-makeup-model .ecjia-makeup-list .swiper-slide{width:33%;border:1px solid #eee;margin:0 0 1em 0}
.swiper-slide .relatedgoods-img{height:0;padding-bottom:100%;overflow:hidden;margin:0 auto}
.ecjia-mod .hd {border-top-color: #19b2f0;}
{/literal}
</style>
<script type="text/javascript">
var swiper = new Swiper('.ecjia-makeup-list', {
    paginationClickable: true,
    spaceBetween: 4,
    freeMode: true,
    scrollbar: '.swiper-scrollbar',
    slidesPerView: 'auto'
});
</script>
