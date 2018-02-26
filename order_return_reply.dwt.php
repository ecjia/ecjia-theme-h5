<?php
/*
Name: 申请售后模板
Description: 这是申请售后首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.return_order();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<form name='theForm' action="{url path='user/order/add_return'}" enctype="multipart/form-data" method="post">
	<div class="ecjia-order-detail">
		<div class="ecjia-checkout ecjia-margin-b">
			<div class="flow-goods-list">
				<ul class="goods-item">
					<!-- {foreach from=$order.goods_list item=goods} -->
					<li>
						<div class="ecjiaf-fl goods-img">
							<img src="{$goods.img.thumb}" alt="{$goods.name}" title="{$goods.name}" />
						</div>
						<div class="ecjiaf-fl goods-info">
							<p class="ecjia-truncate2">{$goods.name}</p>
							<p class="ecjia-goods-attr goods-attr">
							<!-- {foreach from=$goods.goods_attr item=attr} -->
							{if $attr.name}{$attr.name}:{$attr.value}{/if}
							<!-- {/foreach} -->
							</p>
							<p class="ecjia-color-red goods-attr-price">{$goods.formated_shop_price}</p>
						</div>
						<span class="ecjiaf-fr goods-price"> x {$goods.goods_number}</span>
					</li>
					<!-- {/foreach} -->
				</ul>
				
				<ul class="goods-item">
					<li>
						<div class="ecjiaf-fl goods-img">
							<img src="" alt="{$goods.name}" title="{$goods.name}" />
						</div>
						<div class="ecjiaf-fl goods-info">
							<p class="ecjia-truncate2">精品红霞草莓32粒</p>
							<p class="ecjia-goods-attr goods-attr">
							<!-- {foreach from=$goods.goods_attr item=attr} -->
							{if $attr.name}{$attr.name}:{$attr.value}{/if}
							<!-- {/foreach} -->
							</p>
							<p class="ecjia-color-red goods-attr-price">￥19.90</p>
						</div>
						<span class="ecjiaf-fr goods-price"> x 1</span>
					</li>
				</ul>
				
				<ul class="ecjia-list">
					<li>退商品金额<span class="ecjiaf-fr ">￥14.90</span></li>
					<li>退配送费<i class="k0 shipping_fee_notice"></i><span class="ecjiaf-fr ">￥5.00</span></li>
					<li>退总金额<span class="ecjiaf-fr ecjia-red">￥19.90</span></li>
					<li class="notice">
						<div class="notice-content">
							<span class="title">温馨提示：</span>
							<div class="content">
							1.退商品金额是按照您实际支付的商品金额进行退回，如有问题，请联系ECJia到家客服。<br/>
							2.如需退货请准备好发票，附件等资料，与商品一并寄回。
							</div>
						</div>
					</li>
					<li class="return-reason">
						<span class="input-must">*</span>
						<span class="title">售后原因</span>
						<div class="choose_reason">
							<span>请选择售后原因</span>
							<img src="{$theme_url}images/address_list/down_eee.png"></i>
						</div>
					</li>
					<li class="return-reason">
						<span class="input-must">*</span>
						<span class="title">问题描述</span>
						<span class="text">
							<input class="question_desc" type="text" name="question_desc" placeholder="请填写问题描述" />
						</span>
					</li>
					
					<li class="ecjia-met-goods-info">
						<div class="push_img">
							<div class="push_photo_img" id="result"></div>
			            	<div class="push_photo" id="result0">
			            	   <div class="push_result_img">
			            	       <img src="{$theme_url}images/photograph.png">
			            	       <input type="file" class="push_img_btn" id="filechooser0" name="picture[]" accept="image/jpeg,image/jpg,image/png,image/bmp,image/gif">
			            	   </div>
			            	</div>
			            	<div class="push_photo" id="result1">
			            	   <div class="push_result_img">
			            	       <img src="{$theme_url}images/photograph.png">
			            	       <input type="file" class="push_img_btn" id="filechooser1" name="picture[]" accept="image/jpeg,image/jpg,image/png,image/bmp,image/gif">
			            	   </div>
			            	</div>
			            	<div class="push_photo" id="result2">
			            	   <div class="push_result_img">
			            	       <img src="{$theme_url}images/photograph.png">
			            	       <input type="file" class="push_img_btn" id="filechooser2" name="picture[]" accept="image/jpeg,image/jpg,image/png,image/bmp,image/gif">
			            	   </div>
			            	</div>
			            	<div class="push_photo" id="result3">
			            	   <div class="push_result_img">
			            	       <img src="{$theme_url}images/photograph.png">
			            	       <input type="file" class="push_img_btn" id="filechooser3" name="picture[]" accept="image/jpeg,image/jpg,image/png,image/bmp,image/gif">
			            	   </div>
			            	</div>
			            	<div class="push_photo" id="result4">
			            	   <div class="push_result_img">
			            	       <img src="{$theme_url}images/photograph.png">
			            	       <input type="file" class="push_img_btn" id="filechooser4" name="picture[]" accept="image/jpeg,image/jpg,image/png,image/bmp,image/gif">
			            	   </div>
			            	</div>
		                </div>
		                <p class="push_img_fonz">为了帮助我们更好的解决问题，请上传照片，最多5张。</p>
					</li>
				</ul>
			</div>
			
			<div class="order-ft-link">
				<input type="hidden" name="order_id" value="{$order_id}">
				<input class="btn btn-small btn-hollow" name="add-return-btn" type="submit" value="提交"/>
			</div>
		</div>
	</div>
</form>
<input type="hidden" name="reason_list" value='{$reason_list}'>
<!-- #BeginLibraryItem "/library/shipping_fee_modal.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->