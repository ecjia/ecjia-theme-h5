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
	<div class="form-group">
		<span class="ecjiaf-fl">所在地区： </span>
		<div class="ecjiaf-fl">
			<select class="form-select" id="selCountries" name="country" data-toggle="region_change" data-url="index.php?m=user&c=user_address&a=region" data-type="1" data-target="selProvinces">
				<option value="0">{$lang.please_select}{$name_of_region[0]}</option>
				<!-- {foreach from=$country_list item=country} -->
				<option value="{$country.region_id}" {if $consignee.country eq $country.region_id}selected{/if}>{$country.region_name}</option>
				<!-- {/foreach} -->
			</select>
		</div>
		<div class="ecjiaf-fl">
			<select class="form-select" name="province" id="selProvinces" data-toggle="region_change" data-url="index.php?m=user&c=user_address&a=region" data-type="2" data-target="selCities">
				<option value="0">{$lang.please_select}{$name_of_region[1]}</option>
				<!-- {foreach from=$province_list item=province} -->
				<option value="{$province.region_id}" {if $consignee.province eq $province.region_id}selected{/if}>{$province.region_name}</option>
				<!-- {/foreach} -->
			</select>
		</div>
		<div class="ecjiaf-fl">
			<select class="form-select" name="city" id="selCities" data-toggle="region_change" data-url="index.php?m=user&c=user_address&a=region" data-type="3" data-target="selDistricts">
				<option value="0">{$lang.please_select}{$name_of_region[2]}</option>
				<!-- {foreach from=$city_list item=city} -->
				<option value="{$city.region_id}" {if $consignee.city eq $city.region_id}selected{/if}>{$city.region_name}</option>
				<!-- {/foreach} -->
			</select>
		</div>
		<div class="addres-area ecjiaf-fl">
			<select class="form-select" name="district" id="selDistricts">
				<option value="0">{$lang.please_select}{$name_of_region[3]}</option>
				<!-- {foreach from=$district_list item=district} -->
				<option value="{$district.region_id}" {if $consignee.district eq $district.region_id}selected{/if}>{$district.region_name}</option>
				<!-- {/foreach} -->
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="textarea">
			<input name="address" placeholder="{t}楼层，门牌{/t}" value="{$consignee.address|escape}" datatype="*" value="{$consignee.address}" />
		</label>
	</div>
	<div class="form-group">
		<label class="input">
			<span class="ecjiaf-fl">收货姓名： </span>
			<input class="ecjiaf-fr" name="consignee" placeholder="{t}请输入真实姓名，限6个字{/t}" type="text" value="{$consignee.consignee|escape}" datatype="s1-15" errormsg="请输入正确格式的收货人" />
		</label>
	</div>
	<div class="form-group">
		<span class="ecjiaf-fl">收货电话： </span>
		<label class="input">
			<input class="inputBg_touch" name="mobile" placeholder="{t}请确保收货电话真实有效{/t}" type="tel" value="{$consignee.mobile|escape}" datatype="m" errormsg="请输入正确格式的联系方式" />
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
