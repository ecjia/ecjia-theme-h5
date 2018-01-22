<?php
/*
Name: 返还方式列表模板
Description: 这是返还方式列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<div class="ecjia-user ecjia-margin-b">
	 <div class="ecjia-return-title">快递方式选择</div>
     <ul class="ecjia-list ecjia-return-way-list">
        <li>
			<a class="data-pjax" href="{url path='user/order/return_way'}&order_id={$order_id}&type=visit">
				<div class="ecjia-return-item">
        			<div class="return-item-right">
        				<span class="title">上门取件</span>
        			</div>
        			<i class="iconfont icon-jiantou-right"></i>
        		</div>
        	</a>
		</li>
		
		<li>
			<a class="data-pjax" href="{url path='user/order/return_way'}&order_id={$order_id}&type=shipping">
				<div class="ecjia-return-item">
        			<div class="return-item-right">
        				<span class="title">自选快递</span>
        			</div>
        			<i class="iconfont icon-jiantou-right"></i>
        		</div>
        	</a>
		</li>
		
		<li>
			<a class="data-pjax" href="{url path='user/order/return_way'}&order_id={$order_id}&type=to_store">
				<div class="ecjia-return-item">
        			<div class="return-item-right">
        				<span class="title">到店退货</span>
        			</div>
        			<i class="iconfont icon-jiantou-right"></i>
        		</div>
        	</a>
		</li>
	</ul>
</div>
<!-- {/block} -->	