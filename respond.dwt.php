<?php 
/*
Name: 响应模板
Description: 这是响应页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.goods.init();</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<header class="ecjia-header">
	<a class="ecjia-header-icon" href="javascript:history.go(-1)"><i class="glyphicon glyphicon-menu-left"></i></a>
	<p>{$title}</p>
</header>
<div class="respond_div">
	<p>{$message}</p>
	<!--{if $virtual_card}-->
	<div class="alert alert-warning" role="alert">
		<!--{foreach from=$virtual_card item=vgoods}-->
		<h3 class="respond_h3">{$vgoods.goods_name}</h3>
		<!--{foreach from=$vgoods.info item=card}-->
		<ul class="respond_ul">
			<!--{if $card.card_sn}-->
			<li class="respond_li_two"> <strong>{$lang.card_sn}:</strong>
				<span class="respond_span">{$card.card_sn}</span>
			</li>
			<!--{/if}-->
			<!--{if $card.card_password}-->
			<li class="respond_li"> <strong>{$lang.card_password}:</strong>
				<span class="respond_span">{$card.card_password}</span>
			</li>
			<!--{/if}-->
			<!--{if $card.end_date}-->
			<li class="repond_li_two">
				<strong>{$lang.end_date}:</strong>
				{$card.end_date}
			</li>
			<!--{/if}-->
		</ul>
		<!--{/foreach}-->
		<!--{/foreach}-->
	</div>
	<!-- {/if} -->
	<div>
		<span class="p-link">
			<a href="{$shop_url}">{$lang.back_home}</a>
		</span>
	</div>
	<div class="respond_div_two">{foreach from=$lang.p_y item=pv}{$pv}{/foreach}</div>
</div>
<!-- {/block} -->