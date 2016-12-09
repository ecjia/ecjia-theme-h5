<?php
/*
Name: 城市模板
Description: 选择城市模板
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	$(document).ready(function(){  
         var Uarry=$("#tcontent li");
         $("#tcontent li").click(function(){             
              var count=$(this).index();  
              var Tresult=Uarry.eq(count).text();  
              var url = $("#cityall").attr('data-url');
              url += '&city=' + Tresult;
              ecjia.pjax(url);
         }) 
  	})  
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
{if $smarty.get.city eq 'addcity'}
	<div class="cityall" id="cityall" data-url="{url path='user/user_address/add_address'}">
{else}
	<div class="cityall" id="cityall" data-url="{url path='user/user_address/near_location'}">
{/if}
	<h2 class="select-city"><span>选择城市</span></h2>
	<ul class="city" id="tcontent">
		<li cityid="1">北京</li>
		<li cityid="1601">广州</li>
		<li cityid="1607">深圳</li>
		
		<li cityid="1381">武汉</li>
		<li cityid="904">南京</li>
		<li cityid="2376">西安</li>
		
		<li cityid="2">上海</li>
		<li cityid="1930">成都</li>
		<li cityid="3">天津</li>
	
		<li cityid="1213" >杭州</li>
		<li cityid="4" >重庆</li>
		<li cityid="1116">合肥</li>
	</ul>
</div>
<!-- {/block} -->