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
<div class="ecjia-address-list">
    <div class="franchisee-process-hint quickpay-hint"> 
        <img class="quickpay-status-img" src="{$theme_url}images/user_center/apply.png">
        <p class="quickpay-status-g">买单成功</p>
    </div>
    <div class="franchisee-info quickpay-detail">
        <ul>
            <p>
                <span class="ecjiaf-fl fran-info-color">订单编号</span>
                <span class="ecjiaf-fr">2234253453342</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">优惠名称</span>
                <span class="ecjiaf-fr">每满100减10元</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">消费金额</span>
                <span class="ecjiaf-fr">￥500.00</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">优惠金额</span>
                <span class="ecjiaf-fr">-￥10.00</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">实付金额</span>
                <span class="ecjiaf-fr">￥490.00</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">买单时间</span>
                <span class="ecjiaf-fr address-span">2017-01-12 22:50</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">支付方式</span>
                <span class="ecjiaf-fr address-span">支付宝</span>
            </p>
        </ul>
    </div>
    
    <div class="order-ft-link">
        <a class="btn btn-small btn-hollow external" href="tel://15100010102">联系卖家</a>
    </div>
</div>

<!-- {/block} -->
{/nocache}