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
    <div class="ecjia-select">
        <span class="select-title ecjia-margin-l">备注留言</span>
        <div class="input">
            <textarea name="name"></textarea>
        </div>
        <div class="ecjia-margin-t ecjia-margin-b">
            <a class="btn btn-info" href="#">确定</a>
        </div>
    </div>
<!-- {/block} -->
