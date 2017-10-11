/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.touch.quickpay = {
		init : function(){
			ecjia.touch.quickpay.check();
		},
		check: function() {
			$("body").greenCheck();
			$('.quick_money').koala({
				delay: 500,
				keyup: function(event) {
					var order_money = $("input[name='order-money']").val();
			        var drop_out_money = $("input[name='drop-out-money']").val();
			        var store_id = $("input[name='store_id']").val();
			        $('.quickpay-content').html('');
			        if (order_money != '' && drop_out_money != '') {
			        	var url =  $("input[name='drop-out-money']").attr('data-url')
			        	var info = {
			        		'store_id'    : store_id,
			        		'order_money' : order_money,
			        		'drop_out_money' : drop_out_money,
			        	}
			        	$.post(url, info, function(data) {
			        		$('.quickpay-content').html(data.list);
			        		$("body").greenCheck();
			        	});
			        }
			        return false;
				}
            });
			
			$('input[name="payment_id"]').on('click', function() {
				var url = $('.payment-list').attr('data-url');
				var $this = $(this);
				var val = $this.val();
				$.post(url, {val: val});
			})
			
        },
	};
})(ecjia, jQuery);

//end