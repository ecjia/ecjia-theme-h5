<?php
/*
Name: 入驻导航列表
Description: 这是入驻导航列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script>ecjia.touch.merchant.init();</script>
<!-- {/block} -->

<!-- {block name="con"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<div class="merchants_step">
    <section class="checkout-select">
    <!-- {foreach from=$process_list item=tmp_process key=key} -->
        <div class="title">
            {if $key == 1}
            入驻须知
            {elseif $key == 2}
            公司信息认证
            {elseif $key == 3}
            店铺信息认证
            {elseif $key == 4}
            入驻状态
            {/if}
        </div>

        <div>
            <ul class="ecjia-list">
            <!-- {foreach from=$tmp_process item=process key=k} -->
                <!-- {if $process.children} -->
                    <!-- {foreach from=$process.children item=pro key=ke} -->
                        <!-- {if $pro.state eq 1} -->
                        <li class="link" onclick="javascript:location.href='{url path='user/user_merchant/init' args="step={$key}&pid_key={$process.steps_sort}&tid={$pro.tid}"}'">
                            <span class="num">{$pro.index}</span>
                            {$pro.fields_titles}
                            <i class="iconfont icon-check"></i>
                        </li>
                        <!-- {else} -->
                        <!-- {if $pro.lock eq 1} -->
                        <li onclick="javascript:;">
                        <!-- {else} -->
                        <li class="link" onclick="javascript:location.href='{url path='user/user_merchant/init' args="step={$key}&pid_key={$process.steps_sort}&tid={$pro.tid}"}'">
                        <!-- {/if} -->
                            <span class="num">{$pro.index}</span>
                            {$pro.fields_titles}
                            <i class="iconfont icon-jiantou-right"></i>
                        </li>
                        <!-- {/if} -->
                    <!-- {/foreach} -->
                <!-- {else} -->
                    <!-- {if $process.state eq 1} -->
                    <li class="link" onclick="javascript:location.href='{url path='user/user_merchant/init' args="step={$key}&pid_key={$process.steps_sort}"}'">
                        <span class="num">{$process.index}</span>
                        {$process.process_title}
                        <i class="iconfont icon-check"></i>
                    </li>
                    <!-- {else} -->
                    <!-- {if $process.lock eq 1} -->
                    <li onclick="javascript:;">
                    <!-- {else} -->
                    <li class="link" onclick="javascript:location.href='{url path='user/user_merchant/init' args="step={$key}&pid_key={$process.steps_sort}"}'">
                    <!-- {/if} -->
                        <span class="num">{$process.index}</span>
                        {$process.process_title}
                        <i class="iconfont icon-jiantou-right"></i>
                    </li>
                    <!-- {/if} -->
                <!-- {/if} -->

            <!-- {/foreach} -->
            </ul>
        </div>
    <!-- {/foreach} -->
    </section>
</div>

<!-- {/block} -->
