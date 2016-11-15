<?php 
/*
Name: 抢购模板
Description: 这是抢购页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.goods.init();</script>
<script type="text/javascript" src="{$theme_url}js/lefttime.js"></script>
<script type="text/javascript">
	var gmt_end_time = {$snatch_goods.gmt_end_time|default:0};
	var id = {$id};
	{foreach from=$lang.snatch_js item=item key=key}
		var {$key} = "{$item}";
	{/foreach}
	{foreach from=$lang.goods_js item=item key=key}
		var {$key} = "{$item}";
	{/foreach}
	<!-- {literal} -->

	onload = function(){
		try{window.setInterval("newPrice(" + id + ")", 8000);
			onload_leftTime();
		}catch (e){}
	}
	<!-- {/literal} -->
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
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
				<a href="{$snatch_goods.goods_img}">
					<img src="{$snatch_goods.goods_img}" alt="{$snatch_goods.goods_name}" />
				</a>
			</li>
			<!--{if $pictures}-->
			<!-- {foreach from=$pictures item=picture name=no}-->
			<!-- {if $smarty.foreach.no.iteration >1}  -->
			<li>
				<a href="{$picture.img_url}">
					<img src="{$picture.img_url}" alt="{$picture.img_desc}" />
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
	<!--商品描述-->
	<section class=" goods-title">
		<h4 class="title pull-left">
			{$snatch_goods.goods_name}{if $snatch_goods.product_id > 0}&nbsp;[{$products_info}]{/if}
		</h4>
		<span class="pull-right text-center"  id='ECS_COLLECT'>&nbsp;</span>
	</section>
	<section>
		<p>
			{$lang.shop_price}{$snatch_goods.formated_shop_price}
			<small> <del>{$snatch_goods.market_price}</del></small>
		</p>
		<p>
			{$lang.residual_time}
			<span id="leftTime">{$lang.please_waiting}</span>
		</p>
		<p>{$lang.activity_desc}：{$snatch_goods.desc|escape:html|nl2br}</p>
	</section>
	<!-- {if $myprice.is_end eq false} -->
	<form action="javascript:bid()" method="post" name="formBid" id="formBid" >
		<section class="goods-option">
			<div class="goods-num">
				<span class="pull-left">{$lang.my_integral}：</span>
				{$myprice.pay_points}
			</div>
			<div class="goods-num">
				<span class="pull-left">{$lang.bid}：</span>
				<div class="input-group pull-left wrap">
					<input name="snatch_id" type="hidden" value="{$id}" />
					<input class="form-contro form-num" id="goods_number" name="price" type="text" autocomplete="off" />
				</div>
				<input class="btn" type="submit" value="{$lang.me_bid}"/>
			</div>
		</section>
	</form>
	<section class="user-tab">
		<div id="is-nav-tabs"></div>
		<!-- Nav tabs -->
		<ul class="nav nav-tabs text-center">
			<li class="col-xs-4 active">
				<a href="#one" role="tab" data-toggle="tab">{$lang.activity_intro}</a>
			</li>
			<li class="col-xs-4">
				<a href="#two" role="tab" data-toggle="tab">{$lang.me_now_bid}</a>
			</li>
			<li class="col-xs-4">
				<a href="#three" role="tab" data-toggle="tab">{$lang.new_price}</a>
			</li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane tab-info active" id="one">
				{$snatch_goods.snatch_time}
				<br />
				{$lang.price_extent}{$snatch_goods.formated_start_price} - {$snatch_goods.formated_end_price}
				<br />
				{$lang.user_to_use_up}{$snatch_goods.cost_points} {$points_name}
				<br />
				{$lang.snatch_victory_desc}
				<br />
				<!--{if $snatch_goods.max_price neq 0}-->
				{$lang.price_less_victory}{$snatch_goods.formated_max_price}，{$lang.price_than_victory}{$snatch_goods.formated_max_price}，{$lang.or_can}{$snatch_goods.formated_max_price}{$lang.shopping_product}。
				<!--{else}-->
				{$lang.victory_price_product}
				<!--{/if}-->
			</div>
			<div class="tab-pane tab-att" id="two">
				<div id="ECS_SNATCH">
					<!-- #BeginLibraryItem "/library/snatch.lbi" -->
					<!-- #EndLibraryItem -->
				</div>
			</div>
			<div class="tab-pane tab-att" id="three">
				<div id="ECS_PRICE_LIST">
					<!-- #BeginLibraryItem "/library/snatch_price.lbi" -->
					<!-- #EndLibraryItem -->
				</div>
			</div>
		</div>
	</section>
	<!--{else}-->
	<form name="buy" action="{url path='buy' args="id={$id}"}" method="post">
		<section class="goods-option">
			<div class="goods-num">
				<span class="pull-left">{$lang.price_bid}：</span>
				<div class="pull-left wrap">{$result.formated_bid_price}</div>
				<!-- {if $result.order_count eq 0 and $result.user_id eq $smarty.session.user_id} -->
				<input class="btn" type="submit" name="bug" value="{$lang.me_bid}" />
				<!--{/if}-->
			</div>
		</section>
	</form>
	<section class="user-tab">
		<div id="is-nav-tabs" style="height:3.15em; display:none;"></div>
		<!-- Nav tabs -->
		<ul class="nav nav-tabs text-center">
			<li class="col-xs-6 active">
				<a href="#one" role="tab" data-toggle="tab">{$lang.activity_intro}</a>
			</li>
			<li class="col-xs-6">
				<a href="#two" role="tab" data-toggle="tab">{$lang.view_snatch_result}</a>
			</li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content">
			<div class="tab-pane tab-info active" id="one">
				{$snatch_goods.snatch_time}
				<br />
				{$lang.price_extent}{$snatch_goods.formated_start_price} - {$snatch_goods.formated_end_price}
				<br />
				{$lang.user_to_use_up}{$snatch_goods.cost_points} {$points_name}
				<br />
				{$lang.snatch_victory_desc}
				<br />
				<!--{if $snatch_goods.max_price neq 0}-->
				{$lang.price_less_victory}{$snatch_goods.formated_max_price}，{$lang.price_than_victory}{$snatch_goods.formated_max_price}，{$lang.or_can}{$snatch_goods.formated_max_price}{$lang.shopping_product}。
				<!--{else}-->
				{$lang.victory_price_product}
				<!--{/if}-->
			</div>
			<div class="tab-pane tab-att" id="two">
				<!--{if $result}-->
				<div class="tab-content">
					<div class="tab-msg">
						<ul class="msg">
							<li>
								<p>
									<span class="pull-left">{$lang.victory_user}</span>
									<span class="pull-right">{$result.user_name}</span>
								</p>
							</li>
							<li>
								<p>
									<span class="pull-left">{$lang.price_bid}</span>
									<span class="pull-right">{$result.formated_bid_price}</span>
								</p>
							</li>
							<li>
								<p>
									<span class="pull-left">{$lang.bid_time}</span>
									<span class="pull-right">{$result.bid_time}</span>
								</p>
							</li>
						</ul>
					</div>
				</div>
				<!--{/if}-->
			</div>
		</div>
	</section>
	<!--{/if}-->

</div>

<!-- {/block} -->