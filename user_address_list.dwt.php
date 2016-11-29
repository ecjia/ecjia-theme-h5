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

<div class="ecjia-address-list">
	<div class="nav-header ecjia-margin-t ecjia-margin-b">
		<a class="" href="{url path='user/user_address/add_address'}" type="botton">
			<i class="iconfont icon-roundadd"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{t}新建收货地址{/t}
			<span class="ecjiaf-fr"><i class="iconfont icon-jiantou-right"></i></span>
		</a>
	</div>
	<section>
	<!-- {if $address_list} -->
		<ul class="ecjia-list list-one" id="J_ItemList">			
			<!-- 配送地址 start--> 
			<!-- {foreach from=$address_list item=value} 循环地址列表 -->
			<li>
				<div>
					<p class="ecjiaf-fl">{$value.consignee}</p>
					<p class="ecjiaf-fl ecjia-margin-l ecjia-address-mobile">{$value.mobile}</p>
				</div>
				<br />
				<div class="address ecjiaf-wwb">{$value.address}</div>	
				<hr />
				<!-- {if $value.address_id eq $value.a_id} -->
				<p class="is-default"><i class="iconfont icon-roundcheckfill"></i> {t}设为默认{/t}</p>
				<!-- {else} -->
				<p class="not-default"><i class="iconfont icon-round"></i> {t}设为默认{/t}</p>
				<!-- {/if} -->
				<a href="{$value.url}"><i class="iconfont icon-bianji1">{t}编辑{/t}</i></a>
				<a class="nopjax" href="javascript:;" data-toggle="del_list" data-url="{url path='user_address/del_address_list'}" data-id="{$value.address_id}" data-msg="{t}你确定要删除此收货地址吗？{/t}"><i class="iconfont icon-delete">{t}删除{/t}</i></a>
			</li>
			<!-- {/foreach} -->
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
<!-- {/block} -->