<?php
defined('IN_ECJIA') or exit('No permission resources.');

class touch_seller_shopwindow_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'seller_shopwindow';
		parent::__construct();
	}
}

// end