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
					var order_money = $("input[name='order_money']").val();
			        var drop_out_money = $("input[name='drop_out_money']").val();
			        var store_id = $("input[name='store_id']").val();
			        if (order_money != '') {
			        	var url =  $("input[name='drop_out_money']").attr('data-url')
			        	var info = {
			        		'store_id'    : store_id,
			        		'order_money' : order_money,
			        		'drop_out_money' : drop_out_money,
			        	}
			        	$.post(url, info, function(data) {
			        		$('.quickpay-content').html(data.list);
			        		$("body").greenCheck();
			        	});
			        } else {
			        	$('.quickpay-content').html('');
			        }
			        return false;
				}
            });
			
			$('input[name="payment_id"]').on('click', function() {
				var url = $('.payment-list').attr('data-url');
				var $this = $(this);
				var val = $this.val();
				$.post(url, {val: val});
			});
			
			$('.quickpay_done').on('click', function(e) {
				e.preventDefault();
				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				var order_id = $("input[name='order_id']").val();
				if (order_id == undefined) {
					var order_money = $("input[name='order_money']").val();
					if (order_money == '' || order_money.length == 0 || order_money == undefined) {
						alert('订单金额不能为空');
						return false;
					}
					if (order_money == 0) {
						alert('订单金额不能为0');
						return false;
					}
				}
				var url = $("form[name='quickpayForm']").attr('action');
				$("form[name='quickpayForm']").ajaxSubmit({
					type: 'post',
					url: url,
					dataType: "json",
					success: function(data) {
						$('.la-ball-atom').remove();
						if (data.redirect_url) {
							location.href = data.redirect_url;
						} else if(data.weixin_data) {
							$('.wei-xin-pay').html("");
							$('.wei-xin-pay').html(data.weixin_data);
							callpay();
						}
					}
				});
			});
        },
	};
})(ecjia, jQuery);

//end