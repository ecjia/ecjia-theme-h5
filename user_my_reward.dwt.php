<?php
/*
Name: 我的奖励
Description: 我的奖励
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.spread.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-spread-pb">
    <div class="ecjia-spread ecjia-margin-b">
        <ul class="ecjia-list list-short">
            <li>
                <div class="reward-title">获得的积分奖励</div>
                <div class="reward-num1">0</div>
                <div class="reward-hint">
                    <a href="#" class="alert-text1">
                        <img src="./images/wallet/60x60_3g.png">
                    </a>
                </div>
                <div class="reward-shadow">
                    <img src="./images/wallet/220x30.png">
                </div>
            </li>
            <li>
                <div class="reward-title">获得的红包奖励</div>
                <div class="reward-num2">0</div>
                <div class="reward-hint">
                    <a href="#" class="alert-text2">
                        <img src="./images/wallet/60x60_3b.png">
                    </a>
                </div>
                <div class="reward-shadow">
                    <img src="./images/wallet/220x30.png">
                </div>
            </li>
            <li>
                <div class="reward-title">获得的现金奖励</div>
                <div class="reward-num3">0.00</div>
                <div class="reward-hint">
                    <a href="#" class="alert-text3">
                        <img src="./images/wallet/60x60_4o.png">
                    </a>
                </div>
                <div class="reward-shadow">
                    <img src="./images/wallet/220x30.png">
                </div>
            </li>
        </ul>
    </div>
</div>
<div class="ecjia-spread">
    <div class="ecjia-bottom-bar-pannel">
        <ul class="tab5">
            <li>
                <a href="{url path='user/user_bonus/reward_detail'}">
                    <div class="qrcode_image2">
                        <img src="./images/wallet/60x60_1.png">
                    </div>
                    <span>奖励明细</span>
                </a>
            </li>
            <li>
                <a href="{url path='user/user_bonus/get_integral'}">
                    <div class="qrcode_image3">
                        <img src="./images/wallet/60x60_2.png">
                    </div>
                    <span>赚积分</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- {/block} -->
