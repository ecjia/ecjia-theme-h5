<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--申请流程基本信息-->

        <!-- {foreach from=$title.cententFields key=key item=fields}  -->
        	<div class="form-group form-group-text">
                <label class="form-label">
                <p>{$fields.fieldsFormName}：</p>
                <!-- {if $fields.chooseForm eq 'input'} -->
                    <input type="text" value="{$fields.title_contents}" size="{$fields.inputForm}" name="{$fields.textFields}" {if $fields.will_choose}datatype="*"{/if}></label>
                    <!-- <span class="help-block">$fields.formSpecial</span> -->
                <!-- {elseif $fields.chooseForm eq 'other'} -->
                    <!-- {if $fields.otherForm eq 'textArea'} -->
                </label>
                        <div>
                            <select class="ecjiaf-fl region-sel" id="selCountries{$key}" data-index="{$key}" name="{$fields.textFields}[]" data-toggle="region_change" data-url="index.php?m=user&c=user_address&a=region" data-type="1" data-target="selProvinces"{if $fields.will_choose}datatype="*"{/if}>
                                <option value="0">{$lang.please_select}{$name_of_region[0]}</option>
                                <!-- {foreach from=$country_list item=country} -->
                                <option value="{$country.region_id}" {if $fields.textAreaForm.country eq $country.region_id}selected{/if}>{$country.region_name}</option>
                                <!-- {/foreach} -->
                            </select>
                            <select class="ecjiaf-fl region-sel" id="selProvinces{$key}" data-index="{$key}" name="{$fields.textFields}[]" data-toggle="region_change" data-url="index.php?m=user&c=user_address&a=region" data-type="2" data-target="selCities" {if $fields.will_choose}datatype="*"{/if}>
                                <option value="0">{$lang.please_select}{$name_of_region[1]}</option>
                                <!-- {foreach from=$fields.province_list item=province} -->
                                <option value="{$province.region_id}" {if $fields.textAreaForm.province eq $province.region_id}selected{/if}>{$province.region_name}</option>
                                <!-- {/foreach} -->
                            </select>
                            <select class="ecjiaf-fl region-sel" id="selCities{$key}" data-index="{$key}" name="{$fields.textFields}[]" data-toggle="region_change" data-url="index.php?m=user&c=user_address&a=region" data-type="3" data-target="selDistricts" {if $fields.will_choose}datatype="*"{/if}>
                                <option value="0">{$lang.please_select}{$name_of_region[2]}</option>
                                <!-- {foreach from=$fields.city_list item=city} -->
                                <option value="{$city.region_id}" {if $fields.textAreaForm.city eq $city.region_id}selected{/if}>{$city.region_name}</option>
                                <!-- {/foreach} -->
                            </select>
                            <select class="ecjiaf-fl region-sel" id="selDistricts{$key}" data-index="{$key}" name="{$fields.textFields}[]" {if $fields.will_choose}datatype="*"{/if}>
                            <option value="0">{$lang.please_select}{$name_of_region[3]}</option>
                            <!-- {foreach from=$fields.district_list item=district} -->
                            <option value="{$district.region_id}" {if $fields.textAreaForm.district eq $district.region_id}selected{/if}>{$district.region_name}</option>
                            <!-- {/foreach} -->
                            </select>
                        </div>
                    <!-- {elseif $fields.otherForm eq 'dateFile'} -->
                        <div class="reimg">{$fields.title_contents}</div><input type="file" name="{$fields.textFields}" {if $fields.will_choose}datatype="*"{/if}/>
                    <!-- {elseif $fields.otherForm eq 'dateTime'} -->
                        <!-- {foreach from=$fields.dateTimeForm item=date key=dk} -->
                            <!-- {if $dk eq 0} -->
                            <input id="{$fields.textFields}_{$dk}" type="date" size="{$date.dateSize}" value="{$date.dateCentent}" name="{$fields.textFields}[]" {if $fields.will_choose}datatype="*"{/if} />
                            <!-- {else} -->
                            -<input id="{$fields.textFields}_{$dk}" type="date" size="{$date.dateSize}" value="{$date.dateCentent}" name="{$fields.textFields}[]" {if $fields.will_choose}datatype="*"{/if} />
                            <!-- {/if} -->
                        <!-- {/foreach} -->
                    <!-- {/if} -->
                <!-- {elseif $fields.chooseForm eq 'textarea'} -->
                    <textarea name="{$fields.textFields}" cols="{$fields.cols}" rows="{$fields.rows}" {if $fields.will_choose}datatype="*"{/if}>{$fields.title_contents}</textarea></label>
                <!-- {elseif $fields.chooseForm eq 'select'} -->
                    <select name="{$fields.textFields}" {if $fields.will_choose}datatype="*"{/if}>
                        <option value="" selected="selected">请选择..</option>
                    <!-- {foreach from=$fields.selectList item=selectList} -->
                        <option value="{$selectList}" {if $fields.title_contents eq $selectList}selected="selected"{/if}>{$selectList}</option>
                    <!-- {/foreach} -->
                    </select></label>
                <!-- {elseif $fields.chooseForm eq 'radio'} -->
                        <select name="{$fields.textFields}" id="" {if $fields.will_choose}datatype="*"{/if}>
                            <!-- {foreach from=$fields.radioCheckboxForm item=radio key=rc_k} -->
                            <option value="{$radio.radioCheckbox}"{if $fields.title_contents eq $radio.radioCheckbox} selected="selected"{/if}>{$radio.radioCheckbox}</option>
                            <!-- {/foreach} -->
                        </select></label>
                    	<!-- <input name="$fields.textFields" type="radio" value="$radio.radioCheckbox" if $fields.title_contents.$fields.textFields eq $radio.radioCheckbox checked="checked"/if/>&nbsp;$radio.radioCheckbox -->
                <!-- {elseif $fields.chooseForm eq 'checkbox'} -->
                    <!-- {foreach from=$fields.radioCheckboxForm item=checkbox key=rc_k} --></label>
                    <label><input name="{$fields.textFields}" type="checkbox" value="{$radio.radioCheckbox}"  {if $fields.title_contents.{$fields.textFields} eq $checkbox.radioCheckbox}checked="checked"{/if} {if $fields.will_choose}datatype="*"{/if} />&nbsp;{$checkbox.radioCheckbox}</label>
                    <!-- {/foreach} -->
                <!-- {/if} -->
            </div>
         <!-- {/foreach} -->
