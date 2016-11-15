<?php 
/*
Name: 拍卖模板
Description: 这是拍卖页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->

<script type="text/javascript">ecjia.touch.goods.init();</script>
<script type="text/javascript" src="{$theme_url}js/lefttime.js"></script>
<script type="text/javascript">
	TouchSlide({ 
	slideCell:"#picScroll",
	titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
	autoPage:"true", //自动分页
	pnLoop:"false", // 前后按钮不循环
	switchLoad:"_src" //切换加载，真实图片路径为"_src" 
	});
</script>
<script type="text/javascript">
	var gmt_end_time = "{$auction.gmt_end_time|default:0}";
	{foreach from=$lang.goods_js item=item key=key}
		var {$key} = "{$item}";
		var now_time = {$now_time};
	{/foreach}
	onload = function(){
		try{
			onload_leftTime(now_time);
		}
		catch (e){}
	}
</script>
<!-- {/block} -->

<!-- {block name="ecjia"} -->
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
				<a href="{$auction_goods.goods_img}">
					<img src="{$auction_goods.goods_img}" alt="{$auction_goods.goods_name}" />
				</a>
			</li>
			<!--{if $pictures}-->
			<!-- {foreach from=$pictures item=picture name=no}-->
			<!-- {if $smarty.foreach.no.iteration >
			1}  -->
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
<div class="goods-info ect-padding-tb">
	<!--商品描述-->
	<section class="ect-margin-tb ect-margin-lr goods-title">
		<h4 class="title pull-left">
			{$auction_goods.goods_name}{if $auction.product_id > 0}&nbsp;[{$products_info}]{/if}
		</h4>
		<span class="pull-right text-center  ect-padding-lr">{$lang.btn_collect}</span>
	</section>
	<section class="ect-margin-tb ect-margin-lr ">
		{$lang.au_current_price}：{$auction.formated_current_price}
		<br/>
		{t}起止时间{/t}：{$auction.start_time} -- {$auction.end_time}
		<br>
		{$lang.au_start_price}：{$auction.formated_start_price}
		<br>
		{$lang.au_amplitude}：{$auction.formated_amplitude}
		<br>
		<!-- {if $auction.end_price gt 0} -->
		{$lang.au_end_price}：{$auction.formated_end_price}
		<br>
		<!-- {/if} -->
		<!-- {if $auction.deposit gt 0} -->
		{$lang.au_deposit}：{$auction.formated_deposit}
		<br>
		<!-- {/if} -->
	</p>
</section>
<!-- {if $auction.status_no eq 0} 未开始 -->
{$lang.au_pre_start}
<!-- {elseif $auction.status_no eq 1} 进行中 -->
<section class="ect-margin-tb ect-margin-bottom0 ect-padding-tb goods-promotion ect-padding-lr ">
	<h5> <b>{$lang.au_under_way}</b></h5>
	<h5>
		<span id="leftTime">{$lang.please_waiting}</span>
	</h5>
</section>
<form name="theForm" action="{url path='auction/bid'}" method="post">
	<section class="ect-padding-lr ect-padding-tb goods-option">
		<div class="goods-num">
			<span class="pull-left">{$lang.au_i_want_bid}：</span>
			<div class="input-group pull-left wrap">
				<input class="form-contro form-num" type="text" id="price" name="price"/>
			</div>
			<input class="bnt_sub" id="bid" name="bid" type="submit" value="{$lang.button_bid}" style="vertical-align:middle;" />
			<input name="id" type="hidden" value="{$auction.act_id}" />
		</div>
	</section>
</form>
<!-- {else} 已结束 -->
<form name="theForm" action="{url path='auction/buy'}" method="post">
	<!-- {if $auction.is_winner} -->
	<span class="f_red">{$lang.au_is_winner}</span>
	<br />
	<input class="bnt_sub" name="buy" type="submit" value="{$lang.button_buy}" />
	<input name="id" type="hidden" value="{$auction.act_id}" />
	<!-- {else} -->
	{$lang.au_finished}
	<!-- {/if} -->
</form>
<!-- {/if} -->
<section class="goods-more-a">
	<a class="ect-padding-lr ect-padding-tb" href="{url path='Auction/record'  args="id={$auction.act_id}"}">
		<span class="Text">{$lang.activity_intro}</span> 
		<i class="pull-right fa fa-chevron-right"></i>
	</a>
	<a class="ect-padding-lr ect-padding-tb" href="{url path='Auction/record'  args="id={$auction.act_id}"}">
		<span class="Text">{$lang.bid_record}</span> 
		<i class="pull-right fa fa-chevron-right"></i>
	</a>
</section>
</div>
<div class="goods-related ect-padding-lr ect-padding-tb">{$auction.act_desc|escape:html|nl2br}</div>

<!-- {/block} -->