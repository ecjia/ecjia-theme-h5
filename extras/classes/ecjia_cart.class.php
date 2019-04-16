<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-15
 * Time: 15:47
 */

class ecjia_cart
{
    /**
     * 缓存key
     * @var string
     */
    private $storage_key;

    /**
     * 店铺ID
     * @var
     */
    private $store_id;

    /**
     * 登录token
     * @var
     */
    private $token;

    /**
     * 城市ID
     * @var
     */
    private $city_id;

    /**
     * 经度
     * @var
     */
    private $longitude;

    /**
     * 纬度
     * @var
     */
    private $latitude;

    public function __construct($store_id, $token = null)
    {
        $this->store_id = $store_id;

        if (is_null($token)) {
            $this->token = $token;
        } else {
            $this->token = ecjia_touch_user::singleton()->getToken();
        }

        $this->longitude = $_COOKIE['longitude'];
        $this->latitude  = $_COOKIE['latitude'];
        $this->city_id   = $_COOKIE['city_id'];

        $this->storage_key = 'cart_goods' . $this->token . $store_id . $this->longitude . $this->latitude . $this->city_id;
    }

    /**
     * 存储购物车缓存数据
     */
    public function saveLocalStorage($cart_list)
    {
        RC_Cache::app_cache_set($this->storage_key, $cart_list, 'cart');
    }

    /**
     * 取出购物车缓存数据
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
     * 删除购物车缓存数据
     */
    public function deleteLocalStorage()
    {
        RC_Cache::app_cache_delete($this->storage_key, 'cart');
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
            'location'  => array('longitude' => $this->longitude, 'latitude' => $this->latitude),
            'city_id'   => $this->city_id,
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
            //单店铺购物车
            $item = array_shift($cart_list['cart_list']);

            $goods_cart_list = collect($item['goods_list'])->map(function ($item2) {
                $goods_attr_id = array();
                if (!empty($item2['goods_attr_id'])) {
                    $goods_attr_id = explode(',', $item2['goods_attr_id']);
                    asort($goods_attr_id);
                }

                return array(
                    'num'           => $item2['goods_number'],
                    'rec_id'        => $item2['rec_id'],
                    'goods_id'      => $item2['goods_id'],
                    'product_id'    => $item2['product_id'] ?: 0,
                    'goods_attr_id' => $goods_attr_id
                );
            })->all();

        }

        return $goods_cart_list;
    }

    /**
     * 匹配购物车中的商品数据
     * @param $goods_id
     * @param $product_id
     * @param $goods_cart_list
     */
    public function matchingGoodsWithProduct($goods_id, $product_id, $goods_cart_list)
    {
        return collect($goods_cart_list)->contains(function ($item) use ($goods_id, $product_id) {
            return $item['goods_id'] == $goods_id && $item['product_id'] == $product_id;
        });
    }

    public function findGoodsWithProduct($goods_id, $product_id, $goods_cart_list)
    {
        return collect($goods_cart_list)->first(function ($item) use ($goods_id, $product_id) {
            return $item['goods_id'] == $goods_id && $item['product_id'] == $product_id;
        });
    }

    /**
     * 添加商品到购物车
     * @param $goods_id
     * @param int $product_id
     * @return array|ecjia_error
     */
    public function createCart($goods_id, $product_id = 0, $spec = null, $number = 1)
    {
        $data = array(
            'token'      => $this->token,
            'location'   => array('longitude' => $this->longitude, 'latitude' => $this->latitude),
            'city_id'    => $this->city_id,
            'seller_id'  => $this->store_id,
            'goods_id'   => $goods_id,
            'product_id' => $product_id,
            'number'     => $number,
        );

        if ($spec != 'false' && !empty($spec)) {
            $data['spec'] = $spec;
        }

        $result = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_CREATE)->data($data)->run();


        return $result;
    }

    /**
     * 从购物车中删除商品
     * @param $rec_id
     */
    public function deleteCart($rec_id)
    {

        $data = array(
            'token'     => $this->token,
            'location'  => array('longitude' => $this->longitude, 'latitude' => $this->latitude),
            'city_id'   => $this->city_id,
            'seller_id' => $this->store_id,
            'rec_id'    => $rec_id,
        );

        $result = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_DELETE)->data($data)->run();

        return $result;
    }

    /**
     * 更新购物车中商品
     * @param $rec_id
     */
    public function updateCart($rec_id, $number)
    {
        $data = array(
            'token'      => $this->token,
            'location'   => array('longitude' => $this->longitude, 'latitude' => $this->latitude),
            'city_id'    => $this->city_id,
            'seller_id'  => $this->store_id,
            'rec_id'     => $rec_id,
            'new_number' => $number,
        );

        $result = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_UPDATE)->data($data)->run();

        return $result;
    }

    /**
     * 清空购物车
     * @param array $rec_ids 多个rec_id
     */
    public function clearCart(array $rec_ids)
    {
        $rec_id = implode(',', $rec_ids);

        return $this->deleteCart($rec_id);
    }

    /**
     * 修改购物车中商品选中状态
     * @param $rec_id
     */
    public function checkedCart($rec_id, $checked = 1)
    {
        if (is_array($rec_id)) {
            $rec_id = implode(',', $rec_id);
        }

        $data = array(
            'token'      => $this->token,
            'location'   => array('longitude' => $this->longitude, 'latitude' => $this->latitude),
            'city_id'    => $this->city_id,
            'seller_id'  => $this->store_id,
            'rec_id'     => $rec_id,
            'is_checked' => $checked,
        );

        $result = ecjia_touch_manager::make()->api(ecjia_touch_api::CART_CHECKED)->data($data)->run();

        return $result;
    }


}