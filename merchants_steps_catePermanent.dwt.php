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
        <input class="datePicker" id="categoryId_date_{$permanent.dt_id}" type="text" {if $permanent.cate_title_permanent}readonly = "true"{/if} value="{$permanent.permanent_date}" name="categoryId_date_{$permanent.cat_id}[{$pk}]">
        <input class="hide" type="checkbox" id="categoryId_permanent_{$permanent.dt_id}" {if $permanent.cate_title_permanent}checked{/if} value="1" name="categoryId_permanent_{$permanent.cat_id}[{$pk}]" onClick="get_categoryId_permanent(this, '{$permanent.permanent_date}', {$permanent.dt_id})">
    </label>
</div>
<!-- {/foreach} -->