<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="form-group form-group-text">
    <a class="btn select_brand_info">查看已有品牌</a>
    <label class="help-block">{$title.titles_annotation}</label>
</div>

<!--申请品牌信息-->
<div class="brand_list hide">
    <div class="form-group form-group-text">
        <table class="table table-striped smpl_tbl dataTable table-hide-edit">
            <thead>
            <tr>
                <th>序号</th>
                <th>名称</th>
                <th class="w80">LOGO</th>
                <!--					<th>类型</th>-->
                <!--					<th>经营类型</th>-->
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <!-- {foreach from=$title.brand_list item=brand key=key}	 -->
            <tr id="brand_{$brand.bid}">
                <td>{$key}</td>
                <td>{$brand.brandName}</td>
                <td align="center">{if $brand.brandLogo neq ''}<img style="width: 80px;" src="{$brand.brandLogo}" alt="图片预览">{/if}</td>
                <!--					<td>{if $brand.brandType eq 1}国内品牌{elseif $brand.brandType eq 2}国际品牌{/if}</td>-->
                <!--					<td>{if $brand.brand_operateType eq 1}自有品牌{elseif $brand.brand_operateType eq 2}代理品牌{/if}</td>-->
                <td>
                    <a class="ecjia-margin-r" href=""><i class="iconfont icon-edit ecjia-fz-big"></i></a>
                    <a class="deleteBrand" data-url="{url path='user/user_merchant/deleteBrand' args="bid={$brand.bid}"}"><i class="iconfont icon-delete ecjia-fz-big"></i></a>
                </td>
            </tr>
            <!-- {foreachelse} -->
            <tr>
                <td class="dataTables_empty" colspan="8">{t}没有找到任何记录!{/t}</td>
            </tr>
            <!-- {/foreach} -->
            </tbody>
        </table>
    </div>
    <!-- {if $title.brand_list}-->
    <div class="ecjia-margin-t">
        <a class="btn" href="{url path='user/user_merchant/init' args="step={$step}&pid_key={$pid_key}"}">使用已有品牌</a>
        <label class="help-block">{$title.titles_annotation}</label>
    </div>
    <!-- {/if}-->
</div>

<div class="form-group form-group-text">
    <div>
        <p class="heading">
            新品牌信息
        </p>
    </div>
    <div class="form-group form-group-text">
        <label class="input">
        <p>品牌中文名：</p>
            <input type="text" name="ec_brandName"/>
        </label>
    </div>
    <div class="form-group form-group-text">
        <label class="input">
            <p>品牌英文名：</p>
            <input type="text" name="ec_bank_name_letter"/>
        </label>
    </div>
    <div class="form-group form-group-text">
        <label class="input">
            <p>品牌首字母：</p>
            <input type="text" name="ec_brandFirstChar"/>
        </label>
    </div>

    <div class="form-group form-group-text">
        <label class="input">
            <p>品牌LOGO：</p>
            <div class="reimg"></div>
            <input type="file" name="ec_brandLogo"/>
        </label>
    </div>

    <div class="form-group form-group-text">
        <label>
            <p>品牌类型：</p>
            <select name="ec_brandType">
                <option {if $title.parentType.brandType eq 0}selected="selected"{/if} value="0">请选择..</option>
                <option {if $title.parentType.brandType eq 1}selected="selected"{/if} value="1">国内品牌</option>
                <option {if $title.parentType.brandType eq 2}selected="selected"{/if} value="2">国际品牌</option>
            </select>
         </label>
    </div>
    <div class="form-group form-group-text">
        <label class="control-label">经营类型：</label>
        <div class="controls">
            <select name="ec_brand_operateType">
                <option {if $title.parentType.brand_operateType eq 0}selected="selected"{/if} value="0">请选择..</option>
                <option {if $title.parentType.brand_operateType eq 1}selected="selected"{/if} value="1">自有品牌</option>
                <option {if $title.parentType.brand_operateType eq 2}selected="selected"{/if} value="2">代理品牌</option>
            </select>
        </div>
    </div>
    <div class="form-group form-group-text">
        <label class="control-label">品牌使用期限：</label>
        <div class="controls">
            <input type="date" name="ec_brandEndTime" value="{$title.parentType.brandEndTime}" class="input jdate narrow" id="ec_brandEndTime">
<!--            <label><input type="checkbox" name="ec_brandEndTime_permanent" value="1" id="brandEndTime_permanent" {if $title.parentType.brandEndTime_permanent}checked{/if}> 永久</label>-->
            <input name="ec_shop_bid" type="hidden" value="{$ec_shop_bid}">
        </div>
    </div>

    <div class="form-group form-group-text">
        <p class="heading">
            请上传以下品牌资质扫描件
            <label class="ecjia-fz-small">电子版须加盖彩色企业公章（即纸质版盖章，扫描或拍照上传），文字内容清晰可辨,支持jpg、gif和png图片，大小不超过4M</label>
        </p>
    </div>

    <div class="form-group form-group-text">
        <label class="input">
            <p>资质名称：</p>
            <input type="text" name="ec_qualificationNameInput[]" class="w130">
        </label>
    </div>
    <div class="form-group form-group-text">
        <label class="input">
            <p>资质电子版：</p>
            <input type="file" name='ec_qualificationImg[]' size="35"/>
        </label>
    </div>
    <div class="form-group form-group-text">
        <label class="input">
            <p>到期日：</p>
            <input type="text" name="ec_expiredDateInput[]">
