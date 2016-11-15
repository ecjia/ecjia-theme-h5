<?php
defined ( 'IN_ECJIA' ) or exit ( 'No permission resources.' );

/**
 * 获得指定分类同级的所有分类以及该分类下的子分类
 *
 * @access  public
 * @param   integer     $cat_id     分类编号
 * @return  array
 */
function article_categories_tree($cat_id = 0) {
    // $db_article_cat = RC_Loader::load_app_model ("article_cat_model");
    RC_Loader::load_theme('extras/model/user/user_article_cat_model.class.php');
        $db_article_cat = new user_article_cat_model();
    // $db_article_cat_viewmodel = RC_Loader::load_app_model ("new_article_cat_viewmodel");
        RC_Loader::load_theme('extras/model/user/user_new_article_cat_viewmodel.class.php');
        $db_article_cat_viewmodel = new user_new_article_cat_viewmodel();
    if ($cat_id > 0) {
        $parent_id = $db_article_cat->where(array('cat_id'=>$cat_id))->get_field('parent_id');
    } else {
        $parent_id = 0;
    }
    /* 判断当前分类中全是是否是底级分类，如果是取出底级分类上级分类，如果不是取当前分类及其下的子分类 */
    $where = array('parent_id'=>$parent_id);
    $count = $db_article_cat->where($where)->count();
    if ($count) {
        /* 获取当前分类及其子分类 */
        $field = 'ac.cat_id, ac.cat_name, ac.sort_order|parent_order, ac.cat_id, acs.cat_id|child_id, acs.cat_name|child_name, acs.sort_order|child_order';
        $where = array('ac.parent_id'=>$parent_id);
        $orderby = array('parent_order'=>'ASC', 'ac.cat_id'=>'ASC', 'child_order'=>'ASC');
    } else {
        /* 获取当前分类及其父分类 */
        $field = 'ac.cat_id, ac.cat_name, acs.cat_id|child_id, acs.cat_name|child_name, acs.sort_order';
        $where = array('acs.parent_id'=>$parent_id);
        $orderby = array('sort_order'=>'ASC');
    }
    $res = $db_article_cat_viewmodel->join('article_cat')->field($field)->where($where)->order($orderby)->select();
    $cat_arr = array();
    foreach ($res AS $row) {
        $cat_arr[$row['cat_id']]['id']                                       = $row['cat_id'];
        $cat_arr[$row['cat_id']]['name']                                     = $row['cat_name'];
        $cat_arr[$row['cat_id']]['children'][$row['child_id']]['url']        = RC_Uri::url('article/art_list', array('acid' => $row ['cat_id']));
        if ($row['child_id'] != NULL) {
            $cat_arr[$row['cat_id']]['children'][$row['child_id']]['id']     = $row['child_id'];
            $cat_arr[$row['cat_id']]['children'][$row['child_id']]['name']   = $row['child_name'];
            $cat_arr[$row['cat_id']]['children'][$row['child_id']]['url']    = RC_Uri::url('article/art_list', array('acid' => $row ['child_id']));
        }
    }
    return $cat_arr;
}

/**
 * 获得文章分类下的文章列表
 *
 * @access public
 * @param integer $cat_id
 * @param integer $page
 * @param integer $size
 * @return array
 */
function get_cat_articles($cat_id, $page = 1, $size = 10, $requirement = '') {
    // $db_article = RC_Loader::load_app_model ( "article_model" );
    RC_Loader::load_theme('extras/model/article/article_model.class.php');
    $db_article = new article_model();
    /* 取出所有非0的文章 */
    if ($cat_id < 0) {

        $cat_id = 0;
    }
    $cat_arr = get_article_children($cat_id);

    $condition = 'is_open = 1';
    /* 增加搜索条件，如果有搜索内容就进行搜索 */
    if ($requirement != '') {
        $condition .= ' AND title like \'%' . $requirement . '%\'';
    }
    $count = $db_article->field('article_id, title, author, add_time, file_url, open_type')->where($condition)->in($cat_arr)->order('article_id DESC')->count('*');
    $pages = new ecjia_page($count, $size, 6, '', $page);
    $list = $db_article->field('article_id, title, author, add_time, file_url, open_type')->where($condition)->in($cat_arr)->order('article_id DESC')->limit($pages->limit())->select();
    $i = 1;
    $arr = array();
    if (is_array($list)) {
        foreach ($list as $vo) {
            $article_id = $vo['article_id'];
            $arr[$article_id]['id']              = $article_id;
            $arr[$article_id]['index']           = $i + ($page - 1) * $size;
            $arr[$article_id]['title']           = $vo['title'];
            $arr[$article_id]['short_title']     = ecjia::config('article_title_length') > 0 ? RC_String::sub_str($vo['title'], ecjia::config('article_title_length')) : $vo['title'];
            $arr[$article_id]['author']          = empty($vo['author']) || $vo['author'] == '_SHOPHELP' ? ecjia::config('shop_name') : $vo['author'];
            $arr[$article_id]['url']             = $vo['open_type'] != 1 ? RC_Uri::url('index/info', array('aid' => $article_id)) : trim($vo['file_url']);
            $arr[$article_id]['add_time']        = date(ecjia::config('date_format'), $vo['add_time']);
            $i++;
        }
    }
    // return $arr;
    $is_last = $page >= $pages->total_pages ? 1 : 0;
    return array('list'=>$arr, 'page'=>$pages->show(5), 'desc'=>$pages->page_desc(), 'is_last'=>$is_last);
}

