<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 取得用户等级信息
 */
function get_rank_info() {
	// $db_user_rank = RC_Loader::load_app_model ( "user_rank_model" );
	 RC_Loader::load_theme('extras/model/user/user_rank_model.class.php');
        $db_user_rank       = new user_rank_model();
	// $db_users = RC_Loader::load_app_model ( "users_model" );
        RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
        $db_users       = new touch_users_model();
	if (!empty($_SESSION['user_rank'])) {
		$row = $db_user_rank->field('rank_name, special_rank')->where(array('rank_id'=>$_SESSION['user_rank']))->find();
		if ($row && $row['special_rank']) {
			return array('rank_name' => $row['rank_name']);
		} else {
			$rank_name = '';
			$row && $rank_name = $row['rank_name'];
			$condition['user_id'] = $_SESSION['user_id'];
			$user_rank = $db_users->where($condition)->get_field('rank_points');
			$rt = $db_user_rank->field('rank_name,min_points')->where(array('min_points'=>array('gt'=>$user_rank)))->order(array('min_points'=>'asc'))->find();
			$next_rank_name = $rt['rank_name'];
			$next_rank = $rt['min_points'] - $user_rank;
			return array('rank_name' => $rank_name, 'next_rank_name' => $next_rank_name, 'next_rank' => $next_rank);
		}
	} else {
		return array();
	}
}

/**
 *  获取指定用户的收藏商品列表
 */
function get_collection_goods($user_id, $num = 10, $page) {
	// $db_goods_viewmodel = RC_Loader::load_app_model ( "goods_viewmodel" );
	RC_Loader::load_theme('extras/model/user/user_goods_viewmodel.class.php');
    $db_goods_viewmodel       = new user_goods_viewmodel();
	$db_goods_viewmodel->view = array(
		'member_price'   => array(
			'type'     => Component_Model_View::TYPE_LEFT_JOIN,
			'alias'    => 'mp',
			'on'       => 'mp.goods_id = g.goods_id AND mp.user_rank = "' . $_SESSION ['user_rank'] . '"'
		),
		'collect_goods' => array(
			'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
			'alias'	=> 'cg',
			'on' 	=> 'g.goods_id = cg.goods_id',
		)
	);
	$count = $db_goods_viewmodel
	->field('g.goods_id, g.goods_name, g.goods_img, g.is_on_sale, g.market_price, g.shop_price AS org_price,IFNULL(mp.user_price, g.shop_price * '."'$_SESSION[discount]'". ') AS shop_price,g.promote_price, g.promote_start_date,g.promote_end_date, cg.rec_id, cg.is_attention')
	->where(array('cg.user_id'=>$user_id))->order(array('cg.rec_id'=>'DESC'))->count('*');
	$pages = new touch_page($count, $num, 6, '', $page);
	$res = $db_goods_viewmodel
	->field('g.goods_id, g.goods_name, g.goods_img, g.is_on_sale, g.market_price, g.shop_price AS org_price,IFNULL(mp.user_price, g.shop_price * '."'$_SESSION[discount]'". ') AS shop_price,g.promote_price, g.promote_start_date,g.promote_end_date, cg.rec_id, cg.is_attention')
	->where(array('cg.user_id'=>$user_id))->order(array('cg.rec_id'=>'DESC'))->limit($pages->limit())->select();
	$goods_list = array();
	if (!empty($res)) {
		foreach ($res as $row) {
			if ($row['promote_price'] > 0) {
				$promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
			} else {
				$promote_price = 0;
			}
			$goods_list[$row['goods_id']]['rec_id'] = $row['rec_id'];
			$goods_list[$row['goods_id']]['is_attention'] = $row['is_attention'];
			$goods_list[$row['goods_id']]['goods_id'] = $row['goods_id'];
			$goods_list[$row['goods_id']]['goods_name'] = $row['goods_name'];
			$goods_list[$row['goods_id']]['goods_thumb'] = get_image_path(0, $row['goods_img']);
			$goods_list[$row['goods_id']]['market_price'] = price_format($row['market_price']);
			$goods_list[$row['goods_id']]['shop_price'] = price_format($row['shop_price']);
			$goods_list[$row['goods_id']]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
			$goods_list[$row['goods_id']]['url'] = RC_Uri::url('goods/index/init', array('id' => $row['goods_id']));
			$goods_list[$row['goods_id']]['is_on_sale'] = $row['is_on_sale'];
		}
	}
	$is_last = $page >= $pages->total_pages ? 1 : 0;
	return array('list'=>$goods_list,'page' => $pages->show(5),'desc' => $pages->page_desc(), 'is_last' => $is_last );
}

/**
 *  获取用户评论
 */
