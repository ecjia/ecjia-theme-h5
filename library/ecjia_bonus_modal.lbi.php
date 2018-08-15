<?php
/*
Name: 添加红包弹出层
Description: 这是添加红包弹出层
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-normal-modal">
	{if $type eq 'success'}
	<div class="ecjia-normal-modal-content">
		<div class="title">恭喜您！</div>
		<div class="title">红包添加成功！</div>
		<div class="">
			<img src="{$theme_url}images/wallet/bonus_success.png" />
		</div>
		<a class="btn close-normal-btn confirm" href="javascript:;">确认</a>	
	</div>
	{else if $type eq 'error'}
	<div class="ecjia-normal-modal-content">
		<div class="title">您输入的号码有误，</div>
		<div class="title">请核对后重新输入！</div>
		<div class="">
			<img src="{$theme_url}images/wallet/bonus_error.png" />
		</div>
		<a class="btn close-normal-btn" href="javascript:;">重新输入</a>	
	</div>
	{else if $type eq 'bonus_info'}
	<div class="ecjia-normal-modal-content">
		<div class="bonus_title">红包详情</div>
		<div class="bonus_item">
			<div class="left">红包名称：</div>
			<div class="right">18年双十一300元红包</div>
		</div>
		<div class="bonus_item">
			<div class="left">红包金额：</div>
			<div class="right red_color">￥100.00</div>
		</div>
		<div class="bonus_item">
			<div class="left">使用期限：</div>
			<div class="right red_color">2018.11.11-2019-01.22</div>
		</div>
		<div class="bonus_item new_line">
			<div class="left">使用条件：</div>
			<div class="right">
			1.只可以购买分类，家用电器，水果蔬菜里的商品；<br/>
			2.满￥600元才可以使用此红包；
			</div>
		</div>
		<a class="btn confirm-add-btn" href="javascript:;">确认添加</a>
		<a class="btn close-normal-btn gray" href="javascript:;">取消添加</a>
	</div>
	{/if}
</div>
<div class="ecjia-normal-modal-overlay"></div>