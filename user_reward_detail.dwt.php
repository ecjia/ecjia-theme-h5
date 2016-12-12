<?php
/*
Name: 奖励明细
Description: 奖励明细
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.spread.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->

<div class="ecjia-spread">
    <div class="reward-detail">
        <div class="swiper-container swiper-3">
            <div class="swiper-wrapper">
            <!--{foreach from=$month item=date}-->
                <div class="swiper-slide">
                    <span data-date="{$date.invite_data}">{$date.label_invite_data}</span>
                    <img src="./images/wallet/240x240.png">
                </div>
            <!--{/foreach}-->
            </div>
            <input type="hidden" value="{RC_Uri::url('user/user_bonus/reward_detail')}&type=async" name="reward_url"/>
        </div>
    </div>
</div>  
  
<div class="ecjia-spread-detail">
    <ul class="ecjia-list list-short" >
    {if $invite_record}
        <!--{foreach from=$invite_record item=record}-->
            <li>
		         <span class="record-label">{$record.label_reward_type}</span>
		         <span class="icon-price-red ecjiaf-fr">{$record.give_reward}</span>
		         <span class="record-time">{$record.reward_time}</span>
		    </li>
        <!-- {/foreach} -->
    {else}
        <div class="ecjia-nolist">
			<div class="img-noreward"></div>
			<p>{t}暂无奖励{/t}</p>
		</div>
    
    {/if}
	</ul>
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
    

<!-- {/block} -->
