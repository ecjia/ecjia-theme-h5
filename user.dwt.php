<?php
/*
Name: 用户中心模板
Description: 这是用户中心首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

{nocache}
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
{if $user}
<a href="{url path='user/profile/init'}">
    <div class="ecjia-user-info user-new-info ecjia-user">
    	<div class="user-img ecjiaf-fl"><img src="{if $user_img}{$user_img}{else}{$theme_url}images/default_user.png{/if}"></div>
    	<i class="iconfont icon-jiantou-right user_info_title"></i>
    	<div class="ecjiaf-fl ecjia-margin-l user-rank-name">
    		<p><span>{$user.name}</span></p>
    		<span class="ecjia-user-buttom">{$user.rank_name}</span>
    	</div>
    </div>
</a>
{else}
<div class="ecjia-user-info user-new-info ecjia-user">
   	<a href="{$login_url}"><div class="no-login">{t domain="h5"}登录 / 注册{/t}</div></a>
</div>
{/if}

{if $user.id}
<div class="ecjia-user-head ecjia-user ecjia-color-green ecjia-user-marg-t">
    <ul class="ecjia-user-marg-t ecjia-list list-short ecjia-user-no-border-t">
       <li>
        	<a href="{url path='user/order/order_list'}&type={'whole'}">
        		<div class="icon-wallet"><img src="{$theme_url}images/user_center/75x75_2.png"></div>
        		<span class="icon-name">{t domain="h5"}我的订单{/t}</span>
        		<span class="icon-long">{t domain="h5"}查看全部订单{/t}</span>
        		<i class="iconfont icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>
</div>
<div class="ecjia-user-border-b">
    <ul class="ecjia-user ecjia-list bonus ecjia-nav-child-f ecjia-list-five ecjia-login-nav-bottom">
    	<li>
    		<a href="{url path='user/order/order_list'}&type={'await_pay'}">
    		    <p class="oc-icon">
    		      <img src="{$theme_url}images/user_center/o_75_2.png" />
    		      {if $order_num.await_pay gte 1}<span class="oc-num top">{$order_num.await_pay}</span>{/if}
    		    </p>
    			<p>{t domain="h5"}待付款{/t}</p>
    		</a>
    	</li>
    	<li>
    		<a href="{url path='user/order/order_list'}&type={'await_ship'}">
    		    <p class="oc-icon">
    		      <img src="{$theme_url}images/user_center/o_75_3.png" />
    		      {if $order_num.await_ship gte 1}<span class="oc-num top">{$order_num.await_ship}</span>{/if}
    		    </p>
    			<p>{t domain="h5"}待发货{/t}</p>
    		</a>
    	</li>
    	<li>
    	    <a href="{url path='user/order/order_list'}&type={'shipped'}">
        		<p class="oc-icon">
        		  <img src="{$theme_url}images/user_center/o_75_4.png" />
        		  {if $order_num.shipped gte 1}<span class="oc-num top">{$order_num.shipped}</span>{/if}
        		</p>
        		<p>{t domain="h5"}待收货{/t}</p>
    		</a>
    	</li>
    	<li>
    	    <a href="{url path='user/order/order_list'}&type={'allow_comment'}">
        		<p class="oc-icon">
        		  <img src="{$theme_url}images/user_center/o_75_5.png" />
        		  {if $order_num.allow_comment gte 1}<span class="oc-num top">{$order_num.allow_comment}</span>{/if}
        		</p>
        		<p>{t domain="h5"}待评价{/t}</p>
    		</a>
    	</li>
   		<li>
    	    <a href="{url path='user/order/order_list'}&type={'refund'}">
        		<p class="oc-icon">
        		  <img src="{$theme_url}images/user_center/o_75_6.png" />
        		  {if $order_num.refund_order gte 1}<span class="oc-num top">{$order_num.refund_order}</span>{/if}
        		</p>
        		<p>{t domain="h5"}退款/售后{/t}</p>
    		</a>
    	</li>
    </ul>
</div>

<div class="ecjia-user-head ecjia-user ecjia-color-green">
    <ul class="ecjia-user-marg-t ecjia-list list-short">
       <li>
        	<a href="{url path='user/account/init'}">
        		<div class="icon-wallet"><img src="{$theme_url}images/user_center/75x75_1.png"></div>
        		<span class="icon-name">{t domain="h5"}我的钱包{/t}</span>
        		<i class="iconfont icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>
</div>
<div class="ecjia-user-border-b">
    <ul class="ecjia-user ecjia-list bonus ecjia-nav-child-f ecjia-list-three ecjia-login-nav-bottom">
    	<li>
    		<a href="{url path='user/account/balance'}">
    		    <p>{$user.formated_user_money}</p>
    			<p>{t domain="h5"}余额{/t}</p>
    		</a>
    	</li>
    	<li>
    		<a href="{url path='user/bonus/init'}">
    		    <p>{if $user.user_bonus_count eq '0'}{0}{else}{$user.user_bonus_count}{/if}</p>
    			<p>{t domain="h5"}红包{/t}</p>
    		</a>
    	</li>
    	<li>
    	    <a href="{url path='user/account/init'}">
        		<p>{$user.user_points}</p>
        		<p>{$integral_name}</p>
    		</a>
    	</li>
    </ul>
</div>
{else}
<div class="ecjia-user-head ecjia-user ecjia-color-green ecjia-user-marg-t">
    <ul class="ecjia-user-marg-t ecjia-list list-short ecjia-user-no-border-t">
       <li>
        	<a href="{$login_url}">
        		<div class="icon-wallet"><img src="{$theme_url}images/user_center/75x75_2.png"></div>
        		<span class="icon-name">{t domain="h5"}我的订单{/t}</span>
        		<span class="icon-long">{t domain="h5"}查看全部订单{/t}</span>
        		<i class="iconfont icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>
</div>
<div class="ecjia-user-border-b">
    <ul class="ecjia-user ecjia-list bonus ecjia-nav-child-f ecjia-list-five ecjia-login-nav-bottom">
    	<li>
    		<a href="{$login_url}">
    		    <p><img src="{$theme_url}images/user_center/o_75_2.png" /></p>
    			<p>{t domain="h5"}待付款{/t}</p>
    		</a>
    	</li>
    	<li>
    		<a href="{$login_url}">
    		    <p><img src="{$theme_url}images/user_center/o_75_3.png" /></p>
    			<p>{t domain="h5"}待发货{/t}</p>
    		</a>
    	</li>
    	<li>
    	    <a href="{$login_url}">
        		<p><img src="{$theme_url}images/user_center/o_75_4.png" /></p>
        		<p>{t domain="h5"}待收货{/t}</p>
    		</a>
    	</li>
    	<li>
    	    <a href="{$login_url}">
        		<p><img src="{$theme_url}images/user_center/o_75_5.png" /></p>
        		<p>{t domain="h5"}待评价{/t}</p>
    		</a>
    	</li>
  		<li>
    	    <a href="{$login_url}">
        		<p class="oc-icon">
        		  <img src="{$theme_url}images/user_center/o_75_6.png" />
        		</p>
        		<p>{t domain="h5"}退款/售后{/t}</p>
    		</a>
    	</li>
    </ul>
</div>

<div class="ecjia-user-head ecjia-user ecjia-color-green ecjia-user-marg-t">
    <ul class="ecjia-list list-short ecjia-user-no-border-t">
       <li>
        	<a href="{$login_url}">
        		<div class="icon-wallet"><img src="{$theme_url}images/user_center/75x75_1.png"></div>
        		<span class="icon-name">{t domain="h5"}我的钱包{/t}</span>
        		<i class="iconfont icon-jiantou-right"></i>
        	</a>
        </li>
    </ul>
</div>
<div class="ecjia-user-border-b">
    <ul class="ecjia-user ecjia-list bonus ecjia-nav-child-f ecjia-list-three ecjia-login-nav-bottom">
    	<li>
    		<a href="{$login_url}">
    		    <p>{'- -'}</p>
    			<p>{t domain="h5"}余额{/t}</p>
    		</a>
    	</li>
    	<li>
    		<a href="{$login_url}">
    		    <p>{'- -'}</p>
    			<p>{t domain="h5"}红包{/t}</p>
    		</a>
    	</li>
    	<li>
    	    <a href="{$login_url}">
        		<p>{'- -'}</p>
        		<p>{$integral_name}</p>
    		</a>
    	</li>
    </ul>
</div>
{/if}

<div class="ecjia-user-head ecjia-user ecjia-user-marg-t">
    <ul class="ecjia-list list-short">
        <li>
            <a class="nopjax external" href="{url path='user/index/spread'}&name={$user.name}">
                <div class="icon-wallet"><img src="{$theme_url}images/user_center/expand.png"></div>
                <span class="icon-name">{t domain="h5"}我的推广{/t}</span>
                <i class="iconfont icon-jiantou-right"></i>
            </a>
        </li>
    </ul>
</div>
<div class="ecjia-user-border-b">
    <ul class="ecjia-user ecjia-list bonus ecjia-nav-child-f ecjia-list-four ecjia-login-nav-bottom">
        <li>
            <a href="{url path='user/index/spread_center_normal'}">
                <p><img src="{$theme_url}images/user_center/get_integral.png" /></p>
                <p>{t domain="h5"}推广中心{/t}</p>
            </a>
        </li>
        <li>
            <a href="{url path='user/bonus/reward_detail'}">
                <p><img src="{$theme_url}images/user_center/my_reward.png" /></p>
                <p>{t domain="h5"}注册奖励{/t}</p>
            </a>
        </li>
        <li>
            <a href="{url path='user/order/affiliate'}">
                <p><img src="{$theme_url}images/user_center/order_affiliate.png" /></p>
                <p>{t domain="h5"}销售奖励{/t}</p>
            </a>
        </li>
        <li>
            <a href="{url path='user/team/list'}">
                <p><img src="{$theme_url}images/user_center/my_team.png" /></p>
                <p>{t domain="h5"}我的团队{/t}</p>
            </a>
        </li>
    </ul>
</div>

<div class="ecjia-user ecjia-margin-b">
    <div class="ecjia-list list-item-four {if !$data}safe-area{/if}">
        <a class="vl" href="{url path='user/quickpay/quickpay_list'}"> <img src="{$theme_url}images/user_center/quickpay_packet.png">{t domain='mendian'}我的买单{/t}</a>

        <a class="vl" href="{if $user}{url path='user/order/groupbuy_order'}{else}{$login_url}{/if}"> <img src="{$theme_url}images/user_center/groupbuy.png">{t domain='mendian'}我的团购{/t}</a>

        <a class="vl external" href="{if $user}{url path='user/follow/init'}{else}{$login_url}{/if}"><img src="{$theme_url}images/user_center/follow.png">{t domain='mendian'}关注店铺{/t}</a>

        <a class="vl external" href="{$signup_reward_url}"><img src="{$theme_url}images/user_center/gift.png">{t domain='mendian'}新人有礼{/t}</a>
        <a class="vl" href="{url path='user/address/address_list'}"><img src="{$theme_url}images/user_center/address.png">{t domain='mendian'}收货地址{/t}</a>
        <a class="vl" href="{url path='article/help/init'}"><img src="{$theme_url}images/user_center/help.png">{t domain='mendian'}帮助中心{/t}</a>

        {if $merchant_join_close neq 1}
        <a class="vl external nopjax" href="{url path='franchisee/index/search'}"><img src="{$theme_url}images/user_center/franchisee_search.png">{t domain='mendian'}店铺入驻查询{/t}</a>
        <a class="vl external nopjax" href="{url path='franchisee/index/first'}"><img src="{$theme_url}images/user_center/franchisee_apply.png">{t domain='mendian'}店铺入驻申请{/t}</a>
        {/if}

        <a class="vl external" href="{url path='mobile/mobile/download'}"><img src="{$theme_url}images/user_center/down_app.png">{t domain='mendian'}下载App{/t}</a>
        <a class="vl" href="{url path='touch/index/about_us'}"><img src="{$theme_url}images/user_center/about_us.png">{t domain='mendian'}关于我们{/t}</a>
        <a class="vl" href="{url path='touch/index/cache_set'}"><img src="{$theme_url}images/user_center/cache_set.png">{t domain='mendian'}缓存设置{/t}</a>
    </div>
    {if $data}
    <div class="ecjia-list list-item-four safe-area">
        <div class="vl-title">━━━ ● <img src="{$theme_url}images/user_center/discover.png"> ● ━━━</div>
        <!--{foreach from=$data item=val}-->
        <a class="vl external nopjax" href="{$val.url}"><img src="{$val.image}">{$val.text}</a>
        <!--{/foreach}-->
    </div>
    {/if}
</div>
<!-- #BeginLibraryItem "/library/model_bar.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->
{/nocache}