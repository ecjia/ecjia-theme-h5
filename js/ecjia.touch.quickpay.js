/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.touch.quickpay = {
		init : function(){
			ecjia.touch.quickpay.check();
			$("body").greenCheck();
			ecjia.touch.quickpay.quick_pay();
		},
		check: function() {
			$('input[name="order_money"]').koala({
				delay: 500,
				keyup: function(event) {
					ecjia.touch.quickpay.checkout('change', 'activity_id');
				}
            });
			
			$('input[name="drop_out_money"]').koala({
				delay: 500,
				keyup: function(event) {
					ecjia.touch.quickpay.checkout('change', 'activity_id');
				}
            });
			
			$('input[name="activity_id"]').off('click').on('click', function() {
				var order_money = $("input[name='order_money']").val();
				if (order_money == '' || order_money.length == 0 || order_money == undefined) {
					alert('请输入消费金额');
					return false;
				}
				ecjia.touch.quickpay.checkout('change');
			});
			
			$('input[name="show_exclude_amount"]').off('change').on('change', function() {
				var val = $('input[name="show_exclude_amount"]:checked').val();
				if (val == 1) {
					$('.amount_li.li').show();
					$(this).parent('label').addClass('ecjia-checkbox-checked');
				} else {
					$('.amount_li.li').hide();
					$(this).parent('label').removeClass('ecjia-checkbox-checked');
				}
				var drop_out_money = $("input[name='drop_out_money']").val();
				if (drop_out_money != '' && drop_out_money != 0) {
					ecjia.touch.quickpay.checkout('change');
				} else {
					ecjia.touch.quickpay.checkout();
				}
			});
			
			$('.quickpay_done').off('click').on('click', function(e) {
				e.preventDefault();
				var order_id = $("input[name='order_id']").val();
				var show_exclude_amount = $("input[name='show_exclude_amount']:checked").val();
				if (order_id == undefined) {
					var order_money = $("input[name='order_money']").val();
					if (order_money == '' || order_money.length == 0 || order_money == undefined) {
						alert('消费金额不能为空');
						return false;
					}
					if (order_money == 0) {
						alert('消费金额不能为0');
						return false;
					}
					var drop_out_money = $("input[name='drop_out_money']").val();
					if (show_exclude_amount == 1 && drop_out_money > order_money) {
						alert('不参与优惠金额不能大于消费总金额');
						return false;
					}
				}
				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				var url = $("form[name='quickpayForm']").attr('action');
				$("form[name='quickpayForm']").ajaxSubmit({
					type: 'post',
					url: url,
					dataType: "json",
					success: function(data) {
						$('.la-ball-atom').remove();
						if (data.redirect_url) {
							location.href = data.redirect_url;
						}
					}
				});
			});
        },
        
        checkout: function(c, a) {
        	var change = 0;
        	if (c == 'change') {
        		change = 1;
        	}
			var order_money = $("input[name='order_money']").val();
	        var drop_out_money = $("input[name='drop_out_money']").val();
	        var store_id = $("input[name='store_id']").val();
	        var show_exclude_amount = $("input[name='show_exclude_amount']:checked").val();
	        
        	var url =  $("input[name='drop_out_money']").attr('data-url')
        	var activity_id = $("input[name='activity_id']:checked").val();
        	if (a != undefined) {
        		activity_id = 0;
        	}
        	
        	var info = {
        		'store_id' 				: store_id,
        		'order_money' 			: order_money,
        		'drop_out_money' 		: drop_out_money,
        		'activity_id'			: activity_id,
        		'show_exclude_amount' 	: show_exclude_amount,
        		'change'				: change
        	}
        	$.post(url, info, function(data) {
        		console.log(data);
        		$('.quickpay_done').removeAttr('disabled');
        		$('.quickpay-content').html(data.list);
        		$("body").greenCheck();
        		ecjia.touch.quickpay.init();
        	});
	        return false;
        },
        
		quick_pay: function() {
			$('.quick_pay_btn').on('click', function(e) {
				e.preventDefault();
				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				
				$(this).val("支付请求中，请稍后");
				$(this).attr("disabled", true); 
				$(this).addClass("payment-bottom");
				
				var url = $("form[name='quickpay_form']").attr('action');
				$("form[name='quickpay_form']").ajaxSubmit({
					type: 'post',
					url: url,
					dataType: "json",
					success: function(data) {
						$('.quick_pay_btn').removeClass("payment-bottom")
						$('.la-ball-atom').remove();
						$('.quick_pay_btn').removeAttr("disabled"); 
						$('.quick_pay_btn').val("确认支付");
						if (data.state == 'error') {
							alert(data.message);
							return false;
						}
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