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

<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-address-list" name="theForm" action="{$form_action}" method="post">
	<div class="form-group form-group-text">
		<a id="district" href="{url path='user/user_address/city' args="{if $info.id}city=editcity&address_id={$info.id}{else}city=addcity{/if}{if $smarty.get.city_id}&city_id={$smarty.get.city_id}{else}{if $info.city}&city_id={$info.city}{/if}{/if}"}">
		<label class="input">
			<span>所在地区： </span>
			<input name="city_name" placeholder="{t}请选择城市{/t}" type="text" datatype="*" value="{if $smarty.get.city}{$smarty.get.city}{else}{$info.city_name}{/if}" />
			<input name="city" type="hidden" value="{if $smarty.get.city_id}{$smarty.get.city_id}{else}{$info.city}{/if}" />
			<i class="iconfont icon-jiantou-right"></i>
		</label>
		</a>
	</div>
	<div class="form-group form-group-text margin-bottom0">
		<label class="input">
			<span class="ecjiaf-fl">收货地址： </span>
			<a href='{url path="user/user_address/near_location" args="{if $smarty.get.city}city={$smarty.get.city}{/if}{if $smarty.get.city_id}&city_id={$smarty.get.city_id}{/if}{if $info.id}&address_id={$info.id}{/if}"}'>
				<input name="address_location" placeholder="{t}写字楼，小区，学校，街道{/t}" type="text" datatype="*" value="{if $smarty.get.address}{$smarty.get.address}{else}{$info.address}{/if}" />
			</a>
			
			<a href="{url path='user/user_address/my_location'}">
				<div class="position"></div>
			</a>
		</label>
	</div>
	<div class="form-group form-group-text">
		<label class="input">
			<input name="address" placeholder="{t}楼层，门牌{/t}" type="text" datatype="*" value="{$info.address_info|escape}" />
		</label>
	</div>
	<div class="form-group form-group-text margin-bottom0">
		<label class="input">
			<span class="ecjiaf-fl">收货姓名： </span>
			<input name="consignee" placeholder="{t}请输入真实姓名，限6个字{/t}" type="text" value="{$info.consignee|escape}" datatype="*1-15" errormsg="请输入正确格式联系人" />
		</label>
	</div>
	<div class="form-group form-group-text">
		<label class="input">
			<span class="ecjiaf-fl">收货电话： </span>
			<input name="mobile" placeholder="{t}请确保收货电话真实有效{/t}" type="tel" value="{$info.mobile|escape}" datatype="m" errormsg="请输入正确格式的联系方式" />
		</label>
	</div>
	<div class="ecjia-margin-t ecjia-margin-b">
		<input class="btn btn-info nopjax" name="submit" type="submit" value="{t}保存{/t}"/>
		<input name="address_id" type="hidden" value="{$info.id}" />
	</div>
</form>

<!-- {/block} -->