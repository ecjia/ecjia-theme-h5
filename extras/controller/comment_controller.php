<?php
/**
 * 评论模块控制器代码
 */
class comment_controller {

    /**
     * 商品评论列表
     */
    public static function init() {
        $cmt['id'] = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $rank = !empty($_GET['rank']) ? intval($_GET['rank']) : 0;
        $cmt['type'] = !empty($_GET['type']) ? intval($_GET['type']) : 0;
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 5;
        $cmt['page'] = isset($_GET['page']) && intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
        $comment_info = get_comment_info($cmt['id'], $cmt['type'], $size, $cmt['page']);
        $comment_list = assign_comment($cmt['id'], $cmt['type'], $rank, $cmt['page']);
        ecjia_front::$controller->assign('comments_info',$comment_info );
        ecjia_front::$controller->assign('id', $cmt['id']);
        ecjia_front::$controller->assign('goods_id',$cmt['id']);
        ecjia_front::$controller->assign('type', $cmt['type']);
        ecjia_front::$controller->assign('comment_list', $comment_list['list']);
        ecjia_front::$controller->assign('username', $_SESSION['user_name']);
        ecjia_front::$controller->assign('email', $_SESSION['email']);
        ecjia_front::$controller->assign('rank', $rank);
        ecjia_front::$controller->assign('title', RC_Lang::lang('goods_comment'));
        ecjia_front::$controller->assign_title(RC_Lang::lang('goods_comment'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('goods_comment_list.dwt');
    }

    /**
     * 异步加载评论列表
     */
    public  static  function async_comment_list(){
        $cmt['id'] = !empty($_GET['id']) ? intval($_GET['id']) : 0;
        $rank = !empty($_GET['rank']) ? intval($_GET['rank']) : 0;
        $cmt['page'] = isset($_GET['page']) && intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
        $cmt['type'] = !empty($_GET['type']) ? intval($_GET['type']) : 0;
        $comment_list = assign_comment($cmt['id'], $cmt['type'], $rank, $cmt['page']);
        ecjia_front::$controller->assign('comment_list', $comment_list['list']);
        ecjia_front::$controller->assign_lang();
        $sayList = ecjia_front::$controller->fetch('goods_comment_list.dwt');
        ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page' , 'is_last' => $comment_list['is_last']));
    }

    /**
     * 添加商品评论
     */
     public static function add_comment() {
        /* 只有在没有提交评论内容以及没有act的情况下才跳转 */
        $cmt['id'] = intval($_POST['id']) > 0 ? intval($_POST['id']) : 0;
        $cmt['type'] = intval($_POST['cmt_type'])? intval($_POST['cmt_type']) : 0;
        $cmt['email'] = empty($_POST['emails']) ? 'touch_noemail@ecjia.com' : htmlspecialchars($_POST['emails']);
        $cmt['rank'] = htmlspecialchars($_POST['level-hide']);
        $cmt['captcha'] = htmlspecialchars($_POST['captcha']);
        $cmt['content'] = htmlspecialchars($_POST['content']);
        if(empty($cmt['rank'])){
            ecjia_front::$controller->showmessage('请选择评论等级', ecjia_admin::MSGSTAT_ERROR | ecjia_admin::MSGTYPE_JSON);
        }
        if(empty($cmt['content'])){
            ecjia_front::$controller->showmessage('请填写评论内容', ecjia_admin::MSGSTAT_ERROR | ecjia_admin::MSGTYPE_JSON);
        }
        if (empty($cmt) || !isset($cmt['type']) || !isset($cmt['id'])) {
            ecjia_front::$controller->showmessage(RC_Lang::lang('invalid_comments'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }

        if (!is_email($cmt['email'])) {
            ecjia_front::$controller->showmessage(RC_Lang::lang('error_email'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
        if ((intval(ecjia::config('captcha')) & CAPTCHA_COMMENT) ) {
            /* 检查验证码 */
            $captcha = intval(ecjia::config('captcha'));
            if (empty($_POST['captcha']) || $_SESSION['captcha_word'] !== strtolower($_POST['captcha'])) {
                $result['error']   = 1;
                $result['message'] = RC_Lang::lang('invalid_captcha');
                ecjia_front::$controller->showmessage(RC_Lang::lang('invalid_captcha'), ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, $result);
            }
        }
        $factor = intval(ecjia::config('comment_factor'));
        if ($cmt->type == 0 && $factor > 0) {
            /* 只有商品才检查评论条件 */
            switch ($factor) {
                case COMMENT_LOGIN :
                    if ($_SESSION['user_id'] == 0) {
                        $result['error']   = 1;
                        $result['message'] = RC_Lang::lang('comment_login');
                        ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, $result);
                    }
                break;

                case COMMENT_CUSTOM :
                    if ($_SESSION['user_id'] > 0) {
                        // 只要是付款用户，不限制购买内容
                        RC_Loader::load_theme('extras/model/comment/comment_order_info_viewmodel.class.php');
                        $db_comment_order_info = new comment_order_info_viewmodel();
                        $where =
                        "user_id = '" . $_SESSION['user_id'] . "'".
                        " AND (o.order_status = '" . OS_CONFIRMED . "' or o.order_status = '" . OS_SPLITED . "') ".
                        " AND (o.pay_status = '" . PS_PAYED . "' OR o.pay_status = '" . PS_PAYING . "') ".
                        " AND (o.shipping_status = '" . SS_SHIPPED . "' OR o.shipping_status = '" . SS_RECEIVED . "') ";

                        $tmp = $db_comment_order_info->join(null)->where($where)->count('*');

                        if (empty($tmp)) {
                            $result['error']   = 1;
                            $result['message'] = RC_Lang::lang('comment_custom');
                            ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, $result);
                        }
                    } else {
                        $result['error'] = 1;
                        $result['message'] = RC_Lang::lang('comment_custom');
                        ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, $result);
                    }
                break;
                case COMMENT_BOUGHT :
                    if ($_SESSION['user_id'] > 0) {
                        // TODO:: 必须是购买本商品的用户。修复sql
                        RC_Loader::load_theme('extras/model/comment/comment_order_info_viewmodel.class.php');
                        $db_comment_order_info = new comment_order_info_viewmodel();
                        $where = "o.user_id = '" . $_SESSION['user_id'] . "'".
                            " AND og.goods_id = '" . $cmt->id . "'".
                            " AND (o.order_status = '" . OS_CONFIRMED . "' or o.order_status = '" . OS_SPLITED . "') ".
                            " AND (o.pay_status = '" . PS_PAYED . "' OR o.pay_status = '" . PS_PAYING . "') ".
                            " AND (o.shipping_status = '" . SS_SHIPPED . "' OR o.shipping_status = '" . SS_RECEIVED . "') ";
                        $tmp = $db_comment_order_info->where($where)->count('*');
                        if (empty($tmp)) {
                            $result['error']   = 1;
                            $result['message'] = RC_Lang::lang('comment_brought');
                            ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, $result);
                        }
                    } else {
                        $result['error']   = 1;
                        $result['message'] = RC_Lang::lang('comment_brought');
                        ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, $result);
                    }
                break;
            }
            /* 无错误就保存留言 */
            add_comment($cmt);
        } else {
            /* 没有验证码时，用时间来限制机器人发帖或恶意发评论 */
            if (!isset($_SESSION ['send_time'])) {
                $_SESSION ['send_time'] = 0;
            }
            $cur_time = RC_Time::gmtime();
            if (($cur_time - $_SESSION ['send_time']) < 30) { // 小于30秒禁止发评论
                ecjia_front::$controller->showmessage(RC_Lang::lang('cmt_spam_warning'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
            } else {
                $factor = intval(ecjia::config('comment_factor'));
                if ($cmt['type'] == 0 && $factor > 0) {
                    $err_msg = check_add_comment($factor, $cmt);
                    if ($err_msg) {
                        ecjia_front::$controller->showmessage($err_msg , ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
                    }
                }
                /* 无错误就保存留言 */
                add_comment($cmt);
                $_SESSION ['send_time'] = $cur_time;
            }
        }
        if (ecjia::config('comment_check')) {
            ecjia_front::$controller->showmessage(RC_Lang::lang('cmt_submit_wait'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('goods/index/init', array('id' =>$cmt['id']))));
        } else {
            ecjia_front::$controller->showmessage(RC_Lang::lang('cmt_submit_done'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('goods/index/comment', array('id' =>$cmt['id']))));
        }
    }

}

// end
