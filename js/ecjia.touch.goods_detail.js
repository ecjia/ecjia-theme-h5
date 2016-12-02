/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.touch.goods_detail = {
		init : function(){
			ecjia.touch.goods_detail.change();
			ecjia.touch.goods_detail.promote_time();
			ecjia.touch.goods_detail.goods_img();
			ecjia.touch.category.add_tocart();
			ecjia.touch.category.remove_tocart();
			ecjia.touch.category.toggle_cart();
		},
		change: function() {
			$('.goods-p').on('click', function (e) {
				var id = $(this).attr('data-type');
				if (id == 1) {
					$('.p1').show();
					$('.p2').hide();
					$('#goods-info-one').show();
					$('#goods-info-two').hide();
				} else {
					$('.p2').show();
					$('.p1').hide();
					$('#goods-info-two').show();
					$('#goods-info-one').hide();
				}
			});
			//购物车按钮
			$('.add-cart-a').on('click', function (e) {
				$('.ecjia-goods-plus-box').show();
				$('.add-cart-a').hide();
			});
        },
        promote_time : function() {
        	var serverTime = Math.round(new Date().getTime()/1000) * 1000; //服务器时间，毫秒数 
        	var dateTime = new Date(); 
        	var difference = dateTime.getTime() - serverTime; //客户端与服务器时间偏移量 
        	var InterValObj;
        	clearInterval(InterValObj);
        	
        	InterValObj = setInterval(function(){ 
        		$(".promote-time").each(function(){ 
        			var obj = $(this); 
        			var endTime = new Date((parseInt(obj.attr('value')) + 8*3600) * 1000);
        			var nowTime = new Date(); 
        			var nMS=endTime.getTime() - nowTime.getTime() + difference; 
        			var myD=Math.floor(nMS/(1000 * 60 * 60 * 24)); //天 
        			var myH=Math.floor(nMS/(1000*60*60)) % 24; //小时 
        			var myM=Math.floor(nMS/(1000*60)) % 60; //分钟 
        			var myS=Math.floor(nMS/1000) % 60; //秒 
    	    
        			var type = obj.attr('data-type');
        			var hh = checkTime(myH);
        			var mm = checkTime(myM);
        			var ss = checkTime(myS);
    	    
        			if(myD>= 0){ 
        				if (type == 1) {
        					msg = '距结束';
        					var str = msg + myD + '天 &nbsp;&nbsp;<span class="end-time">'+ hh +'</span> : <span class="end-time">' + mm + '</span> : <span class="end-time">' + ss + '</span>';
        				} else {
        					msg = '剩余';
        					var str = msg + myD+"天&nbsp;"+hh+":"+mm+":"+ss; 
        				}
        			}else{ 
        				var str = "已结束！";  
        			} 
        			obj.html(str); 
        		}); 
        	}, 1000); //每隔1秒执行一次 
        },	
    	goods_img : function() {
			var swiper = new Swiper('.swiper-goods-img', {
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
			});
        },
	    add_tocart:function(){
            $("[data-toggle='add-to-cart']").off('click').on('click', function(ev){
            	var $this = $(this);
            	
            	if ($this.hasClass('a5v')) {
            		var val = parseInt($this.prev().html()) + 1;
            		$this.prev().html(val);
            		return;
            	} else {
            		var show = $this.parent('.box').children('label');
            		if (show.html() != '') {
            			var old_val = parseInt(show.html());
            			var val =  parseInt(show.html()) + 1;
            		} else {
            			var old_val = 0;
            			var val = 1;
            		}
	            	if (val > 0) {
	            		show.html(val).addClass('show').removeClass('hide');
	            		$this.parent('.box').children('.reduce').addClass('show').removeClass('hide');
	            	}
	            	
	            	var img = $this.parent().parent().find('img').attr('src');
	                var offset = $('.store-add-cart .a4x').offset(),
	                    flyer = $('<img class="u-flyer" src="'+ img  +'" alt="" style="width:50px;height:50px;">');
            	}
            	
            	var rec_id = $this.attr('rec_id');
            	ecjia.touch.category.update_cart(rec_id, val);
            	
                flyer.fly({
                    start: { // 开始时位置
                        left: ev.pageX - 40,
                        top:  ev.pageY - $('body').scrollTop() - 40
                    },
                    end: { // 结束时位置
                        left: offset.left,
                        top: offset.top - $('body').scrollTop() + 60,
                        width : 0,
                        height : 0,
                    },
                    vertex_Rtop : 50,
                    onEnd: function(){ // 回调方法
                        !$('.store-add-cart').hasClass('active') && $('.store-add-cart').addClass('active');
                    }
                });
            });
        },
        remove_tocart : function() {
            $("[data-toggle='remove-to-cart']").off('click').on('click', function(ev){
            	var $this = $(this);
            	if ($this.hasClass('a5u')) {
            		var val = parseInt($this.next().html()) - 1;
            		if (val == 0) {
            			$this.parent().remove();
            			if ($('.minicart-goods-list').children('li').length == 0) {
            				 $('.store-add-cart').removeClass('active');
            				 $('.store-add-cart').children('.a4x').removeClass('light').addClass('disabled').children('.a4y').remove();
            				 $('.store-add-cart').children('.a4z').children('div').addClass('a50').html('购物车是空的');
            				 $('.store-add-cart').children('.a51').addClass('disabled');
            				 ecjia.touch.category.hide_cart();
            			}
            		} else {
            			$this.next().html(val);
            		}
            		return;
            	} else {
            		var show = $this.parent('.box').children('label');
                	var val =  parseInt(show.html()) - 1;
                	if (val == 0) {
                		show.html(val).removeClass('show').addClass('hide');
                		$this.parent('.box').children('.reduce').removeClass('show').addClass('hide');
                	} else {
                		show.html(val);
                	}
            	}
            	var rec_id = $this.attr('rec_id');
            	ecjia.touch.category.update_cart(rec_id, val);
            });
        },
        toggle_cart : function() {
        	$('.show_cart').off('click').on('click', function(e){
        		e.preventDefault();
        		if ($(this).hasClass('disabled')) {
        			return false;
        		}
        		var bool = $('.store-add-cart').find('.a4x').attr('show');
        		if (bool) {
        			ecjia.touch.category.show_cart();
        		} else {
        			ecjia.touch.category.hide_cart();
        		}
        	});
        	
        	$('.a53').on('click', function(e){
        		e.preventDefault();
        		ecjia.touch.category.hide_cart();
        	});
        }, 
        show_cart : function() {
        	var height = -($('.store-add-cart').find('.minicart-content').height()) + 'px';
			$('.show_cart').css('transform', 'translateY('+ height +')');
			$('.store-add-cart').find('.a4x').removeAttr('show');
			$('.store-add-cart').find('.a4z').css('transform', 'translateX(-60px)');
    		$('.store-add-cart').find('.a53').css('display', 'block');
    		$('.store-add-cart').find('.minicart-content').css('transform', 'translateY(-100%)');	
        },
        hide_cart : function() {
        	$('.show_cart').css('transform', 'translateY(0px)');
			$('.store-add-cart').find('.a4x').attr('show', true);
			$('.store-add-cart').find('.a4z').css('transform', 'translateX(0px)');
    		$('.store-add-cart').find('.a53').css('display', 'none');
    		$('.store-add-cart').find('.minicart-content').css('transform', 'translateY(0px)');	
        },
        update_cart : function(rec_id, val) {
        	var url = $('input[name="update_cart_url"]').val();
        	var store_id = $('input[name="store_id"]').val();
        	
        	var info = {
        		'val' 		: val,
        		'rec_id' 	: rec_id,
        		'store_id' 	: store_id
        	};
        	//更新购物车中商品 数量+1
            $.post(url, info, function(data){});
        },
	};
	
	function checkTime(i) {    
		if (i < 10) {    
			i = "0" + i;    
		}    
		return i;    
    }

})(ecjia, jQuery);
