<?php
defined('IN_ECJIA') or exit('No permission resources.');

class user_order_goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->db_config = RC_Config::load_config('database');
		$this->db_setting = 'default';
		$this->table_name = 'order_goods';
		$this->table_alias_name = 'og';
		
		$this->view = array(
			'merchants_shop_information' => array(
					'type' 	=> Component_Model_View::TYPE_LEFT_JOIN,
					'alias' => 'ms',
					'on' 	=> 'ms.user_id = og.ru_id'
			)
		);		
		parent::__construct();
	}
}

// end