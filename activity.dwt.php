<?php
/*
Name: 优惠活动模板
Description: 优惠活动页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.goods.init();</script>
<script type="text/javascript">
	get_asynclist("{url path='activity/asynclist' args="page={$page}&sort={$sort}&order={$order}"}" , '{$theme_url}dist/images/loader.gif');
</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

	<div class="bran_list" id="J_ItemList">
		<ul class="ecjia-list ecjia-activity-list">
		<!-- {foreach from=$favourable_activity item=activity} -->
			<li class="ecjia-margin-t">
				<p class="a-img"><!-- $activity.act_banner} -->
					<a href="{$activity.url}"><img src="http://img11.360buyimg.com/cms/jfs/t145/259/2655815990/39930/9c6e8426/53d772c7N26e261e4.jpg!q35.jpg"></a>
					<span>{$activity.start_time}-{$activity.end_time}</span>
				</p>
				<p class="a-name">{$activity.act_name}</p>
			</li>
		<!-- {/foreach} -->
		</ul>
		<a class="get_more" href="javascript:;"></a>
	</div>

<!-- {/block} -->


<!-- 优惠活动列表 start-->
<!--{if $activity}-->
<li>
  <p class="a-img"><a href="{$activity.url}"><img src="{$activity.act_banner}"></a><span>{$activity.start_time}-{$activity.end_time}</span></p>
  <p class="a-name">{$activity.act_name}</p>
</li>
<!-- {/if}-->
<!-- 优惠活动列表 end-->
