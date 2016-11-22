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
	<form class="ecjia-form ecjia-account ecjia-margin-t" data-valid="novalid" name="ecjia-form user-profile-form" action="{url path='user/user_account/withdraw_account'}" method="post">
		<p class="account-top2 text-ty">{t}账户余额：{/t}{$sur_amount}</p>
		<div class="form-group form-group-text account-lr-fom">
			<label class="input">
				<span>{t}金额{/t}</span>
				<input placeholder="{t}建议提现100元以上的金额{/t}" name="amount" value="" datatype="n"/>
			</label>
		</div>
		<div class="account-top2">
		    <p1 class="text-ty">备注：（最长100个字）</p1>
    		<div class="form-group form-group-text ">
    			<label class="textarea">
    				<textarea  datatype="*" name="user_note"></textarea>
    			</label>
    		</div>
    		<input name="act" type="hidden" value="profile" />
    		<div class="text-center account-top2">
    			<input class="btn btn-info" name="submit" type="submit" value="{t}提现申请{/t}" />
    		</div>
    	</div>	
	</form>
</div>
<!-- {/block} -->
