<?php
/*
Name: 获取购物车内的相关配件模板
Description: 获取购物车内的相关配件页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
	<script type="text/javascript">
		ecjia.touch.goods.add_quick();
	</script>
<!-- {/block} -->

<!-- {block name="ecjia"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<section class="ect-pro-list flow-pic ect-border-bottom0">
	<ul class="ecjia-list ecjia-fitting-list" id="J_ItemList">
		<!-- {foreach from=$fitting item=fittings} -->
			<li>
				<!-- 产品配件 start-->
				<div class="ecjiaf-fl">
					<a href="{$fittings.url}" >
						<img src="{$fittings.goods_thumb}">
					</a>
				</div>
				<div class="ecjiaf-fl ecjia-margin-l goods-fitting">
					<p class="ecjia-margin-b"><a href="{$fittings.url}">{$fittings.goods_name}</a></p>
					<p class="ecjia-margin-t ecjia-margin-b"><span class="fitting-color-two">{$lang.fittings_price} </span><span class="fitting-color">{$fittings.fittings_price}</span></p>
					<p class="ecjia-margin-t fitting-btn">
						<a class="btn-info btn addToCart_quick" data-url="{url path='cart/index/add_to_cart'}" data-id="{$fittings.goods_id}" data-parent="{$fittings.parent_id}" href="javascript:;">
							{$lang.btn_add_to_cart}
						</a>
					</p>
				</div>
				<!-- 产品配件end-->
			</li>
		<!-- {/foreach} -->
	</ul>
</section>


<div class="alert-goods-attribute">
	<div class="alert-goods-attribute-shade"></div>
	<div class="hd">
	</div>
	<form action="{url path='cart/index/add_to_cart'}" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY" >
		<div class="bd"></div>
		<div class="ft">
			<a class="btn btn-info" data-toggle="addToCart" data-id="0" data-parentid="0" data-url="{url path='cart/index/add_to_cart'}">{t}确定{/t}</a>
		</div>
	</form>
</div>


  <!-- {/block} -->
