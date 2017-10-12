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
<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp"></script>
<script>
var data = JSON.parse('{$data}');
var arr = JSON.parse('{$arr}');
var store_json = '{$store_location}';
if (store_json.length > 0) {
	var store_location = JSON.parse(location);
}
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
if (store_location != undefined) {
	latlngs.push(new qq.maps.LatLng(store_location.latitude, store_location.longitude));
}
var anchor = new qq.maps.Point(75, 42),
size = new qq.maps.Size(150, 85),
origin = new qq.maps.Point(0, 0),
icon_0 = new qq.maps.MarkerImage(theme_url + 'images/icon/icon-shopping-express.png', size, origin, anchor);
icon_1 = new qq.maps.MarkerImage(theme_url + 'images/icon/icon-shopping-address.png', size, origin, anchor);
icon_2 = new qq.maps.MarkerImage(theme_url + 'images/icon/icon-store-address.png', size, origin, anchor);

for (var i = 0;i < latlngs.length; i++) {
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
setTimeout(function () { location.reload(); }, 20000)
</script>
<!-- {/block} -->
<!-- {block name="main-content"} -->
<div id="allmap">
</div>
<div class="express-info">
	<div class="express-img">
		<img src="{$express_info.avatar}" />
	</div>
	<div class="info">
		<div class="name">{$express_info.express_user}</div>
		<div class="status">{$express_info.label_shipping_status}</div>
	</div>
	<div class="phone">
		<a href="tel:{$express_info.express_mobile}"><img src="{$theme_url}images/icon/icon-phone.png" /></a>
	</div>
</div>
<!-- {/block} -->
{/nocache}