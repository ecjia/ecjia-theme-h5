<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * html代码输出
 */
function html_out($str) {
	if (function_exists('htmlspecialchars_decode')) {
		$str = htmlspecialchars_decode($str);
	} else {
		$str = html_entity_decode($str);
	}
	$str = stripslashes($str);
	return $str;
}

/**
 * 添加商品名样式
 */
function add_style($goods_name, $style) {
	$goods_style_name = $goods_name;

	$arr = explode('+', $style);

	$font_color = !empty($arr[0]) ? $arr[0] : '';
	$font_style = !empty($arr[1]) ? $arr[1] : '';

	if ($font_color != '') {
		$goods_style_name = '<font color=' . $font_color . '>' . $goods_style_name . '</font>';
	}
	if ($font_style != '') {
		$goods_style_name = '<' . $font_style . '>' . $goods_style_name . '</' . $font_style . '>';
	}
	return $goods_style_name;
}

/**
 * 重新获得商品图片与商品相册的地址
 */
function get_image_path($goods_id, $image = '', $thumb = false, $call = 'goods', $del = false)
{
	if (strpos($image, 'http://')) {
		return $image;
	} else {
	 	if (empty($image)) {//!file_exists(RC_Upload::upload_path($image)) ||
            return RC_Uri::admin_url('statics/images/nopic.png');
	 	} else {
		    return RC_Upload::upload_url($image);
	 	}
	}
}

/**
 * 创建像这样的查询: "IN('a','b')";
 */
function db_create_in($item_list, $field_name = '') {
	if (empty($item_list)) {
		return $field_name . " IN ('') ";
	} else {
		if (!is_array($item_list)) {
			$item_list = explode(',', $item_list);
		}
		$item_list = array_unique($item_list);
		$item_list_tmp = '';
		foreach ($item_list AS $item) {
			if ($item !== '') {
				$item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
			}
		}
		if (empty($item_list_tmp)) {
			return $field_name . " IN ('') ";
		} else {
			return $field_name . ' IN (' . $item_list_tmp . ') ';
		}
	}
}

/**
 * 验证输入的手机号是否合法
 */
function is_mobile($user_email) {
	$chars = "/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$/";
	if (preg_match($chars, $user_email)) {
		return true;
	} else {
		return false;
	}
}

/**
 * 分配帮助信息
 */
function get_shop_help() {
	// $db_article = RC_Loader::load_app_model ( "new_article_viewmodel", 'article');
	RC_Loader::load_theme('extras/model/touch/touch_new_article_viewmodel.class.php');
        $db_article       = new touch_new_article_viewmodel();
	$res = $db_article->field('ac.cat_id, ac.cat_name, ac.sort_order, a.article_id, a.title, a.file_url, a.open_type')->order(array('ac.sort_order'=>'ASC', 'a.article_id'=>'DESC'))->select();
	$arr = array();
	foreach ($res AS $key => $row) {
		$arr[$row['cat_id']]['cat_id'] = RC_Uri::url('article_cat', array('acid' => $row['cat_id']), $row['cat_name']);
		$arr[$row['cat_id']]['cat_name'] = $row['cat_name'];
		$arr[$row['cat_id']]['article'][$key]['article_id'] = $row['article_id'];
		$arr[$row['cat_id']]['article'][$key]['title'] = $row['title'];
		$arr[$row['cat_id']]['article'][$key]['short_title'] = ecjia::config('article_title_length') > 0 ?
		RC_String::sub_str($row['title'], ecjia::config('article_title_length')) : $row['title'];
		$arr[$row['cat_id']]['article'][$key]['url'] = $row['open_type'] != 1 ?
		RC_Uri::url('article', array('aid' => $row['article_id']), $row['title']) : trim($row['file_url']);
	}
	return $arr;
}

/**
 * 获得指定分类下的子分类的数组
 */
