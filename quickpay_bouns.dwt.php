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
ecjia.touch.user.init();
</script>
<!-- {/block} -->
<!-- {block name="main-content"} -->
<div class="quickpay">
    <div class="checkout">
        <div class="before_two">
           <label class="quickpay_div">
               <li class="outher_d">
                   <span class="redio-height">
                       <label class="ecjia-check ecjiaf-fl"><input name="bouns" type="radio" value="1"></label>
                   </span>
                   <span class="ecjia-margin-l">{t}年末大促，优惠多多{/t}</span>
                   <span class="ecjiaf-fr">2.00</span>
               </li>
            </label>
             <label class="quickpay_div">
               <li class="outher_d">
                   <span class="redio-height">
                       <label class="ecjia-check ecjiaf-fl"><input name="bouns" type="radio" value="1"></label>
                   </span>
                   <span class="ecjia-margin-l">{t}年末大促，优惠多多{/t}</span>
                   <span class="ecjiaf-fr">2.00</span>
               </li>
            </label>
             <label class="quickpay_div">
               <li class="outher_d">
                   <span class="redio-height">
                       <label class="ecjia-check ecjiaf-fl"><input name="bouns" type="radio" value="1"></label>
                   </span>
                   <span class="ecjia-margin-l">{t}年末大促，优惠多多{/t}</span>
                   <span class="ecjiaf-fr">2.00</span>
               </li>
            </label>
        </div>
    </div>
    
     <div class="save_discard">
        <input class="btn mag-t1" type="submit" value="保存">
        <input class="btn btn-hollow-danger mag-t1" type="submit" value="清空">
    </div>
</div>

<!-- {/block} -->
{/nocache}