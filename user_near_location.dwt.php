<?php 
/*
Name: 定位当前位置模板
Description: 定位当前位置页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.address_list();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
{if $smarty.get.type eq 'index'}
<div id="address" data-url="{url path='touch/index/init'}">
{else}
<div id="address" data-url="{url path='user/user_address/add_address'}">
{/if}
    <div class="ecjia-zs">
      <div class="ecjia-zt al">
              <a href="{url path='user/user_address/city' args="city=selectcity{if $smarty.get.city_id}&city_id={$smarty.get.city_id}{/if}"}"><h2 class="ecjia-zu">{if $smarty.get.city}{$smarty.get.city}{/if}</h2></a>
              <input id="list" data-toggle="search-address" data-url="{url path='user/user_address/near_address'}"  class="ecjia-zv" name="address" type="text" placeholder="小区、写字楼、学校" maxlength="50" >
      </div>
      <div class="ecjia-aaddres_list">
           <ul class="nav-list-ready"></ul>    
      </div>
</div>
<!-- {/block} -->