<?php 
/*
Name: 优惠活动模板
Description: 优惠活动页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.goods.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<!-- {if $favourable_list} 优惠活动 -->
<!-- {foreach from=$favourable_list item=favourable} -->
<form class="ecjia-form" action="{url path='cart/index/add_favourable' args="act_id={$favourable.act_id}"}" method="post">
	<div class="ecjia-margin-b">
		<ul class="ecjia-list ecjia-favourable-list ecjia-margin-t">
			<li>{$favourable.act_name}</li>
			<li><span>{$lang.favourable_range}</span><span class="ecjiaf-fr">{$lang.far_ext[$favourable.act_range]}{$favourable.act_range_desc}</span></li>
			<li>{$lang.favourable_amount}<span class="ecjiaf-fr">{$favourable.formated_min_amount} - {$favourable.formated_max_amount}</span></li>
			<li><span class="ecjia-margin-b">{$lang.favourable_type}<span class="ecjiaf-fr">{$favourable.act_type_desc}</span></span>
				<!-- {if $favourable.act_type eq 0} -->
				<!-- {foreach from=$favourable.gift item=gift} -->
				<div class="ecjia-favourable-color-two">
					<labal for="check{$gift.id}">
						<input class="checkbox" data-trigger="checkbox" type="checkbox" value="{$gift.id}" name="gift[]" id="check{$gift.id}"/>
					</labal>
					<span>
						<a href="{url path='goods/index/init' args="id={$gift.id}"}">{$gift.name}</a>
					</span>
					<span class="ecjia-favourable-color">[{$gift.formated_price}]</span>
				</div>
				<!-- {/foreach} -->
				<!-- {/if} -->
			</li>
			<!-- {if $favourable.available} -->
			<li>
				<input class="btn btn-info cart-favourable-btn ecjia-margin-b" type="submit" value="{$lang.add_to_cart}" />
			</li>
			<!-- {/if} -->
		</ul>
	</div>
	<input name="act_id" type="hidden" value="{$favourable.act_id}" />
	<input name="step" type="hidden" value="add_favourable" />
</form>
<!-- {/foreach} 循环赠品活动结束 -->
<!-- {/if} -->
<!-- {/block} -->