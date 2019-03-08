<?php
/*
Name: 订单分成
Description: 订单分成列表
Libraries: model_bar
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->
<!-- {block name="main-content"} -->
<div class="ecjia-reward-list">
	<div class="reward-head">
		<a class="fnUrlReplace" href='{url path="user/order/affiliate"}'><div class="reward-head-item {if !$status}active{/if}"><span>{t domain="h5"}全部{/t}</span></div></a>
		<a class="fnUrlReplace" href='{url path="user/order/affiliate"}&status=await_separate'><div class="reward-head-item {if $status eq 'await_separate'}active{/if}"><span>{t domain="h5"}待分成{/t}</span></div></a>
		<a class="fnUrlReplace" href='{url path="user/order/affiliate"}&status=separated'><div class="reward-head-item {if $status eq 'separated'}active{/if}"><span>{t domain="h5"}已分成{/t}</span></div></a>
	</div>
	<ul class="reward-list" id="reward-list" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/order/ajax_order_affiliate'}{if $smarty.get.status}&status={$smarty.get.status}{/if}">
	</ul>
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
<!-- {if $list} -->
<!-- {foreach from=$list item=val} -->
<li class="reward-item ecjia-margin-t">
	<div class="reward-hd">
		{t domain="h5"}订单编号{/t}&nbsp;{$val.formatted_order_time}
		<span class="ecjiaf-fr ecjia-color-red">{$val.label_status}</span>
	</div>
	<div class="flow-goods-list">
		<a class="ecjiaf-db" href='{url path="user/order/affiliate_detail" args="id={$val.log_id}"}'>
			<!-- {foreach from=$val.goods_list item=v} -->
			<ul class="goods-item">
				<li class="goods-img">
					<img class="ecjiaf-fl" src="{$v.img.thumb}" />
				</li>
				<div class="goods-right">
					<div class="goods-name">{$v.goods_name}</div>
					<p class="block">{$v.formatted_goods_price}</p>
				</div>
			</ul>
			<!-- {/foreach} -->
		</a>
	</div>
	<div class="reward-ft">
		<em class="ecjiaf-fr ecjia-color-red">{$val.formatted_affiliated_amount}</em>
	</div>
</li>
<!-- {/foreach} -->
<!-- {else} -->
<div class="ecjia-mod search-no-pro ecjia-margin-t ecjia-margin-b">
	<div class="ecjia-nolist">
		<p><img src="{$theme_url}images/wallet/null280.png"></p>
		{t domain="h5"}暂无分成{/t}
	</div>
</div>
<!-- {/if} -->
<!-- {/block} -->
{nocache}