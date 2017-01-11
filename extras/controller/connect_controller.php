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
 * 第三方登录callback处理
 * @author huangyuyuan@ecmoban.com
 *
 */
class connect_controller {
    
    /**
     * 回调显示
     * @param unknown $data
     */
    public static function callback_template($data) {
        RC_Logger::getlogger('debug')->info('callback_template');
        RC_Logger::getlogger('debug')->info($data);

        if (is_ecjia_error($data)) {
            //错误
            $msg = '登录授权失败，请使用其他方式登录';
            return ecjia_front::$controller->showmessage($msg, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        
        ecjia_front::$controller->assign('authorize_login', true);
        
        //成功
//         $msg = '授权登录成功！';
//         $login = array( 'url' => $data['login_url'], 'info' => '直接登录');
        
        if (empty($data['connect_code']) || empty($data['open_id'])) {
            return ecjia_front::$controller->showmessage('授权信息异常，请重新授权', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        RC_Loader::load_app_class('connect_user', 'connect', false);
        $connect_user = new connect_user($data['connect_code'], $data['open_id']);
        $user_info = $connect_user->get_openid();
        
        RC_Logger::getlogger('debug')->info($user_info);
        
        if ($data['connect_code'] && $data['connect_code'] == 'sns_qq') {
            $user_img = $user_info['profile']['figureurl_qq_2'];
            $user_name = $user_info['profile']['nickname'];
        } else if ($data['connect_code'] && ( $data['connect_code'] == 'sns_wechat' || $data['connect_code'] == 'sns_wechat_platform')) {
            $user_img = $user_info['profile']['headimgurl'];
            $user_name = $user_info['profile']['nickname'];
        }
        
        ecjia_front::$controller->assign('connect_code',$data['connect_code']);
        ecjia_front::$controller->assign('user_info', $user_info);
        ecjia_front::$controller->assign('user_img', $user_img);
        ecjia_front::$controller->assign('user_name', $user_name);
        
        //$data['open_id']
        //快速注册修改
//         $url['bind_signup'] = str_replace('/notify/', '/', RC_Uri::url('user/privilege/bind_signup', array('connect_code' => $data['connect_code'], 'open_id' => $data['open_id'])));
        $url['bind_signup'] = str_replace('/notify/', '/', $data['login_url']);
        $url['bind_signin'] = str_replace('/notify/', '/', RC_Uri::url('connect/index/bind_signin', array('connect_code' => $data['connect_code'], 'open_id' => $data['open_id'])));
        ecjia_front::$controller->assign('url', $url);
        //         ecjia_front::$controller->assign('login',$login);
        //         show_message($msg, array('绑定已有账号'), array($data['bind_url']), 'info', false);
        //         return file_get_contents (RC_Theme::get_template_directory().'/user_bind_signin.dwt.php');
        return ecjia_front::$controller->fetch ('user_bind_login.dwt.php');
    }
    
    /**
     * 授权用户绑定已有账号
     * 
     */
//     public static function user_bind($get) {
//         ecjia_front::$controller->assign('page_title', "授权登录账号绑定-".ecjia::config('shop_name'));
//         ecjia_front::$controller->assign('get', $get);
//         ecjia_front::$controller->assign('shop_address', "上海市普陀区中山北路3553号伸大厦3层");
//         //copyright
//         return file_get_contents (RC_Theme::get_template_directory().'/user_bind.dwt.php');
//     }

    public static function dump_user_info(){
        $code = $_GET['code'];
        $appsecret = 'f5f9db6dfb1565d61528c749d6fdb4f3';
        $appid = 'wx7daa4b18c79dcd49';
        $referer = empty($_GET['referer'])? 'init' : $_GET['referer'];
        $id = empty($_GET['id'])? '' : intval($_GET['id']);
        $token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$appid.'&secret='.$appsecret.'&code='.$code.'&grant_type=authorization_code';
        $token_temp = file_get_contents($token_url);
        $token = json_decode($token_temp);
        if (isset($token->errcode)) {
            echo '<h1>错误：</h1>'.$token->errcode;
            echo '<br/><h2>错误信息：</h2>'.$token->errmsg;
            exit;
        }
    
        $access_token_url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid='.$appid.'&grant_type=refresh_token&refresh_token='.$token->refresh_token;
        $access_token_url_temp = file_get_contents($access_token_url);
        $access_token = json_decode($access_token_url_temp);
        if (isset($access_token->errcode)) {
            echo '<h1>错误：</h1>'.$access_token->errcode;
            echo '<br/><h2>错误信息：</h2>'.$access_token->errmsg;
            exit;
        }
    
        $user_info_url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token->access_token.'&openid='.$access_token->openid.'&lang=zh_CN';
        $user_info_temp = file_get_contents($user_info_url);
        $user_info = json_decode($user_info_temp);
        if (isset($user_info->errcode)) {
            echo '<h1>错误：</h1>'.$user_info->errcode;
            echo '<br/><h2>错误信息：</h2>'.$user_info->errmsg;
            exit;
        }
        $arr = array();
        if(!empty($id)){
            $arr = array('id' => $id);
        }
        _dump($user_info,1);
        $url = RC_Uri::url('event/index/'.$referer, $arr);
        $_SESSION['openid'] = $user_info->openid;
        ecjia_front::$controller->redirect($url);
    
    }
    
    /* 第三方登陆 */
    public static function bind_login() {
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_bind_login.dwt');
    }
    
    /* 第三方登陆快速注册 */
    public static function bind_signup($params) {
    
        $connect_code = !empty($_GET['connect_code']) ? trim($_GET['connect_code']) : '';
        $open_id = !empty($_GET['open_id']) ? trim($_GET['open_id']) : '';
    
        if (!$params) {
            if (empty($connect_code) || empty($open_id)) {
                return ecjia_front::$controller->showmessage('授权信息异常，请重新授权', ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
            }
            ecjia_front::$controller->assign('connect_code', $connect_code);
            ecjia_front::$controller->assign('open_id', $open_id);
    
            ecjia_front::$controller->assign('title', "注册绑定");
            ecjia_front::$controller->assign_title("注册绑定");
            ecjia_front::$controller->assign_lang();
            ecjia_front::$controller->display('user_bind_signup.dwt');
        } else {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_SIGNUP)->data(array('name' => $params['name'], 'password' => $params['password'], 'email' => $params['email']))->send()->getBody();
            $data = json_decode($data, true);
            if ($data['status']['succeed'] != 1) {
                return new ecjia_error($data['status']['error_code'], $data['status']['error_desc']);
            }
    
            RC_Loader::load_app_class('connect_user', 'connect', false);
            $connect_user = new connect_user($connect_code, $open_id);
            /* 获取远程用户头像信息*/
            $user_info = $connect_user->get_openid();
            if ($connect_code == 'sns_qq') {
                $head_img = $user_info['profile']['figureurl_qq_2'];
            } else if ($connect_code == 'sns_wechat') {
                $head_img = $user_info['profile']['headimgurl'];
            }
            RC_Logger::getlogger('debug')->info('关联');
            RC_Logger::getlogger('debug')->info($user_info);
            RC_Logger::getlogger('debug')->info($head_img);
            if ($head_img) {
                RC_Api::api('connect', 'update_user_avatar', array('avatar_url' => $head_img));
            }
            return $data['data']['session']['uid'];
        }
    
    }
    
    public static function bind_signup_do() {
        //验证邀请码验证码
        $verification = !empty($_POST['verification']) ? trim($_POST['verification']) : '';
        $mobile = !empty($_POST['mobile']) ? trim($_POST['mobile']) : '';
        $username = !empty($_POST['username']) ? trim($_POST['username']) : '';
        $password = !empty($_POST['password']) ? trim($_POST['password']) : '';
        $code = !empty($_POST['code']) ? trim($_POST['code']) : '';
    
        $connect_code = !empty($_POST['connect_code']) ? trim($_POST['connect_code']) : '';
        $open_id = !empty($_POST['open_id']) ? trim($_POST['open_id']) : '';
    
        if (empty($mobile) || empty($username) || empty($password) || empty($code)) {
            return ecjia_front::$controller->showmessage('请填写完整信息', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if (empty($connect_code) || empty($open_id)) {
            return ecjia_front::$controller->showmessage('授权信息异常，请重新授权', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    
        if (strlen($verification) > 6) {
            return ecjia_front::$controller->showmessage('邀请码格式不正确', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::VALIDATE_BIND)->data(array('type' => 'mobile', 'value' => $mobile, 'code' => $code))->send()->getBody();
        $data = json_decode($data, true);
        if ($data['status']['succeed'] != 1) {
            return ecjia_front::$controller->showmessage($data['status']['error_desc'], ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
        if ($data['data']['registered'] == 1) {
            return ecjia_front::$controller->showmessage(__('该手机号已被注册，请更换其他手机号'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    
        //注册
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::USER_SIGNUP)->data(array('name' => $username, 'mobile' => $mobile, 'password' => $password, 'invite_code' => $verification))->send()->getBody();
        $data = json_decode($data,true);
        if ($data['status']['succeed'] != 1) {
            return ecjia_front::$controller->showmessage($data['status']['error_desc'], ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    
        //绑定第三方
        $user_id = $data['data']['user']['id'];
    
        RC_Loader::load_app_class('connect_user', 'connect', false);
        $connect_user = new connect_user($connect_code, $open_id);
        if ($user_id) {
            $result = $connect_user->bind_user($user_id, 0);
        }
        if ($result) {
            //登录
            ecjia_touch_user::singleton()->signin($username, $password);
            /* 获取远程用户头像信息*/
            $user_info = $connect_user->get_openid();
            if ($connect_code == 'sns_qq') {
                $head_img = $user_info['profile']['figureurl_qq_2'];
            } else if ($connect_code == 'sns_wechat') {
                $head_img = $user_info['profile']['headimgurl'];
            }
            if ($head_img) {
                RC_Api::api('connect', 'update_user_avatar', array('avatar_url' => $head_img));
            }
            return ecjia_front::$controller->showmessage('恭喜您，注册成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => RC_Uri::url('touch/my/init')));
        } else {
            return ecjia_front::$controller->showmessage('授权用户信息关联失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    }
    
    /* 第三方登陆绑定关联 */
    public static function bind_signin() {
        $connect_code = !empty($_GET['connect_code']) ? trim($_GET['connect_code']) : '';
        $open_id = !empty($_GET['open_id']) ? trim($_GET['open_id']) : '';
        if (empty($connect_code) || empty($open_id)) {
            return ecjia_front::$controller->showmessage('授权信息异常，请重新授权', ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR);
        }
        ecjia_front::$controller->assign('connect_code', $connect_code);
        ecjia_front::$controller->assign('open_id', $open_id);
    
        ecjia_front::$controller->assign('title', "验证并关联");
        ecjia_front::$controller->assign_title("验证并关联");
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_bind_signin.dwt');
    }
    public static function bind_signin_do() {
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
    
        $connect_code = !empty($_POST['connect_code']) ? trim($_POST['connect_code']) : '';
        $open_id = !empty($_POST['open_id']) ? trim($_POST['open_id']) : '';
        if (empty($connect_code) || empty($open_id)) {
            return ecjia_front::$controller->showmessage('授权信息异常，请重新授权', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    
        if (empty($username) || empty($password)) {
            return ecjia_front::$controller->showmessage('请填写完整信息', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
        }
    
        $data = ecjia_touch_user::singleton()->signin($username, $password);
    
        if (is_ecjia_error($data)) {
            $message = $data->get_error_message();
            return ecjia_front::$controller->showmessage($message, ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('info' => $message));
        } else {
            //             $url = RC_Uri::url('touch/my/init');
            $referer_url = !empty($_POST['referer']) ? urlencode($_POST['referer']) : RC_Uri::url('touch/my/init');
            //             if (!empty($referer_url)) {
            //                 $url = $referer_url;
            //             }
            //             return ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('url' => $url));
            $user = ecjia_touch_user::singleton()->getUserinfo();
    
            RC_Loader::load_app_class('connect_user', 'connect', false);
            $connect_user = new connect_user($connect_code, $open_id);
            if ($user['id']) {
                $result = $connect_user->bind_user($user['id'], 0);
            } else {
                RC_Logger::getlogger('debug')->info('关联账号错误');
                RC_Logger::getlogger('debug')->info($user);
                return ecjia_front::$controller->showmessage('用户验证成功，获取用户信息失败，请重试！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
            if ($result) {
                /* 获取远程用户头像信息*/
                $user_info = $connect_user->get_openid();
                if ($connect_code == 'sns_qq') {
                    $head_img = $user_info['profile']['figureurl_qq_2'];
                } else if ($connect_code == 'sns_wechat') {
                    $head_img = $user_info['profile']['headimgurl'];
                }
                RC_Logger::getlogger('debug')->info('关联');
                RC_Logger::getlogger('debug')->info($user_info);
                RC_Logger::getlogger('debug')->info($head_img);
                if ($head_img) {
                    RC_Api::api('connect', 'update_user_avatar', array('avatar_url' => $head_img));
                }
                return ecjia_front::$controller->showmessage('关联成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => $referer_url));
            } else {
                RC_Logger::getlogger('error')->error($result);
                return ecjia_front::$controller->showmessage('授权用户信息关联失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
            }
    
        }
    }
    
}

// end