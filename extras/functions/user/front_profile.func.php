<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 修改个人资料（Email, 性别，生日)
 */
function edit_profile($profile) {
	$err = new ecjia_error();
	// $db_users = RC_Loader::load_app_model ( "users_model" );
	RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
    $db_users       = new touch_users_model();
	if (!empty($profile['user_id'])) {
		$cfg = array();
		$cfg['username'] =  $_SESSION['user_name'];;
		if (!empty($profile['sex'])) {
			$cfg['gender'] = intval($profile['sex']);
		}
		if (!empty($profile['email'])) {
			$cfg['email'] = $profile['email'];
		}
		if (!empty($profile['birthday'])) {
			$cfg['bday'] = $profile['birthday'];
		}
		$user = integrate::init_users();
		if (!$user->edit_user($cfg)) {
			if ($user->error == ERR_EMAIL_EXISTS) {
				$err->add('edit_profiles', sprintf(RC_Lang::lang('email_exist'), $profile['email']));
			} else {
				$err->add('edit_profiles', 'DB ERROR!', 'DBERROR');
			}
			return $err;
		}
		/* 过滤非法的键值 */
		$other_key_array = array('msn', 'qq', 'office_phone', 'home_phone', 'mobile_phone');
		foreach ($profile['other'] as $key => $val) {
			/*删除非法key值*/
			if (!in_array($key, $other_key_array)) {
				unset($profile['other'][$key]);
			} else {
				$profile['other'][$key] = htmlspecialchars(trim($val)); //防止用户输入javascript代码
			}
		}
		/* 修改在其他资料 */
		if (!empty($profile['other'])) {
			$db_users->where(array('user_id' => $profile['user_id']))->update($profile['other']);
		}
		return true;
	}else{
		$err->add('edit_profiles', RC_Lang::lang('not_login'));
		return $err;
	}
}

//end
