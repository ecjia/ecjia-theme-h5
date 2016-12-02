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
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<div class="ecjia-form">
	<form  class="ecjia-form ecjia-account" data-valid="novalid" name="ecjia-form user-profile-form" action="{url path='user/user_account/recharge_account'}" method="post">
		<p class="account-top text-ty">{t}账户充值：{$user.name}{/t}</p>
		<div class="form-group form-group-text account-lr-fom">
			<label class="input">
				<span class="ecjiaf-fl">{t}金额{/t}</span>
				<input placeholder="{t}建议充入100元以上金额{/t}" name="amount" value="" datatype="n"/>
			</label>
		</div>

		<div class="form-group form-group-text ecjia-margin-t account-lr-fom ecjia-account-padding">
				<select name="payment_id">
					<!--{foreach from=$payment item=pay}-->
					<option value='{$payment.pay_id}'>{$pay.pay_name}</option>
 					<!-- {/foreach} -->
				</select>
		</div>

		<input name="act" type="hidden" value="profile" />
		<div class=" text-center account-top">
			<input class="btn btn-recharge" name="submit" type="submit" value="{t}立即充值{/t}" />
		</div>
	</form>
</div>
<!-- {/block} -->
