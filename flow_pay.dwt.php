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
        <ul class="ecjia-list ecjia-margin-t">
            <!-- {foreach from=$payment_list item=rs} -->
            <label class="select-item" for="{$rs.pay_code}">
                <li>
                    <span class="slect-title">{$rs.pay_name}</span>
                    <span class="ecjiaf-fr">
                        <input type="radio" id="{$rs.pay_code}" name="payment" value="{$rs.pay_id}">
                        <label for="{$rs.pay_code}"></label>
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
