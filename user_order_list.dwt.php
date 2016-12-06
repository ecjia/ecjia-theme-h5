<?php
/*
Name: 获取全部订单模板
Description: 获取全部订单页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	{foreach from=$lang.merge_order_js item=item key=key}
		var {$key} = "{$item}";
	{/foreach}
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="ecjia-order-list ">
	<ul class="ecjia-margin-b" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user_order/async_order_list'}" data-size="10" data-page="1">
		<!-- 订单异步加载 -->
	</ul>
</div>

<!-- <div class="page-content">
    <ul class="ecjia-list">
      <li class="alert-text">Alert With Text</li>
      <li class="alert-text-title">Alert With Text and Title</li>
      <li class="alert-text-title-callback">Alert With Text and Title and Callback</li>
      <li class="alert-text-callback">Alert With Text and Callback</li>
      <li class="confirm-ok">Confirm with text and Ok callback</li>
      <li class="confirm-ok-cancel">Confirm with text, Ok and Cancel callbacks</li>
      <li class="confirm-title-ok">Confirm with text, title and Ok callback</li>
      <li class="confirm-title-ok-cancel">Confirm with text, title, Ok</li>
    </ul>
</div> -->
<script type="text/javascript">
        var myApp = new Framework7();
        // var $ = Dom7;
        $('.alert-text').on('click', function () {
            myApp.alert('Here goes alert text');
        });

        $('.alert-text-title').on('click', function () {
            myApp.alert('Here goes alert text', 'Custom Title!');
        });

        $('.alert-text-title-callback').on('click', function () {
            myApp.alert('Here goes alert text', 'Custom Title!', function () {
                myApp.alert('Button clicked!')
            });
        });

        $('.alert-text-callback').on('click', function () {
            myApp.alert('Here goes alert text', function () {
                myApp.alert('Button clicked!')
            });
        });

        $('.confirm-ok').on('click', function () {
            myApp.confirm('Are you sure?', function () {
                myApp.alert('You clicked Ok button');
            });
        });

        $('.confirm-ok-cancel').on('click', function () {
            myApp.confirm('Are you sure?',
              function () {
                myApp.alert('You clicked Ok button');
              },
              function () {
                myApp.alert('You clicked Cancel button');
              }
            );
        });
        $('.confirm-title-ok').on('click', function () {
            myApp.confirm('Are you sure?', 'Custom Title', function () {
                myApp.alert('You clicked Ok button');
            });
        });
        $('.confirm-title-ok-cancel').on('click', function () {
            myApp.confirm('Are you sure?', 'Custom Title',
              function () {
                myApp.alert('You clicked Ok button');
              },
              function () {
                myApp.alert('You clicked Cancel button');
              }
            );
        });
</script>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
<!-- {foreach from=$order_list1 item=list} -->
		<li class="ecjia-order-item ecjia-checkout ecjia-margin-t">
			<div class="order-hd">
				<a class="ecjiaf-fl" href='{url path="goods/category/store_goods" args="store_id={$list.seller_id}"}'>
					<i class="iconfont icon-shop"></i>{$list.seller_name} <i class="iconfont icon-jiantou-right"></i>
				</a>
				<a class="ecjiaf-fr" href='{url path="user/user_order/order_detail" args="order_id={$list.order_id}"}'><span class="ecjia-color-green">{$list.label_order_status}</span></a>
			</div>
			<div class="flow-goods-list">
				<a class="ecjiaf-db" href='{url path="user/user_order/order_detail" args="order_id={$list.order_id}"}'>
					<ul class="{if count($list.goods_list) > 1}goods-list{else}goods-item{/if}"><!-- goods-list 多个商品隐藏商品名称,goods-item -->
						<!-- {foreach from=$list.goods_list item=goods name=goods} -->
						<!-- {if $smarty.foreach.goods.iteration gt 3} -->
						<!-- 判断不能大于4个 -->
						<li class="goods-img-more">
							<i class="icon iconfont">&#xe62e;</i>
							<p class="ecjia-fz-small">共{$list.goods_number}件</p>
						</li>
						<!-- {break} -->
						<!-- {/if} -->
						<li class="goods-img ecjiaf-fl ecjia-margin-r ecjia-icon">
							<img class="ecjiaf-fl" src="{$goods.img.thumb}" alt="{$goods.name}" title="{$goods.name}" />
							{if $goods.goods_number gt 1}<span class="ecjia-icon-num top">{$goods.goods_number}</span>{/if}
							<span class="ecjiaf-fl goods-name ecjia-truncate2">{$goods.name}</span>
						</li>
						<!-- {/foreach} -->
					</ul>
				</a>
			</div>
			<div class="order-ft">
				<span><a href="#">订单金额：<span class="ecjia-fz-big">{$list.formated_total_fee}</span></a></span>
				<span class="two-btn ecjiaf-fr">
				{if $list.order_status_code eq 'await_pay'} <a class="btn btn-hollow ecjiaf-fr" href="#">去支付</a>
				<!-- if $list.order_status_code eq 'finished' || $list.order_status_code eq 'canceled' -->
				{else} <a class="btn btn-hollow ecjiaf-fr" href='{url path="user/user_order/buy_again" args="order_id={$order.order_id}&from=list"}'>再次购买</a>
				{/if}
				{if $list.shipping_status eq '1'} <a class="btn btn-hollow ecjiaf-fr" href="#">确认收货</a>{/if}
				</span>
			</div>
		</li>
		<!-- {foreachelse} -->
    	<div class="ecjia-nolist">
        	<i class="iconfont icon-icon04"></i>
        	<p>{t}暂无相关订单{/t}</p>
        </div>
		<!-- {/foreach} -->
<!-- {/block} -->
