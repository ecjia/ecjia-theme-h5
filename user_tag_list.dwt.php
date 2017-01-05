<?php
/*
Name: 我的标签模板
Description: 这是我的标签页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.delete_list_click();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div>
	<ul class="ecjia-list ecjia-list-two user-tag-list">
		<!-- 标签云开始 {foreach from=$tags item=tag}-->
		<li class="ecjia-margin-t" role="alert">
			<span class="close" data-toggle="del_list" data-id="{$tag.tag_words}" data-url="{url path='user/user_tag/del_tag'}" data-msg="{t}您确定要删除该标签吗？{/t}"><i class="iconfont icon-close"></i></span>
			<a href="{url path='goods/category/goods_list' args="keywords={$tag.tag_words}"}" title="{$tag.tag_words|escape:html}" style="background-color:{$tag.color}">{$tag.tag_words|escape:html}</a>
		</li>
		<!-- {foreachelse} -->
		<div class="ecjia-nolist">
			<i class="iconfont icon-tag"></i>
			<p class="tags_list_font">{t}您还没有添加标签哦~{/t}</p>
			<p class="tags_list_font_two">{t}注：请在商品详情页添加标签{/t}</p>
		</div>
		<!-- {/foreach} -->
	</ul>
</div>
<!-- {/block} -->
