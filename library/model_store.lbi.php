<?php
/*
Name: 首页推荐商家
Description: 这是推荐商家
Libraries: suggest_store
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-mod ecjia-margin-b goods-index-list ecjia-new-goods" style="border-bottom:none;">
	<div class="hd">
		<h2>
			<span class="line"></span>
			<span class="goods-index-title"><i class="icon-goods-hot"></i>热门推荐</span>
		</h2>
	</div>
	<ul class="ecjia-suggest-store">
		<li class="store-info">
			<div class="basic-info">
				<div class="store-left">
					<a href="{RC_Uri::url('merchant/index/init')}&store_id=65">
						<img src="https://cityo2o.ecjia.com/content/uploads/merchant/65/data/shop_logo/1478541882615669409.png">
					</a>
				</div>
				<div class="store-right">
					<a href="{RC_Uri::url('merchant/index/init')}&store_id=65">
					<div class="store-name">
						清谷田园专营店<span class="manage_mode">自营</span>
						<span class="store-distance">2.16km</span>
					</div>
					<div class="store-range">
						<i class="iconfont icon-remind"></i>8:00 - 21:00
					</div>
					<div class="store-notice">
						<i class="iconfont icon-notification"></i>致力做更好吃的水果，不好吃三五退货！
					</div>
					<ul class="store-promotion">
						<li class="promotion">
							<span class="promotion-label">满减</span>
							<span class="promotion-name">金秋十月豪礼满100减20</span>
						</li>
						<li class="promotion">
							<span class="promotion-label">满减</span>
							<span class="promotion-name">金秋十月豪礼满100减20</span>
						</li>
					</ul>
					</a>
					<div class="suggest-goods-list">
						<a href=""><img src="https://cityo2o.ecjia.com/content/uploads/images/201604/thumb_img/682_thumb_G_1459450760028.jpg"></a>
						<a href=""><img src="https://cityo2o.ecjia.com/content/uploads/images/201604/thumb_img/682_thumb_G_1459450760028.jpg"></a>
						<a href=""><img src="https://cityo2o.ecjia.com/content/uploads/images/201604/thumb_img/682_thumb_G_1459450760028.jpg"></a>
						<a href=""><img src="https://cityo2o.ecjia.com/content/uploads/images/201604/thumb_img/682_thumb_G_1459450760028.jpg"></a>
					</div>
				</div>
				<div class="clear_both"></div>
			</div>
		</li>
	</ul>
</div>