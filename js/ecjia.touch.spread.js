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
				  effect : 'coverflow',
				  slidesPerView: 3,
				  centeredSlides: true,
				  coverflow: {
			            rotate: 0,
			            stretch: 3,
			            depth: 5,
			            modifier: 1,
			            slideShadows : false
			        },
			        onClick : function(swiper){
			        	var index = swiper.clickedIndex;
			        	var date = $('.swiper-wrapper').children('.swiper-slide').eq(index).children('span').attr('data-date');
			        	console.log(date);
			        	var url = $('input[name="reward_url"]').val();
			        	var info = {
			        		'date' : date
			        	};
						$.post(url, info, function(data){
							return false;
							$(".data-date").html(data);
						});
			        }
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
