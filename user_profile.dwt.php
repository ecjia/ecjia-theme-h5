<?php
/*
Name:  会员中心：编辑个人资料模板
Description:  会员中心：编辑个人资料首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->

<div class="ecjia-user ecjia-account">
        <div class="ecjia-user ecjia-user-head ecjia-account">
            <ul class="ecjia-margin-t ecjia-list list-short">
                <li class="account-phone">
                	<span class="icon-name margin-no-l">头像 </span>
            		<div class="user-img-text"><img src="{$user_img}"></div>
                </li>
                <li>
                   <a href="{url path='user/user_profile/modify_username'}">
                		<span class="icon-name margin-no-l">用户名 </span>
                		<span class="icon-price text-color">{$user.name}</span>
                		<i class="iconfont icon-jiantou-right  margin-r-icon"></i>
            	   </a>
                </li>
                <li>
                    <a>
                	<span class="icon-name margin-no-l">用户等级</span>
            		<span class="icon-price text-color">{$user.rank_name}</span></a>
                </li>
                
                 <div class="ecjia-margin-t ecjia-list list-short">
                    <li>
                            <a href="{url path='user/user_profile/edit_password'}">
                    		<span class="icon-name margin-no-l">修改密码</span>
                    		<span class="icon-price"></span>
                    		<i class="iconfont  icon-jiantou-right  margin-r-icon"></i>
                    		</a>
                    </li>
                </div>
            </ul>
        </div>
</div>
<div class="ecjia-margin-t">
	<a class="btn btn-info nopjax" href="{url path='user/privilege/logout'}">{t}退出登录{/t}</a>
</div>

<!-- {/block} -->
