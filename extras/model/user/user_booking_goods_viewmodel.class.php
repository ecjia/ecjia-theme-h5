<?php
defined('IN_ECJIA') or exit('No permission resources.');

class user_booking_goods_viewmodel extends Component_Model_View {
	public $table_name = '';
	public  $view = array();
	public function __construct() {
		$this->db_config 		= RC_Config::load_config('database');
		$this->db_setting 		= 'default';
		$this->table_name 		= 'booking_goods';
		$this->table_alias_name = 'bg';
		
		$this->view = array(
				'goods' => array(
					'type'  => Component_Model_View::TYPE_LEFT_JOIN,
					'alias'	=> 'g',
// 					'field' => 'bg.rec_id, bg.goods_id, bg.goods_number, bg.booking_time, bg.dispose_note, g.goods_name',
					'on'   	=> 'bg.goods_id = g.goods_id'
				)
				
		);
		parent::__construct();
	}
}

// end