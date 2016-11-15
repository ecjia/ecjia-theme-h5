<?php
defined('IN_ECJIA') or exit('No permission resources.');

class goods_merchants_shop_information_viewmodel extends Component_Model_View {
	public $table_name = '';
	public $view = array();
	public function __construct() {
		$this->table_name = 'merchants_shop_information';
		$this->table_alias_name = 'msi';
		
		$this->view =array(
				'users' => array( 
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'u',
						'on'    => 'msi.user_id = u.user_id'				
				),
				'category' => array( 
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'c',
						'on'    => 'msi.shop_categoryMain = c.cat_id'				
				),
				'seller_shopinfo' => array(
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'ssi',
						'on'    => 'msi.user_id = ssi.ru_id ',
				),
				'collect_store' => array(
						'type'  => Component_Model_View::TYPE_LEFT_JOIN,
						'alias' => 'cs',
						'on'    => 'msi.user_id = cs.ru_id ',
				),
				
		);
		
		
		parent::__construct();
	}
}

// end