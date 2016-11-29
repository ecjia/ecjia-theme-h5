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

<form class=" ecjia-address-list" action="{url path='user_address/update_address'}" method="post" name="theForm">
	<div class="form-group form-group-text ecjia-margin-b">
		<label class="input">
			<span>所在地区： </span>
			<input name="district" placeholder="{t}请选择城市{/t}" type="text" datatype="*" value="" />
			<i class="iconfont icon-jiantou-right"></i>
		</label>
	</div>
	<div class="form-group form-group-text margin-bottom0">
		<label class="input">
			<span class="ecjiaf-fl">收货地址： </span>
			<input name="location" placeholder="{t}写字楼，小区，学校，街道{/t}" type="text" datatype="*" value="" />
			<a href={url path='user/user_address/near_location'}>
				<i class="iconfont icon-focus"></i>
			</a>
		</label>
	</div>
	<div class="form-group form-group-text">
		<label class="input">
			<input name="address" placeholder="{t}楼层，门牌{/t}" type="text" datatype="*" value="{$consignee.address|escape}" />
		</label>
	</div>
	<div class="form-group form-group-text margin-bottom0">
		<label class="input">
			<span class="ecjiaf-fl">收货姓名： </span>
			<input name="consignee" placeholder="{t}请输入真实姓名，限6个字{/t}" type="text" value="{$consignee.consignee|escape}" datatype="*1-15" errormsg="请输入正确格式联系人" />
		</label>
	</div>
	<div class="form-group form-group-text">
		<label class="input">
			<span class="ecjiaf-fl">收货电话： </span>
			<input name="mobile" placeholder="{t}请确保收货电话真实有效{/t}" type="tel" value="{$consignee.mobile|escape}" datatype="m" errormsg="请输入正确格式的联系方式" />
		</label>
	</div>
	<div class="ecjia-margin-t ecjia-margin-b">
		<input class="btn btn-info nopjax" name="submit" type="submit" value="{t}保存{/t}"/>
		<input name="address_id" type="hidden" value="{$consignee.address_id}" />
	</div>
</form>
<!-- {/block} -->
