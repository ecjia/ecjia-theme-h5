<?php
defined('IN_ECJIA') or exit('No permission resources.');

class favourable_goods_cat_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'goods_cat';
		parent::__construct();
	}

}