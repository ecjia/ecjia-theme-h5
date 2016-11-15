<?php
defined ( 'IN_ECJIA' ) or exit ( 'No permission resources.' );

/**
 * 计算折扣：根据购物车和优惠活动
 * @return  float   折扣
 */
function compute_discount() {
	// $db_favourable_activity = RC_Loader::load_app_model('favourable_activity_model');
	RC_Loader::load_theme('extras/model/cart/cart_favourable_activity_model.class.php');
    $db_favourable_activity = new cart_favourable_activity_model();
	// $db_cart_viewmodel = RC_Loader::load_app_model('cart_viewmodel');
	RC_Loader::load_theme('extras/model/cart/cart_viewmodel.class.php');
    $db_cart_viewmodel = new cart_viewmodel();
	/* 查询优惠活动 */
	$now =RC_Time::gmtime();
	$user_rank = ',' . $_SESSION['user_rank'] . ',';
	$favourable_list = $db_favourable_activity->where("start_time <= '$now' AND end_time >= '$now' AND CONCAT(',', user_rank, ',') LIKE '%" . $user_rank . "%'" ." AND act_type " . db_create_in(array(FAT_DISCOUNT, FAT_PRICE)))->select();
	if (empty($favourable_list)) {
		return 0;
	}
	/* 查询购物车商品 */
	$field = 'c.goods_id, c.goods_price * c.goods_number|subtotal, g.cat_id, g.brand_id';
	$where = array(
		'c.session_id'	=> SESS_ID,
		'c.parent_id'	=> 0,
		'c.is_gift'		=> 0,
		'rec_type'		=> CART_GENERAL_GOODS
	);
	$goods_list = $db_cart_viewmodel->join('goods')->field($field)->where($where)->select();
	if (!$goods_list) {
		return 0;
	}
	/* 初始化折扣 */
	$discount = 0;
	$favourable_name = array();
	/* 循环计算每个优惠活动的折扣 */
	foreach ($favourable_list as $favourable) {
		$total_amount = 0;
		if ($favourable['act_range'] == FAR_ALL) {
			foreach ($goods_list as $goods) {
				$total_amount += $goods['subtotal'];
			}
		} elseif ($favourable['act_range'] == FAR_CATEGORY) {
			/* 找出分类id的子分类id */
			$id_list = array();
			$raw_id_list = explode(',', $favourable['act_range_ext']);
			foreach ($raw_id_list as $id) {
				$id_list = array_merge($id_list, array_keys(cat_list($id, 0, false)));
			}
			$ids = join(',', array_unique($id_list));
			foreach ($goods_list as $goods) {
				if (strpos(',' . $ids . ',', ',' . $goods['cat_id'] . ',') !== false) {
					$total_amount += $goods['subtotal'];
				}
			}
		} elseif ($favourable['act_range'] == FAR_BRAND) {
			foreach ($goods_list as $goods) {
				if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['brand_id'] . ',') !== false) {
					$total_amount += $goods['subtotal'];
				}
			}
		} elseif ($favourable['act_range'] == FAR_GOODS) {
			foreach ($goods_list as $goods) {
				if (strpos(',' . $favourable['act_range_ext'] . ',', ',' . $goods['goods_id'] . ',') !== false) {
					$total_amount += $goods['subtotal'];
				}
			}
		} else {
			continue;
		}
		/* 如果金额满足条件，累计折扣 */
		if ($total_amount > 0 && $total_amount >= $favourable['min_amount'] && ($total_amount <= $favourable['max_amount'] || $favourable['max_amount'] == 0)) {
			if ($favourable['act_type'] == FAT_DISCOUNT) {
				$discount += $total_amount * (1 - $favourable['act_type_ext'] / 100);

				$favourable_name[] = $favourable['act_name'];
			} elseif ($favourable['act_type'] == FAT_PRICE) {
				$discount += $favourable['act_type_ext'];

				$favourable_name[] = $favourable['act_name'];
			}
		}
	}
	return array('discount' => $discount, 'name' => $favourable_name);
}


