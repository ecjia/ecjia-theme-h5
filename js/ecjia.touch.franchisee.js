/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.touch.franchisee = {
		init : function(){
			ecjia.touch.franchisee.validate_code();
			ecjia.touch.franchisee.coordinate();
			
			$("form[name='theForm']").on('submit',function(e){e.preventDefault();return false;}).Validform({
				tiptype:function(msg,o,cssctl){
				//msg：提示信息;
				//o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
				//cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
					if (o.type == 3){
						alert(msg);
					}
				},
				ajaxPost: true,
				callback:function(data){
					ecjia.touch.showmessage(data);
				}
			});
		},
		
		//商家入驻流程获取验证码
		validate_code : function () {
			var InterValObj; 	//timer变量，控制时间
    		var count = 120; 	//间隔函数，1秒执行
    		var curCount;		//当前剩余秒数
    		
			$(".settled-message").on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				console.log(url);
				var mobile = $("input[name='f_mobile']").val();
				if (mobile.length == 11) {
					url += '&mobile=' + mobile;
					console.log(url);
				} else {
					alert('请输入正确的手机号');
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
					     $("#get_code").css("top", ".2em");
					     $("#get_code").css("height", "2.2em");
					     $("#get_code").css("line-height", "2.4em");
					     $("#get_code").val("重新发送" + curCount + "(s)");
					     $("#get_code").attr("class", "btn btn-org login-btn");
					     InterValObj = window.setInterval(SetRemainTime, 10); //启动计时器，1秒执行一次
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
			            $("#get_code").attr("class", "btn btn-info login-btn");
			        } else {
			            curCount--;
			            $("#get_code").attr("disabled", "true");
			            $("#get_code").val("重新发送" + curCount + "(s)");
			        }
			    };
			});
		},
		
		//传参到获取精准坐标页
		coordinate : function () {
			$(".coordinate").on('click', function(e) {
				e.preventDefault();
				var f_city = $("input[name='f_city']").val();
				var f_address = $("input[name='f_address']").val();
				var url = $(this).attr("data-url");
				
				if (f_city != '') {
					var url = url + '&city=' +f_city;
				} ;
				if (f_address != '') {
					var url = url + '&address=' +f_address;
				} ;
				location.href = url;
			})
		},
		
		choices : function() {
			var category_list = [];
			var category = eval('(' + $("input[name='category']").val() + ')')['data'];
			
			for (i=0;i < category.length; i++){
				category_list.push(category[i]['name']);
			}
			
			var myApp = new Framework7();
			var pickerDevice = myApp.picker({
			    input: '.ecjia-franchisee-category',
			    toolbarCloseText: '完成',
			    cols: [
			        {
			        	textAlign: 'center',
			            values: category_list
			        }
			    ]
			});
			var pickerDevice = myApp.picker({
			    input: '.ecjia-franchisee-type',
			    toolbarCloseText: '完成',
			    cols: [
			        {
			        	textAlign: 'center',
			            values: ['个人入驻', '企业入驻']
			        }
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
	}
})(ecjia, jQuery);

//end