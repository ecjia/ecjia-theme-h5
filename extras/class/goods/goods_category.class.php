<?php
/**
 * 商品分类类
 */
class goods_category {
	public static $goods_category = null;
	public $cat_id				= 0; // 分类ID
	public $brand				= 0; // 分类品牌ID
	public $price_min			= 0; // 分类最低价格
	public $price_max			= 0; // 分类最高价格
	public $filter_attr_str		= 0; // 分类属性字符串
	public $children			= array(); // 分类信息
	public $cat					= null; // 分类信息

    public $page				= 1; // 页数
    public $sort				= 'last_update';
    public $order				= 'DESC'; // 排序方式
    public $keywords			= ''; // 搜索关键词
    public $type				= ''; // 商品类型：best、hot、new、promotion


	public function __construct($cat_id = 0, $brand = 0, $filter = array()) {
		$this->cat_id			= !empty($cat_id)? $cat_id : intval($_GET['cid']);
		$this->brand			= !empty($brand) ? $brand : (intval($_GET['brand']) > 0 ? intval($_GET['brand']) : 0);
		$this->price_min 		= !empty($filter['price_min']) ? $filter['price_min'] : intval($_GET['price_min']);
		$this->price_max		= !empty($filter['price_max']) ? $filter['price_max'] : intval($_GET['price_max']);

		$this->page				= !empty($filter['page']) ? $filter['page'] : (!empty($_GET['page']) ? intval($_GET['page']) : 1);
		$this->sort				= !empty($filter['sort']) ? $filter['sort'] : (!empty($_GET['sort']) ? htmlspecialchars($_GET['sort']) : 'last_update');
		$this->order			= !empty($filter['order']) ? $filter['order'] : (!empty($_GET['order']) ? htmlspecialchars($_GET['order']) : 'ASC');
		$this->keywords			= !empty($filter['keywords']) ? $filter['keywords'] : (!empty($_POST['keywords']) ? htmlspecialchars($_POST['keywords']) : '');
        $this->type				= (isset($_GET['type']) && in_array(trim(strtolower($_GET['type'])), array('best', 'hot', 'new', 'promotion'))) ? trim(strtolower($_GET['type'])) : '';
		if(empty($filter['filter_attr_str'])) {
			$filter_attr_str	= htmlspecialchars($_GET['filter_attr']) > 0 ? htmlspecialchars($_GET['filter_attr']) : 0;
			$filter_attr_str	= trim(RC_String::unicode2string($filter_attr_str));
			$this->filter_attr_str	= preg_match('/^[\d\.]+$/', $filter_attr_str) ? $filter_attr_str : '';
		} else {
			$this->filter_attr_str = $filter['filter_attr_str'];
		}

		/* 如果页面没有被缓存则重新获取页面的内容 */
		$this->children = 	array('cat_id' => array_unique(array_merge(array($this->cat_id), array_keys($this->cat_list($this->cat_id)))));
		/*获得分类的相关信息*/
		$this->get_cat_info();
	}

	/**
	 * 商品分类的工厂方法
	 * @return goods_category
	 */
	public static function factory($cat_id = 0, $brand = 0, $filter = array()) {
		if (self::$goods_category == null) {
			self::$goods_category = new goods_category($cat_id, $brand, $filter);
		}
		return self::$goods_category;
	}


	/**
	 * 获得分类的信息
	 *
	 * @return cat
	 */
	public function get_cat_info() {
		if (empty($this->cat)) {
			// $db_category = RC_Loader::load_app_model('category_model');
			 RC_Loader::load_theme('extras/model/goods/goods_category_model.class.php');
        $db_category       = new goods_category_model();
			$this->cat = $db_category->field('cat_name, keywords, cat_desc, style, grade, filter_attr, parent_id')->where(array('cat_id'=>$this->cat_id))->find();
		}
		return $this->cat;
	}

