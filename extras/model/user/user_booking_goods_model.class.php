<?php
defined('IN_ECJIA') or exit('No permission resources.');

class user_booking_goods_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'booking_goods';
		parent::__construct();
	}
}

// end