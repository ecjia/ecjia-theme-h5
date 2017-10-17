<?php
/*
Name: 确认支付
Description: 这是确认支付页面
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
		<div class="quickpay_div content">
			<div class="before_two">
				<div class="seller_info">
					<div class="seller_logo"><img src="{$shop_info.seller_logo}" /></div>
					<div class="seller_name">{$shop_info.seller_name}</div>
				</div>
				<div class="order_info">
					<div class="order_amount">￥190.00</div>
					<div class="order_sn">优惠买单订单号：22312312313213213</div>
				</div>
          	</div>
		</div>
        
        {if $data}
        <div class="quickpay_div content">
            <div class="before_two ecjia-margin-t">
			    <ul class="ecjia-list list-short payment-list" data-url="{url path='user/quickpay/payment'}">
			    	<!-- {foreach from=$data.payment_list item=list key=key} -->
			    	<li class="ecjia-account-padding-input user_pay_way">
			            <span class="icon-name {$list.pay_code}" data-code="{$list.pay_code}">
			                <label class="ecjiaf-fr ecjia-check">
			                  	<input type="radio" name="payment_id" value="{$list.pay_id}" {if $key eq 0}checked{/if}/>
			                </label>
			                {$list.pay_name}
			            </span>
			        </li>
			    	<!-- {/foreach} -->
			    </ul>
			</div>    
        </div>
        {/if}
        
      	<div class="ecjia-margin-t">
	    	<a class="btn external">确认支付</a>
	    	<div class="wei-xin-pay hide"></div>
	    </div>
    </div>
</div>
<!-- {/block} -->