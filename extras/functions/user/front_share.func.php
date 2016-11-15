<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获得商品的详细信息
 */
function get_goods_info($goods_id) {
	// $db_goods = RC_Loader::load_app_model ( 'goods_auto_viewmodel');
	RC_Loader::load_theme('extras/model/user/user_goods_auto_viewmodel.php');
    $db_goods       = new user_goods_auto_viewmodel();
	//TODO:: common方法
	$time = RC_Time::gmtime ();
	$db_goods->view = array (
		'category' => array(
			'type'     => Component_Model_View::TYPE_LEFT_JOIN,
			'alias'    => 'c',
			'field'    => "g.*, c.measure_unit, b.brand_id, b.brand_name AS goods_brand, m.type_money AS bonus_money,IFNULL(AVG(r.comment_rank), 0) AS comment_rank,IFNULL(mp.user_price, g.shop_price * '$_SESSION[discount]') AS rank_price",
			'on'       => 'g.cat_id = c.cat_id'
		),
		'brand' => array(
			'type'     => Component_Model_View::TYPE_LEFT_JOIN,
			'alias'    => 'b',
			'on'       => 'g.brand_id = b.brand_id '
		),
		'comment' => array(
			'type' => Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'r',
			'on' => 'r.id_value = g.goods_id AND comment_type = 0 AND r.parent_id = 0 AND r.status = 1'
		),
		'bonus_type' => array(
			'type' => Component_Model_View::TYPE_LEFT_JOIN,
			'alias' => 'm',
			'on' => 'g.bonus_type_id = m.type_id AND m.send_start_date <= "' . $time . '" AND m.send_end_date >= "' . $time . '"'
		),
		'member_price'   => array(
			'type'     => Component_Model_View::TYPE_LEFT_JOIN,
			'alias'    => 'mp',
			'on'       => 'mp.goods_id = g.goods_id AND mp.user_rank = "' . $_SESSION ['user_rank'] . '"'
		)
	);

	$row = $db_goods->where(array('g.goods_id' => $goods_id,'g.is_delete' => 0))->group('g.goods_id')->find();
	if ($row !== false) {
		/* 用户评论级别取整 */
		$row ['comment_rank'] = ceil ( $row ['comment_rank'] ) == 0 ? 5 : ceil ( $row ['comment_rank'] );
		/* 获得商品的销售价格 */
		$row ['market_price'] = price_format ($row ['market_price'],false);
		$row ['shop_price_formated'] = price_format ($row ['shop_price'] );
		/* 修正促销价格 */
		if ($row ['promote_price'] > 0) {
			$promote_price = bargain_price ( $row ['promote_price'], $row ['promote_start_date'], $row ['promote_end_date'] );
		} else {
			$promote_price = 0;
		}
		/* 处理商品水印图片 */
		$watermark_img = '';
		if ($promote_price != 0) {
			$watermark_img = "watermark_promote";
		} elseif ($row ['is_new'] != 0) {
			$watermark_img = "watermark_new";
		} elseif ($row ['is_best'] != 0) {
			$watermark_img = "watermark_best";
		} elseif ($row ['is_hot'] != 0) {
			$watermark_img = 'watermark_hot';
		}
		if ($watermark_img != '') {
			$row ['watermark_img'] = $watermark_img;
		}
		$row ['promote_price_org'] = $promote_price;
		$row ['promote_price'] = price_format ( $promote_price );
		/* 修正重量显示 */
		$row ['goods_weight'] = (intval ( $row ['goods_weight'] ) > 0) ? $row ['goods_weight'] . RC_Lang::lang ( 'kilogram' ) : ($row ['goods_weight'] * 1000) . RC_Lang::lang ( 'gram' );
		/* 修正上架时间显示 */
		$row ['add_time'] = RC_Time::local_date ( ecjia::config ( 'date_format' ), $row ['add_time'] );
		/* 促销时间倒计时 */
		$time = RC_Time::gmtime ();
		if ($time >= $row ['promote_start_date'] && $time <= $row ['promote_end_date']) {
			$row ['gmt_end_time'] = $row ['promote_end_date'];
		} else {
			$row ['gmt_end_time'] = 0;
		}
		/* 是否显示商品库存数量 */
		$row ['goods_number'] = (ecjia::config ( 'use_storage' ) == 1) ? $row ['goods_number'] : '';
		/* 修正积分：转换为可使用多少积分（原来是可以使用多少钱的积分） */
		$row ['integral'] = ecjia::config ( 'integral_scale' ) ? round ( $row ['integral'] * 100 / ecjia::config ( 'integral_scale' ) ) : 0;
		/* 修正优惠券 */
		$row ['bonus_money'] = ($row ['bonus_money'] == 0) ? 0 : price_format ( $row ['bonus_money'], false );
		/* 修正商品图片 */
		$row ['goods_img'] = get_image_path($goods_id, $row ['goods_img']);
		$row ['goods_thumb'] = get_image_path($goods_id, $row ['goods_thumb'], true);
		return $row;
	} else {
		return false;
	}
}

//end
