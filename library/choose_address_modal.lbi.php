<?php
/*
Name: 选择地址
Description: 这是选择地址弹窗
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>

<div class="ecjia-modal" style="margin-top: -140px;">
	<div class="modal-inner">
		<div class="modal-title"><i class="position"></i>您当前使用的地址是：</div>
		<div class="modal-text">{$smarty.cookies.index_address}</div>
	</div>
	<div class="modal-buttons modal-buttons-2 modal-buttons-vertical">
		<span class="modal-button"><span class="create_address"><a href="{RC_Uri::url('user/user_address/add_address')}{if $smarty.cookies.index_address}&address={$smarty.cookies.index_address}{/if}">新建收货地址</a></span></span>
		<span class="modal-button"><span class="edit_address"><a href="{RC_Uri::url('user/user_address/location')}">更换地址</a></span></span>
	</div>
</div>
<div class="ecjia-modal-overlay ecjia-modal-overlay-visible"></div>