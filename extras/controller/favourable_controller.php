<?php
/**
* 优惠活动模块控制器代码
*/
class favourable_controller {

    /**
     * 优惠活动 列表
     */
    public static function init() {
        ecjia_front::$controller->display('activity.dwt');
    }

    /**
     * 优惠活动 - 活动商品列表
     */
    public static function goods_list() {
        ecjia_front::$controller->display('activity_goods_list.dwt');
    }

    /**
    * 处理参数便于搜索商品信息
    */
    private static function parameter() {}
}

// end