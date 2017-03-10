/**
 * H5评论晒单
 */
;(function(ecjia, $) {
	ecjia.touch.comment = {
		init : function(){
			ecjia.touch.comment.goods_info();
			ecjia.touch.comment.anonymity();
			ecjia.touch.comment.photo();
			ecjia.touch.comment.remove_goods_img();
			ecjia.touch.comment.publish_comment();
			ecjia.touch.comment.back();
		},
		goods_info : function () {
			$('.star').raty({
				  click: function(score, evt) {
					  $(this).attr("data-number", score)
			      },
				  cancelOff: 'cancel-off-big.png',
				  cancelOn : 'cancel-on-big.png',
				  size     : 24,
				  starOff  : 'star-off-big.png',
				  starOn   : 'star-on-big.png',
			});
		},
		
		anonymity : function () {
			$(".ecjia-anonymity-check").on('click', function (e) {
				e.preventDefault();
				if ($(this).hasClass('anonymity-check-checked')) {
					$(this).removeClass("anonymity-check-checked");
				} else {
					$(this).addClass("anonymity-check-checked");
				}
				
			});
		},
		
		//评价晒单上传图片，并且不能超过5张。
		photo : function () {
			$(".push_img_btn").on('change', function () {
				var f=$(this)[0].files[0];
				if (f) {
					var fr=new FileReader();
					fr.onload=function(){
						var _img=new Image();
						_img.src=this.result;
						var check_push_rm = "check_push_rm" + $(".push_photo_img img").length;
						var img_span = "<i class='a4y'>X</i>";
						var url = "<div class='" + check_push_rm + "'></div>";
						
						$(url).appendTo(".push_photo_img");
						$(_img).appendTo("." + check_push_rm);
						$(img_span).appendTo("." + check_push_rm);
						ecjia.touch.comment.remove_goods_img();
						
						if ($(".push_photo_img img").length > 0) {
							$(".push_img_fonz").hide();
						}
						if ($(".push_photo_img img").length > 4) {
							$(".push_photo").hide();
						}
					}
					fr.readAsDataURL(f);
				}
			})
		},
	
		remove_goods_img : function () {
			$(".a4y").on('click', function (e) {
				e.preventDefault();
				
				var path = $(this).parent();
        		var myApp = new Framework7({
					modalButtonCancel : '取消',
					modalButtonOk : '确定',
					modalTitle : ''
			    });
				myApp.confirm('您确定要删除照片？', function () {
					if ($(".push_photo_img img").length <= 5) {
						$(".push_photo").show();
					}
					if ($(".push_photo_img img").length <= 1) {
						$(".push_img_fonz").show();
					}
					path.remove();
			    });
			})
			
		},
		
		//发表评价
		publish_comment : function () {
			$("input[name='push-comment-btn']").on('click', function (e) {
				e.preventDefault(e);
				var goods_id = $("input[name='goods_id']").val();
				var star = $(".star").attr("data-number");
				var goods_evaluate = $("#goods_evaluate").val();
				if (goods_evaluate == '') {
					goods_evaluate = "商品质量俱佳，强烈推荐！"
				}

				var anonymity = 0;
				if ($("#option_box").hasClass('anonymity-check-checked')) {
					var anonymity = 1;
				}
				info = {
						"goods_id"	:	goods_id,
						"goods_evaluate" : goods_evaluate,
						"star"	:	star,
						"anonymity"	: anonymity
				}
				console.log(info);
			})
		},
		
		back : function () {
			ecjia.touch.comment.back_url();
		},
		
		back_url : function () {
			if (window.history && window.history.pushState) {
				$(window).on('popstate', function () {
					var hashLocation = location.hash;
					var hashSplit = hashLocation.split("#!/");
					var hashName = hashSplit[1];
					if (hashName !== '') {
						var hash = window.location.hash;
						if (hash === '') {
							var goods_evaluate = $("#goods_evaluate").val();
							if (goods_evaluate != '') {
								var myApp = new Framework7();
				    			myApp.modal({
				        			title: '评价信息还未提交，返回将会丢失',
				        			buttons: [
							          {
							            text: '取消',
							            onClick: function() {
							            	ecjia.touch.comment.back_url();
							            }
							          },
							          {
							            text: '确定',
							            onClick: function() {
							            	history.back();
							            }	
							          },
							        ]
				        		});
							} else {
								history.back();
							}
						}
					}
				});
				window.history.pushState('forward', null, '');
			}
		}
	};
	
})(ecjia, jQuery);

//end