<?php
defined ( 'IN_ECJIA' ) or exit ( 'No permission resources.' );

/**
 * 是否存在规格
 */
function is_spec($goods_attr_id_array, $sort = 'asc'){
	// $db_attrivute_viewmodel = RC_Loader::load_app_model('attribute_viewmodel');
	 RC_Loader::load_theme('extras/model/cart/cart_attribute_viewmodel.class.php');
    $db_attrivute_viewmodel = new cart_attribute_viewmodel();
	if (empty($goods_attr_id_array)){
		return $goods_attr_id_array;
	}
	$where = array('a.attr_type'=>1);
	$arr = array('ga.goods_attr_id'=>$goods_attr_id_array);
	$order = array('a.attr_id'=>$sort);
	$row = $db_attrivute_viewmodel->field('a.attr_type, ga.attr_value, ga.goods_attr_id')->join('goods_attr')->where($where)->in($arr)->order($order)->select();
	$return_arr = array();
	foreach ($row as $value){
		$return_arr['sort'][]   = $value['goods_attr_id'];
		$return_arr['row'][$value['goods_attr_id']]    = $value;
	}
	if(!empty($return_arr)){
		return true;
	}
	else {
		return false;
	}
}

/**
 * 将 goods_attr_id 的序列按照 attr_id 重新排序
 *
 * 注意：非规格属性的id会被排除
 *
 * @access public
 * @param array $goods_attr_id_array
 *        	一维数组
 * @param string $sort
 *        	序号：asc|desc，默认为：asc
 *
 * @return string
 */
function sort_goods_attr_id_array($goods_attr_id_array, $sort = 'asc') {
	// $dbview = RC_Loader::load_app_model('sys_attribute_viewmodel');
	RC_Loader::load_theme('extras/model/cart/cart_sys_attribute_viewmodel.class.php');
    $dbview = new cart_sys_attribute_viewmodel(); 
	if (empty($goods_attr_id_array)) {
		return $goods_attr_id_array;
	}

	$row = $dbview->join('goods_attr')->field('a.attr_type, v.attr_value, v.goods_attr_id')
	->where(array('a.attr_type'=>1))->in(array('v.goods_attr_id' => $goods_attr_id_array))->order(array('a.attr_id' => $sort))->select();

	$return_arr = array();
	if (!empty($row)) {
		foreach ($row as $value) {
			$return_arr['sort'][] = $value['goods_attr_id'];
			$return_arr['row'][$value['goods_attr_id']] = $value;
		}
	}
	return $return_arr;
}

/**
 * 获得指定的规格的价格
 *
 * @access public
 * @param mix $spec
 *        	规格ID的数组或者逗号分隔的字符串
 * @return void
 */
function spec_price($spec) {
	// $db = RC_Loader::load_app_model('goods_attr_model');
	RC_Loader::load_theme('extras/model/cart/cart_goods_attr_model.class.php');
    $db = new cart_goods_attr_model();
	if (!empty($spec)) {
		if (is_array($spec)) {
			foreach ( $spec as $key => $val ) {
				$spec [$key] = addslashes($val);
			}
		} else {
			$spec = addslashes($spec);
		}

		$price = $db->in(array('goods_attr_id' => $spec))->sum('attr_price');
	} else {
		$price = 0;
	}
	return $price;
}

/**
 * 获得指定的商品属性
 *
 * @access      public
 * @param       array       $arr        规格、属性ID数组
 * @param       type        $type       设置返回结果类型：pice，显示价格，默认；no，不显示价格
 *
 * @return      string
 */
function get_goods_attr_info($arr, $type = 'pice') {
	// $db_attribute_viewmodel = RC_Loader::load_app_model('attribute_viewmodel');
	RC_Loader::load_theme('extras/model/cart/cart_attribute_viewmodel.class.php');
    $db_attribute_viewmodel = new cart_attribute_viewmodel();
	$attr = '';
	if (!empty($arr)) {
		$fmt = "%s:%s[%s] \n";
		$in = array('ga.goods_attr_id'=>$arr);
		$field = 'a.attr_name, ga.attr_value, ga.attr_price';
		$res = $db_attribute_viewmodel->field($field)->join('goods_attr')->in($in)->select();
		foreach ($res as $row) {
			$attr_price = round(floatval($row['attr_price']), 2);
			$attr .= sprintf($fmt, $row['attr_name'], $row['attr_value'], $attr_price);
		}
		$attr = str_replace('[0]', '', $attr);
	}
	return $attr;
}

/**
 * 添加商品到购物车
 *
 * @access  public
 * @param   integer $goods_id   商品编号
 * @param   integer $num        商品数量
 * @param   array   $spec       规格值对应的id数组
 * @param   integer $parent     基本件
 * @return  boolean
 */
