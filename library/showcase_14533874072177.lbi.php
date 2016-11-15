<?php
/*
Name: 自定义橱窗_底部广告图片
Description: 首页底部可以点击关闭的广告图片
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {if $smarty.cookies.hide_bottom_banner neq 1} -->
<div class="bottom-banner">
<a href="{url path='touch/index/download'}"><img src="{$theme_url}dist/images/bottom_banner.png" /></a>
<i class="iconfont icon-close close-bottom-banner" onclick="close_bottom_banner()"></i>
</div>
<!-- {/if} -->
<script type="text/javascript">
function close_bottom_banner() {
    $.cookie('hide_bottom_banner', 1);
    $('.bottom-banner').remove();
}
</script>
