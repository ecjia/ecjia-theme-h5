<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--申请店铺信息-->
<div class="row-fluid edit-page">
	<div class="span12">
         <!-- {foreach from=$title.cententFields item=fields}  -->
        	<div class="control-group formSep">
                <label class="control-label">{$fields.fieldsFormName}：</label>
                <!-- {if $fields.chooseForm eq 'input'} -->
                <div class="controls">
                    <input class="input" type="text" value="{$fields.title_contents.{$fields.textFields}}" size="{$fields.inputForm}" name="{$fields.textFields}"  {if $fields.will_choose}datatype="*"{/if}>
                    <span class="help-block">{$fields.formSpecial}</span>
                </div>
                <!-- {elseif $fields.chooseForm eq 'other'} -->
                    <!-- {if $fields.otherForm eq 'textArea'} -->
                        <select style="width: 100px;" name="{$fields.textFields}[]" data-toggle="regionSummary" data-url='{url path="seller/region/init"}' data-type="1" data-target="selProvinces_{$fields.textFields}_{$sn}"  {if $fields.will_choose}datatype="*"{/if} >
							<option value="0">{t}请选择{/t}</option>
							<!-- {foreach from=$country_list item=country} -->
							<option value="{$country.region_id}" {if $fields.textAreaForm.country eq $country.region_id}selected{/if}>{$country.region_name}</option>
							<!-- {/foreach} -->
						</select>
						<select style="width: 100px;" class="selProvinces_{$fields.textFields}_{$sn}" name="{$fields.textFields}[]" data-toggle="regionSummary" data-type="2" data-target="selCities_{$fields.textFields}_{$sn}"  {if $fields.will_choose}datatype="*"{/if} >
							<option value="0">{t}请选择{/t}</option>
							<!-- {foreach from=$fields.province_list item=province} -->
							<option value="{$province.region_id}" {if $fields.textAreaForm.province eq $province.region_id}selected{/if}>{$province.region_name}</option>
							<!-- {/foreach} -->
						</select>
						<select style="width: 100px;" class="selCities_{$fields.textFields}_{$sn}" name="{$fields.textFields}[]" data-toggle="regionSummary" data-type="3" data-target="selDistricts_{$fields.textFields}_{$sn}"  {if $fields.will_choose}datatype="*"{/if} >
							<option value="0">{t}请选择{/t}</option>
							<!-- {foreach from=$fields.city_list item=city} -->
							<option value="{$city.region_id}" {if $fields.textAreaForm.city eq $city.region_id}selected{/if}>{$city.region_name}</option>
							<!-- {/foreach} -->
						</select>
					    <select style="width: 100px;" class="selDistricts_{$fields.textFields}_{$sn}" name="{$fields.textFields}[]"  {if $fields.will_choose}datatype="*"{/if}>
							<option value="0">{t}请选择{/t}</option>
							<!-- {foreach from=$fields.district_list item=district} -->
							<option value="{$district.region_id}" {if $fields.textAreaForm.district eq $district.region_id}selected{/if}>{$district.region_name}</option>
							<!-- {/foreach} -->
						</select>
                    <!-- {elseif $fields.otherForm eq 'dateFile'} -->
						<input type="file" name="{$fields.textFields}"  {if $fields.will_choose}datatype="*"{/if}/>
                    <!-- {elseif $fields.otherForm eq 'dateTime'} -->
                        <!-- {foreach from=$fields.dateTimeForm item=date key=dk} -->
                            <!-- {if $dk eq 0} -->
                            <input id="{$fields.textFields}_{$dk}" class="input jdate narrow" type="text" size="{$date.dateSize}" value="{$date.dateCentent}" name="{$fields.textFields}[]"  {if $fields.will_choose}datatype="*"{/if}> 
                            <!-- {else} -->
                            - <input id="{$fields.textFields}_{$dk}" class="input jdate narrow" type="text" size="{$date.dateSize}" value="{$date.dateCentent}" name="{$fields.textFields}[]"  {if $fields.will_choose}datatype="*"{/if}> 
                            <!-- {/if} -->
                        <!-- {/foreach} -->
                    <!-- {/if} -->
                <!-- {elseif $fields.chooseForm eq 'textarea'} -->
                    <textarea name="{$fields.textFields}" cols="{$fields.cols}" rows="{$fields.rows}"  {if $fields.will_choose}datatype="*"{/if}>{$fields.title_contents.{$fields.textFields}}</textarea>
                <!-- {elseif $fields.chooseForm eq 'select'} -->
                    <select name="{$fields.textFields}"  {if $fields.will_choose}datatype="*"{/if}>
                        <option value="" selected="selected">请选择..</option>
                    <!-- {foreach from=$fields.selectList item=selectList} -->
                        <option value="{$selectList}" {if $fields.title_contents.{$fields.textFields} eq $selectList}selected="selected"{/if}>{$selectList}</option>
                    <!-- {/foreach} -->
                    </select>
                <!-- {elseif $fields.chooseForm eq 'radio'} -->
	                    <!-- {foreach from=$fields.radioCheckboxForm item=radio key=rc_k} -->
                    	<input name="{$fields.textFields}" type="radio" value="{$radio.radioCheckbox}" {if $fields.title_contents.{$fields.textFields} eq $radio.radioCheckbox} checked="checked"{/if}  {if $fields.will_choose}datatype="*"{/if} />&nbsp;{$radio.radioCheckbox}
                    	<!-- {/foreach} -->
                <!-- {elseif $fields.chooseForm eq 'checkbox'} -->
                    <!-- {foreach from=$fields.radioCheckboxForm item=checkbox key=rc_k} -->
                    <label><input name="{$fields.textFields}" type="checkbox" value="{$radio.radioCheckbox}"  {if $fields.title_contents.{$fields.textFields} eq $checkbox.radioCheckbox}checked="checked"{/if} {if $fields.will_choose}datatype="*"{/if} />&nbsp;{$checkbox.radioCheckbox}</label>
                    <!-- {/foreach} -->
                <!-- {/if} -->
            </div>
         <!-- {/foreach} -->  
        <!--以上是自定义基本信息，以下是固定信息-->
       <!--  <div>
			<h3 class="heading">
				{t}店铺信息{/t}
			</h3>
		</div> -->
        <div class="form-group form-group-textform-group form-group-text">
        	<label>期望店铺类型：<!-- {if $title.parentType.shoprz_type eq 1} -->旗舰店<!-- {elseif $title.parentType.shoprz_type eq 2} -->专卖店<!-- {elseif $title.parentType.shoprz_type eq 3} -->专营店<!-- {/if} --></label>
        </div>
        
        <div class="form-group form-group-textform-group form-group-text">
        	<label class="input">旗舰店命名规范：</label>
        	<div class="controls l_h30">
        		店铺名称：品牌名|类目描述|旗舰店/官方旗舰店  (也可自定义,如：ecshop模板堂官方旗舰店)
        	</div>
        </div>
        
        <div class="form-group form-group-textform-group form-group-text">
        	<label class="input">店铺名称：</label>
        	<div class="controls l_h30">
        		仅作为参考，最终已审核通过的店铺名称为准。
        	</div>
        </div>
        
        <div class="form-group form-group-textform-group form-group-text">
        	<label>
                <p>选择品牌名：</p>
        		<select name="ec_shoprz_brandName" onChange="get_shoprz_brandName(this.value);">
                	<option value="0">请选择品牌名称</option>
                    <!-- {foreach from=$title.brand_list item=brand} -->
                    <option value="{$brand.brandName}" {if $title.parentType.shoprz_brandName eq $brand.brandName}selected{/if}>{$brand.brandName}</option>
                    <!-- {/foreach} -->
            	</select>
            </label>
        </div>
        
        <div class="form-group form-group-text">
        	<label class="input">
                <p>类目描述关键词：</p>
        		<input type="text" name="ec_shop_class_keyWords" size="30" value="{$title.parentType.shop_class_keyWords}">
            </label>
        </div>
        
        <div class="form-group form-group-text">
        	<label>
            <p>选择店铺后缀：</p>
        		<select name="ec_shopNameSuffix" onChange="get_shopNameSuffix(this.value);">
                	<option selected="selected" value="0">请选择..</option>
                    <option {if $title.parentType.shopNameSuffix eq '旗舰店'}selected{/if} value="旗舰店">旗舰店</option>
                    <option {if $title.parentType.shopNameSuffix eq '专卖店'}selected{/if} value="专卖店">专卖店</option>
                    <option {if $title.parentType.shopNameSuffix eq '专营店'}selected{/if} value="专营店">专营店</option>
                    <option {if $title.parentType.shopNameSuffix eq '馆'}selected{/if} value="馆">馆</option>
                </select>
            </label>

        </div>
        
        <div class="form-group form-group-text">
        	<label class="input">
                <p>期望店铺名称：</p>
        		<input type="text" name="ec_rz_shopName" id="rz_shopName" size="30" value="{$title.parentType.rz_shopName}">
            </label>
        </div>

        <div class="form-group form-group-text">
        	<label class="input">
            <p>期望店铺登陆用户名：</p>
        		<input type="text" name="ec_hopeLoginName" size="30" value="{$title.parentType.hopeLoginName}">
            </label>
        </div>
        
    </div>
</div>

<script type="text/javascript">
//function get_shoprz_brandName(val) {
//	var str = new Array();
//	var shopName = '';
//	var i;
//
//	shopName = document.getElementById('rz_shopName').value;
//	str = shopName.split("|");
//
//	if (str[0] != val) {
//		str[0] = val;
//	}
//	if (str.length == 1) {
//		str[0] = str[0] + "|";
//	}
//
//	if (str[1] == '') {
//		str[1] = '类目描述';
//	}
//
//	str = str.join('|');
//	document.getElementById('rz_shopName').value = str;
//}
//function get_shopNameSuffix(val) {
//	var str = new Array();
//	var shopName = '';
//	var i;
//
//	shopName = document.getElementById('rz_shopName').value;
//	str = shopName.split("|");
//
//	if (str[1] == '') {
//		str[1] = '类目描述';
//	}
//
//	if (str[2] != val) {
//		str[2] = val;
//		if (typeof(str[1]) == 'undefined') {
//			str[1] = '类目描述';
//		}
//	}
//
//	str = str.join('|');
//	document.getElementById('rz_shopName').value = str;
//}
</script>