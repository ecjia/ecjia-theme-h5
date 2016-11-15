<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 *  获取用户指定范围的订单列表
 *
 * @access  public
 * @param   array       $where          查询条件
 * @param   int         $num            列表最大数量
 * @param   int         $start          列表起始位置
 * @return  array       $order_list     订单列表
 */
function get_orders_list($where = 1, $num = 10, $page) {
    RC_Loader::load_theme ('extras/model/user/user_order_info_viewmodel.class.php');
    RC_Loader::load_theme ('extras/model/user/user_order_info_model.class.php');
    $db_order_info  = new user_order_info_viewmodel();
    $db_order       = new user_order_info_model();
    /* 取得订单列表 */
    $arr = array();
    $rs = $db_order->field('order_id, main_order_id')->where(array('user_id' => $_SESSION['user_id']))->select();
    foreach($rs as $value){
        if(empty($value['main_order_id'])){
            $arr[$value['order_id']]['order_id']        = $value['order_id']; // 主订单 和普通订单
        }else{
            $order[$value['order_id']]['order_id']      = $value['order_id'];
            $order[$value['order_id']]['main_order_id'] = $value['main_order_id']; // 子订单
        }
    }
    foreach ($order as $key => $val){
        unset($arr[$val['main_order_id']]); //删除主订单 
        unset($order[$key]['main_order_id']); 
    }
    $order = array_merge($order, $arr);
    foreach ($order as $val){
        $in['oi.order_id'][] = $val['order_id'];
    }
    $field = 'oi.order_id, oi.order_sn, oi.shipping_id, p.pay_code, oi.order_status, oi.shipping_status, oi.pay_status, oi.add_time, (oi.goods_amount + oi.shipping_fee + oi.insure_fee + oi.pay_fee + oi.pack_fee + oi.card_fee + oi.tax - oi.discount)| total_fee, og.goods_name, SUM(og.goods_number) | goods_number, og.goods_price';
    $count = $db_order_info->join(array('order_goods','payment'))->where($where)->in($in)->count('distinct oi.order_id');
    $pages = new touch_page($count, $num, 6, '', $page);
    $res = $db_order_info->field($field)->where($where)->in($in)->order('add_time DESC')->group('oi.order_id')->limit($pages->limit())->select();
    if (!empty($res)) {
        foreach ($res as $key => $value) {
            if( $value['pay_status'] == PS_UNPAYED && $value['pay_code'] != 'pay_cod'){
                //待付款
                $value['handler'] = "<a class='nopjax' href=\"" . RC_Uri::url('user_order/cancel_order', array('order_id' => $value['order_id'])) . "\" onclick=\"if (!confirm('" . RC_Lang::lang('confirm_cancel') . "')) return false;\">" . RC_Lang::lang('cancel') . "</a>";
            }elseif ($value['pay_status'] == PS_PAYED && $value['shipping_status'] == 1) {
                //待收货
                @$value['handler'] = "<a class='nopjax' href=\"" . RC_Uri::url('user_order/affirm_received', array('order_id' => $value['order_id'])) . "\" onclick=\"if (!confirm('" . RC_Lang::lang('confirm_received') . "')) return false;\">" . RC_Lang::lang('received') . "</a>";
            } elseif ($value['pay_status'] == PS_PAYED && $value['shipping_status'] == SS_RECEIVED ) {
                //已完成
                $value['handler'] = '已完成';
            }
            if (( $value['pay_status'] == 0 && $value['pay_code'] != 'pay_cod')){
                //待付款
                $value['order_status'] =  RC_Lang::lang('ps/' . PS_UNPAYED);
            }elseif(($value['shipping_status'] == 0 && $value['pay_status'] == 2) || $value['pay_code'] == 'pay_cod' && $value['shipping_status'] == 0 ) {
                //待发货
                $value['order_status'] =  RC_Lang::lang('ss/' . SS_UNSHIPPED);
            }elseif ($value['shipping_status'] == 1 ) {
                //待收货
                $value['order_status'] =  RC_Lang::lang('os/' . OS_UNCONFIRMED);
            } elseif ($value['pay_status'] == PS_PAYED && $value['shipping_status'] == SS_RECEIVED ) {
                //已完成
                $value['order_status'] = '已完成';
            }
            $order_list[] = array(
                'order_id' => $value['order_id'],
                'order_sn' => $value['order_sn'],
                'img' => get_image_path(0, get_order_thumb($value['order_id'])),
                'order_time' => RC_Time::local_date('Y-m-d', $value['add_time']),
                'order_status' => $value['order_status'],
                'shipping_id' => $value['shipping_id'],
                'goods_name' => $value['goods_name'],
                'goods_number' => $value['goods_number'],
                'total_fee' => price_format($value['total_fee'], false),
                'url' => RC_Uri::url('user/order_detail', array('order_id' => $value['order_id'])),
                'handler' => $value['handler'],
                'order_price'=>order_info($value['order_id'], $value['order_sn']),
                'goods_price'=>$value['goods_price']
            );
        }
    }
    $is_last = $page >= $pages->total_pages ? 1 : 0;
    return array('list'=>$order_list, 'page'=>$pages->show(5), 'desc'=>$pages->page_desc(), 'is_last'=>$is_last);
}