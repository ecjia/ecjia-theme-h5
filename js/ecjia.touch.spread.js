/**
 * 后台综合js文件
 */
;(function(ecjia, $) {
	ecjia.touch.spread = {
		init : function(){
			ecjia.touch.spread.spread();
		},
		spread: function() {
			$('.would-spread').on('click', function (e) {
				//$('.bottom-elastic-layer').animate({height:'toggle'});
			});
        },      
	};
})(ecjia, jQuery);
