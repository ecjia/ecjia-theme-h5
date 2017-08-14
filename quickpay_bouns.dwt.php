<?php
/*
Name: 获取全部订单模板
Description: 获取全部订单页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.enter_search();
</script>
<!-- {/block} -->
<!-- {block name="main-content"} -->
<div class="quickpay">
    <div class="checkout">
        <div class="before_two">
           <label class="quickpay_div">
           <li class="outher_d">
               <span class="redio-height">
                   <label class="ecjia-check ecjiaf-fl"><input type="radio" id="pay_balance" name="payment" value="9"></label>
               </span>
               <span class="ecjia-margin-l">{t}年末大促，优惠多多{/t}</span>
               <span class="ecjiaf-fr">2.00</span>
           </li>
           <li class="outher_d">
               <span class="redio-height">
                   <label class="ecjia-check ecjiaf-fl"><input type="radio" id="pay_balance" name="payment" value="9"></label>
               </span>
               <span class="ecjia-margin-l">{t}年末大促，优惠多多{/t}</span>
               <span class="ecjiaf-fr">2.00</span>
           </li>
           <li class="outher_d">
               <span class="redio-height">
                   <label class="ecjia-check ecjiaf-fl"><input type="radio" id="pay_balance" name="payment" value="9"></label>
               </span>
               <span class="ecjia-margin-l">{t}年末大促，优惠多多{/t}</span>
               <span class="ecjiaf-fr">2.00</span>
           </li>
       </label>
        </div>
    </div>
</div>

<!-- {/block} -->
{/nocache}