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
				{if $type eq 'visit'}
				<p class="select-title ecjiaf-fwb ecjia-margin-l">取件信息</p>
				<div class="co">
					<p class="cp"><span class="cs">取货方式：</span><b>上门取货</b></p>
					<p class="cp"><span class="cs">取货地址：</span><b>上海市普陀区长风街道伸大厦301室</b></p>
					<p class="cp"><span class="cs">期望取件时间：<span class="ecjia-red">*</span></span><label class="cr"><input type="text" name="expect_date"></label></p>
				</div>
				
				<p class="select-title ecjiaf-fwb ecjia-margin-l">联系人信息</p>
				<div class="co">
					<p class="cp"><span class="cs">联系人：</span><label class="cr"><input type="text" name="contact"></label></p>
					<p class="cp"><span class="cs">联系电话：</span><label class="cr"><input type="text" name="contact_mobile"></label></p>
				</div>
	
				{else if $type eq 'shipping'}
			
				<p class="select-title ecjiaf-fwb ecjia-margin-l">返还地址</p>
				<div class="co">
					<p class="cp line"><span class="cs">收件人：</span><b>向xx</b><span class="cu copy-btn" data-clipboard-text="向xx">复制</span></p>
					<p class="cp line"><span class="cs">联系方式：</span><b>18917865421</b><span class="cu copy-btn" data-clipboard-text="18917865421">复制</span></p>
					<p class="cp"><span class="cs">收件地址：</span><b class="cv">上海市普陀区长风街道伸大厦301室</b><span class="cu copy-btn" data-clipboard-text="上海市普陀区长风街道伸大厦301室">复制</span></p>
				</div>
				
				<p class="select-title ecjiaf-fwb ecjia-margin-l">快递信息</p>
				<div class="co">
					<p class="cp line"><span class="cs">快递名称：</span><label class="cr ct"><input type="text" name="contact" placeholder="请输入快递名称"></label></p>
					<p class="cp"><span class="cs">快递单号：</span><label class="cr ct"><input type="text" name="contact_mobile" placeholder="请输入快递单号"></label></p>
				</div>
				
				{else if $type eq 'to_store'}
				
				<p class="select-title ecjiaf-fwb ecjia-margin-l">返还地址</p>
				<div class="co">
					<p class="cp line"><span class="cs">店铺名称：</span><b>xx旗舰店</b><span class="cu copy-btn" data-clipboard-text="xx旗舰店">复制</span></p>
					<p class="cp line"><span class="cs">联系方式：</span><b>021-0000000</b><span class="cu copy-btn" data-clipboard-text="021-0000000">复制</span></p>
					<p class="cp text"><span class="cs">店铺地址：</span><b class="cv">上海市普陀区长风街道伸大厦301室</b><span class="cu copy-btn" data-clipboard-text="上海市普陀区长风街道伸大厦301室">复制</span></p>
				</div>
				
				{/if}
				<div class="order-ft-link">
					<input type="hidden" name="order_id" value="{$order_id}">
					<input class="btn btn-small btn-hollow" name="add-return-btn" type="submit" value="提交"/>
				</div>
			</div>
		</div>
	</div>
</form>
<!-- {/block} -->