<?php
/*
Name: 选择支付方式
Description: 选择支付方式模板
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>

<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->

<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<form id="theForm" name="theForm" action="{url path='cart/flow/checkout'}" method="post">
    <div class="ecjia-select ecjia-margin-t">
        <span class="select-title ecjia-margin-l">备注内容</span>
        <div class="input">
            <textarea name="note">{$note}</textarea>
        </div>
        <div class="ecjia-margin-t ecjia-margin-b">
            <input type="hidden" name="address_id" value="{$address_id}">
            <input type="hidden" name="rec_id" value="{$rec_id}" />
			<input class="btn btn-info" name="note_update" type="submit" value="确定"/>
        </div>
    </div>
</form>
<!-- {/block} -->
