<?php
/**
 * 主题框架基础控制器
 */
RC_Loader::load_theme('extras/functions/touch/front_global.func.php');
RC_Loader::load_theme('extras/functions/touch/front_index.func.php');

if (ROUTE_M == 'user') {
    RC_Loader::load_theme('extras/class/user/user_front.class.php');
    class front_controller extends user_front {
        public function __construct() {
            parent::__construct();
            if (ROUTE_C == 'user_account') {
                RC_Loader::load_theme('extras/functions/user/front_account.func.php');
            } elseif (ROUTE_C == 'user_address') {
                RC_Loader::load_theme('extras/functions/user/front_addres.func.php');
            } elseif (ROUTE_C == 'user_bonus') {
                RC_Loader::load_theme('extras/functions/user/front_bonus.func.php');
            } elseif (ROUTE_C == 'user_booking') {
                RC_Loader::load_theme('extras/functions/user/front_booking.func.php');
            } elseif (ROUTE_C == 'user_collection') {
                // 构造函数
            } elseif (ROUTE_C == 'user_comment') {
                // 构造函数
            } elseif (ROUTE_C == 'user_merchant') {
                // 构造函数
            } elseif (ROUTE_C == 'user_message') {
                RC_Loader::load_theme('extras/functions/user/front_message.func.php');
            } elseif (ROUTE_C == 'user_order') {
                RC_Loader::load_theme('extras/functions/user/front_order.func.php');
            } elseif (ROUTE_C == 'user_package') {
                RC_Loader::load_theme('extras/functions/user/front_package.func.php');
            } elseif (ROUTE_C == 'user_profile') {
                RC_Loader::load_theme('extras/functions/user/front_profile.func.php');
            } elseif (ROUTE_C == 'user_share') {
                RC_Loader::load_theme('extras/functions/user/front_share.func.php');
            } elseif (ROUTE_C == 'user_tag') {
                RC_Loader::load_theme('extras/functions/user/front_tag.func.php');
            }
        }
    }
} else {
    class front_controller extends ecjia_front {
        public function __construct() {
            parent::__construct();
            if (ROUTE_M == 'cart' && ROUTE_C == 'index') {
                RC_Loader::load_theme('extras/functions/cart/front_global.func.php');
                RC_Loader::load_theme('extras/functions/cart/front_cart.func.php');
            } elseif (ROUTE_M == 'cart' && ROUTE_C == 'flow') {
                RC_Loader::load_theme('extras/functions/cart/front_global.func.php');
                RC_Loader::load_theme('extras/functions/cart/front_cart.func.php');
                RC_Loader::load_theme('extras/functions/cart/front_flow.func.php');
            } elseif (ROUTE_M == 'comment' && ROUTE_C == 'index') {
                RC_Loader::load_theme('extras/functions/comment/front_comment.func.php');
            } elseif (ROUTE_M == 'favourable' && ROUTE_C == 'index') {
                RC_Loader::load_theme('extras/functions/favourable/front_favourable.func.php');
            } elseif (ROUTE_M == 'goods' && ROUTE_C == 'index') {
                RC_Loader::load_theme('extras/functions/goods/front_global.func.php');
                RC_Loader::load_theme('extras/functions/goods/front_goods.func.php');
            } elseif (ROUTE_M == 'goods' && ROUTE_C == 'category') {
                RC_Loader::load_theme('extras/functions/goods/front_global.func.php');
                RC_Loader::load_theme('extras/functions/goods/front_category.func.php');
                RC_Loader::load_theme('extras/class/goods/goods_category.class.php');
            }elseif (ROUTE_M == 'article') {
                RC_Loader::load_theme('extras/functions/article/front_article.func.php');
            }
        }
    }
}

// end
