<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 *  添加留言函数
 */
function add_message($message) {
	// $db_feedback = RC_Loader::load_app_model ( "feedback_model" );
	RC_Loader::load_theme('extras/model/user/user_feedback_model.class.php');
    $db_feedback       = new user_feedback_model();
	$data['msg_id']			= NULL;
	$data['parent_id']		= 0;
	$data['user_id']		= $message['user_id'];
	$data['user_name']		= $message['user_name'];
	$data['user_email']		= $message['user_email'];
	$data['msg_title']		= $message['msg_title'];
	$data['msg_type']		= $message['msg_type'];
	$data['msg_content']	= $message['msg_content'];
	$data['order_id']		= $message['order_id'];
	$data['msg_area']		= isset($message['msg_area']) ? intval($message['msg_area']) : 0;
	$data['message_img']	= '';
	$data['msg_status']		= 1 - ecjia::config('message_check');
	$data['msg_time']		= RC_Time::gmtime();
	return $db_feedback->insert($data);
}
