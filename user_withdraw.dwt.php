<?php
/*
Name:  会员中心：提现管理模板
Description:  会员中心：提现管理
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {nocache} -->
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    // ecjia.touch.user.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-user ecjia-account">
    <div class="ecjia-list list-short">
        <li class="height-3">
            <a href="{if $user.wechat_is_bind eq 1}{url path='user/profile/bind_info' args='type=wechat'}
            {else}{url path='user/profile/account_bind'}&type=wechat{/if}">
                <span class="icon-name margin-no-l">微信提现</span>
                <span class="icon-price text-color">{if $user.wechat_is_bind eq 1}{$user.wechat_nickname}{else}未绑定{/if}</span>
                <i class="iconfont icon-jiantou-right margin-r-icon"></i>
            </a>
        </li>
        <li class="ecjia-user-border-b height-3">
            <a href="{url path='user/profile/account_bind'}&type=bank_card">
                <span class="icon-name margin-no-l">银行卡提现</span>
                <span class="icon-price text-color">未绑定</span>
                <i class="iconfont icon-jiantou-right margin-r-icon"></i>
            </a>
        </li>
    </div>
</div>
<!-- {/block} -->

<!-- {/nocache} -->