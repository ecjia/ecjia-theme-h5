<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获得指定分类同级的所有分类以及该分类下的子分类
 */
function get_categories_tree($cat_id = 0) {
	// $db_category = RC_Loader::load_app_model ('category_model');
	 RC_Loader::load_theme('extras/model/goods/goods_category_model.class.php');
        $db_category       = new goods_category_model();
	$count = $db_category->where(array('parent_id' => 0,'is_show' => 1))->count();
	$cat_arr = array();
	if ($count) {
		/* 获取当前分类及其子分类 */
		$res = $db_category->field('cat_id,cat_name,style,parent_id,is_show')->where(array('parent_id' => 0,'is_show'   => 1))->order( array ('sort_order'=> 'asc','cat_id'=> 'asc'))->select();
		foreach ( $res as $key => $row ) {
			$cat_arr [$row ['cat_id']] ['id'] = $row ['cat_id'];
			$cat_arr [$row ['cat_id']] ['name'] = $row ['cat_name'];
			$cat_arr [$row ['cat_id']] ['icon'] = get_image_path('',$row ['style']);
			$cat_arr [$row ['cat_id']] ['url'] = RC_Uri::url( 'top_all', array ('cid' => $row ['cat_id']));
			if(empty($child_category)){
				if(!empty($cat_id)){
					$child_category = get_child_tree ( $cat_id );
				}else{
					$child_category = get_child_tree ( $row ['cat_id'] );
				}
			}
		}
	}
	return array('category' => $cat_arr, 'child' => $child_category);
}

/**
 * 获取子分类列表
 */
function get_child_tree($tree_id = 0) {
	// $db_category = RC_Loader::load_app_model('category_model');
	RC_Loader::load_theme('extras/model/goods/goods_category_model.class.php');
        $db_category       = new goods_category_model();
	$three_arr = array();
	$count = $db_category->where(array('parent_id' => $tree_id, 'is_show' => 1))->count();
	if ($count > 0) {
		$res = $db_category->field('cat_id, cat_name ,style, parent_id, is_show')->where(array('parent_id' => $tree_id, 'is_show' => 1))->order(array('sort_order' => 'asc', 'cat_id' => 'asc'))->select();
		foreach ( $res as $row ) {
			$three_arr [$row ['cat_id']] ['id'] = $row ['cat_id'];
			$three_arr [$row ['cat_id']] ['name'] = $row ['cat_name'];
			$three_arr [$row ['cat_id']] ['url'] = RC_Uri::url('category/goods_list', array ('cid' => $row ['cat_id'] ));
			$three_arr [$row ['cat_id']] ['cat_id'] = get_child_tree ( $row ['cat_id'] );
			if(empty($row ['style'])){
				$three_arr [$row ['cat_id']] ['icon'] = RC_Uri::admin_url('statics/images/nopic.png');
			}else{
				$three_arr [$row ['cat_id']] ['icon'] = get_image_path('',$row ['style']);
			}
		}
	}
	return $three_arr;
}

/**
 * 获得分类的信息
 */
function get_cat_info($cat_id) {
	// $db_category = RC_Loader::load_app_model('category_model');
	 RC_Loader::load_theme('extras/model/goods/goods_category_model.class.php');
        $db_category       = new goods_category_model();
	return $db_category->field('cat_name, keywords, cat_desc, style, grade, filter_attr, parent_id')->
	where(array('cat_id'=>$cat_id))->select();
}

/**
 *  所有的促销活动信息
 */
function get_promotion_show($goods_id = '') {
	// $db_goods = RC_Loader::load_app_model ("goods_model");
	RC_Loader::load_theme('extras/model/goods/goods_model.class.php');
        $db_goods       = new goods_model();
	// $db_goods_activity = RC_Loader::load_app_model ("goods_activity_model");
	 RC_Loader::load_theme('extras/model/goods/goods_activity_model.class.php');
        $db_goods_activity       = new goods_activity_model();
	// $db_favourable_activity = RC_Loader::load_app_model ("favourable_activity_model");
        RC_Loader::load_theme('extras/model/goods/goods_favourable_activity_model.class.php');
        $db_favourable_activity       = new goods_favourable_activity_model();
	$group = array();
	$package = array();
	$favourable = array();
	$gmtime = RC_Time::gmtime();
	$where = array('is_finished'=>0, 'start_time'=>array('elt'=>$gmtime), 'end_time'=>array('gt'=>$gmtime));
	if (!empty($goods_id)) {
		$where['goods_id'] = $goods_id;
	}
	$res = $db_goods_activity->field('act_id, act_name, act_type, start_time, end_time')->where($where)->select();
	if (is_array($res)) {
		foreach ($res as $data) {
			switch ($data['act_type']) {
				case GAT_GROUP_BUY: //团购
				$group[$data['act_id']]['type'] = 'group_buy';
				break;
				case GAT_PACKAGE: //礼包
				$package[$data['act_id']]['type'] = 'package';
				break;
			}
		}
	}
	$user_rank = ',' . $_SESSION['user_rank'] . ',';
	$favourable = array();
	$where = "start_time <= '$gmtime' AND end_time >= '$gmtime'";
	if (!empty($goods_id)) {
		$where .= " AND CONCAT(',', user_rank, ',') LIKE '%" . $user_rank . "%'";
	}
	$res = $db_favourable_activity->field('act_id, act_range, act_type,act_range_ext, act_name, start_time, end_time')->where($where)->select();
	if (empty($goods_id)) {
		foreach ($res as $rows) {
			$favourable[$rows['act_id']]['type'] = 'favourable';
		}
	} else {
		$row = $db_goods->field('cat_id, brand_id')->where(array('goods_id'=>$goods_id))->find();
		$category_id = $row['cat_id'];
		$brand_id = $row['brand_id'];
		foreach ($res as $rows) {
			if ($rows['act_range'] == FAR_ALL) {
				$favourable[$rows['act_id']]['act_type'] = $rows['act_type'];
			} elseif ($rows['act_range'] == FAR_CATEGORY) {
				/* 找出分类id的子分类id */
				$id_list = array();
				$raw_id_list = explode(',', $rows['act_range_ext']);
				foreach ($raw_id_list as $id) {
					$id_list = array_merge($id_list, array_keys(cat_list($id, 0, false)));
				}
				$ids = join(',', array_unique($id_list));
				if (strpos(',' . $ids . ',', ',' . $category_id . ',') !== false) {
					$favourable[$rows['act_id']]['act_type'] = $rows['act_type'];
				}
			} elseif ($rows['act_range'] == FAR_BRAND) {
				if (strpos(',' . $rows['act_range_ext'] . ',', ',' . $brand_id . ',') !== false) {
					$favourable[$rows['act_id']]['act_type'] = $rows['act_type'];
				}
			} elseif ($rows['act_range'] == FAR_GOODS) {
				if (strpos(',' . $rows['act_range_ext'] . ',', ',' . $goods_id . ',') !== false) {
					$favourable[$rows['act_id']]['act_type'] = $rows['act_type'];
				}
			}
		}
	}
	$sort_time = array();
	$arr = array_merge($group, $package, $favourable);
	foreach ($arr as $key => $value) {
		$sort_time[] = $value['sort'];
	}
	array_multisort($sort_time, SORT_NUMERIC, SORT_DESC, $arr);
	return array_unique($arr);
}

// end
