<?php
defined('IN_ECJIA') or exit('No permission resources.');

class merchant_warehouse_goods_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'warehouse_goods';
		parent::__construct();
	}
}

// end