<?php
defined('IN_ECJIA') or exit('No permission resources.');

class cart_warehouse_freight_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'warehouse_freight';
		parent::__construct();
	}
}

// end