	/**
	 * 获取一级分类信息
	 */
	public function get_top_category() {
		// $db_category = RC_Loader::load_app_model('category_model');
		 RC_Loader::load_theme('extras/model/goods/goods_category_model.class.php');
        $db_category       = new goods_category_model();
		$res = $db_category->field('cat_id,cat_name,parent_id,is_show')->where(array('parent_id'=>0, 'is_show'=>1))->order('sort_order,cat_id ASC')->select();
		foreach ($res AS $row) {
			if ($row['is_show']) {
				$cat_arr[$row['cat_id']]['id'] = $row['cat_id'];
				$cat_arr[$row['cat_id']]['name'] = $row['cat_name'];
				$cat_arr[$row['cat_id']]['url'] = RC_Uri::url('category/index', array('id' => $row['cat_id']));
			}
		}
		return $cat_arr;
	}

	/**
	 * 获取满足条件的分类下所有商品的数量
	 * @access private
	 * @param string $children
	 * @param unknown $brand
	 */
	function category_get_count() {
		// $db_goods_viewmodel = RC_Loader::load_app_model ( 'goods_viewmodel' );
		RC_Loader::load_theme('extras/model/goods/goods_viewmodel.class.php');
        $db_goods_viewmodel       = new goods_viewmodel();
		$where = array(
			'g.is_on_sale'		=> 1,
			'g.is_alone_sale'	=> 1,
			'g.is_delete'		=> 0
		);

		if ($this->brand > 0) {
			$where['g.brand_id'] = $this->brand;
		}
		if($this->type){
			switch ($this->type)
			{
				case 'best':
					$where['g.is_best'] = 1;
					break;
					case 'new':
					$where['g.is_new'] = 1;
					break;
				case 'hot':
					$where['g.is_hot'] = 1;
					break;
				case 'promotion':
					$where['g.promote_price'] = array('gt' => 0);
					$where['g.promote_start_date'] = array('elt' => RC_Time::gmtime());
					$where['g.promote_end_date'] = array('gt' => RC_Time::gmtime());
					break;
				default:
			}
		}
		if($this->price_min > 0) {
			$where['g.shop_price'] = array('gt' => $this->price_min);
		}
		if ($this->price_max > 0) {
			$where['g.shop_price'] = array('elt' => $this->price_max);
		}
		$in = $this->get_cats_goods($this->children, 'g.goods_id');
		return $db_goods_viewmodel->join(array('member_price'))->where($where)->in($in)->count('*');
	}

	/**
	 * 获取分类下的商品
	 */
	public function get_category_goods($page, $cat_id, $keywords, $brand, $price_min,$price_max, $sort, $order ) {
		return $this->_get_category_goods($page, $cat_id, $keywords, $brand, $price_min,$price_max, $sort, $order);
	}