function get_comment_list($user_id, $page_size, $page) {
	// $db_comment_viewmodel = RC_Loader::load_app_model ( "comment_viewmodel" );
	RC_Loader::load_theme('extras/model/user/user_comment_viewmodel.class.php');
    $db_comment_viewmodel       = new user_comment_viewmodel();
	// $db_article = RC_Loader::load_app_model ( "article_model" );
	RC_Loader::load_theme('extras/model/user/user_article_model.class.php');
    $db_article       = new user_article_model();
	$count = $db_comment_viewmodel->field('g.goods_name|cmt_name, r.content|reply_content, r.add_time|reply_time')->where(array('c.user_id'=>$user_id))->count('*');
	$pages = new touch_page( $count, $page_size, 6,'', $page);
	$res = $db_comment_viewmodel->join(array('goods','comment'))->field('g.goods_name|cmt_name, g.goods_id, g.goods_thumb, r.content|reply_content, r.add_time|reply_time')->where(array('c.user_id'=>$user_id))->limit($pages->limit())->select();
	$comments = array();
	$to_article = array();
	if (!empty($res)) {
		foreach ($res as $row) {
			$row['formated_add_time'] = RC_Time::local_date(ecjia::config('time_format'), $row['add_time']);
			if ($row['reply_time']) {
				$row['formated_reply_time'] = RC_Time::local_date(ecjia::config('time_format'), $row['reply_time']);
			}
			if ($row['comment_type'] == 1) {
				$to_article[] = $row["id_value"];
			}
			$row['goods_thumb'] = get_image_path(0, $row['goods_thumb']);
			$row['url'] = RC_Uri::url('goods/index/init&id=').$row['goods_id'];
			$comments[] = $row;
		}
	}
	if (!empty($to_article)) {
		$arr = $db_article->field('article_id,title')->in(array('article_id' => $to_article))->select();
		$to_cmt_name = array();
		foreach ($arr as $row) {
			$to_cmt_name[$row['article_id']] = $row['title'];
		}
		foreach ($comments as $key => $row) {
			if ($row['comment_type'] == 1) {
				$comments[$key]['cmt_name'] = isset($to_cmt_name[$row['id_value']]) ? $to_cmt_name[$row['id_value']] : '';
			}
		}
	}
	$is_last = $page >= $pages->total_pages ? 1 : 0;
	return array('list'=>$comments, 'page'=>$pages->show(3), 'desc' => $pages->page_desc(), 'is_last' => $is_last);
}

/**
 * 调用浏览历史
 */
function insert_history() {
    $str = '';
    $history = array();
    if (!empty($_COOKIE['ECS']['history'])) {
        $in = array('goods_id' => $_COOKIE['ECS']['history']);
		// $db_goods = RC_Loader::load_app_model ( "goods_model" );
		RC_Loader::load_theme('extras/model/user/user_goods_model.class.php');
    $db_goods       = new user_goods_model();
		$query = $db_goods->field('goods_id, goods_name, goods_img, shop_price, market_price, click_count, goods_brief')->where(array('is_on_sale' => 1, 'is_alone_sale' => 1, 'is_delete' => 0))->in($in)->select();
        foreach ($query as $key => $row) {
            $goods['goods_id'] = $row['goods_id'];
            $goods['goods_name'] = $row['goods_name'];
            $goods['short_name'] = ecjia::config('goods_name_length') > 0 ? RC_String::sub_str($row['goods_name'], ecjia::config('goods_name_length')) : $row['goods_name'];
            $goods['goods_thumb'] = get_image_path($row['goods_id'], $row['goods_img'], true);
            $goods['shop_price'] = price_format($row['shop_price']);
            $goods['market_price'] = price_format($row['market_price']);
            $goods['click_count'] = $row['click_count'];
            $goods['goods_brief'] = $row['goods_brief'];
            $goods['url'] = RC_Uri::url('goods/index/init', array('id' => $row['goods_id']));
            $history[] = $goods;
        }
    }
    return $history;
}

/**
 * 更新用户SESSION,COOKIE及登录时间、登录次数。
 */
function update_user_info() {
	if (!$_SESSION['user_id']) {
		return false;
	}
	/* 查询会员信息 */
	// $db_user_viewmodel = RC_Loader::load_app_model ( "new_user_viewmodel" );
	RC_Loader::load_theme('extras/model/user/user_new_user_viewmodel.class.php');
    $db_user_viewmodel       = new user_new_user_viewmodel();
	// $db_user_rank = RC_Loader::load_app_model ( "user_rank_model" );
	RC_Loader::load_theme('extras/model/user/user_rank_model.class.php');
    $db_user_rank       = new user_rank_model();
	// $db_users = RC_Loader::load_app_model ( "users_model" );
	RC_Loader::load_theme('extras/model/user/users_model.class.php');
    $db_users       = new users_model();
	$row = $db_user_viewmodel->join(array('bonus_type','user_bonus'))->field('u.user_money,u.email, u.pay_points, u.user_rank, u.rank_points, IFNULL(b.type_money, 0)|user_bonus, u.last_login, u.last_ip')->where(array('u.user_id'=>$_SESSION['user_id']))->find();
	if ($row) {
		/* 更新SESSION */
		$_SESSION['last_time'] = $row['last_login'];
		$_SESSION['last_ip'] = $row['last_ip'];
		$_SESSION['login_fail'] = 0;
		$_SESSION['email'] = $row['email'];
		/* 判断是否是特殊等级，可能后台把特殊会员组更改普通会员组 */
		if ($row['user_rank'] > 0) {
			$special_rank = $db_user_rank->where(array('rank_id'=>$row[user_rank]))->get_field('special_rank');
			if ( empty($special_rank)) {
				$row['user_rank'] = $data['user_rank'] = 0;
				$db_users->where(array('user_id'=>$_SESSION[user_id]))->update($data);
			}
		}
		/* 取得用户等级和折扣 */
		if ($row['user_rank'] == 0) {
			/*非特殊等级，根据等级积分计算用户等级（注意：不包括特殊等级）*/
			$row = $db_user_rank->field('rank_id, discount')->where(array('special_rank'=>0, 'min_points'=>array('elt'=>intval($row['rank_points'])), 'max_points'=>array('gt'=>intval($row['rank_points']))))->find();
			if ($row) {
				$_SESSION['user_rank'] = $row['rank_id'];
				$_SESSION['discount'] = $row['discount'] / 100.00;
			} else {
				$_SESSION['user_rank'] = 0;
				$_SESSION['discount'] = 1;
			}
		} else {
			// 特殊等级
			$row = $db_user_rank->field('rank_id, discount')->where(array('rank_id'=>$row['user_rank']))->find();
			if ($row) {
				$_SESSION['user_rank'] = $row['rank_id'];
				$_SESSION['discount'] = $row['discount'] / 100.00;
			} else {
				$_SESSION['user_rank'] = 0;
				$_SESSION['discount'] = 1;
			}
		}
	}
	$db_users->where(array('user_id'=>$_SESSION['user_id']))->update(array('visit_count'=>'visit_count + 1', 'last_ip'=>RC_Ip::client_ip(), 'last_login'=>RC_Time::gmtime()));
}