function cat_list($cat_id = 0, $selected = 0, $re_type = true, $level = 0, $is_show_all = true) {
	// 加载方法
	// $db_goods = RC_Loader::load_app_model('goods_model', 'goods');
	// $db_category = RC_Loader::load_app_model('sys_category_viewmodel', 'goods');
	// $db_goods_cat = RC_Loader::load_app_model('goods_cat_viewmodel', 'goods');
    RC_Loader::load_theme('extras/model/goods/goods_model.class.php');
    RC_Loader::load_theme('extras/model/goods/goods_sys_category_viewmodel.class.php');
	RC_Loader::load_theme('extras/model/goods/goods_goods_cat_viewmodel.class.php');
	$db_goods = new goods_model();
	$db_category = new goods_sys_category_viewmodel();
	$db_goods_cat = new goods_goods_cat_viewmodel();
	static $res = NULL;
	if ($res === NULL) {
		$data = false;
		if ($data === false) {
			$res = $db_category->join('category')->group('c.cat_id')->order(array('c.parent_id' => 'asc', 'c.sort_order' => 'asc'))->select();
			$res2 = $db_goods->field ( 'cat_id, COUNT(*)|goods_num' )->where(array('is_delete' => 0,'is_on_sale' => 1))->group ('cat_id asc')->select();
			$res3 = $db_goods_cat->join('goods')->where(array('g.is_delete' => 0,'g.is_on_sale' => 1))->group ('gc.cat_id')->select();
			$newres = array ();
			foreach($res2 as $k => $v) {
				$newres [$v ['cat_id']] = $v ['goods_num'];
				foreach ( $res3 as $ks => $vs ) {
					if ($v ['cat_id'] == $vs ['cat_id']) {
						$newres [$v ['cat_id']] = $v ['goods_num'] + $vs ['goods_num'];
					}
				}
			}
			if (! empty ( $res )) {
				foreach ( $res as $k => $v ) {
					$res [$k] ['goods_num'] = ! empty($newres [$v ['cat_id']]) ? $newres [$v['cat_id']] : 0;
				}
			}
		} else {
			$res = $data;
		}
	}
	if (empty ( $res ) == true) {
		return $re_type ? '' : array ();
	}
	$options = cat_options ( $cat_id, $res ); // 获得指定分类下的子分类的数组
	$children_level = 99999; // 大于这个分类的将被删除
	if ($is_show_all == false) {
		foreach ( $options as $key => $val ) {
			if ($val ['level'] > $children_level) {
				unset ( $options [$key] );
			} else {
				if ($val ['is_show'] == 0) {
					unset ( $options [$key] );
					if ($children_level > $val ['level']) {
						$children_level = $val ['level']; // 标记一下，这样子分类也能删除
					}
				} else {
					$children_level = 99999; // 恢复初始值
				}
			}
		}
	}
	/* 截取到指定的缩减级别 */
	if ($level > 0) {
		if ($cat_id == 0) {
			$end_level = $level;
		} else {
			$first_item = reset ( $options ); // 获取第一个元素
			$end_level = $first_item ['level'] + $level;
		}
		/* 保留level小于end_level的部分 */
		foreach ( $options as $key => $val ) {
			if ($val ['level'] >= $end_level) {
				unset ( $options [$key] );
			}
		}
	}
	if ($re_type == true) {
		$select = '';
		if (! empty ( $options )) {
			foreach ( $options as $var ) {
				$select .= '<option value="' . $var ['cat_id'] . '" ';
				$select .= ($selected == $var ['cat_id']) ? "selected='ture'" : '';
				$select .= '>';
				if ($var ['level'] > 0) {
					$select .= str_repeat ( '&nbsp;', $var ['level'] * 4 );
				}
				$select .= htmlspecialchars ( addslashes($var ['cat_name'] ), ENT_QUOTES ) . '</option>';
			}
		}
		return $select;
	} else {
		if (! empty($options )) {
			foreach ($options as $key => $value ) {
				$options [$key] ['url'] = RC_Uri::url('category', array('cid' => $value ['cat_id']));
			}
		}
		return $options;
	}
}
/**
 * 过滤和排序所有分类，返回一个带有缩进级别的数组
 */
