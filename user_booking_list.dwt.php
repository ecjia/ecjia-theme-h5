<?php
/*
Name: 缺货登记列表模板
Description: 缺货登记列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.goods.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div>
	<ul class="ecjia-list user-booking-list" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='async_booking_list'}" data-size="10">
	</ul>
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
<!-- 缺货登记列表 start-->
<!-- {foreach from=$booking_list item=item} -->
<li>
	<div class="booking-goods-img ecjiaf-fl">
		<a href="{$item.url}"><img src="{$item.img}"/></a>
	</div>
	<div class="booking-info ecjiaf-fl">
		<div class="hd ecjiaf-fl">
			<p class="booking-goods-name ecjiaf-wwb">
				<a href="{$item.url}">
					{$item.goods_name}
				</a>
			</p>
			<p class="booking-number ecjia-margin-t">{t}订购数量{/t}：{$item.goods_number}</p>
		</div>
		<div class="bd ecjiaf-fr">
			<p>{$item.booking_time}</p>
			<a class="del-booking" data-toggle="del_list" data-id="{$item.rec_id}" data-msg="{t}你确定要删除此缺货信息吗？{/t}" data-url="{url path='user/user_booking/del_booking'}">
				<i class="iconfont icon-delete ecjiaf-fr"></i>
			</a>
		</div>
	</div>
</li>
<!-- {$page} -->
<!-- {foreachelse} -->
<div class="ecjia-nolist">
	<i class="iconfont icon-xiangzi"></i>
	<p>{t}您暂时还没有进行缺货登记哦~{/t}</p>
</div>
<!-- {/foreach} -->
<!-- 缺货登记列表end-->
<!-- {/block} -->