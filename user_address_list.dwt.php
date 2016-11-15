<?php 
/*
Name: 收货地址列表模板
Description: 收货地址列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<div class="flow-consignee-list">
	<section>
	<!-- {if $addres_list} -->
		<ul class="ecjia-list list-one user-address-list" id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='async_addres_list'}" data-size="10">			
			<!-- 配送地址 start--> 
			<!-- 配送地址end--> 
		</ul>
		<!-- {$page} -->
		<!-- {else} -->
		<div class="ecjia-nolist">
			<i class="iconfont icon-location"></i>
			<p class="address_list_font">{t}您还没有收货地址哦{/t}</p>
			<p class="address_list_font_two">{t}赶快来添加您的第一个收货地址吧{/t}</p>
		</div>
	<!-- {/if} -->
	</section>
</div>
<div class="ecjia-margin-t ecjia-margin-b">
	<a class="btn btn-info" href="{url path='user/user_address/add_address'}" type="botton">{$lang.add_address}</a>
</div>
<!-- {/block} -->
<!-- {block name="ajaxinfo"} -->
	<!-- 配送地址 start--> 
	<!-- {foreach from=$addres_list item=value} 循环地址列表 -->
		<li class="ecjia-margin-b">
			<div class="consignee">
				<div>
					<p class="ecjiaf-fl">{$value.consignee}</p>
					<p class="ecjiaf-fl ecjia-margin-l ecjia-address-mobile">{$value.mobile}</p>
					<!-- {if $value.address_id eq $value.a_id} -->
					<p class="ecjiaf-fl ecjia-margin-l">{t}默认{/t}</p>
					<!-- {/if} -->
				</div>
				<div class="ecjia-margin-t address ecjiaf-wwb">{$value.address}</div>	
				<a href="{$value.url}"><i class="iconfont icon-bianji"></i></a>
				<a class="nopjax" href="javascript:;" data-toggle="del_list" data-url="{url path='user_address/del_address_list'}" data-id="{$value.address_id}" data-msg="{t}你确定要删除此收货地址吗？{/t}"><i class="iconfont icon-delete"></i></a>
			</div>
		</li>
	<!-- {/foreach} -->
	<!-- 配送地址end--> 
<!-- {/block} -->