function cat_options($spec_cat_id, $arr) {
	static $cat_options = array ();
	if (isset ( $cat_options [$spec_cat_id] )) {
		return $cat_options [$spec_cat_id];
	}
	if (! isset ( $cat_options [0] )) {
		$level = $last_cat_id = 0;
		$options = $cat_id_array = $level_array = array ();
		$data = false;
		if ($data === false) {
			while ( ! empty ( $arr ) ) {
				foreach ( $arr as $key => $value ) {
					$cat_id = $value ['cat_id'];
					if ($level == 0 && $last_cat_id == 0) {
						if ($value ['parent_id'] > 0) {
							break;
						}
						$options [$cat_id] = $value;
						$options [$cat_id] ['level'] = $level;
						$options [$cat_id] ['id'] = $cat_id;
						$options [$cat_id] ['name'] = $value ['cat_name'];
						unset ( $arr [$key] );
						if ($value ['has_children'] == 0) {
							continue;
						}
						$last_cat_id = $cat_id;
						$cat_id_array = array (
								$cat_id
						);
						$level_array [$last_cat_id] = ++ $level;
						continue;
					}
					if ($value ['parent_id'] == $last_cat_id) {
						$options [$cat_id] = $value;
						$options [$cat_id] ['level'] = $level;
						$options [$cat_id] ['id'] = $cat_id;
						$options [$cat_id] ['name'] = $value ['cat_name'];
						unset ( $arr [$key] );
						if ($value ['has_children'] > 0) {
							if (end ( $cat_id_array ) != $last_cat_id) {
								$cat_id_array [] = $last_cat_id;
							}
							$last_cat_id = $cat_id;
							$cat_id_array [] = $cat_id;
							$level_array [$last_cat_id] = ++ $level;
						}
					} elseif ($value ['parent_id'] > $last_cat_id) {
						break;
					}
				}
				$count = count ( $cat_id_array );
				if ($count > 1) {
					$last_cat_id = array_pop ( $cat_id_array );
				} elseif ($count == 1) {
					if ($last_cat_id != end ( $cat_id_array )) {
						$last_cat_id = end ( $cat_id_array );
					} else {
						$level = 0;
						$last_cat_id = 0;
						$cat_id_array = array ();
						continue;
					}
				}
				if ($last_cat_id && isset ( $level_array [$last_cat_id] )) {
					$level = $level_array [$last_cat_id];
				} else {
					$level = 0;
				}
			}
		} else {
			$options = $data;
		}
		$cat_options [0] = $options;
	} else {
		$options = $cat_options [0];
	}
	if (! $spec_cat_id) {
		return $options;
	} else {
		if (empty ( $options [$spec_cat_id] )) {
			return array ();
		}
		$spec_cat_id_level = $options [$spec_cat_id] ['level'];
		foreach ( $options as $key => $value ) {
			if ($key != $spec_cat_id) {
				unset ( $options [$key] );
			} else {
				break;
			}
		}
		$spec_cat_id_array = array ();
		foreach ( $options as $key => $value ) {
			if (($spec_cat_id_level == $value ['level'] && $value ['cat_id'] != $spec_cat_id) || ($spec_cat_id_level > $value ['level'])) {
				break;
			} else {
				$spec_cat_id_array [$key] = $value;
			}
		}
		$cat_options [$spec_cat_id] = $spec_cat_id_array;

		return $spec_cat_id_array;
	}
}

/**
 * 获得某个分类下的品牌信息
 */