/**
 * 取得商品最终使用价格
 *
 * @param string $goods_id
 *        	商品编号
 * @param string $goods_num
 *        	购买数量
 * @param boolean $is_spec_price
 *        	是否加入规格价格
 * @param mix $spec
 *        	规格ID的数组或者逗号分隔的字符串
 *
 * @return 商品最终购买价格
 */
function get_final_price($goods_id, $goods_num = '1', $is_spec_price = false, $spec = array()) {

	// $db_goods_viewmodel = RC_Loader::load_app_model ( 'goods_viewmodel' );
		RC_Loader::load_theme('extras/model/cart/cart_goods_viewmodel.class.php');
    $db_goods_viewmodel = new cart_goods_viewmodel();
	$final_price = '0'; // 商品最终购买价格
	$volume_price = '0'; // 商品优惠价格
	$promote_price = '0'; // 商品促销价格
	$user_price = '0'; // 商品会员价格
	/*取得商品优惠价格列表*/
	$price_list = get_volume_price_list ( $goods_id, '1' );
	if (! empty ( $price_list )) {
		foreach ( $price_list as $value ) {
			if ($goods_num >= $value ['number']) {
				$volume_price = $value ['price'];
			}
		}
	}
	/*取得商品促销价格列表*/
	$goods = $db_goods_viewmodel->join ( 'member_price' )->find (array('g.goods_id' => $goods_id, 'g.is_delete' => 0));
	/* 计算商品的促销价格 */
	if ($goods ['promote_price'] > 0) {
		$promote_price = bargain_price ( $goods ['promote_price'], $goods ['promote_start_date'], $goods ['promote_end_date'] );
	} else {
		$promote_price = 0;
	}
	/*取得商品会员价格列表*/
	$user_price = $goods ['shop_price'];
	/*比较商品的促销价格，会员价格，优惠价格*/
	if (empty ( $volume_price ) && empty ( $promote_price )) {
		/*如果优惠价格，促销价格都为空则取会员价格*/
		$final_price = $user_price;
	} elseif (! empty ( $volume_price ) && empty ( $promote_price )) {
		/*如果优惠价格为空时不参加这个比较。*/
		$final_price = min ( $volume_price, $user_price );
	} elseif (empty ( $volume_price ) && ! empty ( $promote_price )) {
		/*如果促销价格为空时不参加这个比较。*/
		$final_price = min ( $promote_price, $user_price );
	} elseif (! empty ( $volume_price ) && ! empty ( $promote_price )) {
		/*取促销价格，会员价格，优惠价格最小值*/
		$final_price = min ( $volume_price, $promote_price, $user_price );
	} else {
		$final_price = $user_price;
	}
	/*如果需要加入规格价格*/
	if ($is_spec_price) {
		if (! empty ( $spec )) {
			$spec_price = spec_price ( $spec );
			$final_price += $spec_price;
		}
	}
	/*返回商品最终购买价格*/
	return $final_price;
}

/**
 * 取得商品优惠价格列表
 *
 * @param string $goods_id
 *        	商品编号
 * @param string $price_type
 *        	价格类别(0为全店优惠比率，1为商品优惠价格，2为分类优惠比率)
 *
 * @return 优惠价格列表
 */
