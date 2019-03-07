<?php
/*
Name: 销售个人奖励详情
Description: 销售个人奖励详情
Libraries: model_bar
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->
<!-- {block name="main-content"} -->
<div class="ecjia-reward-detail">
	<div class="reward-detail-top">
		{if $data.status eq 'await_seprate'}
		<div class="status"><img src="{$theme_url}images/affiliate/wait_affiliate.png" /></div>
		{else if $data.status eq 'seprated'}
		<div class="status"><img src="{$theme_url}images/affiliate/affiliated.png" /></div>
		{else if $data.status eq 'cancel_seprate'}
		<div class="status"><img src="{$theme_url}images/affiliate/cancel_seprate.png" /></div>
		{/if}
		<p>{$data.label_status}</p>
		<p class="price">{$data.formatted_affiliated_amount}</p>
		<div class="detail-list">
			<p><span class="ecjiaf-fl">订单编号</span><span class="ecjiaf-fr">{$data.order_sn}</span></p>
			<p><span class="ecjiaf-fl">购买人</span><span class="ecjiaf-fr">{$data.buyer}</span></p>
			<p><span class="ecjiaf-fl">下单时间</span><span class="ecjiaf-fr">{$data.formatted_order_time}</span></p>
		</div>
	</div>

	<div class="reward-detail-bottom">
		<div class="bottom-hd"><img src="{$theme_url}images/icon/store_green.png" />&nbsp;{$data.store_name}</div>
		
		{foreach from=$data.goods_list item=val}
		<ul class="goods-item">
			<li class="goods-img">
				<img class="ecjiaf-fl" src="{$val.img.thumb}" />
			</li>
			<div class="goods-right">
				<div class="goods-name">{$val.goods_name}</div>
				<p class="block">x{$val.goods_number}</p>
				<p class="block"><span class="ecjiaf-fr ecjia-color-red">{$val.formatted_goods_price}</span></p>
			</div>
		</ul>
		{/foreach}

		<div class="detail-list">
			<p><span class="ecjiaf-fl">订单合计</span><span class="ecjiaf-fr">{$data.formatted_total_amount}</span></p>
			<p><span class="ecjiaf-fl">佣金比例</span><span class="ecjiaf-fr">{$data.formatted_affiliated_amount}</span></p>
            <p><span class="ecjiaf-fl">获得分成</span><span class="ecjiaf-fr ecjia-color-red">{$data.formatted_affiliated_amount}</span></p>
		</div>
	</div>
</div>
<!-- {/block} -->
{nocache}