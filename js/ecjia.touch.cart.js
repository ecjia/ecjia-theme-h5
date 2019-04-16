
;
(function (ecjia, $) {

    /**
     * 店铺购物车
     * @param store_id
     * @param goods_id
     * @param product_id
     * @param spec
     * @constructor
     */
    var cart = function EcjiaStoreCart(store_id, goods_id, product_id, spec) {
        /**
         * 店铺ID
         */
        this.store_id = store_id;

        /**
         * 商品ID
         * @type {{$goods_info}}
         */
        this.goods_id = goods_id === null ? 0 : goods_id;

        /**
         * 货品ID
         */
        this.product_id = product_id == null ? 0 : product_id;

        /**
         * 商品规格
         */
        this.spec = spec;



        /**
         * 添加购物车，增加数量
         * @param url
         * @param num
         */
        this.add = function (url, num) {

            this.num = num;

            var info = {
                'val': num,
                // 'rec_id': rec_id,
                'store_id': this.store_id,
                'goods_id': this.goods_id,
                // 'checked': '',
                // 'response': response,
                'spec': this.spec,
                // 'act_id': act_id,
                'product_id': this.product_id
            };

            //更新购物车中商品
            $.post(url, info, this.updateCartCallback);
        };

        /**
         * 减少购物车，减少数量
         * @param url
         * @param rec_id
         * @param num
         */
        this.reduce = function (url, rec_id, num) {

            this.num = num;

            var info = {
                'val': num,
                'rec_id': rec_id,
                'store_id': this.store_id,
                'goods_id': this.goods_id,
                // 'checked': checked == null ? '' : checked,
                // 'response': response,
                'spec': this.spec,
                // 'act_id': act_id,
                'product_id': this.product_id
            };

            //更新购物车中商品
            $.post(url, info, this.updateCartCallback);
        };

        /**
         * 请求回调
         * @param data
         */
        this.updateCartCallback = function (data) {

            console.log(data);
            //error return
            if (data.state === 'error') {
                this.loginAlert(data);
                return false;
            }

            if (this.num === 0) {
                ecjia.touch.cartdom.removeProduct(this.goods_id);
            }







        };

        /**
         * 消息提示
         * @param data
         */
        this.loginAlert = function (data) {
            var myApp = new Framework7();

            $('.la-ball-atom').remove();
            if (data.referer_url || data.message === 'Invalid session') {
                $(".ecjia-store-goods .a1n .a1x").css({
                    overflow: "hidden"
                }); //禁用滚动条
                //禁用滚动条
                $('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
                    event.preventDefault();
                }, false);

                myApp.modal({
                    title: js_lang.tips,
                    text: js_lang.logged_yet,
                    buttons: [
                        {
                            text: js_lang.cancel,
                            onClick: function () {
                                $('.modal').remove();
                                $('.modal-overlay').remove();
                                $(".ecjia-store-goods .a1n .a1x").css({
                                    overflow: "auto"
                                }); //启用滚动条
                                $('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
                                return false;
                            }
                        },
                        {
                            text: js_lang.go_login,
                            onClick: function () {
                                $('.modal').remove();
                                $('.modal-overlay').remove();
                                $(".ecjia-store-goods .a1n .a1x").css({
                                    overflow: "auto"
                                }); //启用滚动条
                                $('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
                                location.href = data.referer_url;
                                return false;
                            }
                        }
                    ]
                });
            }
            else {
                alert(data.message);
            }
        };



    };
    ecjia.touch.cart = cart;

    /**
     * 购物车DOM相关操作
     */
    ecjia.touch.cartdom = {

        /**
         * 从购物车中移除该货品
         * @param goods_id
         */
        removeProduct: function (goods_id) {

            var element = $('#goods_' + goods_id);

            element.children('.reduce').removeClass('show').addClass('hide');
            element.children('label').removeClass('show').addClass('hide');
            element.children('span.detail-add').removeClass('show').addClass('hide');
            element.children('span.goods-detail').addClass('hide');
            element.siblings('span').removeClass('hide').attr('rec_id', '');

            $('#setion_' + goods_id).remove();
        }











    };



})(ecjia, jQuery);

