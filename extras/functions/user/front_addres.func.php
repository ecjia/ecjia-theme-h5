<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 取得收货人地址列表
 */
function get_consignee_list($user_id, $id = 0,$size = 10, $page = 1) {
	// $db_user_address = RC_Loader::load_app_model ( "new_user_viewmodel" );
	RC_Loader::load_theme('extras/model/user/user_new_user_viewmodel.class.php');
     $db_user_address       = new user_new_user_viewmodel();
	// $db_user = RC_Loader::load_app_model('users_model');
	RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
     $db_user       = new touch_users_model();
	$db_user_address->view = array(
		'user_address'=>array(
			'type'  => Component_Model_View::TYPE_RIGHT_JOIN,
			'alias'	=> 'ua',
			'on'   	=> 'ua.address_id = u.address_id'
		)
	);
	if (!empty($id)) {
		return get_consignee_info($user_id, $id);
	} else {
		$count = $db_user_address->where(array('ua.user_id'=>$user_id))->order(array('u.address_id'=>'DESC'))->count('*');
		$pages = new touch_page($count, $size, 6, '', $page);
		$field = 'ua.*,u.address_id | a_id';
		$res = $db_user_address->field($field)->join('user_address')->where(array('ua.user_id'=>$user_id))->order(array('u.address_id'=>'DESC'))->limit($pages->limit())->select();
	}
	$is_last = $page >= $pages->total_pages ? 1 : 0;
	return array('list'=> $res, 'page'=> $pages->show(5), 'desc'=> $pages->page_desc(), 'is_last'=>$is_last, 'default_address'=>$addressid);
}

/**
 * 获取收货地址信息
 */
function get_consignee_info($user_id, $id) {
	// $db_user_address = RC_Loader::load_app_model ("new_user_viewmodel" );
	RC_Loader::load_theme('extras/model/user/user_new_user_viewmodel.class.php');
    $db_user_address       = new user_new_user_viewmodel();
	$where['ua.address_id'] = $id;
	$where['ua.user_id'] = $user_id;
	$field = 'u.address_id | is_default, zipcode, ua.address_id, ua.consignee, ua.country, ua.province, ua.city, ua.district, ua.address, ua.mobile';
	$arr = $db_user_address->join('user_address')->field($field)->where($where)->find();
	return $arr;
}

/**
 * 获取地区名称
 */
function get_region_name($id = 0) {
	// $db_region = RC_Loader::load_app_model ( "region_model" );
	RC_Loader::load_theme('extras/model/user/user_region_model.class.php');
     $db_region       = new user_region_model();
	return $db_region->where(array('region_id' => $id))->get_field('region_name');
}

/**
 * 获得指定国家的所有省份
 */
function get_regions($type = 0, $parent = 0) {
	// $db_region = RC_Loader::load_app_model ( "region_model" );
	RC_Loader::load_theme('extras/model/user/user_region_model.class.php');
     $db_region       = new user_region_model();
	$condition['region_type'] = $type;
	$condition['parent_id'] = $parent;
	return $db_region->field('region_id, region_name')->where($condition)->select();
}

/**
 *  添加指定用户收货地址
 */
function insert_address($address) {
	// $db_user_address = RC_Loader::load_app_model ( "user_address_model" );
	RC_Loader::load_theme('extras/model/user/user_address_model.class.php');
     $db_user_address       = new user_address_model();
	// $db_users = RC_Loader::load_app_model ( "users_model" );
     RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
     $db_users       = new touch_users_model();

	if (!empty($address['address_id'])) {
		unset($address['address_id']);
	}
	/* 插入一条新记录 */
	$address_id = $db_user_address->insert($address);
	$default_id = $db_users->where(array('user_id' => $_SESSION['user_id']))->get_field('address_id');
	if(empty($default_id)){
		$db_users->where(array('user_id'=>$address['user_id']))->update(array('address_id' => $address_id));
	}
	if ($address_id) {
		return true;
	} else {
		return false;
	}
}

/**
 *  更新指定用户收货地址
 */
function update_address($address) {
	// $db_user_address = RC_Loader::load_app_model ( "user_address_model" );
	RC_Loader::load_theme('extras/model/user/user_address_model.class.php');
     $db_user_address       = new user_address_model();
	// $db_users = RC_Loader::load_app_model ( "users_model" );
     RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
     $db_users       = new touch_users_model();
	/* 更新指定记录 */
	$condition['address_id'] = intval($address['address_id']);
	$condition['user_id'] = $address['user_id'];
	$db_user_address->where($condition)->update($address);
	if ( $address['default'] > 0) {
		$db_users->where(array('user_id'=>$address['user_id']))->update(array('address_id'=>$address['address_id']));
	}
	return true;
}

/**
 * 删除一个收货地址
 */
function drop_consignee($id){
	// $db_user_address = RC_Loader::load_app_model('user_address_model');
		RC_Loader::load_theme('extras/model/user/user_address_model.class.php');
     $db_user_address       = new user_address_model();
	$db_user_address->where(array('user_id' => $_SESSION['user_id'], 'address_id' => $id))->delete();
}

//end
