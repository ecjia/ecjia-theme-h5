/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.touch.goods_detail = {
		init : function(){
			ecjia.touch.goods_detail.change();
			ecjia.touch.goods_detail.promote_time();
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
	    add_tocart:function(){
            $("[data-toggle='add-to-cart']").on('click',function(ev){
            	var $this = $(this);
            	var show = $this.parent('.box').children('label');
            	var val =  parseInt(show.html()) + 1;
            	if (val > 0) {
            		show.html(val).addClass('show').removeClass('hide');
            		$this.parent('.box').children('.reduce').addClass('show').removeClass('hide');
            	}
            	
            	var img = $this.parent().parent().children('img').attr('src');
                var offset = $('.store-add-cart .a4x').offset(),
                    flyer = $('<img class="u-flyer" src="'+ img  +'" alt="" style="width:50px;height:50px;">');
                flyer.fly({
                    start: { // 开始时位置
                        left: ev.pageX - 40,
                        top:  ev.pageY - $('body').scrollTop() - 40
                    },
                    end: { // 结束时位置
                        left: offset.left + 15,
                        top: offset.top - $('body').scrollTop() + 30,
                        width : 0,
                        height : 0,
                    },
                    onEnd: function(){ // 回调方法
                        !$('.store-add-cart').hasClass('active') && $('.store-add-cart').addClass('active');
                    }
                });
            });
        },
        remove_tocart : function() {
            $("[data-toggle='remove-to-cart']").on('click', function(ev){
            	var $this = $(this);
            	var show = $this.parent('.box').children('label');
            	var val =  parseInt(show.html()) - 1;
            	if (val == 0) {
            		show.html(val).removeClass('show').addClass('hide');
            		$this.parent('.box').children('.reduce').removeClass('show').addClass('hide');
            	} else {
            		show.html(val);
            	}
            });
        },
        toggle_cart : function() {
        	$('.show_cart').on('click', function(e){
        		e.preventDefault();
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
        }    
	};
	
	function checkTime(i) {    
		if (i < 10) {    
			i = "0" + i;    
		}    
		return i;    
    }

})(ecjia, jQuery);
