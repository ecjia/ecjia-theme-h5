<?php
defined('IN_ECJIA') or exit('No permission resources.');

class user_merchants_shop_brand_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'merchants_shop_brand';
		parent::__construct();
	}
}

// end