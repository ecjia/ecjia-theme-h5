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
			var length = parseInt($('.swiper-wrapper').children('div').length) - 1;
			var mySwiper3 = myApp.swiper('.swiper-3', {
				  pagination:'.swiper-3 .swiper-pagination',
				  spaceBetween: 10,
				  effect : 'coverflow',
				  slidesPerView: 3,
				  centeredSlides: true,
				  initialSlide : length,
				  coverflow: {
			            rotate: 0,
			            stretch: 3,
			            depth: 5,
			            modifier: 1,
			            slideShadows : false
			        },
			        onClick : function(swiper){
			        	$(".detail-list").html(' ');
			        	$(".detail-list").attr('data-url', '');
						$(".detail-list").attr('data-toggle', '');
			        	
			        	var index = swiper.clickedIndex;
			        	var date = $('.swiper-wrapper').children('.swiper-slide').eq(index).children('span').attr('data-date');
			        	var url = $('input[name="reward_url"]').val();
			        	var info = {
			        		'date' : date
			        	};
						$.get(url, info, function(data){
							$(".detail-list").attr('data-url', data.data.url);
							$(".detail-list").attr('data-toggle', data.data.data_toggle);
							$(".detail-list").html(' ').html(data.list);
							$('.load-list').remove();
							
							if (data.list == null && parseInt($('.detail-list').children('li').length) == 0) {
								var empty = '<div class="ecjia-nolist">' + 
								'<div class="img-noreward"></div>' + 
								'<p>暂无奖励</p></div>';
								$(".detail-list").html(empty);
							}
							ecjia.touch.asynclist();
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
