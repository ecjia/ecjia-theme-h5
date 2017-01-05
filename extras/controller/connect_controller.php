<?php
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
        }
        
        ecjia_front::$controller->assign('connect_code',$data['connect_code']);
        ecjia_front::$controller->assign('user_info', $user_info);
        ecjia_front::$controller->assign('user_img', $user_img);
        ecjia_front::$controller->assign('user_name', $user_name);
        
        //$data['open_id']
        $url['bind_signup'] = str_replace('/notify/', '/', RC_Uri::url('user/privilege/bind_signup', array('connect_code' => $data['connect_code'], 'open_id' => $data['open_id'])));
        $url['bind_signin'] = str_replace('/notify/', '/', RC_Uri::url('user/privilege/bind_signin', array('connect_code' => $data['connect_code'], 'open_id' => $data['open_id'])));
        ecjia_front::$controller->assign('url',$url);
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
}

// end