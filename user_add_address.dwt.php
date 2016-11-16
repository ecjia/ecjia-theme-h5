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
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<form class="ecjia-form address-add-form" name="theForm" action="{url path='user/user_address/inster_addres'}" method="post">
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
				<input name="address" placeholder="{t}楼层，门牌{/t}" type="text" datatype="*" value="{$consignee.address|escape}" />
			</label>
	</div>
	<div class="form-group">
		<span class="ecjiaf-fl">收货姓名： </span>
		<label class="input ecjiaf-fl">
			<input name="consignee" placeholder="{t}请输入真实姓名，限6个字{/t}" type="text" value="{$consignee.consignee|escape}" datatype="*1-15" errormsg="请输入正确格式联系人" />
		</label>
	</div>
	<div class="form-group">
		<span class="ecjiaf-fl">收货电话： </span>
		<label class="input ecjiaf-fl">
			<input name="mobile" placeholder="{t}请确保收货电话真实有效{/t}" type="tel" value="{$consignee.mobile|escape}" datatype="m" errormsg="请输入正确格式的联系方式" />
		</label>
	</div>
    <div class="form-group">
    	<span class="ecjiaf-fl">邮编： </span>
		<label class="input">
			<input name="zipcode" placeholder="邮编" type="number" datatype="n6-6" errormsg="请输入6位数字邮编" value="{$consignee.zipcode|escape}" />
		</label>
	</div>
	<div class="ecjia-margin-t ecjia-margin-b">
		<input class="btn btn-info nopjax" name="submit" type="submit" value="{t}保存{/t}"/>
		<input name="address_id" type="hidden" value="{$consignee.address_id}" />
	</div>
</form>

<!-- {/block} -->