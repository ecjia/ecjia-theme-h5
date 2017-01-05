<?php
/**
 * 分享推荐模块控制器代码
 */
class user_share_controller {

    /**
     * 分享推荐
     */
    public static function share() {
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_share.dwt');
    }

    /**
     * 生成二维码
     */
    public static function create_qrcode() {}
}

// end