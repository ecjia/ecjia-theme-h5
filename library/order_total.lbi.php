<?php 
/*
Name: 订单合计
Description: 这是给结算页面使用的订单合计模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="text-right" id="total_number">
<ul class="ecjia-list text-right">

      <!-- {if ecjia::config('use_integral')} 是否使用积分--> 
      <li>获得积分：<span class="cart-order-color">{$total.will_get_integral}积分</span></li>
      <!-- {/if} -->

      <!-- {if ecjia::config('use_bonus') && $total.will_get_bonus gt 0} 是否使用红包--> 
      <li>获得{$lang.bonus}：<span class="cart-order-color">{$total.will_get_bonus}{$lang.bonus}</span></li>
      <!-- {/if} -->

      <li>{$lang.goods_all_price}: <span class="cart-order-color">{$total.goods_price_formated}</span></li>

      <!-- {if $total.discount gt 0} 折扣 --> 
      <li>{$lang.discount}:<span class="cart-order-color">{$total.discount_formated}</span></li>
      <!-- {/if} -->

      <!-- {if $total.tax gt 0} 税 --> 
      <li>{$lang.tax}:<span class="cart-order-color">{$total.tax_formated}</span></li>
      <!-- {/if} --> 

      <!-- {if $total.shipping_fee > 0} 配送费用 --> 
      <li>{$lang.shipping_fee}:<span class="cart-order-color">{$total.shipping_fee_formated}</span></li>
      <!-- {/if} --> 

      <!-- {if $total.shipping_insure > 0} 保价费用 --> 
      <li>{$lang.insure_fee}:<span class="cart-order-color">{$total.shipping_insure_formated}</span></li>
      <!-- {/if} --> 

      <!-- {if $total.pay_fee > 0} 支付费用 --> 
      <li>{$lang.pay_fee}:<span class="cart-order-color">{$total.pay_fee_formated}</span></li>
      <!-- {/if} --> 

      <!-- {if $total.pack_fee > 0} 包装费用--> 
      <li>{$lang.pack_fee}:<span class="cart-order-color">{$total.pack_fee_formated}</span></li>
      <!-- {/if} --> 

      <!-- {if $total.card_fee > 0} 贺卡费用--> 
      <li>{$lang.card_fee}:<span class="cart-order-color">{$total.card_fee_formated}</span></li>
      <!-- {/if} --> 

      <!-- {if $total.surplus > 0 or $total.integral > 0 or $total.bonus > 0} 使用余额或积分或红包 --> 
      <!-- {if $total.surplus > 0} 使用余额 --> 
      <li> {$lang.use_surplus}:<span class="cart-order-color">{$total.surplus_formated}</span></li>
      <!-- {/if} --> 

      <!-- {if $total.integral > 0} 使用积分 --> 
      <li>  {$lang.use_integral}:<span class="cart-order-color">{$total.integral_formated}</span></li>
      <!-- {/if} --> 

      <!-- {if $total.bonus > 0} 使用红包 --> 
      <li> {$lang.use_bonus}:<span class="cart-order-color">{$total.bonus_formated}</span></li>
      <!-- {/if} --> 
      <!-- {/if} 使用余额或积分或红包 --> 

      <li>{$lang.total_fee}: <span class="cart-order-color">{$total.amount_formated}</span></li>
      
      <!-- {if $is_group_buy} -->
      <li>{$lang.notice_gb_order_amount}</li>
      <!-- {/if}  -->

      <!--{if $total.exchange_integral }消耗积分--> 
      <li>{$lang.notice_eg_integral}<span class="cart-order-color">{$total.exchange_integral}</span></li>
      <!--{/if}--> 
</ul>
</div>