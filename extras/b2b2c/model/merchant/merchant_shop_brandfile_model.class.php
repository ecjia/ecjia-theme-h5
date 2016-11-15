<?php
defined('IN_ECJIA') or exit('No permission resources.');

class merchant_shop_brandfile_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'merchants_shop_brandfile';
		parent::__construct();
	}
}

// end