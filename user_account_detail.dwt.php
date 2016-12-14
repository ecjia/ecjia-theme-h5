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

<div class="ecjia-user ecjia-user-head">
    <ul class="ecjia-list list-short nmargin-t">
        <li>
        	<a href="{url path='user/user_account/account_list'}">
                <div class="iconfont icon icon-qianbao ecjia-user-phono"></div>
        	    <span class="icon-name">我的余额</span>
        		<span class="icon-price icon-price-red">{$user.formated_user_money}</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
        <li>
            <a href="{url path='user/user_bonus/bonus'}">
                <div class="iconfont icon icon-redpacket ecjia-user-phono"></div>
        		<span class="icon-name">红包</span>
        		<span class="icon-price icon-price-red">{$user.user_bonus_count}</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
        <li>
            <a>
        		<div class="iconfont icon icon-copy ecjia-user-phono"></div>
        		<span class="icon-name">积分</span>
        		<span class="icon-price icon-price-red">{$user.user_points}</span>
        	</a>
        </li>
        <li>
            <a href="{url path='user/user_bonus/get_integral'}">
        		<div class="iconfont icon icon-copy ecjia-user-phono"></div>
        		<span class="icon-name">赚积分</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>
</div>
<!-- {/block} -->
