<?php
defined('IN_ECJIA') or exit('No permission resources.');

class merchant_documenttitle_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'merchants_documenttitle';
		parent::__construct();
	}
}

// end