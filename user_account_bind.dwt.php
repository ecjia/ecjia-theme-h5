<?php
/*
Name: 绑定手机号码
Description: 绑定手机号码
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">

</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-user ecjia-form ecjia-user-no-border-b" name="formPassword" action="{url path=''}" method="post" >
    {if $type eq 'mobile'}
    <div class="d_bind_mobile">
        <p class="p_bind">绑定手机号后，你可以使用手机号登录，也可以通过手机号找回密码</p>
        <div class="ecjia-list list-short bind">
            <li>
        		<div class="form-group d_input">
            		<label>
            			<input placeholder="请输入手机号">
            		</label>
            	</div>
           </li>
           <li>
        		<div class="form-group d_input_verification_code">
            		<label>
            			<input placeholder="请输入验证码">
            		</label>
            	</div>
            	<div class="form-group get_code">
            	   <label class="input_verification_code">
            			<input type="button" value="获取验证码">
            		</label>
            	</div>
           </li>
        </div>
        <div class=" ecjia-margin-b">
        	<input class="btn btn-info" name="submit" type="submit" value="立即绑定" />
        </div>
    </div>
    {elseif $type eq 'email'}
    <div class="d_bind_mobile">
        <p class="p_bind">请输入你的邮箱帐号</p>
        <div class="ecjia-list list-short bind">
            <li>
        		<div class="form-group d_input">
            		<label>
            			<input placeholder="请输入邮箱帐号">
            		</label>
            	</div>
           </li>
           <li>
        		<div class="form-group d_input_verification_code">
            		<label>
            			<input placeholder="请输入验证码">
            		</label>
            	</div>
            	<div class="form-group get_code">
            	   <label class="input_verification_code">
            			<input type="button" value="获取验证码">
            		</label>
            	</div>
           </li>
        </div>
        <div class=" ecjia-margin-b">
        	<input class="btn btn-info" name="submit" type="submit" value="立即绑定" />
        </div>
    </div>
    {/if}
</form>
<!-- {/block} -->