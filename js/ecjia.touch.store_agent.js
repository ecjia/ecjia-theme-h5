/**
 * 后台综合js文件
 */
;
(function (ecjia, $) {
    ecjia.touch.store_agent = {
        init: function () {
            ecjia.touch.store_agent.would_store_agent();
        },
        
        would_store_agent: function () {
            $('.would-store-agent').off('click').on('click', function (e) {
                e.preventDefault();
                var ua = navigator.userAgent.toLowerCase();
                if (ua.match(/MicroMessenger/i) == "micromessenger") {
                    $('.ecjia-store-agent-share').removeClass('hide').css('top', $('body').scrollTop() + 'px');
                    //禁用滚动条
                    $('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
                        event.preventDefault;
                    }, false);
                    $('.ecjia-store-agent-share').on('click', function () {
                        $('.ecjia-store-agent-share').addClass('hide');
                        $('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
                    })
                } else {
                    alert(js_lang.please_open_link);
                }
            });
        }
    };

})(ecjia, jQuery);

//end