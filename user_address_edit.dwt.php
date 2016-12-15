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
<script type="text/javascript">ecjia.touch.user.address_save();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-address-list" name="theForm" action="{$form_action}" data-save-url="{url path='user/user_address/save_temp_data'}" method="post">
	<div class="form-group form-group-text">
		<a id="district" href="{url path='location/index/select_city' args="{if $info.id}type=editcity&address_id={$info.id}{else}type=addcity{/if}{if $temp.tem_city}&city_id={$temp.tem_city}{else}{if $info.city}&city_id={$info.city}{/if}{/if}"}">
		<label class="input">
			<span>所在地区： </span>
			<input name="city_name" placeholder="{t}请选择城市{/t}" type="text" datatype="*" value="{if $temp.tem_city_name}{$temp.tem_city_name}{else}{$info.city_name}{/if}" readonly="readonly" />
			<input name="city_id" type="hidden" value="{if $temp.tem_city}{$temp.tem_city}{else}{$info.city}{/if}" />
			<i class="iconfont icon-jiantou-right"></i>
		</label>
		</a>
	</div>
	<div class="form-group form-group-text margin-bottom0">
		<label class="input">
			<span class="ecjiaf-fl">收货地址： </span>
			<a href='{url path="user/user_address/near_location" args="{if $temp.tem_city_name}city={$temp.tem_city_name}{/if}{if $temp.tem_city}&city_id={$temp.tem_city}{/if}{if $info.id}&address_id={$info.id}{/if}"}'>
				<input name="address" placeholder="{t}写字楼，小区，学校，街道{/t}" type="text" datatype="*" value="{if $temp.tem_address}{$temp.tem_address}{$temp.tem_address_info}{else}{$info.address}{/if}" readonly="readonly" />
			</a>
			
			<a href="{url path='user/user_address/my_location'}">
				<div class="position"></div>
			</a>
		</label>
	</div>
	<div class="form-group form-group-text">
		<label class="input">
			<input name="address_info" placeholder="{t}楼层，门牌{/t}" type="text" datatype="*" value="{if $temp.tem_address_info}{$temp.tem_address_info}{else}{$info.address_info|escape}{/if}" />
		</label>
	</div>
	<div class="form-group form-group-text margin-bottom0">
		<label class="input">
			<span class="ecjiaf-fl">收货姓名： </span>
			<input name="consignee" placeholder="{t}请输入真实姓名，限6个字{/t}" type="text" value="{if $temp.tem_consignee}{$temp.tem_consignee}{else}{$info.consignee|escape}{/if}" datatype="*1-15" errormsg="请输入正确格式联系人" />
		</label>
	</div>
	<div class="form-group form-group-text">
		<label class="input">
			<span class="ecjiaf-fl">收货电话： </span>
			<input name="mobile" placeholder="{t}请确保收货电话真实有效{/t}" type="tel" value="{if $temp.tem_mobile}{$temp.tem_mobile}{else}{$info.mobile|escape}{/if}" datatype="m" errormsg="请输入正确格式的联系方式" />
		</label>
	</div>
	<div class="ecjia-margin-t ecjia-margin-b">
		<input class="btn btn-info nopjax" name="submit" type="submit" value="{t}保存{/t}"/>
		<input name="address_id" type="hidden" value="{$info.id}" />
	</div>
</form>

<!-- {/block} -->