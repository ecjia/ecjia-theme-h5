<?php
defined ( 'IN_ECJIA' ) or exit ( 'No permission resources.' );

/**
 * 获取商品总的评价详情 by Leah
 * @param type $id
 * @param type $type
 */
function get_comment_info($id, $type, $size, $page = 1) {
	// $db_comment = RC_Loader::load_app_model ( 'comment_model' );
	RC_Loader::load_theme('extras/model/comment/comment_model.class.php');
    $db_comment = new comment_model();
	$count = $db_comment->where(array('id_value'=>$id, 'comment_type'=>$type, 'status'=>1, 'parent_id'=>0))->order(array('comment_id'=>'DESC'))->count();
	$info['comment'] = $count;
	//好评
	$favorable_count = $db_comment->where("id_value = '$id' AND comment_type = '$type' AND (comment_rank= 5 OR comment_rank = 4) AND status = 1 AND parent_id = 0")->order(array('comment_id'=>'DESC'))->count();

	//中评
	$medium_count = $db_comment->where("id_value = '$id' AND comment_type = '$type' AND status = 1 AND parent_id = 0 AND(comment_rank = 2 OR comment_rank = 3)")->order(array('comment_id'=>'DESC'))->count();

	//差评
	$bad_count = $db_comment->where(array('id_value'=>$id, 'comment_type'=>$type, 'status'=>1, 'parent_id'=>0, 'comment_rank'=>1))->order(array('comment_id'=>'DESC'))->count();

	$info['all_comment'] = $count;
	$info['favorable_count'] = $favorable_count; //好评数量
	$info['medium_count'] = $medium_count; //中评数量
	$info['bad_count'] = $bad_count; //差评数量
	if ($info['all_comment'] > 0) {
		$info['favorable'] = 0;
		if ($favorable_count) {
			$info['favorable'] = round(($favorable_count / $count) * 100);  //好评率
		}
		$info['medium'] = 0;
		if ($medium_count) {
			$info['medium'] = round(($medium_count / $count) * 100); //中评
		}
		$info['bad'] = 0;
		if ($bad_count) {
			$info['bad'] = round(($bad_count / $count) * 100); //差评
		}
	} else {
		$info['favorable'] = 100;
		$info['medium'] = 100;
		$info['bad'] = 100;
	}
	return $info;
}
/**
 * 查询评论内容
 */
function assign_comment($id, $type, $rank = 0, $page = 1) {
	// $db_comment = RC_Loader::load_app_model ( 'comment_model' );
	RC_Loader::load_theme('extras/model/comment/comment_model.class.php');
    $db_comment = new comment_model();
	$rank_info = '';
	if ($rank == '1') {
		$rank_info = ' AND (comment_rank= 5 OR comment_rank = 4)';
	}
	if ($rank == '2') {
		$rank_info = ' AND (comment_rank= 2 OR comment_rank = 3)';
	}
	if ($rank == '3') {
		$rank_info = ' AND comment_rank= 1 ';
	}
	/* 取得评论列表 */
	$count = $db_comment->where("id_value = '$id' AND comment_type = '$type' AND status = 1 AND parent_id = 0" . $rank_info)->count();
	$size = ecjia::config('comments_number') > 0 ? ecjia::config('comments_number') : 5;
	$pages = new touch_page($count, $size, '6', '' ,$page);
	$res = $db_comment->where("id_value = '$id' AND comment_type = '$type' AND status = 1 AND parent_id = 0" . $rank_info)->limit($pages->limit())->select();
	$arr = array();
	$ids = '';
	foreach ($res as $key => $row) {
		$ids .= $ids ? ",$row[comment_id]" : $row['comment_id'];
		$arr[$row['comment_id']]['id'] = $row['comment_id'];
		$arr[$row['comment_id']]['email'] = $row['email'];
		$arr[$row['comment_id']]['username'] = $row['user_name'];
		$arr[$row['comment_id']]['content'] = str_replace('\r\n', '<br />', htmlspecialchars($row['content']));
		$arr[$row['comment_id']]['content'] = nl2br(str_replace('\n', '<br />', $arr[$row['comment_id']]['content']));
		$arr[$row['comment_id']]['rank'] = $row['comment_rank'];
		$arr[$row['comment_id']]['add_time'] =  RC_Time::local_date(ecjia::config('time_format'), $row['add_time']);
		$arr[$row['comment_id']]['user_img'] =  get_user_img($row['user_id']);
	}
	/* 取得已有回复的评论 */
	if ($ids) {
		$res = $db_comment->in(array('parent_id'=>$ids))->select();
		foreach ($res as $row) {
			$arr[$row['parent_id']]['re_content'] = nl2br(str_replace('\n', '<br />', htmlspecialchars($row['content'])));
			$arr[$row['parent_id']]['re_add_time'] =  RC_Time::local_date(ecjia::config('time_format'), $row['add_time']);
			$arr[$row['parent_id']]['re_email'] = $row['email'];
			$arr[$row['parent_id']]['re_username'] = $row['user_name'];
		}
	}
	/* 分页样式 */
	$is_last = $page >= $pages->total_pages ? 1 : 0;
	return array('list'=> $arr, 'page'=> $pages->show(5), 'desc'=> $pages->page_desc(), 'is_last'=>$is_last);
}

