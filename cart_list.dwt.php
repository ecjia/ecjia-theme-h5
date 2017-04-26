<?php
/*
Name: 购物车列表模板
Description: 购物车列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.category.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- {if !$not_login} -->
	<!-- {if $cart_list} -->
		<div class="ecjia-flow-cart">
			<div class="a4t">
				<div class="a4u">
					<div class="a4v">
						{if $address_id gt 0}
							{$address_info.address}{$address_info.address_info}
						{else}
							{$smarty.cookies.location_name}
						{/if}
						<i>(当前位置)</i>
					</div>
				</div>
				<!-- {foreach from=$cart_list item=val} -->
				<div class="a4w" storeid="10055727" orgcode="74418">
					<div class="a4p">
						<a class="a4x" href="{RC_Uri::url('merchant/index/init')}&store_id={$val.seller_id}&from=cart">{$val.seller_name}{if $val.manage_mode eq 'self'}<span class="self-store">自营</span>{/if}</a>
						<div goodslist="" class="a4y a50">
							<ul>
								<!-- {foreach $val.goods_list key=key item=v} -->
								<li>
									<img src="{$v.img.thumb}">
									{if $v.is_disabled eq 1}
									<div class="product_empty">{$v.disabled_label}</div>
									{/if}
									<em>{if $v.goods_price eq 0}免费{else}{$v.formated_goods_price}{/if}</em>
								</li>
								<!-- {/foreach} -->
							</ul>
							{if $val.total.goods_number gt 3}
							<div class="a4z">共{$val.total.goods_number}件</div>
							{/if}
						</div>
					</div>
				</div>
				<!-- {/foreach} -->
				
<!-- 				<div class="a4u a4u-gray"><div class="a4v">伸大厦<i>(其他位置)</i></div></div> -->
<!-- 				<div class="a4w" storeid="10055727" orgcode="74418"> -->
<!-- 					<div class="a4p"> -->
<!-- 						<a class="a4x">崇明生态农场-澳华店</a> -->
<!-- 						<div goodslist="" class="a4y a50"> -->
<!-- 							<ul> -->
<!-- 								<li> -->
<!-- 									<img src="https://img10.360buyimg.com/n7//jfs/t2140/227/2860302244/172432/9fb9183/56f3f321Nbad2ccff.jpg"> -->
<!-- 									<em>￥7</em> -->
<!-- 								</li> -->
<!-- 								<li> -->
<!-- 									<img src="https://img10.360buyimg.com/n7//jfs/t2887/59/1930100478/162285/fc2aedd8/574f9463Ne8c18b43.jpg"> -->
<!-- 									<em>￥7.4</em> -->
<!-- 								</li> -->
<!-- 								<li> -->
<!-- 									<img src="https://img10.360buyimg.com/n7//jfs/t2611/291/1858504955/168398/b8df4743/574f9f19N580a7df2.jpg">  -->
<!-- 									<em>￥9</em> -->
<!-- 								</li> -->
<!-- 								<li> -->
<!-- 									<img src="https://img10.360buyimg.com/n7//jfs/t2611/291/1858504955/168398/b8df4743/574f9f19N580a7df2.jpg">  -->
<!-- 									<em>￥9</em> -->
<!-- 								</li> -->
<!-- 							</ul> -->
<!-- 							<div class="a4z">共8件</div> -->
<!-- 						</div> -->
<!-- 					</div> -->
<!-- 				</div> -->
			</div>
		</div>
	<!-- {/if} -->
<!-- {/if} -->
	
<div class="flow-no-pro {if $cart_list}hide{elseif $no_login}show{/if}">
	<div class="ecjia-nolist">
		您还没有添加商品
		{if $not_login}
		<a class="btn btn-small" type="button" href="{url path='user/user_privilege/login'}{if $referer_url}&referer_url={$referer_url}{/if}">{t}点击登录{/t}</a>
		{else}
		<a class="btn btn-small" type="button" href="{url path='touch/index/init'}">{t}去逛逛{/t}</a>
		{/if}
	</div>
</div>
<!-- #BeginLibraryItem "/library/address_modal.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/model_bar.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->
{/nocache}