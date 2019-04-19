<?php
/*
Name: 商品描述模板
Description: 这是商品描述首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.touch.goods_detail.init();
ecjia.touch.category.init();
{if $is_weixin}
var config = '{$config}';
{/if}

{if $releated_goods}
var releated_goods = {$releated_goods};
{/if}
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-goods-detail-header ecjia-header-index" style="background:#47aa4d none repeat scroll 0 0;">
	<ul>
		<li><a class="goods-tab tab1 active" href="javascript:;" data-type="1">{t domain="h5"}商品{/t}</a></li>
		<li><a class="goods-tab tab2" href="javascript:;" data-type="2">{t domain="h5"}详情{/t}</a></li>
		<li><a class="goods-tab tab3" href="javascript:;" data-type="3">{t domain="h5"}评价{/t}</a></li>
	</ul>
</div>
{if $no_goods_info eq 1}
<div class="ecjia-no-goods-info">{t domain="h5"}不存在的信息{/t}</div>
{/if}
<!-- 切换商品页面start -->
{if $no_goods_info neq 1}
<div class="ecjia-goods-basic-info" id="goods-info-one">
	<!--商品图片相册start-->
	<div class="focus" id="focus">
		<div class="hd">
			<ul></ul>
		</div>
		<div class="bd">
			<!-- Swiper -->
			<div class="swiper-container swiper-goods-img">
				<div class="swiper-wrapper">
					{if $goods_info.pictures}
					<!--{foreach from=$goods_info.pictures item=picture}-->
					<div class="swiper-slide" style="margin-top:3.5em;">
						<span class="wheel-planting-goods-img">
							<img src="{$picture.thumb}" style="height: 40rem;" /></span>
					</div>
					<!--{/foreach}-->
					{else}
					<div class="swiper-slide">
						<img src="{$theme_url}images/default-goods-pic.png" />
					</div>
					{/if}
				</div>
				<!-- Add Pagination -->
				{if count($goods_info.pictures) > 1}
				<div class="swiper-pagination"></div>
				{/if}
			</div>
		</div>
	</div>
	<!--商品图片相册end-->
	<!--商品属性介绍-->
	<form action="{url path='cart/index/add_to_cart'}" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY">
		<div class="goods-info">
			<div class="goods-info-property  goods-info-property-new">
				<!--商品描述-->
				<div class="goods-style-name goods-style-name-new">
					<div class=" ecjiaf-fl goods-name-new">
						{if $goods_info.groupbuy_info}
						<span class="background-ff8214">{t domain="h5"}团{/t}</span>
						{else}
						{if $goods_info.merchant_info.manage_mode eq 'self'}<span>{t domain="h5"}自营{/t}</span>{/if}
						{/if}
						{$goods_info.goods_name}
					</div>
				</div>
				{if $goods_info.groupbuy_info}
				<div class="goods-groupbuy-div">
					<div class="groupbuy-left {if $goods_info.groupbuy_info.deposit neq 0 && $goods_info.groupbuy_info.left_num}two-line{/if}">
						{if $goods_info.groupbuy_info.left_num}
						<p>{t domain="h5" 1={$goods_info.groupbuy_info.left_num}}还剩 %1 份{/t}</p>
						{/if}
						{if $goods_info.groupbuy_info.deposit neq 0}
						<p>{t domain="h5"}保证金：{/t}{$goods_info.groupbuy_info.formated_deposit}</p>
						{/if}
					</div>

					<div class="groupbuy-right">
						<p>{t domain="h5"}距离团购结束{/t}</p>
						<span class="goods-detail-promote" data-type="2" value="{$goods_info.promote_end_time}"></span>
					</div>
				</div>
				{/if}
				<div class="goods-price goods-price-new" goods_id="{$goods_info.id}" data-deposit="{$goods_info.groupbuy_info.deposit}"
				 data-price="{$goods_info.promote_price}" data-priceladder='{$goods_info.groupbuy_info.price_ladder}'>
					<!-- $goods.is_promote and $goods.gmt_end_time -->

					<!--{if ($goods_info.promote_price gt 0) AND ($goods_info.promote_start_date lt $goods_info.promote_end_date) AND ($goods_info.promote_price lt $goods_info.unformatted_shop_price)} 促销-->

					<div class="ecjia-price-time">
						<div class="time-left">
							<span class="ecjia-promote_price-span">{$goods_info.formated_promote_price}</span>
							<del>{t domain="h5"}原价：{/t}{$goods_info.unformatted_shop_price}</del></br>
							{if !$goods_info.groupbuy_info}
							<div class="ecjia-left-time">
								<span class="detail-clock-icon"></span>
								<span class="goods-detail-promote" data-type="1" value="{$goods_info.promote_end_time}"></span>
							</div>
							{/if}
						</div>

						{if $goods_info.shop_closed neq 1}
						<div class="cart-plus-right goods_spec_{$goods_info.id}" goods_id="{$goods_info.id}">
							{if $goods_info.specification}
							<span class="goods-add-cart choose_attr {if $goods_info.in_related_goods eq 1}spec_goods{/if}" goods_id="{$goods_info.id}">{t domain="h5"}选规格{/t}</span>
							{if $goods_attr_num}<i class="attr-number" style="right: 0.2em;top: 0.2em;">{$goods_attr_num}</i>{/if}
							{else}
							<span class="goods-add-cart add-cart-a {if $rec_id}hide{/if}" data-toggle="{if !$goods_info.groupbuy_info}add-to-cart{else}add-goods{/if}"
							 goods_id="{$goods_info.id}" act_id="{$goods_info.goods_activity_id}">{t domain="h5"}加入购物车{/t}</span>
							<div class="ecjia-goods-plus-box {if !$rec_id}hide{/if} box" id="goods_{$goods_info.id}">
								<span class="reduce" data-toggle="{if !$goods_info.groupbuy_info}remove-to-cart{else}remove-goods{/if}" rec_id="{$rec_id}">{t domain="h5"}减{/t}</span>
								<label>{if !$rec_id}1{else}{$num}{/if}</label>
								<span class="add detail-add" data-toggle="{if !$goods_info.groupbuy_info}add-to-cart{else}add-goods{/if}"
								 rec_id="{$rec_id}" goods_id="{$goods_info.id}">{t domain="h5"}加{/t}</span>
							</div>
							{/if}
						</div>
						{/if}
					</div>
					<!--{else}-->
					{if $goods_info.default_product_spec.product_shop_price_label neq ''}
					<span class="ecjia-price-span">{$goods_info.default_product_spec.product_shop_price_label}</span>
					{else}
					<span class="ecjia-price-span">{$goods_info.shop_price}</span>
					{/if}	
						
					{if $goods_info.market_price}
                    <del>{t domain="h5"}市场价：{/t}{$goods_info.market_price}</del>
                    {/if}

					{if $goods_info.shop_closed neq 1}
					{if $goods_info.specification}
					<span class="goods_spec_{$goods_info.id}">
						<span class="goods-add-cart choose_attr {if $goods_info.in_related_goods eq 1}spec_goods{/if}" goods_id="{$goods_info.id}">{t domain="h5"}选规格{/t}</span>
						{if $goods_attr_num}<i class="attr-number">{$goods_attr_num}</i>{/if}
					</span>
					{else}
					<span class="goods-add-cart market-goods-add-cart add-cart-a {if $rec_id}hide{/if}" data-toggle="{if !$goods_info.groupbuy_info}add-to-cart{else}add-goods{/if}"
					 rec_id="{$rec_id}" goods_id="{$goods_info.id}" act_id="{$goods_info.goods_activity_id}">{t domain="h5"}加入购物车{/t}</span>
					<div class="ecjia-goods-plus-box ecjia-market-plus-box {if !$rec_id}hide{/if} box" id="goods_{$goods_info.id}">
						<span class="reduce" data-toggle="{if !$goods_info.groupbuy_info}remove-to-cart{else}remove-goods{/if}" rec_id="{$rec_id}">{t domain="h5"}减{/t}</span>
						<label>{if !$rec_id}1{else}{$num}{/if}</label>
						<span class="add detail-add" data-toggle="{if !$goods_info.groupbuy_info}add-to-cart{else}add-goods{/if}" rec_id="{$rec_id}"
						 goods_id="{$goods_info.id}">{t domain="h5"}加{/t}</span>
					</div>
					{/if}
					{/if}
					<!-- {/if} -->

					{if $goods_info.groupbuy_info.groupbuy_price_ladder neq '' || $goods_info.groupbuy_info.groupbuy_activity_desc neq ''}
					<div class="groupbuy_notice">
						{if $goods_info.groupbuy_info.groupbuy_price_ladder neq ''}
						<div class="item">
							<div class="left">{t domain="h5"}价格阶梯{/t}</div>
							<div class="right">{$goods_info.groupbuy_info.groupbuy_price_ladder}</div>
						</div>
						{/if}
						{if $goods_info.groupbuy_info.groupbuy_activity_desc neq ''}
						<div class="item">
							<div class="left">{t domain="h5"}活动说明{/t}</div>
							<div class="right">{$goods_info.groupbuy_info.groupbuy_activity_desc}</div>
						</div>
						{/if}
					</div>
					{/if}
					{if $goods_info.default_product_spec.product_goods_attr_label neq ''}
					<div class="groupbuy_notice">
						<div class="item">
							<div class="left" style="width:3em;">{t domain="h5"}已选{/t}</div>
							<div class="right" style="margin-left:3em;">{$goods_info.default_product_spec.product_goods_attr_label}</div>
						</div>
					</div>
					{/if}
				</div>
				<!-- {if $goods_info.favourable_list} -->
				<div class="ecjia-favourable-goods-list">
					<ul class="store-promotion">
						<!-- {foreach from=$goods_info.favourable_list item=favour  name=foo} -->
						<!-- {if $smarty.foreach.foo.index < 2 } -->
						<li class="promotion">
							<span class="promotion-label">{$favour.type_label}</span>
							<span class="promotion-name">{$favour.name}</span>
						</li>
						<!-- {/if} -->
						<!-- {/foreach} -->
					</ul>
				</div>
				<!-- {/if} -->
				<input type="hidden" value="{RC_Uri::url('cart/index/update_cart')}" name="update_cart_url" />
				<input type="hidden" value="{$goods_info.seller_id}" name="store_id" />
			</div>
			<a class="nopjax external" href='{url path="merchant/index/init" args="store_id={$goods_info.seller_id}"}'>
				<div class="bd goods-type ecjia-margin-t store-name">
					<div class="goods-option-con goods-num goods-option-con-new">
						<div class="ecjia-merchants-name">
							<span class="shop-title-name"><i class="iconfont icon-shop"></i>{$goods_info.seller_name}</span>
							<i class="iconfont icon-jiantou-right"></i>
						</div>
					</div>
				</div>
			</a>

			<a class="goods-tab tab3" href="javascript:;" data-type="3">
				<div class="bd goods-type ecjia-margin-t">
					<div class="goods-option-con goods-num goods-option-con-new">
						<div class="ecjia-merchants-name">
							{if $comment_list.list}
							<span class="shop-title-name">{t domain="h5" 1={$comment_number.all}}商品评价(%1人评价){/t}</span>
							<i class="iconfont icon-jiantou-right"></i>
							<span class="comment_score">{$comment_list.comment_percent}{t domain="h5"}好评{/t}</span>
							{else}
							<span class="shop-title-name">{t domain="h5"}商品评价{/t}</span>
							<i class="iconfont icon-jiantou-right"></i>
							{/if}
						</div>
					</div>
				</div>
			</a>
			{if $comment_list.list}
			<div class="ecjia-goods-comment ecjia-seller-comment border_t_e">
				<!-- {foreach from=$comment_list.list item=comment key=key} -->
				{if $key lt 5}
				<div class="assess-flat">
					<div class="assess-wrapper">
						<div class="assess-top">
							<span class="user-portrait"><img src="{if $comment.avatar_img}{$comment.avatar_img}{else}{$theme_url}images/default_user.png{/if}"></span>
							<div class="user-right">
								<span class="user-name">{$comment.author}</span>
								<span class="assess-date">{$comment.add_time}</span>
							</div>
							<p class="comment-item-star score-goods" data-val="{$comment.rank}"></p>
						</div>
						<div class="assess-bottom">
							<p class="assess-content">{$comment.content}</p>
							<p class="goods-attr">{$comment.goods_attr}</p>
							<!-- {if $comment.picture} -->
							<div class="img-list img-pwsp-list" data-pswp-uid="{$key}">
								<!-- {foreach from=$comment.picture item=img} -->
								<figure><span><a class="nopjax external" href="{$img}"><img src="{$img}" /></a></span></figure>
								<!-- {/foreach} -->
							</div>
							<!-- {/if} -->
							{if $comment.reply_content}
							<div class="store-reply">{t domain="h5"}商家回复：{/t}{$comment.reply_content}</div>
							{/if}
						</div>
					</div>
				</div>
				{/if}
				<!-- {/foreach} -->
			</div>
			{/if}

			<!-- {if $goods_info.related_goods} -->
			<div class="address-warehouse ecjia-margin-t address-warehouse-new">
				<div class="ecjia-form">
					<div class="may-like-literal"><span class="may-like">{t domain="h5"}猜你喜欢{/t}</span></div>
				</div>
				<div class="ecjia-margin-b form-group ecjia-form">
					<div class="bd">
						<ul class="ecjia-list ecjia-like-goods-list">
							<!--{foreach from=$goods_info.related_goods item=goods name=goods}-->
							<!-- {if $smarty.foreach.goods.index < 6 } -->
							<li>
								<a class="nopjax external" href='{url path="goods/index/show" args="goods_id={$goods.goods_id}"}'>
									<span class="like-goods-img">
										<img src="{$goods.img.url}" alt="{$goods.name}" title="{$goods.name}" /></span>
								</a>
								<p class="link-goods-name ecjia-goods-name-new">{$goods.name}</p>
								<div class="link-goods-price">
									<!--{if $goods.promote_price}-->
									<span class="goods-price">{$goods.promote_price}</span>
									<!--{else}-->
									<span class="goods-price">{$goods.shop_price}</span>
									<!--{/if}-->

									{if $goods_info.shop_closed neq 1}
										{if $goods.specification}
										<div class="goods_attr goods_spec_{$goods.id}" goods_id="{$goods_info.id}">
											<span class="choose_attr spec_goods" rec_id="{$goods.rec_id}" goods_id="{$goods.id}" data-num="{$goods.num}"
											data-spec="{$goods.default_spec}" data-url="{RC_Uri::url('cart/index/check_spec')}" data-store="{$store_id}">{t domain="h5"}选规格{/t}</span>
											{if $goods.num}<i class="attr-number">{$goods.num}</i>{/if}
										</div>
										{else}
										<span class="goods-price-plus may_like_{$goods.id}" data-toggle="add-to-cart" rec_id="{$goods.rec_id}"
										goods_id="{$goods.id}" data-num="{$goods.num}"></span>
										{/if}
									{/if}
								</div>
							</li>
							<!--{/if}-->
							<!--{/foreach}-->
						</ul>
					</div>
				</div>
			</div>
			<!-- {/if} -->
		</div>
	</form>
</div>
{/if}
<!-- 切换商品页面end -->

<!-- 切换详情页面start -->
{if $no_goods_info neq 1}
<div class="goods-desc-info active" id="goods-info-two" style="margin-top:3.5em;">
	<!--商品描述-->
	<!-- Nav tabs -->
	<ul class="ecjia-list ecjia-list-new ecjia-list-two ecjia-list-two-new ecjia-nav ecjia-nav-new goods-desc-nav-new">
		<li class="active goods-desc-li-info one-li" data-id="1">
			<a class="a1" href="javascript:;">{t domain="h5"}图文详情{/t}</a>
			<span class="goods-detail-title-border"></span>
		</li>
		<li class="goods-desc-li-info two-li" style="border-left:none;" data-id="2"><a class="a2" href="javascript:;">{t domain="h5"}规格参数{/t}</a></li>
	</ul>
	<!-- Tab panes -->
	<div class="goods-describe ecjia-margin-b active" id="one-info">
		<!-- {if $goods_desc && $goods_desc neq ''} -->
		{$goods_desc}
		<!-- {else} -->
		<div class="ecjia-nolist">
			<img src="{$theme_url}images/wallet/null280.png">
			<p class="tags_list_font">{t domain="h5"}暂无任何商品详情{/t}</p>
		</div>
		<!-- {/if} -->
	</div>
	<div class="goods-describe goods-describe-new ecjia-margin-b" id="two-info">
		<!-- {if $goods_info.properties} -->
		<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#dddddd">
			<!-- {foreach from=$goods_info.properties item=property_group} -->
			<tr>
				<td bgcolor="#FFFFFF" align="left" width="40%" class="f1">{$property_group.name|escape:html}</td>
				<td bgcolor="#FFFFFF" align="left" width="60%">{$property_group.value}</td>
			</tr>
			<!-- {/foreach}-->
		</table>
		<!-- {else} -->
		<div class="ecjia-nolist">
			<img src="{$theme_url}images/wallet/null280.png">
			<p class="tags_list_font">{t domain="h5"}暂无任何规格参数{/t}</p>
		</div>
		<!-- {/if} -->
	</div>
</div>
{/if}
<!-- 切换详情页面end -->

<div class="goods-desc-info active ecjia-seller-comment" id="goods-info-three" style="margin-top:7.5em;">
<!-- #BeginLibraryItem "/library/goods_comment.lbi" --><!-- #EndLibraryItem -->
</div>

<div class="store-add-cart a4w">
	<div class="a52"></div>
	{if !$goods_info.groupbuy_info}
	<a href="javascript:void 0;" class="a4x {if $real_count.goods_number}light{else}disabled{/if} outcartcontent show show_cart"
	 show="false">
		{if $real_count.goods_number}
		<i class="a4y">
			{if $real_count.goods_number gt 99}99+{else}{$real_count.goods_number}{/if}
		</i>
		{/if}
	</a>
	{/if}
	<div class="a4z {if $goods_info.groupbuy_info}m_l1{/if}" style="transform: translateX(0px);">
		{if $goods_info.shop_closed eq 1}
		<div class="a61">{t domain="h5"}商家打烊了{/t}</div>
		<div class="a62">{t domain="h5"}营业时间{/t} {$goods_info.label_trade_time}</div>
		{else if !$goods_info.groupbuy_info}
			{if !$real_count.goods_number}
			<div class="a50">{t domain="h5"}购物车是空的{/t}</div>
			{else}
			<div>
				{$count.goods_price}{if $count.discount neq 0}<label>{t domain="h5" 1={$count.discount}}(已减%1){/t}</label>{/if}
			</div>
			{/if}
		{/if}
	</div>
	<a class="a51 {if !$count.check_one || $count.meet_min_amount neq 1}disabled{/if} {if $goods_info.groupbuy_info}check_groupbuy_cart disabled{else}check_cart{/if}"
	 {if $goods_info.groupbuy_info} data-href="{RC_Uri::url('cart/flow/add_groupbuy')}" data-goods="{$goods_info.id}"
	 data-act="{$goods_info.goods_activity_id}" {else} data-href="{RC_Uri::url('cart/flow/checkout')}" {/if} data-store="{$goods_info.seller_id}"
	 data-address="{$address_id}" data-rec="{$data_rec}" href="javascript:;" data-text='{if $goods_info.groupbuy_info}{t domain="h5"}立即购买{/t}{else}{t domain="h5"}去结算{/t}{/if}'>
		{if $count.meet_min_amount eq 1 || !$count.label_short_amount}{if $goods_info.groupbuy_info}{t domain="h5"}立即购买{/t}{else}{t domain="h5"}去结算{/t}{/if}{else}{t domain="h5" 1={$count.label_short_amount}}还差%1起送{/t}{/if}
	</a>

	<div class="minicart-content" style="transform: translateY(0px); display: block;">
		<a href="javascript:void 0;" class="a4x {if $count.goods_number}light{else}disabled{/if} incartcontent show_cart"
		 show="false">
			{if $real_count.goods_number}
			<i class="a4y">
				{if $real_count.goods_number gt 99}99+{else}{$real_count.goods_number}{/if}
			</i>
			{/if}
		</a>
		<i class="a57"></i>
		<div class="a58 ">
			<span class="a69 a6a {if $count.check_all}checked{/if}" data-toggle="toggle_checkbox" data-children=".checkbox" id="checkall">{t domain="h5"}全选{/t}</span>
			<p class="a6c">{t domain="h5" 1={$count.goods_number}}(已选%1件){/t}</p>
			<a href="javascript:void 0;" class="a59" data-toggle="deleteall" data-url="{RC_Uri::url('cart/index/update_cart')}">{t domain="h5"}清空购物车{/t}</a>
		</div>

		<div class="a5b" style="max-height: 21em;">
			<div class="a5l single">
				{if $goods_info.favourable_list}
				<ul class="store-promotion" id="store-promotion">
					<!-- {foreach from=$goods_info.favourable_list item=list} -->
					<li class="promotion">
						<span class="promotion-label">{$list.type_label}</span>
						<span class="promotion-name">{$list.name}</span>
					</li>
					<!-- {/foreach} -->
				</ul>
				{/if}
				<ul class="minicart-goods-list single">
					<!-- {foreach from=$cart_list item=cart} -->
					<li class="a5n single {if $cart.is_disabled eq 1}disabled{/if}">
						<span class="a69 a5o {if $cart.is_checked}checked{/if} checkbox {if $cart.is_disabled eq 1}disabled{/if}"
						 data-toggle="toggle_checkbox" rec_id="{$cart.rec_id}"></span>
						<table class="a5s">
							<tbody>
								<tr>
									<td style="width:75px; height:75px">
										<img class="a7g" src="{$cart.img.small}">
										<div class="product_empty">
											{if $cart.is_disabled eq 1}{$cart.disabled_label}{/if}
										</div>
									</td>
									<td>
										<div class="a7j">{$cart.goods_name}</div>
										{if $cart.attr}<div class="a7s">{$cart.attr}</div>{/if}
										<span class="a7c">
											{if $cart.goods_price eq 0}{t domain="h5"}免费{/t}{else}{$cart.formated_goods_price}{/if}
										</span>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="box" id="goods_cart_{$cart.id}">
							<span class="a5u reduce {if $cart.is_disabled eq 1}disabled{/if} {if $cart.attr}attr_spec{/if}" data-toggle="remove-to-cart"
							 rec_id="{$cart.rec_id}" goods_id="{$cart.id}"></span>
							<lable class="a5x" {if $cart.is_disabled neq 1}data-toggle="change-number" {/if} rec_id="{$cart.rec_id}"
							 goods_id="{$cart.goods_id}" goods_num="{$cart.goods_number}">{$cart.goods_number}</lable>
							<span class="a5v {if $cart.is_disabled eq 1}disabled{/if} {if $cart.attr}attr_spec{/if}" data-toggle="add-to-cart"
							 rec_id="{$cart.rec_id}" goods_id="{$cart.id}"></span>
						</div>
					</li>
					<input type="hidden" name="rec_id" value="{$cart.rec_id}" />
					<!-- {/foreach} -->
				</ul>
				<div class="a5m single"></div>
			</div>
		</div>
	</div>
</div>
<!-- 遮罩层 -->
<div class="a53" style="display: none;"></div>
<input type="hidden" name="share_title" value="{$goods_info.goods_name}">
<input type="hidden" name="share_desc" value="{$goods_info.goods_brief}">
<input type="hidden" name="share_image" value="{$goods_info.img.thumb}">
<input type="hidden" name="share_link" value="{$share_link}">
<input type="hidden" name="share_page" value="1">

<!-- #BeginLibraryItem "/library/address_modal.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/goods_attr_modal.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/goods_attr_static_modal.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/preview_image.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/change_goods_num.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->
{/nocache}