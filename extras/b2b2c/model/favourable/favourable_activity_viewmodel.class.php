<?php
defined('IN_ECJIA') or exit('No permission resources.');
class favourable_activity_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'favourable_activity';
		$this->table_alias_name = 'fa';
		
		$this->view =array(
				'merchants_shop_information' => array( 
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'msi',
						'field' => '',
						'on'    => 'fa.user_id = msi.user_id'				
				),
				
		);
		
		
		parent::__construct();
	}
}

// end