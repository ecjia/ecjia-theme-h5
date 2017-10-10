<?php
/*
Name: 闪惠付款
Description: 这是闪惠付款页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.quickpay.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="quickpay">
    <div class="checkout">
        <div class="quickpay_div before_two">
            <li class="outher_d"><span>{t}订单金额 (元){/t}</span><input name="order-money" placeholder="请询问店员后输入"></li>
            <li class="outher_d"><span>{t}不参与优惠金额 (元){/t}</span><input name="drop-out-money" placeholder="请询问店员后输入" data-url="{url path='user/quickpay/checkout'}"></li>
        </div>
        <input type="hidden" name="store_id" value="{$store_id}">
        
        <div class="before_two ecjia-margin-t goods-describe">
           <label class="quickpay_div">
               <li class="outher_d">
                    <span class="redio-height redio-mr-t">
                       <label class="ecjia-check ecjiaf-fr"><input type="radio" id="11" name="11" value="91"></label>
                   </span>
                   <span class="shanhui">{t}闪惠{/t}</span>
                   <span class="slect-title">{t}每满100减8元{/t}</span>
                   <span class="ecjiaf-fr ecjia-margin-r">123</span>
               </li>
           </label>
        </div>
       
        <div class="quickpay_div before_two ecjia-margin-t goods-describe">
            <li class="outher_d">
                <a class="nopjax" href="{url path='user/quickpay/bouns'}">
            		<div class="icon-wallet"></div>
            		<span class="icon-name">{t}红包{/t}</span>
            		<span class="fav_info">{t}3个可用{/t}</span>
            		<i class="iconfont  icon-jiantou-right"></i>
            		<span class="other_width">{t}年末大促，优惠多多[¥2.00]{/t}</span>
            	</a>
            </li>
            <li class="outher_d">
                <a href="{url path='user/quickpay/integral'}">
            		<div class="icon-wallet"></div>
            		<span class="icon-name">{t}积分{/t}</span>
            		<span class="fav_info">{t}500积分可用{/t}</span>
            		<i class="iconfont  icon-jiantou-right"></i>
        			<span class="other_width">{t}500积分抵5元{/t}</span>
            	</a>
            </li>
             <li class="outher_d">
                <span>实付金额</span>
                <span class="ecjiaf-fr">¥0.00</span>
            </li>
        </div>
    
        <div class="before_two ecjia-margin-t">
            <ul class="ecjia-list">
                <li>
                                其它支付方式 <span class="ecjiaf-fr"></span>
                </li>
            </ul>
            <ul class="ecjia-list list-short payment-list">
            <!-- {foreach from=$payment_list item=list} -->
                <li class="ecjia-account-padding-input user_pay_way">
                    <span class="icon-name {$list.pay_code}" data-code="{$list.pay_code}">
                		<label for="{$list.pay_code}" class="ecjiaf-fr ecjia-check" value="{$list.pay_id}">
                		  <input type="radio" id="{$list.pay_code}" name="payment_id" value="{$list.pay_id}" checked="true">
                		</label>
                    	{$list.pay_name}
                    </span>
                </li>
            <!-- {/foreach} -->
            </ul>
        </div>
    </div>
    
    <div class="pri ecjia-margin-t">
        <a href="{url path='user/quickpay/explain'}"><p class="pri_info">优惠说明</p></a>
    </div>
    
    <div>
        <input class="btn btn-info nopjax" name="submit" type="submit" value="和店员已确认，立即买单">
    </div>
</div>
<!-- {/block} -->
{/nocache}