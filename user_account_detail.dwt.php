<?php
/*
Name: 资金管理模板
Description: 资金管理页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<div class="ecjia-user ecjia-account">
    <ul>
        <div class="ecjia-margin-t ecjia-list list-short">
            <li>
            	<a href="{url path='user/user_account/account_list'}">
            		<i class="iconfont icon icon-qianbao"></i>
            		<span class="icon-name">我的余额 </span>
            		<span class="icon-price">{$user.formated_user_money}</span>
            		<i class="iconfont icon-jiantou-right"></i>
            	</a>
            </li>
             <li>
            	<a href="{url path='user/user_bonus/bonus'}">
            		<i class="iconfont icon icon-redpacket"></i>
            		<span class="icon-name">红包</span>
            		<span class="icon-price">{$user.user_bonus_count}</span>
            		<i class="iconfont  icon-jiantou-right"></i>
            	</a>
            </li>
            <li>
            		<i class="iconfont icon icon-copy"></i>
            		<span class="icon-name">积分</span>
            		<span class="icon-price">{$user.user_points}</span>
            </li>
        </div>
    </ul>
</div>
<!-- {/block} -->
