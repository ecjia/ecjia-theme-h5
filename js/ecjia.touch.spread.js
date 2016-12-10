/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.touch.spread = {
		init : function(){
			ecjia.touch.spread.spread();
			ecjia.touch.spread.hint();
		},
		spread: function() {
			$('.would-spread').on('click', function (e) {
				//$('.bottom-elastic-layer').animate({height:'toggle'});
			});
        },  
		hint: function() {
			var myApp = new Framework7({
				modalButtonOk: '确定',
				modalTitle: '温馨提示',
		    });
			var $$ = Dom7;
			
			var mySwiper3 = myApp.swiper('.swiper-3', {
				  pagination:'.swiper-3 .swiper-pagination',
				  spaceBetween: 10,
				  slidesPerView: 3
				});
			
			$$('.alert-text1').on('click', function () {
			    myApp.alert('邀请成功即可获得积分奖励' + '<br>' + '积分可在购买商品时使用');
			});
			$$('.alert-text2').on('click', function () {
			    myApp.alert('邀请成功即可获得红包奖励' + '<br>' + '红包可在购买商品时使用');
			});
			$$('.alert-text3').on('click', function () {
			    myApp.alert('邀请成功即可获得现金奖励' + '<br>' + '现金可在购买商品时使用');
			});
        },     
	};
})(ecjia, jQuery);
