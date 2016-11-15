<?php
/*
Name: 文章详情模板
Description: 文章详情页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.touch.region_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<ul class="ecjia-list ecjia-region-sel">
    <li class="region_address"><p class="active"><i class="iconfont icon-location"></i>当前定位城市：{$city}</p></li>
    <li class="search-region" id="side_accordion">
        <input name="search" data-toggle="search_key" type="text" placeholder="请输入搜索地区！"><i class="iconfont icon-search"></i>
    </li>
    <li>
        <!-- {foreach from=$area item=value} -->
            <p class="active" data-trigger="change_area" data-url="{url path='touch/index/set_area' args="city_id={$value.region_id}&province_id={$value.parent_id}"}">{$value.region_name}</p>
        <!-- {/foreach} -->
    </li>
</ul>
<!-- {/block} -->