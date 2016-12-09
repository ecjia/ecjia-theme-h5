<?php
/*
Name: 首页header模块
Description: 这是首页的header模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.searchbox_foucs();</script>
<script type="text/javascript">ecjia.touch.substr();</script>
<!-- {/block} -->
{if $address}
<div class="ecjia-header ecjia-header-index" style="height:5em">
	<div class="ecjia-web">
		<div class="ecjia-address">
			<a href="{url path='user/user_address/location' class="data-pjax" args="city={if $smarty.get.city}{$smarty.get.city}{else}上海{/if}"}" >
			    <span><img src="{$theme_url}images/address_list/50x50_2l.png"></span>
				<span class="address-text">{if $smarty.get.address}{$smarty.get.address}{else}上海市普陀区中山北路上海市普陀区中山北路上海市普陀区中山北路{/if}</span>
				<span><img src="{$theme_url}images/address_list/down.png"></span>
			</a>
		</div>
	</div>
	
	<div class="ecjia-search-header">
		<span class="bg search-goods" style="margin-top:1.5em;" data-url="{RC_Uri::url('touch/index/search')}{if $store_id}&store_id={$store_id}{/if}" {if $keywords neq ''}style="text-align: left;" data-val="{$keywords}"{/if}>
			<i class="iconfont icon-search"></i>{if $keywords neq ''}<span class="keywords">{$keywords}</span>{else}{if $store_id}搜索店内商品{else}搜索附近门店{/if}{/if}
		</span>
	</div>
</div>
{else}
<div class="ecjia-header ecjia-header-index">
	<div class="ecjia-search-header">
		<span class="bg search-goods" data-url="{RC_Uri::url('touch/index/search')}{if $store_id}&store_id={$store_id}{/if}" {if $keywords neq ''}style="text-align: left;" data-val="{$keywords}"{/if}>
			<i class="iconfont icon-search"></i>{if $keywords neq ''}<span class="keywords">{$keywords}</span>{else}{if $store_id}搜索店内商品{else}搜索附近门店{/if}{/if}
		</span>
	</div>
</div>
{/if}
