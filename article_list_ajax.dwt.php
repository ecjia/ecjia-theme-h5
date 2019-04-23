<?php 
/*
Name: 文章评论列表模版
Description: 文章评论列表页
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
	<!-- {foreach from=$data item=val key=key} -->
	<div class="article-item"> 
		<a class="nopjax external" href="{RC_Uri::url('article/index/detail')}&article_id={$val.article_id}">
			<div class="article-left"> 
				<p class="article-title line-clamp2">{$val.title}</p> 
				<p class="article-summary line-clamp2">{$val.description}</p> 
				<div class="article-author clearfix" data-lazy="false"> 
					<img class="lazy-img article-author-pic" src="{if $val.store_info.store_id eq 0}{$theme_url}images/store_logo.png{else}{$val.store_info.store_logo}{/if}"> 
					<span class="lazy-img article-author-name">{$val.store_info.store_name}</span> 
				</div> 
			</div> 
			<div class="article-right" data-lazy="false"> 
				<div class="img-box"> 
					<img class="lazy-img" src="{if $val.cover_image}{$val.cover_image}{else}{$theme_url}images/default-goods-pic.png{/if}"> 
				</div> 
				<div class="article-info clearfix"> 
					<div class="article-time"> 
						<div class="clock little-icon"></div> 
						<span>{$val.add_time}</span> 
					</div> 
					<div class="article-viewed"> 
						<span>{if $val.click_count gt 999}1k+{else}{$val.click_count}{/if}</span>
						<div class="eye little-icon"></div> 
					</div> 
				</div> 
			</div>
		</a> 
	</div>
	<!-- {foreachelse} -->
	<div class="ecjia-nolist"><img src="{$theme_url}images/wallet/null280.png"><p class="tags_list_font">{t domain="h5"}暂无文章{/t}</p></div>
	<!-- {/foreach} -->
<!-- {/block} -->
{/nocache}
