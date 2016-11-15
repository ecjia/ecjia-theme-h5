<?php 
/*
Name: 增加收货地址模板
Description: 增加收货地址页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.region_change();</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<form class="ecjia-form address-add-form" name="theForm" action="{url path='user/user_address/inster_addres'}" method="post">
	<div class="form-group">
		<label class="input">
			<input name="consignee" placeholder="{$lang.consignee_name}{$lang.require_field}" type="text" value="{$consignee.consignee|escape}" datatype="*1-15" errormsg="请输入正确格式联系人" />
		</label>
	</div>
	<div class="form-group">
		<label class="input">			
			<input name="mobile" placeholder="{$lang.mobile}{$lang.require_field}" type="tel" value="{$consignee.mobile|escape}" datatype="m" errormsg="请输入正确格式的联系方式" />
		</label>
	</div>
    <div class="form-group">
		<label class="input">
			<input name="zipcode" placeholder="邮编" type="number" datatype="n6-6" errormsg="请输入6位数字邮编" value="{$consignee.zipcode|escape}" />
		</label>
	</div>
	<div class="form-group">
		<div class="ecjiaf-fl">
			<select class="form-select" id="selCountries" name="country" data-toggle="region_change" data-url="index.php?m=user&c=user_address&a=region" data-type="1" data-target="selProvinces">
				<option value="0">{$lang.please_select}{$name_of_region[0]}</option>
				<!-- {foreach from=$country_list item=country} -->
				<option value="{$country.region_id}" {if $consignee.country eq $country.region_id}selected{/if}>{$country.region_name}</option>
				<!-- {/foreach} -->
			</select>
		</div>
		<div class="ecjiaf-fl">
			<select class="form-select" id="selProvinces" name="province" data-toggle="region_change" data-url="index.php?m=user&c=user_address&a=region" data-type="2" data-target="selCities">
				<option value="0">{$lang.please_select}{$name_of_region[1]}</option>
				<!-- {foreach from=$province_list item=province} -->
				<option value="{$province.region_id}" {if $consignee.province eq $province.region_id}selected{/if}>{$province.region_name}</option>
				<!-- {/foreach} -->
			</select>
		</div>
		<div class="ecjiaf-fl">
			<select class="form-select" id="selCities" name="city" data-toggle="region_change" data-url="index.php?m=user&c=user_address&a=region" data-type="3" data-target="selDistricts">
				<option value="0">{$lang.please_select}{$name_of_region[2]}</option>
				<!-- {foreach from=$city_list item=city} -->
				<option value="{$city.region_id}" {if $consignee.city eq $city.region_id}selected{/if}>{$city.region_name}</option>
				<!-- {/foreach} -->
			</select>
		</div>
		<div class="ecjiaf-fl">
			<select class="form-select" id="selDistricts" name="district">
				<option value="0">{$lang.please_select}{$name_of_region[3]}</option>
				<!-- {foreach from=$district_list item=district} -->
				<option value="{$district.region_id}" {if $consignee.district eq $district.region_id}selected{/if}>{$district.region_name}</option>
				<!-- {/foreach} -->
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="textarea">
			<textarea name="address" placeholder="{$lang.detailed_address}{$lang.require_field}" type="text" datatype="*">{$consignee.address|escape}</textarea>
		</label>
	</div>
	<div class="ecjia-margin-t ecjia-margin-b">
		<input class="btn btn-info nopjax" name="submit" type="submit" value="{$lang.add_address}"/>
		<input name="address_id" type="hidden" value="{$consignee.address_id}" />
	</div>
</form>

<!-- {/block} -->