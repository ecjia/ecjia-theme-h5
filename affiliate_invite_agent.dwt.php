<?php
/*
Name: 邀请注册模板
Description: 这是邀请二级代理商首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.affiliate_invite_agent();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-next-agent">
	<div class="ecjia-bg-qr-code">
		<div class="qrcode_image">
			<img src="{$theme_url}images/default_user.png" />
		</div>
		<div class="my-invite-code">
			<p>【{$agent_info.agent_name}】{t domain="h5"}代理商{/t}</p>
			<div class="code-style">邀请您加入下级代理</div>
		</div>
	</div>
	
	<div class="ecjia-form">
		 <form class="invite-form" name="inviteForm" action='{url path="affiliate/index/invite_agent_insert"}'>
			
			<div class="form-group margin-right-left">
				<label class="input">
					  <input class="p_d0" type="text" name="agent_name" placeholder='{t domain="h5"}请输入代理商名称{/t}'/>
				</label>
			</div>
		
			<div class="go-to-spread">
			    <input type="hidden" name="invite_code" value="{$invite_code}"/>
				<input class="receive_btn" type="submit" value='{t domain="h5"}立即加入{/t}'/>
			</div>
		  </form>
	</div>
</div>
<!-- {/block} -->
{/nocache}