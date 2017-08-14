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
// 	ecjia.touch.user.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="quickpay">
    <div class="checkout">
        <div class="quickpay_div before_two">
            <li class="outher_d"><span>{t}订单金额 (元){/t}</span><input placeholder="请询问店员后输入"></li>
            <li class="outher_d"><span>{t}不参与优惠金额 (元){/t}</span><input placeholder="请询问店员后输入"></li>
        </div>
        
       <label class="quickpay_div">
           <li class="outher_d">
               <span class="shanhui">{t}闪惠{/t}</span>
               <span class="slect-title">{t}每满100减8元{/t}</span>
               <span class="ecjiaf-fr redio-height">
                   <span class="quickpay_info">123</span>
                   <label class="ecjia-check"><input type="radio" id="pay_balance" name="payment" value="9"></label>
               </span>
           </li>
       </label>
       
        <div class="quickpay_div before_two">
            <li class="outher_d">
                <a href="{url path='user/account/init'}">
            		<div class="icon-wallet"></div>
            		<span class="icon-name">{t}红包{/t}</span>
            		<span class="fav_info">{t}3个可用{/t}</span>
            		<i class="iconfont  icon-jiantou-right"></i>
            		<span class="other_width">{t}年末大促，优惠多多[¥2.00]{/t}</span>
            	</a>
            </li>
            <li class="outher_d">
                <a href="{url path='user/account/init'}">
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
    
        <div class="quickpay_div">
            <ul class="ecjia-list ecjia-margin-t">
                <li>
                                其它支付方式 <span class="ecjiaf-fr"></span>
                </li>
            </ul>
            <ul class="ecjia-list list-short payment-list">
            <!-- {foreach from=$payment_list item=list} -->
                <li class="ecjia-account-padding-input user_pay_way">
                    <span class="icon-name {$list.pay_code}" data-code="{$list.pay_code}">
                		<label for="{$list.pay_code}" class="ecjiaf-fr ecjia-check" value="10">
                		<input type="radio" id="{$list.pay_code}" name="payment_id" value="{$list.pay_id}" checked="true">
                		</label>
                    	{$list.pay_name}
                    </span>
                </li>
                <li class="ecjia-account-padding-input user_pay_way">
                    <span class="icon-name {$list.pay_code}" data-code="{$list.pay_code}">
                		<label for="{$list.pay_code}" class="ecjiaf-fr ecjia-check" value="10">
                		<input type="radio" id="{$list.pay_code}" name="payment_id" value="{$list.pay_id}" checked="true">
                		</label>
                    	{$list.pay_name}
                    </span>
                </li>
            <!-- {/foreach} -->
            </ul>
        </div>
    </div>
    
    <div class="pri">
        <a href="{url path='user/quickpay/explain'}"><p class="pri_info">优惠说明</p></a>
    </div>
    
    <div>
        <input class="btn btn-info nopjax" name="submit" type="submit" value="和店员已确认，立即买单">
    </div>
</div>
<!-- {/block} -->