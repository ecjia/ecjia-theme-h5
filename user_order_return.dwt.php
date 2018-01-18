<?php
/*
Name: 申请售后模板
Description: 这是申请售后首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->

<div class="ecjia-user ecjia-margin-b">
     <ul class="ecjia-list ecjia-return-list">
        <li>
			<a href="{url path='user/quickpay/quickpay_list'}">
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
			<a href="{url path='user/quickpay/quickpay_list'}">
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
</div>
<!-- {/block} -->	