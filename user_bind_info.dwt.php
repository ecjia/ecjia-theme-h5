<?php
/*
Name:  查看绑定手机号
Description:  查看绑定手机号
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!--{nocache}-->

<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.touch.user.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
{if $type eq 'mobile'}
<div class="ecjia-check-info">
    <div class="bind-info">
        <p>已绑：{$user.mobile_phone}</p>
    </div>
    <div>
        <a class="btn btn-info nopjax external" href="{RC_uri::url('user/profile/account_bind')}&type=mobile&status=change">更换手机号</a>
    </div>
</div>
{elseif $type eq 'email'}
<div class="ecjia-check-info">
    <div class="bind-info">
        <p>已绑：{$user.email}</p>
    </div>
    <div>
        <a class="btn btn-info nopjax external" href="{RC_uri::url('user/profile/account_bind')}&type=email&status=change">更换邮箱号</a>
    </div>
</div>
{elseif $type eq 'wechat'}
<div class="ecjia-check-info">
    <div class="bind-info">
        <p>
            <!--{if $user.wechat_is_bind eq 1}-->
                <!--{if $user.wechat_nickname}-->
                    已绑：<!--{$user.wechat_nickname}-->
                <!--{else}-->
                    已绑定
                <!--{/if}-->
            <!--{else}-->
                暂未绑定
            <!--{/if}-->
        </p>
    </div>
    <div>
        <!--{if $user.wechat_is_bind eq 1}-->
        <a class="btn btn-info unbind_wechat" href="javascript:;" data-url="{RC_Uri::url('user/profile/unbind_wechat')}">解除绑定</a>
        <!--{else}-->
        <a class="btn btn-info nopjax external" href='{url path="connect/index/authorize" args="connect_code=sns_wechat"}'>去绑定</a>
        <!--{/if}-->
    </div>
</div>
{/if}
<!-- {/block} -->

<!--{/nocache}-->