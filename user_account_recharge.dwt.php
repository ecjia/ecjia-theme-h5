<?php
/*
Name: 账户充值模板
Description: 账户充值页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript" >
ecjia.touch.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-account ecjia-form user-profile-form" action="{url path='user/user_account/recharge_account'}" method="post">
    <div class="ecjia-form ecjia-account ecjia-flow-done ecjia-pay">
    	<p class="account-top text-ty ">{t}账户充值：{$user.name}{/t}</p>
    	<div class="form-group form-group-text account-lr-fom no-border">
    		<label class="input">
    			<span class="ecjiaf-fl">{t}金额{/t}</span>
    			<input placeholder="{t}建议充入100元以上金额{/t}" name="amount"/>
    		</label>
    	</div>
    	<ul class="ecjia-list ecjia-margin-t">
            <li class="list-font-size">
                                    其它支付方式
            </li>
        </ul>
        <ul class="ecjia-list list-short payment-list">
            <li class="ecjia-account-padding-input">
                <span class="icon-name {$pay_alipay.pay_code} fmtmargin" data-code="{$pay_alipay.pay_code}">
                <label for="{$pay_alipay.pay_code}" class="ecjiaf-fr ecjia-check" value="10"> 
                <input type="radio" id="{$pay_alipay.pay_code}" name="payment" value="{$pay_alipay.pay_id}" checked="true"></label>
                {$pay_alipay.pay_name}</a></span>
            </li>
            <li class="ecjia-account-padding-input">
                <span class="icon-name {$pay_wxpay.pay_code} fmtmargin" data-code="{$pay_wxpay.pay_code}">
                <label for="{$pay_wxpay.pay_code}" class="ecjiaf-fr ecjia-check" value="10">      
                <input type="radio" id="{$pay_wxpay.pay_code}" name="payment" value="{$pay_wxpay.pay_id}"></label>
                {$pay_wxpay.pay_name}</a></span>
            </li>
        </ul>
    	<input name="act" type="hidden" value="profile" />
    	<div class=" text-center account-top">
    		<input class="btn btn-recharge" name="submit" type="submit" value="{t}立即充值{/t}" />
    	</div>
    </div>	
</form>
<!-- {/block} -->