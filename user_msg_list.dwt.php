<?php
/*
Name: 信息中心模板
Description: 这是信息中心页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="ecjia"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div>
	<ul class="ecjia-list ecjia-message-list" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='async_msg_list'}" data-size="10"></ul>
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
	<!-- {foreach from=$message_list item=msg} 循环信息列表 -->
	<li>
		<a class="ecjiaf-fl {if $msg.re_msg_content}ecjia-margin-b{/if}" href="{url path='user/user_message/msg_detail' args="msg_id={$msg.msg_id}"}">
			<div class="ecjiaf-fl">
				<div class="msg-img msg_type{$msg.msg_type_id}">{$msg.msg_type}</div>
			</div>
			<div class="ecjia-msg-r ecjiaf-fl">
				<div class="hd">
					<div class="ecjiaf-fl msg-username">{$msg.msg_username}</div>
					<div class="ecjiaf-fr msg-msg_time">{$msg.msg_time}</div>
				</div>
				<div class="bd">{$msg.msg_content}</div>
			</div>
		</a>
		<a class="message-list-del ecjiaf-fr nopjax" href="javascript:;" data-toggle="del_list" data-url="{url path='user/user_message/del_msg'}" data-id="{$msg.msg_id}" data-msg="{t}您确定要删除此{$msg.msg_type}吗？{/t}"><i class="iconfont icon-delete"></i></a>
		<!--{if $msg.re_msg_content}-->
		<div class="ecjiaf-fl ecjiaf-wwb mer-msg">
			<a href="{url path='user/user_message/msg_detail' args="msg_id={$msg.msg_id}"}"><div>{$lang.shopman_reply}:<span>{$msg.re_msg_content}</span></div></a>
		</div>
		<!--{/if}-->
	</li>
	<!--{foreachelse}-->
	<div class="ecjia-nolist">
		<i class="iconfont icon-message"></i>
		<p>{t}暂无消息通知{/t}</p>
	</div>
	<!--{/foreach}-->
<!-- {/block} -->
