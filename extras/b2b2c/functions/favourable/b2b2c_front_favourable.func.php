<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取优惠活动的信息和活动banner
 * @param unknown $size
 * @param unknown $page
 * @return Ambigous <multitype:, type, string, unknown>
 */
function get_activity_list($size, $page) {
    RC_Loader::load_theme('extras/b2b2c/model/favourable/favourable_activity_viewmodel.class.php');
    $db_favourable = new favourable_activity_viewmodel();
    $order = array(
        'sort_order'=>ASC,
        'end_time'=>DESC
    );
    $count = $db_favourable->count('*');
    $pages = new ecjia_page($count, $size, 6, '',$page);
    $res = $db_favourable->field('*')->limit($pages->limit())->order($order)->select();
    $arr = array();
    foreach ($res as $row) {
        $arr[$row['act_id']]['start_time'] = RC_Time::local_date('Y-m-d H:i', $row['start_time']);
        $arr[$row['act_id']]['end_time'] = RC_Time::local_date('Y-m-d H:i', $row['end_time']);
        $arr[$row['act_id']]['url'] = RC_Uri::url('favourable/index/goods_list', array('id' => $row['act_id']));
        $arr[$row['act_id']]['act_name'] = $row['act_name'];
        $arr[$row['act_id']]['act_id'] = $row['act_id'];
        $shopname = $row['shoprz_brandName'].$row['shopNameSuffix'];
        $arr[$row['act_id']]['shop_name'] = !empty($shopname) ? $shopname : '自营';
    }
    $is_last = $page >= $pages->total_pages ? 1 : 0;
    return array('list'=>$arr, 'page'=>$pages->show(5), 'desc'=>$pages->page_desc(), 'is_last'=>$is_last);
}

// end