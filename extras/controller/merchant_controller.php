<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 店铺模块控制器代码
 */
class merchant_controller
{

    /**
     * 店铺首页
     */
    public static function init()
    {
        unset($_SESSION['cart']);

        $store_id    = intval($_GET['store_id']);
        $category_id = intval($_GET['category_id']);

        $url = RC_Uri::url('merchant/index/init', array('store_id' => $store_id));
        touch_function::redirect_referer_url($url);

        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages = intval($_GET['page']) ? intval($_GET['page']) : 1;

        $type_name   = '';
        $action_type = !empty($_GET['type']) ? trim($_GET['type']) : '';

        //店铺信息
        $parameter_list = array(
            'seller_id' => $store_id,
//             'location' => array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
            'city_id'   => $_COOKIE['city_id'],
        );
        $store_info = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_CONFIG)->data($parameter_list)->run();
        $store_info = is_ecjia_error($store_info) ? array() : $store_info;

        if (!is_ecjia_error($store_info)) {
            $store_info                                 = merchant_function::format_info_distance($store_info);
            $store_info['comment']['comment_goods_val'] = (float) $store_info['comment']['comment_goods'] / 100;

            if (!empty($store_info['favourable_list'])) {
                $store_info['favourable_count'] = count($store_info['favourable_list']);
            }
            $store_info['shop_address'] = trim($store_info['shop_address']);
            ecjia_front::$controller->assign('store_info', $store_info);
            ecjia_front::$controller->assign_title($store_info['seller_name']);

            ecjia_front::$controller->assign('title', $store_info['seller_name']);
            ecjia_front::$controller->assign('header_left', ' ');

            $map_url   = 'https://3gimg.qq.com/lightmap/v1/marker/index.html?type=0&marker=coord:';
            $url_param = '' . $store_info['location']['latitude'] . ',' . $store_info['location']['longitude'] . ';title:' . $store_info['seller_name'] . ';addr:' . $store_info['shop_address'];
            $url_param = urlencode($url_param);
            $map_url .= $url_param;

            $header_right = array(
                'location'     => '<i class="icon-shop-location"></i>',
                'location_url' => $map_url,
                'search'       => '<i class="icon-shop-search"></i>',
                'search_url'   => RC_Uri::url('touch/index/search', array('store_id' => $store_id)),
            );
            ecjia_front::$controller->assign('header_right', $header_right);
        }

        //获取浏览器后退显示原来的分类
        $store_temp_action_type = $_SESSION['store_temp' . $store_id]['action_type'];

        if ($store_temp_action_type == 'all') {
            $type_name = __('全部', 'h5');
        } elseif ($store_temp_action_type == 'best') {
            $type_name = __('精选', 'h5');
        } elseif ($store_temp_action_type == 'hot') {
            $type_name = __('热销', 'h5');
        } elseif ($store_temp_action_type == 'new') {
            $type_name = __('新品', 'h5');
        }

        if (!empty($store_temp_action_type)) {
            $action_type = $store_temp_action_type;
        } else {
            $action_type = 'all';
        }
        ecjia_front::$controller->assign('action_type', $action_type);

