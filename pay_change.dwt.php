<?php
/*
Name: ����֧����ʽҳ��
Description: 
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript" >
    ecjia.touch.flow.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->

<form class="ecjia-form" name="payForm" action="{url path='pay/index/pay_order'}" method="post">
    <div class="ecjia-flow-done ecjia-pay">
        <p class="ecjia-payment-notice">��ǰ������֧��ԭ��֧����ʽ�����л��µ�֧����ʽ����֧����</p>


        <ul class="ecjia-list ecjia-margin-t">
            <li>������<span class="ecjiaf-fr">{$detail.formated_total_fee}</span></li>
            <li>֧����ʽ��<span class="ecjiaf-fr flow-msg">{$detail.pay_name}</span></li>
        </ul>
        
        {if $payment_list}
            <ul class="ecjia-list ecjia-margin-t">
                <li>
                    ����֧����ʽ <span class="ecjiaf-fr"></span>
                </li>
            </ul>

            <ul class="ecjia-list list-short payment-list">
            <!-- {foreach from=$payment_list item=list} -->
                <li>
                    <span class="icon-name {$list.pay_code}" data-code="{$list.pay_code}">
                        <label class="ecjiaf-fr ecjia-check">
                            <input type="radio" id="{$list.pay_id}" name="pay_id" value="{$list.pay_id}"{if $list.checked}checked="true"{/if} >
                        </label>
                        {$list.pay_name}
                    </span>
                </li>
            <!-- {/foreach} -->
            </ul>
        {/if}

        <div class="ecjia-margin-t ecjia-margin-b">
            <input name="order_id" type="hidden" value="{$detail.order_id}" />
            <input class="btn btn-recharge confirm-payment" name="submit" type="submit" value="{t}ȷ��֧��{/t}" />
        </div>
    </div>
</form>
<!-- {/block} -->
{/nocache}