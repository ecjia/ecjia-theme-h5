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
    <div class="ecjia-select ecjia-margin-t ecjia-flow-invoice">
        <span class="select-title ecjia-margin-l">发票抬头</span>
        <div class="input ecjia-margin-b">
            <input type="text" name="name" value="" placeholder="您本次最多可以使用3个积分">
        </div>
        <span class="select-title ecjia-margin-l">发票内容</span>
        <ul class="ecjia-list ecjia-margin-b">
            <label class="select-item" for="{$rs.pay_code}">
                <li>
                    <span class="slect-title">11{$rs.pay_name}</span>
                    <span class="ecjiaf-fr">
                        <input type="radio" id="{$rs.pay_code}" name="payment" value="{$rs.pay_id}" {if $smarty.get.pay_id eq $rs.pay_id}checked="true"{/if}>
                        <label for="{$rs.pay_code}"></label>
                    </span>
                </li>
            </label>
            <label class="select-item" for="{$rs.pay_code}">
                <li>
                    <span class="slect-title">11{$rs.pay_name}</span>
                    <span class="ecjiaf-fr">
                        <input type="radio" id="{$rs.pay_code}" name="payment" value="{$rs.pay_id}" {if $smarty.get.pay_id eq $rs.pay_id}checked="true"{/if}>
                        <label for="{$rs.pay_code}"></label>
                    </span>
                </li>
            </label>
        </ul>
        <span class="select-title ecjia-margin-l">发票类型</span>
        <ul class="ecjia-list">
            <label class="select-item" for="{$rs.pay_code}">
                <li>
                    <span class="slect-title">{$rs.pay_name}</span>
                    <span class="ecjiaf-fr">
                        <input type="radio" id="{$rs.pay_code}" name="payment" value="{$rs.pay_id}" {if $smarty.get.pay_id eq $rs.pay_id}checked="true"{/if}>
                        <label for="{$rs.pay_code}"></label>
                    </span>
                </li>
            </label>
            <label class="select-item" for="{$rs.pay_code}">
                <li>
                    <span class="slect-title">11{$rs.pay_name}</span>
                    <span class="ecjiaf-fr">
                        <input type="radio" id="{$rs.pay_code}" name="payment" value="{$rs.pay_id}" {if $smarty.get.pay_id eq $rs.pay_id}checked="true"{/if}>
                        <label for="{$rs.pay_code}"></label>
                    </span>
                </li>
            </label>
        </ul>
        <div class="ecjia-margin-t ecjia-margin-b two-btn">
            <a class="btn btn-hollow-danger" href="#">清空</a>
            <a class="btn btn-info" href="#">确定</a>
        </div>
    </div>
<!-- {/block} -->
