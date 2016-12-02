<?php
/*
Name: 分类模板
Description: 分类页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?> defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} //TODO: move -->
<script type="text/javascript">
{literal}
$('.category').css({height:document.documentElement.clientHeight});
if (!$('.ecjia-header').is(":visible")) $('.category_left, .category_right').css({marginTop : 0, paddingTop : 0});
{/literal}
ecjia.touch.category.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="category">
<!-- #BeginLibraryItem "/library/index_header.lbi" -->
<!-- #EndLibraryItem -->
    <ul class="ecjia-list category_left">
        <!--{foreach from=$data item=cat}-->
        <li{if $cat.id eq $cat_id} class="active"{/if}><a href="#" data-rh="1" data-val="{$cat.id}">{$cat.name|escape:html}</a></li>
        <!--{/foreach}-->
    </ul>
    <div class="category_right">
		<!--{foreach from=$data item=children}-->
			<div class="cat_list ecjia-category-list {if $cat_id eq $children.id}show{else}hide{/if}" id="category_{$children.id}">
	            <a href="{RC_Uri::url('goods/category/store_list')}&cid={$children.id}"><img src="{$children.image}" alt="{$children.name}"></a>
	            <div class="hd">
	                <h5>
	                    <span class="line"></span>
	                    <span class="goods-index-title">{$children.name}</span>
	                </h5>
	            </div>
	            <!-- {if $children.children} -->
	            <ul class="ecjia-margin-t">
	                <!--{foreach from=$children.children item=cat}-->
	                <li>
	                    <a href="{RC_Uri::url('goods/category/store_list')}&cid={$cat.id}">
	                        <div class="cat-img">
	                            <img src="{$cat.image}" alt="{$cat.name}">
	                        </div>
	                        <div class="child_name">{$cat.name}</div>
	                    </a>
	                </li>
		           	<!--{/foreach}-->
	            </ul>
	            <!-- {/if} -->
            </div>
    	<!--{/foreach}-->
    </div>
</div>
<!-- #BeginLibraryItem "/library/model_bar.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->
