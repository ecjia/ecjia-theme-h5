<?php
/*
Name: 获取全部订单模板
Description: 获取全部订单页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.comment.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->

<form action="{url path='user/order/make_comment'}" enctype="multipart/form-data" method="post">
<div class="ecjia-met-goods-info">
    <li class="ecjia-order-item ecjia-checkout">
    	<div class="flow-goods-list">
    		<ul class="goods-item ecjia-comment-list">
    			<li class="goods-img ecjiaf-fl ecjia-margin-r ecjia-icon">
    				<img class="ecjiaf-fl" src="{$goods.img.thumb}" alt="{$goods.goods_name}" title="{$goods.goods_name}" />
    				<span class="ecjiaf-fl cmt-goods-name">{$goods.goods_name}</span>
    				<span class="ecjiaf-fl cmt-goods-price">{$goods.shop_price}</span>
    			</li>
    		</ul>
    		
    		<input type="hidden" value="{$rec_info.comment_goods}" name="comment_goods" />
    		<div class="star"><span>评分<span></div>
    		<div class="input">
    		    {if $rec_info.comment_content}
                <textarea id="goods_evaluate" name="note" readonly="readonly">{$rec_info.comment_content}</textarea>
                {else}
                <textarea id="goods_evaluate" name="note" placeholder="商品质量俱佳，强烈推荐！" ></textarea>
                {/if}
                <input type="hidden" value="{$rec_info.comment_content}" name="comment_content" />
            </div>
            
            <div class="push_img">   
                <div class="push_photo_img" id="result">
                </div>
            	<div class="push_photo" id="result0">
            	   <div class="push_result_img">
            	       <img src="{$theme_url}images/photograph.png">
            	       <input type="file" class="push_img_btn" id="filechooser0" name="filechooser0">
            	   </div>
            	</div>
            	<div class="push_photo" id="result1">
            	   <div class="push_result_img">
            	       <img src="{$theme_url}images/photograph.png">
            	       <input type="file" class="push_img_btn" id="filechooser1" name="filechooser1">
            	   </div>
            	</div>
            	<div class="push_photo" id="result2">
            	   <div class="push_result_img">
            	       <img src="{$theme_url}images/photograph.png">
            	       <input type="file" class="push_img_btn" id="filechooser2" name="filechooser2">
            	   </div>
            	</div>
            	<div class="push_photo" id="result3">
            	   <div class="push_result_img">
            	       <img src="{$theme_url}images/photograph.png">
            	       <input type="file" class="push_img_btn" id="filechooser3" name="filechooser3">
            	   </div>
            	</div>
            	<div class="push_photo" id="result4">
            	   <div class="push_result_img">
            	       <img src="{$theme_url}images/photograph.png">
            	       <input type="file" class="push_img_btn" id="filechooser4" name="filechooser4">
            	   </div>
            	</div>
                <p class="push_img_fonz" >请上传图片 (最多5张)</p>
            </div>
    	</div>
    </li>
</div>

{if $goods_info.is_showorder eq 0 && $goods_info.is_commented eq 0}
<div class="ecjia-push-comment flow-goods-list">
    <label class="select-item">
        <li>
            <span class="ecjiaf-fr">
                <div class="ecjia-anonymity-check" id="option_box"><input type="radio" name="anonymity" value="0" /><p>匿名评价</p></div>
                <input type="hidden" name="anonymity_status" value="0" />
            </span>
        </li>
    </label>
    <span class="ecjiaf-fr push-comment-btn">
        <input class="btn" name="push-comment-btn" type="submit" data-url="{RC_Uri::url('user/order/make_comment')}" value="发表评价"/>
        <input type="hidden" value="{$goods.rec_id}" name="rec_id" />
    </span>
</div>
{/if}
</form>
<!-- {/block} -->