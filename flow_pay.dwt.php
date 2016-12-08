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
<!-- #EndLibraryItem -->
<form id="theForm" name="theForm" action='{url path="cart/flow/checkout" args="address_id={$address_id}&rec_id={$rec_id}"}' method="post">
    <div class="ecjia-select">
        <ul class="ecjia-list ecjia-margin-t">
            <!-- {foreach from=$payment_list item=rs} -->
            <label class="select-item" for="{$rs.pay_code}">
                <li>
                    <span class="slect-title">{$rs.pay_name}</span>
                    <span class="ecjiaf-fr">
                        <input type="radio" id="{$rs.pay_code}" name="payment" value="{$rs.pay_id}" {if $smarty.get.pay_id eq $rs.pay_id}checked="true"{/if}>
                        <label for="{$rs.pay_code}"></label>
                    </span>
                </li>
            </label>
            <!-- {/foreach} -->
        </ul>
        
        <div class="ecjia-margin-t ecjia-margin-b">
            <input type="hidden" name="address_id" value="{$address_id}">
            <input type="hidden" name="rec_id" value="{$rec_id}" />
			<input class="btn btn-info" name="payment_update" type="submit" value="确定"/>
        </div>
    </div>
</form>
    
<!-- {/block} -->
