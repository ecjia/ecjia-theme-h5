/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.touch = {
		init : function() {
			ecjia.touch.setpjax();
			ecjia.touch.asynclist();
			ecjia.touch.ecjia_menu();
			ecjia.touch.region_change();
			ecjia.touch.selectbox();
			ecjia.touch.valid();
			ecjia.touch.toggle_collapse();
			ecjia.touch.close_banner();
			ecjia.touch.close_app_download();
		},

		/**
		 * 设置PJAX
		 */
		setpjax : function() {
			/* PJAX基础配置项 */
			ecjia.pjaxoption = {
				timeout: 10000,
				container: '.main-content', /* 内容替换的容器 */
				cache: false,  /* 是否使用缓存 */
				storage: false,  /* 是否使用本地存储 */
				titleSuffix: '.pjax' /* 标题后缀 */
			};

			/* ecjia.pjax */
			ecjia.extend({
				pjax : function(url, callback) {
					var option = $.extend( ecjia.pjaxoption , { url : url, callback : function(){if (typeof(callback) === 'function')callback();} } );
					$.pjax(option);
					delete ecjia.pjaxoption.url;
				}
			});
			/* pjax刷新当前页面 */
			ecjia.pjax.reload = function() {
				$.pjax.reload(ecjia.pjaxoption.container, ecjia.pjaxoption);
			};
			/* 移动pjax方法的调用，使用document元素委派pjax点击事件 */
			if ($.support.pjax) {
				$(document).on('click', 'a:not(.nopjax)', function(event) {
					$.pjax.click(event, ecjia.pjaxoption.container, ecjia.pjaxoption);
				});
			}
		},

		pjaxloadding : function() {
			//增加一个加载动画
            $('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
        },

		/**
		 * 展示信息，成功和失败。
		 */
		showmessage : function(options) {
			var defaults = {
				message		: false,												/* message 提示信息 */
				is_show		: true,												    /* message 提示信息 */
				state		: 'success',											/* state 信息状态 */
				links		: false,												/* links 链接对象 */
				close		: true,													/* close 是否可以关闭 */
				pjaxurl		: ''													/* pjax刷新页面后显示message的时候传递的pjaxURL参数 */
			};

			var options = $.extend({}, defaults, options);
			options.message && options.is_show && alert(options.message);
			options.pjaxurl && ecjia.pjax(options.pjaxurl);
		},

		/**
		 * 加载列表的触发器方法
		 */
		asynclist : function() {
			if ($('[data-toggle="asynclist"]').length) {
				var $this = $('[data-toggle="asynclist"]');
					options = {
						areaSelect	: '[data-toggle="asynclist"]',
						url			: $this.attr('data-url'),
						size		: $this.attr('data-size'),
						page		: $this.attr('data-page'),
					};
				ecjia.touch.more(options);
				var loaderimgurl = $this.attr('data-loadimg') || false;
				if (loaderimgurl) {
					$loader = $('<a class="load-list" href="javascript:;"><img src="'+loaderimgurl+'" /></a>');
					$this.after($loader);
				}
			}
		},

		/**
		 * 加载列表方法
		 */
		more : function(options) {
			$(window).scrollTop(0);
			var defaults = {
				url			: false,					//url 			请求地址
				page		: 1,						//page			分页
				size		: 10,						//size			分页数量
				areaSelect	: '#J_ItemList',			//areaSelect	模块select
				scroll		: true,						//scroll		滑动加载
				offset		: 100,						//offset		滑动预留
				trigger		: '.load-list',				//trigger		点击的触发器
				lock		: false,					//lock			锁
			},
				options		= $.extend({}, defaults, options),
				scroll_list = function(){
					if (!options.lock && ($(window).scrollTop() > $(document).height() - $(window).height() - options.offset)) {
						options.lock = true;
						ecjia.touch.load_list(options);
						options.page++;
					}
				};
			scroll_list();
			if (options.scroll) {
				window.onscroll = function(){
					scroll_list();
				};
			} else {
				var add_more_btn = '<button id="load_more_btn" class="btn btn-default btn-lg">点击加载更多</button>';
				$('[data-flag="add_load_more_btn"]').after(add_more_btn);
				$("#load_more_btn").on("click",function(){
					scroll_list();
					$(this).attr("data-scroll","false");
				});
			}
		},

		more_callback : function() {ecjia.touch.delete_list_click();},

		/**
		 * 数据操作方法
		 */
		load_list : function(options) {
			if(!options.url)return console.log('批量操作缺少参数！');
			$(options.trigger).show();
			$.get(options.url, {
				page : options.page,
				size : options.size
			}, function(data){
				$(options.areaSelect).append(data.list);
				options.lock = data.is_last;
				$(options.trigger).hide();
				if(data.is_last == 1){
					$("#load_more_btn").remove();
				}
				ecjia.touch.more_callback();
			});
		},

		delete_list_click: function(){
			$(document).off('click', '[data-toggle="del_list"]');
			$(document).on('click', '[data-toggle="del_list"]', function(e){
                e.preventDefault();
				var $this 	= $(this),
					id 		= $this.attr('data-id'),
					msg 	= $this.attr('data-msg') ? $this.attr('data-msg') : '您确定要删除此条信息吗？',
					url 	= $this.attr('data-url');
				if(id && url){
					if(confirm(msg)) ecjia.touch.delete_list({id : id, url : url});
				}
			});
		},

		delete_list: function (options){
			$.get(options.url, {
				id: options.id
			}, function(data) {
				ecjia.touch.showmessage(data);
			}, 'json');
		},

		// load_goods : function() {
		// 	var $list = $('#J_ItemList'),
		// 		url = $list.attr('data-url');
		// 	!$list.length && console.log('未设置显示区域');
		// 	!url && console.log('未设置data-url');
		// 	!($list.length && url) && console.log('不执行more方法');
		// 	$list.length && url && $list.more({'address': url, 'spinner_code': '<div style="text-align:center; margin:10px;"><img src="./loadimg.gif" /></div>'});
		// },

		/* 下方相关商品滑动块的JS */
		touch_slide : function() {
			TouchSlide({
				slideCell:"#picScroll",
				titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
				autoPage:"true", //自动分页
				pnLoop:"false", // 前后按钮不循环
				switchLoad:"_src" //切换加载，真实图片路径为"_src"
			});
		},

		region_change : function() {
			$('[data-toggle="region_change"]').on('change', function() {
 				var $this		= $(this),
 					id 			= $this.attr("id"),
                    index       = $this.attr("data-index") || '',
 					url 		= $this.attr("data-url"),
 					type    	= $this.attr("data-type"),
 					target 		= $this.attr("data-target"),
 					parent 		= $this.val();
 					if($("#selCountries"+index).val()== 0 ){
 						$("#selProvinces"+index).children("option:gt(0)").remove();
 						$("#selCities"+index).children("option:gt(0)").remove();
 						$("#selDistricts"+index).children("option:gt(0)").remove();
 						//$("#selDistricts"+index).hide();
 					}else{
 						if( id == "selCountries"+index){
	 						//$("#selDistricts"+index).hide();
	 					}else if( id == "selProvinces"){
	 						//$("#selDistricts"+index).hide();
	 						if($("#selProvinces"+index).val()== 0 ){
 								$("#selCities"+index).children("option:gt(0)").remove();
	 						}
	 					}else if( id == "selCities"){
	 						//$("#selDistricts"+index).show();
	 						if($("#selCities"+index).val()== 0 ){
 								$("#selDistricts"+index).children("option:gt(0)").remove();
	 						}
	 					}
 						$.get(url,
							{'type':type ,'target':target,'parent':parent },
							function(data){
								if (data.state == 'success') {
				 					var opt  =	'';
				 					for (var i= 0 ; i<data.regions.length; i ++){
			 							opt +=	'<option value="'+data.regions[i].region_id+'">'+data.regions[i].region_name+'</option>';
				 					}
				 					if( id == "selCountries"+index){
				 						$("#selProvinces"+index).children("option:gt(0)").remove();
				 						$("#selProvinces"+index).children("option").after(opt);
				 					}else if( id == "selProvinces"+index){
				 						$("#selCities"+index).children("option:gt(0)").remove();
				 						$("#selCities"+index).children("option").after(opt);
				 					}else if( id == "selCities"+index){
				 						$("#selDistricts"+index).children("option:gt(0)").remove();
										$('#selDistricts').show();
				 						$("#selDistricts"+index).children("option").after(opt);
				 					}
				 				} else {
				 					ecjia.touch.showmessage(data);
				 				}
						}, 'json');
 					}

 			});
		},

		ecjia_menu : function() {
			$(document).off('click', '.ecjia-menu .main');
			$(document).on('click', '.ecjia-menu .main', function() {
				if ($('.ecjia-menu').hasClass('active')) {
					$('.ecjia-menu').removeClass('active');
				} else {
					$('.ecjia-menu').addClass('active');
				}
			});
		},

		toggle_collapse : function() {
			$(document).on('click', '[data-trigger="collapse"]', function(e) {
				e.preventDefault();
				var o_this = $(this),
					o_parent = o_this.attr('data-parent') ? o_this.parents(o_this.attr('data-parent')) : o_this,
					o_toggle = o_parent.find(o_this.attr('href')) || o_this.next();

				o_parent.hasClass('active') ? o_parent.addClass('active') : o_parent.removeClass('active');

				if (o_toggle.is(":visible")) {
					o_toggle.hide();
				} else {
					o_toggle.show();
				}
			});
		},

		selectbox : function() {
			$('.ecjia-form select').each(function(index) {
				var obj_this = $(this),
					obj_abter = $('<div class="select"><i class="iconfont"></i></div>');
				obj_this.after(obj_abter);
				obj_abter.append(obj_this);
			});
		},

		valid : function() {
			var $ecjiaform = $(".ecjia-form");
			$ecjiaform.length && $ecjiaform.each(function(index) {
			var need_valid = $(this).attr('data-valid') == 'novalid' ? false : true;
				if (need_valid) {
					$(this).on('submit',function(e){e.preventDefault();return false;}).Validform({
						tiptype:4,
						ajaxPost: true,
						callback:function(data){
							ecjia.touch.showmessage(data);
						}
					});
				}
			});
		},

		close_app_download : function() {
			$('.ecjia-app-download .icon-close').on('click', function(){
                $.cookie('hide_download', 1);
				$('.ecjia-app-download').remove();
			});
		},

		close_banner : function(){
			$(document).off('click', '.close-banner');
			$(document).on('click', '.close-banner', function(){
				$('.bottom-banner img').slideUp();
				var url = $(this).attr('data-url');
				$.get(url,function(){});
			});
		},

		searchbox_foucs : function() {
			$("#keywordBox").focus();
		}


	};




	//PJAX跳转执行
	$(document).on('pjax:complete', function() {
        window.onscroll = null;
		ecjia.touch.asynclist();
		ecjia.touch.selectbox();
		ecjia.touch.valid();

		ecjia.touch.more_callback = function() {ecjia.touch.delete_list_click();};
	});

	//PJAX开始
	$(document).on('pjax:start', function(){
		//增加动画
		$('body').removeClass('blurry');
		ecjia.touch.pjaxloadding();
	});

	//PJAX前进、返回执行
	$(document).on('pjax:popstate', function() {
	});

	//PJAX历史和跳转都会执行的方法
	$(document).on('pjax:end', function() {
        $('.la-ball-atom').remove();
		//关闭menu
		if ($('.ecjia-menu').hasClass('active')) {
			$('.ecjia-menu').removeClass('active');
		}
	});

})(ecjia, jQuery);

$(function(){
	/* 页面载入后自动执行 */
	ecjia.touch.init();
});