/**
 * 重新计算购物车中的商品价格：目的是当用户登录时享受会员价格，当用户退出登录时不享受会员价格。如果商品有促销，价格不变
 */
function recalculate_price() {
	/* 取得有可能改变价格的商品：除配件和赠品之外的商品 */
	// $db_cart_viewmodel = RC_Loader::load_app_model ( "cart_viewmodel" );
	RC_Loader::load_theme('extras/model/user/user_cart_viewmodel.class.php');
    $db_cart_viewmodel       = new user_cart_viewmodel();
	// $db_cart = RC_Loader::load_app_model ( "cart_model" );
	RC_Loader::load_theme('extras/model/user/user_cart_model.class.php');
    $db_cart       = new user_cart_model();
	$res = $db_cart_viewmodel->join(array('goods', 'member_price'))
	->field('c.rec_id, c.goods_id, c.goods_attr_id, g.promote_price, g.promote_start_date, c.goods_number,g.promote_end_date,' ." IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]')|member_price ")
	->where(array('session_id'=>SESS_ID, 'c.parent_id'=>0, 'c.is_gift'=>0, 'c.goods_id'=>array('gt'=>0), 'c.rec_type'=>CART_GENERAL_GOODS, 'c.extension_code'=>array('neq'=>'package_buy')))->select();
    if (!empty($res)) {
        foreach ($res AS $row) {
    		$attr_id = empty($row['goods_attr_id']) ? array() : explode(',', $row['goods_attr_id']);
    		$goods_price = get_final_price($row['goods_id'], $row['goods_number'], true, $attr_id);
    		$db_cart->where(array('goods_id'=>$row['goods_id'], 'session_id'=> SESS_ID, 'rec_id'=>$row['rec_id']))->update(array('goods_price'=>$goods_price));
    	}
    }
	/* 删除赠品，重新选择 */
	$db_cart->where(array('session_id'=> SESS_ID, 'is_gift'=>array('neq'=>0)))->delete();
}

/**
 * 获取用户帐号信息
 */
function get_profile($user_id) {
    $user = integrate::init_users();
	// $db_users = RC_Loader::load_app_model ( "users_model" );
	RC_Loader::load_theme('extras/model/user/users_model.class.php');
    $db_users       = new users_model();
	// $db_user_rank = RC_Loader::load_app_model ( "user_rank_model" );
	RC_Loader::load_theme('extras/model/user/user_rank_model.class.php');
    $db_user_rank       = new user_rank_model();
	// $db_user_bonus_viewmodel = RC_Loader::load_app_model ( "user_bonus_viewmodel" );
	RC_Loader::load_theme('extras/model/user/user_bonus_viewmodel.class.php');
    $db_user_bonus_viewmodel       = new user_bonus_viewmodel();
	/* 会员帐号信息 */
	$info = array();
	$infos = array();
	$infos = $db_users->field("user_name, birthday, sex, question, answer, rank_points, pay_points,user_money, user_rank, msn, qq, office_phone, home_phone, mobile_phone, passwd_question, passwd_answer ")
	->where(array('user_id'=>$user_id))->find();
	$infos['user_name'] = addslashes($infos['user_name']);
	$row = $user->get_profile_by_name($infos['user_name']); //获取用户帐号信息
	$_SESSION['email'] = $row['email'];    //注册SESSION
	/* 会员等级 */
	if ($infos['user_rank'] > 0) {
		$row = $db_user_rank->field('rank_id, rank_name, discount')->where(array('rank_id'=>$infos['user_rank']))->find();
	} else {
		$row = $db_user_rank->field('rank_id, rank_name, discount, min_points')->where(array('min_points'=>intval($infos['rank_points'])))->order(array('min_points'=>'DESC'))->find();
	}
	if ($row) {
		$info['rank_name'] = $row['rank_name'];
	} else {
		$info['rank_name'] = RC_Lang::lang('undifine_rank');
	}
	/* 会员红包 */
	$bonus = array();
	$where = array(
		'ub.user_id'		=> $user_id,
		'bt.use_start_date'	=> array('elt' => RC_Time::gmtime()),
		'bt.use_end_date'	=> array('gt' => RC_Time::gmtime()),
		'ub.order_id'		=> 0
	);
	$bonus = $db_user_bonus_viewmodel->field('type_name, type_money')->where($where)->select();
	if (!empty($bonus)) {
		foreach ($bonus as $key => $val ) {
			$bonus[$key]['type_money'] = price_format($val['type_money'], false);
		}
	}
	$info['discount'] = $_SESSION['discount'] * 100 . "%";
	$info['email'] = $_SESSION['email'];
	$info['user_name'] = $_SESSION['user_name'];
	$info['rank_points'] = isset($infos['rank_points']) ? $infos['rank_points'] : '';
	$info['pay_points'] = isset($infos['pay_points']) ? $infos['pay_points'] : 0;
	$info['user_money'] = isset($infos['user_money']) ? $infos['user_money'] : 0;
	$info['sex'] = isset($infos['sex']) ? $infos['sex'] : 0;
	$info['birthday'] = isset($infos['birthday']) ? $infos['birthday'] : '';
	$info['question'] = isset($infos['question']) ? htmlspecialchars($infos['question']) : '';
	$info['user_money'] = price_format($info['user_money'], false);
	$info['pay_points'] = $info['pay_points'] . ecjia::config('integral_name');
	$info['bonus'] = $bonus;
	$info['qq'] = $infos['qq'];
	$info['msn'] = $infos['msn'];
	$info['office_phone'] = $infos['office_phone'];
	$info['home_phone'] = $infos['home_phone'];
	$info['mobile_phone'] = $infos['mobile_phone'];
	$info['passwd_question'] = $infos['passwd_question'];
	$info['passwd_answer'] = $infos['passwd_answer'];
	return $info;
}

