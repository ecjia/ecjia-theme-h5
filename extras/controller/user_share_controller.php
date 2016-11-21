<?php
/**
 * 分享推荐模块控制器代码
 */
class user_share_controller {

    /**
     * 分享推荐
     */
    public static function share() {
        // $user_id = $_SESSION['user_id'];
        // // $db_users = RC_Loader::load_app_model ( "users_model" );
        // RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
        // $db_users       = new touch_users_model();
        // // $db_order_info_viewmodel = RC_Loader::load_app_model ( "order_info_viewmodel" );
        // RC_Loader::load_theme('extras/model/user/user_order_info_viewmodel.class.php');
        // $db_order_info_viewmodel       = new user_order_info_viewmodel();
        // $share = unserialize(ecjia::config('affiliate'));
        //
        // $page = intval($_REQUEST['page']);
        // $size = intval(ecjia::config('page_size'));
        // empty($share) && $share = array();
        // if (empty($share['config']['separate_by'])) {
        //     /*推荐注册分成*/
        //     $affdb = array();
        //     $num = count($share['item']);
        //     $up_uid = "'$user_id'";
        //     $all_uid = "'$user_id'";
        //     for ($i = 1; $i <= $num; $i++) {
        //         $count = 0;
        //         if ($up_uid) {
        //             $rs = $db_users->field('user_id')->in(array('parent_id'=>$up_uid))->select();
        //             if (empty($rs)) {
        //                 $rs = array();
        //             }
        //             $up_uid = '';
        //             foreach ($rs as $k => $v) {
        //                 $up_uid .= $up_uid ? ",'$v[user_id]'" : "'$v[user_id]'";
        //                 if ($i < $num) {
        //                     $all_uid .= ", '$v[user_id]'";
        //                 }
        //                 $count++;
        //             }
        //         }
        //         $affdb[$i]['num'] = $count;
        //         $affdb[$i]['point'] = $share['item'][$i - 1]['level_point'];
        //         $affdb[$i]['money'] = $share['item'][$i - 1]['level_money'];
        //         ecjia_front::$controller->assign('affdb', $affdb);
        //         $where = "oi.user_id > 0 AND (u.parent_id IN ($all_uid) AND oi.is_separate = 0 OR al.user_id = '$user_id' AND oi.is_separate > 0)";
        //         $field = 'oi.*, al.log_id, al.user_id|suid,  al.user_name|auser, al.money, al.point, al.separate_type';
        //         $orderby = array('order_id'=>'DESC');
        //         $count = $db_order_info_viewmodel->join(array('users','affiliate_log'))->where($where)->count('*');
        //         $page = new touch_page($count, $size, 6, '', $page);
        //         $rt = $db_order_info_viewmodel->join(array('users','affiliate_log'))->field($field)->join('users,affiliate_log')->where($where)->order($orderby)->limit($page->limit())->select();
        //     }
        // } else {
        //     /*推荐订单分成*/
        //     $where = "oi.user_id > 0 AND (oi.parent_id = '$user_id' AND oi.is_separate = 0 OR al.user_id = '$user_id' AND oi.is_separate > 0)";
        //     $field = 'oi.*, al.log_id,al.user_id|suid, al.user_name|auser, al.money, al.point, al.separate_type,u.parent_id|up';
        //     $orderby = array('order_id'=>'DESC');
        //     $count = $db_order_info_viewmodel->join(array('users','affiliate_log'))->where($where)->count('*');
        //     $page = new touch_page($count, $size, 6, '', $page);
        //     $rt = $db_order_info_viewmodel->join(array('users','affiliate_log'))->field($field)->where($where)->order($orderby)->limit($page->limit())->select();
        // }
        // if ($rt) {
        //     foreach ($rt as $k => $v) {
        //         if (!empty($v['suid'])) {
        //             if ($v['separate_type'] == - 1 || $v['separate_type'] == - 2) {
        //                 $v['is_separate'] = 3;
        //             }
        //         }
        //         $rt[$k]['order_sn'] = substr($v['order_sn'], 0, strlen($v['order_sn']) - 5) . "***" . substr($v['order_sn'], - 2, 2);
        //     }
        // } else {
        //     $rt = array();
        // }
        // $shopurl = RC_Uri::url('touch/index/init', array('u'=>$user_id));
        // ecjia_front::$controller->assign('pager', $page->show(5));
        // ecjia_front::$controller->assign('affiliate_type', $share['config']['separate_by']);
        // ecjia_front::$controller->assign('logdb', $rt);
        // ecjia_front::$controller->assign('shopurl', $shopurl);
        // ecjia_front::$controller->assign('base64_shopurl', base64_encode($shopurl));
        // ecjia_front::$controller->assign('domain', SITE_URL);
        // ecjia_front::$controller->assign('shopdesc', ecjia::config('shop_desc'));
        // ecjia_front::$controller->assign('title', RC_Lang::lang('label_share'));
        // ecjia_front::$controller->assign('share', $share);
        // ecjia_front::$controller->assign_title(RC_Lang::lang('label_share'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_share.dwt');
    }

    /**
     * 生成二维码
     */
    public static function create_qrcode(){
        // $value = base64_decode(htmlspecialchars($_GET['value']));
        // if($value){
        //     // 纠错级别：L、M、Q、H
        //     $errorCorrectionLevel = 'L';
        //     // 点的大小：1到10
        //     $matrixPointSize = 4;
        //     RC_Loader::load_app_class('QRcode', 'touch');
        //     QRcode::png($value, false, $errorCorrectionLevel, $matrixPointSize, 2);
        // }
    }

}

// end
