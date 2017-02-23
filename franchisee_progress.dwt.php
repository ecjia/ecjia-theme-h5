<?php
/*
Name: 查询进度页
Description: 
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-address-list">
    <div class="franchisee-process-hint"> 
        <img src="{$theme_url}/images/user_center/f_process.png" width="100" height="100">
        <p>
        {if $check_status=0}
                                    亲~您的申请已提交成功！
        {elseif $check_status=2}
                                    您的申请审核已通过！
        {elseif $check_status=3}
                                     您的申请审核未通过！
        {/if}
        </p>
    </div>
    <div class="franchisee-progress">
        <p>申请进度</p>
        <hr />
    </div>
    <div class="franchisee-prompt">
        <span class="warm-prompt">温馨提示：</span>
        <span>
            {if $check_status=0}
                                                    您的申请已提交成功，我们将尽快为您处理，感谢您对我们的支持！
            {elseif $check_status=2}
                                                    您的申请已审核通过，现在您可以登录自己的商家平台管理店铺，赶快去登录吧！
            {/if}
        </span>
    </div>
    <div class="franchisee-info">
        <ul>
            <p>
                <span class="ecjiaf-fl fran-info-color">真实姓名</span>
                <span class="ecjiaf-fr">{$info.responsible_person}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">电子邮箱</span>
                <span class="ecjiaf-fr">{$info.email}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">手机号码</span>
                <span class="ecjiaf-fr">{$info.mobile}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">店铺名称</span>
                <span class="ecjiaf-fr">{$info.seller_name}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">店铺分类</span>
                <span class="ecjiaf-fr">{$info.seller_category}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">详细地址</span>
                <span class="ecjiaf-fr">{$info.address}</span>
            </p>
        </ul>
    </div>
</div>
<!-- {/block} -->