/**
 * 添加评论内容
 */
function add_comment($cmt) {
	// $db_comment = RC_Loader::load_app_model ( 'comment_model' );
	RC_Loader::load_theme('extras/model/comment/comment_model.class.php');
    $db_comment = new comment_model();
	/* 评论是否需要审核 */
	$status = 1 - ecjia::config('comment_check');
	$user_id = empty($_SESSION ['user_id']) ? 0 : $_SESSION ['user_id'];
	$email = empty($cmt['email']) ? $_SESSION ['email'] : trim($cmt['email']);
	$user_name = empty($cmt['username']) ? $_SESSION ['user_name'] : '';
	$email = htmlspecialchars($email);
	$user_name = htmlspecialchars($user_name);
	/* 保存评论内容 */
	$data = array(
		'comment_type'	=> $cmt['type'],
		'id_value'		=> $cmt['id'],
		'email'			=> $email,
		'user_name'		=> $user_name,
		'content'		=> $cmt['content'],
		'comment_rank'	=> $cmt['rank'],
		'add_time'		=> RC_Time::gmtime(),
		'ip_address'	=> RC_Ip::client_ip(),
		'status'		=> $status,
		'parent_id'		=> 0,
		'user_id'		=> $user_id,
	);
	$result = $db_comment->insert($data);
	return $result;
}

/**
 * 检查是否符合发评论的要求
 */
function check_add_comment($factor, $comment){
	// $db_order_info = RC_Loader::load_app_model ( 'order_info_model' );
	RC_Loader::load_theme('extras/model/comment/comment_order_info_model.class.php');
    $db_order_info = new comment_order_info_model();
	// $db_order_info_viewmodel = RC_Loader::load_app_model ( 'order_info_viewmodel' );
	RC_Loader::load_theme('extras/model/comment/comment_order_info_viewmodel.class.php');
    $db_order_info_viewmodel = new comment_order_info_viewmodel();
	/* 只有商品才检查评论条件 */
	switch ($factor) {
		case COMMENT_LOGIN :
			if ($_SESSION ['user_id'] == 0) {
				return RC_Lang::lang('invalid_captcha');
			}
			break;
		case COMMENT_CUSTOM :
			if ($_SESSION ['user_id'] > 0) {
				$condition = "user_id = '" . $_SESSION ['user_id'] . "'" . " AND (order_status = '" . OS_CONFIRMED . "' or order_status = '" . OS_SPLITED . "') " . " AND (pay_status = '" . PS_PAYED . "' OR pay_status = '" . PS_PAYING . "') " . " AND (shipping_status = '" . SS_SHIPPED . "' OR shipping_status = '" . SS_RECEIVED . "') ";
				$tmp = $db_order_info->where($condition)->get_field('order_id');
				if (empty($tmp)) {
					return RC_Lang::lang('comment_custom');
				}
			} else {
				return RC_Lang::lang('comment_custom');
			}
			break;
		case COMMENT_BOUGHT :
			if ($_SESSION ['user_id'] > 0) {
				$where = "oi.order_id = og.order_id" . " AND oi.user_id = '" . $_SESSION ['user_id'] . "'" . " AND og.goods_id = '" . $comment['id'] . "'" . " AND (oi.order_status = '" . OS_CONFIRMED . "' or oi.order_status = '" . OS_SPLITED . "') " . " AND (oi.pay_status = '" . PS_PAYED . "' OR oi.pay_status = '" . PS_PAYING . "') " . " AND (oi.shipping_status = '" . SS_SHIPPED . "' OR oi.shipping_status = '" . SS_RECEIVED . "') ";
				$tmp = $db_order_info_viewmodel->join('order_goods')->where($where)->get_field('oi.order_id');
				if (empty($tmp)) {
					return RC_Lang::lang('comment_brought');
				}
			} else {
				return RC_Lang::lang('comment_brought');
			}
			break;
	}
	return false;
}

//end
