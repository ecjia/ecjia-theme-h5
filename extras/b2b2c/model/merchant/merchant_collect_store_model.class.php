<?php
defined('IN_ECJIA') or exit('No permission resources.');

class merchant_collect_store_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'collect_store';
		parent::__construct();
	}



}

// end