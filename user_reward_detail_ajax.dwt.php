<?php
/*
Name: 奖励明细
Description: 奖励明细
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
    <!--{foreach from=$data item=record}-->
    <!--<li>
        <span class="record-label">{$record.label_reward_type}</span>
		<span class="icon-price-red ecjiaf-fr">{$record.give_reward}</span>
        <span class="record-time">{$record.reward_time}</span>
    </li>-->
    <li class="reward-item ecjia-margin-t ecjia-reward-list">
        <div class="reward-hd">
            {t domain="h5"}注册时间{/t}&nbsp;{$record.reward_time}
        </div>
        <div class="flow-goods-list">
            <a class="ecjiaf-db">
                <ul class="goods-item" style="padding: 0;">
                    <li class="goods-img">
                        <img class="ecjiaf-fl" style="border: none; border-radius: 2.5em;" src="{if $record.avatar_img}{$record.avatar_img}{else}{$theme_url}images/default_user.png{/if}" />
                        <div class="goods-right">
                            <div class="goods-name">{$record.invitee_name}</div>
                            <p class="block">{$record.invitee_mobile}</p>
                        </div>
                    </li>
                </ul>
            </a>
        </div>

        <div class="reward-ft">
            <em class="ecjiaf-fr ecjia-color-red">{$record.give_reward}</em>
        </div>

    </li>
   	<!-- {foreachelse} -->
	<div class="ecjia-nolist">
		<div class="img-noreward">{t domain="h5"}暂无奖励{/t}</div>
	</div>
    <!-- {/foreach} -->
<!-- {/block} -->
{/nocache}