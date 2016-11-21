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

<div class="user-account-detail">
	<form  class="ecjia-form ecjia-account" data-valid="novalid" name="ecjia-form user-profile-form" action="{url path='user/user_account/recharge_account'}" method="post">
		 <p>{t}账户充值：TEST测试{/t}</p>
		<div class="form-group form-group-text">
			<label class="input">
				<span class="ecjiaf-fl">{t}金额{/t}</span>
				<input type="number" placeholder="{t}建议充入100元以上金额{/t}" name="amount" value="" datatype="n"/>
			</label>
		</div>

		<div class="form-group form-group-text ecjia-margin-t">
			<label>
				<span class="ecjia-margin-r">{t}充值方式{/t}</span>
				<select name="payment_id">
					<!--{foreach from=$payment_list item=payment}-->
					<option value='{$payment.pay_id}'>{$payment.pay_name}</option>
 					<!-- {/foreach} -->
				</select>
			</label>
		</div>

		<input name="act" type="hidden" value="profile" />
		<div class=" text-center ecjia-margin-t3">
			<input class="btn btn-recharge" name="submit" type="submit" value="{t}立即充值{/t}" />
		</div>
	</form>
</div>
<!-- {/block} -->
