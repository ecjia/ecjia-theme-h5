<?php
/*
Name: 闪惠积分
Description: 闪惠积分单页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
// 	ecjia.touch.enter_search();
</script>
<!-- {/block} -->
<!-- {block name="main-content"} -->
<div class="quickpay">
    <div class="checkout">
        <p class="intergal_title">{t}您总共1447个积分{/t}</p>
        <input class="intergal_input before_two" placeholder="最多可使用500个积分">
    </div>
    
     <div class="save_discard">
        <input class="btn mag-t1" name="submit" type="submit" value="保存">
        <input class="btn btn-hollow-danger mag-t1" name="submit" type="submit" value="清空">
    </div>
</div>

<!-- {/block} -->
{/nocache}