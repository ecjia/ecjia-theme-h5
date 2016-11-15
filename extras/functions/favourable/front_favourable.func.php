<?php
defined ( 'IN_ECJIA' ) or exit ( 'No permission resources.' );

/**
 * 获得分类下的商品
 */
function category_get_goods($children, $brand, $goods, $size, $page, $sort, $order) {
	/* 获得商品列表 */
	// $dbview = RC_Loader::load_app_model('goods_member_viewmodel');
	RC_Loader::load_theme('extras/model/favourable/favourable_goods_member_viewmodel.class.php');
    $dbview = new favourable_goods_member_viewmodel();
	$display = '';
	$where = array(
			'g.is_on_sale' => 1,
			'g.is_alone_sale' => 1,
			'g.is_delete' => 0
	);
	if(!empty($children)){
		$where[]="(".$children ." OR ".get_extension_goods($children).")";
	}
	if ($brand > 0) {
		$where['g.brand_id'] = $brand;
	}
	if(!empty($goods)){
		$where[] = $goods;
	}
	$limit = ($page - 1) * $size;
	/* 获得商品列表 */
	$data = $dbview->join('member_price')->where($where)->order(array($sort => $order))->limit(($page - 1) * $size, $size)->select();
	$arr = array();
	if (! empty($data)) {
		foreach ($data as $row) {
			if ($row['promote_price'] > 0) {
				$promote_price = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
			} else {
				$promote_price = 0;
			}
			/* 处理商品水印图片 */
			$watermark_img = '';
			if ($promote_price != 0) {
				$watermark_img = "watermark_promote_small";
			} elseif ($row['is_new'] != 0) {
				$watermark_img = "watermark_new_small";
			} elseif ($row['is_best'] != 0) {
				$watermark_img = "watermark_best_small";
			} elseif ($row['is_hot'] != 0) {
				$watermark_img = 'watermark_hot_small';
			}

			if ($watermark_img != '') {
				$arr[$row['goods_id']]['watermark_img'] = $watermark_img;
			}

			$arr[$row['goods_id']]['goods_id'] = $row['goods_id'];
			if ($display == 'grid') {
				$arr[$row['goods_id']]['goods_name'] = ecjia::config('goods_name_length') > 0 ? RC_String::sub_str($row['goods_name'], ecjia::config('goods_name_length')) : $row['goods_name'];
			} else {
				$arr[$row['goods_id']]['goods_name'] = $row['goods_name'];
			}
			$arr[$row['goods_id']]['name'] = $row['goods_name'];
			$arr[$row['goods_id']]['goods_brief'] = $row['goods_brief'];
			$arr[$row['goods_id']]['goods_style_name'] = add_style($row['goods_name'], $row['goods_name_style']);
			$arr[$row['goods_id']]['market_price'] = price_format($row['market_price'],false);
			$arr[$row['goods_id']]['shop_price'] = price_format($row['shop_price'],false);
			$arr[$row['goods_id']]['type'] = $row['goods_type'];
			$arr[$row['goods_id']]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
			$arr[$row['goods_id']]['goods_thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
			$arr[$row['goods_id']]['original_img'] = get_image_path($row['goods_id'], $row['original_img'], true);
			$arr[$row['goods_id']]['goods_img'] = get_image_path($row['goods_id'], $row['goods_img']);
			$arr[$row['goods_id']]['url'] = RC_Uri::url('goods/index/init', array('id' => $row['goods_id']), $row['goods_name']);
		}
	}
	return $arr;
}

/**
 * 获得指定分类下所有底层分类的ID
 * @param type $str
 * @return type
 */
function get_children_cat($str) {
	$act_id = explode(',', $str);
	foreach ($act_id as $val) {
		$cat[] = array_unique(array_merge(array($val), array_keys(cat_list($val, 0, false))));
	}
	foreach ($cat as $key => $val) {
		foreach ($val as $k => $v) {
			$res[] = $v;
		}
	}
	return array_unique($res);
}

/**
 * 或许分类总数
 */
function category_get_count($children, $brand, $goods, $min, $max, $ext) {
	// $db_goods_viewmodel = RC_Loader::load_app_model('goods_viewmodel');
	RC_Loader::load_theme('extras/model/favourable/favourable_goods_viewmodel.class.php');
    $db_goods_viewmodel = new favourable_goods_viewmodel();
	$db_goods_viewmodel->view = array(
			'touch_goods' => array(
					'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
					'alias'	=> 'xl',
					'on'	=> "g.goods_id=xl.goods_id"
			),
			'member_price' => array(
					'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
					'alias'	=> 'mp',
					'on'	=> " mp.goods_id = g.goods_id AND mp.user_rank = '$_SESSION[user_rank]'"
			)
		);
    $where = "g.is_on_sale = 1 AND g.is_alone_sale = 1 AND " . "g.is_delete = 0 ";
    if ($children) {
        $where .= " AND ($children OR " . get_extension_goods($children) . ')';
    }
    if ($brand) {
        $where .= " AND $brand ";
    }
    if ($goods) {
        $where .= " AND $goods";
    }
    if ($min > 0) {
        $where .= " AND g.shop_price >= $min ";
    }
    if ($max > 0) {
        $where .= " AND g.shop_price <= $max ";
    }
	$res = $db_goods_viewmodel->join('touch_goods,member_price')->where($where)->find();
    return $res;
}

/**
 * 获取优惠活动的信息和活动banner
 */
function get_activity_info($size, $page) {
	// $db_favourable = RC_Loader::load_app_model('favourable_activity_model');
	RC_Loader::load_theme('extras/model/favourable/favourable_activity_model.class.php');
    $db_favourable = new favourable_activity_model();
	$order = array(
		'sort_order'=>ASC,
		'end_time'=>DESC
	);
	$count = $db_favourable->count('*');
	$pages = new ecjia_page($count, $size, 6, '',$page);
	$res = $db_favourable->field('*')->limit($pages->limit())->order($order)->select();
	$arr = array();
	foreach ($res as $row) {
		$arr[$row['act_id']]['start_time'] = RC_Time::local_date('Y-m-d H:i', $row['start_time']);
		$arr[$row['act_id']]['end_time'] = RC_Time::local_date('Y-m-d H:i', $row['end_time']);
		$arr[$row['act_id']]['url'] = RC_Uri::url('favourable/index/goods_list', array('id' => $row['act_id']));
		$arr[$row['act_id']]['act_name'] = $row['act_name'];
		$arr[$row['act_id']]['act_id'] = $row['act_id'];
// 			$arr[$row['act_id']]['act_banner'] = get_banner_path($row['act_banner']);
	}
	$is_last = $page >= $pages->total_pages ? 1 : 0;
	return array('list'=>$arr, 'page'=>$pages->show(5), 'desc'=>$pages->page_desc(), 'is_last'=>$is_last);
}


/**
 * 获得所有扩展分类属于指定分类的所有商品ID
 *
 * @access  public
 * @param   string $cat_id     分类查询字符串
 * @return  string
 */
function get_extension_goods($cats) {
	// $db_goods_cat = RC_Loader::load_app_model('goods_cat_model');
	RC_Loader::load_theme('extras/model/favourable/favourable_goods_cat_model.class.php');
    $db_goods_cat = new favourable_goods_cat_model();
	$res = $db_goods_cat->where($cats)->get_field('goods_id');
	if ($res !== false) {
		$arr = array();
		foreach ($res as $key => $value) {
			$arr[] = $value['goods_id'];
		}
	}
	return db_create_in($arr, 'g.goods_id');
}

//end
