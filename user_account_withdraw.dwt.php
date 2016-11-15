<?php
/*
Name: 账户提现模板
Description: 账户提现页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<div class="user-account-withdraw">
	<form class="ecjia-form user-account-withdraw" data-valid="novalid" name="ecjia-form user-profile-form" action="{url path='user/user_account/withdraw_account'}" method="post">
		<p class="account-withdraw">{t}余额：{/t}{$sur_amount}</p>
		<div class="form-group form-group-text">
			<label class="input">
				<span>{t}金额{/t}</span>
				<input type="number" placeholder="{t}金额{/t}" name="amount" value="" datatype="n"/>
			</label>
		</div>
		<div class="form-group form-group-text widthdraw">
			<label class="textarea">
				<textarea placeholder="{t}请输入备注信息，银行信息等{/t}" datatype="*" name="user_note"></textarea>
			</label>
		</div>
		<input name="act" type="hidden" value="profile" />
		<div class="text-center">
			<input class="btn btn-info" name="submit" type="submit" value="{t}立即提现{/t}" />
		</div>
	</form>
</div>
<!-- {/block} -->
