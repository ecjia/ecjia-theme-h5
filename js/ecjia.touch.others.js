/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.touch.index = {
		init : function(){
            this.init_swiper();
            this.change_index();
            this.swiper_promotion();
		},
        init_swiper : function() {
			var swiper = new Swiper('.swiper-touchIndex', {
				pagination: '.swiper-pagination',
				grabCursor: true,
				centeredSlides: true,
				coverflow: {
					rotate: 50,
					stretch: 0,
					depth: 100,
					modifier: 1,
					slideShadows : true
				},
				//无限滚动
				slidesPerView: 1,
				loop: true,
				//自动播放
				autoplay: 2500,
				autoplayDisableOnInteraction: false,
			});
        },
        swiper_promotion : function() {
			var swiper = new Swiper('.swiper-promotion', {
		        slidesPerView: 2.5,
		        paginationClickable: true,
		        spaceBetween: 30,
		        freeMode : true,
		        freeModeMomentumVelocityRatio : 5,
			});
        },

		close_bottom_banner : function() {
            $.cookie('hide_bottom_banner', 1);
			$('.bottom-banner').remove();
		},

		click_header : function(){
			$('.ecjia-header.ecjia-header-index').removeClass('active');
			$('.search-header.index-header').addClass('active');
			$('.search_fixed_mask').toggleClass('active');
			$("#keywordBox").val('').focus().click();
			$('.search-history').toggleClass('active');
			if($('.ecjia-app-download').length > 0){
				$('.ecjia-app-download').css('margin-top','3.5em');
			}else{
				$('.focus').css('margin-top','3.5em');
			}
		},

        change_index : function() {
            $('[data-toggle="change_index"]').on('click', function(){
                $('.ecjia-header.ecjia-header-index').addClass('active');
                $('.search-header.index-header').removeClass('active');
                $('.search_fixed_mask').toggleClass('active');
                $('.search-history').toggleClass('active');
                if($('.ecjia-app-download').length > 0){
                    $('.ecjia-app-download').css('margin-top','');
                }else{
                    $('.focus').css('margin-top','');
                }
            })
        }


	};
})(ecjia, jQuery);