function get_brands($cat = 0, $app = 'goods_list') {
	// $db = RC_Loader::load_app_model ('brand_viewmodel');
	RC_Loader::load_theme('extras/model/touch/touch_brand_viewmodel.class.php');
	$db = new touch_brand_viewmodel();
	$children = ($cat >= 0) ? array_unique(array_merge(array($cat), array_keys(cat_list($cat, 0, false )))) : '';
	$db->view = array (
		'goods' => array(
			'type'  => Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'g',
			'on'   	=> 'g.brand_id = b.brand_id'
		),
	);
	$where['is_show'] = 1;
	$where['g.is_on_sale'] = 1;
	$where['g.is_alone_sale'] = 1;
	$where['g.is_delete'] = 0;
	$where['g.cat_id'] = $children;
	$field = "b.brand_id, b.brand_name, b.brand_logo, b.brand_desc, COUNT(*) | goods_num, IF(b.brand_logo > '', '1', '0') | tag";
	$row = $db->join('goods')->field($field)->where($where)->group('b.brand_id')->having('goods_num > 0')->order(array('tag'=>'desc','b.sort_order'=>'asc'))->limit(8)->select();
	if (! empty ( $row )) {
		foreach ( $row as $key => $val ) {
			$row [$key] ['url'] = RC_Uri::url( $app, array (
					'cid' => $cat,
					'bid' => $val ['brand_id']
			));
			if (strpos($val['brand_logo'], 'data/brandlogo') !== false ) {
				$row [$key] ['brand_logo'] = RC_Upload::upload_url($val ['brand_logo']);
			} else {
				$row [$key] ['brand_logo'] = RC_Upload::upload_url('data/brandlogo/'.$val ['brand_logo']);
			}
			
			$row [$key] ['brand_desc'] = htmlspecialchars ( $val ['brand_desc'], ENT_QUOTES );
		}
	}
	return $row;
}

/**
 * 获得某个分类下的品牌信息
 */
function get_brands_list($cat = 0, $app = 'goods_list') {
    // $db = RC_Loader::load_app_model ('brand_viewmodel');
RC_Loader::load_theme('extras/model/touch/touch_brand_viewmodel.class.php');
        $db       = new touch_brand_viewmodel();
    $children = ($cat >= 0) ? array_unique(array_merge(array($cat), array_keys(cat_list($cat, 0, false )))) : '';
    $db->view = array (
        'goods' => array(
            'type'  => Component_Model_View::TYPE_LEFT_JOIN,
            'alias' => 'g',
            'on'   	=> 'g.brand_id = b.brand_id'
        ),
    );
    $where['is_show'] = 1;
    $where['g.is_on_sale'] = 1;
    $where['g.is_alone_sale'] = 1;
    $where['g.is_delete'] = 0;
    $where['g.cat_id'] = $children;
    $field = "b.brand_id, b.brand_name, b.brand_logo, b.brand_desc, COUNT(*) | goods_num, IF(b.brand_logo > '', '1', '0') | tag";
    $row = $db->join('goods')->field($field)->where($where)->group('b.brand_id')->having('goods_num > 0')->order(array('tag'=>'desc','b.sort_order'=>'asc'))->select();
    if (! empty ( $row )) {
        foreach ( $row as $key => $val ) {
            $row [$key] ['url'] = RC_Uri::url( $app, array (
                'cid' => $cat,
                'bid' => $val ['brand_id']
            ));
            if (strpos($val['brand_logo'], 'data/brandlogo') !== false ) {
            	$row [$key] ['brand_logo'] = RC_Upload::upload_url($val ['brand_logo']);
            } else {
            	$row [$key] ['brand_logo'] = RC_Upload::upload_url('data/brandlogo/'.$val ['brand_logo']);
            }
            $row [$key] ['brand_desc'] = htmlspecialchars ( $val ['brand_desc'], ENT_QUOTES );
        }
    }
    return $row;
}

/**
 * 所有的促销活动信息
 */
