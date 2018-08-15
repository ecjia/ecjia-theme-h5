<?php
/*
Name: 赚积分
Description: 赚积分
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
    <!-- {extends file="ecjia-touch.dwt.php"} -->

    <!-- {block name="footer"} -->
    <script type="text/javascript">
        ecjia.touch.user_account.init();
    </script>
    <!-- {/block} -->

    <!-- {block name="main-content"} -->
    <div class="ecjia-add-bonus">
        <form name="addBonusForm" action="{RC_Uri::url('user/bonus/add_bonus')}">
            <div class="ecjia-margin-b">
                <div class="bonus_image">
                    <img src="{$theme_url}images/wallet/bonus_image.png">
                </div>
            </div>
            <div class="ecjia-margin-b">
                <input class="bonus_number_input" type="text" name="bonus_number" placeholder="请输入号码" />
            </div>

            <div class="ecjia-margin-b">
                <input class="btn" type="button" name="add_bonus" value="添加" />
            </div>
        </form>
    </div>

    <!-- {/block} -->