<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-04-17
 * Time: 19:53
 */

class ecjia_goods_specification
{

    /**
     * 缓存key
     * @var string
     */
    private $storage_key;

    /**
     * 登录token
     * @var
     */
    private $token;

    private $goods_id;

    public function __construct($goods_id, $token = null)
    {

        if (is_null($token)) {
            $this->token = $token;
        } else {
            $this->token = ecjia_touch_user::singleton()->getToken();
        }

        $this->goods_id = $goods_id;

        $this->storage_key = sprintf('%X', crc32('goods_product_specification_' . $this->token . $this->goods_id));
    }


    /**
     * 存储购物车缓存数据
     */
    public function saveLocalStorage($spec_list)
    {
        RC_Cache::app_cache_set($this->storage_key, $spec_list, 'goods');
    }

    /**
     * 取出购物车缓存数据
     */
    public function getLocalStorage()
    {
        //店铺购物车商品
        $cart_list = RC_Cache::app_cache_get($this->storage_key, 'goods');

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
        RC_Cache::app_cache_delete($this->storage_key, 'goods');
    }


    /**
     * 获取线上购物车数据
     * @return array|ecjia_error
     */
    public function getServerCartData()
    {
        $arr = array(
            'token'    => $this->token,
            'goods_id' => $this->goods_id,
        );

        $cart_list = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_PRODUCT_SPECIFICATION)->data($arr)->run();
        if (!is_ecjia_error($cart_list)) {
            $this->saveLocalStorage($cart_list);
        } else {
            $cart_list = array();
        }

        return $cart_list;
    }


}