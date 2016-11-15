<?php
/*
Name: 自定义橱窗_首页多图广告
Description: 这是首页多图广告
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-margin-t custom_showcase1">
	<div class="ecjia-margin-t ">
		<img src="{$theme_url}/images/custom_1.jpg">
		<a class="custom-1" href="http://test.weshop.ecjia.com/index.php?m=goods&c=index&a=init&id=103"></a>
		<a class="custom-2" href="http://test.weshop.ecjia.com/index.php?m=goods&c=index&a=init&id=81"></a>
		<a class="custom-3" href="http://test.weshop.ecjia.com/index.php?m=goods&c=index&a=init&id=87"></a>
		<a class="custom-4" href="http://test.weshop.ecjia.com/index.php?m=goods&c=index&a=init&id=102"></a>
	</div>

	<div class="ecjia-margin-t ">
		<a href="{url path='topic/index/init'}"><img src="{$theme_url}/images/showcase8_4.jpg"></a>
	</div>
	<div class="ecjia-margin-t showcase8-5 ">
		<img src="{$theme_url}/images/showcase8_5.jpg">
		<a class="showcase8-1" href="http://test.weshop.ecjia.com/index.php?m=goods&c=index&a=init&id=182"></a>
		<a class="showcase8-2" href="http://test.weshop.ecjia.com/index.php?m=goods&c=index&a=init&id=67"></a>
		<a class="showcase8-3" href="http://test.weshop.ecjia.com/index.php?m=goods&c=index&a=init&id=113"></a>
	</div>
</div>

<style media="screen">
{literal}
.ecjia-mod .hd i {position: absolute;width: 1em;left: .5em;}
.custom_showcase1{padding:0 .5em;margin-top:0}
.custom_showcase1 img{width:100%}
.custom_showcase1>div{position:relative}
.custom_showcase1 div:first-child a{position:absolute;display:block}
.custom_showcase1 div:first-child a.custom-1{height:100%;width:38%;top:0;left:0}
.custom_showcase1 div:first-child a.custom-2{height:50%;width:62%;top:0;left:38%}
.custom_showcase1 div:first-child a.custom-3{height:50%;width:31%;top:50%;left:38%}
.custom_showcase1 div:first-child a.custom-4{height:50%;width:31%;top:50%;left:69%}
.showcase8-5{position: relative;}
.showcase8-5 a {position: absolute;display: block;width: 32%; height: 100%;}
.showcase8-5 .showcase8-1{width: 32%; top:0; left: 0;}
.showcase8-5 .showcase8-2{width: 32%; top:0; left: 34%;}
.showcase8-5 .showcase8-3{width: 32%; top:0; left: 68%;}
{/literal}
</style>
