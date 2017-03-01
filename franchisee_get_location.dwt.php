<?php 
/*
Name: 店铺位置
Description: 这是店铺位置地图页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.franchisee.location();</script>
<style type="text/css">
.ecjia{
	height: 85%;
	max-width: 640px;
}
.ecjia #container{
	width: 100%;
	height: 85%;
}
</style>
<script type="text/JavaScript" src="https://api.map.baidu.com/api?v=1.3"></script>
<script type="text/javascript">   
       var map = new BMap.Map("container"); // 创建地图实例
       var lng='{$longitude}';
       var lat='{$latitude}';
       var point2 = new BMap.Point(lng, lat); // 创建点坐标
       $('input[name="longitude"]').val(lng);
       $('input[name="latitude"]').val(lat);
       
       map.centerAndZoom(point2, 15);  // 初始化地图，设置中心点坐标和地图级别
       map.addControl(new BMap.NavigationControl());

       var marker = new BMap.Marker(point2); // 创建标注
       map.addOverlay(marker);
       marker.enableDragging();
       //标注拖拽后的位置
       marker.addEventListener("dragend", function (e) {
           $('input[name="longitude"]').val(e.point.lng);
           $('input[name="latitude"]').val(e.point.lat);
       });
     
</script>
<!-- {/block} -->
<!-- {block name="main-content"} -->
<div id="container"></div>
	<div class="ecjia-f-location">
	    <div class="location-longitude">
    		<span>经度：</span>
    		<input name="longitude"  type="text"  readonly="readonly" />
		</div>
		<div class="location-latitude">
    		<span>纬度：</span>
    		<input name="latitude"  type="text"  readonly="readonly" />
		</div>
	</div>
	
 	<div class="ecjia-margin-t ecjia-margin-b">
		<input class="btn btn-info nopjax" style="margin-top: 2em;" name="button" id="button" type="button" data-url="{url path='franchisee/index/store'}" value="{t}保存{/t}"/>
	</div>
<!-- {/block} -->