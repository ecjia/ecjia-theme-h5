<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--申请店铺信息-->
<!-- <div>
	<h3 class="heading">
		{$title.fields_titles}<label class="help-block">{$title.titles_annotation}</label>
	</h3>
</div> -->
	<!-- {foreach from=$title.cententFields item=fields}  -->
	<div class="form-group form-group-text">
		<label class="control-label">
		<span>{$fields.fieldsFormName}：</span>
		<span>{$fields.fieldsFormName}：</span>
		<!-- {if $fields.chooseForm eq 'input'} -->
			<input type="text" value="{$fields.title_contents.{$fields.textFields}}" size="{$fields.inputForm}" name="{$fields.textFields}" {if $fields.will_choose}datatype="*"{/if}>
		</label>
		<span class="help-block">{$fields.formSpecial}</span>
		<!-- {elseif $fields.chooseForm eq 'other'} -->
		<!-- {if $fields.otherForm eq 'textArea'} -->
			<select style="width: 100px;" name="{$fields.textFields}[]" data-toggle="regionSummary" data-url='{url path="seller/region/init"}' data-type="1" data-target="selProvinces_{$fields.textFields}_{$sn}" {if $fields.will_choose}datatype="*"{/if} >
			<option value="0">{t}请选择{/t}</option>
			<!-- {foreach from=$country_list item=country} -->
			<option value="{$country.region_id}" {if $fields.textAreaForm.country eq $country.region_id}selected{/if}>{$country.region_name}</option>
			<!-- {/foreach} -->
			</select>
			<select style="width: 100px;" class="selProvinces_{$fields.textFields}_{$sn}" name="{$fields.textFields}[]" data-toggle="regionSummary" data-type="2" data-target="selCities_{$fields.textFields}_{$sn}" {if $fields.will_choose}datatype="*"{/if} >
			<option value="0">{t}请选择{/t}</option>
			<!-- {foreach from=$fields.province_list item=province} -->
			<option value="{$province.region_id}" {if $fields.textAreaForm.province eq $province.region_id}selected{/if}>{$province.region_name}</option>
			<!-- {/foreach} -->
			</select>
			<select style="width: 100px;" class="selCities_{$fields.textFields}_{$sn}" name="{$fields.textFields}[]" data-toggle="regionSummary" data-type="3" data-target="selDistricts_{$fields.textFields}_{$sn}" {if $fields.will_choose}datatype="*"{/if} >
			<option value="0">{t}请选择{/t}</option>
			<!-- {foreach from=$fields.city_list item=city} -->
			<option value="{$city.region_id}" {if $fields.textAreaForm.city eq $city.region_id}selected{/if}>{$city.region_name}</option>
			<!-- {/foreach} -->
			</select>
			<select style="width: 100px;" class="selDistricts_{$fields.textFields}_{$sn}" name="{$fields.textFields}[]" {if $fields.will_choose}datatype="*"{/if} >
			<option value="0">{t}请选择{/t}</option>
			<!-- {foreach from=$fields.district_list item=district} -->
			<option value="{$district.region_id}" {if $fields.textAreaForm.district eq $district.region_id}selected{/if}>{$district.region_name}</option>
			<!-- {/foreach} -->
			</select>
		<!-- {elseif $fields.otherForm eq 'dateFile'} -->
			<input type="file" name="{$fields.textFields}"  {if $fields.will_choose}datatype="*"{/if}/>
		</label>
		<!-- {elseif $fields.otherForm eq 'dateTime'} -->
			<!-- {foreach from=$fields.dateTimeForm item=date key=dk} -->
				<!-- {if $dk eq 0} -->
				<input id="{$fields.textFields}_{$dk}" type="text" size="{$date.dateSize}" value="{$date.dateCentent}" name="{$fields.textFields}[]"  {if $fields.will_choose}datatype="*"{/if} >
				<!-- {else} -->
				- <input id="{$fields.textFields}_{$dk}" type="text" size="{$date.dateSize}" value="{$date.dateCentent}" name="{$fields.textFields}[]"  {if $fields.will_choose}datatype="*"{/if} >
				<!-- {/if} -->
			<!-- {/foreach} -->
		<!-- {/if} -->
		<!-- {elseif $fields.chooseForm eq 'textarea'} -->
			<textarea name="{$fields.textFields}" cols="{$fields.cols}" rows="{$fields.rows}"  {if $fields.will_choose}datatype="*"{/if} >{$fields.title_contents.{$fields.textFields}}</textarea>
		<!-- {elseif $fields.chooseForm eq 'select'} -->
			<select name="{$fields.textFields}"  {if $fields.will_choose}datatype="*"{/if} >
			<option value="" selected="selected">请选择..</option>
			<!-- {foreach from=$fields.selectList item=selectList} -->
			<option value="{$selectList}" {if $fields.title_contents.{$fields.textFields} eq $selectList}selected="selected"{/if}>{$selectList}</option>
			<!-- {/foreach} -->
			</select>
		<!-- {elseif $fields.chooseForm eq 'radio'} -->
			<!-- {foreach from=$fields.radioCheckboxForm item=radio key=rc_k} -->
			<input name="{$fields.textFields}" type="radio" value="{$radio.radioCheckbox}" {if $fields.title_contents.{$fields.textFields} eq $radio.radioCheckbox} checked="checked"{/if} {if $fields.will_choose}datatype="*"{/if} />&nbsp;{$radio.radioCheckbox}
			<!-- {/foreach} -->
		<!-- {elseif $fields.chooseForm eq 'checkbox'} -->
			<!-- {foreach from=$fields.radioCheckboxForm item=checkbox key=rc_k} -->
			<label><input name="{$fields.textFields}" type="checkbox" value="{$radio.radioCheckbox}"  {if $fields.title_contents.{$fields.textFields} eq $checkbox.radioCheckbox}checked="checked"{/if} {if $fields.will_choose}datatype="*"{/if} />&nbsp;{$checkbox.radioCheckbox}</label>
			<!-- {/foreach} -->
		<!-- {/if} -->
	</div>
	<!-- {/foreach} -->
	<div class="form-group form-group-text">
		<label class="control-label">
			<span>主营类目：</span>
        </label>
        <select name="ec_shop_categoryMain" id="shop_categoryMain_id">
            <option value="0">请选择..</option>
            <!-- {foreach from=$title.first_cate item=cate} -->
            <option value="{$cate.cat_id}" {if $title.parentType.shop_categoryMain eq $cate.cat_id}selected="selected"{/if}>{$cate.cat_name}</option>
            <!-- {/foreach} -->
        </select>
	</div>

    <div class="form-group form-group-text">
		<div>
			<span class="heading">
				<a class="btn toggle_category">添加详细类目</a>
			</span>
		</div>
	</div>

    <div class="form-group form-group-text choose-category hide">
        <div class="form-group form-group-text">
            <label class="control-label">一级类目：</label>
            <div class="controls">
                <select name="parent_name" class="parent_list" data-url="{url path='user/user_merchant/get_cat_name'}">
                    <option value="0">请选择..</option>
                    <!-- {foreach from=$title.first_cate item=cate} -->
                    <option value="{$cate.cat_id}">{$cate.cat_name}</option>
                    <!-- {/foreach} -->
                </select>
            </div>
        </div>

        <div class="form-group form-group-text">
            <label class="control-label">{t}二级类目：{/t}</label>
            <div class="controls cat_list l_h30">
                请选择一级类目..
            </div>
        </div>

        <div class="form-group form-group-text">
            <div class="controls">
                <a class="btn addDetailCategoryBtn" data-url="{url path='user/user_merchant/addChildCate_checked'}">添加</a>
            </div>
        </div>
    </div>

    <div class="form-group form-group-text">
		<p>对应类目行业资质<label class="help-block">请准确填写行业资质（至少一项必填），资质不全将无法通过审核，查看<a class="link-blue" target="_blank" href="#">《商创行业资质标准》</a></label></p>
	</div>

    <div class="form-group form-group-text cat_content">
        <div class="form-group form-group-text">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>序号</th>
                    <th>一级类目</th>
                    <th>二级类目</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <!-- {foreach from=$category_info item=category key=k} -->
                <tr>
                    <td>
                        <span class="index">{$k}</span>
                        <input type="hidden" value="{$category.cat_id}" name="cat_id[]" class="cId">
                    </td>
                    <td>
                        <input type="hidden" value="{$category.parent_name}" name="parent_name[]" class="cl1Name">
                        {$category.parent_name}
                    </td>
                    <td>
                        <input type="hidden" value="{$category.cat_name}" name="cat_name[]" class="cl2Name">
                        {$category.cat_name}
                    </td>
                    <td align="center">
                        <a class="ecjiafc-red removeCategoryBtn" data-url='{url path="user/user_merchant/deleteChildCate_checked" args="ct_id={$category.ct_id}"}'>删除</a>
                    </td>
                </tr>
                <!-- {foreachelse} -->
                <tr>
                    <td class="dataTables_empty" colspan="4">{t}没有找到任何记录!{/t}</td>
                </tr>
                <!-- {/foreach} -->
                </tbody>
            </table>
        </div>

        <!--申请店铺信息-->
        <!-- {foreach from=$permanent_list item=permanent key=pk} -->
        <div class="form-group form-group-text">
            <label class="input">
                <p>资质名称：{$permanent.dt_title}<input type="hidden" value="{$permanent.dt_id}" name="permanent_title_{$permanent.cat_id}[]"></p>

            </label>
        </div>
        <div class="form-group form-group-text">
            <label class="input">
                <p>电子版：</p>
                <div class="reimg">{$permanent.permanent_file}</div>
                <input type="file" name="permanentFile_{$permanent.cat_id}[]"/>
            </label>
        </div>
        <div class="form-group form-group-text">
            <label class="input">
                <p>到期日：</p>
                <input id="categoryId_date_{$permanent.dt_id}" type="date" {if $permanent.cate_title_permanent}readonly = "true"{/if} value="{$permanent.permanent_date}" name="categoryId_date_{$permanent.cat_id}[{$pk}]">
                <input class="hide" type="checkbox" id="categoryId_permanent_{$permanent.dt_id}" {if $permanent.cate_title_permanent}checked{/if} value="1" name="categoryId_permanent_{$permanent.cat_id}[{$pk}]" onClick="get_categoryId_permanent(this, '{$permanent.permanent_date}', {$permanent.dt_id})">
            </label>
        </div>
        <!-- {/foreach} -->
    </div>
