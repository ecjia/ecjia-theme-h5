<?php
/*
Name: 优惠说明
Description: 这是优惠说明页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
// 	ecjia.touch.user.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="quickpay">
    <div class="checkout">
         <div class="quickpay_div">
            <li class="explain_title"><span><b>{t}买单说明{/t}</b></span></li>
            <li class="quickpay_list">
                <p>{t}1、优惠买单仅限于到店消费后使用，请勿提前支付；{/t}</p>
                <p>{t}2、请在输入买单金额前与商家确认门店信息和消费金额；{/t}</p>
                <p>{t}3、遇节假日能否享受优惠，请详细咨询商家；{/t}</p>
                <p>{t}4、请咨询商家能否与店内其他优惠同享；{/t}</p>
                <p>{t}5、如需发票，请您在消费时向商家咨询；{/t}</p>
            </li>
        </div>
        
        <div class="quickpay_div">
            <li class="explain_title"><span><b>{t}买单优惠{/t}</b></span></li>
            <div class="before_two">
                <li class="outher_d explain_d">
                    <div class="explain_info">
                        <p class="explain_info_top"><span class="explain_name">{t}9.9折{/t}</span><span class="explain_status">{t}进行中{/t}</span></p>
                        <p class="explain_info_top">{t}使用时间：周一至周日全天可用{/t}</p>
                        <p class="explain_info_top">{t}有效日期： 2017-06-01至2017-09-30{/t}</p>
                    </div>
                </li>
                <li class="outher_d explain_d">
                    <div class="explain_info">
                        <p class="explain_info_top"><span class="explain_name">{t}每满100减10元{/t}</span><span class="explain_status">{t}进行中{/t}</span></p>
                        <p class="explain_info_top">{t}周一至周五全天可用{/t}</p>
                        <p class="explain_info_top">{t}不可用时间：2017-06-05,2017-06-30,2017-08-12{/t}</p>
                        <p class="explain_info_top">{t}有效日期： 2017-06-01至2017-09-30{/t}</p>
                    </div>
                </li>
                 <li class="outher_d explain_d">
                    <div class="explain_info">
                        <p class="explain_info_top"><span class="explain_name">{t}满100减5元{/t}</span><span class="explain_status">{t}进行中{/t}</span></p>
                        <p class="explain_info_top">{t}使用时间：周一至周五 09:00～12:00 14:00～20:00{/t}</p>
                        <p class="explain_info_top">{t}不可用时间：2017-06-05,2017-06-30,2017-08-12{/t}</p>
                        <p class="explain_info_top">{t}有效日期： 2017-06-01至2017-09-30{/t}</p>
                    </div>
                </li>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->