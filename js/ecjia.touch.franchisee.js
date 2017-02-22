/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.touch.franchisee = {
		init : function(){
			ecjia.touch.franchisee.buttom();
			
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
		
		buttom : function () {
			}
		}
})(ecjia, jQuery);

//end