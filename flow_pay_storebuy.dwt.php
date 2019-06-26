<?php
/*
Name: 选择支付方式
Description: 选择支付方式模版
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
<form id="theForm" name="theForm" action='{url path="cart/flow/storebuy_checkout" args="{if $smarty.session.order_address_temp.store_id}store_id={$smarty.session.order_address_temp.store_id}&{/if}rec_id={$rec_id}"}' method="post">
    <div class="ecjia-select">
    	<div class="ecjia-select-white">
    		{if $payment_list.online || $payment_list.offline}
	        <p class="select-title ecjia-margin-l"><span class="icon-pay-title"></span>{t domain="h5"}支付方式{/t}</p>
	        <ul class="ecjia-list">
	        
	        	<!-- {if $payment_list.online} -->
	            <label class="select-item">
	                <li class="select-item-li">
	                	<!-- {foreach from=$payment_list.online item=rs} -->
	                    <span class="select-pay-title {if $temp.pay_id eq $rs.pay_id}active{/if}" data-payment="{$rs.pay_id}">{$rs.pay_name}</span>
	                    <!-- {/foreach} -->
	                </li>
	            </label>
	            <!-- {/if} -->
	            
	            <!-- {if $payment_list.offline} -->
	            <label class="select-item">
	                <li class="select-item-li">
	                	<!-- {foreach from=$payment_list.offline item=rs} -->
	                    <span class="select-pay-title {if $temp.pay_id eq $rs.pay_id}active{/if}" data-payment="{$rs.pay_id}">{$rs.pay_name}</span>
	                    <!-- {/foreach} -->
	                </li>
	            </label>
	            <!-- {/if} -->
	        </ul>
	        {/if}
        </div>
        
        <div class="ecjia-margin-t ecjia-margin-b">
            <input type="hidden" name="rec_id" value="{$rec_id}" />
            <input type="hidden" name="payment" value="{$temp.pay_id}">
			<input class="btn btn-info" name="payment_pickup_update" type="submit" value='{t domain="h5"}确定{/t}' />
        </div>
    </div>
</form>
<!-- {/block} -->
{/nocache}