/**
 * 后台综合js文件
 */
;
(function(ecjia, $) {
	ecjia.touch.user_account = {
		init: function() {
			ecjia.touch.user_account.wxpay_user_account();
			ecjia.touch.user_account.btnflash();
		},
		wxpay_user_account: function() {
			$('.wxpay-btn').on('click', function(e) {
				e.preventDefault();
				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				
				var record = $('input[name="record"]').val();
				var amount = $('input[name="amount"]').val();
	
				if (amount == '') {
					$('.la-ball-atom').remove();
					alert("金额不能为空");
					return false;
				}
			
				if (record != 1) {
					$(this).val("支付请求中，请稍后");
				}
				
				$(this).attr("disabled", true); 
				$(this).css("border", 0);
				$(this).css("background", "#ddd");
				$(this).css("color", "black");
				var url = $("form[name='useraccountForm']").attr('action');
				$("form[name='useraccountForm']").ajaxSubmit({
					type: 'post',
					url: url,
					dataType: "json",
					success: function(data) {
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
		
		btnflash : function() {
			$('.alipay-btn').on('click', function(e) {
				e.preventDefault();
				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				
				var record = $('input[name="record"]').val();
				var amount = $('input[name="amount"]').val();
				if (amount == '') {
					$('.la-ball-atom').remove();
					alert("金额不能为空");
					return false;
				}

				if (record != 1) {
					$(this).val("支付请求中，请稍后");
				}
				$(this).attr("disabled", true); 
				$(this).css("border", 0);
				$(this).css("background", "#ddd");
				$(this).css("color", "black");
				
				var url = $("form[name='useraccountForm']").attr('action');
				$("form[name='useraccountForm']").ajaxSubmit({
					type: 'post',
					url: url,
					dataType: "json",
					success: function(data) {
						location.href = data.redirect_url;
//						ecjia.touch.showmessage(data);
					}
				});
			});
		},
	};
})(ecjia, jQuery);

//end