<!--            <input type="checkbox" name="ec_expiredDate_permanent[]" value="1">永久-->
        </label>
    </div>
</div>


  <!-- {foreach from=$title.cententFields item=fields}  -->
	<div class="form-group form-group-text">
        <label class="control-label">{$fields.fieldsFormName}：</label>
        <!-- {if $fields.chooseForm eq 'input'} -->
            <input class="input" type="text" value="{$fields.title_contents.{$fields.textFields}}" size="{$fields.inputForm}" name="{$fields.textFields}"  {if $fields.will_choose}datatype="*"{/if}>
        <!-- {elseif $fields.chooseForm eq 'other'} -->
            <!-- {if $fields.otherForm eq 'textArea'} -->
           	<div class="controls">
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
            </div>
            <!-- {elseif $fields.otherForm eq 'dateFile'} -->
			<div class="controls fileupload {if $fields.title_contents.{$fields.textFields}}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
				<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
					{if $fields.title_contents.{$fields.textFields}}
					<img src="{$fields.title_contents.{$fields.textFields}}" alt="{t}图片预览{/t}"  {if $fields.will_choose}datatype="*"{/if} />
					{/if}
				</div>
				<span class="btn btn-file">
					<span class="fileupload-new">{t}浏览{/t}</span>
					<span class="fileupload-exists">{t}修改{/t}</span>
					<input type="file" name="{$fields.textFields}"/>
				</span>
				<a class="btn fileupload-exists" {if !$fields.title_contents.{$fields.textFields}}data-dismiss="fileupload" href="javascript:;"{else}data-toggle="ajaxremove" data-msg="{t}您确定要删除吗？{/t}" href='{url path="seller/admin/remove_basic_img" args="img={$fields.textFields}"}' title="{t}移除{/t}"{/if}>删除</a>
			</div>
            <!-- {elseif $fields.otherForm eq 'dateTime'} -->
            <div class="controls">
                <!-- {foreach from=$fields.dateTimeForm item=date key=dk} -->
                    <!-- {if $dk eq 0} -->
                    <input id="{$fields.textFields}_{$dk}" class="input jdate narrow" type="text" size="{$date.dateSize}" value="{$date.dateCentent}" name="{$fields.textFields}[]"  {if $fields.will_choose}datatype="*"{/if} >
                    <!-- {else} -->
                    - <input id="{$fields.textFields}_{$dk}" class="input jdate narrow" type="text" size="{$date.dateSize}" value="{$date.dateCentent}" name="{$fields.textFields}[]"  {if $fields.will_choose}datatype="*"{/if} >
                    <!-- {/if} -->
                <!-- {/foreach} -->
            </div>
            <!-- {/if} -->
        <!-- {elseif $fields.chooseForm eq 'textarea'} -->
        <div class="controls">
            <textarea name="{$fields.textFields}" cols="{$fields.cols}" rows="{$fields.rows}"  {if $fields.will_choose}datatype="*"{/if} >{$fields.title_contents.{$fields.textFields}}</textarea>
        </div>
        <!-- {elseif $fields.chooseForm eq 'select'} -->
       	<div class="controls">
            <select name="{$fields.textFields}"  {if $fields.will_choose}datatype="*"{/if} >
                <option value="" selected="selected">请选择..</option>
            <!-- {foreach from=$fields.selectList item=selectList} -->
                <option value="{$selectList}" {if $fields.title_contents.{$fields.textFields} eq $selectList}selected="selected"{/if}>{$selectList}</option>
            <!-- {/foreach} -->
            </select>
        </div>
        <!-- {elseif $fields.chooseForm eq 'radio'} -->
        	<div class="controls chk_radio">
                <!-- {foreach from=$fields.radioCheckboxForm item=radio key=rc_k} -->
            	<input name="{$fields.textFields}" type="radio" value="{$radio.radioCheckbox}" {if $fields.title_contents.{$fields.textFields} eq $radio.radioCheckbox} checked="checked"{/if}  {if $fields.will_choose}datatype="*"{/if} />&nbsp;{$radio.radioCheckbox}
            	<!-- {/foreach} -->
            </div>
        <!-- {elseif $fields.chooseForm eq 'checkbox'} -->
            <!-- {foreach from=$fields.radioCheckboxForm item=checkbox key=rc_k} -->
            <label><input name="{$fields.textFields}" type="checkbox" value="{$radio.radioCheckbox}"  {if $fields.title_contents.{$fields.textFields} eq $checkbox.radioCheckbox}checked="checked"{/if}  {if $fields.will_choose}datatype="*"{/if} />&nbsp;{$checkbox.radioCheckbox}</label>
            <!-- {/foreach} -->
        <!-- {/if} -->
    </div>
	<!-- {/foreach} -->