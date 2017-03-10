<?php
/*
Name: 评价晒单
Description: 获取订单内所有商品
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->

<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->

<div>
    <li class="ecjia-order-item ecjia-checkout">
    	<div class="flow-goods-list">
    		<!-- {foreach from=$goods_list item=goods name=goods} -->
    			<ul class="goods-item ecjia-comment-list">
    				<li class="goods-img ecjiaf-fl ecjia-margin-r ecjia-icon">
    					<img class="ecjiaf-fl" src="{$goods.img.thumb}" alt="{$goods.name}" title="{$goods.name}" />
    					<span class="ecjiaf-fl cmt-goods-name">{$goods.name}</span>
    					<span class="ecjiaf-fl cmt-goods-price">{$goods.formated_shop_price}</span>
    					<span class="ecjiaf-fr btn-comment">
    		              <a class="nopjax btn btn-hollow" href='{url path="user/order/goods_comment" args="goods_id={$goods.goods_id}"}'>发表评价</a>
    		            </span>
    				</li>
    			</ul>
    		<!-- {/foreach} -->
    	   </div>
    	</div>
    </li>
</div>
<!-- {/block} -->