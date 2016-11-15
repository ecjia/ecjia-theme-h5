<?php
/*
Name: 账户充值模板
Description: 账户充值页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="con"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<div class="user-account-detail">
	<form  class="ecjia-form user-account-recharge" data-valid="novalid" name="ecjia-form user-profile-form" action="{url path='user/user_account/recharge_account'}" method="post">
		<div class="form-group form-group-text">
			<label class="input">
				<span class="ecjiaf-fl">{t}充值金额{/t}</span>
				<input type="number" placeholder="{t}请输入充值金额{/t}" name="amount" value="" datatype="n"/>
			</label>
		</div>

		<p>{t}温馨提醒：充值金额最好在1元到1万元之间{/t}</p>

		<div class="form-group form-group-text">
			<label>
				<span class="ecjia-margin-r">{t}充值方式{/t}</span>
				<select name="payment_id">
					<!--{foreach from=$payment_list item=payment}-->
					<option value='{$payment.pay_id}'>{$payment.pay_name}</option>
 					<!-- {/foreach} -->
				</select>
			</label>
		</div>

		<div class="form-group form-group-text textarea-recharge">
			<label class="textarea">
				<!-- <span class="ecjiaf-fl">{t}备注信息{/t}</span> -->
				<textarea type="text" placeholder="{t}请输备注信息{/t}" name="user_note" datatype="*" value=""></textarea>
			</label>
		</div>
		
		<input name="act" type="hidden" value="profile" />
		<div class=" text-center">
			<input class="btn btn-recharge" name="submit" type="submit" value="{t}立即充值{/t}" />
		</div>
	</form>
</div>
<!-- {/block} -->
