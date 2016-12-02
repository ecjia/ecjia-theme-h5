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
<script type="text/javascript">ecjia.touch.region_change();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-list ecjia-article" action="" method="post" id="searchForm" name="searchForm">
	<ul class="list-one user-address-list">
		<!-- {foreach from=$data item=value} 帮助中心 -->
			<span>{$value.name}</span>
			<!-- {foreach from=$value.article item=val} -->
				<li>
					<div class="form-group form-group-text">
						<a href="{RC_uri::url('article/index/info')}&title={$val.title}&aid={$val.id}">
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