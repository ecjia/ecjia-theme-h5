<?php
/*
Name: 收货地址列表模板
Description: 收货地址列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.address_from.init();</script>
<script type="text/javascript">ecjia.touch.franchisee.coordinate();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-address-list" name="theForm" action="{$form_action}" method="post">
	<div class="form-group form-group-text">
		<label class="input">
			<span class="ecjiaf-fl"><img src="{$theme_url}/images/user_center/f_store.png" width="30" height="30"></span>
			<input style="padding-left: 3.5em;" name="f_name" placeholder="{t}请输入店铺名称10字以内{/t}" type="text"  value=""  />
		</label>
	</div>
	
	<div class="form-group form-group-text">
		<label class="input">
			<span class="ecjiaf-fl"><img src="{$theme_url}/images/user_center/f_category.png" width="30" height="30"></span>
			<input class="ecjia-franchisee-category" style="padding-left: 3.5em;" name="f_email" placeholder="{t}请选择店铺分类{/t}" type="email"  value=""  />
		</label>
	</div>
	
	<div class="form-group form-group-text">
		<label class="input">
			<span class="ecjiaf-fl"><img src="{$theme_url}/images/user_center/f_type.png" width="30" height="30"></span>
			<input class="ecjia-franchisee-type" style="padding-left: 3.5em;" name="f_mobile" placeholder="{t}请选择入驻类型 {/t}" type="tel" value=""  />
		</label>
	</div>
	
	<div class="form-group form-group-text">
		<label class="input">
			<span class="ecjiaf-fl"><img src="{$theme_url}/images/user_center/f_location.png" width="30" height="30"></span>
			<i class="iconfont  icon-jiantou-right"></i>
			<input style="padding-left: 3.5em;" name="f_city" placeholder="{t}选择店铺所在地{/t}" type="text" value=""   />
			<input style="padding-left: 3.5em;" name="f_address" placeholder="{t}输入详细地址{/t}" type="text" value=""   />
		</label>
	</div>
	
	<p class="coordinate" data-url="{url path='franchisee/index/get_loaction'}">获取精准坐标</p>
	
	<div class="ecjia-margin-t ecjia-margin-b">
	    <input name="temp_key" type="hidden" value="{$temp_key}" />
		<input class="btn btn-info nopjax" name="submit" type="submit" value="{t}下一步{/t}"/>
	</div>
	
</form>
<!-- {/block} -->