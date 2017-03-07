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
		},
		goods_info : function () {
			$('.star').raty({
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
					}
					fr.readAsDataURL(f);
					
					if ($(".push_photo_img img").length == 3) {
						$(".push_img_fonz").remove();
					}
					if ($(".push_photo_img img").length == 4) {
						$(".push_photo").remove();
					}
				}
			})
		},
	
		remove_goods_img : function () {
			$(".a4y").on('click', function (e) {
				e.preventDefault();
				$(this).parent().remove();
			})
			
		},
	};
	
})(ecjia, jQuery);

//end