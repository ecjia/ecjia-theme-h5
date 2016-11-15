<?php
defined('IN_ECJIA') or exit('No permission resources.');

/**
 *  获取用户的tags
 */
function get_user_tags($user_id = 0) {
	if (empty($user_id)) {
		return false;
	}
	$tags = get_tags(array('user_id' => $user_id));
	if (!empty($tags)) {
		color_tag($tags);
	}
	return $tags;
}

/**
 * 标签着色
 */
function color_tag(&$tags) {
    $tagmark = array(
        array('color' => '#FB9797'),
        array('color' => '#1ccfe2'),
        array('color' => '#EAA98F'),
        array('color' => '#C1A1C3'),
        array('color' => '#9BBFC3'),
        array('color' => '#6DCFD1'),
        array('color' => '#58CB8B'),
        array('color' => '#C98F8B'),
        array('color' => '#7996CB'),
    );
	$maxlevel = count($tagmark);
	$tcount = $scount = array();
	foreach ($tags AS $val) {
		$tcount[] = $val['tag_count']; // 获得tag个数数组
	}
	$tcount = array_unique($tcount); // 去除相同个数的tag
	sort($tcount); // 从小到大排序
	$tempcount = count($tcount); // 真正的tag级数
	$per = $maxlevel >= $tempcount ? 1 : $maxlevel / ($tempcount - 1);
	foreach ($tcount AS $key => $val) {
		$lvl = floor($per * $key);
		$scount[$val] = $lvl; // 计算不同个数的tag相对应的着色数组key
	}
	/* 遍历所有标签，根据引用次数设定字体大小 */
	foreach ($tags AS $key => $val) {
		$lvl = $scount[$val['tag_count']]; // 着色数组key
		$tags[$key]['color'] = $tagmark[$lvl]['color'];
		$tags[$key]['url'] = RC_Uri::url('goods/index/goods_list', array('keywords' => urlencode($val['tag_words'])));
	}
	shuffle($tags);
}

/**
 *  验证性的删除某个tag
 */
function delete_tag($tag_words, $user_id){
	// $db_tag = RC_Loader::load_app_model ( "tag_model" );
	RC_Loader::load_theme('extras/model/user/user_tag_model.class.php');
    $db_tag       = new user_tag_model();
	$where['tag_words'] = $tag_words;
	$where['user_id'] = $user_id;
	if(!empty($where['tag_words']) && !empty($where[user_id]) && $where[user_id]>0){
		$db_tag->where($where)->delete();
	}
}