        //店铺分类
        $store_category = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_CATEGORY)->data(array('seller_id' => $store_id))->run();
        if (!is_ecjia_error($store_category)) {
            //默认选中分类
            if (!empty($store_temp_action_type) && is_numeric($store_temp_action_type)) {
                $category_id = $store_temp_action_type;

                foreach ($store_category as $key => $value) {
                    if ($value['id'] == $store_temp_action_type) {
                        $store_category[$key]['checked'] = 1;
                        $type_name                       = $value['name'];
                        break;
                    }
                    if (!empty($value['children'])) {
                        foreach ($value['children'] as $k => $v) {
                            if ($v['id'] == $store_temp_action_type) {
                                $store_category[$key]['checked']                 = 1;
                                $store_category[$key]['children'][$k]['checked'] = 1;
                                $type_name                                       = $v['name'];
                                break;
                            }
                        }
                    }
                }
            }
            ecjia_front::$controller->assign('store_category', $store_category);
        }

        $goods_list = array();
        if (!empty($action_type) && $action_type != 'all' && !is_numeric($action_type)) {
            $parameter = array(
                'action_type' => $action_type,
                'pagination'  => array('count' => $limit, 'page' => $pages),
                'seller_id'   => $store_id,
            );
            $response = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_SUGGESTLIST)->data($parameter)->hasPage()->run();
            if (!is_ecjia_error($response)) {
                list($data, $page) = $response;
                $goods_num         = $page['count'];
                $goods_list        = $data;
            }
        } else {
            //店铺分类商品
            $arr = array(
                'filter'     => array('category_id' => $category_id),
                'pagination' => array('count' => $limit, 'page' => $pages),
                'seller_id'  => $store_id,
            );

            $response = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_LIST)->data($arr)->hasPage()->run();
            if (!is_ecjia_error($response)) {
                list($data, $page) = $response;
                $goods_num         = $page['count'];
                $goods_list        = $data;
            }
            if (empty($category_id)) {
                $type_name = __('全部', 'h5');
            }
        }

        $rec_id = '';
        if ($store_info['shop_closed'] != 1) {
            $token = ecjia_touch_user::singleton()->getToken();
            $arr   = array(
                'token'     => $token,
                'seller_id' => $store_id,
                'location'  => array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
                'city_id'   => $_COOKIE['city_id'],
            );

            RC_Cache::app_cache_delete('cart_goods' . $token . $store_id . $_COOKIE['longitude'] . $_COOKIE['latitude'] . $_COOKIE['city_id'], 'cart');

            //店铺购物车商品
            $cart_list = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($arr)->run();

            $goods_cart_list = array();

            if (!is_ecjia_error($cart_list)) {
                if (!empty($cart_list['cart_list'][0]['goods_list'])) {
                    $cart_list['cart_list'][0]['total']['check_all'] = true;
                    $cart_list['cart_list'][0]['total']['check_one'] = false;
                    foreach ($cart_list['cart_list'][0]['goods_list'] as $k => $v) {
                        if (!empty($v['goods_number'])) {
                            $goods_cart_list[$v['goods_id']] = array('num' => $v['goods_number'], 'rec_id' => $v['rec_id']);
                        }
                        if ($v['is_checked'] == 1 && $v['is_disabled'] == 0) {
                            $cart_list['cart_list'][0]['total']['check_one'] = true; //至少选择了一个
                            if ($k == 0) {
                                $rec_id = $v['rec_id'];
                            } else {
                                $rec_id .= ',' . $v['rec_id'];
                            }
                        } elseif ($v['is_checked'] == 0) {
                            $cart_list['cart_list'][0]['total']['check_all'] = false; //全部选择
                            $cart_list['cart_list'][0]['total']['goods_number'] -= $v['goods_number'];
                        }
                        $rec_id = trim($rec_id, ',');
                    }
                } else {
                    $cart_list['cart_list'][0]['total']['check_all'] = false;
                    $cart_list['cart_list'][0]['total']['check_one'] = false;
                }
            }

            if (!empty($goods_list)) {
                foreach ($goods_list as $k => $v) {
                    if (array_key_exists($v['id'], $goods_cart_list)) {
                        if (!empty($goods_cart_list[$v['id']]['num'])) {
                            $goods_list[$k]['num']    = $goods_cart_list[$v['id']]['num'];
                            $goods_list[$k]['rec_id'] = $goods_cart_list[$v['id']]['rec_id'];
                        }
                    }
                }
            }

            if (ecjia_touch_user::singleton()->isSignin() && !is_ecjia_error($cart_list)) {
                ecjia_front::$controller->assign('cart_list', $cart_list['cart_list'][0]['goods_list']);
                ecjia_front::$controller->assign('count', $cart_list['cart_list'][0]['total']);
                ecjia_front::$controller->assign('real_count', $cart_list['total']);
            }
        }

        ecjia_front::$controller->assign('goods_list', $goods_list);
        ecjia_front::$controller->assign('type_name', $type_name);
        ecjia_front::$controller->assign('goods_num', $goods_num);

        ecjia_front::$controller->assign('store_id', $store_id);
        ecjia_front::$controller->assign('category_id', $category_id);
        ecjia_front::$controller->assign('rec_id', $rec_id);

        if (isset($_COOKIE['location_address_id']) && $_COOKIE['location_address_id'] > 0) {
            ecjia_front::$controller->assign('address_id', $_COOKIE['location_address_id']);
        }
        ecjia_front::$controller->assign('referer_url', urlencode(RC_Uri::url('merchant/index/init', array('store_id' => $store_id))));

        ecjia_front::$controller->assign('url', RC_Uri::url('merchant/index/init', array('store_id' => $store_id)));
        ecjia_front::$controller->assign('follow_url', RC_Uri::url('merchant/index/follow_store', array('store_id' => $store_id)));

        if (user_function::is_weixin()) {
            $protocol   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $spread_url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            $spread_url = strrpos($spread_url, "&_pjax") ? substr($spread_url, 0, strrpos($spread_url, "&_pjax")) : $spread_url;
            ecjia_front::$controller->assign('share_link', $spread_url);

            $config = user_function::get_wechat_config($spread_url);
            ecjia_front::$controller->assign('config', $config);
        }

        $status = !empty($_GET['status']) ? trim($_GET['status']) : '';
        if ($status == 'comment') {
            ecjia_front::$controller->assign('ajax_url', RC_Uri::url('merchant/index/ajax_store_comment', array('store_id' => $store_id)));

            //店铺评论
            $info = array(
                'store_id'     => $store_id,
                'comment_type' => 'all',
                'pagination'   => array('count' => $limit, 'page' => $pages),
            );
            $comments = ecjia_touch_manager::make()->api(ecjia_touch_api::STORE_COMMENTS)->data($info)->hasPage()->run();

            if (!is_ecjia_error($comments)) {
                list($data, $page) = $comments;
                if (isset($page['more']) && $page['more'] == 0) {
                    $is_last = 1;
                }

                ecjia_front::$controller->assign('comment_list', $data);
                ecjia_front::$controller->assign('comment_number', $data['comment_number']);
            }

            ecjia_front::$controller->display('merchant_comment.dwt');
            return false;
        }

        unset($_SESSION['quick_pay']);
        ecjia_front::$controller->assign('status', $status);
        ecjia_front::$controller->assign('ajax_url', RC_Uri::url('merchant/index/ajax_store_comment', array('store_id' => $store_id)));

        ecjia_front::$controller->display('merchant.dwt');
    }

    public static function ajax_store_comment()
    {
        $store_id     = !empty($_GET['store_id']) ? $_GET['store_id'] : 0;
        $limit        = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages        = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $comment_type = !empty($_GET['action_type']) ? $_GET['action_type'] : 'all';

        $info = array(
            'store_id'     => $store_id,
            'comment_type' => $comment_type,
            'pagination'   => array('count' => $limit, 'page' => $pages),
        );
        $comments = ecjia_touch_manager::make()->api(ecjia_touch_api::STORE_COMMENTS)->data($info)->hasPage()->run();

        if (!is_ecjia_error($comments)) {
            list($data, $page) = $comments;
            if (isset($page['more']) && $page['more'] == 0) {
                $is_last = 1;
            }

            ecjia_front::$controller->assign('comment', $data['list']);
            $say_list = ecjia_front::$controller->fetch('merchant_comment.dwt');
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $is_last));
        } else {
            return ecjia_front::$controller->showmessage($comments->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }

    /**
     * 获取店铺商品
     */
    public static function ajax_goods()
    {
        $store_id    = intval($_GET['store_id']);
        $category_id = 0;
        $action_type = '';

        $_SESSION['store_temp' . $store_id]['action_type'] = $_GET['action_type'];
        if (!empty($_GET['action_type']) && is_numeric($_GET['action_type'])) {
            $category_id = intval($_GET['action_type']);
        } else {
            $action_type = trim($_GET['action_type']);
        }

        $type_name = '';
        $limit     = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages     = intval($_GET['page']) ? intval($_GET['page']) : 1;

        if ($action_type == 'best') {
            $type_name = __('精选', 'h5');
        } elseif ($action_type == 'hot') {
            $type_name = __('热销', 'h5');
        } elseif ($action_type == 'new') {
            $type_name = __('新品', 'h5');
        }

        //店铺分类
        $store_category = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_CATEGORY)->data(array('seller_id' => $store_id))->run();

        $goods_num  = 0;
        $goods_list = array();
        if (!empty($action_type) && $action_type != 'all') {
            $parameter = array(
                'action_type' => $action_type,
                'pagination'  => array('count' => $limit, 'page' => $pages),
                'seller_id'   => $store_id,
            );
            $response = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_SUGGESTLIST)->data($parameter)->hasPage()->run();

            if (!is_ecjia_error($response)) {
                list($data, $page) = $response;
                $goods_num         = $page['count'];
                $goods_list        = $data;
            }
        } else {
            //店铺分类商品
            $arr = array(
                'filter'     => array('category_id' => $category_id),
                'pagination' => array('count' => $limit, 'page' => $pages),
                'seller_id'  => $store_id,
            );
            $response = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_GOODS_LIST)->data($arr)->hasPage()->run();
            if (!is_ecjia_error($response)) {
                list($data, $page) = $response;
                $goods_num         = $page['count'];
                $goods_list        = $data;
            }

            if (empty($category_id)) {
                $type_name = __('全部', 'h5');
            } else {
                $type_name = '';
                if (!is_ecjia_error($store_category) && !empty($store_category)) {
                    foreach ($store_category as $k => $v) {
                        if ($v['id'] == $category_id) {
                            $type_name = $v['name'];
                        } else if ($v['children']) {
                            foreach ($v['children'] as $key => $val) {
                                if ($val['id'] == $category_id) {
                                    $type_name = $val['name'];
                                }
                            }
                        }
                    }
                }
            }
        }

        //店铺信息
        $parameter_list = array(
            'seller_id' => $store_id,
            'city_id'   => $_COOKIE['city_id'],
        );
        $store_info = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_CONFIG)->data($parameter_list)->run();
        $store_info = is_ecjia_error($store_info) ? array() : $store_info;

        if ($store_info['shop_closed'] != 1) {
            $token = ecjia_touch_user::singleton()->getToken();
            $arr   = array(
                'token'     => $token,
                'seller_id' => $store_id,
                'location'  => array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
                'city_id'   => $_COOKIE['city_id'],
            );

            //店铺购物车商品
            $cart_list = RC_Cache::app_cache_get('cart_goods' . $token . $store_id . $_COOKIE['longitude'] . $_COOKIE['latitude'] . $_COOKIE['city_id'], 'cart');

            if (empty($cart_list['cart_list'])) {
                $cart_list = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($arr)->run();
                if (!is_ecjia_error($cart_list) && ecjia_touch_user::singleton()->isSignin()) {
                    RC_Cache::app_cache_set('cart_goods' . $token . $store_id . $_COOKIE['longitude'] . $_COOKIE['latitude'] . $_COOKIE['city_id'], $cart_list, 'cart');
                } else {
                    $cart_list = array();
                }
            }

            $goods_cart_list = array();
            if (!empty($cart_list)) {
                if (!empty($cart_list['cart_list'][0]['goods_list'])) {
                    foreach ($cart_list['cart_list'][0]['goods_list'] as $k => $v) {
                        $goods_attr_id = array();
                        if (!empty($v['goods_attr_id'])) {
                            $goods_attr_id = explode(',', $v['goods_attr_id']);
                            asort($goods_attr_id);
                        }
                        $goods_cart_list['arr'][$v['goods_id']][] = array('num' => $v['goods_number'], 'rec_id' => $v['rec_id'], 'goods_attr_id' => $goods_attr_id);
                    }
                }
            }

            $spec_goods = array();
            if (!empty($goods_list)) {
                foreach ($goods_list as $k => $v) {
                    if (!empty($v['specification'])) {
                        $spec_goods[$v['id']]['goods_price']            = ltrim((!empty($v['promote_price']) ? $v['promote_price'] : ($v['shop_price'] == __('免费', 'h5') ? '0' : $v['shop_price'])), '￥');
                        $spec_goods[$v['id']]['goods_info']             = $v;
                        $spec_goods[$v['id']]['goods_info']['goods_id'] = $v['id'];
                    }
                    if (array_key_exists($v['id'], $goods_cart_list['arr'])) {
                        foreach ($goods_cart_list['arr'][$v['id']] as $j => $n) {
                            $goods_list[$k]['num'] += $n['num'];
                            if (empty($n['goods_attr_id'])) {
                                $goods_list[$k]['rec_id'] = $n['rec_id'];
                            }

                            if (!empty($n['goods_attr_id']) && !isset($goods_list[$k]['default_spec'])) {
                                $goods_list[$k]['default_spec'] = implode(',', $n['goods_attr_id']);
                            }
                        }
                    }
                    $goods_list[$k]['store_id'] = $store_id;
                }
            }

            if ($pages == 1) {
                ecjia_front::$controller->assign('page', $pages);
                ecjia_front::$controller->assign('type_name', $type_name);
                ecjia_front::$controller->assign('goods_num', $goods_num);
            }

            if (isset($page['total']) && $page['total'] == 0) {
                $goods_list = array();
            }
        }

        ecjia_front::$controller->assign('goods_list', $goods_list);
        ecjia_front::$controller->assign('shop_closed', $store_info['shop_closed']);

        $say_list = ecjia_front::$controller->fetch('library/merchant_goods.lbi');
        if (isset($page['more']) && $page['more'] == 0) {
            $data['is_last'] = 1;
        }

        $response = array(
            'list'       => $say_list,
            'goods_list' => $goods_list,
            'name'       => $type_name,
            'num'        => $goods_num,
            'type'       => $action_type,
            'is_last'    => $data['is_last'],
            'spec_goods' => $spec_goods,
        );
        return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $response);
    }

    /**
     * 店铺位置
     */
    public static function position()
    {
        $cache_id = sprintf('%X', crc32($_SERVER['QUERY_STRING']));

        if (!ecjia_front::$controller->is_cached('merchant_position.dwt', $cache_id)) {
            $shop_address = $_GET['shop_address'];
            ecjia_front::$controller->assign('shop_address', $shop_address);
            ecjia_front::$controller->assign_title(__('店铺位置', 'h5'));
        }
        ecjia_front::$controller->display('merchant_position.dwt', $cache_id);
    }

    /**
     * 店铺列表
     */
    public static function seller_list()
    {
        $cid   = intval($_GET['cid']);
        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $pages = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $type  = isset($_GET['type']) ? $_GET['type'] : ''; //判断是否是下滑加载

        if ($type == 'ajax_get') {
            $arr = array(
                'pagination' => array('count' => $limit, 'page' => $pages),
                'location'   => array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
                'city_id'    => $_COOKIE['city_id'],
            );
            $arr['category_id'] = $cid;
            $response           = ecjia_touch_manager::make()->api(ecjia_touch_api::SELLER_LIST)->data($arr)->hasPage()->run();
            if (!is_ecjia_error($response)) {
                list($data, $page) = $response;
                $arr_list          = merchant_function::format_distance($data);

                ecjia_front::$controller->assign('data', $arr_list);
                $say_list = ecjia_front::$controller->fetch('seller_list.dwt');

                if (isset($page['more']) && $page['more'] == 0) {
                    $data['is_last'] = 1;
                }

                return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('list' => $say_list, 'is_last' => $data['is_last']));
            }
        }

        ecjia_front::$controller->assign_title(__('店铺列表', 'h5'));
        ecjia_front::$controller->assign('cid', $cid);
        ecjia_front::$controller->display('seller_list.dwt');
    }

    public static function collectmoney()
    {
        $store_id = intval($_GET['store_id']);

        //店铺信息
        $parameter_list = array(
            'seller_id' => $store_id,
            'city_id'   => $_COOKIE['city_id'],
        );
        $store_info = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_CONFIG)->data($parameter_list)->run();
        $store_info = !is_ecjia_error($store_info) ? $store_info : array();

        ecjia_front::$controller->assign('store_info', $store_info);
        ecjia_front::$controller->assign('store_id', $store_id);

        ecjia_front::$controller->assign_title(sprintf(__("%s在线买单", 'h5'), $store_info['seller_name']));
        ecjia_front::$controller->assign('title', sprintf(__("%s在线买单", 'h5'), $store_info['seller_name']));

        if (empty($_SESSION['wxpay_open_id']) && cart_function::is_weixin()) {
            //提前获取微信支付wxpay_open_id
            $handler                   = with(new Ecjia\App\Payment\PaymentPlugin)->channel('pay_wxpay');
            $open_id                   = $handler->getWechatOpenId();
            $_SESSION['wxpay_open_id'] = $open_id;
        }

        $direct_pay = false;
        if (cart_function::is_weixin() || cart_function::is_alipay()) {
            $params       = array('store_id' => $store_id);
            $payment_list = ecjia_touch_manager::make()->api(ecjia_touch_api::MERCHANT_SHOP_PAYMENT)->data($params)->run();
            $payment_list = !is_ecjia_error($payment_list) ? $payment_list : array();
            /*根据浏览器过滤支付方式，微信自带浏览器过滤掉支付宝支付，其他浏览器过滤掉微信支付*/

            $payment = array();
            if (!empty($payment_list['payment'])) {
                if (cart_function::is_weixin()) {
                    $direct_pay = true;
                    foreach ($payment_list['payment'] as $key => $val) {
                        if ($val['pay_code'] == 'pay_wxpay') {
                            $payment = $payment_list['payment'][$key];
                        }
                    }
                } elseif (cart_function::is_alipay()) {
                    $direct_pay = true;
                    foreach ($payment_list['payment'] as $key => $val) {
                        if ($val['pay_code'] == 'pay_alipay') {
                            $payment = $payment_list['payment'][$key];
                        }
                    }
                }
            }
            ecjia_front::$controller->assign('payment', $payment);
        }
        ecjia_front::$controller->assign('direct_pay', $direct_pay);

        ecjia_front::$controller->display('quickpay_collectmoney.dwt');
    }

    public static function follow_store()
    {
        $url       = RC_Uri::site_url() . substr($_SERVER['HTTP_REFERER'], strripos($_SERVER['HTTP_REFERER'], '/'));
        $login_str = user_function::return_login_str();

        $referer_url = RC_Uri::url($login_str, array('referer_url' => urlencode($url)));
        if (!ecjia_touch_user::singleton()->isSignin()) {
            return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('referer_url' => $referer_url));
        }

        $store_id = intval($_GET['store_id']);
        $type     = intval($_POST['type']);

        if ($type == 1) {
            $message = __('关注成功', 'h5');
            $api_url = ecjia_touch_api::STORE_COLLECT_CREATE;
        } else {
            $message = __('取消关注成功', 'h5');
            $api_url = ecjia_touch_api::STORE_COLLECT_CANCEL;
        }
        $token = ecjia_touch_user::singleton()->getToken();

        $response = ecjia_touch_manager::make()->api($api_url)->data(array('token' => $token, 'store_id' => $store_id))->run();
        if (is_ecjia_error($response)) {
            return ecjia_front::$controller->showmessage($response->get_error_message(), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        return ecjia_front::$controller->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS);
    }
}

// end
