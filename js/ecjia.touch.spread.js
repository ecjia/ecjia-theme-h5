/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.touch.spread = {
		init : function(){
			ecjia.touch.spread.spread();
			ecjia.touch.spread.hint();
			ecjia.touch.spread.article();
			ecjia.touch.spread.share_spread();
		},
		spread: function() {
			$(document).off('click', '.would-spread');
			$(document).on('click', '.would-spread', function() {
				var ua = navigator.userAgent.toLowerCase();
				if (ua.match(/MicroMessenger/i)=="micromessenger") {
	        		$('.ecjia-spread-share').removeClass('hide').css('top', $('body').scrollTop() + 'px');
	            	//禁用滚动条
	            	$('body').css('overflow-y', 'hidden').on('touchmove',function(event){event.preventDefault;}, false);
	            	$('.ecjia-spread-share').on('click', function(){
	            		$('.ecjia-spread-share').addClass('hide');
	            		$('body').css('overflow-y', 'auto').off("touchmove");//启用滚动条
	            	})
	            	ecjia.touch.spread.share_spread();
				}
        	});
        },  
        
		article: function() {
			//滚动条事件
			$(window).scroll(function(){
				//获取滚动条的滑动距离
				var scroH = $(this).scrollTop();
				$("ul .pf").each(function(i){
					//滚动时候pf离顶部的距离
					var pfTop = $(this).offset().top;
					console.log(pfTop - scroH);
                    //滚动条的滑动距离大于等于定位元素距离浏览器顶部的距离，就固定，反之就不固定
					div_height = $(this).height();
					$("ul").each(function(){
				        //取出ul下的第一个li
				        var li= $(this).children("li").first();
				        li.css("margin-top", div_height);
				    });
					if (pfTop - scroH < div_height) {
						$(this).css({"position":"fixed","top":0, "z-index":9});
						$(this).siblings('.pf').css({"position":"relative"}); 
					}
			    });
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
								'<div class="img-nolist">'+ '<div class="img-noreward">暂无奖励</div>'+'</div>' + 
								'</div>';
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
			    $(".modal-overlay").css('transition-duration', "0ms");
			    $(".modal-in").css("position", "absolute");
			    $(".modal-inner").css("background-color", "#FFF");
			    $(".modal-button-bold").css("background-color", "#FFF");
			});
			$$('.alert-text2').on('click', function () {
			    myApp.alert('邀请成功即可获得红包奖励' + '<br>' + '红包可在购买商品时使用');
			    $(".modal-overlay").css('transition-duration', "0ms");
			    $(".modal-in").css("position", "absolute");
			    $(".modal-inner").css("background-color", "#FFF");
			    $(".modal-button-bold").css("background-color", "#FFF");
			});
			$$('.alert-text3').on('click', function () {
			    myApp.alert('邀请成功即可获得现金奖励' + '<br>' + '现金可在购买商品时使用');
			    $(".modal-overlay").css('transition-duration', "0ms");
			    $(".modal-in").css("position", "absolute");
			    $(".modal-inner").css("background-color", "#FFF");
			    $(".modal-button-bold").css("background-color", "#FFF");
			});
        },
		
		share_spread : function() {
			var info = {
    			'url' : window.location.href
    		};
			var url = $('input[name="spread_url"]').val();
        	if (url == undefined) {
        		return false;
        	}
        	var desc = $('textarea[name="invite_template"]').val();
        	wechat_spread(url, info, title, link, image, desc);
		},
	};
	
	function wechat_spread(url, info, title, link, image, desc) {
    	$.post(url, info, function(response){
    		var data = response.data;
    		wx.config({
    			debug: false,
    			appId: data.appId,
    			timestamp: data.timestamp,
    			nonceStr: data.nonceStr,
    			signature: data.signature,
    			jsApiList: [
    				'checkJsApi',
    				'onMenuShareTimeline',
    				'onMenuShareAppMessage',
    				'onMenuShareAppMessage',
    				'hideOptionMenu',
    			]
    		});
    		wx.ready(function () {
    			//分享到朋友圈
    			wx.onMenuShareTimeline({
    		        title: title, 					// 分享标题【必填】
    		        link: link, 					// 分享链接【必填】
    		        imgUrl: image, 					// 分享图标【必填】
    		        success: function () { 
    		            // 用户确认分享后执行的回调函数
    		        },
    		        cancel: function () { 
    		            // 用户取消分享后执行的回调函数
    		        }
    		    });

    			//分享给朋友
    		    wx.onMenuShareAppMessage({
    		        title: title, 					// 分享标题【必填】
    		        desc: desc,	 					// 分享描述【必填】
    		        link: link, 					// 分享链接【必填】
    		        imgUrl: image, 					// 分享图标【必填】
    		        type: 'link', 					// 分享类型,music、video或link，不填默认为link【必填】
    		        dataUrl: '', 					// 如果type是music或video，则要提供数据链接，默认为空
    		        success: function () { 
    		            // 用户确认分享后执行的回调函数
    		        },
    		        cancel: function () { 
    		            // 用户取消分享后执行的回调函数
    		        }
    		    });

    		    //分享到QQ
    		    wx.onMenuShareQQ({
    		        title: title, 					// 分享标题
    		        desc: desc, 					// 分享描述
    		        link: link, 					// 分享链接
    		        imgUrl: image, 					// 分享图标
    		        success: function () { 
    		           // 用户确认分享后执行的回调函数
    		        },
    		        cancel: function () { 
    		           // 用户取消分享后执行的回调函数
    		        }
    		    });
    		});	
    	});
    };
    
})(ecjia, jQuery);

//end