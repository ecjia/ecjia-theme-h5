<?php
/*
Name: 首页-今日头条
Description: 这是自定义橱窗中的今日头条
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="headlines">
	<div class="head-none"><a href=""><span class="ecjiaf-fl"><i class="iconfont icon-notification"></i></span><span class="ecjiaf-fl">便宜就不能拉风吗？ 看过以下车型顿时有了追求！！！</span></a></div>
	<div class="head-none"><a href=""><span class="ecjiaf-fl"><i class="iconfont icon-notification"></i></span><span class="ecjiaf-fl">最新10分钟神奇气质提升术，路人从此变女神！！！</span></a></div>
	<div class="head-none head-show"><a href=""><span class="ecjiaf-fl"><i class="iconfont icon-notification"></i></span><span class="ecjiaf-fl">推荐再没这么专业的米粉选购建议了！！！</span></a></div>
</div>
<script type="text/javascript">
(function(){
	var i = 0, child = $('.headlines').children(), childLen = child.length;
	setInterval(function(){
		child.eq(i).attr('class','head-show').siblings('div').attr('class','head-none');
		i++; (i == childLen) && (i=0);
    },2000);
})();
</script>
<style>
{literal}
.headlines{background:#fff;overflow:hidden;height:3em;line-height:3em;text-align:center}
.headlines .head-none{display:none}
.headlines .head-show{display:block}
.headlines i{font-size:1.7em;color:#f9b001}
.headlines span:first-child{width:2em;text-align:left;margin-left:1em}
{/literal}
</style>
