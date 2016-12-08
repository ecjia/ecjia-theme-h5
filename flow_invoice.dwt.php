<?php
/*
Name: 使用积分
Description: 使用积分模板
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>

<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->

<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<form id="theForm" name="theForm" action="{url path='cart/flow/checkout'}" method="post">
    <div class="ecjia-select ecjia-margin-t ecjia-flow-invoice">
        <span class="select-title ecjia-margin-l">发票抬头</span>
        <div class="input ecjia-margin-b">
            <input type="text" name="inv_payee" value="{$temp.inv_payee}" placeholder="请输入发票抬头，如:个人">
        </div>
        <span class="select-title ecjia-margin-l">发票内容</span>
        <ul class="ecjia-list ecjia-margin-b">
            <!-- {foreach from=$inv_content_list item=list} -->
            <label class="select-item" for="content-{$list.id}">
                <li>
                    <span class="slect-title">{$list.value}</span>
                    <span class="ecjiaf-fr">
                        <input type="radio" name="inv_content" id="content-{$list.id}" value="{$list.value}" {if $temp.inv_content eq $list.value}checked="true"{/if}>
                        <label for="content-{$list.id}"></label>
                    </span>
                </li>
            </label>
            <!-- {foreachelse} -->
            <li>暂无</li>
            <!-- {/foreach} -->
        </ul>
        <span class="select-title ecjia-margin-l">发票类型</span>
        <ul class="ecjia-list">
            <!-- {foreach from=$inv_type_list item=list} -->
            <label class="select-item" for="type-{$list.id}">
                <li>
                    <span class="slect-title">{$list.value}</span>
                    <span class="ecjiaf-fr">
                        <input type="radio" name="inv_type" id="type-{$list.id}" value="{$list.label_value}" {if $temp.inv_type eq $list.label_value}checked="true"{/if}>
                        <label for="type-{$list.id}"></label>
                    </span>
                </li>
            </label>
            <!-- {foreachelse} -->
            <li>暂无</li>
            <!-- {/foreach} -->
        </ul>
        <div class="ecjia-margin-t ecjia-margin-b two-btn">
            <input type="hidden" name="address_id" value="{$address_id}">
            <input type="hidden" name="rec_id" value="{$rec_id}" />
            <input class="btn btn-hollow-danger" name="inv_clear" type="submit" value="清空"/>
            <input class="btn btn-info" name="inv_update" type="submit" value="确定"/>
        </div>
    </div>
</form>
<!-- {/block} -->
