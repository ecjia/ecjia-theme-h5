<?php
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {if not is_pjax()} -->
<!-- {if is_ajax()} -->
<!-- {block name="ajaxinfo"} --><!-- {/block} -->
<!-- {else} -->
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0, minimal-ui">
	<title>{$page_title}</title>
	<link rel="shortcut icon" href="favicon.ico" />

	<!-- {block name="ready_meta"} --><!-- {/block} -->
	<link rel="stylesheet" href="{$theme_url}lib/bootstrap3/css/bootstrap.css">

	<link rel="stylesheet" href="{$theme_url}dist/css/iconfont.min.css">


	<link rel="stylesheet" href="{$theme_url}css/ecjia.touch.css">
	<link rel="stylesheet" href="{$theme_url}css/ecjia.touch.develop.css">
	<link rel="stylesheet" href="{$theme_url}css/ecjia.touch.b2b2c.css">
	<link rel="stylesheet" href="{$theme_url}css/ecjia_city.css">
	<link rel="stylesheet" href="{$theme_url}css/ecjia_help.css">
    <!-- 弹窗 -->
	<link rel="stylesheet" href="{$theme_url}css/ecjia.touch.models.css">
	<link rel="stylesheet" href="{$theme_url}dist/other/swiper.min.css">
    <link rel="stylesheet" href="{$theme_url}lib/datePicker/css/datePicker.min.css">
    <link rel="stylesheet" href="{$theme_url}lib/winderCheck/css/winderCheck.min.css">
	<!-- skin -->
	<link rel="stylesheet" href="{$theme_url}{$curr_style}">

	<script type="text/javascript" src="{$theme_url}lib/jquery/jquery.min.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/multi-select/js/jquery.quicksearch.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/jquery/jquery.pjax.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/jquery/jquery.cookie.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/iscroll/js/iscroll.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/bootstrap3/js/bootstrap.min.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/ecjiaUI/ecjia.js" ></script>
	<script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=P4C6rokKFWHjXELjOnogw3zbxC0VYubo"></script>
	<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=4PLBZ-WSUW2-OXBUZ-CFNSS-MRUAV-3SFEO"></script>
	

	<!-- {block name="meta"} --><!-- {/block} -->

	<script type="text/javascript" src="{$theme_url}js/ecjia.touch.js" ></script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.history.js" ></script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.others.js" ></script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.goods.js" ></script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.user.js" ></script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.flow.js" ></script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.merchant.js" ></script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.b2b2c.js" ></script>

    
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.goods_detail.js" ></script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.spread.js" ></script>
    
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.fly.js" ></script>
    <!-- 弹窗 -->
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.intro.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/Validform/Validform_v5.3.2_min.js"></script>

	<script type="text/javascript" src="{$theme_url}lib/swiper/js/swiper.min.js"></script>
    <script type="text/javascript" src="{$theme_url}lib/datePicker/js/datePicker.min.js"></script>
    <script type="text/javascript" src="{$theme_url}lib/winderCheck/js/winderCheck.min.js"></script>
</head>
<body>
	<div class="ecjia">
		<!-- {block name="main-content"} --><!-- {/block} -->
	</div>
	<!-- {block name="ready_footer"} --><!-- {/block} -->

	<!-- #BeginLibraryItem "/library/page_menu.lbi" -->
	<!-- #EndLibraryItem -->


	<!-- {block name="footer"} --><!-- {/block} -->
	<script type="text/javascript">
		var hidenav = {if $hidenav eq 1}1{else}0{/if}, hidetab = {if $hidetab eq 1}1{else}0{/if}, hideinfo = {if $hideinfo}1{else}0{/if};
		if (hideinfo) {
			$('header').hide();
			$('footer').hide();
			$('.ecjia-menu').hide();
		} else {
			hidenav && $('header').hide();
			hidetab && $('footer').hide();
		}
	</script>
</body>
</html>
<!-- {/if} -->
<!-- {else} -->
<title>{block name="title"}{$page_title}{/block}</title>
<!-- {block name="meta"} --><!-- {/block} -->
<!-- {block name="main-content"} --><!-- {/block} -->
<!-- {block name="footer"} --><!-- {/block} -->
<!-- {/if} -->
{/nocache}
