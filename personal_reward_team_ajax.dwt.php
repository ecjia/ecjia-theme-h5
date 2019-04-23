<?php
/*
Name: 团队列表
Description: 团队列表
Libraries: model_bar
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
<!-- {if $list} -->
<!-- {foreach from=$list item=val} 循环商品 -->
<li class="team-item-li">
	<div class="team-img">
		<img class="ecjiaf-fl" src="{if $val.avatar_img}{$val.avatar_img}{else}{$theme_url}images/default_user.png{/if}" />
	</div>
	<div class="team-right">
		<div class="name">{$val.user_name}</div>
		<p class="block">{t domain="h5"}加入时间：{/t}{$val.formatted_reg_time}</p>
	</div>
</li>
<!-- {/foreach} -->
<!-- {else} -->
<div class="ecjia-mod search-no-pro">
	<div class="ecjia-nolist">
		<p><img src="{$theme_url}images/wallet/null280.png"></p>
		{t domain="h5"}暂无团队成员{/t}
	</div>
</div>
<!-- {/if} -->
<!-- {/block} -->

{/nocache}