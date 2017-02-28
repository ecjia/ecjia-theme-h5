/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.touch.franchisee = {
		init : function(){
			/*$("form[name='theForm']").on('submit',function(e){e.preventDefault();return false;}).Validform({
				tiptype:function(msg,o,cssctl){
				//msg：提示信息;
				//o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
				//cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
					if (o.type == 3){
						//alert(msg);
					}
				},
				ajaxPost: true,
				callback:function(data){
					ecjia.touch.showmessage(data);
				}
			});*/
			
			ecjia.touch.franchisee.validate_code();
			ecjia.touch.franchisee.next();
		},
		
		//商家入驻流程获取验证码
		validate_code : function () {
			var InterValObj; 	//timer变量，控制时间
    		var count = 120; 	//间隔函数，1秒执行
    		var curCount;		//当前剩余秒数
    		
			$(".settled-message").on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				var mobile = $("input[name='f_mobile']").val();
				if (mobile.length == 11) {
					url += '&mobile=' + mobile;
				} else {
					alert('请输入正确的手机号');return false;
				}
				
				$.get(url, function(data){
				    if (data.state == 'success') {
					  　    curCount = count;
					     $("#mobile").attr("readonly", "true");
					     $("#get_code").attr("disabled", "true");
					     $("#get_code").css("width", "7em");
					     $("#get_code").css("right", "4%");
					     $("#get_code").css("position", "absolute");
					     $("#get_code").css("padding", "0");
					     $("#get_code").css("margin", "0");
					     $("#get_code").css("top", ".5em");
					     $("#get_code").css("height", "2.2em");
					     $("#get_code").val("重新发送" + curCount + "(s)");
					     $("#get_code").attr("class", "btn btn-org login-btn settled-message btn-small");
					     InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
				    }
				    ecjia.touch.showmessage(data);
			    });
				//timer处理函数
			    function SetRemainTime() {
			        if (curCount == 0) {     
			            window.clearInterval(InterValObj);		//停止计时器
			            $("#mobile").removeAttr("readonly");	//启用按钮
			            $("#get_code").removeAttr("disabled");	//启用按钮
			            $("#get_code").val("重新发送");
			            $("#get_code").attr("class", "btn btn-info login-btn btn-small settled-message");
			        } else {
			            curCount--;
			            $("#get_code").attr("disabled", "true");
			            $("#get_code").val("重新发送" + curCount + "(s)");
			        }
			    };
			});
		},
		
		//入驻页面下一步
		next : function () {
			$("input[name='next_button']").on('click', function(e) {
				e.preventDefault();
				var f_name = $("input[name='f_name']").val();
				var f_email = $("input[name='f_email']").val();
				var f_mobile = $("input[name='f_mobile']").val();
				var f_code = $("input[name='f_code']").val();
				var url = $("form[name='theForm']").attr('action');
				
				if (f_name == '') {
					alert('请输入真实姓名');
					return false;
				}
				
				if (f_email == '') {
					alert('请输入电子邮箱');		
					return false;
				} else {
					var search_str = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
					if(!search_str.test(f_email)){       
					    alert("请输入正确的邮箱格式 !");
					    return false;
					}
				}
				
				if (f_mobile == '') {
					alert('请输入手机号码');
					return false;
				}
				
				if (f_code == '') {
					alert('验证码不能为空');
					return false;
				}

				var referer_url = $('input[name="referer_url"]').val();
        		var info = {
					'f_name': f_name,
					'f_email': f_email,
					'f_mobile' : f_mobile,
					'f_code': f_code
				};
				$.post(url, info, function(data){
					if (data.state == 'error') {
						alert(data.message);
					} else {
//						ecjia.pjax(data.url);
						location.href = data.url;
					}
				});
			});
		},
		
		//入驻页面下一步
		two : function () {
			$("input[name='franchisee_submit']").on('click', function(e) {
				e.preventDefault();
				var seller_name = $("input[name='seller_name']").val();
				var seller_category = $("input[name='seller_category']").val();
				var validate_type = $("input[name='validate_type']").val();
				var address = $("input[name='address']").val();
				var f_city = $("input[name='f_city']").val();
				
				var url = $("form[name='theForm']").attr('action');
				if (seller_name == '') {
					alert('请输入店铺名称');
					return false;
				}
				
				if (seller_category == '') {
					alert('请选择店铺分类');		
					return false;
				}
				
				if (validate_type == '') {
					alert('请选择入驻类型');
					return false;
				}
				
				if (address == '') {
					alert('请先写店铺地址');
					return false;
				}

        		var info = {
					'seller_name': seller_name,
					'seller_category': seller_category,
					'validate_type' : validate_type,
					'address': address,
					'f_city': f_city
				};
				$.post(url, info, function(data){
					if (data.state == 'error') {
						alert(data.message);
					} else {
						//location.href = data.url;
					}
				});
			});
		},
		
		//传参到获取精准坐标页
		coordinate : function () {
			var longitude = $("input[name='longitude']").val();
			var latitude = $("input[name='latitude']").val();
			
			if (longitude != '' && latitude != '') {
				$(".coordinate").html("精度：" + longitude + "；  " + "纬度：" + latitude);
			}

			$(".coordinate").on('click', function(e) {
				e.preventDefault();
				var seller_name 		= $("input[name='seller_name']").val();
				$.cookie('seller_name', seller_name); 
				
				var f_city 		= $("input[name='f_city']").val();
				var f_address   = $("input[name='f_address']").val();
				if(f_city && f_address){
					var url = $(this).attr("data-url");
					if (f_city != '') {
						var url = url + '&city=' +f_city;
					} ;
					if (f_address != '') {
						var url = url + '&address=' +f_address;
					} ;
					location.href = url;
				}else{
					alert('请输入详细地址');
				}
			})
		},
		
		//店铺入驻选择分类、入驻类型、店铺所在地
		choices : function() {
			var category_list = [];
			var category = eval('(' + $("input[name='category']").val() + ')')['data'];
			
			for (i=0;i < category.length; i++){
				category_list.push(category[i]['name']);
			};
			var myApp = new Framework7();
			var pickerDevice = myApp.picker({
			    input: '.ecjia-franchisee-category',
			    toolbarCloseText: '完成',
			    cols: [
			        {
			        	onChange: function (p, value) {
			        		$.cookie('seller', value); 
			        		for (i = 0; i < category.length; i++) {
			        			if (category[i]['name'] == value) {
			        				$.cookie('seller_category', category[i]['id']);
			        			}
			        		}
			        	},
			        	textAlign: 'center',
			            values: category_list
			        }
			    ]
			});
			
			var category_test = $(".picker-selected").attr("data-picker-value");
			var pickerDevice = myApp.picker({
			    input: '.ecjia-franchisee-type',
			    toolbarCloseText: '完成',
			    cols: [
			        {
			        	textAlign: 'center',
			            values: ['个人入驻', '企业入驻'],
			            onChange: function (p, value) {
			            	$.cookie('validate_type', value); 
			            }
			        }
			    ]
			});
			
			var province_list = [];
			var province_array = [];
			
			var province = eval('(' + $("input[name='province']").val() + ')')['data']['regions'];
			var city_list = eval('(' + $("input[name='city']").val() + ')')['data']['regions'];
			
			for (i=0;i < province.length; i++){
				var name = province[i]['name'];
				var id = province[i]['id'];
				province_list.push(name);
				province_array.push({name:name, id:id});
			};
			
			var carVendors = {
        		北京 : ['北京']
        	};
			var pickerDependent = myApp.picker({
			    input: '.ecjia-franchisee-location',
			    toolbarCloseText: '完成',
			    formatValue: function (picker, values) {
			        return values[1];
			    },
			    cols: [
			        {
			            textAlign: 'left',
			            values: province_list,
			            onChange: function (picker, city) {
			            	var citylist = [];
			            	for (i = 0; i < province_array.length; i++) {
			            		if (province_array[i]['name'] == city) {
			            			var province_id = province_array[i]['id'];
			            			console.log(province_id);
			            			$.cookie('province_id', province_id); 
			            		}
			            	}
			            	for (i = 0; i < city_list.length; i++) {
			            		if (city_list[i]['parent_id'] == province_id) {
			            			citylist.push(city_list[i]['name']);
			            		}
			            	}
			  
			            	var carVendors = {};
			            	$.cookie('city_id', citylist[1]); 
			            	carVendors[city] = citylist;
			                if(picker.cols[1].replaceValues){
			                    picker.cols[1].replaceValues(carVendors[city]);
			                }
			            }
			        },
			        {
			            values: carVendors.北京,
			            width: 160,
			            onChange: function (p, value) {
			            	for (i = 0; i < city_list.length; i++) {
			            		if (city_list[i]['name'] == value) {
			            			console.log(city_list[i]['id']);
			            			$.cookie('city_id', city_list[i]['id']); 
			            		}
			            	}
			            },
			        },
			    ]
			}); 
			
		},
		
		location :function(){
			$("#button").on('click', function(e) {
				e.preventDefault();
				var longitude = $("input[name='longitude']").val();
				var latitude = $("input[name='latitude']").val();
				var url = $(this).attr("data-url")+ '&longitude=' +longitude+ '&latitude=' +latitude;
				location.href = url;
			})
		}
	};
	
})(ecjia, jQuery);

//end