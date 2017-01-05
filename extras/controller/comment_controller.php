<?php
/**
 * 评论模块控制器代码
 */
class comment_controller {

    /**
     * 商品评论列表
     */
    public static function init() {
        ecjia_front::$controller->display('goods_comment_list.dwt');
    }

    /**
     * 异步加载评论列表
     */
    public  static  function async_comment_list(){}

    /**
     * 添加商品评论
     */
     public static function add_comment() {}
}

// end