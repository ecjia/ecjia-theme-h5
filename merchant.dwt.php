<?php 
/*
Name: 商户列表
Description: 商户列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.b2b2c.init();</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
	<ul class="ecjia-list ecjia-shop-list" id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='ansy_merchant_list'}" data-size="10">
	</ul>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->

<!-- {foreach from=$merchant item=list} -->
<li class="ecjia-margin-t">
	<div class="shop-list-head">
		<div class="shop-img-logo ecjiaf-fl">
			<a href='{url path="touch/index/merchant_shop" args="ru_id={$list.ru_id}"}'>{if $list.shop_logo}<img src="{$list.shop_logo}" />{else}<img src="{$list.goods_list.0.small}">{/if}</a>
		</div>
		<div class="shop-name ecjiaf-fl ecjia-margin-l">
			<a href='{url path="touch/index/merchant_shop" args="ru_id={$list.ru_id}"}'><span>{$list.shop_name}</span><br><span>{$list.follower}人关注 共{$list.goods_count}件宝贝</span></a>
		</div>
		<div class="shop-attention ecjiaf-fr ecjia-margin-t">
			<button class="btn btn-info" data-toggle="is_attention" data-url="{url path='touch/index/add_attention'}" data-pjaxurl="{url path='touch/index/merchant_list'}" value="{$list.ru_id}" data-is_attention="{if $list.is_attention }1{/if}">
				{if  $list.is_attention }已关注{else}<i class="iconfont icon-shoucang"></i>关注{/if}
			</button>
		</div>
	</div>
	<ul class="ecjia-list ecjia-list-three ecjia-margin-t shop-goods">
		<!-- {foreach from= $list.goods_list item=val} -->
		<li class="ecjiaf-fl ecjia-margin-r">
			<div class="shop-goods-img"><a href='{url path="goods/index/init" args="id={$val.id}"}'><img src="{$val.img.thumb}"></a></div>
		</li>
		<!-- {/foreach} -->
	</ul>
</li>
<!-- {foreachelse} -->
<div class="ecjia-nolist">
	<i class="iconfont icon-shop"></i>
	<p>{t}暂无店铺{/t}</p>
</div>
<!-- {/foreach} -->
<!-- {/block} -->