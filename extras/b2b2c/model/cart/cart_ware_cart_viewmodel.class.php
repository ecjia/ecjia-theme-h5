<?php
defined('IN_ECJIA') or exit('No permission resources.');

class cart_ware_cart_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->db_config 		= RC_Config::load_config('database');
		$this->db_setting 		= 'default';
		$this->table_name 		= 'cart';
		$this->table_alias_name = 'c';

		$this->view = array(
			'region_warehouse' => array(
				'type'  =>	Component_Model_View::TYPE_LEFT_JOIN,
				'alias'	=>	'rw',
				'on'    =>	'rw.region_id = c.warehouse_id ',
			)
    	);	
		parent::__construct();
	}
}

// end