/**
 * 获得指定文章分类下所有底层分类的ID
 *
 * @access  public
 * @param   integer     $cat        指定的分类ID
 *
 * @return void
 */
function get_article_children($cat = 0) {
    return array( 'cat_id' => array_unique(array_merge(array($cat), array_keys(article_cat_list($cat, 0, false)))));
}

/**
 * 获得指定分类下的子分类的数组
 *
 * @access public
 * @param int $cat_id
 *            分类的ID
 * @param int $selected
 *            当前选中分类的ID
 * @param boolean $re_type
 *            返回的类型: 值为真时返回下拉列表,否则返回数组
 * @param int $level
 *            限定返回的级数。为0时返回所有级数
 * @return mix
 */
function article_cat_list($cat_id = 0, $selected = 0, $re_type = true, $level = 0) {
    // $db_article_cat_viewmodel = RC_Loader::load_app_model ( "new_article_cat_viewmodel" );
    RC_Loader::load_theme('extras/model/article/article_new_article_cat_viewmodel.class.php');
    $db_article_cat_viewmodel = new article_new_article_cat_viewmodel();
	static $res = NULL;
	if ($res === NULL) {
		// $data = RC_Cache::app_getcache('art_cat_pid_releate', 'article');
		$data = RC_Cache::app_cache_get('art_cat_pid_releate', 'article');
		if ($data === false) {
			$field = 'ac.*, COUNT(ac.cat_id)|has_children, COUNT(a.article_id)|aricle_num';
			$orderby = 'parent_id, sort_order ASC';
			$res = $db_article_cat_viewmodel->join('article')->field($field)->group('ac.cat_id')->order($orderby)->select();

			RC_Cache::app_cache_set('art_cat_pid_releate', $res, 'article');
		} else {
			$res = $data;
		}
	}

	if (empty($res) == true) {
		return $re_type ? '' : array();
	}

	$options = article_cat_options($cat_id, $res); // 获得指定分类下的子分类的数组//$this->
	/* 截取到指定的缩减级别 */
	if ($level > 0) {
		if ($cat_id == 0) {
			$end_level = $level;
		} else {
			$first_item = reset($options); // 获取第一个元素
			$end_level = $first_item['level'] + $level;
		}

		/* 保留level小于end_level的部分 */
		foreach ($options as $key => $val) {
			if ($val['level'] >= $end_level) {
				unset($options[$key]);
			}
		}
	}

	$pre_key = 0;
	foreach ($options as $key => $value) {
		$options[$key]['has_children'] = 1;
		if ($pre_key > 0) {
			if ($options[$pre_key]['cat_id'] == $options[$key]['parent_id']) {
				$options[$pre_key]['has_children'] = 1;
			}
		}
		$pre_key = $key;
	}

	if ($re_type == true) {
		$select = '';
		foreach ($options as $var) {
			$select .= '<option value="' . $var['cat_id'] . '" ';
			$select .= ($selected == $var['cat_id']) ? "selected='ture'" : '';
			$select .= '>';
			if ($var['level'] > 0) {
				$select .= str_repeat('&nbsp;', $var['level'] * 4);
			}
			$select .= htmlspecialchars(addslashes($var['cat_name'])) . '</option>';
		}

		return $select;
	} else {
		foreach ($options as $key => $value) {
			$options[$key]['url'] = RC_Uri::url('article/init', array(
					'id' => $value['cat_id']
			));
		}
		return $options;
	}
}

/**
 * 过滤和排序所有文章分类，返回一个带有缩进级别的数组
 *
 * @access private
 * @param int $cat_id
 *            上级分类ID
 * @param array $arr
 *            含有所有分类的数组
 * @param int $level
 *            级别
 * @return void
 */
