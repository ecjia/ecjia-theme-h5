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
	height: 100%;
	max-width: 640px;
}
.ecjia #allmap{
	width: 100%;
	height: 100%;
}
</style>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp"></script>
<script charset="utf-8" src="http://map.qq.com/api/js?v=2.exp&libraries=convertor"></script>
<script type="text/javascript">
var lng='{$longitude}';
var lat='{$latitude}';
var geocoder,map, marker = null;

//转换百度坐标为腾讯坐标  1：gps经纬度；2：搜狗经纬度；3：百度经纬度；4：mapbar经纬度；5：google经纬度；6：搜狗墨卡托。
qq.maps.convertor.translate(new qq.maps.LatLng(lat,lng), 3, function(res){
    latlng = res[0];
	//设置经纬度信息
	var center = new qq.maps.LatLng(latlng.lat,latlng.lng);
    map = new qq.maps.Map(document.getElementById('allmap'),{
		center: center,	//居中显示
        zoom: 18
	});
    var info = new qq.maps.InfoWindow({
        map: map
    });
	//调用地址解析类
    geocoder = new qq.maps.Geocoder({
        complete : function(result){
            map.setCenter(result.detail.location);
            var marker = new qq.maps.Marker({
                map:map,
                position: result.detail.location
            });
            //添加监听事件 当标记被点击了  设置图层
            qq.maps.event.addListener(marker, 'click', function() {
                info.open();
                info.setContent('<div style="width:auto;height:20px;">'+
                    result.detail.address+'</div>');
                info.setPosition(result.detail.location);
            });
        }
    });
    geocoder.getAddress(center);
});
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div id="allmap">
</div>
<!-- {/block} -->
