<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--申请类目信息-->
<!-- <div>
	<h3 class="heading">
		{$title.fields_titles}<label class="help-block">{$title.titles_annotation}</label>
	</h3>
</div> -->
        <!-- {foreach from=$title.cententFields item=fields}  -->
        	<div class="form-group form-group-text">
                <label class="input">{$fields.fieldsFormName}：</label>
                <!-- {if $fields.chooseForm eq 'input'} -->
                    <input class="input" type="text" value="{$fields.title_contents.{$fields.textFields}}" size="{$fields.inputForm}" name="{$fields.textFields}" {if $fields.will_choose}datatype="*"{/if}>
                    <span class="help-block">{$fields.formSpecial}</span>
                <!-- {elseif $fields.chooseForm eq 'other'} -->
                    <!-- {if $fields.otherForm eq 'textArea'} -->
                        <select style="width: 100px;" name="{$fields.textFields}[]" data-toggle="regionSummary" data-url='{url path="user/user_merchant/region"}' data-type="1" data-target="selProvinces_{$fields.textFields}_{$sn}" {if $fields.will_choose}datatype="*"{/if} >
							<option value="0">{t}请选择{/t}</option>
							<!-- {foreach from=$country_list item=country} -->
							<option value="{$country.region_id}" {if $fields.textAreaForm.country eq $country.region_id}selected{/if}>{$country.region_name}</option>
							<!-- {/foreach} -->
						</select>
						<select style="width: 100px;" class="selProvinces_{$fields.textFields}_{$sn}" name="{$fields.textFields}[]" data-toggle="regionSummary" data-type="2" data-target="selCities_{$fields.textFields}_{$sn}" {if $fields.will_choose}datatype="*"{/if}>
							<option value="0">{t}请选择{/t}</option>
							<!-- {foreach from=$fields.province_list item=province} -->
							<option value="{$province.region_id}" {if $fields.textAreaForm.province eq $province.region_id}selected{/if}>{$province.region_name}</option>
							<!-- {/foreach} -->
						</select>
						<select style="width: 100px;" class="selCities_{$fields.textFields}_{$sn}" name="{$fields.textFields}[]" data-toggle="regionSummary" data-type="3" data-target="selDistricts_{$fields.textFields}_{$sn}" {if $fields.will_choose}datatype="*"{/if}>
							<option value="0">{t}请选择{/t}</option>
							<!-- {foreach from=$fields.city_list item=city} -->
							<option value="{$city.region_id}" {if $fields.textAreaForm.city eq $city.region_id}selected{/if}>{$city.region_name}</option>
							<!-- {/foreach} -->
						</select>
					    <select style="width: 100px;" class="selDistricts_{$fields.textFields}_{$sn}" name="{$fields.textFields}[]" {if $fields.will_choose}datatype="*"{/if}>
							<option value="0">{t}请选择{/t}</option>
							<!-- {foreach from=$fields.district_list item=district} -->
							<option value="{$district.region_id}" {if $fields.textAreaForm.district eq $district.region_id}selected{/if}>{$district.region_name}</option>
							<!-- {/foreach} -->
						</select>
                    <!-- {elseif $fields.otherForm eq 'dateFile'} -->
						<input type="file" name="{$fields.textFields}" {if $fields.will_choose}datatype="*"{/if}/>
                    <!-- {elseif $fields.otherForm eq 'dateTime'} -->
                    <div class="controls">
                        <!-- {foreach from=$fields.dateTimeForm item=date key=dk} -->
                            <!-- {if $dk eq 0} -->
                            <input id="{$fields.textFields}_{$dk}" type="text" size="{$date.dateSize}" value="{$date.dateCentent}" name="{$fields.textFields}[]" {if $fields.will_choose}datatype="*"{/if}>
                            <!-- {else} -->
                            - <input id="{$fields.textFields}_{$dk}" type="text" size="{$date.dateSize}" value="{$date.dateCentent}" name="{$fields.textFields}[]" {if $fields.will_choose}datatype="*"{/if}>
                            <!-- {/if} -->
                        <!-- {/foreach} -->
                    </div>
                    <!-- {/if} -->
                <!-- {elseif $fields.chooseForm eq 'textarea'} -->
                    <textarea name="{$fields.textFields}" cols="{$fields.cols}" rows="{$fields.rows}" {if $fields.will_choose}datatype="*"{/if}>{$fields.title_contents.{$fields.textFields}}</textarea>
                <!-- {elseif $fields.chooseForm eq 'select'} -->
                    <select name="{$fields.textFields}" {if $fields.will_choose}datatype="*"{/if}>
                        <option value="" selected="selected">请选择..</option>
                    <!-- {foreach from=$fields.selectList item=selectList} -->
                        <option value="{$selectList}" {if $fields.title_contents.{$fields.textFields} eq $selectList}selected="selected"{/if}>{$selectList}</option>
                    <!-- {/foreach} -->
                    </select>
                <!-- {elseif $fields.chooseForm eq 'radio'} -->
	                    <!-- {foreach from=$fields.radioCheckboxForm item=radio key=rc_k} -->
                    	<input name="{$fields.textFields}" type="radio" value="{$radio.radioCheckbox}" {if $fields.title_contents.{$fields.textFields} eq $radio.radioCheckbox} checked="checked"{/if} {if $fields.will_choose}datatype="*"{/if}/>&nbsp;{$radio.radioCheckbox}
                    	<!-- {/foreach} -->
                <!-- {elseif $fields.chooseForm eq 'checkbox'} -->
                    <!-- {foreach from=$fields.radioCheckboxForm item=checkbox key=rc_k} -->
                    <label><input name="{$fields.textFields}" type="checkbox" value="{$radio.radioCheckbox}"  {if $fields.title_contents.{$fields.textFields} eq $checkbox.radioCheckbox}checked="checked"{/if} {if $fields.will_choose}datatype="*"{/if} />&nbsp;{$checkbox.radioCheckbox}</label>
                    <!-- {/foreach} -->
                <!-- {/if} -->
        	</div>
        <!-- {/foreach} -->
        <div class="form-group form-group-text">
        	<label class="control-label">期望店铺类型：</label>
            <select id="shoprz_type" name="ec_shoprz_type" {if $fields.will_choose}datatype="*"{/if}>
                <option value="0" {if $title.parentType.shoprz_type eq 0}selected="selected"{/if}>请选择</option>
                <option value="1" {if $title.parentType.shoprz_type eq 1}selected="selected"{/if}>旗舰店</option>
                <option value="2" {if $title.parentType.shoprz_type eq 2}selected="selected"{/if}>专卖店</option>
                <option value="3" {if $title.parentType.shoprz_type eq 3}selected="selected"{/if}>专营店</option>
            </select>

            <select class="{if $title.parentType.shoprz_type neq 1} hide{/if}" id="subShoprz_type" name="ec_subShoprz_type" {if $fields.will_choose}datatype="*"{/if}>
                <option value="0" {if $title.parentType.subShoprz_type eq 0}selected="selected"{/if}>请选择</option>
                <option value="1" {if $title.parentType.subShoprz_type eq 1}selected="selected"{/if}>厂商直营旗舰店</option>
                <option value="2" {if $title.parentType.subShoprz_type eq 2}selected="selected"{/if}>厂商授权旗舰店</option>
                <option value="3" {if $title.parentType.subShoprz_type eq 3}selected="selected"{/if}>卖场型旗舰店</option>
            </select>
        </div>
        <div class="form-group form-group-text subShoprz_type2{if $title.parentType.subShoprz_type neq 2} hide{/if}">
        	<label>
            <p>授权有效期：</p>
        		<input class="two-line" id="shop_expireDateStart" type="date" value="{$title.parentType.shop_expireDateStart}" name="ec_shop_expireDateStart" {if $fields.will_choose}datatype="*"{/if}>
                <input class="two-line" id="shop_expireDateEnd" type="date" value="{$title.parentType.shop_expireDateEnd}" name="ec_shop_expireDateEnd" {if $fields.will_choose}datatype="*"{/if}>
<!--                <input class="hide" type="checkbox" id="authorizeCheckBox" value="1" name="ec_shop_permanent" {if $title.parentType.shop_permanent eq 1}checked{/if}> 永久-->
            </label>
            <div class="reimg ecjia-margin-t"></div>
            <input type="file" name="ec_authorizeFile" {if $fields.will_choose}datatype="*"{/if}/>
        </div>

        <div class="form-group form-group-text shop_hypermarketFile{if $title.parentType.subShoprz_type neq 3} hide{/if}">
            <p>服务类商标注册证：</p>
            <div class="reimg"></div>
            <input type="file" name="ec_shop_hypermarketFile"  {if $fields.will_choose}datatype="*"{/if}/>
        </div>