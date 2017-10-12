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
	<form id="theForm" name="theForm" action="{url path='user/quickpay/done'}" method="post">
	    <div class="checkout">
	        <div class="quickpay_div before_two">
	            <li class="outher_d"><span>{t}订单金额 (元){/t}</span><input class="quick_money" name="order_money" placeholder="请询问店员后输入" value="{$data.goods_amount}"></li>
	            <li class="outher_d"><span>{t}不参与优惠金额 (元){/t}</span><input class="quick_money" name="drop_out_money" placeholder="请询问店员后输入" data-url="{url path='user/quickpay/flow_checkorder'}" value="{$data.exclude_amount}" /></li>
	        </div>
	        <input type="hidden" name="store_id" value="{$store_id}">
	        <div class="quickpay-content">
	        	{if $data}
	        	<div class="before_two ecjia-margin-t">
				   <label class="quickpay_div">
				       <li class="outher_d">
				            <span class="redio-height redio-mr-t">
								<label class="ecjia-check ecjiaf-fr" for="activity">
				               		<input type="radio" id="activity" name="activity_id" value="{$data.activity_id}" checked>
				               </label>
				           </span>
				           <span class="shanhui">买单</span>
				           <span class="slect-title">{$data.title}</span>
				           <span class="ecjiaf-fr ecjia-margin-r">-{$data.formated_discount}</span>
				       </li>
				   </label>
				</div>
				<div class="quickpay_div before_two ecjia-margin-t">
					{if $data.allow_use_bonus}
				    <li class="outher_d">
				    	{if $data.bonus_list|count gt 0}
				        <a class="nopjax" href='{url path="user/quickpay/bonus" args="store_id={$store_id}"}'>
				            <div class="icon-wallet"></div>
				            <span class="icon-name">使用红包</span>
				            <span class="fav_info">{count($data.bonus_list)}个可用</span>
				            <i class="iconfont icon-jiantou-right"></i>
				            <span class="other_width">{$data.bonus_list[$temp.bonus].type_name} {$data.bonus_list[$temp.bonus].bonus_money_formated}</span>
				       		<input type="hidden" name="bonus" value="{$temp.bonus}">
				        </a>
				        {else}
				        <a href='javascript:;' title="不可用">
							<span class="ecjia-color-999">使用红包</span>
							<span class="ecjia-tag ecjia-tag-disable">不可用</span>
						</a>
				        {/if}
				    </li>
				    {/if}
				    
				    {if $data.allow_use_integral}
				    <li class="outher_d">
				    	{if $data.order_max_integral eq 0}
						<a href='javascript:;' title="不可用">
							<span class="ecjia-color-999">使用积分</span>
							<span class="ecjia-tag ecjia-tag-disable">不可用</span>
						</a>
						{else}	
				        <a href='{url path="user/quickpay/integral" args="store_id={$store_id}"}'>
				            <div class="icon-wallet"></div>
				            <span class="icon-name">{t}使用积分{/t}</span>
				            {if $temp.integral gt 0}
				            <span class="fav_info">{$temp.integral}积分</span>
				            <input type="hidden" name="integral" value="{$temp.integral}" />
				            {else}
				            <span class="fav_info">{if $data.user_integral lt $data.order_max_integral }{$data.user_integral}{else}{$data.order_max_integral}{/if}积分可用</span>
				            {/if}
				            <i class="iconfont icon-jiantou-right"></i>
				        </a>
				        {/if}
				    </li>
				    {/if}
				    
					<li class="outher_d">
				        <span>实付金额</span>
				        <span class="ecjiaf-fr">￥{$total_fee}</span>
				    </li>
				</div>
				
				<div class="before_two ecjia-margin-t">
				    <ul class="ecjia-list">
				        <li>
				                        选择支付方式 <span class="ecjiaf-fr"></span>
				        </li>
				    </ul>
				    <ul class="ecjia-list list-short payment-list" data-url="{url path='user/quickpay/payment'}">
				    <!-- {foreach from=$data.payment_list item=list key=key} -->
				        <li class="ecjia-account-padding-input user_pay_way">
				            <span class="icon-name {$list.pay_code}" data-code="{$list.pay_code}">
				                <label class="ecjiaf-fr ecjia-check">
				                  	<input type="radio" name="payment_id" value="{$list.pay_id}" {if $temp.payment_id eq $list.pay_id}checked{else if $key eq 0}checked{/if}/>
				                </label>
				                {$list.pay_name}
				            </span>
				        </li>
				    <!-- {/foreach} -->
				    </ul>
				</div>  
				{/if}
	        </div>
	    </div>
	
	    <div class="pri ecjia-margin-t">
	        <a href="{url path='user/quickpay/explain'}"><p class="pri_info">优惠说明</p></a>
	    </div>

	    <div>
	    	<input class="btn btn-info" name="submit" type="submit" value="立即买单" style="display:none;"/>
			<a class="btn quickpay_done pjax">和店员已确认，立即买单</a>
	    </div>
	</form>
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
<div class="before_two ecjia-margin-t">
   <label class="quickpay_div">
       <li class="outher_d">
            <span class="redio-height redio-mr-t">
				<label class="ecjia-check ecjiaf-fr" for="activity">
               		<input type="radio" id="activity" name="activity_id" value="{$data.activity_id}" checked>
               </label>
           </span>
           <span class="shanhui">买单</span>
           <span class="slect-title">{$data.title}</span>
           <span class="ecjiaf-fr ecjia-margin-r">-{$data.formated_discount}</span>
       </li>
   </label>
