<?php
/*
Name: 账户充值模板
Description: 账户充值页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->
<!-- {block name="main-content"} -->

<form action="{url path='user/user_account/recharge_account'}" method="post">
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
                                    其它支付方式 <span class="ecjiaf-fr"><i class="iconfont icon-jiantou-bottom"></i></span>
            </li>
        </ul>
        <ul class="ecjia-list list-short payment-list">
        <!-- {foreach from=$payment item=list} -->
            <li class="ecjia-account-padding-input">
                <span class="icon-name {$list.pay_code}" data-code="{$list.pay_code}">
                <input type="radio" id="{$list.pay_code}" name="payment" value="{$list.pay_id}" checked="true">
                <label for="{$list.pay_code}" class="ecjiaf-fr one-select"></label>
                {$list.pay_name}</a></span>
            </li>
        <!-- {/foreach} -->
        </ul>
    	<input name="act" type="hidden" value="profile" />
    	<div class=" text-center account-top">
    		<input class="btn btn-recharge" name="submit" type="submit" value="{t}立即充值{/t}" />
    	</div>
    </div>	
</form>
<!-- {/block} -->