function addto_cart($goods_id, $num = 1, $spec = array(), $parent = 0) {
	// $db_goods_viewmodel = RC_Loader::load_app_model('goods_viewmodel');
	RC_Loader::load_theme('extras/model/cart/cart_goods_viewmodel.class.php');
    $db_goods_viewmodel = new cart_goods_viewmodel();
	// $db_products = RC_Loader::load_app_model('products_model');
	RC_Loader::load_theme('extras/model/cart/cart_products_model.class.php');
    $db_products = new cart_products_model();
	// $db_group_goods = RC_Loader::load_app_model('group_goods_model');
	RC_Loader::load_theme('extras/model/cart/cart_group_goods_model.class.php');
    $db_group_goods = new cart_group_goods_model();
	// $db_cart = RC_Loader::load_app_model('cart_model');
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db_cart = new cart_model();
	$_parent_id = $parent;
	/* 取得商品信息 */
	$where = array('g.goods_id'=>$goods_id,'g.is_delete'=>0);
	$field = 'g.goods_name, g.goods_sn, g.is_on_sale, g.is_real, g.market_price, g.shop_price AS org_price, g.promote_price, g.promote_start_date, g.promote_end_date, g.goods_weight, g.integral, g.extension_code, g.goods_number, g.is_alone_sale, g.is_shipping,' . "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]')|shop_price ";
	$goods = $db_goods_viewmodel->join('member_price')->field($field)->where($where)->find();
	if (empty($goods)) {
		return new ecjia_error(ERR_NOT_EXISTS, RC_Lang::lang('goods_not_exists'));
	}
	/* 如果是作为配件添加到购物车的，需要先检查购物车里面是否已经有基本件 */
	if ($parent > 0) {
		$where = array(
			'goods_id'			=> $parent,
			'session_id'		=> SESS_ID,
			'extension_code'	=> array('neq'=>'package_buy')
		);
		$res = $db_cart->where($where)->count('*');
		if ($res == 0) {
            return new ecjia_error(ERR_NO_BASIC_GOODS, RC_Lang::lang('no_basic_goods'));
		}
	}
	/* 是否正在销售 */
	if ($goods['is_on_sale'] == 0) {
        return new ecjia_error(ERR_NOT_ON_SALE, RC_Lang::lang('not_on_sale'));
	}
	/* 不是配件时检查是否允许单独销售 */
	if (empty($parent) && $goods['is_alone_sale'] == 0) {
        return new ecjia_error(ERR_CANNT_ALONE_SALE, RC_Lang::lang('cannt_alone_sale'));
	}
	/* 如果商品有规格则取规格商品信息 配件除外 */
	$prod = $db_products->where(array('goods_id'=>$goods_id))->count();
	if (is_spec($spec) && !empty($prod)) {
		$product_info = get_products_info($goods_id, $spec);
	}
	if (empty($product_info)) {
		$product_info = array('product_number' => '', 'product_id' => 0);
	}
	/* 检查：库存 */
	if (ecjia::config('use_storage') == 1) {
		/*检查：商品购买数量是否大于总库存*/
		if ($num > $goods['goods_number']) {
            return new ecjia_error(ERR_OUT_OF_STOCK, sprintf(RC_Lang::lang('shortage'), $goods['goods_number']));
		}
		/*商品存在规格 是货品 检查该货品库存*/
		if (is_spec($spec) && !empty($prod) && !empty($spec)) {
			/* 取规格的货品库存 */
			if ($num > $product_info['product_number']) {
                return new ecjia_error(ERR_OUT_OF_STOCK, sprintf(RC_Lang::lang('shortage'), $product_info['product_number']));
			}
		}
	}
	/* 计算商品的促销价格 */
	$spec_price = spec_price($spec);
	$goods_price = get_final_price($goods_id, $num, true, $spec);
	$goods['market_price'] += $spec_price;
	$goods_attr = get_goods_attr_info($spec);
	$goods_attr_id = join(',', $spec);
	/* 初始化要插入购物车的基本件数据 */
	$parent = array(
		'user_id'			=> $_SESSION['user_id'],
		'session_id'		=> SESS_ID,
		'goods_id'			=> $goods_id,
		'goods_sn'			=> addslashes($goods['goods_sn']),
		'product_id'		=> $product_info['product_id'],
		'goods_name'		=> addslashes($goods['goods_name']),
		'market_price'		=> $goods['market_price'],
		'goods_attr'		=> addslashes($goods_attr),
		'goods_attr_id'		=> $goods_attr_id,
		'is_real'			=> $goods['is_real'],
		'extension_code'	=> $goods['extension_code'],
		'ru_id'				=> $goods['user_id'],
		'is_gift'			=> 0,
		'is_shipping'		=> $goods['is_shipping'],
		'rec_type'			=> CART_GENERAL_GOODS
	);
	/* 如果该配件在添加为基本件的配件时，所设置的“配件价格”比原价低，即此配件在价格上提供了优惠， */
	/* 则按照该配件的优惠价格卖，但是每一个基本件只能购买一个优惠价格的“该配件”，多买的“该配件”不享受此优惠 */
	$basic_list = array();
	$res = $db_group_goods->field('parent_id, goods_price')->where(array('goods_id'=>$goods_id, 'parent_id'=>$_parent_id, 'goods_price'=>array('elt'=>$goods_price)))
	->order('goods_price')->select();
	foreach ($res as $row) {
		$basic_list[$row['parent_id']] = $row['goods_price'];
	}
	/* 取得购物车中该商品每个基本件的数量 */
	$basic_count_list = array();
	if ($basic_list) {
		$where = array(
			'session_id'=>SESS_ID,
			'parent_id' =>0,
			'extension_code'=>array('neq'=>'package_buy')
		);
		$in = array('goods_id' => array_keys($basic_list));
		$res = $db_cart->where($where)->in($in)->field('goods_id,SUM(goods_number) as count')->group('goods_id')->select();
		foreach ($res as $row) {
			$basic_count_list[$row['goods_id']] = $row['count'];
		}
	}
	/* 取得购物车中该商品每个基本件已有该商品配件数量，计算出每个基本件还能有几个该商品配件 */
	/* 一个基本件对应一个该商品配件 */
	if ($basic_count_list) {
		$where = array(
			'session_id'=>SESS_ID,
			'goods_id'=>$goods_id,
			'extension_code'=>array('neq'=>'package_buy'),
			'parent_id' => array_keys($basic_count_list)
		);
		$res = $db_cart->where($where)->field('parent_id,SUM(goods_number) as count')->group('parent_id')->select();
		foreach ($res as $row) {
			$basic_count_list[$row['parent_id']] -= $row['count'];
		}
	}
	/* 循环插入配件 如果是配件则用其添加数量依次为购物车中所有属于其的基本件添加足够数量的该配件 */
	foreach ($basic_list as $parent_id => $fitting_price) {
		/* 如果已全部插入，退出 */
		if ($num <= 0) {
			break;
		}
		/* 如果该基本件不再购物车中，执行下一个 */
		if (!isset($basic_count_list[$parent_id])) {
			continue;
		}
		/* 如果该基本件的配件数量已满，执行下一个基本件 */
		if ($basic_count_list[$parent_id] <= 0) {
			continue;
		}
		/* 作为该基本件的配件插入 */
		$parent['goods_price'] = max($fitting_price, 0) + $spec_price; //允许该配件优惠价格为0
		$parent['goods_number'] = min($num, $basic_count_list[$parent_id]);
		$parent['parent_id'] = $parent_id;
		/* 添加 */
		$db_cart->insert($parent);
		/* 改变数量 */
		$num -= $parent['goods_number'];
	}
	/* 如果数量不为0，作为基本件插入 */
	if ($num > 0) {
		/* 检查该商品是否已经存在在购物车中 */
		$where = array(
				'session_id'		=> SESS_ID,
				'goods_id'			=> $goods_id,
				'parent_id'			=> 0,
				'goods_attr'		=> get_goods_attr_info($spec),
				'extension_code'	=> array('neq'=>'package_buy'),
				'rec_type'			=> CART_GENERAL_GOODS
		);
		$goods_number = $db_cart->where($where)->get_field('goods_number');
		//如果购物车已经有此物品，则更新
		if ($goods_number) {
			$num += $goods_number;
			if (is_spec($spec) && !empty($prod)) {
				$goods_storage = $product_info['product_number'];
			} else {
				$goods_storage = $goods['goods_number'];
			}
			if (ecjia::config('use_storage') == 0 || $num <= $goods_storage) {
				$goods_price = get_final_price($goods_id, $num, true, $spec);
				$data = array(
						'goods_number'	=> $num,
						'goods_price'	=> $goods_price,
				);
				$where = array(
						'session_id'		=> SESS_ID,
						'goods_id'			=> $goods_id,
						'parent_id'			=> 0,
						'goods_attr'		=> get_goods_attr_info($spec),
						'extension_code'	=> array('neq'=>'package_buy'),
						'rec_type'			=> CART_GENERAL_GOODS
				);
				$res = $db_cart->where($where)->update($data);
				return $res;
			} else {
                return new ecjia_error(ERR_OUT_OF_STOCK, sprintf(RC_Lang::lang('shortage'), $num));
			}
		} else {
			$goods_price = get_final_price($goods_id, $num, true, $spec);
			$parent['goods_price'] = max($goods_price, 0);
			$parent['goods_number'] = $num;
			$parent['parent_id'] = 0;
			$res = $db_cart->insert($parent);
			return $res;
		}
	}
}

