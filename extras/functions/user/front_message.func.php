<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取指定用户的留言
 */
function get_message_list($user_id, $num, $page, $order_id = 0) {
	// $db_feedback = RC_Loader::load_app_model ( "feedback_model" );
	RC_Loader::load_theme('extras/model/user/user_feedback_model.class.php');
    $db_feedback       = new user_feedback_model();
	/* 获取留言数据 */
	$condition['parent_id'] = 0;
	$condition['user_id'] = $user_id;
	if ($order_id) {
		$condition['order_id'] = $order_id;
	} else {
		$condition['order_id'] = 0;
		$condition['user_name'] = $_SESSION['user_name'];
	}
	$count = $db_feedback->where($condition)->count();
	$pages = new touch_page($count, $num, 6, '', $page);
	$list = $db_feedback->where($condition)->limit($pages->limit())->order(array('msg_time'=>DESC))->select();
	$msg = array();
	if (!empty($list)) {
		foreach ($list as $vo) {
			$reply = array();
			$condition2['parent_id'] = $vo['msg_id'];
			$reply = $db_feedback->field('user_name, user_email, msg_time, msg_content')->where($condition2)->find();
			if (!empty($reply)) {
				$msg[$vo['msg_id']]['re_user_name'] = $reply['user_name'];
				$msg[$vo['msg_id']]['re_user_email'] = $reply['user_email'];
				$msg[$vo['msg_id']]['re_msg_time'] = RC_Time::local_date(ecjia::config('time_format'), $reply['msg_time']);
				$msg[$vo['msg_id']]['re_msg_content'] = nl2br(htmlspecialchars($reply['msg_content']));
			}
			$msg[$vo['msg_id']]['url'] = RC_Uri::url('user_message/del_msg', array('id' => $vo['msg_id'], 'order_id' => $vo['order_id']));
			$msg[$vo['msg_id']]['msg_content'] = nl2br(htmlspecialchars($vo['msg_content']));
			$msg[$vo['msg_id']]['msg_time'] = RC_Time::local_date('Y-m-d', $vo['msg_time']);
			$msg[$vo['msg_id']]['msg_type'] = $order_id ? $vo['user_name'] : RC_Lang::lang('type/' . $vo['msg_type']);
			$msg[$vo['msg_id']]['msg_type_id'] = $vo['msg_type'];
			$msg[$vo['msg_id']]['msg_title'] = nl2br(htmlspecialchars($vo['msg_title']));
			$msg[$vo['msg_id']]['message_img'] = $vo['message_img'];
			$msg[$vo['msg_id']]['order_id'] = $vo['order_id'];
			$msg[$vo['msg_id']]['msg_id'] = $vo['msg_id'];
			$msg[$vo['msg_id']]['msg_username'] = $_SESSION['user_name'];
		}
	}
	$is_last = $page >= $pages->total_pages ? 1 : 0;
	return array('list' => $msg, 'page' => $pages->show(5), 'desc' => $pages->page_desc(), 'is_last' => $is_last);
}

/**
 * 获取指定的消息详情
 */
function get_message_detail($user_id, $msg_id) {
	// $db_msg = RC_Loader::load_app_model ( "message_model" );
	RC_Loader::load_theme('extras/model/user/user_message_model.class.php');
    $db_msg       = new user_message_model();
	$where = array(
		'user_id'=>$user_id,
		'msg_id'=> $msg_id
	);
	$field ='msg_content, msg_time, msg_type';
	$res = $db_msg->field($field)->where($where)->find();
	$res['msg_time'] = date('Y-m-d', $res['msg_time']);
	$condition['parent_id'] = $msg_id;
	$reply = $db_msg->field('user_name, user_email, msg_time, msg_content')->where($condition)->find();
	$res['re_user_name'] = $reply['user_name'];
	$res['re_user_email'] = $reply['user_email'];
	$res['msg_type'] = RC_Lang::lang('type/' . $res['msg_type']);
	$res['re_msg_time'] = RC_Time::local_date(ecjia::config('time_format'), $reply['msg_time']);
	$res['re_msg_content'] = nl2br(htmlspecialchars($reply['msg_content']));
	return $res;
}