function get_promotion_info($goods_id = '') {
	// $db_goods_activity = RC_Loader::load_app_model ("goods_activity_model", "goods");
	 RC_Loader::load_theme('extras/model/goods/goods_activity_model.class.php');
        $db_goods_activity       = new goods_activity_model();
	// $db_favourable = RC_Loader::load_app_model('favourable_activity_model', 'goods');
	RC_Loader::load_theme('extras/model/goods/goods_favourable_activity_model.class.php');
        $db_favourable       = new goods_favourable_activity_model();
	// $db_goods = RC_Loader::load_app_model ('goods_model', 'goods');
	 RC_Loader::load_theme('extras/model/goods/goods_model.class.php');
        $db_goods       = new goods_model();
	$snatch = array ();
	$group = array ();
	$auction = array ();
	$package = array ();
	$favourable = array ();
	$gmtime = RC_Time::gmtime ();
	$where = array(
		'is_finished'	=> 0,
		'start_time'	=> array('elt'=>$gmtime),
		'end_time'		=> array('gt'=>$gmtime)
	);
	if (! empty ( $goods_id )) {
		$where['goods_id'] = $goods_id;
	}
	$res = $db_goods_activity->field('act_id, act_name, act_type, start_time, end_time')->where($where)->select();
	if (!empty($res)) {
		foreach ($res as $data) {
			switch ($data ['act_type']) {
				//TODO  优惠活动
// 				case GAT_SNATCH : // 夺宝奇兵
// 					$snatch [$data ['act_id']] ['act_name'] = $data ['act_name'];
// 					$snatch [$data ['act_id']] ['url'] = RC_Uri::url ('snatch', array (
// 							'sid' => $data ['act_id']
// 					) );
// 					$snatch [$data ['act_id']] ['time'] = sprintf(RC_Lang::lang ( 'promotion_time' ), RC_Time::local_date ( 'Y-m-d', $data ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $data ['end_time'] ) );
// 					$snatch [$data ['act_id']] ['sort'] = $data ['start_time'];
// 					$snatch [$data ['act_id']] ['type'] = 'snatch';
// 					break;
// 				case GAT_GROUP_BUY : // 团购
// 					$group [$data ['act_id']] ['act_name'] = $data ['act_name'];
// 					$group [$data ['act_id']] ['url'] = RC_Uri::url ( 'group_buy', array (
// 							'gbid' => $data ['act_id']
// 					) );
// 					$group [$data ['act_id']] ['time'] = sprintf ( RC_Lang::lang ( 'promotion_time' ), RC_Time::local_date ( 'Y-m-d', $data ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $data ['end_time'] ) );
// 					$group [$data ['act_id']] ['sort'] = $data ['start_time'];
// 					$group [$data ['act_id']] ['type'] = 'group_buy';
// 					break;
// 				case GAT_AUCTION : // 拍卖
// 					$auction [$data ['act_id']] ['act_name'] = $data ['act_name'];
// 					$auction [$data ['act_id']] ['url'] = RC_Uri::url ( 'auction', array (
// 							'auid' => $data ['act_id']
// 					) );
// 					$auction [$data ['act_id']] ['time'] = sprintf ( RC_Lang::lang ( 'promotion_time' ), RC_Time::local_date ( 'Y-m-d', $data ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $data ['end_time'] ) );
// 					$auction [$data ['act_id']] ['sort'] = $data ['start_time'];
// 					$auction [$data ['act_id']] ['type'] = 'auction';
// 					break;
				case GAT_PACKAGE : // 礼包
					$package [$data ['act_id']] ['act_name'] = $data ['act_name'];
					$package [$data ['act_id']] ['url'] = 'package.php#' . $data ['act_id'];
					$package [$data ['act_id']] ['time'] = sprintf ( RC_Lang::lang ( 'promotion_time' ), RC_Time::local_date ( 'Y-m-d', $data ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $data ['end_time'] ) );
					$package [$data ['act_id']] ['sort'] = $data ['start_time'];
					$package [$data ['act_id']] ['type'] = 'package';
					break;
			}
		}
	}
	$user_rank = ',' . $_SESSION ['user_rank'] . ',';
	$favourable = array ();
	$where = " start_time <= '$gmtime' AND end_time >= '$gmtime'";
	if (! empty ( $goods_id )) {
		$where .= " AND CONCAT(',', user_rank, ',') LIKE '%" . $user_rank . "%'";
	}
	$res  = $db_favourable->field('act_id, act_range, act_range_ext, act_name, start_time, end_time')->where($where)->select();
	if (empty ( $goods_id )) {
		if (!empty($res)) {
			foreach ( $res as $rows ) {
				$favourable [$rows ['act_id']] ['act_name'] = $rows ['act_name'];
				$favourable [$rows ['act_id']] ['url'] = RC_Uri::url('favourable/index/goods_list', array('id' => $rows ['act_id']));
				$favourable [$rows ['act_id']] ['time'] = sprintf ( RC_Lang::lang ( 'promotion_time' ), RC_Time::local_date ( 'Y-m-d', $rows ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $rows ['end_time'] ) );
				$favourable [$rows ['act_id']] ['sort'] = $rows ['start_time'];
				$favourable [$rows ['act_id']] ['type'] = 'favourable';
			}
		}
	} else {
		$row = $db_goods->field('cat_id, brand_id')->find(array('goods_id' => $goods_id));
		$category_id = $row ['cat_id'];
		$brand_id = $row ['brand_id'];
		foreach ( $res as $rows ) {
			if ($rows ['act_range'] == FAR_ALL) {
				$favourable [$rows ['act_id']] ['act_name'] = $rows ['act_name'];
				$favourable [$rows ['act_id']] ['url'] = RC_Uri::url('favourable/index/goods_list', array('id' => $rows ['act_id']));
				$favourable [$rows ['act_id']] ['time'] = sprintf ( RC_Lang::lang ( 'promotion_time' ), RC_Time::local_date ( 'Y-m-d', $rows ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $rows ['end_time'] ) );
				$favourable [$rows ['act_id']] ['sort'] = $rows ['start_time'];
				$favourable [$rows ['act_id']] ['type'] = 'favourable';
			} elseif ($rows ['act_range'] == FAR_CATEGORY) {
				/* 找出分类id的子分类id */
				$id_list = array ();
				$raw_id_list = explode ( ',', $rows ['act_range_ext'] );
				foreach ( $raw_id_list as $id ) {
					$id_list = array_merge ( $id_list, array_keys ( cat_list ( $id, 0, false ) ) );
				}
				$ids = join ( ',', array_unique ( $id_list ) );
				if (strpos ( ',' . $ids . ',', ',' . $category_id . ',' ) !== false) {
					$favourable [$rows ['act_id']] ['act_name'] = $rows ['act_name'];
					$favourable [$rows ['act_id']] ['url'] = RC_Uri::url('favourable/index/goods_list', array('id' => $rows ['act_id']));
					$favourable [$rows ['act_id']] ['time'] = sprintf ( RC_Lang::lang ( 'promotion_time' ), RC_Time::local_date ( 'Y-m-d', $rows ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $rows ['end_time'] ) );
					$favourable [$rows ['act_id']] ['sort'] = $rows ['start_time'];
					$favourable [$rows ['act_id']] ['type'] = 'favourable';
				}
			} elseif ($rows ['act_range'] == FAR_BRAND) {
				if (strpos ( ',' . $rows ['act_range_ext'] . ',', ',' . $brand_id . ',' ) !== false) {
					$favourable [$rows ['act_id']] ['act_name'] = $rows ['act_name'];
					$favourable [$rows ['act_id']] ['url'] = RC_Uri::url('favourable/index/goods_list', array('id' => $rows ['act_id']));
					$favourable [$rows ['act_id']] ['time'] = sprintf ( RC_Lang::lang ( 'promotion_time' ), RC_Time::local_date ( 'Y-m-d', $rows ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $rows ['end_time'] ) );
					$favourable [$rows ['act_id']] ['sort'] = $rows ['start_time'];
					$favourable [$rows ['act_id']] ['type'] = 'favourable';
				}
			} elseif ($rows ['act_range'] == FAR_GOODS) {
				if (strpos ( ',' . $rows ['act_range_ext'] . ',', ',' . $goods_id . ',' ) !== false) {
					$favourable [$rows ['act_id']] ['act_name'] = $rows ['act_name'];
					$favourable [$rows ['act_id']] ['url'] = RC_Uri::url('favourable/index/goods_list', array('id' => $rows ['act_id']));
					$favourable [$rows ['act_id']] ['time'] = sprintf ( RC_Lang::lang ( 'promotion_time' ), RC_Time::local_date ( 'Y-m-d', $rows ['start_time'] ), RC_Time::local_date ( 'Y-m-d', $rows ['end_time'] ) );
					$favourable [$rows ['act_id']] ['sort'] = $rows ['start_time'];
					$favourable [$rows ['act_id']] ['type'] = 'favourable';
				}
			}
		}
	}
	$sort_time = array ();
	$arr = array_merge ( $snatch, $group, $auction, $package, $favourable );
	foreach ( $arr as $key => $value ) {
		$sort_time [] = $value ['sort'];
	}
	array_multisort ( $sort_time, SORT_NUMERIC, SORT_DESC, $arr );
	return $arr;
}

