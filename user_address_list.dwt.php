<?php
/*
Name: 收货地址列表模板
Description: 收货地址列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.more();</script>
<script type="text/javascript">ecjia.touch.delete_list_click();</script>
<script type="text/javascript">ecjia.touch.asynclist();</script>
<script type="text/javascript">
$('.setdefault').click(function(){
	var data_id = $(this).attr('data-id');
    var url = $("input[name='setdefault_url']").val();
    $.get(url, {
		id: data_id
	}, function(data) {
		ecjia.touch.showmessage(data);
	}, 'json');
});
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->

<div class="ecjia-address-list">
	<div class="nav-header ecjia-margin-t ecjia-margin-b">
		<a href="{url path='user/user_address/add_address'}">
			<i class="icon-add-address"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{t}新建收货地址{/t}
			<span class="ecjiaf-fr"><i class="iconfont icon-jiantou-right"></i></span>
		</a>
	</div>
	<section>
	<input type="hidden" name="setdefault_url" value="{RC_uri::url('user/user_address/set_default')}">
	<!-- {if $address_list} -->
		<ul class="ecjia-list list-one" id="J_ItemList">
			<!-- 配送地址 start-->
			<!-- {foreach from=$address_list item=value}-->
			<li>
				<div>
					<p class="ecjiaf-fl">{$value.consignee}</p>
					<p class="ecjiaf-fl ecjia-margin-l ecjia-address-mobile">{$value.mobile}</p>
				</div>
				<br />
				<div class="address ecjiaf-wwb">{$value.province_name} {$value.city_name} {$value.address} {$value.address_info}</div>
				<hr />
				<!-- {if $value.default_address eq 1} -->
				<p><i class="icon-is-default"></i>&nbsp;&nbsp;{t}设为默认{/t}</p>
				<!-- {else} -->
				<p class="setdefault ecjiaf-csp" data-id="{$value.id}"><i class="icon-not-default"></i>&nbsp;&nbsp;{t}设为默认{/t}</p>
				<!-- {/if} -->
				
				<a class="edit-address" href="{RC_uri::url('user/user_address/edit_address')}&id={$value.id}"><div class="icon-edit-address"></div>{t}编辑{/t}</a>
				
			    <a class="delete-address nopjax" href="javascript:;" data-toggle="del_list" data-url="{url path='user/user_address/del_address'}" data-id="{$value.id}" data-msg="{t}你确定要删除此收货地址吗？{/t}"><div class="icon-delete-address"></div>{t}删除{/t}</a>
		
			</li>
			<!-- {/foreach} -->
			<!-- 配送地址end-->
		</ul>
	    <!-- {$page} -->
	<!-- {else} -->
		<div class="ecjia-nolist">
			<img src="{$theme_url}images/address.png">
			<p class="address_list_font">{t}暂无收货地址，请添加{/t}</p>
		</div>
	<!-- {/if} -->
	</section>
</div>
<!-- {/block} -->
