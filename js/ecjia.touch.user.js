/**
 * 后台综合js文件
 */
;(function(ecjia, $) {

	ecjia.touch.user = {
		init : function(from){
			ecjia.touch.user.show_goods_list_click();
			ecjia.touch.user.show_share_click();
			ecjia.touch.user.loginout_click();
			ecjia.touch.user.clear_history();
			ecjia.touch.user.get_code();
			ecjia.touch.user.fast_reset_pwd();
			ecjia.touch.user.register_password();
			ecjia.touch.user.mobile_register();
			ecjia.touch.user.reset_password();
			ecjia.touch.user.show_password();
			$(function(){
				$(".del").click(function(){
					if(!confirm('您确定要删除吗？')){
						return false;
					}
					var obj = $(this);
					var url = obj.attr("href");
					$.get(url, '', function(data){
						if('success' == data.state){
							if(obj.hasClass("history_clear")){
								obj.closest(".ect-pro-list").html("<p class='text-center  ect-margin-tb ect-padding-tb'>暂无浏览记录，点击<a class='ect-color ect-margin-lr' href={url path='category/index')}>进入</a>浏览商品</p>");
								obj.parent().siblings("ul").remove();
							} 
							else{
								if(obj.closest("li").siblings("li").length == 0){
									obj.closest("ul").html("<p class='text-center  ect-margin-tb ect-padding-tb'>{$lang.no_data}</p>");
								}
								obj.closest("li").remove();
							}
						}
						else{
							alert("删除失败");
						}
					}, 'json');
					return false;
				});
			})
		},

		//点击搜索结果事件
        location_list_click: function () {      	
            $('.ecjia-location-list-wrap li').on('click', function () {
            	  var title=$(this).find(".ecjia-location-list-title").text();
                  var address=$(this).find(".ecjia-location-list-address").text();
                  var url = $("#ecjia-zs").attr('data-url');
                  url += '&address=' + address;
                  url += '&address_info=' + title;
                  ecjia.pjax(url);
            });
        },

		loginout_click : function (){
			$('.loginout').on('click',function(e){
				e.preventDefault();
				var url = $(this).attr('href');
				if(confirm('你确定要退出登录吗？')){
					$.get(url, '', function(data){
						ecjia.touch.showmessage(data);
					})
				}
			});
		},
		clear_history : function (){
			$('.clear_history').on('click',function(e){
				e.preventDefault();
				var url = $(this).attr('href');
				if(confirm('你确定要清除浏览历史记录吗？')){
					$.get(url, '', function(data){
						ecjia.touch.showmessage(data);
					})
				}
			});
		},
		/* 注册验证码 */
		get_code : function (){
			var InterValObj; 	//timer变量，控制时间
    		var count = 120; 	//间隔函数，1秒执行
    		var curCount;		//当前剩余秒数
    		$('#get_code').off('click').on('click', function(e){
				e.preventDefault();
				var url = $(this).attr('data-url');
				var mobile = $("input[name='mobile']").val();
//				if (mobile.trim() != '') {
					url += '&mobile=' + mobile;
//				}
				$.get(url, function(data){
				    if (data.state == 'success') {
					  　    	 curCount = count;
					     $("#mobile").attr("readonly", "true");
					     $("#get_code").attr("disabled", "true");
					     $("#get_code").val("重新发送" + curCount + "(s)");
					     $("#get_code").attr("class", "btn btn-org login-btn");
					     InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
				    }
				    ecjia.touch.showmessage(data);
			    });
			});
		    //timer处理函数
		    function SetRemainTime() {
		        if (curCount == 0) {     
		            window.clearInterval(InterValObj);		//停止计时器
		            $("#mobile").removeAttr("readonly");	//启用按钮
		            $("#get_code").removeAttr("disabled");	//启用按钮
		            $("#get_code").val("重新发送验证码");
		            $("#get_code").attr("class", "btn btn-info login-btn");
		        } else {
		            curCount--;
		            $("#get_code").attr("disabled", "true");
		            $("#get_code").val("重新发送" + curCount + "(s)");
		        }
		    };
		},
		
		/* 注册提交表单 */
		fast_reset_pwd : function (){
			$(".next-btn").on('click', function(e){
				e.preventDefault();
				var url = $(this).attr('data-url'),
					mobile = $("input[name='mobile']").val().trim(),
					verification = $("input[name='verification']").val().trim(),
					code = $("input[name='code']").val().trim();
				if (code == '') {
					return false;
				}
				var info = {
					'mobile': mobile,
					'verification': verification,
					'code': code
				};
				$.post(url, info, function(data){
					ecjia.touch.showmessage(data);
				});
			});
		},
		/* 处理注册  */
		register_password : function (){
			$("#signin").on('click', function(e){
				e.preventDefault();
				var url = $(this).attr('data-url'),
				    username = $("input[name='username']").val().trim(),
				    password = $("input[name='password']").val().trim();
				var info = {
					'username': username,
					'password': password
				};
				$.post(url, info, function(data){
					ecjia.touch.showmessage(data);
				});
			});
		},
		/*找回密码重置密码*/
		mobile_register : function (){
			$("input[name='mobile_register']").on('click', function(e){
				e.preventDefault();
				var url = $(this).attr('data-url'),
					mobile = $("input[name='mobile']").val().trim(),
					code = $("input[name='code']").val().trim();
				var info = {
					'mobile': mobile,
					'code': code
				};
				$.post(url, info, function(data){
					ecjia.touch.showmessage(data);
				});
			});
		},
		/*设置新密码*/
		reset_password : function (){
			$("input[name='reset_password']").on('click', function(e){
				e.preventDefault();
				var url = $(this).attr('data-url'),
					passwordf = $("input[name='passwordf']").val().trim();
					passwords = $("input[name='passwords']").val().trim();
				var info = {
					'passwordf': passwordf,
					'passwords': passwords
				};
				$.post(url, info, function(data){
					ecjia.touch.showmessage(data);
				});
			});
		},
		/*查看密码*/
		show_password : function (){
			$("#password1").on('click', function(e){
				if ($("#password-1").attr("type") == "password") {
		            $("#password-1").attr("type", "text")
		        }
		        else {
		            $("#password-1").attr("type", "password")
		        }
			});
			$("#password2").on('click', function(e){
				if ($("#password-2").attr("type") == "password") {
		            $("#password-2").attr("type", "text")
		        }
		        else {
		            $("#password-2").attr("type", "password")
		        }
			});
		},
		// add_attention_click : function(){
		// 	$('[data-toggle="add_to_attention"]').on('click', function(){
		// 			var $this 		= $(this),
		// 			options		= {
		// 				id 		: $this.attr('data-id'),
		// 				url 	: $this.attr('data-url'),
		// 				logo 	: $this.attr('data-logo')
		// 			};
		// 			if (!options.url || !options.id) { alert('缺少必要参数，添加关注失败');return;}
		// 		if(options.logo =='del'){
		// 			if(confirm('确认将该商品移除关注列表吗？')){
		// 				ecjia.touch.user.add_attention(options);
		// 				}
		// 		}else if(options.logo =='add'){
		// 			if(confirm('确认将该商品加入关注列表吗？')){
		// 				ecjia.touch.user.add_attention(options);
		// 				}
		// 			}else{
		// 				if(confirm('确认将该商品从收藏列表移除吗？')){
		// 				ecjia.touch.user.add_attention(options);
		// 				}
		// 			}
		// 		})
		// },

		// add_attention : function(options){
		// 	$.get(options.url, {
		// 			rec_id: options.id
		// 		}, function(data) {
		// 			location.href=data.pjaxurl;
		// 		}, 'json');
		// },

		show_goods_list_click :function(){
			$('.order-detail-list li.hd').on('click', function(){
				if (! $(this).hasClass('active')) {
					$(this).addClass('active');
					$(this).next(".order-goods-detail").addClass('active');
				}else {
					$(this).removeClass('active');
					$(this).next(".order-goods-detail").removeClass('active');
				}
			})
		},

		show_share_click :function(){
			$('.commont-show-active .hd').on('click', function(){
				if (! $(this).parent('.user-share').hasClass('user-share-show')) {
					$(this).parent('.user-share').addClass('user-share-show');
				}else {
					$(this).parent('.user-share').removeClass('user-share-show');
				}
			})
		},
	};


	// ecjia.touch.getpwd = {
	// 	init : function () {
	// 		$("form[name='getPassword']")
	// 		.formValidation({
	// 			message: '您的输入有误，请重新输入！',
	// 			fields: {
	// 				user_name: {
	// 					message: '用户名输入有误！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '用户名不能为空！'
	// 						},
	// 						stringLength: {
	// 							min: 1,
	// 							max: 30,
	// 							message: '请输入1-30位长度的用户名！'
	// 						}
	// 					}
	// 				},
	// 				email: {
	// 					message: '电子邮箱输入有误！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '电子邮箱不能为空！'
	// 						},
	// 						emailAddress: {
	// 							message: '电子邮箱格式不正确！'
	// 						}
	// 					}
	// 				},
	// 				passwd_answer: {
	// 					message: '问题答案输入有误！',
	// 					validators: {
	// 						notEmpty: {
	// 							message:'问题答案不能为空'
	// 						}
	// 					}
	// 				}
	// 			}
	// 		})
	// 		.on('success.form.fv', function(e) {
	// 			e.preventDefault();
	// 			$("form[name='getPassword']").ajaxSubmit({
	// 				dataType:"json",
	// 				success:function(data) {
	// 					ecjia.touch.showmessage(data);
	// 				}
	// 			});
	// 		});
	// 	}
	// },

	// ecjia.touch.resetpwd = {
	// 	init : function () {
	// 		$("form[name='getPassword2']")
	// 		.formValidation({
	// 			message: '您的输入有误，请重新输入！',
	// 			fields: {
	// 				new_password: {
	// 					message: '新密码输入有误！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '新密码不能为空！'
	// 						},
	// 						stringLength: {
	// 							min: 6,
	// 							max: 32,
	// 							message: '请输入6-32位长度的密码！'
	// 						}
	// 					}
	// 				},
	// 				confirm_password: {
	// 					validators: {
	// 						notEmpty: {
	// 							message: '确认新密码不能为空！'
	// 						},
	// 						identical: {
	// 							field: 'new_password',
	// 							message:'您输入密码不一致'
	// 						},
	// 						stringLength: {
	// 							min: 6,
	// 							max: 32,
	// 							message: '请输入6-32位长度的密码！'
	// 						}
	// 					}
	// 				}
	// 			}
	// 		})
	// 		.on('success.form.fv', function(e) {
	// 			e.preventDefault();
	// 			$("form[name='getPassword2']").ajaxSubmit({
	// 				dataType:"json",
	// 				success:function(data) {
	// 					ecjia.touch.showmessage(data);
	// 				}
	// 			});
	// 		});
	// 	}
	// },

	// ecjia.touch.formMsg = {
	// 	init : function () {
	// 		$("form[name='formMsg']")
	// 		.formValidation({
	// 			message: '您的输入有误，请重新输入！',
	// 			fields: {
	// 				msg_type: {
	// 					message: '请选择留言类型！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '留言类型不能为空！'
	// 						}
	// 					}
	// 				},
	// 				msg_content: {
	// 					validators: {
	// 						notEmpty: {
	// 							message:'留言内容不能为空'
	// 						}
	// 					}
	// 				}
	// 			}
	// 		})
	// 		.on('success.form.fv', function(e) {
	// 			e.preventDefault();
	// 			$("form[name='formMsg']").ajaxSubmit({
	// 				dataType:"json",
	// 				success:function(data) {
	// 					ecjia.touch.showmessage(data);
	// 				}
	// 			});
	// 		});
	// 	}
	// },

	// ecjia.touch.bouns = {
	// 	init : function () {
	// 		$("form[name='addBouns']")
	// 		.formValidation({
	// 			message: '您的输入有误，请重新输入！',
	// 			fields: {
	// 				bonus_sn: {
	// 					message: '请输入红包序列号！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '红包序列号不能为空！'
	// 						}
	// 					}
	// 				}
	// 			}
	// 		})
	// 		.on('success.form.fv', function(e) {
	// 			e.preventDefault();
	// 			$("form[name='addBouns']").ajaxSubmit({
	// 				dataType:"json",
	// 				success:function(data) {
	// 					ecjia.touch.showmessage(data);
	// 				}
	// 			});
	// 		});
	// 	}
	// },

	// ecjia.touch.address_from = {
	// 	init : function () {
	// 		$("form[name='theForm']")
	// 		.formValidation({
	// 			message: '您的输入有误，请重新输入！',
	// 			fields: {
	// 				consignee: {
	// 					message: '请输入收货人姓名！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '收货人姓名不能为空！'
	// 						},
	// 						stringLength: {
	// 							min: 1,
	// 							max: 15,
	// 							message: '请输入1-15位长度的收货人姓名！'
	// 						}
	// 					}
	// 				},
	// 				mobile: {
	// 					message: '请输入手机号！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '手机号不能为空！'
	// 						},
	// 						stringLength: {
	// 							min: 7,
	// 							max: 14,
	// 							message: '请输入正确格式的联系方式！'
	// 						}
	// 					}
	// 				},
	// 				address: {
	// 					message: '请输入详细地址！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '详细地址不能为空！'
	// 						}
	// 					}
	// 				},
	// 			}
	// 		})
	// 		.on('success.form.fv', function(e) {
	// 			e.preventDefault();
	// 			$("form[name='theForm']").ajaxSubmit({
	// 				dataType:"json",
	// 				success:function(data) {
	// 					$('button[type="submit"]').removeClass('disabled').attr('disabled',false);
	// 					ecjia.touch.showmessage(data);
	// 				}
	// 			});
	// 		});
	// 	}
	// },

	// ecjia.touch.edit_address = {
	// 	init : function () {
	// 		$("form[name='theForm']")
	// 		.formValidation({
	// 			message: '您的输入有误，请重新输入！',
	// 			fields: {
	// 				consignee: {
	// 					message: '请输入收货人姓名！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '收货人姓名不能为空！'
	// 						},
	// 						stringLength: {
	// 							min: 1,
	// 							max: 15,
	// 							message: '请输入1-15位长度的收货人姓名！'
	// 						}
	// 					}
	// 				},
	// 				mobile: {
	// 					message: '请输入手机号！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '手机号不能为空！'
	// 						},
	// 						stringLength: {
	// 							min: 7,
	// 							max: 14,
	// 							message: '请输入正确格式的联系方式！'
	// 						}
	// 					}
	// 				},
	// 				address: {
	// 					message: '请输入详细地址！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '详细地址不能为空！'
	// 						}
	// 					}
	// 				},
	// 			}
	// 		})
	// 		.on('success.form.fv', function(e) {
	// 			e.preventDefault();
	// 			$("form[name='theForm']").ajaxSubmit({
	// 				dataType:"json",
	// 				success:function(data) {
	// 					ecjia.touch.showmessage(data);
	// 				}
	// 			});
	// 		});
	// 	}
	// },

	// ecjia.touch.edit_password = {
	// 	init : function () {
	// 		$("form[name='formPassword']")
	// 		.formValidation({
	// 			message: '您的输入有误，请重新输入！',
	// 			fields: {
	// 				old_password: {
	// 					message: '请输入当前密码！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '当前密码不能为空！'
	// 						},
	// 						stringLength: {
	// 							min: 6,
	// 							max: 32,
	// 							message: '请输入6-32位长度的密码！'
	// 						}
	// 					}
	// 				},
	// 				new_password: {
	// 					message: '请输入新密码！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '新密码不能为空！'
	// 						},
	// 						stringLength: {
	// 							min: 6,
	// 							max: 32,
	// 							message: '请输入6-32位长度的密码！'
	// 						}
	// 					}
	// 				},
	// 				comfirm_password: {
	// 					message: '您的输入有误，请重新输入！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '确认新密码不能为空！'
	// 						},
	// 						identical: {
	// 							field: 'new_password',
	// 							message:'您输入密码不一致'
	// 						},
	// 						stringLength: {
	// 							min: 6,
	// 							max: 32,
	// 							message: '请输入6-32位长度的密码！'
	// 						}
	// 					}
	// 				}
	// 			}
	// 		})
	// 		.on('success.form.fv', function(e) {
	// 			e.preventDefault();
	// 			$("form[name='formPassword']").ajaxSubmit({
	// 				dataType:"json",
	// 				success:function(data) {
	// 					ecjia.touch.showmessage(data);
	// 				}
	// 			});
	// 		});
	// 	}
	// },

	// ecjia.touch.add_booking = {
	// 	init : function () {
	// 		$("form[name='formPassword']")
	// 		.formValidation({
	// 			message: '您的输入有误，请重新输入！',
	// 			fields: {
	// 				number: {
	// 					message: '请输入进行缺货登记的数量！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '缺货登记的数量不能为空！'
	// 						}
	// 					}
	// 				},
	// 				linkman: {
	// 					message: '请输入联系人！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '联系人不能为空！'
	// 						}
	// 					}
	// 				},
	// 				email: {
	// 					message: '电子邮箱输入有误！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '电子邮箱不能为空！'
	// 						},
	// 						emailAddress: {
	// 							message: '电子邮箱格式不正确！'
	// 						}
	// 					}
	// 				},
	// 				tel: {
	// 					message: '请输入手机号！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '手机号不能为空！'
	// 						},
	// 						stringLength: {
	// 							min: 7,
	// 							max: 14,
	// 							message: '请输入正确格式的联系方式！'
	// 						}
	// 					}
	// 				},
	// 				desc: {
	// 					message: '请输入进行缺货登记的描述！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '缺货登记的订单描述不能为空！'
	// 						}
	// 					}
	// 				}
	// 			}
	// 		})
	// 		.on('success.form.fv', function(e) {
	// 			e.preventDefault();
	// 			$("form[name='formPassword']").ajaxSubmit({
	// 				dataType:"json",
	// 				success:function(data) {
	// 					ecjia.touch.showmessage(data);
	// 				}
	// 			});
	// 		});
	// 	}
	// },

	// ecjia.touch.edit_profile = {
	// 	init : function () {
	// 		$("form[name='user_profile']")
	// 		.formValidation({
	// 			message: '您的输入有误，请重新输入！',
	// 			fields: {
	// 				email: {
	// 					message: '电子邮箱输入有误！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '电子邮箱不能为空！'
	// 						},
	// 						emailAddress: {
	// 							message: '电子邮箱格式不正确！'
	// 						}
	// 					}
	// 				}
	// 			}
	// 		})
	// 		.on('success.form.fv', function(e) {
	// 			e.preventDefault();
	// 			$("form[name='user_profile']").ajaxSubmit({
	// 				dataType:"json",
	// 				success:function(data) {
	// 					ecjia.touch.showmessage(data);
	// 					$('input[type="submit"]').removeClass('disabled').attr('disabled',false);
	// 				}
	// 			});
	// 		});
	// 	}
	// },
	
	// ecjia.touch.user_register = {
	// 	init : function () {
	// 		$("form[name='formUser']")
	// 		.formValidation({
	// 			message: '您的输入有误，请重新输入！',
	// 			fields: {
	// 				username: {
	// 					message: '请选择留言类型！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '用户名不能为空！'
	// 						},
	// 						stringLength: {
	// 							min: 1,
	// 							max: 30,
	// 							message: '请输入1-30位长度的用户名！'
	// 						}
	// 					}
	// 				},
	// 				email: {
	// 					message: '电子邮箱输入有误！',
	// 					validators: {
	// 						notEmpty: {
	// 							message: '电子邮箱不能为空！'
	// 						},
	// 						emailAddress: {
	// 							message: '电子邮箱格式不正确！'
	// 						}
	// 					}
	// 				},
	// 				password: {
	// 					message: '密码输入有误！',
	// 					validators: {
	// 						notEmpty: {
	// 							message:'密码不能为空'
	// 						},
	// 						stringLength: {
	// 							min: 6,
	// 							max: 32,
	// 							message: '请输入6-32位长度的密码！'
	// 						}
	// 					}
	// 				},
	// 				captcha: {
	// 					message: '验证码输入有误！',
	// 					validators: {
	// 						notEmpty: {
	// 							message:'验证码不能为空'
	// 						}
	// 					}
	// 				}
	// 			}
	// 		})
	// 		.on('success.form.fv', function(e) {
	// 			e.preventDefault();
	// 			$("form[name='formUser']").ajaxSubmit({
	// 				dataType:"json",
	// 				success:function(data) {
	// 					$('.register_submit').attr('class', 'register_submit btn btn-info').removeAttr('disabled');
	// 					ecjia.touch.showmessage(data);
	// 				}
	// 			});
	// 		});
	// 	}
	// }
})(ecjia, jQuery);
