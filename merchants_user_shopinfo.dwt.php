<?php 
/*
Name: 信息留言模板
Description: 这是信息留言首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script>ecjia.touch.merchant.init()</script>
<!-- {/block} -->
<!-- {block name="ecjia"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<!-- {if $step eq 4 } -->
    <form class="ecjia-form merchant_shop" data-step="{$next_step}" name="theForm" action='{url path="user/user_merchant/update" args="step={$step}&pid_key={$pid_key}&tid={$tid}"}' method="post">
        <section class="flow-done merchant_ok">
            <div class="done-message">
                <i class="glyphicon glyphicon-ok"></i>
                <!--{if $shop_info.merchants_audit eq 0}-->
                    <!--{if $shop_info.steps_audit eq 0}-->
                    <p>可以提交审核</p>
                    <!--{else}-->
                    <p>正在审核中...</p>
                    <!--{/if}-->
                <!--{elseif $shop_info.merchants_audit eq 1}-->
                <p>审核已通过...</p>
                <!--{elseif $shop_info.merchants_audit eq 2}-->
                <p>审核未通过...</p>
                    <!--{if $shop_info.merchants_message}-->
                    <p style=" color:#48a7e7">{$shop_info.merchants_message}</p>
                    <!--{/if}-->
                <!--{/if}-->
            </div>

            <!--{if $shop_info.merchants_audit eq 0 && $shop_info.steps_audit eq 0}-->
            </section>
                <p class="ecjia-margin-t">
                    <button class="btn" type="submit">提交审核</button>
                </p>
            <!--{elseif $shop_info.merchants_audit eq 2}-->
            </section>
            <p class="ecjia-margin-t">
                <button class="btn" type="submit">我要修改</button>
            </p>
            <!--{else}-->
                <p class="ordertitle">
                    感谢您在本店申请商家入驻！
                    <!--{if $shop_info.merchants_audit eq 1}-->
                    <br/>您的商家入驻管理中心登陆账号：
                    <span>{$shop_info.hopeLoginName}</span>
                    <br/>密码：<span>{$password_clear}</span>
                    <!--{/if}-->
                </p>
                <p>期望店铺名称：<span>{$shop_info.hopeLoginName}</span></p>
                <p>店铺描述：<span>{$shop_info.shop_class_keyWords}</span></p>
            </section>
            <!--{/if}-->
    </form>
<!--{else}-->
<form class="ecjia-form merchant_shop" data-step="{$next_step}" name="theForm" action='{url path="user/user_merchant/update" args="step={$step}&pid_key={$pid_key}&tid={$tid}"}' method="post" enctype="multipart/form-data">
    <!-- {if $step eq 1}-->
    <div class="ecjia-margin-b" style="width:100%;height:20em;overflow-x:hidden;background: #fff;padding: 1em;word-wrap: break-word;word-break : break-all;">{$online_agreement.article_content}</div>
    <!-- {/if}-->

    <!--{foreach from=$steps_title item=title}-->

    <!--{if $title.special_type eq 1 && $title.fields_special neq ''}-->
    <div class="form-group form-group-text">
        <!--{$title.fields_special}-->
    </div>
    <!--{/if}-->

    <!--{if $title.steps_style eq 0}-->
    <!-- #BeginLibraryItem "/library/merchants_steps_basic_type.lbi" --><!-- #EndLibraryItem -->
    <!--{elseif $title.steps_style eq 1}-->
    <!-- #BeginLibraryItem "/library/merchants_steps_shop_type.lbi" --><!-- #EndLibraryItem -->
    <!--{elseif $title.steps_style eq 2}-->
    <!-- #BeginLibraryItem "/library/merchants_steps_cate_type.lbi" --><!-- #EndLibraryItem -->
    <!--{elseif $title.steps_style eq 3}-->
    <!-- #BeginLibraryItem "/library/merchants_steps_brank_type.lbi" --><!-- #EndLibraryItem -->
    <!--{elseif $title.steps_style eq 4}-->
    <!-- #BeginLibraryItem "/library/merchants_steps_shop_info.lbi" --><!-- #EndLibraryItem -->
    <!--{/if}-->

    <!--{if $title.special_type eq 2 && $title.fields_special neq ''}-->
    <div class="form-group form-group-text">
        <!--{$title.fields_special}-->
    </div>
    <!--{/if}-->
    <!--{/foreach}-->

	<div class=" ecjia-margin-t ecjia-margin-b">
		<input name="numAdd" value="1" id="numAdd" type="hidden" />
		<input class="btn btn-info nopjax" type="submit" {if $process.fields_next} value="{$process.fields_next}" {else} value="确定" {/if} name="submit">
		<!--  {if $user_id > 0} -->
		<input type="hidden" name="user_id" value="{$user_id}" id="user_id" />
		<!-- {/if} -->
	</div>
</form>
<!-- {/if} -->
<!-- {/block} -->
