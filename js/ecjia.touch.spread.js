/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.touch.spread = {
		init : function(){
			ecjia.touch.spread.spread();
			ecjia.touch.spread.hint();
			ecjia.touch.spread.article();
		},
		spread: function() {
			$('.would-spread').on('click', function (e) {
				//$('.bottom-elastic-layer').animate({height:'toggle'});
			});
        },  
        
		article: function() {
				//滚动条事件
				$(window).scroll(function(){
					//获取滚动条的滑动距离
					var scroH = $(this).scrollTop();
					
					$("ul .pf").each(function(i){
						
//						滚动时候pf离顶部的距离
						var pfTop = $(this).offset().top;
//						console.log('div' + pfTop);
//						console.log(scroH);

						//滚动条的滑动距离大于等于定位元素距离浏览器顶部的距离，就固定，反之就不固定
//						if (i>=1 && scroH >= pfTop-38) {
//							$(this).css({"position":"fixed","top":0, "z-index":9});
//						}else if(i==0 && scroH >= pfTop){
//							$(this).css({"position":"fixed","top":0, "z-index":9});
//						}else{
//							$(this).css({"position":"relative"});
//						}
//						alert(pfTop);
//						if(scroH>=pfTop){
//							alert(pfTop);
//							$(this).css("background","pink");
//							$(".pf").css({"position":"fixed","top":0});
//						}else if(scroH<pfTop){
//							$(".pf").css({"position":"static"});
//						}
				    });
				})
		  
			
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
			
			var windowWidth = $(window).width(); //屏幕的宽度
			var divWidth = 0; //每个div宽度
			var resPlaceX = 0; //最终的位置X
			var moveDistance = 0; //移动的距离
			var startTranform = 0; //当前的transform值
			var startTranformStr = '' //transform字符串
			$('.swiper-slide').on('click', function(e) {
			    var ev = e || event;
			    var disX = ev.clientX - ev.offsetX; //当前div距离屏幕左边距离
			    divWidth = $(this).width();
			    resPlaceX = (windowWidth - divWidth) / 2;
			    moveDistance = disX - resPlaceX;
			    startTranformStr = $('.swiper-wrapper').get(0).style.transform;
			    startTranform = startTranformStr.slice(startTranformStr.indexOf('(') + 1, startTranformStr.indexOf('px'));
			    if (startTranform == '') {
			        startTranform = 0
			    };
			    $('.swiper-slide').removeClass('font-red');
			    $(this).addClass('font-red');
			    $('.swiper-wrapper').css({
			        'transform': 'translate3d(' + (parseInt(startTranform) + -moveDistance) + 'px,0,0)',
			        'transition-duration': '0.5s'
			    });
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
