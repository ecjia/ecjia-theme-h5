<?php 
/*
Name: 增加收货地址模板
Description: 增加收货地址页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.region_change();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->

<form class="ecjia-form ecjia-margin-t" name="theForm" action="{url path='user/user_address/inster_addres'}" method="post">
	<div class="ecjia-address-list">
		<div class="form-group form-group-text">
			<label class="input">
				<span>所在地区： </span>
				<input name="district" placeholder="{t}请选择城市{/t}" type="text" datatype="*" value="" />
				<label class="iconfont icon-jiantou-right"></label>
			</label>
		</div>
		<div class="form-group form-group-text">
			<label class="input">
				<span class="ecjiaf-fl">收货地址： </span>
				<input name="location" placeholder="{t}写字楼，小区，学校，街道{/t}" type="text" datatype="*" value="" />
				<a href={url path='user/user_address/near_location'}>
					<label class="iconfont icon-focus"></label>
				</a>
			</label>
		</div>
		<div class="form-group form-group-text">
			<label class="input">
				<input name="address" placeholder="{t}楼层，门牌{/t}" type="text" datatype="*" value="{$consignee.address|escape}" />
			</label>
		</div>
		<div class="form-group form-group-text">
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
	</div>
</form>

<!-- {/block} -->