/**
 * 获得指定商品的关联商品
 *
 * @access  public
 * @param   integer     $goods_id
 * @return  array
 */
function get_linked_goods($goods) {
	// $db_goods_viewmodel = RC_Loader::load_app_model('goods_viewmodel');
	RC_Loader::load_theme('extras/model/cart/cart_goods_viewmodel.class.php');
    $db_goods_viewmodel = new cart_goods_viewmodel();
	foreach ($goods as $gid) {
		$goodsid[] = $gid['goods_id'];
	}
	$related_goods_number = ecjia::config('related_goods_number') ? ecjia::config('related_goods_number') : 0;
	$related_goods_number = $related_goods_number * 3;
	$field = 'g.goods_id, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price|org_price, g.market_price, g.promote_price, g.promote_start_date, g.promote_end_date, ' . "IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]')|shop_price" ;
	$where = array(
		'g.is_on_sale'		=> 1,
		'g.is_alone_sale'	=> 1,
		'g.is_delete'		=> 0
	);
	$in = array('lg.goods_id'=>$goodsid);
	$limit = $related_goods_number;
	$res = $db_goods_viewmodel->join(array('link_goods', 'member_price'))->field($field)->where($where)->in($in)->limit($limit)->select();
	$arr = array();
	foreach ($res as $row) {
		if (!in_array($row['goods_id'], $goodsid)) {
			$arr[$row['goods_id']]['goods_id'] = $row['goods_id'];
			$arr[$row['goods_id']]['goods_name'] = $row['goods_name'];
			$arr[$row['goods_id']]['short_name'] = $GLOBALS['_CFG']['goods_name_length'] > 0 ?
			RC_String::sub_str($row['goods_name'], ecjia::config('goods_name_length')) : $row['goods_name'];
			$arr[$row['goods_id']]['goods_thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
			$arr[$row['goods_id']]['goods_img'] = get_image_path($row['goods_id'], $row['goods_img']);
			$arr[$row['goods_id']]['market_price'] = price_format($row['market_price']);
			$arr[$row['goods_id']]['shop_price'] = price_format($row['shop_price']);
			$arr[$row['goods_id']]['url'] = RC_Uri::url('goods/index/init', array('id' => $row['goods_id']));
			if ($row['promote_price'] > 0) {
				$arr[$row['goods_id']]['promote_price'] = bargain_price($row['promote_price'], $row['promote_start_date'], $row['promote_end_date']);
				$arr[$row['goods_id']]['formated_promote_price'] = price_format($arr[$row['goods_id']]['promote_price']);
			} else {
				$arr[$row['goods_id']]['promote_price'] = 0;
			}
		}
	}
	/*返回数组*/
	$related_goods_number = ecjia::config('related_goods_number');
	if (count($arr) > $related_goods_number) {
		$linked_goods = array_rand($arr, $related_goods_number);
		foreach ($linked_goods as $key) {
			$array[] = $arr[$key];
		}
	} else {
		$array = $arr;
	}
	return $array;
}

/**
 * 取得购物车中已有的优惠活动及数量
 *
 * @return array
 */
function cart_favourable() {
	// $db_cart = RC_Loader::load_app_model('cart_model');
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db_cart = new cart_model();
	$list = array();
	$res = $db_cart->field('is_gift, COUNT(*)|num')->where(array('session_id'=>SESS_ID, 'rec_type'=>CART_GENERAL_GOODS, 'is_gift'=>array('gt'=>0)))->group('is_gift')->select();
	foreach ($res as $row) {
		$list [$row ['is_gift']] = $row ['num'];
	}
	return $list;
}

/**
 * 取得购物车中基本件ID
 */
function get_cart_parentid_list() {
	// $db_cart = RC_Loader::load_app_model('cart_model');
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db_cart = new cart_model();
	$where = array(
		'session_id'		=> SESS_ID,
		'rec_type'			=> CART_GENERAL_GOODS,
		'is_gift'			=> 0,
		'extension_code'	=> array('neq' => 'package_buy'),
		'parent_id'			=> 0
	);
	$list = $db_cart->field('goods_id')->where($where)->select();
	$parent_list = array();
	foreach ($list as $v) {
		$parent_list[] = $v['goods_id'];
	}
	return $parent_list;
}

/**
 * 获得购物车中商品的配件
 *
 * @access public
 * @param array $goods_list
 * @return array
 */
function get_goods_fittings($goods_list = array()) {
	if (empty($goods_list)) return array();
	// $db_group_goods_viewmodel = RC_Loader::load_app_model ( 'group_goods_viewmodel' );
	RC_Loader::load_theme('extras/model/cart/cart_group_goods_viewmodel.class.php');
    $db_group_goods_viewmodel = new cart_group_goods_viewmodel();
	$temp_index = 0;
	$arr 		= array ();
	$field = 'gg.parent_id, ggg.goods_name | parent_name, gg.goods_id, gg.goods_price, g.goods_name, g.goods_thumb, g.goods_img, g.shop_price | org_price,IFNULL(mp.user_price, g.shop_price * '.$_SESSION[discount].') | shop_price';
	$where = array('g.is_delete'=>0, 'g.is_on_sale'=>1);
	$in = array('gg.parent_id' => $goods_list);
	$order =array('gg.parent_id' => 'asc', 'gg.goods_id' => 'asc');
	$res = $db_group_goods_viewmodel->field($field)->where($where)->in($in)->order($order)->select();
	if (! empty ( $res )) {
		foreach ( $res as $row ) {
			$arr[$temp_index]['parent_id']				= $row ['parent_id']; // 配件的基本件ID
			$arr[$temp_index]['parent_name']			= $row ['parent_name']; // 配件的基本件的名称
			$arr[$temp_index]['parent_short_name']		= ecjia::config ( 'goods_name_length' ) > 0 ? RC_String::sub_str ( $row ['parent_name'], ecjia::config ( 'goods_name_length' ) ) : $row ['parent_name']; // 配件的基本件显示的名称
			$arr[$temp_index]['goods_id']				= $row ['goods_id']; // 配件的商品ID
			$arr[$temp_index]['goods_name']				= $row ['goods_name']; // 配件的名称
			$arr[$temp_index]['short_name']				= ecjia::config ( 'goods_name_length' ) > 0 ? RC_String::sub_str ( $row ['goods_name'], ecjia::config ( 'goods_name_length' ) ) : $row ['goods_name']; // 配件显示的名称
			$arr[$temp_index]['fittings_price']			= price_format ( $row ['goods_price'] ); // 配件价格
			$arr[$temp_index]['shop_price']				= price_format ( $row ['shop_price'] ); // 配件原价格
			$arr[$temp_index]['goods_thumb']			= get_image_path ( $row ['goods_id'], $row ['goods_thumb'], true );
			$arr[$temp_index]['goods_img']				= get_image_path ( $row ['goods_id'], $row ['goods_img'] );
			$arr[$temp_index]['url']					= RC_Uri::url('goods/index/init', array ('id' => $row ['goods_id']));
			$temp_index ++;
		}
	}
	return $arr;
}

/**
 * 检查礼包内商品的库存
 * @return  boolen
 */
//TODO: 测试这个方法
function judge_package_stock($package_id, $package_num = 1) {
	// $db_package_goods 	= RC_Loader::load_app_model('package_goods_model','goods');
	RC_Loader::load_theme('extras/model/cart/cart_package_goods_model.class.php');
    $db_package_goods = new cart_group_goods_viewmodel();
	// $db_products_view 	= RC_Loader::load_app_model('products_viewmodel','goods');
	RC_Loader::load_theme('extras/model/cart/cart_products_viewmodel.class.php');
    $db_products_view = new cart_products_viewmodel();
	// $db_goods_view 		= RC_Loader::load_app_model('goods_auto_viewmodel','goods');
    RC_Loader::load_theme('extras/model/cart/cart_goods_auto_viewmodel.class.php');
    $db_goods_view = new cart_goods_auto_viewmodel();
	$row = $db_package_goods->field('goods_id, product_id, goods_number')->where(array('package_id' => $package_id))->select();
	if (empty($row)) {
		return true;
	}

	/* 分离货品与商品 */
	$goods = array('product_ids' => '', 'goods_ids' => '');
	foreach ($row as $value) {
		if ($value['product_id'] > 0) {
			$goods['product_ids'] .= ',' . $value['product_id'];
			continue;
		}
		$goods['goods_ids'] .= ',' . $value['goods_id'];
	}

	/* 检查货品库存 */
	if ($goods['product_ids'] != '') {
		$row = $db_products_view->join('package_goods')->where(array('pg.package_id' => $package_id , 'pg.goods_number' * $package_num => array('gt' => 'p.product_number')))->in(array('p.product_id' => trim($goods['product_ids'], ',')))->select();
		if (!empty($row)) {
			return true;
		}
	}

	/* 检查商品库存 */
	if ($goods['goods_ids'] != '') {
		$db_goods_view->view = array(
			'package_goods' => array(
				'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=> 'pg',
				'field' => 'g.goods_id',
				'on' 	=> 'pg.goods_id = g.goods_id'
			)
		);
		$row = $db_goods_view->where(array('pg.goods_number' * $package_num => array('gt' => 'g.goods_number')  , 'pg.package_id' => $package_id))->in(array('pg.goods_id' => trim($goods['goods_ids'] , ',')))->select();
		if (!empty($row)) {
			return true;
		}
	}
	return false;
}

/**
 * 删除购物车中的商品
 *
 * @access public
 * @param integer $id
 * @return void
 */
function flow_drop_cart_goods($id) {
	// $db_cart = RC_Loader::load_app_model('cart_model');
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db_cart = new cart_model();
	// $db_cart_viewmodel = RC_Loader::load_app_model('cart_viewmodel');
	RC_Loader::load_theme('extras/model/cart/cart_viewmodel.class.php');
    $db_cart_viewmodel = new cart_viewmodel();
	/* 取得商品id */
	$row = $db_cart->where(array('rec_id'=>$id))->find();
	if ($row) {
		/* 如果是超值礼包 */
		if ($row ['extension_code'] == 'package_buy') {
			$where = array(
				'session_id'	=> SESS_ID,
				'rec_id'		=> $id
			);
			$db_cart->where($where)->delete();
		/* 如果是普通商品，同时删除所有赠品及其配件 */
		} elseif ($row ['parent_id'] == 0 && $row ['is_gift'] == 0) {
			/* 检查购物车中该普通商品的不可单独销售的配件并删除 */
			$where = array(
				'gg.parent_id'		=> $row ['goods_id'],
				'c.goods_id'		=> gg.goods_id,
				'c.parent_id'		=> $row ['goods_id'],
				'c.extension_code'	=> array('neq'=>'package_buy'),
				'gg.goods_id'		=> g.goods_id,
				'g.is_alone_sale'	=> 0
			);
			$res = $db_cart_viewmodel->join(array('goods','group_goods'))->field('c.rec_id')->where($where)->select();
			$_del_str = $id . ',';
			foreach ($res as $id_alone_sale_goods) {
				$_del_str .= $id_alone_sale_goods ['rec_id'] . ',';
			}
			$_del_str = trim($_del_str, ',');

			$where = "session_id = '" . SESS_ID . "' " . "AND (rec_id IN ($_del_str) OR parent_id = '$row[goods_id]' OR is_gift <> 0)";
			$db_cart->where($where)->delete();
		// 如果不是普通商品，只删除该商品即可
		} else {
			$where = array(
				'session_id'	=> SESS_ID,
				'rec_id'		=> $id
			);
			$db_cart->where($where)->delete();
		}
	}
	//删除购物车中不能单独销售的商品
	flow_clear_cart_alone();
}

/**
 * 删除购物车中不能单独销售的商品
 *
 * @access public
 * @return void
 */
function flow_clear_cart_alone() {
	// $db_cart = RC_Loader::load_app_model('cart_model');
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db_cart = new cart_model();
	// $db_cart_viewmodel = RC_Loader::load_app_model('cart_viewmodel');
	RC_Loader::load_theme('extras/model/cart/cart_viewmodel.class.php');
    $db_cart_viewmodel = new cart_viewmodel();
	/* 查询：购物车中所有不可以单独销售的配件 */
	$where = array(
		'c.session_id'		=> SESS_ID,
		'c.extension_code'	=> array('neq'=>'package_buy'),
		'gg.goods_id'		=> array('gt'=>0),
		'g.is_alone_sale'	=> 0
	);
	$res = $db_cart_viewmodel->join(array('goods','group_goods'))->field('c.rec_id, gg.parent_id')->where($where)->select();
	$rec_id = array();
	foreach ($res as $row) {
		$rec_id [$row ['rec_id']] [] = $row ['parent_id'];
	}
	if (empty($rec_id)) {
		return;
	}
	/* 查询：购物车中所有商品 */
	$where = array(
		'session_id'		=> SESS_ID,
		'extension_code'	=> array('neq'=>'package_buy')
	);
	$db_cart->where($where)->select();
	$cart_good = array();
	foreach ($res as $row) {
		$cart_good [] = $row ['goods_id'];
	}
	if (empty($cart_good)) {
		return;
	}
	/* 如果购物车中不可以单独销售配件的基本件不存在则删除该配件 */
	$del_rec_id = array();
	foreach ($rec_id as $key => $value) {
		foreach ($value as $v) {
			if (in_array($v, $cart_good)) {
				continue 2;
			}
		}
		$del_rec_id[] = $key;
	}
	if (empty($del_rec_id))return;
	/* 删除 */
	$db_cart->where(array('session_id'=>SESS_ID))->in(array('rec_id'=>$del_rec_id))->delete();
}

/**
 * 取得某用户等级当前时间可以享受的优惠活动
 *
 * @param int $user_rank
 *        	用户等级id，0表示非会员
 * @return array
 */
function favourable_list_flow($user_rank) {
	// $db_favourable_activity = RC_Loader::load_app_model ("favourable_activity_model");
	RC_Loader::load_theme('extras/model/cart/cart_favourable_activity_model.class.php');
    $db_favourable_activity = new cart_favourable_activity_model();
	// $db_goods = RC_Loader::load_app_model ("cart_goods_model");
	RC_Loader::load_theme('extras/model/cart/cart_goods_model.class.php');
    $db_goods = new cart_goods_model();
	/* 购物车中已有的优惠活动及数量 */
	$used_list = cart_favourable();
	/* 当前用户可享受的优惠活动 */
	$favourable_list = array();
	$now =RC_Time::gmtime();
	$where = array(
		'start_time'		=> array('elt'=>$now),
		'end_time'			=> array('gt'=>$now),
		'act_type'			=> FAT_GOODS,
		'CONCAT(user_rank)'	=> array('like'=>"%$user_rank%")
	);
	$res = $db_favourable_activity->where($where)->order('sort_order')->select();
	foreach ($res as $favourable) {
		$favourable['start_time']			= RC_Time::local_date(ecjia::config('time_format'), $favourable['start_time']);
		$favourable['end_time']				= RC_Time::local_date(ecjia::config('time_format'), $favourable['end_time']);
		$favourable['formated_min_amount']	= price_format($favourable['min_amount'], false);
		$favourable['formated_max_amount']	= price_format($favourable['max_amount'], false);
		$favourable['gift']					= unserialize($favourable['gift']);
		foreach ($favourable['gift'] as $key => $value) {
			$favourable['gift'][$key]['formated_price'] = price_format($value['price'], false);
			$where = array(
				'is_on_sale'	=> 1,
				'goods_id'		=> $value['id']
			);
			$is_sale = $db_goods->where($where)->count('*');
			if (!$is_sale) {
				unset($favourable['gift'][$key]);
			}
		}
		$favourable['act_range_desc'] = act_range_desc($favourable);
		$favourable['act_type_desc'] = sprintf(RC_Lang::lang('fat_ext.' . $favourable ['act_type']), $favourable ['act_type_ext']);
		/* 是否能享受 */
		$favourable['available'] = favourable_available($favourable);
		if ($favourable['available']) {
			/* 是否尚未享受 */
			$favourable['available'] = !favourable_used($favourable, $used_list);
		}
		if (!$favourable['available']) {
			continue;
		}
		$favourable_list [] = $favourable;
	}
	return $favourable_list;
}

/**
 * 添加优惠活动（赠品）到购物车
 * @param   int     $act_id     优惠活动id
 * @param   int     $id         赠品id
 * @param   float   $price      赠品价格
 */
function add_gift_to_cart($act_id, $id, $price){
	// $db_cart = RC_Loader::load_app_model('cart_model');
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db_cart = new cart_model();
	// $db_goods = RC_Loader::load_app_model('cart_goods_model');
	RC_Loader::load_theme('extras/model/cart/cart_goods_model.class.php');
    $db_goods = new cart_goods_model();
	$field = 'goods_id,goods_sn,goods_name,market_price,is_real,extension_code';
	$data = $db_goods->field($field)->where(array('goods_id'=>$id))->find();
	$data['user_id']		= $_SESSION[user_id];
	$data['session_id']		= SESS_ID;
	$data['goods_price']	= $price;
	$data['goods_number']	= 1;
	$data['parent_id']		= 0;
	$data['is_gift']		= $act_id;
	$data['rec_type']		= CART_GENERAL_GOODS;
	$res = $db_cart->insert($data);
}

/**
 * 取得优惠范围描述
 * @param   array   $favourable     优惠活动
 * @return  string
 */
function act_range_desc($favourable){
	// $db_brand =  RC_Loader::load_app_model('brand_model');
	RC_Loader::load_theme('extras/model/cart/cart_brand_model.class.php');
    $db_brand = new cart_brand_model();
	// $db_category =  RC_Loader::load_app_model('category_model');
	RC_Loader::load_theme('extras/model/cart/cart_category_model.class.php');
    $db_category = new cart_category_model();
	// $db_goods =  RC_Loader::load_app_model('cart_goods_model');
	RC_Loader::load_theme('extras/model/cart/cart_goods_model.class.php');
    $db_goods = new cart_goods_model();
	$list = array();
	if (!empty($favourable['act_range_ext'])) {
		if ($favourable['act_range'] == FAR_BRAND){
			$res = $db_brand->field('brand_name')->in(array('brand_id'=>$favourable['act_range_ext']))->select();
		}
		elseif ($favourable['act_range'] == FAR_CATEGORY){
			$res = $db_category->field('cat_name')->in(array('cat_id'=>$favourable['act_range_ext']))->select();
		}
		elseif ($favourable['act_range'] == FAR_GOODS){
			$res = $db_goods->field('goods_name')->in(array('goods_id'=>$favourable['act_range_ext']))->select();
		}else{
			return join(',', $list);
		}
	} else {
		return join(',', $list);
	}
	foreach ($res as $v) {
		$list[] = $v['brand_name'];
	}
	return join(',', $list);
}

/**
 * 根据购物车判断是否可以享受某优惠活动
 * @param   array   $favourable     优惠活动信息
 * @return  bool
 */
function favourable_available($favourable){
	/* 会员等级是否符合 */
	$user_rank = $_SESSION['user_rank'];
	if (strpos(',' . $favourable['user_rank'] . ',', ',' . $user_rank . ',') === false){
		return false;
	}
	/* 优惠范围内的商品总额 */
	$amount = cart_favourable_amount($favourable);
	/* 金额上限为0表示没有上限 */
	return $amount >= $favourable['min_amount'] && ($amount <= $favourable['max_amount'] || $favourable['max_amount'] == 0);
}

/**
 * 取得购物车中某优惠活动范围内的总金额
 * @param   array   $favourable     优惠活动
 * @return  float
 */
function cart_favourable_amount($favourable){
	// $db_cart_viewmodel = RC_Loader::load_app_model('cart_viewmodel');
	RC_Loader::load_theme('extras/model/cart/cart_viewmodel.class.php');
    $db_cart_viewmodel = new cart_viewmodel();
	/* 查询优惠范围内商品总额的sql */
	$where = array(
		'c.goods_id'	=> SESS_ID,
		'c.rec_type'	=> CART_GENERAL_GOODS,
		'c.is_gift'		=> 0,
		'c.goods_id'	=> array('gt'=>0)
	);
	$in = array();
	/* 根据优惠范围修正sql */
	if ($favourable['act_range'] == FAR_ALL){
		// sql do not change
	}elseif ($favourable['act_range'] == FAR_CATEGORY){
		/* 取得优惠范围分类的所有下级分类 */
		$id_list = array();
		$cat_list = explode(',', $favourable['act_range_ext']);
		foreach ($cat_list as $id){
			$id_list = array_merge($id_list, array_keys(cat_list(intval($id), 0, false)));
		}
		$in = array('g.cat_id'=>$id_list);
	}
	elseif ($favourable['act_range'] == FAR_BRAND){
		$id_list = explode(',', $favourable['act_range_ext']);
		$in = array('g.brand_id'=>$id_list);
	}else{
		$id_list = explode(',', $favourable['act_range_ext']);
		$in = array('g.goods_id'=>$id_list);
	}
	$result = $db_cart_viewmodel->join('goods')->field('SUM(c.goods_price *c.goods_number)')->where($where)->in($in)->get_field();
	/* 优惠范围内的商品总额 */
	return $result;
}

/**
 * 购物车中是否已经有某优惠
 * @param   array   $favourable     优惠活动
 * @param   array   $cart_favourable购物车中已有的优惠活动及数量
 */
function favourable_used($favourable, $cart_favourable){
	if ($favourable['act_type'] == FAT_GOODS){
		return isset($cart_favourable[$favourable['act_id']]) &&
		$cart_favourable[$favourable['act_id']] >= $favourable['act_type_ext'] &&
		$favourable['act_type_ext'] >= 0;
	}
	else{
		return isset($cart_favourable[$favourable['act_id']]);
	}
}

/**
 * 添加优惠活动（非赠品）到购物车
 * @param   int     $act_id     优惠活动id
 * @param   string  $act_name   优惠活动name
 * @param   float   $amount     优惠金额
 */
function add_favourable_to_cart($act_id, $act_name, $amount){
	// $db_cart = RC_Loader::load_app_model('cart_model');
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db_cart = new cart_model();
	$data = array(
		'user_id'			=> $_SESSION[user_id],
		'session_id'		=> SESS_ID,
		'goods_id'			=> 0,
		'goods_name'		=> $act_name,
		'market_price'		=> 0,
		'goods_price'		=> (-1) * $amount,
		'goods_number'		=> 1,
		'is_real'			=> 0,
		'extension_code'	=> '',
		'parent_id'			=> 0,
		'is_gift'			=> $act_id,
		'rec_type'			=> CART_GENERAL_GOODS
	);
	$res = $db_cart->insert($data);
}

/**
 * 取得优惠活动信息
 * @param   int     $act_id     活动id
 * @return  array
 */
function favourable_info($act_id){
	// $db_faviurable_activity = RC_Loader::load_app_model('favourable_activity_model');
	RC_Loader::load_theme('extras/model/cart/cart_favourable_activity_model.class.php');
    $db_faviurable_activity = new cart_favourable_activity_model();
	$row = $db_faviurable_activity->where(array('act_id' => $act_id))->find();
	if (!empty($row)){
		$row['start_time'] = RC_Time::local_date($GLOBALS['_CFG']['time_format'], $row['start_time']);
		$row['end_time'] = RC_Time::local_date($GLOBALS['_CFG']['time_format'], $row['end_time']);
		$row['formated_min_amount'] = price_format($row['min_amount']);
		$row['formated_max_amount'] = price_format($row['max_amount']);
		$row['gift'] = unserialize($row['gift']);
		if ($row['act_type'] == FAT_GOODS){
			$row['act_type_ext'] = round($row['act_type_ext']);
		}
	}
	return $row;
}

/**
 * 取指定规格的货品信息
 *
 * @access public
 * @param string $goods_id
 * @param array $spec_goods_attr_id
 * @return array
 */
function get_products_info($goods_id, $spec_goods_attr_id) {
	// $db = RC_Loader::load_app_model ( 'products_model');
	RC_Loader::load_theme('extras/model/cart/cart_products_model.class.php');
    $db = new cart_products_model();
	$return_array = array ();

	if (empty ( $spec_goods_attr_id ) || ! is_array ( $spec_goods_attr_id ) || empty ( $goods_id )) {
		return $return_array;
	}
	$goods_attr_array = sort_goods_attr_id_array ( $spec_goods_attr_id );
	if (isset ( $goods_attr_array ['sort'] )) {
		$goods_attr = implode ( '|', $goods_attr_array ['sort'] );
		$return_array = $db->where(array ('goods_id' => $goods_id,'goods_attr' => $goods_attr))->find ();
	}
	return $return_array;
}

/**
 * 调用购物车信息
 *
 * @access  public
 * @return  string
 */
function insert_cart_info() {
	// $db_cart = RC_Loader::load_app_model('cart_model');
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db_cart = new cart_model();
	$row = $db_cart->field('goods_number|number, SUM(goods_price * goods_number)|amount')->where(array('session_id'=>SESS_ID, 'rec_type'=>CART_GENERAL_GOODS))->find();
	if ($row) {
		$number = intval($row['number']);
		$amount = floatval($row['amount']);
	} else {
		$number = 0;
		$amount = 0;
	}
	$str = sprintf(RC_Lang::lang('cart_info'), $number, price_format($amount, false));
	return '<a href="flow.php" title="' . RC_Lang::lang('view_cart') . '">' . $str . '</a>';
}

/**
 * 根据商品id获取购物车中此id的数量
 */
function get_goods_number($goods_id) {
	// $db_cart = RC_Loader::load_app_model ( "cart_model" );
	RC_Loader::load_theme('extras/model/cart/cart_model.class.php');
    $db_cart = new cart_model();
	/*查询*/
	$where = array(
		'session_id'	=> SESS_ID,
		'rec_type'		=> CART_GENERAL_GOODS,
		'goods_id'		=> $goods_id
	);
	$res = intval($db_cart->where($where)->get_field('goods_number'));
	return $res;
}



// end
