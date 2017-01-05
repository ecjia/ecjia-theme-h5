<?php
/*
Name: 提交订单结算模板
Description: 提交订单结算页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.goods.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="ecjia-flow-done">
    <div class="flow-success">
        <p>恭喜您，订单已经生成~</p>
    </div>
    <ul class="ecjia-list ecjia-margin-t">
        <li>应付金额：<span class="ecjiaf-fr">{if $data.formated_order_amount}{$data.formated_order_amount}{else}{$data.order_amount}{/if}</span></li>
        <li>支付方式：<span class="ecjiaf-fr flow-msg">{$data.pay_name}</span></li>
    </ul>
    <div class="ecjia-margin-t ecjia-margin-b flow-msg">{$pay_error}</div>
    {if $payment_list}
    <ul class="ecjia-list ecjia-margin-t">
        <li>
                        其它支付方式 <span class="ecjiaf-fr"><i class="iconfont icon-jiantou-bottom"></i></span>
        </li>
    </ul>
    <ul class="ecjia-list list-short payment-list">
    <!-- {foreach from=$payment_list item=list} -->
        <li>
            <span class="icon-name" data-code="{$list.pay_code}"><a href='{url path="cart/flow/done" args="order_id={$data.order_id}&pay_id={$list.pay_id}&pay_code={$list.pay_code}"}'>{$list.pay_name}</a></span>
        </li>
    <!-- {/foreach} -->
    </ul>
    {/if}

    {if $pay_online}
    <div class="ecjia-margin-t ecjia-margin-b">
        <a class="btn" href="{$pay_online}">确认支付</a>
    </div>
    {/if}
    
    <div class="ecjia-margin-t ecjia-margin-b two-btn">
        <a class="btn" href='{url path="touch/index/init"}'>去购物</a>
        <a class="btn" href='{url path="user/user_order/order_detail" args="order_id={$data.order_id}"}'>查看订单</a>
    </div>
</div>
<!-- {/block} -->