/**
 * 发送激活验证邮件
 */
function send_regiter_hash($user_id) {
	// $db_users = RC_Loader::load_app_model ( "users_model" );
	RC_Loader::load_theme('extras/model/user/users_model.class.php');
    $db_users       = new users_model();
	/* 设置验证邮件模板所需要的内容信息 */
	$template = get_mail_template('register_validate');
	$hash = register_hash('encode', $user_id);
	$validate_email = RC_Uri::url('user/index/validate_email', array('hash' => $hash));
	$row = $db_users->field('user_name, email')->where(array('user_id' => $user_id))->find();
	ecjia_front::$controller->assign('user_name', $row['user_name']);
	ecjia_front::$controller->assign('validate_email', $validate_email);
	ecjia_front::$controller->assign('shop_name', ecjia::config('shop_name'));
	ecjia_front::$controller->assign('send_date', date(ecjia::config('date_format')));
	ecjia_front::$controller->assign_lang();
	$content = ecjia_front::$controller->fetch('string:' . $template['template_content']);
	/* 发送激活验证邮件 */
	if (RC_Mail::send_mail($row['user_name'], $row['email'], $template['template_subject'], $content, $template['is_html'])) {
		return true;
	} else {
		return false;
	}
}

/**
 * 生成邮件验证hash
 */
function register_hash($operation, $key) {
	// $db_users = RC_Loader::load_app_model ( "users_model" );
	RC_Loader::load_theme('extras/model/user/users_model.class.php');
    $db_users       = new users_model();
	if ($operation == 'encode') {
		$user_id = intval($key);
		$reg_time = $db_users->where(array('user_id'=>$user_id))->get_field('reg_time');
		$hash = substr(md5($user_id . ecjia::config('hash_code') . $reg_time), 16, 4);
		return base64_encode($user_id . ',' . $hash);
	} else {
		$hash = base64_decode(trim($key));
		$row = explode(',', $hash);
		if (count($row) != 2) {
			return 0;
		}
		$user_id = intval($row[0]);
		$salt = trim($row[1]);
		if ($user_id <= 0 || strlen($salt) != 4) {
			return 0;
		}
		$reg_time = $db_users->where(array('user_id'=>$user_id))->get_field('reg_time');
		$pre_salt = substr(md5($user_id . ecjia::config('hash_code') . $reg_time), 16, 4);
		if ($pre_salt == $salt) {
			return $user_id;
		}
		return 0;
	}
}

/**
 * 获取用户中心默认页面所需的数据
 */