	private function _get_category_goods($page, $cat_id, $keywords, $brand, $price_min,$price_max, $sort, $order ) {
		// $db_goods_viewmodel = RC_Loader::load_app_model ( 'goods_viewmodel' );
		 RC_Loader::load_theme('extras/model/goods/goods_viewmodel.class.php');
        $db_goods_viewmodel       = new goods_viewmodel();
		$display = $GLOBALS['display'];
		$db_goods_viewmodel->view = array(
			'member_price' => array(
				'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'		=> 'mp',
				'on'		=> 'mp.goods_id = g.goods_id AND mp.user_rank = "' . $_SESSION ['user_rank'] . '"'
			),
// 			'tag' => array(
// 				'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
// 				'alias'		=> 'tg',
// 				'on'		=> 'g.goods_id = tg.goods_id '
// 			),
			'goods_cat' => array(
				'type'		=> Component_Model_View::TYPE_LEFT_JOIN,
				'alias'		=> 'gc',
				'on'		=> 'gc.goods_id = g.goods_id '
			)
		);
		$where = array(
			'g.is_on_sale'		=> 1,
			'g.is_alone_sale'	=> 1,
			'g.is_delete'		=> 0
		);
		$this->children = $this->get_children($cat_id);
		$children = $cat_id >0 ? 'g.cat_id'.db_create_in (array_unique(array_merge(array($cat_id), array_keys(cat_list($cat_id, 0, false ))))) : '';
		if(!empty($children)){
			$where[] .= '(('.$children.') OR( gc.cat_id ='. $cat_id .' ))';
		}
		if (!empty($keywords)) {
			$where[] .= "( goods_name LIKE '%$keywords%' OR goods_sn LIKE '%$keywords%' OR keywords LIKE '%$keywords%' )";
		}
		$this->keywords = $keywords;
		if ($this->type) {
			switch ($this->type) {
				case 'best':
					$where['g.is_best'] = 1;
					break;
				case 'new':
					$where['g.is_new'] = 1;
					break;
				case 'hot':
					$where['g.is_hot'] = 1;
					break;
				case 'promotion':
					$time = RC_Time::gmtime();
					$where['g.promote_price']		= array('gt'=>0);
					$where['g.promote_start_date']	= array('elt' => $time);
					$where['g.promote_end_date']	= array('gt' => $time);
					break;
				default:
			}
		}
		if ($brand > 0) {
			$where['g.brand_id'] = $brand;
		}
		if ($price_min >= 0) {
			$where['g.shop_price'] = array('egt' => $price_min);
		}
		if($price_max > 0 && !empty($where['g.shop_price'])){
			$where['g.shop_price'] = array_merge($where['g.shop_price'], array('elt' => $price_max));
		}
		//TODO: 销量排序功能
		$sort = empty($sort) ? $this->sort : $sort ;
		$order = empty($order) ? $this->order : $order ;
		if($sort == 'sales_volume'){
			$sort = 'sort_order';
		}
		/* 获得商品列表 */
		$count = $db_goods_viewmodel->join(array('member_price', 'goods_cat'))->where($where)->order(array($sort=>$this->order))->count('*');
		$pages = new touch_page($count, $this->size, 6, '', $page);

		$res = $db_goods_viewmodel->join(array('member_price', 'goods_cat'))->field('g.goods_id, g.goods_name, g.goods_name_style, g.market_price, g.is_new, g.is_best, g.is_hot, g.shop_price, g.promote_price, g.goods_type, g.promote_start_date, g.promote_end_date, g.goods_brief, g.goods_thumb , g.goods_img')->where($where)->order(array($sort=>$order))->limit($pages->limit())->select();
		$arr = array();
		foreach ($res as $row) {
			// 销量统计
			$sales_volume = (int) $row['sales_volume'];
			//TODO:Touch 销量统计
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
			$arr[$row['goods_id']]['market_price'] = price_format($row['market_price']);
			$arr[$row['goods_id']]['shop_price'] = price_format($row['shop_price']);
			$arr[$row['goods_id']]['type'] = $row['goods_type'];
			$arr[$row['goods_id']]['promote_price'] = ($promote_price > 0) ? price_format($promote_price) : '';
			$arr[$row['goods_id']]['goods_thumb'] = get_image_path($row['goods_id'], $row['goods_thumb'], true);
			$arr[$row['goods_id']]['goods_img'] = get_image_path($row['goods_id'], $row['goods_img']);
			$arr[$row['goods_id']]['url'] = RC_Uri::url('goods/index/init', array(
				'id' => $row['goods_id']
			));
			$arr[$row['goods_id']]['sales_count'] = $sales_volume;
			$arr[$row['goods_id']]['sc'] = get_goods_collect($row['goods_id']);
			$arr[$row['goods_id']]['mysc'] = 0;
			// 检查是否已经存在于用户的收藏夹
			if ($_SESSION['user_id']) {
				unset($where);
				// 用户自己有没有收藏过
				$where['goods_id'] = $row['goods_id'];
				$where['user_id'] = $_SESSION['user_id'];
				// $db_collect_goods = RC_Loader::load_app_model('collect_goods_model');
				RC_Loader::load_theme('extras/model/goods/goods_collect_goods_model.class.php');
        $db_collect_goods       = new goods_collect_goods_model();
				$rs = $db_collect_goods->where($where)->count();
				$arr[$row['goods_id']]['mysc'] = $rs;
			}
			$arr[$row['goods_id']]['promotion'] = get_promotion_show($row['goods_id']);
		}
		$is_last = $page >= $pages->total_pages ? 1 : 0;
		return array('list'=>$arr, 'page'=>$pages->show(5), 'desc'=>$pages->page_desc(), 'is_last'=> $is_last);
	}

