<?php
defined('IN_ECJIA') or exit('No permission resources.');

class goods_bonus_type_model extends Component_Model_Model {
	public $table_name = '';
	public function __construct() {
		$this->table_name = 'bonus_type';
		parent::__construct();
	}
}

// end