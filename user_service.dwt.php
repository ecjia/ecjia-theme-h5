<?php
/*
Name:客户服务模板
Description: 这是客户服务首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.goods.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<form class="ecjia-form package-message-form" action="{url path='user/user_package/add_server'}" method="post" enctype="multipart/form-data" name="formMsg">
	<div class="form-group">
		<span class="ecjiaf-fl">{$lang.message_title}</span>
		<label class="package-server ecjiaf-fr">
			<select name="msg_type">
                <option value="0">{$lang.type[0]}</option>
                <option value="1">{$lang.type[1]}</option>
                <option value="2">{$lang.type[2]}</option>
                <option value="3">{$lang.type[3]}</option>
                <option value="4">{$lang.type[4]}</option>
			</select>
		</label>
	</div>
	<div class="form-group message-content">
		<label class="textarea">
			<textarea name="msg_content" placeholder="{$lang.message_content}" cols="50" rows="4" wrap="virtual" datatype="*"></textarea>
		</label>
	</div>
	<div class="add_service_user ecjia-margin-t ecjia-margin-b">
		<input class="btn btn-info" type="submit" value="{$lang.submit}" />
	</div>
</form>
<!-- {/block} -->
