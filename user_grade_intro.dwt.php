<?php
/*
Name: 权益介绍
Description: 这是权益介绍说明页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<div class="quickpay ecjia-margin-t">
    <div class="checkout">
		<div class="item_list">
			<div class="quickpay_div content">
	            <li class="explain_title"><span><b>{t domain="h5"}会员卡介绍{/t}</b></span></li>
	            <li class="quickpay_list m_b0 ecjia-discover-detail article-p">
	                {$data.user_card_intro}
	            </li>
	            
	            <li class="explain_title"><span><b>{t domain="h5"}VIP权益介绍{/t}</b></span></li>
	            <li class="quickpay_list m_b0 ecjia-discover-detail article-p">
	                <p>{$data.grade_intro}</p>
	            </li>
        	</div>
        </div>
    </div>
</div>
<!-- {/block} -->