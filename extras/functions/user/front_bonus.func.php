<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 用户红包列表
 */
function get_user_bouns_list($where, $num = 10, $page = 0) {
	// $db_user_bonus_viewmodel = RC_Loader::load_app_model ( "user_bonus_viewmodel" );
	RC_Loader::load_theme('extras/model/user/user_bonus_viewmodel.class.php');
    $db_user_bonus_viewmodel       = new user_bonus_viewmodel();
	$where = array_merge($where, array('ub.user_id' => $_SESSION['user_id']));
	$field = 'ub.bonus_sn, ub.order_id, bt.type_name, bt.type_money, bt.min_goods_amount, bt.use_start_date, bt.use_end_date';
	$count = $db_user_bonus_viewmodel->where($where)->count('*');
	$pages = new ecjia_page($count, $num, 6, '', $page);
	$res = $db_user_bonus_viewmodel->field($field)->where($where)->limit($pages->limit())->order(array('bonus_id' => 'DESC'))->select();
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

		$arr[] = $row;
	}
	$is_last = $page >= $pages->total_pages ? 1 : 0;
	return array('list'=>$arr, 'page'=>$pages->show(5), 'desc' => $pages->page_desc(), 'is_last'=>$is_last);
}

/**
 *  给指定用户添加一个指定红包
 */
function add_bonus($user_id, $bouns_sn) {
	// $db_user_bonus = RC_Loader::load_app_model ( "user_bonus_model" );
	RC_Loader::load_theme('extras/model/user/user_bonus_model.class.php');
    $db_user_bonus       = new user_bonus_model();
	// $db_bonus_type = RC_Loader::load_app_model ( "bonus_type_model" );
	RC_Loader::load_theme('extras/model/user/user_bonus_type_model.class.php');
    $db_bonus_type       = new user_bonus_type_model();
	$error = new ecjia_error();
	if (empty($user_id)) {
		RC_Error::add_data(RC_Lang::lang('not_login'), 'not_login');
		return false;
	}
	/* 查询红包序列号是否已经存在 */
	$field = 'bonus_id, bonus_sn, user_id, bonus_type_id';
	$where = array('bonus_sn'=>$bouns_sn,'user_id'=>0);
	$row = $db_user_bonus->field($field)->where($where)->find();
	if(!empty($row)){
		/*红包是否过期*/
		$field = 'send_end_date, use_end_date';
		$where = array('type_id'=>$row['bonus_type_id']);
		$bonus_time = $db_bonus_type->field($field)->where($where)->find();
		$now = RC_Time::gmtime();
		if ($now > $bonus_time['use_end_date']) {
			$result['message'] = RC_Lang::lang('bonus_use_expire');
			$result['error'] = 1;
			return $result;
		} else {
			$data = array('user_id'=>$user_id);
			$where = array('bonus_id'=>$row[bonus_id]);
			$result = $db_user_bonus->where($where)->update($data);
			if ($result) {
				return true;
			} else {
				return false;
			}
		}
	}else{
		$result['message'] = RC_Lang::lang('bonus_not_exist');
		$result['error'] = 1;
		return $result;
	}

}

//end
