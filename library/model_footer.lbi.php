<?php
/*
Name: 首页底部模块
Description: 这是首页的底部模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<footer>
	<div class="footer-icon">
		<ul class="ecjia-list ecjia-list-three">
			<li><a href="{url path='touch/index/download'}"><i class="iconfont icon-app"></i><p>{t}客户端{/t}</p></a></li>
			<li><a class="active" href="javascript:;"><i class="iconfont icon-shouji"></i><p>{t}触屏版{/t}</p></a></li>
			<li><a href="{$shop_pc_url}"><i class="iconfont icon-pc"></i><p>{t}电脑版{/t}</p></a></li>
		</ul>
	</div>
	<div class="copyright">
		{$copyright}
	</div>
</footer>
