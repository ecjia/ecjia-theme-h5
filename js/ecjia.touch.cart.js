(function (ecjia, $) {

    /**
     * 店铺购物车
     * @param store_id
     * @param goods_id
     * @param product_id
     * @param spec
     * @param div
     * @constructor
     */
    var cart = function EcjiaStoreCart(store_id, goods_id, product_id, spec,div) {
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
         * 删除指定div
         */
        this.div = div;

        /**
         * 添加购物车，增加数量
         * rec_id 不赋值为add 赋值为reduce
         * @param url
         * @param num
         */
        this.add = function (url,num) {
            this.num = num;
            this.type = 'add';
            var info ={
                'val': num,
                'store_id': this.store_id,
                'goods_id': this.goods_id,
                'spec': this.spec,
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
        this.reduce = function (url,rec_id,num) {
            this.num = num;
            this.type = 'reduce';
            var info = {
                'val': num,
                'rec_id': rec_id,
                'store_id': this.store_id,
                'goods_id': this.goods_id,
                'spec': this.spec,
                'product_id': this.product_id
            };

            //更新购物车中商品
            $.post(url, info, this.updateCartCallback);
        };

        /**
         * 改变购物车中商品的数量
         * @param url
         * @param num
         */
        this.changeNum = function (url,num) {
            var info = {
                'rec_id': this.rec_id,
                'val': num,
                'goods_id': this.goods_id
            };
            $.post(url,info,this.updateCartCallback)
        };

        /**
         * 请求回调
         * @param data
         */
        this.updateCartCallback = function (data) {
            console.log(data);
            // dom 操作
            ecjia.touch.cartdom.updateCartInitDom();
            // error return
            if (data.state === 'error') {
                this.loginAlert(data);
                return false;
            }
            // 传入的商品数量为0
            if (this.num === 0) {
                ecjia.touch.cartdom.removeProduct(this.goods_id);
            }
            // 移除相关div
            if (div !== undefined && div !== '') {
                ecjia.touch.cartdom.removeDiv(div);
                return  false;
            }
            // 返回 empty 字段为 true
            if (data.empty === true) {
                var li = $('.check_cart_' + data.store_id).parents('.cart-single');
                li.remove();
                if ($('li.cart-single').length === 0) {
                    $('.ecjia-flow-cart').remove();
                    $('.flow-no-pro').removeClass('hide');
                }
                return false;
            }
            // 返回 response 字段为true
            if (data.response === true) {
                $('.la-ball-atom').remove();
                if (data.count != null) {
                    var price_ele = $('.price_' +this.store_id);
                    var _check_cart_ele = $('.check_cart_' + this.store_id);

                    if (data.count.discount !== 0) {
                        var discount_html = '<label class="discount">' + sprintf(js_lang.reduced, data.count.discount) + '<label>';
                        price_ele.html(data.count.goods_price + discount_html);
                    } else {
                        price_ele.html(data.count.goods_price);
                    }

                    if (data.data_rec) {
                        _check_cart_ele.attr('data-rec', data.data_rec);
                        _check_cart_ele.removeClass('disabled');
                    } else {
                        _check_cart_ele.attr('data-rec', '');
                        _check_cart_ele.addClass('disabled');
                    }
                }
                return true;
            }
            // 根据传入的商品规格来更新商品规格部分的数据
            if (spec !== '' || spec !== false) {
                ecjia.touch.cartdom.updateProductSpecNumDom(this.spec,this.type,this.goods_id,this.num);
            }
            // 更新购物车数据和相关dom
            ecjia.touch.cartdom.updateCartDataAndDom(data,this.goods_id,this.spec,this.num);

            ecjia.touch.category.check_all();
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

        /**
         * 显示购物车
         * 传入布尔值
         * @param boolean
         */
        this.showCart = function (boolean) {
            var store_add_acrt_ele = $('.store-add-cart');
            var minicart_content_ele = $('.minicart-content');

            if (boolean) {
                // 底部灰色部分可用
                store_add_acrt_ele.children('.a4x').addClass('light').removeClass('disabled');
                store_add_acrt_ele.children('.a51').removeClass('disabled');
            } else {
                // 显示
                $('.a57').css('display', 'block');
                //禁用滚动条
                // $('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
                //     event.preventDefault();
                // }, false);
                ecjia.touch.cartdom.isScroll('body','y',false);
                minicart_content_ele.on('touchmove', function (e) {
                    e.stopPropagation();
                });
                $('.a53').css('display', 'block');
                store_add_acrt_ele.children('.a4x').removeClass('show').removeAttr('show');
                store_add_acrt_ele.children('.minicart-content').css('transform', 'translateY(-100%)');
                store_add_acrt_ele.children('.a4z').css('transform', 'translateX(-60px)');
                minicart_content_ele.children('.a4x').addClass('show').addClass('light').removeClass('disabled');
            }
        };

        /**
         * 清空并隐藏购物车
         * 若传入参数为true 同时清空购物车
         * @param boolean
         */
       this.hideCart = function (boolean) {
            var store_add_acrt_ele = $('.store-add-cart');
            var minicart_content_ele = $('.minicart-content');
            //启用滚动条
            $('body').css('overflow-y', 'auto').off("touchmove");

            store_add_acrt_ele.find('.a4z').css('transform', 'translateX(0px)');
            $('.a53').css('display', 'none');
            store_add_acrt_ele.find('.minicart-content').css('transform', 'translateY(0px)');
            minicart_content_ele.children('.a4x').removeClass('show').attr('show', false);
            store_add_acrt_ele.children('.a4x').addClass('show').attr('show', false);

            //购物车完全清空
            if (boolean === true) {
                this.clearCart();
            }
            //启用用滚动条
            $(".ecjia-store-goods .a1n .a1x").css({
                overflow: "auto"
            });
        };

        /**
         * 清空购物车
         */
        this.clearCart = function(){
            var a51_ele = $('.a51');
            var text = a51_ele.attr('data-text') === undefined ? js_lang.go_settlement : a51_ele.attr('data-text');
            var store_add_acrt_ele = $('.store-add-cart');
            var minicart_content_ele = $('.minicart-content');
            $('.a57').css('display', 'none');
            store_add_acrt_ele.removeClass('active');
            $('.a4y').remove();
            store_add_acrt_ele.children('.a4x').addClass('disabled').addClass('outcartcontent').removeClass('light').removeClass('incartcontent');
            minicart_content_ele.children('.a4x').removeClass('light').addClass('disabled');
            store_add_acrt_ele.children('.a4z').children('div').addClass('a50').html(js_lang.cart_empty);
            store_add_acrt_ele.children('.a51').addClass('disabled').html(text);
            $('.minicart-goods-list').html('');
        }

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
        },

        /**
         * 更新完购物车后，立即操作的一些dom
         */
        updateCartInitDom: function(){
            $('.la-ball-atom').remove();
            $('.box').children('span').addClass('limit_click'); //禁止其他加减按钮点击
            $('[data-toggle="toggle_checkbox"]').removeClass('limit_click'); //店铺首页 允许其他单选框点击
            $("[data-toggle='add-to-cart']").removeClass('limit_click');
            $("[data-toggle='remove-to-cart']").removeClass('limit_click');

            $('.goods-add-cart').removeClass('disabled');
            $('.ecjia-num-view').find('.btn-ok').removeClass('disabled');
        },

        /**
         * 移除相关的 div
         * @param element
         */
        removeDiv: function (element) {
            if (element.hasClass('other_place')) {
                if (element.parent().find('.other_place').length === 1) {
                    $('.a4u.a4u-gray').remove();
                }
            } else if (element.hasClass('current_place')) {
                if (element.parent().find('.current_place').length === 1) {
                    $('.a4u.a4u-green').after('<div class="a57"><span>' + js_lang.shop_cart_empty + '</span></div>');
                }
            }
            element.remove();
            if ($('.a57').length === 1 && $('.a4u-gray').length === 0) {
                var index_url = $('input[name="index_url"]').val();
                $('.ecjia-flow-cart-list').html('').html('<div class="flow-no-pro"><div class="ecjia-nolist">' + js_lang.add_goods_yet + '<a class="btn btn-small" type="button" href="' + index_url + '">' + js_lang.go_go + '</a></div>');
            }
        },

        /**
         * 根据传入的商品规格和商品数量来决定显示隐藏商品的数量部分
         * @param spec
         * @param type
         * @param goods_id
         * @param num
         */
        updateProductSpecNumDom: function(spec,type,goods_id,num){
            var good_spec_ele = $('.goods_spec_' + goods_id);
            var n = parseInt(good_spec_ele.children('i').html());
            var ecjia_attr_modal = $('.ecjia-attr-modal');

            if (type && type === 'add') {
                if (spec.length !== undefined) {
                    good_spec_ele.find('.choose_attr').attr('data-spec', spec);
                }
                n = n + 1;
                if (isNaN(n)) n = 1;
                if (good_spec_ele.find('.attr-number').length === 0) {
                    good_spec_ele.append('<i class="attr-number">' + n + '</i>');
                } else {
                    good_spec_ele.find('.attr-number').html(n);
                }
            } else if (type && type === 'reduce') {
                n = n - 1;
                if (n === 0) {
                    good_spec_ele.find('.attr-number').remove();
                    good_spec_ele.children('.choose_attr').attr('data-spec', '');
                } else {
                    good_spec_ele.find('.attr-number').html(n);
                }
            }

            if (num === 0) {
                ecjia_attr_modal.find('.add-tocart').addClass('show').removeClass('hide');
                ecjia_attr_modal.find('#goods_' + this.goods_id).removeClass('show').addClass('hide').children().attr('rec_id', '');
            } else {
                ecjia_attr_modal.find('.add-tocart').removeClass('show').addClass('hide');
                ecjia_attr_modal.find('#goods_' + this.goods_id).addClass('show').removeClass('hide');
                ecjia_attr_modal.find('#goods_' + this.goods_id).children().addClass('show').removeClass('hide');
            }
            ecjia_attr_modal.find('#goods_' + this.goods_id).children('label').html(num);
        },

        /**
         * 更新购物车数据和相关dom
         * @param data
         * @param goods_id
         * @param spec
         * @param num
         */
        updateCartDataAndDom: function (data,goods_id,spec,num) {
            var check_button_ele = $('.a51');// 去结算按钮
            var text = check_button_ele .attr('data-text') === undefined ? js_lang.go_settlement : check_button_ele.attr('data-text');

            if (data.count == null) {
                ecjia.touch.category.hide_cart(true);
            } else {
                ecjia.touch.category.show_cart(true);
                var goods_number = data.count.goods_number;
                var goods_ele = $('#goods_' + goods_id);

                if (spec === '') {
                    for (var i = 0; i < data.list.length; i++) {
                        if (data.say_list) {
                            if (data.list[i].id === goods_id) {
                                goods_ele.children('.reduce').removeClass('hide').attr('rec_id', data.list[i].rec_id);
                                goods_ele.children('label').removeClass('hide').html(data.list[i].goods_number);
                                goods_ele.children('.add').removeClass('hide').attr('rec_id', data.list[i].rec_id);
                                if ($.find('.may_like_' + goods_id)) {
                                    $('.may_like_' + goods_id).attr('rec_id', data.list[i].rec_id);
                                }
                            }
                        }
                        if (data.list[i].is_checked !== 1) {
                            data.count.goods_number -= data.list[i].goods_number;
                        }
                    }
                } else {
                    console.log('----'.spec);
                    goods_ele.children('span').attr('rec_id', data.current.rec_id).removeClass('hide');
                    goods_ele.children('label').removeClass('hide').html(data.current.goods_number);
                }

                if (data.say_list) {
                    $('.minicart-goods-list').html(data.say_list);
                    ecjia.touch.category.change_num();
                }

                $('p.a6c').html(sprintf(js_lang.have_select, data.count.goods_number));
                if (goods_number > 99) {
                    $('.a4x').html('<i class="a4y">99+</i>');
                } else {
                    $('.a4x').html('<i class="a4y">' + goods_number + '</i>');
                }

                if (data.count.goods_number === 0) {
                    check_button_ele.addClass('disabled').html(text);
                } else {
                    check_button_ele.removeClass('disabled');
                    //隐藏加入购物车按钮 显示加减按钮
                    var goods_add_cart_ele = $('.goods-add-cart');
                    var ecjia_goods_plus_box_ele = $('.ecjia-goods-plus-box');
                    if (goods_add_cart_ele.attr('goods_id') === goods_id) {
                        if (spec === '') {
                            if (val > 0) {
                                goods_add_cart_ele.addClass('hide').removeClass('show');
                                ecjia_goods_plus_box_ele.removeClass('hide').addClass('show');
                            } else {
                                goods_add_cart_ele.removeClass('hide').addClass('show');
                                ecjia_goods_plus_box_ele.addClass('hide').removeClass('show');
                            }
                        } else {
                            if (num === 0) num = 1;
                            goods_add_cart_ele.not('.choose_attr').addClass('hide');
                            ecjia_goods_plus_box_ele.removeClass('hide').children('label').html(num);
                            ecjia_goods_plus_box_ele.children().removeClass('hide');
                        }
                    }
                }
                var discount_html = '';
                if (parseFloat(data.count.discount) !== 0) {
                    discount_html = '<label>' + sprintf(js_lang.have_select, data.count.discount) + '<label>';
                }
                $('.a4z').html('<div>' + data.count.goods_price + discount_html + '</div>');
                var check_cart_ele =  $('.check_cart');
                if (data.data_rec) {
                    check_cart_ele.attr('data-rec', data.data_rec);
                    check_cart_ele.removeClass('disabled');
                } else {
                    check_cart_ele.attr('data-rec', '');
                    check_cart_ele.addClass('disabled');
                }
                var count = data.count;
                if (count.meet_min_amount === 1 || !count.label_short_amount) {
                    if (count.real_goods_count > 0) {
                        check_cart_ele.removeClass('disabled').html(text);
                    } else {
                        check_cart_ele.html(text);
                    }
                } else {
                    check_cart_ele.addClass('disabled').html(sprintf(js_lang.deviation_pick_up, count.label_short_amount));
                }

                ecjia.touch.category.add_tocart();
                ecjia.touch.category.remove_tocart();
                ecjia.touch.category.toggle_checkbox();
                //隐藏修改购物车商品数量弹窗
                $('.ecjia-num-content').removeClass('show');
            }
        },

        /**
         * 禁止滚动
         * @param ele
         * @param direction
         * @param is_scroll
         */
        isScroll: function (ele,direction,is_scroll) {
            var overflow_direction = "overflow-";
            if(direction && direction ==='x'){
                overflow_direction += 'x';
            }else{
                overflow_direction += 'y'
            }
            $(ele).css(overflow_direction, (is_scroll || is_scroll ===true) ? 'auto': 'hidden').off('touchmove');
            if(!is_scroll){
                $(ele).on('touchmove', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                }, false);
            }
        }
    };

    /**
     * css 的一些tarnsform 方法
     * @type {{translateY: ecjia.touch.css.translateY, translateX: ecjia.touch.css.translateX}}
     */
    ecjia.touch.css = {
        translateX: function (ele,x) {
            $(ele).css('transform','translateX('+x+'px)');
        },
        translateY: function (ele,x) {
            $(ele).css('transform','translateY('+x+'px)');
        }
    };

})(ecjia, jQuery);

