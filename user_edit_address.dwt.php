<?php
/*
Name: 编辑收货地址的处理模板
Description: 编辑收货地址的处理页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<form class="ecjia-form ecjia-margin-t address-add-form" action="{url path='user_address/update_address'}" method="post" name="theForm">
	<div class="form-group form-group-text">
		<label class="input">
			<span>所在地区： </span>
			<input name="district" placeholder="{t}请选择城市{/t}" type="text" datatype="*" value=""/>
			<i class="iconfont icon-jiantou-right"></i>
		</label>
	</div>
	<div class="form-group form-group-text">
		<label class="input">
			<span class="ecjiaf-fl">收货地址： </span>
			<input name="location" placeholder="{t}写字楼，小区，学校，街道{/t}" type="text" datatype="*" value="" />
			<i class="iconfont icon-focus"></i>
		</label>
	</div>
	<div class="form-group form-group-text">
		<label class="input">
			<input name="address" placeholder="{t}楼层，门牌{/t}" value="{$consignee.address|escape}" datatype="*" value="{$consignee.address}" />
		</label>
	</div>
	<div class="form-group form-group-text">
		<label class="input">
			<span class="ecjiaf-fl">收货姓名： </span>
			<input name="consignee" placeholder="{t}请输入真实姓名，限6个字{/t}" type="text" value="{$consignee.consignee|escape}" datatype="s1-15" errormsg="请输入正确格式的收货人" />
		</label>
	</div>
	<div class="form-group form-group-text">
		<label class="input">
			<span class="ecjiaf-fl">收货电话： </span>
			<input name="mobile" placeholder="{t}请确保收货电话真实有效{/t}" type="tel" value="{$consignee.mobile|escape}" datatype="m" errormsg="请输入正确格式的联系方式" />
		</label>
	</div>
	<!-- {if $consignee.is_default eq ''} -->
	<div class="form-group last-form-group">
			{t}设为默认收货{/t}
			<label class="ecjiaf-fr" for="is_default">
				<input class="checkbox" data-trigger="checkbox" id="is_default" type="checkbox"{if $consignee.is_default}checked="checked"{/if} value="1" name="default" >
			</label>
	</div>
	<!-- {/if} -->
	<div class="ecjia-margin-t">
		<button class="btn btn-info nopjax" type="submit" name="submit">{$lang.confirm_edit}</button>
		<input name="address_id" type="hidden" value="{$consignee.address_id}" />
	</div>
</form>
<!-- {/block} -->