function get_user_default($user_id) {
	$user_bonus = get_user_bonus();
	// $db_users = RC_Loader::load_app_model ( 'users_model', 'user' );
	RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
    $db_users       = new touch_users_model();
	// $db_order_info = RC_Loader::load_app_model ( 'order_info_model', 'user' );
    	RC_Loader::load_theme('extras/model/user/user_order_info_model.class.php');
    	$db_order_info       = new user_order_info_model();
	$row = $db_users->field('pay_points, user_money, credit_line, last_login, is_validated')->where(array('user_id'=>$user_id))->find();
	$info = array();
	$info['username'] = stripslashes($_SESSION['user_name']);
	$info['shop_name'] = ecjia::config('shop_name');
	$info['integral'] = $row['pay_points'] . ecjia::config('integral_name');
	/* 增加是否开启会员邮件验证开关 */
	$info['is_validate'] = (ecjia::config('member_email_validate') && !$row['is_validated']) ? 0 : 1;
	$info['credit_line'] = $row['credit_line'];
	$info['formated_credit_line'] = price_format($info['credit_line'], false);
	/*新增获取用户头像，昵称*/
	$u_row = '';
	if(class_exists('WechatController')){
		if (method_exists('WechatController', 'get_avatar')) {
			$u_row = call_user_func(array('WechatController', 'get_avatar'), $user_id);
		}
	}
	if ($u_row) {
		$info['nickname'] = $u_row['nickname'];
		$info['headimgurl'] = $u_row['headimgurl'];
	} else {
		$info['nickname'] = $info['username'];
		$info['headimgurl'] = '/images/get_avatar.png';//__PUBLIC__ .
	}
	/*如果$_SESSION中时间无效说明用户是第一次登录。取当前登录时间。*/
	$last_time = !isset($_SESSION['last_time']) ? $row['last_login'] : $_SESSION['last_time'];
	if ($last_time == 0) {
		$_SESSION['last_time'] = $last_time = RC_Time::gmtime();
	}
	$info['last_time'] = RC_Time::local_date(ecjia::config('time_format'), $last_time);
	$info['surplus'] = price_format($row['user_money'], false);
	$info['bonus'] = sprintf(RC_Lang::lang('user_bonus_info'), $user_bonus['bonus_count'], price_format($user_bonus['bonus_value'], false));
	$info['order_count'] = $db_order_info->where(array('user_id'=>$user_id, 'add_time'=>array('gt'=>RC_Time::local_strtotime('-1 months'))))->count();
	return $info;
}

/**
 * 查询会员的红包金额
 */
function get_user_bonus($user_id = 0) {
	if ($user_id == 0) {
		$user_id = $_SESSION['user_id'];
	}
	$row = array('bonus_value'=>0, 'bonus_count'=>0);
	if (!empty($user_id)) {
		// $user_bonus_viewmodel = RC_Loader::load_app_model ("user_bonus_viewmodel", "user");
		RC_Loader::load_theme('extras/model/user/user_bonus_viewmodel.class.php');
    	$user_bonus_viewmodel       = new user_bonus_viewmodel();
		RC_Loader::load_theme('extras/model/goods/goods_model.class.php');
        $db_goods_model       = new goods_model();
		$row = $user_bonus_viewmodel->join('bonus_type')->field('SUM(bt.type_money)|bonus_value, COUNT(*)|bonus_count')->where(array('ub.user_id'=>$user_id, 'ub.order_id'=>0))->find();
	}
	return $row;
}

/**
 * 取得自定义导航栏列表
 */
function get_navigator($ctype = '', $catlist = array()) {
	// $db_nav = RC_Loader::load_app_model ( 'nav_model' );
	 RC_Loader::load_theme('extras/model/user/user_nav_model.class.php');
     $user_nav_model  = new user_nav_model();
	$res = $db_nav->where(array('ifshow' => '1'))->order('type, vieworder')->select();
	$cur_url = RC_String::sub_str(strrchr($_SERVER['REQUEST_URI'], '/'), 1);
	if (intval(ecjia::config('rewrite'))) {
		if (strpos($cur_url, '-')) {
			preg_match('/([a-z]*)-([0-9]*)/', $cur_url, $matches);
			$cur_url = $matches[1] . '.php?id=' . $matches[2];
		}
	} else {
		$cur_url = RC_String::sub_str(strrchr($_SERVER['REQUEST_URI'], '/'), 1);
	}
	$noindex = false;
	$active = 0;
	$navlist = array(
		'top' => array(),
		'middle' => array(),
		'bottom' => array()
	);
	foreach ($res as $key => $row) {
		$navlist[$row['type']][] = array(
			'name' => $row['name'],
			'pic' => $row['pic'],
			'opennew' => $row['opennew'],
			'url' => $row['url'],
			'ctype' => $row['ctype'],
			'cid' => $row['cid'],
		);
	}
	/* 遍历自定义是否存在currentPage */
	foreach ($navlist['middle'] as $k => $v) {
		$condition = empty($ctype) ? (strpos($cur_url, $v['url']) === 0) : (strpos($cur_url, $v['url']) === 0 && strlen($cur_url) == strlen($v['url']));
		if ($condition) {
			$navlist['middle'][$k]['active'] = 1;
			$noindex = true;
			$active += 1;
		}
	}
	if (!empty($ctype) && $active < 1) {
		foreach ($catlist as $key => $val) {
			foreach ($navlist['middle'] as $k => $v) {
				if (!empty($v['ctype']) && $v['ctype'] == $ctype && $v['cid'] == $val && $active < 1) {
					$navlist['middle'][$k]['active'] = 1;
					$noindex = true;
					$active += 1;
				}
			}
		}
	}
	if ($noindex == false) {
		$navlist['config']['index'] = 1;
	}
	return $navlist;
}

/**
 * 用户注册，登录函数
 */
