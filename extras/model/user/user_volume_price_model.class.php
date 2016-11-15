<?php
defined('IN_ECJIA') or exit('No permission resources.');

class user_volume_price_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'volume_price';
		parent::__construct();
	}
}

// end