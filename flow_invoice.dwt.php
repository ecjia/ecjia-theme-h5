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
    <div class="ecjia-select ecjia-margin-t">
        <span class="select-title ecjia-margin-l">您总共有1000个积分</span>
        <div class="input">
            <input type="text" name="name" value="" placeholder="您本次最多可以使用3个积分">
        </div>
        <div class="ecjia-margin-t ecjia-margin-b">
            <a class="btn btn-info" href="#">确定</a>
        </div>
    </div>
<!-- {/block} -->