function register($username, $password, $email, $other = array()) {
	// $db_users = RC_Loader::load_app_model ( 'users_model' );
	RC_Loader::load_theme('extras/model/user/users_model.class.php');
    $db_users       = new users_model();

	$user = integrate::init_users();

	/* 检查注册是否关闭 */
	$shop_reg_closed = ecjia::config('shop_reg_closed');
	if (!empty($shop_reg_closed)) {
		return new ecjia_error('register', RC_Lang::lang('shop_register_closed'));
	}
	/* 检查username */
	if (empty($username)) {
		return new ecjia_error('register', RC_Lang::lang('username_empty'));
	} else {
		if (preg_match('/\'\/^\\s*$|^c:\\\\con\\\\con$|[%,\\*\\"\\s\\t\\<\\>\\&\'\\\\]/', $username)) {
			return new ecjia_error('register', sprintf(RC_Lang::lang('username_invalid'), htmlspecialchars($username)));
		}
	}
	/* 检查email */
	if (empty($email)) {
		return new ecjia_error('register', RC_Lang::lang('email_empty'));
	} else {
		if (!is_email($email)) {
			return new ecjia_error('register', sprintf(RC_Lang::lang('email_invalid'), htmlspecialchars($email)));
		}
	}
	if (user_registered($username)) {
		return new ecjia_error('register', sprintf(RC_Lang::lang('username_exist'), $username));
	}
	if (mail_registered($email)) {
		return new ecjia_error('register', sprintf(RC_Lang::lang('email_exist'), $email));
	}
	if (!$user->add_user($username, $password, $email)) {
		if ($user->error == ERR_INVALID_USERNAME) {
			return new ecjia_error('register', sprintf(RC_Lang::lang('username_invalid'), $username));
		} elseif ($user->error == ERR_USERNAME_NOT_ALLOW) {
			return new ecjia_error('register', sprintf(RC_Lang::lang('username_not_allow'), $username));
		} elseif ($user->error == ERR_USERNAME_EXISTS) {
			return new ecjia_error('register', sprintf(RC_Lang::lang('username_exist'), $username));
		} elseif ($user->error == ERR_INVALID_EMAIL) {
			return new ecjia_error('register', sprintf(RC_Lang::lang('email_invalid'), $email));
		} elseif ($user->error == ERR_EMAIL_NOT_ALLOW) {
			return new ecjia_error('register', sprintf(RC_Lang::lang('email_not_allow'), $email));
		} elseif ($user->error == ERR_EMAIL_EXISTS) {
			return new ecjia_error('register', sprintf(RC_Lang::lang('email_exist'), $email));
		} else {
			return new ecjia_error('register', 'UNKNOWN ERROR!');
		}
	} else {
		/*注册成功*/
		/* 设置成登录状态 */
		$user->set_session($username);
		$user->set_cookie($username);
		/* 注册送积分 */
		$register_points = ecjia::config('register_points');
		if (!empty($register_points)) {
			log_account_change($_SESSION['user_id'], 0, 0, ecjia::config('register_points'), ecjia::config('register_points'), RC_Lang::lang('register_points'));
		}
		/*定义other合法的变量数组*/
		$other_key_array = array('msn', 'qq', 'office_phone', 'home_phone', 'mobile_phone', 'parent_id');
		$update_data['reg_time'] = RC_Time::local_strtotime(RC_Time::local_date('Y-m-d H:i:s'));
		if ($other) {
			foreach ($other as $key => $val) {
				/*删除非法key值*/
				if (!in_array($key, $other_key_array)) {
					unset($other[$key]);
				} else {
					$other[$key] = htmlspecialchars(trim($val)); //防止用户输入javascript代码
				}
			}
			$update_data = array_merge($update_data, $other);
		}
		$condition['user_id'] = $_SESSION['user_id'];
		$db_users->where($condition)->update($update_data);
		/* 推荐处理 */
		$affiliate = unserialize(ecjia::config('affiliate'));
		if (isset($affiliate['on']) && $affiliate['on'] == 1) {
			// 推荐开关开启
			$up_uid = get_affiliate();
			empty($affiliate) && $affiliate = array();
			$affiliate['config']['level_register_all'] = intval($affiliate['config']['level_register_all']);
			$affiliate['config']['level_register_up'] = intval($affiliate['config']['level_register_up']);
			if ($up_uid) {
				if (!empty($affiliate['config']['level_register_all'])) {
					if (!empty($affiliate['config']['level_register_up'])) {
						$res = $this->row("SELECT rank_points FROM " . $this->pre . "users WHERE user_id = '$up_uid'");
						if ($res['rank_points'] + $affiliate['config']['level_register_all'] <= $affiliate['config']['level_register_up']) {
							log_account_change($up_uid, 0, 0, $affiliate['config']['level_register_all'], 0, sprintf(RC_Lang::lang('register_affiliate'), $_SESSION['user_id'], $username));//model('ClipsBase')->
						}
					} else {
						log_account_change($up_uid, 0, 0, $affiliate['config']['level_register_all'], 0, RC_Lang::lang('register_affiliate'));
					}
				}
				//设置推荐人
				$db_users->where(array('user_id'=>$_SESSION['user_id']))->update(array('parent_id'=>$up_uid));
			}
		}
		update_user_info(); // 更新用户信息
		recalculate_price(); // 重新计算购物车中的商品价格
		return true;
	}
}

/**
 * 判断超级管理员用户名是否存在
 */
function user_registered($username) {
	// $db_users = RC_Loader::load_app_model ( 'users_model' );
	RC_Loader::load_theme('extras/model/user/users_model.class.php');
    $db_users       = new users_model();
	return $db_users->where(array('user_name'=>$username))->count('*');
}

/**
 * 判断用户邮箱是否存在
 */
function mail_registered($email) {
	// $db_users = RC_Loader::load_app_model ( 'users_model' );
	RC_Loader::load_theme('extras/model/user/users_model.class.php');
    $db_users       = new users_model();
	RC_Loader::load_theme('extras/model/user/users_model.class.php');
    $db_users       = new users_model();
	return $db_users->where(array('email'=>$email))->count('*');
}

