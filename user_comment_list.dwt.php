<?php
/*
Name: 评论列表模板
Description: 评论列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.delete_list_click();</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div>
	<ul class="ecjia-list user-comment-list"  id="J_ItemList"  data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='async_comment_list'}" data-size="10"></ul>
</div>
<!-- {/block} -->
<!-- {block name="ajaxinfo"} -->
<!--{foreach from=$comment_list item=comment} -->
<li>
	<div class="ecjiaf-fl user-comment-img">
		<a class="comment-goods-img" href="{$comment.url}"><img src="{$comment.goods_thumb}"/></a>
	</div>
	<div class="ecjiaf-fr user-comment-goods">
		<p class="ecjiaf-wwb">{$comment.content}</p>
		<p class="ecjia-margin-t"><a class="ecjiaf-wwb goods-name" href="{url path='goods/index/init' args="id={$comment.id_value}"}">{$comment.cmt_name}</a>{$comment.formated_add_time}</p>
	</div>
	<a class="user-drop-comment" href="javascript:" data-toggle="del_list" data-url="{url path='user/user_comment/delete_comment'}" data-id="{$comment.comment_id}" data-msg="{t}您确定要删除此评论吗？{/t}"> <i class="iconfont icon-delete"></i></a>
</li>
<!--{foreachelse}-->
<div class="ecjia-nolist">
	<i class="iconfont icon-markfill"></i>
	<p>{t}您还没有评论~{/t}</p>
</div>
<!-- {/foreach} -->
<!-- {/block} -->
