<?php
/*
Name: 闪惠详情
Description: 
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.franchisee.cancel_apply();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-address-list ecjia-order-detail">
    <div class="franchisee-process-hint quickpay-hint"> 
    	{if $data.order_status_str eq 'unpaid'}
        <img class="quickpay-status-img" src="{$theme_url}images/user_center/wait_paid.png">
        {else}
        <img class="quickpay-status-img" src="{$theme_url}images/user_center/apply.png">
        {/if}
        <p class="quickpay-status-g {if $data.order_status_str eq 'unpaid'}unpaid{/if}">{$data.label_order_status}</p>
    </div>
    <div class="franchisee-info quickpay-detail">
        <ul>
            <p>
                <span class="ecjiaf-fl fran-info-color">订单编号</span>
                <span class="ecjiaf-fr">{$data.order_sn}</span>
            </p>
            {if $data.title}
            <p>
                <span class="ecjiaf-fl fran-info-color">优惠名称</span>
                <span class="ecjiaf-fr">{$data.title}</span>
            </p>
            {/if}
            <p>
                <span class="ecjiaf-fl fran-info-color">消费金额</span>
                <span class="ecjiaf-fr">{$data.formated_goods_amount}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">优惠金额</span>
                <span class="ecjiaf-fr">-{$data.formated_total_discount}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">实付金额</span>
                <span class="ecjiaf-fr">{$data.formated_order_amount}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">买单时间</span>
                <span class="ecjiaf-fr address-span">{$data.formated_add_time}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">支付方式</span>
                <span class="ecjiaf-fr address-span">{$data.pay_name}</span>
            </p>
        </ul>
    </div>
    
    <div class="order-ft-link">
    	{if $data.order_status_str eq 'unpaid' && $data.pay_code}
    	<a class="btn btn-small btn-hollow external" href='{url path="user/quickpay/pay" args="order_id={$data.order_id}"}'>去支付</a>
    	{/if}
        <a class="btn btn-small btn-hollow external" href="tel://{$data.service_phone}">联系卖家</a>
    </div>
</div>
<!-- {/block} -->
{/nocache}