</div>
<div class="quickpay_div before_two ecjia-margin-t">
	{if $data.allow_use_bonus}
    <li class="outher_d">
    	{if $data.bonus_list|count gt 0}
        <a class="nopjax" href='{url path="user/quickpay/bonus" args="store_id={$store_id}"}'>
            <div class="icon-wallet"></div>
            <span class="icon-name">使用红包</span>
            <span class="fav_info">{count($data.bonus_list)}个可用</span>
            <i class="iconfont icon-jiantou-right"></i>
            <input type="hidden" name="bonus" value="{$temp.bonus}">
        </a>
        {else}
        <a href='javascript:;' title="不可用">
			<span class="ecjia-color-999">使用红包</span>
			<span class="ecjia-tag ecjia-tag-disable">不可用</span>
		</a>
        {/if}
    </li>
    {/if}
    
    {if $data.allow_use_integral}
    <li class="outher_d">
    	{if $data.order_max_integral eq 0}
		<a href='javascript:;' title="不可用">
			<span class="ecjia-color-999">使用积分</span>
			<span class="ecjia-tag ecjia-tag-disable">不可用</span>
		</a>
		{else}	
        <a href='{url path="user/quickpay/integral" args="store_id={$store_id}"}'>
            <div class="icon-wallet"></div>
            <span class="icon-name">{t}使用积分{/t}</span>
            {if $temp.integral gt 0}
            <span class="ecjia-tag">{$temp.integral}积分</span>
            <input type="hidden" name="integral" value="{$temp.integral}" />
            {else}
            <span class="fav_info">{if $data.user_integral lt $data.order_max_integral }{$data.user_integral}{else}{$data.order_max_integral}{/if}积分可用</span>
            {/if}
            <i class="iconfont icon-jiantou-right"></i>
        </a>
        {/if}
    </li>
    {/if}
    
	<li class="outher_d">
        <span>实付金额</span>
        <span class="ecjiaf-fr">￥{$total_fee}</span>
    </li>
</div>

<div class="before_two ecjia-margin-t">
    <ul class="ecjia-list">
        <li>
                        选择支付方式 <span class="ecjiaf-fr"></span>
        </li>
    </ul>
    <ul class="ecjia-list list-short payment-list" data-url="{url path='user/quickpay/payment'}">
    <!-- {foreach from=$data.payment_list item=list key=key} -->
        <li class="ecjia-account-padding-input user_pay_way">
            <span class="icon-name {$list.pay_code}" data-code="{$list.pay_code}">
                <label class="ecjiaf-fr ecjia-check">
                  	<input type="radio" name="payment_id" value="{$list.pay_id}" {if $key eq 0}checked{/if}/>
                </label>
                {$list.pay_name}
            </span>
        </li>
    <!-- {/foreach} -->
    </ul>
</div>        
<!-- {/block} -->
{/nocache}