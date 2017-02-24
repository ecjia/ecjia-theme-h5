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
<script type="text/javascript">ecjia.touch.franchisee.validate_code();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-address-list" name="theForm" action="{$form_action}" method="post">
	<div class="form-group form-group-text">
		<label class="input">
			<span class="ecjiaf-fl"><img src="{$theme_url}/images/user_center/f_mobile.png" width="30" height="30"></span>
			<input style="padding-left: 3.5em;" name="f_mobile" placeholder="{t}请输入手机号码 {/t}" type="tel"  />
		</label>
	</div>
	
	<div class="form-group form-group-text">
		<label class="input">
			<span class="ecjiaf-fl"><img src="{$theme_url}/images/user_center/f_code.png" width="30" height="30"></span>
			<input style="padding-left: 3.5em;" name="f_code" placeholder="{t}请输入验证码{/t}" type="code" />
			<input type="button" class="btn btn-info settled-message" value="{$lang.return_verification}" data-url="{url path='franchisee/index/validate'}" id="get_code" />
		</label>
	</div>
	
	<div class="ecjia-margin-t2 ecjia-margin-b">
	    <input name="temp_key" type="hidden" value="{$temp_key}" />
		<input class="btn btn-info nopjax" name="submit" type="submit" value="{t}查询{/t}"/>
	</div>
	
</form>
<!-- {/block} -->