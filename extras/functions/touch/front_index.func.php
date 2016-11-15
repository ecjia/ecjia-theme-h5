<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 取得自定义导航栏列表
 */
function get_touch_nav($ctype = '', $catlist = array()) {
	// $db_nav = RC_Loader::load_app_model ( 'nav_model' );
    RC_Loader::load_theme('extras/model/touch/touch_nav_model.class.php');
    $db_nav = new touch_nav_model();
	$res = $db_nav->where(array('ifshow' => '1', 'type' => 'touch'))->order('type, vieworder')->select();
	$navlist = array();
	foreach ($res as $key => $row) {
		$tmp_str = str_replace(array('&icon=','&bgc='), '&var|', $row['url']);
		$tmp_arr = explode('&var|', $tmp_str);
		$row['url'] = preg_match("/^https?:\/\//i", $tmp_arr[0]) ? $tmp_arr[0] : RC_Uri::site_url($tmp_arr[0]);
		if(!empty($tmp_arr[1])){
			$row['icon'] = RC_Upload::upload_url($tmp_arr[1]);
		}else{
			$row['icon'] = '';
		}
		$row['bgc'] = isset($tmp_arr[2]) ? $tmp_arr[2] : '';
		$navlist[$row['type']][] = array(
			'name' => $row['name'],
			'icon' => $row['icon'],
			'bgc' => $row['bgc'],
			'opennew' => $row['opennew'],
			'url' => $row['url'],
			'ctype' => $row['ctype'],
			'cid' => $row['cid'],
		);
	}
	return $navlist;
}

/**
 * 获取推荐商品
 */
function goods_list($type = 'best', $limit, $page) {
	// $db_goods_viewmodel = RC_Loader::load_app_model('goods_viewmodel');
	// $db_collect_goods = RC_Loader::load_app_model('collect_goods_model');

	RC_Loader::load_theme('extras/model/touch/touch_goods_viewmodel.class.php');
	RC_Loader::load_theme('extras/model/touch/touch_collect_goods_model.class.php');
	$db_goods_viewmodel = new touch_goods_viewmodel();
	$db_collect_goods = new touch_collect_goods_model();
	$where = array(
		'is_on_sale' => 1,
		'is_alone_sale' => 1,
		'is_delete' => 0
	);
	if (!empty($type)) {
		switch ($type) {
			case 'best':
				$where['is_best'] = 1;
				break;
			case 'new':
				$where['is_new'] = 1;
				break;
			case 'hot':
				$where['is_hot'] = 1;
				break;
			case 'promotion':
				$time = RC_Time::gmtime();
				$where['promote_price'] = array('gt' => 0);
				$where['promote_start_date'] = array('elt' => $time);
				$where['promote_end_date'] = array('egt' => $time);
				break;
			default:
				$intro   = '';
		}
	}
	$field = "g.goods_id, g.goods_name, g.goods_name_style, g.market_price, g.is_new, g.is_best, g.is_hot, g.shop_price AS org_price,".
		"IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price, ".
		"g.promote_price, g.promote_start_date, g.promote_end_date, g.goods_thumb, g.goods_img, g.goods_brief, g.goods_type, RAND() AS rnd ";
	$order_by = array('sort_order' => 'asc', 'last_update' => 'desc');
	/*获取到商品数据*/
	$count = $db_goods_viewmodel->join('member_price')->field($field)->where($where)->order($order_by)->count('*');
	$pages = new ecjia_page($count, $limit, 6, '', $page);
	$result = $db_goods_viewmodel->join('member_price')->field($field)->where($where)->order($order_by)->limit($pages->limit())->select();
	/*处理商品信息的逻辑*/
	foreach ($result as $key => $vo) {
		if ($vo['promote_price'] > 0) {
			$promote_price = bargain_price($vo['promote_price'], $vo['promote_start_date'], $vo['promote_end_date']);
			$goods[$key]['promote_price'] = $promote_price > 0 ? price_format($promote_price) : '';
		} else {
			$goods[$key]['promote_price'] = '';
		}
		$goods[$key]['id'] = $vo['goods_id'];
		$goods[$key]['name'] = $vo['goods_name'];
		$goods[$key]['brief'] = $vo['goods_brief'];
		$goods[$key]['goods_style_name'] = add_style($vo['goods_name'], $vo['goods_name_style']);
		$goods[$key]['short_name'] = ecjia::config('goods_name_length') > 0 ? RC_String::sub_str($vo['goods_name'], ecjia::config('goods_name_length')) : $vo['goods_name'];
		$goods[$key]['short_style_name'] = add_style($goods[$key] ['short_name'], $vo['goods_name_style']);
		$goods[$key]['market_price'] = $vo['market_price'] <= 0 ? 0 : price_format($vo['market_price']);
		$goods[$key]['shop_price'] = price_format($vo['shop_price']);
		$goods[$key]['thumb'] = get_image_path($vo['goods_id'], $vo['goods_thumb'], true);
		$goods[$key]['goods_img'] = get_image_path($vo['goods_id'], $vo['goods_img']);
		$goods[$key]['url'] = RC_Uri::url('goods/index/init', array('id' => $vo['goods_id']));
		$goods[$key]['sc'] = get_goods_collect($vo['goods_id']);/*商品收藏量*/
		$goods[$key]['mysc'] = 0;
		/*检查是否已经存在于用户的收藏夹*/
		if ($_SESSION ['user_id']) {
			/* 用户自己有没有收藏过 */
			$condition['goods_id'] = $vo['goods_id'];
			$condition['user_id'] = $_SESSION ['user_id'];
			$goods[$key]['mysc'] = $db_collect_goods->where($condition)->count();
		}
		$type_goods[$type][] = $goods[$key];
	}
	$is_last = $page >= $pages->total_pages ? 1 : 0;
	return array('list'=>$type_goods[$type], 'page'=>$pages->show(5), 'desc'=>$pages->page_desc(), 'is_last'=>$is_last);
}