/**
 * 获得指定用户、商品的所有标记
 */
function get_tags($where, $limit=null) {
	// $db_tag = RC_Loader::load_app_model ( "tag_model", "user" );
	RC_Loader::load_theme('extras/model/user/user_tag_model.class.php');
     $db_tag       = new user_tag_model();
	if (empty($where)) {
		return array();
	}
	if (empty($limit)) {
		$arr = $db_tag->field('tag_id, user_id, tag_words, COUNT(tag_id)|tag_count')->where($where)->group('tag_words')->select();
	} else {
		$arr = $db_tag->field('tag_id, user_id, tag_words, COUNT(tag_id)|tag_count')->where($where)->group('tag_words')->limit($limit)->select();
	}
	return $arr;
}

/**
 * 判断某个商品是否正在特价促销期
 */
function bargain_price($price, $start, $end) {
	if ($price == 0) {
		return 0;
	} else {
		$time = RC_Time::gmtime();
		if ($time >= $start && $time <= $end) {
			return $price;
		} else {
			return 0;
		}
	}
}

/**
 * 调用浏览历史
 */
function insert_search() {
    $str = '';
    return empty($_COOKIE ['ECJia'] ['search']) ? array() : explode(',', $_COOKIE ['ECJia'] ['search']);
}

/**
 * 获取用户头像
 */
function get_user_img($user_id){
	RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
	$db = new touch_users_model();
	$user_info = $db->field('user_name')->find(array('user_id' => $user_id));
	$uid = sprintf("%09d", $user_id);//格式化uid字串， d 表示把uid格式为9位数的整数，位数不够的填0

	$dir1 = substr($uid, 0, 3);//把uid分段
	$dir2 = substr($uid, 3, 2);
	$dir3 = substr($uid, 5, 2);

	$filename = md5($user_info['user_name']);
	$avatar_path = RC_Upload::upload_path().'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2)."_".$filename.'.jpg';

	if(!file_exists($avatar_path)) {
		$avatar_img = RC_Theme::get_template_directory_uri().'/dist/images/default_userimg.png';
	} else {
		$avatar_img = RC_Upload::upload_url().'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2)."_".$filename.'.jpg';
	}

	return $avatar_img;
}
// end
