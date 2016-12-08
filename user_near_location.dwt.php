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
<script type="text/javascript">ecjia.touch.region_change();</script>

<script type="text/javascript">
   $('.city_name').on('click', function () {
      $('.cityall').css('display', 'block');
      $('.address-backgroundw').css('display', 'none');
   });

   $(document).ready(function(){  
         var Uarry=$("#tcontent li");
         $("#tcontent li").click(function(){             
              var count=$(this).index();  
              var Tresult=Uarry.eq(count).text();  
              $("#tresult").val(Tresult);  
              if($("#tresult").val()){
                  	$('.city_name').children('span').html($("#tresult").val());
         		 $('.cityall').css('display', 'none');
        	     $('.address-backgroundw').css('display', 'block');
        	  }
         }) 
  	})  

</script>


<!-- {/block} -->

<!-- {block name="main-content"} -->

<form class="ecjia-list ecjia-address-list" action="" method="post" id="searchForm" name="searchForm">
	<div class="address-backgroundw">
		<span class="city_name" ><input type="text" id="tresult"/><span>上海</span></span>
		<i class="iconfont icon-jiantou-bottom"></i>
		<i class="img-search"></i>
		<input id="keywordBox" name="keywords" type="search" placeholder="小区、写字楼、学校">
	</div>
		
	<div class="cityall" style="display: none;">
		<h2 class="select-city"><span>选择城市</span></h2>
		<ul class="city" id="tcontent">
			<li cityid="1" >北京</li>
			<li cityid="1601" >广州</li>
			<li cityid="1607" >深圳</li>
			
			<li cityid="1381" >武汉</li>
			<li cityid="904" >南京</li>
			<li cityid="2376" >西安</li>
			
			<li cityid="2" >上海</li>
			<li cityid="1930" >成都</li>
			<li cityid="3" >天津</li>
		
			<li cityid="1213" >杭州</li>
			<li cityid="4" >重庆</li>
			<li cityid="1116">合肥</li>
		</ul>
	</div>
	
	
</form>
<!-- {/block} -->