function article_cat_options($spec_cat_id, $arr) {
	static $cat_options = array();

	if (isset($cat_options[$spec_cat_id])) {
		return $cat_options[$spec_cat_id];
	}

	if (!isset($cat_options[0])) {
		$level = $last_cat_id = 0;
		$options = $cat_id_array = $level_array = array();
		while (!empty($arr)) {
			foreach ($arr as $key => $value) {
				$cat_id = $value['cat_id'];
				if ($level == 0 && $last_cat_id == 0) {
					if ($value['parent_id'] > 0) {
						break;
					}

					$options[$cat_id]          = $value;
					$options[$cat_id]['level'] = $level;
					$options[$cat_id]['id']    = $cat_id;
					$options[$cat_id]['name']  = $value['cat_name'];
					unset($arr[$key]);

					if ($value['has_children'] == 0) {
						continue;
					}
					$last_cat_id = $cat_id;
					$cat_id_array = array(
							$cat_id
					);
					$level_array[$last_cat_id] = ++$level;
					continue;
				}

				if ($value['parent_id'] == $last_cat_id) {
					$options[$cat_id]          = $value;
					$options[$cat_id]['level'] = $level;
					$options[$cat_id]['id']    = $cat_id;
					$options[$cat_id]['name']  = $value['cat_name'];
					unset($arr[$key]);

					if ($value['has_children'] > 0) {
						if (end($cat_id_array) != $last_cat_id) {
							$cat_id_array[]     = $last_cat_id;
						}
						$last_cat_id                  = $cat_id;
						$cat_id_array[]               = $cat_id;
						$level_array[$last_cat_id]    = ++$level;
					}
				} elseif ($value['parent_id'] > $last_cat_id) {
					break;
				}
			}

			$count = count($cat_id_array);
			if ($count > 1) {
				$last_cat_id = array_pop($cat_id_array);
			} elseif ($count == 1) {
				if ($last_cat_id != end($cat_id_array)) {
					$last_cat_id = end($cat_id_array);
				} else {
					$level         = 0;
					$last_cat_id   = 0;
					$cat_id_array  = array();
					continue;
				}
			}

			if ($last_cat_id && isset($level_array[$last_cat_id])) {
				$level = $level_array[$last_cat_id];
			} else {
				$level = 0;
			}
		}
		$cat_options[0] = $options;
	} else {
		$options = $cat_options[0];
	}

	if (!$spec_cat_id) {
		return $options;
	} else {
		if (empty($options[$spec_cat_id])) {
			return array();
		}

		$spec_cat_id_level = $options[$spec_cat_id]['level'];

		foreach ($options as $key => $value) {
			if ($key != $spec_cat_id) {
				unset($options[$key]);
			} else {
				break;
			}
		}

		$spec_cat_id_array = array();
		foreach ($options as $key => $value) {
			if (($spec_cat_id_level == $value['level'] && $value['cat_id'] != $spec_cat_id) || ($spec_cat_id_level > $value['level'])) {
				break;
			} else {
				$spec_cat_id_array[$key] = $value;
			}
		}
		$cat_options[$spec_cat_id] = $spec_cat_id_array;
		return $spec_cat_id_array;
	}
}

/**
 * 获得指定的文章的详细信息
 *
 * @access  private
 * @param   integer     $article_id
 * @return  array
 */
function get_article_info($article_id) {
	// $db_article_viewmodel = RC_Loader::load_app_model ( "new_article_viewmodel" );
	 RC_Loader::load_theme('extras/model/article/article_new_article_viewmodel.class.php');
    $db_article_viewmodel = new article_new_article_viewmodel();
	/* 获得文章的信息 */
	$field = 'a.*, IFNULL(AVG(c.comment_rank), 0)|comment_rank';
	$where = array('a.is_open'=>1, 'a.article_id'=>$article_id);
	$row = $db_article_viewmodel->join('comment')->field($field)->where($where)->group('a.article_id')->find();
	if ($row !== false) {
		$row['comment_rank'] = ceil($row['comment_rank']);// 用户评论级别取整
		/* 修正添加时间显示 */
		$row['add_time'] = RC_Time::local_date(RC_Lang::lang('date_format'), $row['add_time']);// 修正添加时间显示
		$row['content'] = html_out($row['content']);;
		/* 作者信息如果为空，则用网站名称替换 */
		if (empty($row['author']) || $row['author'] == '_SHOPHELP') {
			$row['author'] = RC_Lang::lang('shop_name');
		}
	}
	return $row;
}

// end
