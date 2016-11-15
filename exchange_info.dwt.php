<?php 
/*
Name: 交易信息模板
Description: 这是交易信息首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.goods.init();</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<header class="ecjia-header">
	<a class="ecjia-header-icon" href="javascript:history.go(-1)"><i class="glyphicon glyphicon-menu-left"></i></a>
	<p>{$title}</p>
</header>
<!--商品图片相册-->
<div class="focus goods-focus" id="focus">
	<div class="hd">
		<ul></ul>
	</div>
	<div class="bd">
		<ul id="Gallery">
			<li>
				<a href="#">
					<img alt="{$goods.goods_name}" src="{$goods.original_img}"/>
				</a>
			</li>
			<!--{if $pictures}-->
			<!-- {foreach from=$pictures item=picture name=no}-->
			<!-- {if $smarty.foreach.no.iteration >
			1}  -->
			<li>
				<a href="#">
					<img alt="{$goods.goods_name}" src="{$picture.img_url}"/>
				</a>
			</li>
			<!-- {/if}-->
			<!--{/foreach}-->
			<!--{/if}-->
		</ul>
	</div>
</div>
<!--商品属性介绍-->
<div class="goods-info">
	<section class=" goods-title">
		<h4 class="title pull-left">
			<!--{if $goods.goods_style_name}-->
			{$goods.goods_name}
			<!--{else}-->
			{$goods.goods_name}
			<!--{/if}-->
		</h4>
		<span class="pull-right text-center <!--{if $sc eq 1}-->ect-colory<!--{/if}-->ect-padding-lr" id='ECS_COLLECT' onClick="collect({$goods.goods_id})"> 
				<i class="fa <!--{if $sc eq 1}-->fa-heart<!--{else}-->fa-heart-o<!--{/if}-->"></i>
			<br>{$lang.btn_collect}
		</span>
	</section>
	<section>

		<p>
			<span>
				{$lang.exchange_integral}: <strong >{$goods.exchange_integral}</strong>
			</span>
		</p>
		<!-- {if $cfg.show_goodssn} 显示商品货号-->
		<p>
			<span>
				{$lang.goods_sn} <strong>{$goods.goods_sn}</strong>
			</span>
		</p>
		<!-- {/if} -->
		<!-- {if $goods.goods_brand neq "" and $cfg.show_brand} 显示商品品牌-->
		<p>
			{$lang.goods_brand}
			<strong ><a href="{$goods.goods_brand_url}">{$goods.goods_brand}</a></strong> 
		</p>
		<!-- {/if} -->
		<!-- {if $cfg.show_goodsweight} 商品重量-->
		<p>
			{$lang.goods_weight}<strong>{$goods.goods_weight}</strong>
		</p>
		<!-- {/if} -->
	</section>
	<form action="{url path='exchange/buy'}" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY" >
		<input type="hidden" name="valid_goods" value="{$group_buy.valid_goods}" />
		<input type="hidden" name="group_buy_id" value="{$group_buy.group_buy_id}" />
		<section class="goods-option">
			<div class="goods-optionc">
				<!-- {foreach name=spec from=$specification item=spec key=spec_key} -->
				<div class="goods-option-con">
					<span>{$spec.name}：</span>
					<div class="goods-option-conr">

						<!-- {* 判断属性是复选还是单选 *} -->
						<!-- {if $spec.attr_type eq 1} -->
						<!-- {if $cfg.goodsattr_style eq 1} -->
						<!-- {foreach from=$spec.values item=value key=key} -->
						<input id="spec_value_{$value.id}" name="spec_{$spec_key}" type="radio" value="{$value.id}" {if $key eq 0}checked{/if} onclick="changePrice()" />
						<label for="spec_value_{$value.id}">{$value.label}</label>
						<!-- {/foreach} -->
						<input name="spec_list" type="hidden" value="{$key}" />
						<!-- {else} -->
						<select name="spec_{$spec_key}" onchange="changePrice()">
							<!-- {foreach from=$spec.values item=value key=key} -->
							<option label="{$value.label}" value="{$value.id}">
								{$value.label} {if $value.price gt 0}{$lang.plus}{elseif $value.price lt 0}{$lang.minus}{/if}{if $value.price neq 0}{$value.format_price}{/if}
							</option>
							<!-- {/foreach} -->
						</select>
						<input name="spec_list" type="hidden" value="{$key}" />
						<!-- {/if} -->
						<!-- {else} -->
						<!-- {foreach from=$spec.values item=value key=key} -->
						<input id="spec_value_{$value.id}" name="spec_{$spec_key}" type="checkbox" value="{$value.id}" onclick="changePrice()" />
						<label for="spec_value_{$value.id}">
							{$value.label} [{if $value.price gt 0}{$lang.plus}{elseif $value.price lt 0}{$lang.minus}{/if} {$value.format_price|abs}]
						</label>
						<!-- {/foreach} -->
						<!-- {/if} -->
					</div>
				</div>
				<!-- {/foreach} -->
			</div>
		</section>
		<input name="goods_id" type="hidden" value="{$goods.goods_id}" />
		<div class=" goods-submit">
			<button class="btn btn-info" type="submit" >{$lang.exchange_goods}</button>
		</div>
		<section class="user-tab ">
			<div id="is-nav-tabs"></div>
			<!-- Nav tabs -->
			<ul class="nav nav-tabs text-center">
				<li class="col-xs-6 active">
					<a href="#one" role="tab" data-toggle="tab">{$lang.goods_attr}</a>
				</li>
				<li class="col-xs-6">
					<a href="#two" role="tab" data-toggle="tab">{$lang.goods_brief}</a>
				</li>
			</ul>
			<!-- Tab panes -->
			<div class="tab-content">
				<div class="tab-pane tab-info active" id="one">
					<table class="exchange_info_table">
						<!-- {foreach from=$properties item=property_group key=key} -->
						<tr>
							<th colspan="2" bgcolor="#FFFFFF">{$key|escape}</th>
						</tr>
						<!-- {foreach from=$property_group item=property} -->
						<tr>
							<td class="f1">[{$property.name|escape:html}]</td>
							<td class="f2">{$property.value}</td>
						</tr>
						<!-- {/foreach}-->
						<!-- {/foreach}-->
					</table>
				</div>
				<div class="tab-pane tab-att" id="two">{$goods.goods_desc}</div>
			</div>
		</section>
	</form>
</div>
<!-- {/block} -->