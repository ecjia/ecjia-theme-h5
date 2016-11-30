<?php
/**
 * ecjia 前端页面控制器父类
 */
defined('IN_ECJIA') or exit('No permission resources.');

class wechart {

    /**
     * 构造函数
     */
    public function __construct() {
    }

    /**
     * 判断是否是微信浏览器
     */
    public static function isWechart(){
        if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
            return true;
        }
        return false;
    }

    /**
     * 设置openid
     * @param [type] $code GET到的code参数
     */
    public function setOpenid($code) {
        // 如果不是微信浏览器，或者微信支付不存在，则直接跳出。
        if (!$this->isWechart() || !RC_Loader::load_plugin_class('WxPayPubHelper', 'pay_wxpay_wap', false)) return false;

        // 如果加载不到微信支付，则直接跳出
        RC_Loader::load_app_class('payment_abstract', 'payment', false);
        $payment_method = RC_Loader::load_app_class('payment_method','payment');
        $payment_info = $payment_method->payment_info_by_code('pay_wxpay_wap');
        if (empty($payment_info)) return false;
        /*取得支付信息，生成支付代码*/
        $payment_config = $payment_method->unserialize_config($payment_info['pay_config']);

        $jsApiPub = new JsApi_pub($payment_config);

        if (empty($code)) {
            $call_url = urlencode(RC_Uri::current_url());
            $url = $jsApiPub->createOauthUrlForCode($call_url);
            ecjia_front::$controller->redirect($url);
            header("Location: ".$url);die;
        }

        $jsApiPub->setCode($code);
        $openid = $jsApiPub->getOpenId();
        $_SESSION['openid'] = $openid;
    }

    /**
     * 获取微信用户信息
     * @return [type] 用户信息或false
     */
    public function getUserinfo() {
        if (!$this->isWechart() || empty($_SESSION['openid'])) return false;

        $openid = $_SESSION['openid'];
        // 查询公众平台账号信息
        // $db = new db();
        $res = array();
        // $res = $db->find();

        if (!empty($res)) {
            return $res;
        } else {
            return false;
        }
    }

}

// end