/**
 * 调用某商品的累积收藏
 */
function get_goods_collect($goods_id = 0) {
	// $db_collect_goods = RC_Loader::load_app_model('collect_goods_model');
	RC_Loader::load_theme('extras/model/touch/touch_collect_goods_model.class.php');
	$db_collect_goods = new touch_collect_goods_model();
	return $db_collect_goods->where(array('goods_id'=>$goods_id))->count('*');
}

/**
 * 首页推荐分类
 */
function get_recommend_res() {
	/*加载商品关联会员价格模型*/
	// $db_category_viewmodel = RC_Loader::load_app_model('category_viewmodel');
	RC_Loader::load_theme('extras/model/touch/touch_category_viewmodel.class.php');
	$db_category_viewmodel = new touch_category_viewmodel();
	$cat_recommend_res = $db_category_viewmodel->join('cat_recommend')->select();
	if (!empty($cat_recommend_res)) {
		$cat_rec_array = array();
		foreach ($cat_recommend_res as $cat_recommend_data) {
			$cat_rec[$cat_recommend_data['recommend_type']][] = array(
				'cat_id' => $cat_recommend_data['cat_id'],
				'cat_name' => $cat_recommend_data['cat_name'],
				'url' => RC_Uri::url('goods/category/', array('id' => $cat_recommend_data['cat_id'])),
				'cat_id' => get_parent_id_tree($cat_recommend_data['cat_id']),
				'goods_list' => assign_cat_goods($cat_recommend_data['cat_id'],3)
			);
		}
		return $cat_rec;
	}
}

/*
 * 获得指定商品分类的所有分类
*/
function get_parent_id_tree($parent_id) {
	// $db_category = RC_Loader::load_app_model('category_model');
	RC_Loader::load_theme('extras/model/touch/touch_category_model.class.php');
	$db_category = new touch_category_model();
	$three_c_arr = array();
	$res = $db_category->where(array('parent_id'=>$parent_id, 'is_show'=>1))->count();
	if ($res) {
		$res = $db_category->field('cat_id, cat_name, parent_id, is_show')->where(array('parent_id'=>$parent_id, 'is_show'=>1))->order(array('sort_order'=>'ASC', 'cat_id'=>'ASC'))->select();
		foreach ($res AS $row) {
			if ($row['is_show']) {
				$three_c_arr[$row['cat_id']]['id'] = $row['cat_id'];
				$three_c_arr[$row['cat_id']]['name'] = $row['cat_name'];
				$three_c_arr[$row['cat_id']]['url'] = RC_Uri::url('category/index', array('id' => $row['cat_id']), $row['cat_name']);
			}
		}
	}
	return $three_c_arr;
}

