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
    		<div class="star"><span >评论<span></div>
    		<div class="input">
                <textarea name="note" placeholder="商品质量俱佳，强烈推荐！" value="商品质量俱佳，强烈推荐！">{$note}</textarea>
            </div>
            
            <div class="push_img">   
                <div class="push_photo_img" id="result">
                </div>
            	<div class="push_photo" id="result">
            	   <div class="push_result_img">
            	       <img src="{$theme_url}images/photograph.png">
            	       <input type="file" class="push_img_btn" size="1"  id="filechooser">
            	   </div>
            	</div>
                <p class="push_img_fonz" >上传图片</p>
            </div>
    	</div>
    </li>
</div>

<div class="ecjia-push-comment flow-goods-list">
    <label class="select-item">
        <li>
            <span class="ecjiaf-fr">
                <div class="ecjia-anonymity-check"><input type="radio" name="anonymity" value="" /><p>匿名评价</p></div>
            </span>
        </li>
    </label>
    <span class="ecjiaf-fr push-comment-btn">
        <input class="btn" name="push-comment-btn" type="submit" value="发表评价"/>
    </span>
</div>
<!-- {/block} -->