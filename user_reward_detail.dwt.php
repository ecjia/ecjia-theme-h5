<?php
/*
Name: 奖励明细
Description: 奖励明细
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.spread.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->

<div class="ecjia-spread">
    <div class="reward-detail">
        <div class="swiper-container swiper-3">
            <div class="swiper-wrapper">
            <!--{foreach from=$month item=date}-->
                <div class="swiper-slide">
                    <span>{$date.label_invite_data}</span>
                    <img src="./images/wallet/240x240.png">
                </div>
            <!-- {foreachelse} -->
            
            <!--{/foreach}-->
            </div>
        </div>
    </div>

</div>
<!-- {/block} -->
