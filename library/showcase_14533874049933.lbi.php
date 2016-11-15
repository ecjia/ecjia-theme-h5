<?php
/*
Name: 自定义橱窗_气质女装模块
Description: 首页气质女装模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-mod ecjia-making-model red ecjia-margin-t">
	<div class="hd">
		<h2><i class="iconfont icon-nvzhuang1"></i>气质女装</h2>
	</div>
	<div class="bd">
	    <div class="swiper-container ecjia-clothing-list">
	        <div class="swiper-wrapper">
	            <!--{foreach from=$new_goods item=relatedgoods }-->
	            <div class="swiper-slide">
	                <a href="{$relatedgoods.url}">
	                    <img src="{$relatedgoods.goods_img}" />
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
            <div class="swiper-scrollbar swiper-scrollbar-2"></div>
	    </div>
	</div>
</div>
<style media="screen">
{literal}
.ecjia-making-model .hd{color:#ef3030}
.ecjia-making-model .bd{border:0;padding:0 .5em}
.ecjia-making-model p.link-goods-price{color:#ef3030;padding-bottom:1em}
.ecjia-making-model .bd .ecjia-clothing-list p{text-align:left;overflow:hidden;padding:0 .2em;height:1.4em;margin-top:.2em;white-space:nowrap;text-overflow:ellipsis}
.ecjia-making-model .ecjia-clothing-list .swiper-slide{width:33%;border:1px solid #eee;margin:0 0 1em 0}
{/literal}
</style>
<script type="text/javascript">
    var swiper = new Swiper('.ecjia-clothing-list', {
        slidesPerView: 3,
        paginationClickable: true,
        spaceBetween: 4,
        freeMode: true,
        scrollbar: '.swiper-scrollbar-2',
        slidesPerView: 'auto',
    });
</script>
