<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 *
 * @access  public
 * @param   int         $user_id         用户ID
 * @param   int         $num             列表显示条数
 * @param   int         $start           显示起始位置
 *
 * @return  array       $arr             红保列表
 */
function get_user_bouns($where, $num = 10, $page = 0) {
    RC_Loader::load_theme("extras/model/user/user_bonus_viewmodel.class.php");
    $db_user_bonus_viewmodel = new user_bonus_viewmodel();

    $db_user_bonus_viewmodel->view = array(
		'bonus_type'	=> array(
			'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias'		=> 'bt',
			'on'		=> 'ub.bonus_type_id = bt.type_id'
			),
        'merchants_shop_information' => array(
            'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
            'alias'		=> 'ms',
            'on'		=> 'bt.user_id = ms.user_id'
        )
	);

    $where = array_merge($where, array('ub.user_id' => $_SESSION['user_id']));
    $field = 'ub.bonus_sn, ub.order_id, bt.type_name, bt.type_money, bt.min_goods_amount, bt.usebonus_type, bt.use_start_date, bt.use_end_date, ms.shopNameSuffix, ms.shoprz_brandName, ms.user_id';
    $count = $db_user_bonus_viewmodel->join(array('bonus_type','merchants_shop_information'))->where($where)->count('*');

    $pages = new ecjia_page($count, $num, 6, '', $page);

    $res = $db_user_bonus_viewmodel->field($field)->where($where)->limit($pages->limit())->select();
    $arr = array();
    $day = getdate();
    $cur_date = RC_Time::local_mktime(23, 59, 59, $day['mon'], $day['mday'], $day['year']);
    foreach ($res as $row) {
        /* 先判断是否被使用，然后判断是否开始或过期 */
        if (empty($row['order_id'])) {
            /* 没有被使用 */
            if ($row['use_start_date'] > $cur_date) {
                $row['status'] = RC_Lang::lang('not_start');
            } else if ($row['use_end_date'] < $cur_date) {
                $row['status'] = RC_Lang::lang('overdue');
            } else {
                $row['status'] = RC_Lang::lang('not_use');
            }
        } else {
            $url = RC_Uri::url('user_order/order_detail', array('order_id'=>$row['order_id']));
            $row['status'] = '<a href="'.$url.'" >' . RC_Lang::lang('had_use') . '</a>';
        }
        $row['use_startdate'] = RC_Time::local_date(ecjia::config('date_format'), $row['use_start_date']);
        $row['use_enddate'] = RC_Time::local_date(ecjia::config('date_format'), $row['use_end_date']);
        $row['bonus_type'] = !empty($row['user_id']) ? $row['shoprz_brandName'].$row['shopNameSuffix'] : $row['usebonus_type'] == 1 ?  '全场通用' : '自主使用';
        $arr[] = $row;
    }
    $is_last = $page >= $pages->total_pages ? 1 : 0;
    return array('list'=>$arr, 'page'=>$pages->show(1), 'desc' => $pages->page_desc(), 'is_last'=>$is_last);
}