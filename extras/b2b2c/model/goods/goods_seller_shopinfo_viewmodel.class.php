<?php
defined('IN_ECJIA') or exit('No permission resources.');

class goods_seller_shopinfo_viewmodel extends Component_Model_View {
    public $table_name = '';
    public $view = array();
    public function __construct() {
        $this->db_config 		= RC_Config::load_config('database');
        $this->db_setting 		= 'default';
        $this->table_name 		= 'seller_shopinfo';
        $this->table_alias_name = 'sl';

        $this->view = array(
            'merchants_shop_information' => array(
                'type'  =>	Component_Model_View::TYPE_LEFT_JOIN,
                'alias'	=>	'ms',
                'on'    =>	'ms.user_id = sl.ru_id ',
            ),
            'goods' => array(
                'type'  =>	Component_Model_View::TYPE_LEFT_JOIN,
                'alias'	=>	'g',
                'on'    =>	'g.user_id = sl.ru_id ',
            ),
        );
        parent::__construct();
    }
}
// end