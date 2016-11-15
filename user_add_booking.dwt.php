<?php 
/*
Name: 添加缺货登记模板
Description: 添加缺货登记页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
{foreach from=$lang.profile_js item=item key=key}
var {$key} = "{$item}";
{/foreach}
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<form class="ecjia-form add-booking-form form-group" name="formPassword" action="{url path='user_booking/insert_booking'}" method="post" onsubmit="return addBooking();">
	<div class="form-group">
		<label class="input" > 
			{$lang.booking_goods_name}：
			<span>{$info.goods_name}</span>
		</label>
	</div>
	<div class="form-group">
		<label class="input"> 
			{$lang.booking_amount}：
			<!--{if $info.goods_number}-->
				<input class="ecjiaf-fr" name="number" type="number" value="{$info.goods_number}" datatype="n" />
			<!--{else}-->
				<input class="ecjiaf-fr" name="number" type="number" value="{$lang.booking_number}" datatype="n" />
			<!--{/if}-->
		</label>
	</div>
	<div class="form-group">
		<label class="input">
			{$lang.contact_username}：
			<input class="ecjiaf-fr" name="linkman" type="text" value="{$info.consignee|escape}" datatype="*3-15" errormsg="请输入正确格式收货人姓名" />
		</label>
	</div>
	<div class="form-group">
		<label class="input">
			{$lang.email_address}：
			<input class="ecjiaf-fr" name="email" type="email" value="{$info.email|escape}" datatype="e" errormsg="请输入正确格式的邮箱" />
		</label>
	</div>
	<div class="form-group">
		<label class="input">
			{$lang.contact_phone}：
			<input class="ecjiaf-fr" name="tel" type="text" value="{$info.tel|escape}" datatype="m" errormsg="请输入正确格式的联系方式" />
		</label>
	</div>
	<div class="form-group">
		<label class="textarea">
			{$lang.describe}：
			<textarea class="ecjiaf-fr" name="desc" wrap="virtual" datatype="*" >{$goods_attr}{$info.goods_desc|escape}</textarea>
		</label>
	</div>
	<div class="ecjia-margin-t">
		<input name="id" type="hidden" value="{$info.id}" />
		<input name="rec_id" type="hidden" value="{$info.rec_id}" />
		<input name="submit" type="submit" class="btn btn-info" value="{$lang.submit_booking_goods}" />
	</div>
</form>
<!-- {/block} -->