function get_volume_price_list($goods_id, $price_type = '1') {
	// $db = RC_Loader::load_app_model ( 'volume_price_model' );
		RC_Loader::load_theme('extras/model/cart/cart_volume_price_model.class.php');
    $db = new cart_volume_price_model();
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
 * 获得购物车中的商品
 *
 * @access  public
 * @return  array
 */
function get_cart_goods() {
    // $db_cart        = RC_Loader::load_app_model('cart_model');
    	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db_cart = new cart_model();
    // $db_goods       = RC_Loader::load_app_model('cart_goods_model');
     	RC_Loader::load_theme('extras/model/cart/cart_goods_model.class.php');
    $db_goods = new cart_goods_model();
    // $db_goods_attr  = RC_Loader::load_app_model('goods_attr_model');
//    RC_Loader::load_theme('extras/model/cart/cart_goods_attr_model.class.php');
//    $db_goods_attr = new cart_goods_attr_model();
    // $db_group = RC_Loader::load_app_model('group_goods_model');
    RC_Loader::load_theme('extras/model/cart/cart_group_goods_model.class.php');
    $db_group = new cart_group_goods_model();
    /* 初始化 */
    $goods_list = array();
    $total = array(
        'goods_price'   => 0, // 本店售价合计（有格式）
        'market_price'  => 0, // 市场售价合计（有格式）
        'saving'        => 0, // 节省金额（有格式）
        'save_rate'     => 0, // 节省百分比
        'goods_amount'  => 0, // 本店售价合计（无格式）
        'total_number'  => 0,
        );
    /* 循环、统计 */
    $where = array(
        'session_id'    => SESS_ID,
        'rec_type'      => CART_GENERAL_GOODS
        );
    $res = $db_cart->field('*, IF(parent_id, parent_id, goods_id)|pid')->where($where)->order('pid, parent_id')->select();
    /* 用于统计购物车中实体商品和虚拟商品的个数 */
    $virtual_goods_count = 0;
    $real_goods_count = 0;
    foreach ($res as $row) {

		$row['goods_attr'] 		= empty($row['goods_attr'])? '' :'<span>'.str_replace(" \n", '</span><span>', $row['goods_attr']).'</span>';
        $total['total_number']  += $row['goods_number'];
        $total['goods_price']   += $row['goods_price'] * $row['goods_number'];
        $total['market_price']  += $row['market_price'] * $row['goods_number'];
        $row['subtotal']        = price_format($row['goods_price'] * $row['goods_number'], false);
        $row['goods_price']     = price_format($row['goods_price'], false);
        $row['market_price']    = price_format($row['market_price'], false);
        /* 统计实体商品和虚拟商品的个数 */
        $row['is_real'] ? $real_goods_count++ : $virtual_goods_count++;
        /* 增加是否在购物车里显示商品图 */
        if ((ecjia::config('show_goods_in_cart') == "2" || ecjia::config('show_goods_in_cart') == "3") && $row['extension_code'] != 'package_buy') {
            $goods_thumb = $db_goods->where(array('goods_id'=>$row['goods_id']))->get_field('goods_thumb');
            $row['goods_thumb'] = get_image_path($row['goods_id'], $goods_thumb, true);
        }
        if ($row['extension_code'] == 'package_buy') {
            $row['package_goods_list'] = get_package_goods($row['goods_id']);
        }
        $row['favourable'] = favourable_list_flow($_SESSION['user_rank']);
        /*获取库存*/
        $row['goods_max_number'] = $db_goods->where(array('goods_id'=>$row['goods_id']))->get_field('goods_number');
        // $goods_list[$row['goods_id']] = $row;
        $goods_list[] = $row;
    }
    /*取得优惠活动*/
    $fitting = array_column($db_group->field('parent_id')->group('parent_id')->select(), 'parent_id');
    foreach ($goods_list as $key => $value) {
        if(in_array($value['goods_id'], $fitting)){
            $goods_list[$key]['fitting'] = $value['goods_id'];
        }
    }
    $total['goods_amount'] = $total['goods_price'];
    $total['saving'] = price_format($total['market_price'] - $total['goods_price'], false);
    if ($total['market_price'] > 0) {
        $total['save_rate'] = $total['market_price'] ? round(($total['market_price'] - $total['goods_price']) * 100 / $total['market_price']) . '%' : 0;
    }
    $total['goods_price'] = price_format($total['goods_price'], false);
    $total['market_price'] = price_format($total['market_price'], false);
    $total['real_goods_count'] = $real_goods_count;
    $total['virtual_goods_count'] = $virtual_goods_count;
    return array('goods_list' => $goods_list, 'total' => $total);
}

// end
