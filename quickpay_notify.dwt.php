<?php
/*
Name: 闪惠积分
Description: 闪惠积分单页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
// 	ecjia.touch.enter_search();
</script>
<!-- {/block} -->
<!-- {block name="main-content"} -->
<div class="quickpay quickpay-flow-done">
    <div class="checkout quickpay-success">
        <div class="notify_head">
            <img class="quickpay-status-img" src="{$theme_url}images/user_center/apply.png">
            <div class="quickpay-color-green">支付成功</div>
        </div>
        
        <div class="notify_body">
            <div class="store_name"><b>{t}天天果园{/t}</b></div>
            <ul>
                <li><span>{t}订单编号{/t}</span><span class="ecjiaf-fr">{t}2234253453342{/t}</span></li>
                <li><span>{t}优惠名称{/t}</span><span class="ecjiaf-fr">{t}每满100减10元{/t}</span></li>
                <li><span>{t}消费金额{/t}</span><span class="ecjiaf-fr">{t}￥500.00{/t}</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="two-btn">
    <input type="hidden" name="address_id" value="1511">
    <input type="hidden" name="rec_id" value="14375,14374">
    <input class="btn btn-hollow-danger" name="bonus_clear" type="submit" value="查看订单">
    <input class="btn btn-info" name="bonus_update" type="submit" value="去购物 ">
</div>

<!-- {/block} -->
{/nocache}