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
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div class="ecjia-order-list ">
	<ul class="ecjia-margin-b">
		<li class="ecjia-order-item ecjia-checkout ecjia-margin-t">
			<div class="order-hd">
				<a class="ecjiaf-db" href="#">
					<i class="iconfont icon-shop"></i>华联-申隆店专营店 <i class="iconfont icon-jiantou-right"></i>
					<span class="ecjiaf-fr ecjia-color-green">待收货</span>
				</a>
			</div>
			<div class="flow-goods-list">
				<a class="ecjiaf-db" href='{url path="user/user_order/order_detail" args="order_id={$list.order_id}"}'>
					<ul class="goods-list"><!-- goods-list 多个商品隐藏商品名称 -->
						<li class="goods-img ecjiaf-fl ecjia-margin-r  ecjia-icon">
							<img class="ecjiaf-fl" src="" alt="" />
							<span class="ecjia-icon-num top">1</span>
							<span class="ecjiaf-fl goods-name ecjia-truncate2">爱大厨四菜私人厨师上门做饭</span>
						</li>
						<li class="goods-img ecjiaf-fl ecjia-margin-r  ecjia-icon">
							<img class="ecjiaf-fl" src="" alt="" />
							<span class="ecjia-icon-num top">1</span>
							<span class="ecjiaf-fl goods-name ecjia-truncate2">爱大厨四菜私人厨师上门做饭</span>
						</li>
						<li class="goods-img ecjiaf-fl ecjia-margin-r  ecjia-icon">
							<img class="ecjiaf-fl" src="" alt="" />
							<span class="ecjia-icon-num top">1</span>
							<span class="ecjiaf-fl goods-name ecjia-truncate2">爱大厨四菜私人厨师上门做饭</span>
						</li>
						<li class="goods-img ecjiaf-fl ecjia-margin-r  ecjia-icon">
							<img class="ecjiaf-fl" src="" alt="" />
							<span class="ecjia-icon-num top">1</span>
							<span class="ecjiaf-fl goods-name ecjia-truncate2">爱大厨四菜私人厨师上门做饭</span>
						</li>
						<!-- 判断不能大于4个 -->
						<li class="goods-img-more">
							<i class="icon iconfont">&#xe62e;</i>
							<p class="ecjia-fz-small">共8件</p>
						</li>
					</ul>
				</a>
			</div>
			<div class="order-ft">
				<span><a href="#">订单金额：<span class="ecjia-fz-big">￥15.50</span></a></span>
				
				<span class="two-btn ecjiaf-fr">
					<a class="btn  ecjiaf-fr" href="#">确认收货</a>
					<a class="btn  ecjiaf-fr" href="#">再次购买</a>
				</span>
			</div>
		</li>

		<li class="ecjia-order-item ecjia-checkout ecjia-margin-t">
			<div class="order-hd">
				<i class="iconfont icon-shop"></i>华联-申隆店专营店 <i class="iconfont icon-jiantou-right"></i>
				<span class="ecjiaf-fr ecjia-color-green">待收货</span>
			</div>
			<div class="flow-goods-list">
				<a class="ecjiaf-db" href='{url path="user/user_order/order_detail" args="order_id={$list.order_id}"}'>
				<ul class="goods-item"><!-- goods-item -->
					<li class="goods-img ecjiaf-fl ecjia-margin-r  ecjia-icon">
						<img class="ecjiaf-fl" src="" alt="" />
						<span class="ecjia-icon-num top">1</span>
						<span class="ecjiaf-fl goods-name ecjia-truncate2">爱大厨四菜私人厨师上门做饭</span>
					</li>
				</ul>
				</a>
			</div>
			<div class="order-ft">
				<span>订单金额：<span class="ecjia-fz-big">￥155.50</span></span>
				<span class="two-btn ecjiaf-fr">
					<a class="btn  ecjiaf-fr" href="#">再次购买</a>
				</span>
			</div>
		</li>
	</ul>
</div>

<div class="page-content">
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
</div>
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
