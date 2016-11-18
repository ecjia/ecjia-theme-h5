<?php
/**
 * 地址模块控制器代码
 */
class user_address_controller {

    /**
     * 收货地址列表界面
     */
    public static function address_list() {
        /*赋值于模板*/
        $user_id = $_SESSION['user_id'];
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $consignee_list = get_consignee_list($user_id, 0, $size, $page);
        if (!empty($consignee_list['list'])) {
            foreach ($consignee_list['list'] as $k => $v) {
                $address = '';
                if ($v['province']) {
                    $address .= get_region_name($v['province']);
                }
                if ($v['city']) {
                    $address .= get_region_name($v['city']);
                }
                if ($v['district']) {
                    $address .= get_region_name($v['district']);
                }
                $v['address'] = $address . ' ' . $v['address'];
                $v['url'] = RC_Uri::url('edit_address', array(
                    'id' => $v['address_id']
                ));
                $address_list[] = $v;
            }
        }
        ecjia_front::$controller->assign('addres_list', $address_list);
        ecjia_front::$controller->assign('page', $consignee_list['page']);
        ecjia_front::$controller->assign('title', RC_Lang::lang('consignee_info'));
        ecjia_front::$controller->assign_title(RC_Lang::lang('consignee_info'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_address_list.dwt');
    }

    /**
     * 异步地址列表
     */
    public static function async_addres_list() {
        $user_id = $_SESSION['user_id'];
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $consignee_list = get_consignee_list($user_id, 0, $size, $page);
        $address_list = array();
        if ($consignee_list['list']) {
            foreach ($consignee_list['list'] as $k => $v) {
                $address = '';
                if ($v['province']) {
                    $address .= get_region_name($v['province']);
                }
                if ($v['city']) {
                    $address .= get_region_name($v['city']);
                }
                if ($v['district']) {
                    $address .= get_region_name($v['district']);
                }
                $v['address'] = $address . ' ' . $v['address'];
                $v['url'] = RC_Uri::url('edit_address', array(
                    'id' => $v['address_id']
                ));
                $address_list[] = $v;
            }
        }
        ecjia_front::$controller->assign('addres_list', $address_list);
        $sayList = ecjia_front::$controller->fetch('user_address_list.dwt');
        ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page' , 'is_last' => $consignee_list['is_last']));
    }

    /**
     * 增加收货地址
     */
    public static function add_address() {
        $province_list = get_regions(1, 1);
        $city_list = get_regions(2);
        $district_list = get_regions(3);
        ecjia_front::$controller->assign('title', RC_Lang::lang('add_address'));
        ecjia_front::$controller->assign('country_list', get_regions());
        ecjia_front::$controller->assign('shop_province_list', get_regions(1, ecjia::config('shop_country')));
        ecjia_front::$controller->assign('province_list', $province_list);
        ecjia_front::$controller->assign('city_list', $city_list);
        ecjia_front::$controller->assign('district_list', $district_list);
        ecjia_front::$controller->assign_title(RC_Lang::lang('add_address'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_add_address.dwt');
    }

    /**
     * 插入收货地址
     */
    public static function inster_addres() {
        $user_id = $_SESSION['user_id'];
        $address = array(
            'user_id'   => $user_id,
            'country'   => htmlspecialchars($_POST['country']),
            'province'  => htmlspecialchars($_POST['province']),
            'city'      => htmlspecialchars($_POST['city']),
            'district'  => htmlspecialchars($_POST['district']),
            'address'   => htmlspecialchars($_POST['address']),
            'consignee' => htmlspecialchars($_POST['consignee']),
            'mobile'    => htmlspecialchars($_POST['mobile']),
//             'zipcode'   => htmlspecialchars($_POST['zipcode']),
        );
	    if (empty($address['district'])) {
		    ecjia_front::$controller->showmessage('收货人信息填写不完整', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
	    }
        if (insert_address($address)) {
            ecjia_front::$controller->showmessage(RC_Lang::lang('add_address_success'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl'=>RC_Uri::url('address_list'),'is_show' => false));
        } else {
            ecjia_front::$controller->showmessage(RC_Lang::lang('add_address_error'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
    }

    /**
     * 编辑收货地址的处理
     */
    public static function edit_address() {
        $id             = isset($_GET['id']) ? intval($_GET['id']) : '';
        $consignee      = get_consignee_list($_SESSION['user_id'], $id); /*获得用户对应收货人信息*/
        $province_list  = get_regions(1, 1);
        $city_list      = get_regions(2, $consignee['province']);
        $district_list  = get_regions(3, $consignee['city']);
        ecjia_front::$controller->assign('title', RC_Lang::lang('edit_address'));
        ecjia_front::$controller->assign('consignee', $consignee);
        ecjia_front::$controller->assign('country_list', get_regions());
        ecjia_front::$controller->assign('shop_province_list', get_regions(1, ecjia::config('shop_country')));
        ecjia_front::$controller->assign('province_list', $province_list);
        ecjia_front::$controller->assign('city_list', $city_list);
        ecjia_front::$controller->assign('district_list', $district_list);
        ecjia_front::$controller->assign_title(RC_Lang::lang('edit_address'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_edit_address.dwt');
    }

    /**
     * 更新地址信息
     */
    public static function update_address() {
        $user_id = $_SESSION['user_id'];
        $address = array(
            'user_id'       => $user_id,
            'address_id'    => intval($_POST['address_id']),
            'country'       => intval($_POST['country']),
            'province'      => intval($_POST['province']),
            'city'          => intval($_POST['city']),
            'district'      => intval($_POST['district']),
            'address'       => htmlspecialchars($_POST['address']),
            'consignee'     => htmlspecialchars($_POST['consignee']),
            'mobile'        => htmlspecialchars($_POST['mobile']),
//             'zipcode'       => htmlspecialchars($_POST['zipcode']),
            'default'       =>intval($_POST['default'])
        );
        if (update_address($address)) {
            ecjia_front::$controller->showmessage(RC_Lang::lang('edit_address_success'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl'=>RC_Uri::url('address_list') ,'is_show' => false));
        } else {
            ecjia_front::$controller->showmessage(RC_Lang::lang('edit_address_error'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
    }

    /**
     * 删除收货地址
     */
    public static function del_address_list() {
        $id = intval($_GET['id']);
        // $db_users = RC_Loader::load_app_model ( "users_model" );
        RC_Loader::load_theme('extras/model/user/touch_users_model.class.php');
     $db_users       = new touch_users_model();
        $count = $db_users->where(array('user_id' => $_SESSION['user_id'], 'address_id' => $id))->count();
        if (empty($count)) {
            drop_consignee($id);
            ecjia_front::$controller->showmessage(RC_Lang::lang('del_address_true'),ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('address_list') ,'is_show' => false));
        } else {
            ecjia_front::$controller->showmessage('该地址为默认的收货地址，不能删除', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('address_list')));
        }
    }

    /**
     * 地区筛选
     */
    public static function region() {
        $type = intval($_GET['type']) ? intval($_GET['type']) : 0;
        $parent = intval($_GET['parent']) ? intval($_GET['parent']) : 0;
        $arr['regions'] = get_regions($type, $parent);
        $arr['type'] = $type;
        $arr['target'] = htmlspecialchars(trim(stripslashes($_GET['target'])));
        ecjia_front::$controller->showmessage('地区参数', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, $arr);
    }
    
    /**
     * 定位当前位置
     */
    public static function near_location() {
        ecjia_front::$controller->assign('title', '您当前地址列表');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->assign_title('当前位置');
        ecjia_front::$controller->display('user_near_location.dwt');
    }
    
    /**
     * 定位列表
     */
    public static function location() {
        $province_list = get_regions(1, 1);
        $city_list = get_regions(2);
        $district_list = get_regions(3);
        ecjia_front::$controller->assign('country_list', get_regions());
        ecjia_front::$controller->assign('shop_province_list', get_regions(1, ecjia::config('shop_country')));
        ecjia_front::$controller->assign('province_list', $province_list);
        ecjia_front::$controller->assign('city_list', $city_list);
        ecjia_front::$controller->assign('district_list', $district_list);
        ecjia_front::$controller->assign_title('定位');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_location.dwt');
    }

}

// end
