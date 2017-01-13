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
ecjia.touch.user_account.init();
ecjia.touch.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-account ecjia-form user-profile-form" name="useraccountForm" action="{url path='user/user_account/recharge_account'}" method="post">
    <div class="ecjia-form ecjia-account ecjia-flow-done ecjia-pay">
    	<p class="account-top text-ty ">{t}账户充值：{$user.name}{/t}</p>
    	<div class="form-group form-group-text account-lr-fom no-border">
    		<label class="input">
    			<span class="ecjiaf-fl">{t}金额{/t}</span>
    			<input placeholder="{t}建议充入100元以上金额{/t}" name="amount"/>
    		</label>
    	</div>
    	 {if $payment_list}
		    <ul class="ecjia-list ecjia-margin-t">
		        <li>
		                        其它支付方式 <span class="ecjiaf-fr"><i class="iconfont icon-jiantou-bottom"></i></span>
		        </li>
		    </ul>
		    <ul class="ecjia-list list-short payment-list">
		    <!-- {foreach from=$payment_list item=list} -->
		        <li class="ecjia-account-padding-input user_pay_way">
		            <span class="icon-name {$list.pay_code}" data-code="{$list.pay_code}">
		            	<input type="radio" id="{$list.pay_code}" name="payment" value="{$list.pay_id}" checked="true">
                		<label for="{$list.pay_code}" class="ecjiaf-fr one-select" value="10"></label>
		            	{$list.pay_name}
		            </span>
		        </li>
		    <!-- {/foreach} -->
		    </ul>
	    {/if}
    	<input name="act" type="hidden" value="profile" />
    	<div class=" text-center account-top btn-submit">
    		<input class="btn btn-recharge" name="submit" type="submit" value="{t}立即充值{/t}" />
    	</div>
    </div>	
</form>
<!-- {/block} -->