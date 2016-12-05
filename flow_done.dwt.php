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
        <li>应付金额：<span class="ecjiaf-fr">{if $data.order_info.formatted_order_amount}{$data.order_info.formatted_order_amount}{else}{$data.order_info.goods_price}{/if}</span></li>
        <li>支付方式：<span class="ecjiaf-fr flow-msg">支付方式</span></li>
    </ul>
    <div class="ecjia-margin-t ecjia-margin-b flow-msg">支付成功</div>
    <ul class="ecjia-list ecjia-margin-t">
        <li>
            其他支付方式 <span class="ecjiaf-fr"><i class="iconfont icon-jiantou-bottom"></i></span>
        </li>
    </ul>
    <ul class="ecjia-list list-short">
        <li>
            <span class="icon-name">支付宝</span>
        </li>
        <li>
            <span class="icon-name">余额支付</span>
        </li>
        <li>
            <span class="icon-name">**支付</span>
        </li>
    </ul>
    <div class="ecjia-margin-t ecjia-margin-b two-btn">
        <a class="btn" href="#">去购物</a>
        <a class="btn" href="#">查看订单</a>
    </div>

    <div class="ecjia-margin-t ecjia-margin-b">
        <a class="btn" href="#">确认支付</a>
    </div>
</div>


<!-- {/block} -->
