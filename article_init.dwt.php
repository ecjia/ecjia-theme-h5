<?php 
/*
Name: 帮助中心
Description: 帮助中心首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.spread.article();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-article ecjia-article0" action="" method="post" id="searchForm" name="searchForm">
	<ul class="list-one user-address-list ecjia-list list-short">
		<!-- {foreach from=$data item=value} 帮助中心 -->
			<div class="pf"><span>{$value.name}</span></div>
			<!-- {foreach from=$value.article item=val} -->
				<li>
					<div class="form-group form-group-text">
						<a href="{RC_uri::url('article/help/detail')}&title={$val.title}&aid={$val.id}">
						<span>{$val.title}</span>
						<i class="ecjiaf-fr iconfont icon-jiantou-right"></i>
						</a>
					</div>
				</li>
			<!-- {/foreach} -->
		<!-- {/foreach} -->
	</ul>
</form>
<!-- {/block} -->