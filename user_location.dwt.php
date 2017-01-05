<?php 
/*
Name: 定位当前位置模板
Description: 定位当前位置页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.region_change();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-list ecjia-address-list" action="" method="post" id="searchForm" name="searchForm">
	<div class="nav-header">
		<a href="{url path='user/user_address/near_location' args="city={$smarty.get.city}&type=index"}">
		<div class="img-search"></div>
		<input id="keywordBox" name="keywords" type="search" placeholder="小区、写字楼、学校">
		</a>
	</div>
	<div class="nav-header ecjia-margin-t ecjia-margin-b">
		<a href="https://apis.map.qq.com/tools/locpicker?search=1&type=0&backurl={url path='touch/index/init'}&key=4PLBZ-WSUW2-OXBUZ-CFNSS-MRUAV-3SFEO&referer=nothingkey">
			<div class="position"></div>&nbsp;&nbsp;&nbsp;&nbsp;{t}定位到当前位置{/t}
			<span class="ecjiaf-fr"><i class="iconfont icon-jiantou-right"></i></span>
		</a>
	</div>
	<ul class="list-one">
		<div class="address-backgroundw"><span>我的收货地址</span></div>			
		<!-- {foreach from=$address_list item=value} 循环地址列表 -->
		<li>
			<a data-toggle="choose_address" href="{RC_Uri::url('user/user_address/choose_address')}&address_id={$value.id}{if $referer_url}&referer_url={$referer_url}{/if}">
				<div class="circle"></div>
				<div class="list">
					<div>
						<p class="ecjiaf-fl">{$value.consignee}</p>
						<p class="ecjiaf-fl ecjia-margin-l ecjia-address-mobile">{$value.mobile}</p>
					</div><br />
					<div class="ecjia-margin-top address ecjiaf-wwb">{$value.address}</div>	
				</div>
			</a>
		</li>
		<!-- {/foreach} -->
	</ul>
	<div class="address-list-center">
		<a type="botton" href="{url path='user/user_address/address_list'}">
			<i class="iconfont icon-roundadd"></i> {t}管理收货地址{/t}
		</a>
	</div>
</form>
<!-- {/block} -->