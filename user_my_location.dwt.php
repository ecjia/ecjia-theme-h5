<?php 
/*
Name: 我的位置模板
Description: 我的位置
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->

<script type="text/javascript">ecjia.touch.region_change();</script>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=P4C6rokKFWHjXELjOnogw3zbxC0VYubo"></script>
<script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script>
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script> 
<script type="text/javascript">
{literal}
    // 百度地图API功能
    var map = new BMap.Map("allmap");
    var point = new BMap.Point(116.331398,39.897445);
    map.centerAndZoom(point,13);
    map.enableScrollWheelZoom();  
    
    var geolocation = new BMap.Geolocation();
    geolocation.getCurrentPosition(function(r){
    	if(this.getStatus() == BMAP_STATUS_SUCCESS){
    		var myGeo = new BMap.Geocoder(); 
    		var mk = new BMap.Marker(r.point);
    		
    		map.addOverlay(mk);
    		map.panTo(r.point);
    		var mPoint = new BMap.Point(r.point.lng, r.point.lat);

    		var mOption = {
			    poiRadius : 500,           //半径为500米内的POI,默认100米
			    numPois : 50                //列举出50个POI,默认10个
			}
			
    		myGeo.getLocation(mPoint, function mCallback(rs) {
    			var allPois = rs.surroundingPois;       //获取全部POI（该点半径为100米内有6个POI点）
    			console.log(allPois);
                for(i=0;i<allPois.length;++i){
                    document.getElementById("panel").innerHTML += "<p style='font-size:12px;' lng='"+ allPois[i].point.lng +"'>" + (i+1) + "、" + allPois[i].title + ",地址:" + allPois[i].address + "</p>" + "<hr>";
                    map.addOverlay(new BMap.Marker(allPois[i].point));                
                }
        	}, mOption);
    		
//     		alert('您的位置：'+r.point.lng+','+r.point.lat);
    	}
    	else {
//     		alert('failed'+this.getStatus());
    	}        
    },{enableHighAccuracy: true})
    
    
    
    
{/literal}
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-list ecjia-address-list" action="" method="post" name="searchForm">
	<div class="address-background-mylocation">
		<i class="iconfont icon-search1"></i>
		<input id="keywordBox" name="keywords" type="search" placeholder="搜索地点">
	</div>
    <div id="allmap" style="height: 20em;width: 100%"></div>
    <div id="panel" style="width:100%;height:100%;border:1px solid gray;"></div>
</form>

<!-- {/block} -->