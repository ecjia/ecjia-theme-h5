<?php
/*
Name: 邀请注册模板
Description: 这是邀请注册首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.affiliate();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-card-box">
	<div class="ecjia-card-top">
		<img src="{$theme_url}images/user_card.png">
	</div>
	
	<div class="ecjia-card-list">
		<ul class="ecjia-grade-goods">
			<!-- {foreach from=$data item=list}-->
			<li class="grade-goods-info">
				<div class="basic-info">
					<div class="grade-goods-left">
						<a class="goods-logo nopjax external" href="">
							<img src="{$list.goods.img.thumb}">
						</a>
					</div>
					
					<div class="grade-goods-right">
						<span class="grade-goods-name">{$list.goods.name}</span>
						<div class="grade-goods-range">
							<span class="goods-price">{$list.goods.formatted_shop_price}</span>
							<a href='{url path="user/card/buy_now"}&store_id={$list.goods.store_id}&goods_id={$list.goods.id}'>
								<span class="card-quickpay-btn">立即购买</span>
							</a>
						</div>		
						<a href='{url path="user/card/user_grade_intro"}&grade_id={$list.grade_id}'><p class="grade-intro"><i class="icon-grade-intro"></i>权益介绍</p></a>
					</div>					
				</div>
			</li>
			<!-- {/foreach} -->
		</ul>
	</div>
</div>

<!-- {/block} -->
{/nocache}