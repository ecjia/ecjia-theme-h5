<?php
/*
Name:  查看绑定手机号
Description:  查看绑定手机号
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.user.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-address-list">
    <div class="binding-mobile">
        <div class="mobile-phone-logo">
            <img src="http://ecjia-cityo2o.dev/sites/m/content/themes/h5//images/user_center/f_process.png">
        </div>
        <p>已绑定手机号：15216000120</p>
    </div>
</div>
<div class="ecjia-bonus-top-list">
	<input class="btn btn-info nopjax" name="logout" type="submit" data-url="{url path='user/privilege/logout'}" value="更换手机号">
</div>
<!-- {/block} -->