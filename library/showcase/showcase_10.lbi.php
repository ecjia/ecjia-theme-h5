<?php
/*
Name: 首页-底部会隐藏的广告图
Description: 首页底部会隐藏的广告大图
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
