<?php
/*
Name: 返还方式模板
Description: 这是返还方式页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.return_order();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<form name='theForm' action="{url path='user/order/add_return_way'}" enctype="multipart/form-data" method="post">
	<div class="ecjia-order-detail ecjia-return-way">
		<div class="ecjia-checkout ecjia-margin-b">
			<div class="flow-goods-list">
				{if $type eq 'home'}
				<p class="select-title ecjiaf-fwb ecjia-margin-l">取件信息</p>
				<div class="co">
					<p class="cp"><span class="cs">取货方式：</span><b>{$return_info.return_way_name}</b></p>
					<p class="cp"><span class="cs">取货地址：</span><b class="cq">{$return_info.pickup_address}</b></p>
					<p class="cp"><span class="cs">期望取件时间：<span class="ecjia-red">*</span></span><label class="cr"><input type="text" readonly name="expect_pickup_time"></label></p>
				</div>
				
				<p class="select-title ecjiaf-fwb ecjia-margin-l">联系人信息</p>
				<div class="co">
					<p class="cp"><span class="cs">联系人：<span class="ecjia-red">*</span></span><label class="cr"><input type="text" name="contact_name"></label></p>
					<p class="cp"><span class="cs">联系电话：<span class="ecjia-red">*</span></span><label class="cr"><input type="text" name="contact_phone"></label></p>
				</div>
	
				<input type="hidden" name="pickup_address" value="{$return_info.pickup_address}">
	
				{else if $type eq 'express'}
			
				<p class="select-title ecjiaf-fwb ecjia-margin-l">返还地址</p>
				<div class="co">
					<p class="cp line"><span class="cs">收件人：</span><b>{$return_info.recipients}</b><span class="cu copy-btn" data-clipboard-text="{$return_info.recipients}">复制</span></p>
					<p class="cp line"><span class="cs">联系方式：</span><b>{$return_info.contact_phone}</b><span class="cu copy-btn" data-clipboard-text="{$return_info.contact_phone}">复制</span></p>
					<p class="cp"><span class="cs">收件地址：</span><b class="cv">{$return_info.recipient_address}</b><span class="cu copy-btn" data-clipboard-text="{$return_info.recipient_address}">复制</span></p>
					
					<input type="hidden" name="recipients" value="{$return_info.recipients}">
					<input type="hidden" name="contact_phone" value="{$return_info.contact_phone}">
					<input type="hidden" name="recipient_address" value="{$return_info.recipient_address}">
				</div>
				
				<p class="select-title ecjiaf-fwb ecjia-margin-l">快递信息</p>
				<div class="co">
					<p class="cp line"><span class="cs">快递名称：</span><label class="cr ct"><input type="text" name="shipping_name" placeholder="请输入快递名称"></label></p>
					<p class="cp"><span class="cs">快递单号：</span><label class="cr ct"><input type="text" name="shipping_sn" placeholder="请输入快递单号"></label></p>
				</div>
				
				{else if $type eq 'shop'}
				
				<p class="select-title ecjiaf-fwb ecjia-margin-l">返还地址</p>
				<div class="co">
					<p class="cp line"><span class="cs">店铺名称：</span><b>{$return_info.store_name}</b><span class="cu copy-btn" data-clipboard-text="{$return_info.store_name}">复制</span></p>
					<p class="cp line"><span class="cs">联系方式：</span><b>{$return_info.store_service_phone}</b><span class="cu copy-btn" data-clipboard-text="{$return_info.store_service_phone}">复制</span></p>
					<p class="cp text"><span class="cs">店铺地址：</span><b class="cv">{$return_info.store_address}</b><span class="cu copy-btn" data-clipboard-text="{$return_info.store_address}">复制</span></p>
				</div>
				
				<input type="hidden" name="store_name" value="{$return_info.store_name}">
				<input type="hidden" name="contact_phone" value="{$return_info.store_service_phone}">
				<input type="hidden" name="store_address" value="{$return_info.store_address}">
				
				{/if}
				<div class="order-ft-link">
					<input type="hidden" name="refund_sn" value="{$refund_sn}">
					<input type="hidden" name="type" value="{$type}">
					<input class="btn btn-small btn-hollow" name="add-return-btn" type="submit" value="提交"/>
				</div>
			</div>
		</div>
	</div>
</form>

<div class="mod_address_slide" id="shippingTimeArea">
	<div class="mod_address_slide_main">
		<div class="mod_address_slide_head">
			取件时间<i class="iconfont icon-close"></i>
		</div>
		<div class="mod_address_slide_body">
			<ul class="mod_address_slide_tabs navBar">
				<!-- {foreach from=$return_info.expect_pickup_date.dates item=val} -->
				<li data-date="{$val}">{$val}</li>
				<!-- {/foreach} -->
			</ul>
			<ul class="mod_address_slide_list selShip hide">
				<!-- {foreach from=$return_info.expect_pickup_date.times item=val} -->
				<li data-time="{$val.start_time}-{$val.end_time}">{$val.start_time}-{$val.end_time}</li>
				<!-- {/foreach} -->
			</ul>
		</div>
	</div>
</div>
<!-- {/block} -->