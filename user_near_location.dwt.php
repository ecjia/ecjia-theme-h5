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
	// 百度地图API功能
	function G(id) {
		return document.getElementById(id);
	}
	var map = new BMap.Map("l-map");
    var city = $('.city_name').children('span').html();
	map.centerAndZoom(city,12);                   // 初始化地图,设置城市和地图级别。
	var ac = new BMap.Autocomplete(//建立一个自动完成的对象
		{
			"input" : "suggestId"
		,"location" : map
	});

	ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
	var str = "";
		var _value = e.fromitem.value;
		var value = "";
		if (e.fromitem.index > -1) {
			value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
		}    
		str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;
		
		value = "";
		if (e.toitem.index > -1) {
			_value = e.toitem.value;
			value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
		}    
		str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
		G("searchResultPanel").innerHTML = str;
	});

	var myValue;
	ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
	var _value = e.item.value;
		myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
		G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
		
		setPlace();
		
		var url = $("#select-city").attr('data-url');
	    url += '&address=' + myValue + '&city=' + city;
	    ecjia.pjax(url);
	});

	function setPlace(){
		map.clearOverlays();    //清除地图上所有覆盖物
		function myFun(){
			var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
			map.centerAndZoom(pp, 18);
			map.addOverlay(new BMap.Marker(pp));    //添加标注
		}
		var local = new BMap.LocalSearch(map, { //智能搜索
		  onSearchComplete: myFun
		});
		local.search(myValue);
	}	
</script>

<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-list ecjia-address-list" action="" method="post" id="searchForm" name="searchForm">
	{if $smarty.get.type eq 'index'}
	<div class="address-backgroundw" id="select-city" data-url="{url path='touch/index/init'}">
	{else}
	<div class="address-backgroundw" id="select-city" data-url="{url path='user/user_address/add_address'}">
	{/if}
		<a href="{url path='user/user_address/city' args="city=selectcity"}"><span class="city_name"><input type="text" id="tresult"/><span>{if $smarty.get.city}{$smarty.get.city}{/if}</span></span></a>
		<i class="iconfont icon-jiantou-bottom"></i>
		<i class="img-search"></i>
		<div id="r-result" style="width:100%;"><input type="text" id="suggestId"  name="keywords" type="search" value="" placeholder="小区、写字楼、学校"></div>
	</div>
		
	<div id="l-map" style="height:600px;width:100%;display:none;"></div>
	<div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>	
	
</div>
	
	
	
</form>
<!-- {/block} -->