/**
 * 获得指定分类下的商品
 */
function assign_cat_goods($cat_id, $num = 0, $from = 'web', $order_rule = '') {
	// $db_category = RC_Loader::load_app_model ('category_model');
	// $dbview = RC_Loader::load_app_model ('goods_viewmodel');
	RC_Loader::load_theme('extras/model/touch/touch_category_model.class.php');
	RC_Loader::load_theme('extras/model/touch/touch_goods_viewmodel.class.php');
	$db_category = new touch_category_model();
	$dbview = new touch_goods_viewmodel();
	$children = get_children ( $cat_id );
	$order_rule = empty($order_rule) ? array ('g.sort_order' => 'asc','g.goods_id' => 'DESC'):$order_rule;
	$dbview->view = array (
		'member_price' => array (
			'type'     => Component_Model_View::TYPE_LEFT_JOIN,
			'alias'    => 'mp',
			'field'    => "g.goods_id, g.goods_name, g.market_price, g.shop_price AS org_price,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS shop_price,g.promote_price, promote_start_date, promote_end_date, g.goods_brief, g.goods_thumb, g.goods_img",
			'on'       => 'mp.goods_id = g.goods_id and mp.user_rank = ' . $_SESSION ['user_rank'] . ''
		)
	);
	$where = array(
		'is_on_sale' => 1,
		'is_alone_sale' => 1
	);
	if ($num > 0) {
		$res = $dbview->where($where)->in($children)->order ($order_rule)->limit ($num)->select();
	} else {
		$res = $dbview->where($where)->in($children)->order ($order_rule)->select();
	}
	$goods = array ();
	if (! empty ( $res )) {
		foreach ( $res as $idx => $row ) {
			if ($row ['promote_price'] > 0) {
				$promote_price = bargain_price ( $row ['promote_price'], $row ['promote_start_date'], $row ['promote_end_date'] );
				$goods [$idx] ['promote_price'] = $promote_price > 0 ? price_format ( $promote_price ) : '';
			} else {
				$goods [$idx] ['promote_price'] = '';
			}
			$goods [$idx] ['id'] = $row ['goods_id'];
			$goods [$idx] ['name'] = $row ['goods_name'];
			$goods [$idx] ['brief'] = $row ['goods_brief'];
			$goods [$idx] ['market_price'] = price_format ( $row ['market_price'] );
			$goods [$idx] ['short_name'] = ecjia::config ( 'goods_name_length' ) > 0 ? RC_String::sub_str ( $row ['goods_name'], ecjia::config ( 'goods_name_length' ) ) : $row ['goods_name'];
			$goods [$idx] ['shop_price'] = price_format ( $row ['shop_price'] );
			$goods [$idx] ['thumb'] = get_image_path ( $row ['goods_id'], $row ['goods_thumb'], true );
			$goods [$idx] ['goods_img'] = get_image_path ( $row ['goods_id'], $row ['goods_img'] );
			$goods [$idx] ['url'] = RC_Uri::url('goods', array ('gid' => $row ['goods_id']));
		}
	}
	if ($from == 'web') {
		ecjia::$view_object->assign('cat_goods_' . $cat_id, $goods);
	} elseif ($from == 'wap') {
		$cat ['goods'] = $goods;
	}
	/* 分类信息 */
	$cat ['name'] = $db_category->where(array('cat_id' => $cat_id ))->get_field( 'cat_name' );
	$cat ['url'] = RC_Uri::url('category',array ('cid' => $cat_id));
	$cat ['id'] = $cat_id;
	return $cat;
}

/**
 * 获取轮播图方法
 */
function get_cycleimage() {
	$player = RC_Loader::load_app_class('cycleimage_method', 'cycleimage');
	if (empty($player)) {
		return false;
	}
	return $player->player_data(true);
}

/**
 * 获得指定分类下所有底层分类的ID
 */
function get_children($cat = 0) {
	return array('cat_id' => array_unique(array_merge(array($cat), array_keys(cat_list($cat, 0, false)))));
}

//END
