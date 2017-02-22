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
<script type="text/JavaScript" src="http://api.map.baidu.com/api?v=1.3"></script>
<script type="text/javascript">   
       var map = new BMap.Map("container"); // 创建地图实例
       
       var point2 = new BMap.Point(121.408897, 31.229071); // 创建点坐标
       map.centerAndZoom(point2, 15);  // 初始化地图，设置中心点坐标和地图级别
       map.addControl(new BMap.NavigationControl());

       var marker = new BMap.Marker(point2); // 创建标注
       map.addOverlay(marker);
       marker.enableDragging();
       //标注拖拽后的位置
       marker.addEventListener("dragend", function (e) {
           alert("当前位置：" + e.point.lng + ", " + e.point.lat);
       });
       //点击的位置
       map.addEventListener("click", function (e) {
           var pointClick=  new BMap.Point(e.point.lng , e.point.lat);
           map.openInfoWindow(pointClick);
       });
</script>
<!-- {/block} -->
<!-- {block name="main-content"} -->
 	<div id="container"></div>
	<div class="ecjia-f-location">
		<span>经度：</span>
		<input name="f_mobile"  type="text" value=""  />
		<span style="margin-left: 25px;">纬度：</span>
		<input name="f_mobile"  type="text" value=""  />
	</div>
	
 	<div class="ecjia-margin-t ecjia-margin-b">
	    <input name="temp_key" type="hidden" value="{$temp_key}" />
		<input class="btn btn-info nopjax" name="submit" type="submit" value="{t}保存{/t}"/>
	</div>
<!-- {/block} -->