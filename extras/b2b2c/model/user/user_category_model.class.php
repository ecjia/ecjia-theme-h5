<?php
defined('IN_ECJIA') or exit('No permission resources.');

class user_category_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'category';
		parent::__construct();
	}
}

// end