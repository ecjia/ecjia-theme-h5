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
        <h3 class="select-title"></h3>
        <ul class="ecjia-list">
            <!-- {foreach from=$shipping_list item=rs} -->
            <label class="select-item" for="shipping_{$rs.shipping_code}">
                <li>
                    <span class="slect-title">{$rs.shipping_name}</span>
                    <span class="ecjiaf-fr">
                        <input type="radio" id="shipping_{$rs.shipping_code}" name="shipping" value="{$rs.shipping_id}">
                        <label for="shipping_{$rs.shipping_code}"></label>
                    </span>
                </li>
            </label>
            <!-- {/foreach} -->
        </ul>
        <div class="ecjia-margin-t ecjia-margin-b">
            <a class="btn btn-info" href="#">确定</a>
        </div>
    </div>
<!-- {/block} -->
