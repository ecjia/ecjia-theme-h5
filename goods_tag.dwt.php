<?php 
/*
Name: 商品描述模板
Description: 这是商品描述首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.goods.init();</script>
<!-- {/block} -->

<!-- {block name="ecjia"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<div class="tag_list">
	<ul class="ecjia-list goods-tag">
			<div class="ecjia-margin-t">商品标签：</div>
			<!-- {foreach from=$tags item=val } -->
			<li class="ecjia-margin-t">{$val.tag_words} {if $val.num gt 1}[{$val.num}]{/if} </li>
			<!-- {foreachelse} -->
			<p>该商品还没有标签，赶快添加吧！</p>
			<!-- {/foreach} -->
	</ul>
</div>

<div class="add_tags ecjia-margin-t ecjia-margin-b">
	<form class="ecjia-form" action="{url path='goods/index/add_tags'}" method="get" name="addtags">
		<input class="ecjiaf-fl tag-words" type="text" name="tags" datatype="s1-10" nullmsg="请填写标签内容" autocomplete="off" />
		<input type="hidden" name="goods_id" value="{$goods_id}">
		<input class="ecjiaf-fr btn btn-info add-button" type="submit" data-toggle="addtags" value="添加标签" >
	</form>
</div>
<!-- {/block} -->