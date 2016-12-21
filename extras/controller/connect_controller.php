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
        
        if ($data['connect_code']) {
            $user_img = $user_info['profile']['nickname'];
            $user_name = $user_info['profile']['figureurl_qq_2'];
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

}

// end