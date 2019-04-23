<?php
/*
Name: 闪惠付款
Description: 这是闪惠付款页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.quickpay.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="quickpay">
	{if $store_info.shop_closed eq 1}
	<div class="shop_closed_notice">{t domain="h5"}商家打烊中，优惠买单尚未开始~{/t}</div>
	{/if}
	<form name="quickpayForm" action="{url path='quickpay/flow/done'}" method="post" data-url="{url path='quickpay/flow/flow_checkorder'}">
	    <div class="checkout">
	        <div class="quickpay_div before_two">
	            <li class="outher_d amount_li">
	            	<span>{t domain="h5"}消费金额 (元){/t}</span>
	            	<input class="quick_money" type="number" name="order_money" step="0.01" placeholder='{t domain="h5"}请询问店员后输入{/t}' value="{$data.goods_amount}" {if $store_info.shop_closed eq 1}readonly{/if}>
	            </li>
	            
	            <li class="outher_d exclude_amount_li">
		            <label class="ecjia-checkbox {if $show_exclude_amount eq 1}ecjia-checkbox-checked{/if}">
		            	<input type="checkbox" name="show_exclude_amount" value="1" {if $show_exclude_amount eq 1}checked{/if}>
		            </label>
	            	<span>{t domain="h5"}输入不参与优惠金额 (元){/t}</span>
	            </li>
	            
	            <li class="outher_d amount_li li" {if $show_exclude_amount eq 1}style="display:block;"{/if}>
	            	<span>{t domain="h5"}不参与优惠金额 (元){/t}</span>
	            	<input class="quick_money" type="number" name="drop_out_money" step="0.01" placeholder='{t domain="h5"}请询问店员后输入{/t}' value="{$data.exclude_amount}">
	            </li>
	        </div>
	        <input type="hidden" name="store_id" value="{$store_id}">
				
			<div class="quickpay-content before_two">
				{if $activity_list}
				<div class="item_list">
					<div class="quickpay_div content">
				   		<!-- {foreach from=$activity_list item=val} -->
				       	<li class="outher_d">
				        	<span class="radio-height radio-mr-t">
								<label class="ecjia-check ecjiaf-fr" for="activity_{$val.activity_id}">
				       				<input type="radio" id="activity_{$val.activity_id}" name="activity_id" value="{$val.activity_id}" {if $val.is_allow_use eq 0}disabled{else if $val.is_favorable eq 1}checked{/if} />
				               	</label>
				           	</span>
				           	<span class="shanhui">{t domain="h5"}买单{/t}</span>
				           	<span class="slect-title">{$val.title}</span>
				           	{if $is_available neq 1 && $val.is_allow_use eq 0}
				           	<span class="ecjiaf-fr ecjia-margin-r ecjia-color-aaa">{t domain="h5"}不可用{/t}</span>
				           	{else}
				           	<span class="ecjiaf-fr ecjia-margin-r">-{$val.formated_discount}</span>
				           	{/if}
				       	</li>
				       	<!-- {/foreach} -->
				   	</div>
			   	</div>
				{/if}
				
				
				{if $activity.bonus_list|count gt 0 || $activity.allow_use_integral}
				<div class="item_list ecjia-margin-t">
					<div class="quickpay_div content">
						{if $activity.allow_use_bonus && $activity.bonus_list|count gt 0}
					    <li class="outher_d">
					        <a class="nopjax" href='{url path="user/quickpay/bonus" args="store_id={$store_id}"}'>
					            <div class="icon-wallet"></div>
					            <span class="icon-name">{t domain="h5"}使用红包{/t}</span>
					            <span class="fav_info">{t domain="h5" 1={count($activity.bonus_list)}}个可用{/t}</span>
					            <i class="iconfont icon-jiantou-right"></i>
					            <input type="hidden" name="bonus" value="{$temp.bonus}">
					            {if $temp.bonus}
	                            <span class="other_width">{$activity['bonus_list'][$temp.bonus]['type_name']} [{$activity['bonus_list'][$temp.bonus]['bonus_money_formated']}] </span>
	                            {/if}
					        </a>
					    </li>
					    {/if}
					    
					    {if $activity.allow_use_integral && $activity.order_max_integral neq 0}
					    <li class="outher_d">
					        <a href='{url path="user/quickpay/integral" args="store_id={$store_id}"}'>
					            <div class="icon-wallet"></div>
					            <span class="icon-name">{t domain="h5" 1={$integral_name}}使用%1{/t}</span>
					            {if $temp.integral gt 0}
					            <span class="fav_info">{$temp.integral}{$integral_name}</span>
					            <input type="hidden" name="integral" value="{$temp.integral}" />
					            {else}
					            <span class="fav_info">{if $data.user_integral lt $activity.order_max_integral }{$data.user_integral}{else}{$activity.order_max_integral}{/if}{$integral_name}{t domain="h5"}可用{/t}</span>
					            {/if}
					            <i class="iconfont icon-jiantou-right"></i>
						        {if $temp.integral && $temp.integral_bonus}
	                            <span class="other_width">{$temp.integral}{$integral_name}{t domain="h5" 1={$temp.integral_bonus}}抵%1元{/t}</span>
	                            {/if}
					        </a>
					    </li>
					    {/if}
					</div>
				</div>
				{/if}
				
				<div class="quickpay_div ecjia-margin-t background_fff item_list">
					<li class="outher_d">
				        <span>{t domain="h5"}实付金额{/t}</span>
				        <span class="ecjiaf-fr total_fee">{if $total_fee}￥{$total_fee}{else}￥0.00{/if}</span>
				    </li>
			    </div>
			</div>
        </div>
	
	    <div class="pri ecjia-margin-t">
	        <a href='{url path="user/quickpay/explain" args="store_id={$store_id}"}'><p class="pri_info">{t domain="h5"}优惠说明{/t}</p></a>
	    </div>

	    <div>
	    	<input class="btn quickpay_done external" type="submit" value='{t domain="h5"}确认买单{/t}' {if $data.goods_amount eq '' || !$data.goods_amount}disabled{/if}/>
	    	<div class="help-block">{t domain="h5"}优惠买单仅限于到店支付，请确认金额后提交。{/t}</div>
	    </div>
	</form>
</div>
<!-- {/block} -->

{/nocache}