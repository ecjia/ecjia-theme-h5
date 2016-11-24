<?php 
/*
Name: 店铺商品
Description: 这是店铺商品页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.category.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-header ecjia-store-banner">
	<div class="ecjia-header-left">
		<a href="javascript:ecjia.touch.history.back();">
			<i class="iconfont icon-jiantou-left"></i>
			<img src="{$store_info.seller_banner}">
		</a>
	</div>
</div>

<div class="ecjia-store-brief">
	<li class="store-info">
		<a href="{RC_Uri::url('goods/category/store_detail')}&store_id={$store_info.id}">
			<div class="basic-info">
				<div class="store-left">
					<img src="{$store_info.seller_logo}">
				</div>
				<div class="store-right">
					<div class="store-name">
						{$store_info.seller_name}
						{if $store_info.distance}&nbsp;{$store_info.distance}m{/if}
						{if $store_info.manage_mode eq 'self'}<span>自营</span>{/if}
						<label class="store-distance"><i class="iconfont icon-jiantou-right"></i></label>
					</div>
					<div class="store-range">
						<i class="iconfont icon-remind"></i>{$store_info.label_trade_time}
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</a>
		{if $store_info.favourable_list}
		<ul class="store-promotion">
			<!-- {foreach from=$store_info.favourable_list item=list} -->
			<li class="promotion">
				<span class="promotion-label">{$list.type_label}</span>
				<span class="promotion-name">{$list.name}</span>
			</li>
			<!-- {/foreach} -->
		</ul>
		{/if}
	</li>
	<div class="a1n">
		<div class="wg"> 
			<div class="wh"><span class="wp"><i class="iconfont icon-search"></i>搜索店内商品</span></div>
		</div>
		<div class="a21">
			<ul class="a1o">
				<!-- {if $store_info.goods_count.best_goods gt 0} -->
				<li class="a1p a1t">
					<a class="data-pjax" href="{RC_Uri::url('goods/category/store_goods')}&store_id={$store_id}&type=best">
						<strong class="a1s {if $action_type eq 'best'}active{/if}">精选</strong>
					</a>
				</li>
				<!-- {/if} -->
				
				<!-- {if $store_info.goods_count.hot_goods gt 0} -->
				<li class="a1p a1t">
					<a class="data-pjax" href="{RC_Uri::url('goods/category/store_goods')}&store_id={$store_id}&type=hot">
						<strong class="a1s {if $action_type eq 'hot'}active{/if}">热销</strong>
					</a>
				</li>
				<!-- {/if} -->
				
				<!-- {if $store_info.goods_count.new_goods gt 0} -->
				<li class="a1p a1t">
					<a class="data-pjax" href="{RC_Uri::url('goods/category/store_goods')}&store_id={$store_id}&type=new">
						<strong class="a1s {if $action_type eq 'new'}active{/if}">新品</strong>
					</a>
				</li>
				<!-- {/if} -->
				
				<li class="a1p a1t">
					<a href="{RC_Uri::url('goods/category/store_goods')}&store_id={$store_id}&type=all">
						<strong class="a1s {if (!$category_id && !$action_type) || $action_type eq 'all'}active{/if}">全部</strong>
					</a>
				</li>
				
				
				<!-- {if $store_category} -->
					<!-- {foreach from=$store_category item=val} -->
					<li class="a1p">
						<a href="{RC_Uri::url('goods/category/store_goods')}&store_id={$store_id}&category_id={$val.id}">
						<strong class="a1s {if $val.id eq $category_id}active{/if}">{$val.name}</strong>
						</a>
					</li>
					<!-- {/foreach} -->
				<!-- {/if} -->
			</ul>
			
			<div class="a20">
				{$type_name}
				（{$goods_num}）
			</div>
			<div class="a1x wd ">
				<div class="a1z r2 a0h">
					<ul>
						<!-- {if $suggest_goods} -->
							<!-- {foreach from=$suggest_goods item=goods} -->
							<li>
								<a class="linksGoods w">
									<img class="pic" src="{$goods.img.small}"> 
									<dl>
										<dt>{$goods.name}</dt>
										<dd><label>{$goods.shop_price}</label></dd>
									</dl>
								</a>
							</li>
							<!-- {/foreach} -->
						<!-- {/if} -->
						
						<!-- {if $goods_list} -->
							<!-- {foreach from=$goods_list item=goods} -->
							<li>
								<a class="linksGoods w">
									<img class="pic" src="{$goods.img.small}"> 
									<dl>
										<dt>{$goods.name}</dt>
										<dd><label>{$goods.shop_price}</label></dd>
									</dl>
								</a>
							</li>
							<!-- {/foreach} -->
						<!-- {/if} -->
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->