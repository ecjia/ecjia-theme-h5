<?php
/*
Name: 我的奖励
Description: 我的奖励
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->

<div class="ecjia-spread ecjia-margin-t">
    <div class="ecjia-bottom-bar-pannel">
        <ul class="tab5">
            <li>
                <a href="{url path='user/user_bonus/reward_detail'}">
                    <div class="qrcode_image2">
                        <img src="./images/wallet/50_5.png">
                    </div>
                    <span>奖励明细</span>
                </a>
            </li>
            <li>
                <a href="{url path='user/user_bonus/get_integral'}">
                    <div class="qrcode_image2">
                        <img src="./images/wallet/50_5.png">
                    </div>
                    <span>赚积分</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- {/block} -->
