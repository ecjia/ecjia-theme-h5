<?php
/*
Name: 专题2
Description: 专题2
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="ecjia"} -->
<!-- TemplateBeginEditable name="内容区域" -->
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->
<!-- TemplateEndEditable -->
<style type="text/css">
{literal}
body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td{margin:0px; padding:0px;}
table{ border-collapse:collapse; border-spacing:0;}
fieldset,img{border:0;}
em,strong,th,i{ font-weight:normal; font-style:normal;}
ol,ul{ list-style-type:none; list-style-position:outside;}
caption,th{ text-align:left;}
h1,h2,h3,h4,h5,h6{ font-size:100%; font-weight:normal;}
body{font-family:"Microsoft YaHei"; font-size:12px; width: 100%; max-width: 640px;margin: 0 auto;}
a, a:active, a:hover, a:link, a:visited{text-decoration:none;color: #fff;}
.img{max-width: 100%;width: 100%; vertical-align:middle;}
ul,li{overflow: hidden;}
.center{text-align: center !important;}
.topic-goods-list{padding:.5em;}
.topic-goods-list ul li:nth-child(2n){margin-right:0px;}
.topic-goods-list  li{float: left;width: 49%;border-bottom: none; margin-right:2%; margin-bottom: .6em;}
.topic-goods-list  li .goods-img {display: block; height: 0; padding-bottom: 100%;overflow: hidden;}
.topic-goods-list .goods-wth-2{width:100%;border-bottom: none; margin: 0 2% .8em 0;}
.topic-goods-list .goods-wth-3{position: relative; width: 32%;border-bottom: none; padding: 0 0 .4em; margin: 0 2% .4em 0;}
.topic-goods-list .goods-wth-4{position: relative; width: 66%;border-bottom: none; padding: 0 0 .4em; margin: 0 2% .4em 0;}
.topic-bgc02{background-color:#291e62;}
.topic-bgc03{background-color:#c8000d;}
.topic-bgc04{background-color:#eeeeee;}
.topic-bgc05{background-color:#fcd6e3;}
.topic-bgc06{background-color:#fff;}

.goods-wth-3{position: relative; width: 32%;border-bottom: none; padding: 0 0 .4em; margin: 0 2% .4em 0;}
.goods-wth-4{position: relative; width: 66%;border-bottom: none; padding: 0 0 .4em; margin: 0 2% .4em 0;}
.goods-wth-2{ width:100%;border-bottom: none; margin: 0 2% .8em 0;}
.pad-b{padding-bottom: 15px;}

.pos-1{ background-color: rgba(0,0,0,.5); color: #fff; height: 1.8em; line-height: 1.8em;}
.fsize-2{font-size: 1.6em; line-height: 1.5em;}
.fsize-1{font-size: 1em;line-height: 1.5em;}
.fcolor-1{color: #ff1b50}
.fcolor-2{color: #999}
.btn-red{background-color: #ff0042; color: #fff; display: block; width: 100%; padding:.5em 0; border-radius: 5px;margin:0 auto;} 
.btn-list{background-color: #ff0042; color: #fff; display: block; width: 40%; padding:.4em 0; border-radius: 5px;margin-top: .2em;} 
.btn{width: 80%; padding: 10px 0;margin:0 auto;}
.title-wth{padding: 15px 0; width: 80%;margin:0 auto;}
.title-5{padding-top: 10px;}
.list-l{width: 32%; float: left;}
.list-r{width: 67%; line-height: 1.5em;float: left; text-align: left;}
.pad-l{padding-left: 1em; overflow: hidden;}
.btn-list{background-color: #ff0042; color: #fff; display: block; width: 40%; padding:.4em 0; border-radius: 5px;margin-top: 1.8em;} 
.text-of{height: 3.2em;text-overflow:ellipsis;}
.list-r p{line-height: 1.8em;}
.foot-btn {overflow: hidden;}
.ecjia-header,.ecjia-app-download{font-size: 1.4em;}
{/literal}
</style>
<div class="topic-bgc02">
	<div class="pad-b"><img class="img" src="{$theme_url}/library/topic/images/banner02.jpg" alt="banner"></div>

	<div class="topic-goods-list"><img class="img" src="{$theme_url}/library/topic/images/title02-1.jpg" alt="##"></div>
		<div class="pad-b title-5">
			<ul class="topic-goods-list">
				<li class="fl goods-wth-3">
					<a href="##">
						<img class="img" src="{$theme_url}/library/topic/images/title02-2.jpg" alt="#">
					</a>
				</li>
				<li class="fl goods-wth-3">	
					<a href="##">
						<img class="img" src="{$theme_url}/library/topic/images/title02-3.jpg" alt="#">
					</a>
				</li>
				<li class="fl goods-wth-3" style="margin-right: 0">	
					<a href="##">
						<img class="img" src="{$theme_url}/library/topic/images/title02-4.jpg" alt="#">
					</a>
				</li>
				<li class="fl goods-wth-3">	
					<a href="##">
						<img class="img" src="{$theme_url}/library/topic/images/title02-5.jpg" alt="#">
					</a>
				</li>
				<li class="fl goods-wth-4" style="margin-right: 0">	
					<a href="##">
						<img class="img" src="{$theme_url}/library/topic/images/title02-6.jpg" alt="#">
					</a>
				</li>
			</ul>
		</div>
	<div class="center pad-b"><img class="img" src="{$theme_url}/library/topic/images/title02.png" alt="title"></div>
	<div class="foot-btn">
		<ul class="topic-goods-list">
			<li class="goods-wth-2 topic-bgc06">
				<a class="list-l"><img class="img" src="http://test.b2c.ecjia.com/content/uploads/images/201512/goods_img/44_G_1450744893342.jpg" alt="安娜苏（Annasui）许愿精灵香水30ml（又名：安娜苏许愿精灵淡香水 30ml）"></a>
				<div class="fl list-r text-left">
					<p class="pad-l title-5 text-of">安娜苏(Annasui)许愿精灵香水30ml(又名：安娜苏许愿精灵淡香水)</p>
					<p class="fcolor-1 pad-l text-of-1">活动体验价：<span class="fsize-2">￥500.00</span>  <s class="fcolor-2">￥600.00</s></p>
					<div class="pad-l"><a href="http://test.weshop.ecjia.com/index.php?m=goods&c=index&a=init&id=44" class="center btn-list ">了解详情</a></div>
				</div>
			</li>
			<li class="goods-wth-2 topic-bgc06">
				<a class="list-l"><img class="img" src="http://test.b2c.ecjia.com/content/uploads/images/201601/goods_img/131_G_1452720319630.jpg" alt="2015冬装休闲羽绒服  2015冬装新款女装休闲羽绒服宽松短款面包服外套女"></a>
				<div class="fl list-r text-left">
					<p class="pad-l title-5 text-of">2015冬装休闲羽绒服  2015冬装新款女装休闲羽绒服宽松短款面包服外套女 </p>
					<p class="fcolor-1 pad-l text-of-1">活动体验价：<span class="fsize-2">￥399元</span>  <s class="fcolor-2">￥479元</s></p>
					<div class="pad-l"><a href="http://test.weshop.ecjia.com/index.php?m=goods&c=index&a=init&id=131" class="center btn-list ">了解详情</a></div>
				</div>
			</li>
			<li class="goods-wth-2 topic-bgc06">
				<a class="list-l"><img class="img" src="http://test.b2c.ecjia.com/content/uploads/images/201601/goods_img/128_G_1452707340203.jpg" alt="A字斗篷双排扣毛呢大衣  2015冬季韩版A字斗篷宽松大衣中长款双排扣加厚白色毛呢大衣"></a>
				<div class="fl list-r text-left">
					<p class="pad-l title-5 text-of">A字斗篷双排扣毛呢大衣  2015冬季韩版A字斗篷宽松大衣中长款双排扣加厚白色毛呢大衣 </p>
					<p class="fcolor-1 pad-l text-of-1">活动体验价：<span class="fsize-2">￥199元</span>  <s class="fcolor-2">￥239元</s></p>
					<div class="pad-l"><a href="http://test.weshop.ecjia.com/index.php?m=goods&c=index&a=init&id=128" class="center btn-list ">了解详情</a></div>
				</div>
			</li>
			<li class="goods-wth-2 topic-bgc06">
				<a class="list-l"><img class="img" src="http://test.b2c.ecjia.com/content/uploads/images/201512/goods_img/66_G_1450760702030.jpg" alt="伊贝诗深海绿洲拍拍水面膜"></a>
				<div class="fl list-r text-left">
					<p class="pad-l title-5 text-of">伊贝诗深海绿洲拍拍水面膜</p>
					<p class="fcolor-1 pad-l text-of-1">活动体验价：<span class="fsize-2">￥49元</span>  <s class="fcolor-2">￥59元</s></p>
					<div class="pad-l"><a href="http://test.weshop.ecjia.com/index.php?m=goods&c=index&a=init&id=66" class="center btn-list ">了解详情</a></div>
				</div>
			</li>
			<li class="goods-wth-2 topic-bgc06">
				<a class="list-l"><img class="img" src="http://test.b2c.ecjia.com/content/uploads/images/201601/goods_img/107_G_1452581981177.jpg" alt="显瘦学生呢子大衣  新款格子毛呢外套女中长款韩版修身外套显瘦学生呢子大衣"></a>
				<div class="fl list-r text-left">
					<p class="pad-l title-5 text-of">显瘦学生呢子大衣  新款格子毛呢外套女中长款韩版修身外套显瘦学生呢子大衣</p>
					<p class="fcolor-1 pad-l text-of-1">活动体验价：<span class="fsize-2">￥499元</span>  <s class="fcolor-2">￥699元</s></p>
					<div class="pad-l"><a href="http://test.weshop.ecjia.com/index.php?m=goods&c=index&a=init&id=107" class="center btn-list ">了解详情</a></div>
				</div>
			</li>
			<li class="goods-wth-2 topic-bgc06">
				<a class="list-l"><img class="img" src="http://test.b2c.ecjia.com/content/uploads/images/201601/goods_img/141_G_1452727163254.jpg" alt="秋装新款韩版后背褶皱收腰中长款单排扣风衣"></a>
				<div class="fl list-r text-left">
					<p class="pad-l title-5 text-of">秋装新款韩版后背褶皱收腰中长款单排扣风衣</p>
					<p class="fcolor-1 pad-l text-of-1">活动体验价：<span class="fsize-2">￥299元</span>  <s class="fcolor-2">359元</s></p>
					<div class="pad-l"><a href="http://test.weshop.ecjia.com/index.php?m=goods&c=index&a=init&id=141" class="center btn-list ">了解详情</a></div>
				</div>
			</li>
		</ul>
	</div>
</div>	
<!-- {/block} -->
	