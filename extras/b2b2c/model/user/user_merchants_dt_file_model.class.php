<?php
defined('IN_ECJIA') or exit('No permission resources.');

class user_merchants_dt_file_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'merchants_dt_file';
		parent::__construct();
	}
}

// end