/**
* 获取邮件模板
*/
function get_mail_template($tpl_name) {
	// $db_mail_templates = RC_Loader::load_app_model ( "mail_templates_model" );
	RC_Loader::load_theme('extras/model/user/user_mail_templates_model.class.php');
    $db_mail_templates       = new user_mail_templates_model();
	$field = 'template_subject, is_html, template_content';
	$where = array('template_code'=>$tpl_name);
	return $db_mail_templates->field($field)->where($where)->find();
}

/**
 * 获取推荐uid
 */
function get_affiliate() {
	// $db_users = RC_Loader::load_app_model ( "users_model" );
	RC_Loader::load_theme('extras/model/user/users_model.class.php');
    $db_users       = new users_model();
	if (!empty($_COOKIE['ecshop_affiliate_uid'])) {
		$uid = intval($_COOKIE['ecshop_affiliate_uid']);
		$user_id = $db_users->field('user_id')->where(array('user_id'=>$uid))->get_field();
		if ($user_id) {
			return $uid;
		} else {
			setcookie('ecshop_affiliate_uid', '', 1);
		}
	}
	elseif($_SESSION['user_id'] !== 0){
		//推荐 by ecmoban
		$reg_info = $db_users->field('reg_time, parent_id')->where(array('user_id'=>$_SESSION['user_id']))->find();
		//推荐信息
		$config = unserialize(ecjia::config('affiliate'));
		if (!empty($config['config']['expire'])) {
			if ($config['config']['expire_unit'] == 'hour') {
				$c = 1;
			} elseif ($config['config']['expire_unit'] == 'day') {
				$c = 24;
			} elseif ($config['config']['expire_unit'] == 'week') {
				$c = 24 * 7;
			} else {
				$c = 1;
			}
			//有效时间
			$eff_time = 3600 * $config['config']['expire'] * $c;
			//有效时间内
			if(RC_Time::gmtime() - $reg_info['reg_time'] <= $eff_time){
				return $reg_info['parent_id'];
			}
		}
	}
	return 0;
}

/**
 * 取得商品最终使用价格
 */
function get_final_price($goods_id, $goods_num = '1', $is_spec_price = false, $spec = array())
{
	// $db_goods_viewmodel = RC_Loader::load_app_model ( 'goods_viewmodel' );
	RC_Loader::load_theme('extras/model/user/user_goods_viewmodel.class.php');
    $db_goods_viewmodel       = new user_goods_viewmodel();
	$final_price = '0'; // 商品最终购买价格
	$volume_price = '0'; // 商品优惠价格
	$promote_price = '0'; // 商品促销价格
	$user_price = '0'; // 商品会员价格
	// 取得商品优惠价格列表
	$price_list = get_volume_price_list ( $goods_id, '1' );
	if (! empty ( $price_list )) {
		foreach ( $price_list as $value ) {
			if ($goods_num >= $value ['number']) {
				$volume_price = $value ['price'];
			}
		}
	}
	// 取得商品促销价格列表
	$goods = $db_goods_viewmodel->join ( 'member_price' )->find (array('g.goods_id' => $goods_id, 'g.is_delete' => 0));
	/* 计算商品的促销价格 */
	if ($goods ['promote_price'] > 0) {
		$promote_price = bargain_price ( $goods ['promote_price'], $goods ['promote_start_date'], $goods ['promote_end_date'] );
	} else {
		$promote_price = 0;
	}
	// 取得商品会员价格列表
	$user_price = $goods ['shop_price'];
	// 比较商品的促销价格，会员价格，优惠价格
	if (empty ( $volume_price ) && empty ( $promote_price )) {
		// 如果优惠价格，促销价格都为空则取会员价格
		$final_price = $user_price;
	} elseif (! empty ( $volume_price ) && empty ( $promote_price )) {
		// 如果优惠价格为空时不参加这个比较。
		$final_price = min ( $volume_price, $user_price );
	} elseif (empty ( $volume_price ) && ! empty ( $promote_price )) {
		// 如果促销价格为空时不参加这个比较。
		$final_price = min ( $promote_price, $user_price );
	} elseif (! empty ( $volume_price ) && ! empty ( $promote_price )) {
		// 取促销价格，会员价格，优惠价格最小值
		$final_price = min ( $volume_price, $promote_price, $user_price );
	} else {
		$final_price = $user_price;
	}
	// 如果需要加入规格价格
	if ($is_spec_price) {
		if (! empty ( $spec )) {
			$spec_price = spec_price ( $spec );
			$final_price += $spec_price;
		}
	}
	// 返回商品最终购买价格
	return $final_price;
}

/**
 * 取得商品优惠价格列表
 */
function get_volume_price_list($goods_id, $price_type = '1') {
	// $db = RC_Loader::load_app_model ( 'volume_price_model' );
	RC_Loader::load_theme('extras/model/user/user_volume_price_model.class.php');
    $db       = new user_volume_price_model();
	$volume_price = array ();
	$temp_index = '0';
	$res = $db->field ('`volume_number` , `volume_price`')->where(array('goods_id' => $goods_id, 'price_type' => $price_type))->order ('`volume_number` asc')->select();
	if (! empty ( $res )) {
		foreach ( $res as $k => $v ) {
			$volume_price [$temp_index] = array ();
			$volume_price [$temp_index] ['number'] = $v ['volume_number'];
			$volume_price [$temp_index] ['price'] = $v ['volume_price'];
			$volume_price [$temp_index] ['format_price'] = price_format ( $v ['volume_price'] );
			$temp_index ++;
		}
	}
	return $volume_price;
}

