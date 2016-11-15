<?php 
/*
Name: 获取配送地址列表模板
Description: 获取配送地址列表首页
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

<div class="flow-consignee-list">
	<section>
		<ul class="ecjia-list user-address-list" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='async_addres_list'}" data-size="10">
				<!-- 配送地址 start-->
				<!-- 配送地址 end-->
		</ul>
	</section>
</div>
<div class="ecjia-margin-t ecjia-margin-b">
	<a class="btn btn-info flow-consignee-add" href="{url path='flow/consignee'}" type="botton">{$lang.add_address}</a>
</div>

<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
	<!-- 配送地址 start--> 
	<!-- {foreach from=$addres_list item=value} 循环地址列表 -->
	<li class=" checkout-add single_item ">
		<div class="consignee">
			<a href="{$value.url}">
				<div>
					<p class="ecjiaf-fl">{$value.consignee}</p>
					<p class="ecjiaf-fl ecjia-margin-l ecjia-address-mobile">{$value.mobile}</p>
					<!-- {if $value.address_id eq $value.a_id} -->
					<p class="ecjiaf-fl ecjia-margin-l">{t}默认{/t}</p>
					<!-- {/if} -->
				</div>
				<div class="ecjia-margin-t address ecjiaf-wwb">{$value.address}</div>	
				<a href="{$value.url}"><i class="iconfont icon-bianji"></i></a>
				<a class="nopjax" href="{url path='user_address/del_address_list' args="id={$value.address_id}"}"><i class="iconfont icon-delete"></i></a>
			</a>
		</div> 
	</li>
	<!-- {/foreach} -->
	<!-- 配送地址end--> 
<!-- {/block} -->