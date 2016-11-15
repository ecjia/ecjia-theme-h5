<?php
/*
Name: 加载消息详情模板
Description: 加载消息详情页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.delete_list_click();
</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div class="msg-detail">
	<div class="message_deatil ecjiaf-wwb">
		{$msg_detail.msg_content}
	</div>
	<div class="ecjiaf-wwb mer-msg ecjia-margin-b">
		<div><b class="ecjiaf-fl msg_title">{$lang.shopman_reply}:</b><span class="ecjiaf-fr msg_type">{$msg_detail.msg_type}</div>
		{if $msg_detail.re_msg_content}<span>{$msg_detail.re_msg_content}</span>{else}店主还没有回复此条消息{/if}
	</div>
	<a class="btn msg-btn msg-btn-color btn-info nopjax" data-toggle="del_list" data-url="{url path='user/user_message/del_msg'}" data-id="{$id}" data-msg="{t}您确定要删除此{$msg.msg_type}吗？{/t}">删除此条消息</a>
</div>
<!-- {/block} -->
