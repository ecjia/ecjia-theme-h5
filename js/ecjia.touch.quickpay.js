/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.touch.quickpay = {
		init : function(){
			ecjia.touch.quickpay.check();
		},
		check: function() {
			$('input').bind('input propertychange', function(e) {  
				e.preventDefault();
		        var order_money = $("input[name='order-money']").val();
		        var drop_out_money = $("input[name='drop-out-money']").val();
		        var store_id = $("input[name='store_id']").val();
		        if (order_money != '' && drop_out_money != '') {
		        	var url =  $("input[name='drop-out-money']").attr('data-url')
		        	var info = {
		        		'store_id'    : store_id,
		        		'order_money' : order_money,
		        		'drop_out_money' : drop_out_money,
		        	}
		        	$.post(url, info, function(data) {
		        		console.log(data)
		        	});
		        }
		
            })
        },
	};
})(ecjia, jQuery);

//end