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
    <div class="ecjia-account ecjia-form">
    	<p class="account-top text-ty ">{t}账户充值：{$user.name}{/t}</p>
    	<div class="form-group form-group-text account-lr-fom no-border">
    		<label class="input">
    			<span class="ecjiaf-fl">{t}金额{/t}</span>
    			<input placeholder="{t}建议充入100元以上金额{/t}" name="amount" type="number"/>
    		</label>
    	</div>
    	<div class="form-group form-group-text ecjia-margin-t account-lr-fom ecjia-account-padding no-border">
    			<select name="payment_id">
    				<!--{foreach from=$payment item=pay}-->
    				<option value={$pay.pay_id}>{$pay.pay_name}</option>
    				<!-- {/foreach} -->
    			</select>
    	</div>
    	<input name="act" type="hidden" value="profile" />
    	<div class=" text-center account-top">
    		<input class="btn btn-recharge" name="submit" type="submit" value="{t}立即充值{/t}" />
    	</div>
    </div>	
</form>
<!-- {/block} -->
