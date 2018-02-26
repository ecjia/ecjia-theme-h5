<?php
/*
Name: 申请售后列表模板
Description: 这是申请售后列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<div class="ecjia-user ecjia-margin-b">
	 <div class="ecjia-return-title">售后类型选择</div>
     <ul class="ecjia-list ecjia-return-list">
        <li>
			<a class="data-pjax" href="{url path='user/order/return_order'}&type=refund&order_id={$order_id}">
				<div class="ecjia-return-item">
        			<img class="return-item-icon" src="{$theme_url}images/user_center/return_order.png">
        			<div class="return-item-right">
        				<span class="title">仅退款</span>
        				<p class="notice">全部商品/部分商品未收到，或商家协商同意</p>
        			</div>
        			<i class="iconfont icon-jiantou-right"></i>
        		</div>
        	</a>
		</li>
		
		<li>
			<a class="data-pjax" href="{url path='user/order/return_order'}&type=return&order_id={$order_id}">
				<div class="ecjia-return-item">
        			<img class="return-item-icon" src="{$theme_url}images/user_center/quickpay.png">
        			<div class="return-item-right">
        				<span class="title">退货退款</span>
        				<p class="notice">如您已收到商品或收到送错的商品</p>
        			</div>
        			<i class="iconfont icon-jiantou-right"></i>
        		</div>
        	</a>
		</li>
    </ul>
    
    <div class="ecjia-return-title">售后进度查询</div>
    <div class="ecjia-return-list">
		<div class="a7 ah">
			<ul class="a8 ao">
				<li class="ai">
					<a class="data-pjax" href="{url path='user/order/return_detail'}&order_id={$order_id}">
						<h4 class="aq">服务单号：<em>20564080</em></h4>
						<div class="ar">
							<span class="as"><img class="at" src=""></span>
							<span class="as"><img class="at" src=""></span>
							<span class="as"><img class="at" src=""></span>
							<span class="as none"><img class="at" src=""></span>
							<em class="av">共1件</em><em class="aw">退款：¥6.01</em>
						</div>
						<div class="ay h">
							<img class="ab" src="{$theme_url}images/user_center/return_order.png"><span class="audit_result">退款, 退款成功</span><em class="sales_view_details">查看详情</em>
						</div>
					</a>
				</li>
			</ul>
		</div>
		
     </div>
</div>
<!-- {/block} -->	