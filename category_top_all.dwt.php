<?php
/*
Name: 分类模板
Description: 分类页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?> defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} //TODO: move -->
<script type="text/javascript">
{literal}
$('.category').css({height:document.documentElement.clientHeight});
if (!$('.ecjia-header').is(":visible")) $('.category_left, .category_right').css({marginTop : 0, paddingTop : 0});
{/literal}
</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<div class="category">
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
    <ul class="ecjia-list category_left">
        <!--{foreach from=$category item=cat}-->
        <li{if $cat.id eq $check_cat} class="active"{/if}><a href="{$cat.url}" data-rh="1">{$cat.name|escape:html}</a></li>
        <!--{/foreach}-->
    </ul>
    <div class="category_right">
        <div class="cat_list">
            <a href="{$cat_url}"><img src="{$category_logo}" alt=""></a>
            <ul class="ecjia-margin-t">
                <!--{foreach from=$child item=children }-->
                <li>
                    <a href="{$children.url}">
                        <div class="cat-img">
                            <img src="{$children.icon}" alt="">
                        </div>
                        <div class="child_name">{$children.name}</div>
                    </a>
                </li>
                <!-- {if $children.cat_id} -->
                <!--{foreach from=$children.cat_id item=cat }-->
                <li>
                    <a href="{$cat.url}">
                        <div class="cat-img">
                            <img src="{$cat.icon}" alt="">
                        </div>
                        <div class="child_name">{$cat.name}</div>
                    </a>
                </li>
                <!--{/foreach}-->
                <!-- {/if} -->
                <!--{/foreach}-->
            </ul>
        </div>
    </div>
</div>
<!-- {/block} -->
