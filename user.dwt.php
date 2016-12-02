<?php
/*
Name: 用户中心模板
Description: 这是用户中心首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript" xmlns="http://www.w3.org/1999/html">ecjia.touch.user.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- TemplateBeginEditable name="标题区域" -->
<!-- TemplateEndEditable -->

<div class="ecjia-user-info user-new-info ecjia-user">
    {if $user.id}
    	<a href="{url path='user/user_profile/edit_profile'}"><div class="user-img ecjiaf-fl"><img src="{$user_img}" alt=""></a></div>
    	<div class="ecjiaf-fl ecjia-margin-l user-rank-name">
    		<span>{$user.name}</span>
    		<span class="ecjia-user-buttom">{$user.rank_name}</span>
    	</div>
    	<a href="{url path='user/user_message/msg_list'}">
    		{if $order_num.msg_num}
    		<span class="ecjia-icon ecjia-icon ecjia-icon-num">{$order_num.msg_num}</span>
    		{/if}
    	</a>
	{else}
	   <a href="{url path='user/privilege/login'}"><div class="no-login">登陆 / 注册</div></a>
	{/if}
</div>




<div class="ecjia-user-head ecjia-user">
     <ul class="ecjia-margin-t ecjia-list list-short">
       <li>
        	<a href="{url path='user/user_account/account_detail'}">
        		<div class="icon-wallet"></div>
        		<span class="icon-name">{t}我的钱包{/t}</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>
</div>
<div class="ecjia-user-border-b">
    <ul class="ecjia-user ecjia-list bonus ecjia-nav-child-f ecjia-list-three ecjia-login-nav-bottom">
    	<li>
    		<a href="{url path='user/user_account/account_detail'}">
    		    <p>{if $user.formated_user_money}{$user.formated_user_money}{else}{'- -'}{/if}</p>
    			<p>余额</p>
    		</a>
    	</li>
    	<li>
    		<a href="{url path='user/user_bonus/bonus'}">
    		    <p>{if $user.user_bonus_count}{$user.user_bonus_count}{else}{'- -'}{/if}</p>
    			<p>红包</p>
    		</a>
    	</li>
    	<li>
    		<p>{if $user.user_points}{$user.user_points}{else}{'- -'}{/if}</p>
    		<p>积分</p>
    	</li>
    </ul>
</div>

<div class="ecjia-user ecjia-user-head">
    <ul class="ecjia-margin-t ecjia-list list-short">
       <li>
        	<a href="{url path='user/user_address/address_list'}">
        		<div class="icon-address-list"></div>
        		<span class="icon-name">地址管理</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
       <li>
        	<a href="{url path='user/user_address/address_list'}">
        		<div class="icon-expand"></div>
        		<span class="icon-name">推广</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>

    <ul class="ecjia-margin-t ecjia-list list-short">
        <li>
        	<a href="{url path='user/user_package/service'}">
        		<div class="icon-website-service"></div>
        		<span class="icon-name">官网客服</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
        <li>
        	<a href="{url path='user/user_address/address_list'}">
        		<div class="icon-offical-website"></div>
        		<span class="icon-name">官网网站</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>
    <ul class="ecjia-margin-t ecjia-list list-short">
        <li>
        	<a href="{url path='article/help/init'}">
        		<div class="icon-message-center"></div>
        		<span class="icon-name">帮助中心</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
        <li>
        	<a href="{url path='user/user_address/address_list'}">
        		<div class="icon-message-center"></div>
        		<span class="icon-name">消息中心</span>
        		<i class="iconfont  icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>
    <ul class="ecjia-margin-t ecjia-list list-short">
        <!-- {foreach from=$shop item=value} 网店信息 -->
            <li>
            	<a href="{RC_uri::url('user/index/shop_detail')}&article_id={$value.id}">
            		<div class="icon-shop-info"></div>
            		<span class="icon-name">{$value.title}</span>
            		<i class="iconfont  icon-jiantou-right"></i>
            	</a>
            </li>
        <!-- {/foreach} -->
    </ul>
</div>
<!-- #BeginLibraryItem "/library/model_bar.lbi" --><!-- #EndLibraryItem -->

<!-- {/block} -->
