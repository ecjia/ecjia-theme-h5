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
<div class="ecjia-check-info">
    <div class="binding-mobile">
        <h2>已绑：15216000120</h2>
    </div>
</div>
<div>
	<a class="btn btn-info nopjax" href="{RC_uri::url('user/profile/bind_mobile')}">更换手机号</a>
</div>
<!-- {/block} -->