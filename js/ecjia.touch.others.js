/**
 * 后台综合js文件
 */
;
(function(ecjia, $) {
	ecjia.touch.index = {
		init: function() {
			sessionStorage.removeItem('swiper');
			this.substr();
			this.init_swiper();
			this.change_index();
			this.swiper_promotion();
			this.promote_time();
			this.close_download();
			this.discover_swiper();
		},

		substr: function() {
			var str = $(".address-text").html();
			if (str) {
				str = str.length > 20 ? str.substring(0, 20) + '...' : str;
				var str = $(".address-text").html(str);
			}
		},

		init_swiper: function() {
			if ($.find('.ecjia-mod-cycleimage').length != 0) {
				var width = $('.ecjia-mod-cycleimage').find('.swiper-slide ').width();
				$('.ecjia-mod-cycleimage').find('.swiper-slide').css('height', width * 2 / 5 + 'px');
				$('.ecjia-mod-cycleimage').find('.swiper-slide').find('img').css('height', width * 2 / 5 + 'px');
			}
			if (sessionStorage.getItem("swiper") == 1) {
				return false;
			}
			var swiper = new Swiper('#swiper-touchIndex', {
				pagination: '.swiper-pagination',
				speed: 800,
				grabCursor: true,
				centeredSlides: true,
				coverflow: {
					rotate: 50,
					stretch: 0,
					depth: 100,
					modifier: 1,
					slideShadows: true
				},
				//无限滚动
				slidesPerView: 1,
				loop: true,
				//自动播放
				autoplay: 2500,
				autoplayDisableOnInteraction: false,
			});
			sessionStorage.setItem("swiper", 1);

			$('.ecjia-zx').off('click').on('click', function() {
				sessionStorage.removeItem('swiper');
			});
		},
		swiper_promotion: function() {
			var swiper = new Swiper('.swiper-promotion', {
				slidesPerView: 2.5,
				spaceBetween: 10,
				freeMode: true,
				freeModeMomentumVelocityRatio: 5,
			});
		},
		promote_time: function() {
			var serverTime = Math.round(new Date().getTime() / 1000) * 1000; //服务器时间，毫秒数 
			var dateTime = new Date();
			var difference = dateTime.getTime() - serverTime; //客户端与服务器时间偏移量 
			var InterValObj;
			clearInterval(InterValObj);

			InterValObj = setInterval(function() {
				$(".promote-time").each(function() {
					var obj = $(this);
					var endTime = new Date((parseInt(obj.attr('value')) + 8 * 3600) * 1000);
					var nowTime = new Date();
					var nMS = endTime.getTime() - nowTime.getTime() + difference;
					var myD = Math.floor(nMS / (1000 * 60 * 60 * 24)); //天 
					var myH = Math.floor(nMS / (1000 * 60 * 60)) % 24; //小时 
					var myM = Math.floor(nMS / (1000 * 60)) % 60; //分钟 
					var myS = Math.floor(nMS / 1000) % 60; //秒 

					var type = obj.attr('data-type');
					var hh = checkTime(myH);
					var mm = checkTime(myM);
					var ss = checkTime(myS);

					if (myD >= 0) {
						if (type == 1) {
							msg = '距离活动结束还有';
							var str = msg + myD + '天 &nbsp;&nbsp;<span class="end-time">' + hh + '</span> : <span class="end-time">' + mm + '</span> : <span class="end-time">' + ss + '</span>';
						} else {
							msg = '剩余';
							var str = msg + myD + "天&nbsp;" + hh + ":" + mm + ":" + ss;
						}
					} else {
						var str = "已结束！";
					}
					obj.html(str);
				});
			}, 1000); //每隔1秒执行一次 
		},

		close_bottom_banner: function() {
			$.cookie('hide_bottom_banner', 1, {
				expires: 7
			});
			$('.bottom-banner').remove();
		},

		click_header: function() {
			$('.ecjia-header.ecjia-header-index').removeClass('active');
			$('.search-header.index-header').addClass('active');
			$('.search_fixed_mask').toggleClass('active');
			$("#keywordBox").val('').focus().click();
			$('.search-history').toggleClass('active');
			if ($('.ecjia-app-download').length > 0) {
				$('.ecjia-app-download').css('margin-top', '3.5em');
			} else {
				$('.focus').css('margin-top', '3.5em');
			}
		},

		change_index: function() {
			$('[data-toggle="change_index"]').on('click', function() {
				$('.ecjia-header.ecjia-header-index').addClass('active');
				$('.search-header.index-header').removeClass('active');
				$('.search_fixed_mask').toggleClass('active');
				$('.search-history').toggleClass('active');
				if ($('.ecjia-app-download').length > 0) {
					$('.ecjia-app-download').css('margin-top', '');
				} else {
					$('.focus').css('margin-top', '');
				}
			})
		},
		close_download: function() {
			$('.close_tip').on('click', function() {
				$.cookie('close_download', true, {
					expires: 7
				});
				$('.ecjia-download').remove();
			})
		},
		
		//发现页顶部滚动图标
		discover_swiper: function() {
			var index = 0;
			if (sessionStorage.getItem("discover_swiper")) {
				index = sessionStorage.getItem("discover_swiper");
			}
			var swiper = new Swiper('#swiper-discover-icon', {
				slidesPerView: 5,
				paginationClickable: true,
				initialSlide: index,
				spaceBetween: 0,
			});
			
			$('#swiper-discover-icon .swiper-slide').find('a').off('click').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					url = $this.attr('href');
				var i = $("#swiper-discover-icon").find('.swiper-slide').index();
				sessionStorage.setItem("discover_swiper", i);
				ecjia.pjax(url);
			});
		},
	};

	function checkTime(i) {
		if (i < 10) {
			i = "0" + i;
		}
		return i;
	}
})(ecjia, jQuery);

//end