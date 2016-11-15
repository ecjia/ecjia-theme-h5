<?php
defined('IN_ECJIA') or exit('No permission resources.');

class user_merchants_steps_fields_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'merchants_steps_fields';
		parent::__construct();
	}
}

// end