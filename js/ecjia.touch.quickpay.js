/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.touch.quickpay = {
		init : function(){
			ecjia.touch.quickpay.check();
			$("body").greenCheck();
		},
		check: function() {
			$('.quick_money').koala({
				delay: 500,
				keyup: function(event) {
					ecjia.touch.quickpay.checkout();
				}
            });
			
			$('.radio-height').on('click', function() {
				var order_money = $("input[name='order_money']").val();
				if (order_money == '') {
					alert('请先输入消费金额');
		        	return false;
				}
			});
			
			$('input[name="activity_id"]').on('click', function() {
				var order_money = $("input[name='order_money']").val();
		        var drop_out_money = $("input[name='drop_out_money']").val();
		        var store_id = $("input[name='store_id']").val();
		        if (order_money != '') {
		        	var url =  $("input[name='drop_out_money']").attr('data-url')
		        	var activity_id = $("input[name='activity_id']:checked").val()
		        	var info = {
		        		'store_id'    : store_id,
		        		'order_money' : order_money,
		        		'drop_out_money' : drop_out_money,
		        		'activity_id': activity_id
		        	}
		        	$.post(url, info, function(data) {
		        		$('.quickpay-content').html(data.list);
		        	});
		        } else {
		        	alert('请先输入消费金额');
		        	return false;
		        }
		        return false;
			});
			
			
			$('input[name="show_exclude_amount"]').on('change', function() {
				var val = $('input[name="show_exclude_amount"]:checked').val();
				if (val == 1) {
					$('.amount_li.li').show();
					$(this).parent('label').addClass('ecjia-checkbox-checked');
				} else {
					$('.amount_li.li').hide();
					$(this).parent('label').removeClass('ecjia-checkbox-checked');
				}
				ecjia.touch.quickpay.checkout();
			});
			
			$('.quickpay_done').off('click').on('click', function(e) {
				e.preventDefault();
				var order_id = $("input[name='order_id']").val();
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
					if (drop_out_money > order_money) {
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
        
        checkout: function() {
        	$('.ecjia-check').removeClass('ecjia-check-checked');
			$('.ecjia-check').children().prop('checked', false);
			$('.ecjia-check').children().prop('disabled', true);
			
			var order_money = $("input[name='order_money']").val();
	        var drop_out_money = $("input[name='drop_out_money']").val();
	        var store_id = $("input[name='store_id']").val();
	        var show_exclude_amount = $("input[name='show_exclude_amount']:checked").val();
	        
        	var url =  $("input[name='drop_out_money']").attr('data-url')
        	var activity_id = $("input[name='activity_id']:checked").val()
        	var info = {
        		'store_id' : store_id,
        		'order_money' : order_money,
        		'drop_out_money' : drop_out_money,
        		'activity_id': activity_id,
        		'show_exclude_amount' : show_exclude_amount
        	}
        	$.post(url, info, function(data) {
        		$('.quickpay_done').removeAttr('disabled');
        		$('.quickpay-content').html(data.list);
        		$("body").greenCheck();
        	});
	        return false;
        }
	};
})(ecjia, jQuery);

//end