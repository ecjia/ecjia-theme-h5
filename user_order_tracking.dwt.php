<?php 
/*
Name: 订单跟踪模板
Description: 订单跟踪页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->

<script type="text/javascript">ecjia.touch.goods.init();</script>
<script type="text/javascript">
jQuery(function($){
	var resultJson = {$trackinfo};
	var resultTable = $("#queryResult");
	resultTable.empty();
	if(resultJson.status == 200) { //成功
		var resultData = resultJson.data;
		for (var i = resultData.length - 1; i >= 0; i--) {
			var className = "";
			if(i%2 == 0){
				className = "even";
			}else{
				className="odd";
			}
			if(resultData.length == 1){
				if(resultJson.ischeck == 1){
					className += " checked";
				}else{
					className += " wait";
				}
			}else if(i == resultData.length - 1){
				className += " first-line";
			}else if(i == 0){
				className += " last-line";
				if(resultJson.ischeck == 1){
					className += " checked";
				}else{
					className += " wait";
				}
			}

			var index = resultData[i].ftime.indexOf(" ");
			var result_date = resultData[i].ftime.substring(0,index);
			var result_time = resultData[i].ftime.substring(index+1);

			var s_index = result_time.lastIndexOf(":");
			result_time = result_time.substring(0,s_index);
			resultTable.append("<li><i class='fa fa-check-circle ect-color'></i><p>" + resultData[i].context + "</p><p class='tracking-time'>" + result_date + "&nbsp;"+result_time + "</p></li>");
		}
		resultTable.append(' <p class="tracking-title">{$shipping_name}<br /><span>{$invoice_no}</span></p>');
		$("body").animate({scrollTop: "1000px"}, 1000);
	}else if(resultJson.status == 400){
		resultTable.append("<p>{t}订单暂未发货，请稍后再来查询{/t}</p>");				
	}else{
		resultTable.append("<p>"+ resultJson.message +"</p>");
	}
})
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->

<section class="user-order-tracking ect-padding-tb ect-padding-lr">
	<ul id="queryResult"></ul>
</section>
<!-- {/block} -->
