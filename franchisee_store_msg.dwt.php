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
<script type="text/javascript">ecjia.touch.franchisee.choices();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-address-list" name="theForm1" action="{$form_action}" method="post">
	<div class="form-group form-group-text franchisee">
		<label class="input">
			<span class="ecjiaf-fl"><img src="{$theme_url}/images/user_center/f_store.png" width="30" height="30"></span>
			<input name="f_name" placeholder="{t}请输入店铺名称10字以内{/t}" type="text"  value=""  />
		</label>
	</div>
	
	<div class="form-group form-group-text franchisee">
		<label class="input">
			<span class="ecjiaf-fl"><img src="{$theme_url}/images/user_center/f_category.png" width="30" height="30"></span>
			<i class="iconfont  icon-jiantou-right"></i>
			<input class="ecjia-franchisee-category" style="padding-left: 3.5em;" name="f_category" placeholder="{t}请选择店铺分类{/t}" type="category"  value=""  />
		    <input name="category" type="hidden" value={$category} />
		</label>
		<label class="input">
			<span class="ecjiaf-fl"><img src="{$theme_url}/images/user_center/f_type.png" width="30" height="30"></span>
			<i class="iconfont  icon-jiantou-right"></i>
			<input class="ecjia-franchisee-type" style="padding-left: 3.5em;" name="franchisee-type" placeholder="{t}请选择入驻类型 {/t}" type="franchisee-type" value=""  />
		</label>
	</div>
	
	<div class="form-group form-group-text franchisee">
		<label class="input">
    		<span class="ecjiaf-fl"><img src="{$theme_url}/images/user_center/f_location.png" width="30" height="30"></span>
    		<i class="iconfont  icon-jiantou-right"></i>
    		<input class="ecjia-franchisee-location" name="f_city" placeholder="{t}选择店铺所在地{/t}" type="text" value={$f_city}>
	        <input name="province" type="hidden" value={$province} />
    		<input name="city" type="hidden" value={$city} />
    		</label>
		<label class="input">
    	   <input name="f_address" placeholder="{t}输入详细地址{/t}" type="text" value={$f_address}>
		</label>
	</div>
	
	<p class="coordinate" data-url="{url path='franchisee/index/location'}">获取精准坐标</p>
	<input name="longitude" type="hidden" value="{$longitude}" />
	<input name="latitude" type="hidden" value="{$latitude}" />
	
	<div class="ecjia-margin-t ecjia-margin-b">
	    <input name="temp_key" type="hidden" value="11" />
		<input class="btn btn-info nopjax" name="franchisee_submit" type="submit" value="{t}提交{/t}"/>
	</div>
	
</form>
<!-- {/block} -->