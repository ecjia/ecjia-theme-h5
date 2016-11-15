<?php 
/*
Name: 优惠活动，活动商品列表模板
Description: 优惠活动，活动商品列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.goods.init();</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<!-- #BeginLibraryItem "/library/goods_list_act.lbi" -->
<!-- #EndLibraryItem -->
<!-- {/block} -->