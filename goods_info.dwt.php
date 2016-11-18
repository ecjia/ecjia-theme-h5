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

<div class="goods-desc-info">
	<!--商品描述-->
	<!-- Nav tabs -->
	<ul class="ecjia-list ecjia-list-two ecjia-nav goods-desc-nav">
		<li class="active"><a class="nopjax" href="#one" role="tab" data-toggle="tab">{$lang.goods_brief}</a></li>
		<li><a class="nopjax" href="#two" role="tab" data-toggle="tab">{$lang.goods_attr}</a></li>
	</ul>
	<!-- Tab panes -->
	<div class="bd">
		<div class="goods-describe ecjia-margin-b active" id="one">
			<!-- {if $goods.goods_desc} -->
			{$goods.goods_desc}
			<!-- {else} -->
			<div class="ecjia-nolist">
				<p class="tags_list_font">{t}此商品暂时没有详情{/t}</p>
			</div>
			<!-- {/if} -->
		</div>
		<div class="goods-describe ecjia-margin-b" id="two">
		<!-- {if $properties} -->
			<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#dddddd">
				<!-- {foreach from=$properties item=property_group key=key} -->
				<tr>
					<th colspan="2" bgcolor="#FFFFFF">{$key|escape}</th>
				</tr>
				<!-- {foreach from=$property_group item=property} -->
				<tr>
					<td bgcolor="#FFFFFF" align="left" width="30%" class="f1">[{$property.name|escape:html}]</td>
					<td bgcolor="#FFFFFF" align="left" width="70%">{$property.value}</td>
				</tr>
				<!-- {/foreach}-->
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
<!-- {/block} -->
