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
         $(".citylist li").click(function(){             
              var city_id=$(this).attr('data-id');  
              var city_name=$(this).text();
              var url = $("#cityall").attr('data-url');
              url += '&city=' + city_name + '&city_id=' + city_id;
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
	<ul class="city citylist" >
	<!-- {foreach from=$citylist item=list} -->
		<li data-id="{$list.id}"{if $list.id eq $smarty.get.city_id} class="active"{/if}>{$list.name}</li>
	<!-- {foreachelse} -->
		<li>暂无</li>
	<!-- {/foreach} -->
	</ul>
</div>
<!-- {/block} -->