<?php 
/*
Name: 分类模板
Description: 分类页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.category.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<div class="panel panel-default category-all" >
	<ul class="ecjia-list">
		<!--{foreach from=$category item=cat name=no}-->
		<li>
			<!--{if $cat.cat_id}-->
			<div class="media panel-body">
				<div class="ecjiaf-fl">
					<h3>{$cat.name|escape:html}</h3>
					<h5 style="display:none;">
						<!--{foreach from=$cat.cat_id item=child name=no1}-->
							<!--{if $smarty.foreach.no1.index lt 3}-->
								<!--{if $smarty.foreach.no1.index gt 0}-->/<!--{/if}-->{$child.name}
							<!--{/if}-->
						<!--{/foreach}-->
					</h5>
				</div>
				<i class="iconfont icon-jiantou-bottom"></i>
			</div>
			<!--{else}-->
			<a href="{url path='category/goods_list' args="cid={$cat.id}"}">
				<div class="media panel-body">
					<div class="ecjiaf-fl">
						<h3>{$cat.name|escape:html}</h3>
						<h5 style="display:none;">
							<!--{foreach from=$cat.cat_id item=child name=no1}-->
								<!--{if $smarty.foreach.no1.index lt 3}-->
									<!--{if $smarty.foreach.no1.index gt 0}-->/<!--{/if}-->{$child.name}
								<!--{/if}-->
							<!--{/foreach}-->
						</h5>
					</div>
				</div>
			</a>
			<!--{/if}-->
			<div class="category-child">
				<!--{foreach from=$cat.cat_id item=child name=no1}-->
				<p><a href="{$child.url}">{$child.name|escape:html}</a></p>
				<!--{/foreach}-->
			</div>
		</li>
		<!--{/foreach}-->
	</ul>
</div>
<!-- {/block} -->