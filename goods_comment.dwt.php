<?php 
/*
Name: 商品评论列表模板
Description: 商品评论列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.comment.init();</script>
<!-- {/block} -->

<!-- {block name="ecjia"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<!--评论表单 start-->
<div class="submit-comments">
	<form class="ecjia-form comment-form form-group" name="commentForm" action="{url path='comment/index/add_comment'}" method="post">
		<div class="add-comment">
			<div class="hd">
				<p class="comemnt-content">
					<!--{if $smarty.session.user_name}-->
					{$smarty.session.user_name}
					<!--{else}-->
					{$lang.anonymous}
					<!--{/if}-->
				</p>
				<span class="rating rating0 comment-level">
					<span class="star" data-level="5" ></span>
					<span class="star" data-level="4"></span>
					<span class="star" data-level="3"></span>
					<span class="star" data-level="2"></span>
					<span class="star" data-level="1"></span>
				</span>
				<input type="hidden" name="level-hide" value="">
			</div>
			<div class="comment-content ecjia-margin-t">
				<!-- {if $email eq ''} -->
				<p class="comment-email">
					<input type="text" name="emails" placeholder="E - mail" value="{$email}" />
				</p>
				<!-- {/if} -->
				<p class="add-comment-con {if $email eq ''} ecjia-margin-t{/if}">
					<textarea name="content" placeholder="{$lang.comment_content}"></textarea>
					<input type="hidden" name="id" value="{$id}" />
				</p>
				<!-- 判断是否启用验证码 -->
				<!-- {if $enabled_captcha} -->
				<p class="comment-email comment_captcha ecjia-margin-t">
					<span class="ecjiaf-fl">
						<input placeholder="{$lang.comment_captcha}" type="text" name="captcha"/>
					</span>
					<img class="ecjiaf-fr" src="{url path='captcha/index/init'}" alt="captcha" onClick="this.src='{url path='captcha/index/init'}&t='+Math.random();" />
				</p>
				<!-- {/if} -->
			</div>
			<p class="add-comment-btn ecjia-margin-t">
				<input class="btn btn-info" data-toggle="add-comment" type="submit" value="{$lang.submit_comment}"/>
			</p>
		</div>
	</form>
</div>
<!--用户评论 END-->
<!-- {/block} -->