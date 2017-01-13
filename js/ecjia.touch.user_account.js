/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.touch.user_account = {
		init : function(){
			ecjia.touch.user_account.pay_user_account();
			ecjia.touch.user_account.wxpay_user_account();
		},
		pay_user_account : function (){
			$('.user_pay_way').on('click',function(e){
				e.preventDefault();
				var code = $('.icon-name').attr('data-code');
				if ( code == 'pay_wxpay') {
					 $(".btn-recharge").addClass(".wxpay-btn");
				} else {
					$(".btn-recharge").removeClass(".wxpay-btn");
				}
			});
		},
		wxpay_user_account: function () {
            $('.wxpay-btn').on('click', function (e) {
            	e.preventDefault();
				var url = $("form[name='useraccountForm']").attr('action');
            	$("form[name='useraccountForm']").ajaxSubmit({
            		type: 'post',
            		url: url,
	 				dataType:"json",
	 				success:function(data) {
//	 					if (data.weixin_data != '') {
//	 						$('.btn-submit').html(data.weixin_data);
//	 					}
	 				}
	 			});
            });
        }
	};    
})(ecjia, jQuery);

//end