/**
 * 获得指定的规格的价格
 */
function spec_price($spec) {
	// $db = RC_Loader::load_app_model ( 'goods_attr_model' );
	RC_Loader::load_theme('extras/model/user/user_goods_attr_model.class.php');
    $db       = new user_goods_attr_model();
	if (! empty ( $spec )) {
		if (is_array ( $spec )) {
			foreach ( $spec as $key => $val ) {
				$spec [$key] = addslashes ( $val );
			}
		} else {
			$spec = addslashes ( $spec );
		}
		$price = $db->in(array('goods_attr_id' => $spec))->sum('`attr_price`|attr_price');
	} else {
		$price = 0;
	}
	return $price;
}

/**
 *  用户进行密码找回操作时，发送一封确认邮件
 */
function send_pwd_email($uid, $user_name, $email, $code) {
	if (empty($uid) || empty($user_name) || empty($email) || empty($code)) {
		return false;
	}

	/* 设置重置邮件模板所需要的内容信息 */
	$template = get_mail_template('send_password');
	$reset_email = RC_Uri::url('user/index/get_password_email', array('uid' => $uid, 'code' => $code));
	ecjia_front::$controller->assign('user_name', $user_name);
	ecjia_front::$controller->assign('reset_email', $reset_email);
	ecjia_front::$controller->assign('shop_name', ecjia::config('shop_name'));
	ecjia_front::$controller->assign('send_date', date('Y-m-d'));
	ecjia_front::$controller->assign('sent_date', date('Y-m-d'));
	ecjia_front::$controller->assign_lang();
	$content = ecjia_front::$controller->fetch_string($template['template_content']);
	/* 发送确认重置密码的确认邮件 */
	if (RC_Mail::send_mail('', $email, $template['template_subject'], $content, $template['is_html'])) {
		return true;
	} else {
		return false;
	}
}

/**
 * 获取订单数量
 */
function get_order_num() {
	// $db_order_info = RC_Loader::load_app_model ('order_info_viewmodel');
	 RC_Loader::load_theme('extras/model/user/user_order_info_viewmodel.class.php');
        $db_order_info       = new user_order_info_viewmodel();
	// $db_mesages_info = RC_Loader::load_app_model('feedback_model');
        RC_Loader::load_theme('extras/model/user/user_feedback_model.class.php');
        $db_mesages_info       = new user_feedback_model();
	// $db_comment_info = RC_Loader::load_app_model('comment_model');
        RC_Loader::load_theme('extras/model/user/user_comment_model.class.php');
        $db_comment_info       = new user_comment_model();
	// $db_bonus = RC_Loader::load_app_model('user_bonus_viewmodel');
        RC_Loader::load_theme('extras/model/user/user_bonus_viewmodel.class.php');
        $db_bonus       = new user_bonus_viewmodel();
		$db_bonus->view = array(
			'bonus_type' => array(
				'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'		=> 'bt',
				'on'		=> 'ub.bonus_type_id = bt.type_id'
			)
		);
	$where[] = '( p.pay_code = "pay_cod" or pay_status = "2" )';
	$where[] .= '(shipping_status = 0 OR shipping_status = 3 OR shipping_status = 5)';
	$where['user_id'] = $_SESSION['user_id'];
	$where['order_status'] = array('neq' => 2);
	$cur_date = RC_Time::gmtime();
	$where_success = array(
		'user_id'			=> $_SESSION['user_id'],
		'pay_status'		=> PS_PAYED,
		'order_status' 		=> array('neq' => OS_CANCELED),
		'shipping_status'	=> SS_RECEIVED
	);
	return array(
		'unpayed'		=> intval($db_order_info->join(array('order_goods','payment'))->where(array('user_id' => $_SESSION['user_id'], 'pay_status' => PS_UNPAYED, 'pay_code' => array('neq'=> 'pay_cod'), 'order_status' => array('neq' => 2)))->count('distinct oi.order_id')),
		'unshipped'		=> intval($db_order_info->join(array('order_goods','payment'))->where($where)->count('distinct oi.order_id')),
		'confiroed'		=> intval($db_order_info->join('order_goods')->where(array('user_id' => $_SESSION['user_id'], 'shipping_status' 	=> SS_SHIPPED, 'order_status' => array('neq' => 2)))->count('distinct oi.order_id')),
		'success_order'	=> intval($db_order_info->join('order_goods')->where($where_success)->count('distinct oi.order_id')),
		'msg_num'		=> intval($db_mesages_info->where(array('user_id'=> $_SESSION['user_id'], 'parent_id' => 0, 'user_name' => $_SESSION['user_name'], 'order_id' => 0))->count('*')),
		'comment'		=> intval($db_comment_info->where(array('user_id'=> $_SESSION['user_id']))->count('*')),
		'bonus'	    	=> intval($db_bonus->join(array('bonus_type'))->where(array('use_start_date'	=> array('elt'=>$cur_date), 'use_end_date'=> array('gt'=>$cur_date),'order_id'=> 0, 'ub.user_id' => $_SESSION['user_id']))->count('*')),
	);
}

//end
