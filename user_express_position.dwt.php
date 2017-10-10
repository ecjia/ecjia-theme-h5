<?php 
/*
Name: 配送员
Description: 这是配送员位置地图页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->
<!-- {block name="footer"} -->
<style type="text/css">
.ecjia{ height:100%;max-width:640px }
.ecjia #allmap{ width:100%;height:90% }
.express-info{ height:10%;display:flex;flex-direction:row;justify-content:space-between;align-items:center }
.express-img image{ width:100rpx;height:100rpx }
.info{ width:65%;display:flex;flex-direction:column;font-size:26rpx;line-height:50rpx;height:100% }
.name{ height:25%;padding-top:8% }
.status{ color:#999;overflow:hidden;text-overflow:ellipsis;white-space:nowrap }
.express-img{ height:100%;display:flex;align-items:center;width:20%;justify-content:center }
.phone{ height:60%;display:flex;align-items:center;border-left:2rpx solid #eee;width:15%;justify-content:center }
.phone image{ width:60rpx;height:60rpx }
</style>
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp"></script>
<script>
// var center = new qq.maps.LatLng(39.91474,116.37333);
var data = JSON.parse('{$data}');
var arr = JSON.parse('{$arr}');
var store_location = JSON.parse('{$store_location}');
var center = new qq.maps.LatLng(arr.from.location.lat, arr.from.location.lng);
var map = new qq.maps.Map(document.getElementById("allmap"), {
    center: center,
    zoom: 18
});
var infoWin = new qq.maps.InfoWindow({
    map: map
});
var latlngs = [
    new qq.maps.LatLng(arr.from.location.lat, arr.from.location.lng),
    new qq.maps.LatLng(arr.to.location.lat, arr.to.location.lng)
];

if (store_location != null) {
	latlngs.push(new qq.maps.LatLng(store_location.latitude, store_location.longitude));
}
var anchor = new qq.maps.Point(75, 42),
size = new qq.maps.Size(150, 85),
origin = new qq.maps.Point(0, 0),
icon_0 = new qq.maps.MarkerImage(theme_url + 'images/icon/icon-shopping-express.png', size, origin, anchor);
icon_1 = new qq.maps.MarkerImage(theme_url + 'images/icon/icon-shopping-address.png', size, origin, anchor);
icon_2 = new qq.maps.MarkerImage(theme_url + 'images/icon/icon-store-address.png', size, origin, anchor);

for(var i = 0;i < latlngs.length; i++) {
    (function(n){
        if (n == 0) {
            var marker = new qq.maps.Marker({
                position: latlngs[n],
                map: map,
                icon: icon_0
            });
        } else if (n == 1) {
            var marker = new qq.maps.Marker({
                position: latlngs[n],
                map: map,
                icon: icon_1
            });
        } else if (n == 2 && store_location != null) {
            var marker = new qq.maps.Marker({
                position: latlngs[n],
                map: map,
                icon: icon_2
            });
        } 

    })(i);
}    
</script>
<!-- {/block} -->
<!-- {block name="main-content"} -->
<div id="allmap">
</div>
<div class="express-info">
	<div class="express-img">
		<img src="" />
	</div>
	<div class="info">
		<div class="name"></view>
		<div class="status"></view>
	</div>
	<div class="phone">
		<img src="" />
	</div>
</div>
<!-- {/block} -->
{/nocache}