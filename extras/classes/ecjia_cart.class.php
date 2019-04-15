<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-15
 * Time: 15:47
 */

class ecjia_cart
{

    private $storage_key;

    private $store_id;

    private $token;

    public function __construct($store_id, $token = null)
    {
        $this->store_id = $store_id;

        if (is_null($token)) {
            $this->token = $token;
        } else {
            $this->token = ecjia_touch_user::singleton()->getToken();
        }

        $longitude = $_COOKIE['longitude'];
        $latitude = $_COOKIE['latitude'];
        $city_id = $_COOKIE['city_id'];

        $this->storage_key = 'cart_goods' . $this->token . $store_id . $longitude . $latitude . $city_id;
    }

    /**
     * 存储购物车数据
     */
    public function saveLocalStorage($cart_list)
    {
        RC_Cache::app_cache_set($this->storage_key, $cart_list, 'cart');
    }

    /**
     * 取出购物车数据
     */
    public function getLocalStorage()
    {
        //店铺购物车商品
        $cart_list = RC_Cache::app_cache_get($this->storage_key, 'cart');

        if (empty($cart_list['cart_list'])) {
            return $this->getServerCartData();
        }

        return $cart_list;
    }

    /**
     * 获取线上购物车数据
     * @return array|ecjia_error
     */
    public function getServerCartData()
    {
        $arr = array(
            'token'     => $this->token,
            'seller_id' => $this->store_id,
            'location'  => array('longitude' => $_COOKIE['longitude'], 'latitude' => $_COOKIE['latitude']),
            'city_id'   => $_COOKIE['city_id'],
        );

        $cart_list = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_LIST)->data($arr)->run();
        if (!is_ecjia_error($cart_list) && ecjia_touch_user::singleton()->isSignin()) {
            $this->saveLocalStorage($cart_list);
        } else {
            $cart_list = array();
        }

        return $cart_list;
    }


    public function getGoodsCartList($cart_list)
    {
        $goods_cart_list = array();
        if (!empty($cart_list)) {

            collect($cart_list['cart_list'])->map(function($item) use (& $goods_cart_list) {
//                dd($item['goods_list']);


                $arr = collect($item['goods_list'])->map(function($item2) {
                    $goods_attr_id = array();
                    if (!empty($item2['goods_attr_id'])) {
                        $goods_attr_id = explode(',', $item2['goods_attr_id']);
                        asort($goods_attr_id);
                    }

//                    return array(
//                        'num' => $item2['goods_number'],
//                        'rec_id' => $item2['rec_id'],
//                        'goods_attr_id' => $goods_attr_id
//                    );

                    return array(
                        'num'           => $item2['goods_number'],
                        'rec_id'        => $item2['rec_id'],
                        'goods_id'      => $item2['goods_id'],
                        'product_id'    => $item2['product_id'] ?: 0,
                        'goods_attr_id' => $goods_attr_id
                    );
                })->all();

//                dd($arr);
                $goods_cart_list['arr'][] = $arr;
            });



//            if (!empty($cart_list['cart_list'][0]['goods_list'])) {
//                foreach ($cart_list['cart_list'][0]['goods_list'] as $k => $v) {
//                    $goods_attr_id = array();
//                    if (!empty($v['goods_attr_id'])) {
//                        $goods_attr_id = explode(',', $v['goods_attr_id']);
//                        asort($goods_attr_id);
//                    }
//                    $goods_cart_list['arr'][$v['goods_id']][] = array('num' => $v['goods_number'], 'rec_id' => $v['rec_id'], 'goods_attr_id' => $goods_attr_id);
//                }
//            }
        }

        return $goods_cart_list;
    }


}