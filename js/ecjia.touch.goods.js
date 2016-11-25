/**
 * 后台综合js文件
 */
 ;(function(ecjia, $) {


	ecjia.touch.category = {
		init : function(){
			ecjia.touch.category.openSelection();
			ecjia.touch.category.selectionValue();
			ecjia.touch.category.clear_filter();
			ecjia.touch.category.goods_show();
			ecjia.touch.category.add_tocart();
		},

        add_tocart:function(){
            $("[data-toggle='add-to-cart']").on('click',function(ev){
                var offset = $('.icon-gouwuche').offset(),
                    flyer = $('<img class="u-flyer" src="http://cityo2o.ecjia.com/content/uploads/images/201603/goods_img/350_G_1459301046358.jpg" alt="">');
                flyer.fly({
                    start: {
                        left: ev.pageX,
                        top:  ev.pageY - $('body').scrollTop()
                    },
                    end: {
                        left: offset.left,
                        top: offset.top - $('body').scrollTop(),
                        width : 0,
                        height : 0,
                    }
                });
            })
        },

		openSelection : function() {
			/*商品列表页面点击显示筛选*/
			$('[data-toggle="openSelection"]').on('click', function(e){
				e.preventDefault();
				$(".goods-filter-box").toggleClass("show");
			});
			/*商品列表页面点击隐藏筛选*/
			$('[data-toggle="closeSelection"]').on('click', function(e){
				e.preventDefault();
				if ($(".goods-filter-box").hasClass("show")) {
					$(".goods-filter-box").removeClass("show");
				} else {
					$(".goods-filter-box").addClass("show");
				}
			});
		},

		/*筛选的属性下拉*/
		selectionValue : function() {
			$('.goods-filter .title').on('click', function(e){
				e.preventDefault();
				var _find = $(this).find(".icon-jiantou-bottom");
				var _next = $(this).next("ul");
				if (_find.hasClass('down')) {
					_find.removeClass("down");
					_next.removeClass("show");
				} else {
					_find.addClass("down");
					_next.addClass("show");
				}
			});

			/*商品列表页面点击隐藏下拉*/
			$('.goods-filter .goods-filter-box-content .goods-filter-box-listtype ul li a').on('click', function(e){
				e.preventDefault();
				var click_id = $(this).parent("li").parent("ul").prev(".title").attr("id");
				var str=$(this).attr("value");
				if(click_id == 'filter_brand'){
					$(".brandname").val(str);
				}else{
					var res;
					res=str.split("|");
					$("input[name='price_min']").val(res[0]);
					$("input[name='price_max']").val(res[1]);
				}
				$(this).parent("li").parent("ul").prev(".title").children(".range").text($(this).text());
				$(this).parent("li").parent("ul").removeClass("show");
				$(this).parent("li").parent("ul").prev(".title").children("i").removeClass("down");
			});
			$(".goods-filter .goods-filter-box-content .btns .btn-default").on("click",function(e){
				e.preventDefault();
				$(".goods-filter .goods-filter-box-content .goods-filter-box-listtype .title").each(function(i){
					$(this).children(".range").text("全部");
				});
			});
		},

		clear_filter : function() {
			$('[data-toggle="clear_filter"]').on('click', function(e){
				e.preventDefault();
				$("input[name='price_min']").val('');
				$("input[name='price_max']").val('');
				$("input[name='brand']").val('');
				$(".touchweb-com_listType .range").text("全部");
				$(".touchweb-com_listType input").each(function() {
					if($(this).attr('class') != 'cat'){
						$(this).val("");
					}
				});
			});
		},

		goods_show : function() {
			$('.view-more').on('click', function(e){
				e.preventDefault();
				var $this = $(this);

				if ($this.hasClass('retract')) {
					$this.parent().siblings('.single_store').children().find('.goods-hide-list').hide();
				} else {
					$this.parent().siblings('.single_store').children().find('.goods-hide-list').fadeIn("slow");
				}
				$this.addClass('hide').siblings('.goods-info').removeClass('hide');
			});

			$('.category_left li').on('click', function(){
				$('.ecjia-category-list').removeClass('show');
				var $this = $(this)
					cat_id = $this.children('a').attr('data-val');
				$this.addClass('active').siblings('li').removeClass('active');
				$('#category_' + cat_id).removeClass('hide').siblings('.ecjia-category-list').addClass('hide');
			});
		}
	};

	ecjia.touch.comment = {
		init : function(){
			ecjia.touch.comment.level_change();
		},

		level_change : function(){
			$('input[name="level-hide"]').val('');
			$('input[name="email"]').val('');
			$('textarea').val('');
			$('.comment-level span').on('mouseover', function(){
				var $this = $(this),
					level = $(this).attr('data-level'),
					hide_level = $('input[name="level-hide"]');
				$this.parent('span').attr('class', 'comment-level rating rating'+ level);
				$this.on('click',function(){
					hide_level.val($this.attr('data-level'));
				});
			});
		}
	};

 	ecjia.touch.goods = {
 		init : function() {
 			ecjia.touch.goods.collect_click();
 			ecjia.touch.goods.open_options();
 			ecjia.touch.goods.open_booking();
 			ecjia.touch.goods.addToCart_click();
 			ecjia.touch.goods.changeprice_click();
 			ecjia.touch.goods.changeprice_once();
 			ecjia.touch.goods.goods_img();
 			ecjia.touch.goods.choose_option();
 			ecjia.touch.goods.area_change();
 			ecjia.touch.goods.address_change();
 			ecjia.touch.goods.warehouse();
 		},

	area_change : function() {
	$('[data-toggle="region_change"]').on('change', function() {
			var $this		= $(this),
				id 			= $this.attr("id"),
				url 		= $this.attr("data-url"),
				type    	= $this.attr("data-type"),
				target 		= $this.attr("data-target"),
				check 		= $this.attr("data-city"),
				parent 		= $this.val();
				if($("#selCountries").val()== 0 ){
					$("#selProvinces").children("option:gt(0)").remove();
					$("#selCities").children("option:gt(0)").remove();
					$("#selDistricts").children("option:gt(0)").remove();
					$("#selDistricts").hide();
				}else{
					if( id == "selCountries"){
						$("#selDistricts").hide();
					}else if( id == "selProvinces"){
						$("#selDistricts").hide();
						if($("#selProvinces").val()== 0 ){
							$("#selCities").children("option:gt(0)").remove();
						}
					}else if( id == "selCities"){
						$("#selDistricts").show();
						if($("#selCities").val()== 0 ){
							$("#selDistricts").children("option:gt(0)").remove();
						}
					}
					$.get(url,
					{'type':type ,'target':target,'parent':parent, 'checked': check},
					function(data){
						if (data.state == 'success') {
		 					var opt  =	'';
		 					if(data.regions){
		 						for (var i= 0 ; i<data.regions.length; i ++){
									if(data.check){
										if (data.regions[i].region_id == data.check ){
											opt +=	'<option value="'+data.regions[i].region_id+'" selected="selected">'+data.regions[i].region_name+'</option>';
										}else{
											opt +=	'<option value="'+data.regions[i].region_id+'">'+data.regions[i].region_name+'</option>';
										}
									}else{
										if (i == 0){
											opt +=	'<option value="'+data.regions[i].region_id+'" selected="selected">'+data.regions[i].region_name+'</option>';
										}else{
											opt +=	'<option value="'+data.regions[i].region_id+'">'+data.regions[i].region_name+'</option>';
										}
									}
			 					}
			 					if( id == "selCountries"){
			 						$("#selProvinces").children("option:gt(0)").remove();
			 						$("#selProvinces").children("option").after(opt);
			 					}else if( id == "selProvinces"){
			 						$("#selCities").children("option:gt(0)").remove();
			 						$("#selCities").children("option").after(opt);
			 						$('[data-target="selDistricts"][id="selCities"]').change();
			 					}else if( id == "selCities"){
			 						$("#selDistricts").children("option:gt(0)").remove();
			 						$("#selDistricts").children("option").after(opt);
			 					}
		 					}
		 				} else {
		 					ecjia.touch.showmessage(data);
		 				}
				}, 'json');
				}

		})
},

		address_change : function(){
			$('select[id="selCities"]').on('change', function(){
				$('select[id="selDistricts"]').change();
			});
			$('select[id="selDistricts"]').on('change', function(){
				$('[data-toggle="warehouse"]').change();
			});
			$('[data-toggle="region_change"][id="selProvinces"]').change();
		},

 		warehouse : function(){
 			$('[data-toggle="warehouse"]').on('change', function(){
 				var $this	= $(this),
 				url		= $this.attr('data-url'),
 				id		= $this.attr('data-id'),
				house 		= $('select[name="region_id"]').val(),
				province 	= $('select[id="selProvinces"]').val();
				if (!url || !id) { alert('缺少必要参数');return;}
 				$.get(url,
					{'id':id ,'house':house,'region_id':province},
					function(data){
						if (data.state == 'success') {
							$('#ECS_GOODS_AMOUNT').html(data.goods.goods_price);
							$('.goods-promote-price').html(data.goods.goods_price);

							$('#shop_goods_number').html(data.goods.goods_number);
							if(data.goods.goods_number > 0){
								$('.goods_show').hide();
								$('.goodsnumber-show-btn').show();
								$('.goodsnumber-none-btn').hide();
							}else{
								$('.goods_show').show();
								$('.goodsnumber-none-btn').show();
								$('.goodsnumber-show-btn').hide();
							}
						}
					},'json');
 			});
 		},

 		collect_click : function(){
 			$('[data-toggle="collect"]').on('click', function(){
 				var $this	= $(this),
 				url		= $this.attr('data-url'),
 				id		= $this.attr('data-id'),
 				act 	= $this.hasClass('active');
 				if (!url || !id) { alert('缺少必要参数，收藏失败');return;}
 				ecjia.touch.goods.collect({thisobj : $this, url : url, id : id, act : act});
 			});
 		},

 		collect : function(options) {
 			$.get(options.url, {
 				id: options.id
 			}, function(data) {
 				if (data.state == 'success') {
                    options.thisobj.toggleClass('active');
                    var num = $('.goods-like span').text();
                    num = parseInt(num);
                    if(options.act){
                    	num = parseInt(num) - 1;
                    }else{
                    	num = parseInt(num) + 1;
                    }
                    $('.goods-like span').text(num+"个");
 				}
 				ecjia.touch.showmessage(data);
 			}, 'json');
 		},

 		open_options : function() {
 			var $options = $('.alert-goods-attribute');

 			$('[data-toggle="openOptions"]').on('click', function(e){
 				e.preventDefault();
 				$options.addClass('active');
 				$('.goods-option-conr label.option-radio').each(function(i) {
 					if ($(this).prev('input').is(':checked')) {
 						$(this).addClass('active');
 					}
 				});
 				$('.goods-option-conr label.option-checkbox').removeClass('active').prev('input').prop('checked', false);
 				$('[data-toggle="addToCart"]').attr('data-pjaxurl',$(this).attr('data-pjaxurl'));
 				var alt = $(this).attr('data-message');
 				alt || $('[data-toggle="addToCart"]').attr('data-message', '1');
 			});

 			$options.find('.hd i').on('click', function() {
				$options.removeClass('active');
			});
 		},

 		open_booking : function() {
	 		$('[data-toggle="booking"]').on('click', function(e){
	 			e.preventDefault();
	 			var pjaxurl = $(this).attr('data-pjaxurl');
				if(window.confirm("商品库存不足\n是否添加缺货登记？", "标题")) {
					ecjia.pjax(pjaxurl);
				}
	 		});
	 	},

 		addToCart_click : function(){
 			$('[data-toggle="addToCart"]').on('click', function(e){
 				e.preventDefault();
 				var $this 		= $(this),
					options		= {
						$form		: $('#ECS_FORMBUY'),
						id			: $this.attr('data-id'),
						message		: $this.attr('data-message'),
						url			: $this.attr('data-url'),
						pjaxurl		: $this.attr('data-pjaxurl'),
						parentid	: $this.attr('data-parentid'),
						number		: $('input[name="number"]').val(),
						quick		: 0,
						alt 		: $this.attr('data-message')
					};
 				if (!options.url || !options.id) { alert('缺少必要参数，添加购物车失败');return;}
				ecjia.touch.goods.addToCart(options);
 			});
 		},

 		addToCart : function(options) {
 			var $form		= options.$form,
 				quick		= options.quick,
				number		= options.number,
				id			= options.id,
				message		= options.message,
				url			= options.url,
				pjaxurl		= options.pjaxurl,
				parentid	= options.parentid,
				alt 		= options.alt,
				spec_arr	= [];
 			// 检查是否有商品规格
 			if ($form.length) {
 				var j = 0;
 				$form.find('[name^=spec_]').each(function(i){
 					var $this = $(this),
 						type  = $this.attr('type');
 					if (type == 'checkbox') {
 						if ($this.is(':checked')) {
 							spec_arr[j] = $this.val();
 							j++;
 						}
 					} else if( (type == 'radio' && $this.is(':checked')) || $this.is('select')) {
 						spec_arr[j] = $this.val();
						j++;
 					}
 				});
				if($('[name="number"]').length) number = $('[name="number"]').val();
 				quick = 1;
 			}

 			var goods = {
	 			quick		: quick,
	 			spec		: spec_arr,
	 			goods_id	: id,
	 			number		: number,
	 			parent		: parentid
 			};
 			$.post(url, {
 				goods: goods
 			}, function(data) {
 				//TODO:加入购物车的错误处理未完成
 				if(data.state == 'success') {
 					if(alt){
 						if(window.confirm("商品已成功加入购物车\n是否去购物车查看？", "标题")) {
 							ecjia.pjax(pjaxurl);
	 					}else{
	 						ecjia.pjax(data.link);
	 					}
 					}else{
 						ecjia.pjax(data.pjaxurl);
 					}
 				}else{
 					alert(data.message);
 				}
 			}, 'json');
 		},

 		changeprice_click : function() {
 			$('[data-toggle="changeprice"]').on('click', function() {
 				var $this	= $(this),
 					option  = $this.attr('data-option'),
 					number 	= $('#goods_number').val(),
 					options = {
 						id 	: $this.attr('data-id'),
 						url : $this.attr('data-url')
 					};
				if(option =='del'){
					if(number == 1){
						number = 1;
						$('#goods_number').val(number);
					}else{
						number = parseInt(number) - 1;
						$('#goods_number').val(number);
					}
				}else{
					number = parseInt(number) + 1;
					$('#goods_number').val(number);
				}
				ecjia.touch.goods._change_price(options,number);
 			});
 			$('[data-toggle="changeprice_change"]').on('change', function() {
 				var $this	= $(this),
 					number 	= $('#goods_number').val(),
 					options = {
 						id 	: $this.attr('data-id'),
 						url : $this.attr('data-url')
 					};
				ecjia.touch.goods._change_price(options,number);
 			});
 			$('[data-toggle="changeprice_blur"]').on('blur', function() {
 				var $this	= $(this),
 					number 	= $('#goods_number').val(),
 					options = {
 						id 	: $this.attr('data-id'),
 						url : $this.attr('data-url')
 					};
				if(number<=0){
	 				number 	= 1;
	 				$('#goods_number').val(1);
	 			}
				ecjia.touch.goods._change_price(options,number);
 			});
 			$('[data-toggle="changeprice_parts"]').on('click', function() {
 				var $this	= $(this),
 					number 	= $('#goods_number').val(),
 					options = {
 						id 	: $this.attr('data-id'),
 						url : $this.attr('data-url')
 					};
				ecjia.touch.goods._change_price(options,number);
 			});
 		},

 		changeprice_once : function(){
			var $this	= $('[data-toggle="changeprice"]'),
				id 		= $this.attr('data-id'),
				url 	= $this.attr('data-url'),
				options = $this.attr('data-option'),
				number 	= $('#goods_number').val();
			if(options =='del'){
				if(number == 1){
					number = 1;
					$('#goods_number').val(number);
				}else{
					number = parseInt(number) - 1;
					$('#goods_number').val(number);
				}
			}else{
				number = parseInt(number) + 1;
				$('#goods_number').val(number);
			}
			 $.get(url,
			 	{'id':id ,'attr':'','number':number },
			 	function(data){
		   		$('#ECS_GOODS_AMOUNT').html(data.message);
			 }, 'json');
 		},

 		_change_price : function(options,number){
 			var val   = '';
 			for(var i=0 ;i<$('[data-toggle="changeprice_change"]').length;i++){
					val += $('[data-toggle="changeprice_change"]').eq(i).val()+',';
				}
			for(var i=0 ;i<$('[data-toggle="changeprice_parts"]').length;i++){
					if($('[data-toggle="changeprice_parts"]').eq(i).is(":checked")){
						val = val+","+$('[data-toggle="changeprice_parts"]').eq(i).val();
					}else{
						val = val;
					}
				}
			$.get(options.url,
				{'id':options.id ,'attr':val,'number':number },
				function(data){
					$('#ECS_GOODS_AMOUNT').html(data.message);
			}, 'json');

 		},

 		goods_img : function() {
            var startX, moveEndX,
                next_has_class,
                obj_nextmsg = $('.scroller-slidenext .slidenext-msg'),
                obj_nexticon = $('.scroller-slidenext .slidenext-icon');
			var swiper = new Swiper('.goods-imgshow', {
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
                onTouchStart : function(s,e) {
                    startX = e.touches && e.touches[0].pageX ? e.touches[0].pageX : e.pageX;
                },
                onTouchMove : function(s,e) {
                    if (s.isEnd) {
                        moveEndX = e.touches && e.touches[0].pageX ? e.touches[0].pageX : e.pageX;
                        next_has_class = obj_nexticon.hasClass("active");

                        if (moveEndX - startX < -80) {
                            !next_has_class && obj_nexticon.addClass("active");
                            !next_has_class && obj_nextmsg.text('释放查看详情');
                        } else {
                            next_has_class && obj_nexticon.removeClass("active");
                            next_has_class && obj_nextmsg.text('滑动查看详情');
                        }
                    }
                },
                onTouchEnd : function(s,e) {
                    if (s.isEnd) {
                        moveEndX = e.changedTouches && e.changedTouches[0].pageX ? e.changedTouches[0].pageX : e.pageX;
                        if (moveEndX - startX < -80) {
                            console.log($('.goods_info'));
                            $('.goods_info').trigger('click');
                        }
                    }
                }
			});
		},

        goods_link : function() {
            var swiper = new Swiper('.goods-link-likeshow', {
                slidesPerView: 2,
                paginationClickable: true,
                spaceBetween: 30,
                freeMode: true,
				//无限滚动
				loop: 1
            });
        },

		choose_option : function() {
			$('.goods-option-conr label').on('click', function(e) {
				var $this = $(this);
				if ($this.hasClass('option-checkbox')) {
					if ($this.prev('input').is(':checked')) {
						$this.removeClass('active');
					} else {
						$this.addClass('active');
					}
				} else {
					$this.addClass('active').siblings('label').removeClass('active');
				}
			});
		},

		tmp_good_info : {},

		add_quick : function() {
			$('.addToCart_quick').on('click', function(e) {
				var $this = $(this),
				url = $this.attr('data-url'),
				id = $this.attr('data-id'),
				parent = $this.attr('data-parent');
				ecjia.touch.goods.tmp_good_info.img = $this.parents('li').find('.ecjiaf-fl img').attr('src');
				ecjia.touch.goods.tmp_good_info.name = $this.parents('li').find('.goods-fitting p').eq(0).find('a').text();
				ecjia.touch.goods.tmp_good_info.price = $this.parents('li').find('.goods-fitting p').eq(1).find('span').eq(1).text();
				ecjia.touch.goods.tmp_good_info.id = $this.attr('data-id');
				ecjia.touch.goods.tmp_good_info.parentid = $this.attr('data-parent') || 0;
	 			$.post(url, {goods : {goods_id: id, parent: parent, number: 1, spec: {}}}, function(data) {
	 				//TODO:加入购物车的错误处理未完成
	 				if(data.state == 'error' && data.error == 6) {
	 					ecjia.touch.goods.openSpeDiv(data.message, data.goods_id, data.parent);
	 				} else {
						ecjia.touch.showmessage(data);
	 				}
	 			}, 'json');
 			});
 		},

 		openSpeDiv : function(message, goods_id, parent) {
 				// 展示商品信息
				$('.alert-goods-attribute > .hd').html('<img src="'+ecjia.touch.goods.tmp_good_info.img+'" alt="'+ecjia.touch.goods.tmp_good_info.name+'"/><i class="glyphicon glyphicon-remove"></i><p class="alert-goods-name">商品名称'+ecjia.touch.goods.tmp_good_info.name+'</p><p class="alert-price"><b id="ECS_GOODS_AMOUNT">'+ecjia.touch.goods.tmp_good_info.price+'</b></p>');

				// 确认按钮属性
				$('.alert-goods-attribute form .ft [data-toggle="addToCart"]').attr({'data-parentid': ecjia.touch.goods.tmp_good_info.parentid, 'data-id':ecjia.touch.goods.tmp_good_info.id});

				// 展示商品属性
				$('.alert-goods-attribute form .bd').html('');
				for (var spec = 0; spec < message.length; spec++)
				{
					var new_div = $('<div class="goods-option-con"><div class="goods-option-conr"></div>'),
					new_div_con = new_div.find('.goods-option-conr');
					// newDiv.innerHTML += '<hr style="color: #EBEBED; height:1px;"><h6 style="text-align:left; background:#ffffff; margin-left:15px;">' +  message[spec]['name'] + '</h6>';
					new_div_con.before('<span class="spec-name">' +  message[spec]['name'] + '</span>');

					if (message[spec]['attr_type'] == 1) {
						for (var val_arr = 0; val_arr < message[spec]['values'].length; val_arr++) {
							if (val_arr == 0) {
								new_div_con.append('<label class="option-radio active"><input name="spec_' + message[spec]['attr_id'] + '" type="radio" checked="checked" value="' + message[spec]['values'][val_arr]['id'] + '" />' + message[spec]['values'][val_arr]['label'] + '[' + message[spec]['values'][val_arr]['format_price'] + ']</label>');
							} else {
								new_div_con.append('<label class="option-radio"><input name="spec_' + message[spec]['attr_id'] + '" type="radio" value="' + message[spec]['values'][val_arr]['id'] + '" />' + message[spec]['values'][val_arr]['label'] + '[' + message[spec]['values'][val_arr]['format_price'] + ']</label>');
							}
						}
						new_div_con.append("<input type='hidden' name='spec_list' value='" + val_arr + "' />");
					} else {
						for (var val_arr = 0; val_arr < message[spec]['values'].length; val_arr++) {
							new_div_con.append('<label class="option-checkbox"><input name="spec_' + message[spec]['attr_id'] + '" type="checkbox" value="' + message[spec]['values'][val_arr]['id'] + '" /><i class="glyphicon glyphicon-ok"></i>' + message[spec]['values'][val_arr]['label'] + '[' + message[spec]['values'][val_arr]['format_price'] + ']</label>');
						}
						new_div_con.append("<input type='hidden' name='spec_list' value='" + val_arr + "' />");
					}
					$('.alert-goods-attribute form .bd').append(new_div);
				}

 			$('.alert-goods-attribute').css('display','block');

 			// 关闭按钮方法
 			$('.glyphicon-remove').on('click', function() {
 				$('.alert-goods-attribute').css('display','none');
 			});

 			// 属性选择方法
 			$('.alert-goods-attribute form .bd label').on('click', function(){
 				var $this = $(this);
 				$('.alert-goods-attribute form .goods-option-conr label.option-radio').each(function(i) {
 					if ($this.find('input').is(':checked')) {
 						$this.addClass('active');
 					} else {
 						$this.removeClass('active');
 					}
 				});

 				if ($this.hasClass('option-checkbox')) {
 					if ($this.find('input').is(':checked')) {
 						$this.removeClass('active');
 					} else {
 						$this.addClass('active');
 					}
 				} else {
 					$this.addClass('active').siblings('label').removeClass('active');
 				}
 			});

 			// 确认按钮提交事件
 			$('.alert-goods-attribute form .ft [data-toggle="addToCart"]').on('click', function(e){
 				e.preventDefault();
 				var $this 		= $(this),
					options		= {
						$form		: $('.alert-goods-attribute form'),
						id			: $this.attr('data-id'),
						message		: $this.attr('data-message'),
						url			: $this.attr('data-url'),
						pjaxurl		: $this.attr('data-pjaxurl'),
						parentid	: $this.attr('data-parentid'),
						number		: 1,
						quick		: 1
					};
 				if (!options.url || !options.id) { alert('缺少必要参数，添加购物车失败');return;}
				ecjia.touch.goods.addToCart(options);
 			});

		}

 	};
	})(ecjia, jQuery);
