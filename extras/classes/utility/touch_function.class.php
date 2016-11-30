<?php

class touch_function
{
    
    //获取token
    public static function get_token($return_all = 0) {
        $rs_token = ecjia_touch_manager::make()->api(ecjia_touch_api::SHOP_TOKEN)->run();
        if ($return_all) {
            return $rs_token;
        } else {
            return $rs_token['access_token'];
        }
    
    }

}