	/**
	 *
	 * @param unknown $cat_id
	 * @param number $brand
	 * @param unknown $filter
	 */
	public function get_price_range($cat_id = 0, $brand = 0, $filter = array()) {
		//获取参数
		if(empty($cat_id)) $cat_id											= $this->cat_id;
		if(empty($brand)) $brand											= $this->brand;
		if(empty($filter['price_min'])) $filter['price_min']				= $this->price_min;
		if(empty($filter['price_max'])) $filter['price_max']				= $this->price_max;
		if(empty($filter['filter_attr_str'])) $filter['filter_attr_str']	= $this->filter_attr_str;
		if(empty($filter['children'])) $filter['children']					= $this->children;
		if(empty($filter['cat'])) $filter['cat']							= $this->cat;

		/* 获取价格分级 */
		if (empty($filter['cat']['grade'])  && $filter['cat']['parent_id'] != 0) {
			$filter['cat']['grade'] = $this->get_parent_grade($cat_id); //如果当前分类级别为空，取最近的上级分类
		}

		return $this->_get_price_range($cat_id, $brand, $filter);
	}

	/**
	 * 获取分类商品价格区间
	 * @param unknown $cat_id
	 * @param unknown $brand
	 * @param unknown $filter_attr_str
	 * @param unknown $price_min
	 * @param unknown $price_max
	 * @param unknown $children
	 */
	private function _get_price_range($cat_id, $brand, $filter) {
		$price_min			= $filter['price_min'];
		$price_max			= $filter['price_max'];
		$filter_attr_str	= $filter['filter_attr_str'];
		$children			= $filter['children'];
		$cat				= $filter['cat']; // 获得分类的相关信息
		//开始运算
		$field = 'min(shop_price) | min, max(shop_price) | max';
		$where = array(
				'is_delete' => 0,
				'is_on_sale' => 1,
				'is_alone_sale' => 1
		);
		$in = $this->get_cats_goods($children, 'goods_id');
		//获得当前分类下商品价格的最大值、最小值
		// $db_goods = RC_Loader::load_app_model('goods_model', 'goods');
	     RC_Loader::load_theme('extras/model/goods/goods_model.class.php');
        $db_goods       = new goods_model();
		$row = $db_goods->field($field)->where($where)->in($in)->find();
		// 取得价格分级最小单位级数，比如，千元商品最小以100为级数
		$price_grade = 0.0001;
		for($i=-2; $i<= log10($row['max']); $i++) {
			$price_grade *= 10;
		}
		//跨度
		$dx = ceil(($row['max'] - $row['min']) / ($cat['grade']) / $price_grade) * $price_grade;
		$dx == 0 && $dx = $price_grade;

		for($i = 1; $row['min'] > $dx * $i; $i ++);

		for($j = 1; $row['min'] > $dx * ($i-1) + $price_grade * $j; $j++);
		$row['min'] = $dx * ($i-1) + $price_grade * ($j - 1);

		for(; $row['max'] >= $dx * $i; $i ++);
		$row['max'] = $dx * ($i) + $price_grade * ($j - 1);

		$field = "(FLOOR((shop_price - $row[min]) / $dx)) | sn, COUNT(*) | goods_num";
		$price_grade = $db_goods->field($field)->where($where)->in($in)->group('sn')->select();

		foreach ($price_grade as $key => $val) {
			$temp_key = $key + 1;
			$price_grade[$temp_key]['goods_num']		= $val['goods_num'];
			$price_grade[$temp_key]['start']			= $row['min'] + round($dx * $val['sn']);
			$price_grade[$temp_key]['end']				= $row['min'] + round($dx * ($val['sn'] + 1));
			$price_grade[$temp_key]['price_range']		= $price_grade[$temp_key]['start'] . '&nbsp;-&nbsp;' . $price_grade[$temp_key]['end'];
			$price_grade[$temp_key]['formated_start']	= price_format($price_grade[$temp_key]['start']);
			$price_grade[$temp_key]['formated_end']		= price_format($price_grade[$temp_key]['end']);
			$price_grade[$temp_key]['url']				= RC_Uri::url('category', array(
					'cid'			=> $cat_id,
					'bid'			=> $brand,
					'price_min'		=> $price_grade[$temp_key]['start'],
					'price_max'		=> $price_grade[$temp_key]['end'],
					'filter_attr'	=> $filter_attr_str
			));
			/* 判断价格区间是否被选中 */
			if (isset($price_min) && $price_grade[$temp_key]['start'] == $price_min && $price_grade[$temp_key]['end'] == $price_max) {
				$price_grade[$temp_key]['selected'] = 1;
			} else {
				$price_grade[$temp_key]['selected'] = 0;
			}
		}

		$price_grade[0]['start'] = 0;
		$price_grade[0]['end'] = 0;
		$price_grade[0]['price_range'] = RC_Lang::lang('all_attribute');
		$price_grade[0]['url'] = RC_Uri::url('goods_list', array('cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>0, 'price_max'=> 0, 'filter_attr'=>$filter_attr_str));
		$price_grade[0]['selected'] = empty($price_max) ? 1 : 0;
		return $price_grade;
	}

	/**
	 *
	 * @param unknown $cat_id
	 * @param number $brand
	 * @param unknown $filter
	 */
	public function get_brands_range($cat_id = 0, $brand = 0, $filter = array()) {
		//获取参数
		//获取参数
		if(empty($cat_id)) $cat_id											= $cat_id;
		if(empty($brand)) $brand											= $brand;
		if(empty($filter['price_min'])) $filter['price_min']				= $this->price_min;
		if(empty($filter['price_max'])) $filter['price_max']				= $this->price_max;
		if(empty($filter['filter_attr_str'])) $filter['filter_attr_str']	= $this->filter_attr_str;
		if(empty($filter['children'])) $filter['children']					= $this->children;
		if(empty($filter['cat'])) $filter['cat']							= $this->cat;

		return $this->_get_brands_range($cat_id, $brand, $filter);
	}

	/**
	 * 获得指定分类下所有底层分类的ID
	 *
	 * @access public
	 * @param integer $cat
	 *        	指定的分类ID
	 * @return string
	 */
	function get_children($cat = 0) {
		return 'cat_id ' . db_create_in (array_unique(array_merge(array($cat), array_keys(cat_list($cat, 0, false )))));
	}

	/**
	 * 获取分类品牌
	 * @param unknown $cat_id
	 * @param unknown $brand
	 * @param unknown $price_min
	 * @param unknown $price_max
	 * @param unknown $filter_attr_str
	 * @return number
	 */
	private function _get_brands_range($cat_id, $brand=0, $filter = array()) {
		$price_min			= $filter['price_min'];
		$price_max			= $filter['price_max'];
		$filter_attr_str	= $filter['filter_attr_str'];

		$where = array(
			'b.is_show'			=> 1,
			'g.is_on_sale'		=> 1,
			'g.is_alone_sale'	=> 1,
			'g.is_delete'		=> 0
		);
		$field = 'b.brand_id, b.brand_name, COUNT(*) | goods_num';
		$in = empty($cat_id) ? '' : array('g.cat_id' => $cat_id);
		// $db_brand_viewmodel = RC_Loader::load_app_model ('brand_viewmodel');
		 RC_Loader::load_theme('extras/model/goods/goods_brand_viewmodel.class.php');
        $db_brand_viewmodel       = new goods_brand_viewmodel();
		if(empty($brand)){
			$brand = $db_brand_viewmodel->join(array('goods', 'goods_cat'))
			->field($field)->where($where)->in($in)
			->group('b.brand_id')->having('`goods_num`>0')->order(array('b.sort_order'=>'ASC', 'b.brand_id'=>'ASC'))->select();
		}else {
			$brand = $db_brand_viewmodel->join(null)->where(array('b.brand_id' => $brand))->select();
		}
		foreach ($brand AS $key => $val) {
			$temp_key = $key + 1;
			$brands[$temp_key]['brand_name'] = $val['brand_name'];
			$brands[$temp_key]['url'] = RC_Uri::url('goods_list', array('cid' => $cat_id, 'bid' => $val['brand_id'], 'price_min'=>$price_min, 'price_max'=> $price_max, 'filter_attr'=>$filter_attr_str));
			$brands[$temp_key]['brand_id'] = $val['brand_id'];
			/* 判断品牌是否被选中 */
			if ($brand == $brands[$key]['brand_id']){
				$brands[$temp_key]['selected'] = 1;
			} else {
				$brands[$temp_key]['selected'] = 0;
			}
		}
		$brands[0]['brand_name'] = RC_Lang::lang('all_attribute');
		$brands[0]['url'] = RC_Uri::url('category', array('cid' => $cat_id, 'bid' => 0, 'price_min'=>$price_min, 'price_max'=> $price_max, 'filter_attr'=>$filter_attr_str));
		$brands[0]['selected'] = empty($brand) ? 1 : 0;
		ksort($brands);
		return $brands;
	}

	/**
	 *
	 * @param unknown $cat_id
	 * @param number $brand
	 * @param unknown $filter
	 */
	public function get_attr_range($cat_id = 0, $brand = 0, $filter = array()) {
		if ($this->cat['filter_attr'] > 0) {
			//获取参数
			if(empty($cat_id)) $cat_id											= $this->cat_id;
			if(empty($brand)) $brand											= $this->brand;
			if(empty($filter['price_min'])) $filter['price_min']				= $this->price_min;
			if(empty($filter['price_max'])) $filter['price_max']				= $this->price_max;
			if(empty($filter['filter_attr_str'])) $filter['filter_attr_str']	= $this->filter_attr_str;
			if(empty($filter['children'])) $filter['children']					= $this->children;
			if(empty($filter['cat'])) $filter['cat']							= $this->cat;

			return $this->_get_attr_range($cat_id, $brand, $filter);
		}
	}

	/**
	 * 获取分类属性
	 * @param unknown $cat_id
	 * @param number $brand
	 * @param number $price_min
	 * @param number $price_max
	 * @param number $filter_attr_str
	 * @return Ambigous <multitype:, number, void, boolean, string>
	 */
	private function _get_attr_range($cat_id, $brand=0, $filter = array()) {
		$price_min			= $filter['price_min'];
		$price_max			= $filter['price_max'];
		$filter_attr_str	= $filter['filter_attr_str'];
		$children			= $filter['children'];
		$cat				= $filter['cat']; // 获得分类的相关信息

		$filter_attr 				= empty($filter_attr_str) ? '' : explode('.', $filter_attr_str);

		$cat_filter_attr = explode(',', $cat['filter_attr']);/*提取出此分类的筛选属性*/
		$all_attr_list = array();
		foreach ($cat_filter_attr AS $key => $value){
			// $db_attribute_viewmodel = RC_Loader::load_app_model ('attribute_viewmodel');
			RC_Loader::load_theme('extras/model/goods/goods_attribute_viewmodel.class.php');
        $db_attribute_viewmodel       = new goods_attribute_viewmodel();
			$db_attribute_viewmodel->view =array(
					'goods_attr' => array(
							'type'  => Component_Model_View::TYPE_INNER_JOIN,
							'alias' => 'ga',
							'on'    => 'ga.attr_id = a.attr_id'
					),
					'goods' => array (
							'type' 	=> Component_Model_View::TYPE_INNER_JOIN,
							'alias' => 'g',
							'on' 	=> 'ga.goods_id = g.goods_id'
					)
			);
			$where = array(
					'g.is_delete'		=> 0,
					'g.is_on_sale'		=> 1,
					'g.is_alone_sale'	=> 1,
					'a.attr_id'			=> $value
			);
			$in = $this->get_cats_goods($children, 'g.goods_id');

			$temp_name = $db_attribute_viewmodel->join(array('goods_attr', 'goods'))->field('a.attr_name')->where($where)->in($in)->get_field();
			if ($temp_name) {
				$all_attr_list[$key]['filter_attr_name'] = $temp_name;
				// $db_goods_viewmodel = RC_Loader::load_app_model ('goods_viewmodel');
				RC_Loader::load_theme('extras/model/goods/goods_viewmodel.class.php');
        $db_goods_viewmodel       = new goods_viewmodel();
				$db_goods_viewmodel->view =array(
					'goods_attr' => array (
						'type' => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'ga',
						'on' => 'g.goods_id = ga.goods_id'
					),
					'attribute' => array (
						'type' 	=> Component_Model_View::TYPE_INNER_JOIN,
						'alias' => 'a',
						'on' 	=> 'ga.attr_id = a.attr_id'
					)
				);
				$field = 'a.attr_id, MIN(ga.goods_attr_id ) | goods_id, ga.attr_value | attr_value';
				$where = array(
						'g.is_delete'		=> 0,
						'g.is_on_sale'		=> 1,
						'g.is_alone_sale'	=> 1,
						'a.attr_id'			=>$value
				);
				$attr_list = $db_goods_viewmodel->join(array('goods_attr','attribute'))->field($field)->where($where)->in($in)->group('ga.attr_value')->select();
				$temp_arrt_url_arr = array();
				for ($i = 0; $i < count($cat_filter_attr); $i++){/*获取当前url中已选择属性的值，并保留在数组中*/
					$temp_arrt_url_arr[$i] = !empty($filter_attr[$i]) ? $filter_attr[$i] : 0;
				}

				$temp_arrt_url_arr[$key] = 0;/*“全部”的信息生成*/
				$temp_arrt_url = implode('.', $temp_arrt_url_arr);
				$all_attr_list[$key]['attr_list'][0]['attr_value'] = RC_Lang::lang('all_attribute');
				$all_attr_list[$key]['attr_list'][0]['url'] = RC_Uri::url('goods_list', array('cid'=>$cat_id, 'bid'=>$brand, 'price_min'=>$price_min, 'price_max'=>$price_max, 'filter_attr'=>$temp_arrt_url));
				$all_attr_list[$key]['attr_list'][0]['selected'] = empty($filter_attr[$key]) ? 1 : 0;

				foreach ($attr_list as $k => $v){
					$temp_key = $k + 1;
					$temp_arrt_url_arr[$key] = $v['goods_id'];/*为url中代表当前筛选属性的位置变量赋值,并生成以‘.’分隔的筛选属性字符串*/
					$temp_arrt_url = implode('.', $temp_arrt_url_arr);

					$all_attr_list[$key]['attr_list'][$temp_key]['attr_value'] = $v['attr_value'];
					$all_attr_list[$key]['attr_list'][$temp_key]['url'] = RC_Uri::url('goods/category/init',array('cic' => $cat_id, 'bid'=>$brand, 'price_min'=>$price_min, 'price_max'=>$price_max, 'filter_attr'=>$temp_arrt_url));

					if (!empty($filter_attr[$key]) AND $filter_attr[$key] == $v['goods_id']){
						$all_attr_list[$key]['attr_list'][$temp_key]['selected'] = 1;
					}
					else{
						$all_attr_list[$key]['attr_list'][$temp_key]['selected'] = 0;
					}
				}
			}
		}
		return $all_attr_list;
	}

	/**
	 * 获得指定分类下的子分类的数组
	 *
	 * @access public
	 * @param int $cat_id
	 *        	分类的ID
	 * @param int $level
	 *        	限定返回的级数。为0时返回所有级数
	 * @param int $is_show_all
	 *        	如果为true显示所有分类，如果为false隐藏不可见分类。
	 * @return mix
	 */
	 public function cat_list($cat_id = 0, $level = 0, $is_show_all = false) {
		// 加载方法
		// $db_goods = RC_Loader::load_app_model('goods_model');
		 RC_Loader::load_theme('extras/model/goods/goods_model.class.php');
        $db_goods = new goods_model();
		// $db_category = RC_Loader::load_app_model('sys_category_viewmodel');
		 RC_Loader::load_theme('extras/model/goods/goods_sys_category_viewmodel.class.php');
        $db_category = new goods_sys_category_viewmodel();
		// $db_goods_cat = RC_Loader::load_app_model('goods_cat_viewmodel');
		 RC_Loader::load_theme('extras/model/goods/goods_cat_viewmodel.class.php');
        $db_goods_cat = new goods_cat_viewmodel();
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
			return array ();
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

		if (! empty($options )) {
			foreach ($options as $key => $value ) {
				$options [$key] ['url'] = RC_Uri::url('category', array('cid' => $value ['cat_id']));
			}
		}
		return $options;
	}

	/**
	 * 获得扩展分类或扩展分类属于指定分类的所有商品ID
	 *
	 * @access public
	 * @param string $cat_id
	 *        	分类查询字符串
	 * @return string
	 */
	public function get_cats_goods($cats, $field_name = false) {
		// $db_goods = RC_Loader::load_app_model('goods_model', 'goods');
		RC_Loader::load_theme('extras/model/goods/goods_model.class.php');
        $db_goods       = new goods_model();
		// $db_goods_cat = RC_Loader::load_app_model('goods_cat_model', 'goods');
		RC_Loader::load_theme('extras/model/goods/goods_cat_model.class.php');
        $db_goods_cat       = new goods_cat_model();
		$data = $db_goods->field('goods_id')->in($cats)->select();
		$res = $db_goods_cat->field('goods_id')->in($cats)->select();
		$arr = array();
		if (!empty($data)) {
			foreach ( $data as $row ) {
				if(!empty($field_name)){
					$arr[$field_name][] = $row['goods_id'];
				} else {
					$arr[] = $row['goods_id'];
				}
			}
		}
		if (!empty($res)) {
			foreach ( $res as $row ) {
				if(!empty($field_name)){
					$arr[$field_name][] = $row['goods_id'];
				} else {
					$arr[] = $row['goods_id'];
				}
			}
		}
		return $arr;
	}

	/**
	 * 取得最近的上级分类的grade值
	 *
	 * @access  public
	 * @param   int     $cat_id    //当前的cat_id
	 *
	 * @return int
	 */
	public function get_parent_grade($cat_id) {
		static $res = NULL;

		if ($res === NULL) {
			// $data = RC_Cache::app_getcache('cat_parent_grade', 'category');
			$data = RC_Cache::app_cache_get('cat_parent_grade', 'goods');
			if ($data === false) {
				// $db_category = RC_Loader::load_app_model ('category_model');
				RC_Loader::load_theme('extras/model/goods/goods_category_model.class.php');
        $db_category       = new goods_category_model();
				$res = $db_category->field('parent_id, cat_id, grade')->select();
				RC_Cache::app_cache_set('cat_parent_grade', $res, 'goods');
			} else {
				$res = $data;
			}
		}
		if (!$res) {
			return 0;
		}
		$parent_arr = array();
		$grade_arr = array();
		foreach ($res as $val) {
			$parent_arr[$val['cat_id']] = $val['parent_id'];
			$grade_arr[$val['cat_id']] = $val['grade'];
		}
		while ($parent_arr[$cat_id] > 0 && $grade_arr[$cat_id] == 0) {
			$cat_id = $parent_arr[$cat_id];
		}
		return $grade_arr[$cat_id];
	}

	/**
	 * 获得指定分类同级的所有分类以及该分类下的子分类
	 * @param number $cat_id
	 * @return Ambigous <multitype:, string, String, void, boolean>
	 */
	public function get_categories_tree($cat_id = 0) {
		// $db_category = RC_Loader::load_app_model ('category_model');
		RC_Loader::load_theme('extras/model/goods/goods_category_model.class.php');
        $db_category       = new goods_category_model();
		if ($cat_id > 0) {
			$parent = $db_category->where(array('cat_id' => $cat_id))->get_field('parent_id');
			$parent_id = $parent;
		} else {
			$parent_id = 0;
		}
		$count = $db_category->where(array('parent_id' => $parent_id,'is_show' => 1))->count();
		$cat_arr = array();
		if ($count) {
			/* 获取当前分类及其子分类 */
			$res = $db_category->field('cat_id,cat_name ,parent_id,is_show')->where(array('parent_id' => $parent_id,'is_show'   => 1))->order( array ('sort_order'=> 'asc','cat_id'=> 'asc'))->select();
			foreach ( $res as $row ) {
				$cat_arr [$row ['cat_id']] ['id'] = $row ['cat_id'];
				$cat_arr [$row ['cat_id']] ['name'] = $row ['cat_name'];
				$cat_arr [$row ['cat_id']] ['url'] = RC_Uri::url( 'category', array ('cid' => $row ['cat_id']));
				$cat_arr [$row ['cat_id']] ['cat_id'] = get_child_tree ( $row ['cat_id'] );
			}
		}
		return $cat_arr;
	}

}



// end
