<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 *  获取某用户的缺货登记列表
 */
function get_booking_list($user_id, $num, $page) {
	// $db_booking_goods_viewmodel = RC_Loader::load_app_model ( "booking_goods_viewmodel" );
	RC_Loader::load_theme('extras/model/user/user_booking_goods_viewmodel.class.php');
    $db_booking_goods_viewmodel       = new user_booking_goods_viewmodel();
	$booking = array();
	$where = array('bg.user_id'=>$user_id);
	$field = 'bg.rec_id, bg.goods_id, bg.goods_number, bg.booking_time, bg.dispose_note, g.goods_name, g.goods_thumb';
	$orderby = array('bg.booking_time'=>'DESC');
	$count = $db_booking_goods_viewmodel->field($field)->where($where)->order($orderby)->count('*');
	$pages = new touch_page($count, $num, 6, '', $page);
	$list = $db_booking_goods_viewmodel->field($field)->where($where)->order($orderby)->limit($pages->limit())->select();
	if (is_array($list)) {
		foreach ($list as $vo) {
			if (empty($vo['dispose_note'])) {
				$vo['dispose_note'] = 'N/A';
			}
			$booking[] = array(
				'rec_id' => $vo['rec_id'],
				'goods_name' => $vo['goods_name'],
				'goods_number' => $vo['goods_number'],
				'booking_time' => RC_Time::local_date(ecjia::config('date_format'), $vo['booking_time']),
				'dispose_note' => $vo['dispose_note'],
				'url' => RC_Uri::url('goods/index/init', array('id' => $vo['goods_id'])),
				'img' => get_image_path(0, $vo['goods_thumb'])
			);
		}
	}
	$is_last = $page >= $pages->total ? 1 : 0;
	return array('list'=>$booking, 'page'=>$pages->show(5), 'desc' => $pages->page_desc(), 'is_last' => $is_last);
}

/**
 *  验证删除某个缺货登记
 */
function delete_booking($booking_id, $user_id){
	// $booking = RC_Loader::load_app_model ( "booking_goods_model" );
	RC_Loader::load_theme('extras/model/user/user_booking_goods_model.class.php');
    $booking       = new user_booking_goods_model();
	if (empty($booking_id) || empty($user_id)) {
		return false;
	}
	$where['user_id'] = $user_id;
	$where['rec_id'] = $booking_id;
	$booking ->where($where)->delete();
}

/**
 *  获取某用户的缺货登记列表
 */
function get_goodsinfo($goods_id){
	// $db_booking_model = RC_Loader::load_app_model ( "goods_model" );
	RC_Loader::load_theme('extras/model/user/user_goods_model.class.php');
    $db_booking_model       = new user_goods_model();
	// $db_booking_addres_viewmodel = RC_Loader::load_app_model ( "booking_addres_viewmodel" );
	RC_Loader::load_theme('extras/model/user/user_booking_addres_viewmodel.class.php');
    $db_booking_addres_viewmodel       = new user_booking_addres_viewmodel();
	$info = array();
	$where['goods_id'] = $goods_id;
	$arr = $db_booking_model->field('goods_name')->where($where)->find();
	$info['goods_name']   = $arr['goods_name'];
	$info['goods_number'] = 1;
	$info['id']           = $goods_id;
	if (!empty($_SESSION['user_id'])) {
		$row = $db_booking_addres_viewmodel->field('ua.consignee,ua.email,ua.tel,ua.mobile')->join('users')->where(array('u.user_id' => $_SESSION[user_id]))->find();
		$info['consignee'] = empty($row['consignee']) ? '' : $row['consignee'];
		$info['email']     = empty($row['email'])     ? '' : $row['email'];
		$info['tel']       = empty($row['mobile'])    ? (empty($row['tel']) ? '' : $row['tel']) : $row['mobile'];
	}
	return $info;
}

/**
 *  查看此商品是否已进行过缺货登记
 */
function get_booking_rec($user_id, $goods_id){
	// $db_booking_model = RC_Loader::load_app_model ( "booking_goods_model" );
	RC_Loader::load_theme('extras/model/user/user_booking_goods_model.class.php');
    $db_booking_model       = new user_booking_goods_model();
	$arr = $db_booking_model->where(array('user_id' => $user_id, 'goods_id' => $goods_id, 'is_dispose' => '0'))->count('*');
	return $arr;
}

/**
 * 添加缺货登记记录到数据表
 */
function adds_booking($booking){
	// $db_booking_model = RC_Loader::load_app_model ( "booking_goods_model" );
	RC_Loader::load_theme('extras/model/user/user_booking_goods_model.class.php');
    $db_booking_model       = new user_booking_goods_model();
	$data['user_id']=$_SESSION[user_id];
	$data['email']=$booking[email];
	$data['link_man']=$booking[linkman];
	$data['tel']=$booking[tel];
	$data['goods_id']=$booking[goods_id];
	$data['goods_desc']=$booking[desc];
	$data['goods_number']=$booking[goods_amount];
	$data['booking_time'] = RC_time::gmtime();
	$data['is_dispose']= '0';
	$data['dispose_time']= '0';
	$res = $db_booking_model->insert($data);
	return $res;
}

//end
