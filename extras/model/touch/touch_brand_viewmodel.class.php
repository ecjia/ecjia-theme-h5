<?php
defined('IN_ECJIA') or exit('No permission resources.');

class touch_brand_viewmodel extends Component_Model_View {
	public $table_name = '';
	public  $view = array();
	public function __construct() {
		$this->table_name = 'brand';
		$this->table_alias_name = 'b';

		$this->view = array(
				'goods' => array(
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'g',
						'on'   	=> 'g.brand_id = b.brand_id'
				),
				'goods_cat' => array(
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'gc',
						'on'    => 'g.goods_id = gc.goods_id'
				)
		);
		parent::__construct();
	}
}

// end
