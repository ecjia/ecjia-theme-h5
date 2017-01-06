<?php
/**
 * 地址模块控制器代码
 */
class user_address_controller {

    /**
     * 收货地址列表界面
     */
    public static function address_list() {
    	unset($_SESSION['referer_url']);
    	
    	$address_list = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_LIST)->data(array('token' => ecjia_touch_user::singleton()->getToken()))->run();
    	ecjia_front::$controller->assign('address_list', $address_list);
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_address_list.dwt');
    }

    /**
     * 异步地址列表
     */
    public static function async_address_list() {
        $user_id = $_SESSION['user_id'];
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
    	
        $address_list = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_LIST)->data(array('token' => ecjia_touch_user::singleton()->getToken()))->run();
		ecjia_front::$controller->assign('address_list', $address_list);

		$sayList = ecjia_front::$controller->fetch('user_address_list.dwt');
        return ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page' , 'is_last' => $consignee_list['is_last']));
    }
    
    public static function save_temp_data ($is_return = 0, $data_key, $is_clear, $options = array()) {
        if (isset($_GET['city'])) {
            $options['tem_city_name'] = $_GET['city'];
        }
        if (isset($_GET['city_id'])) {
            $options['tem_city'] = $_GET['city_id'];
        }
        if (isset($_GET['address'])) {
            $options['tem_address'] = $_GET['address'];
        }
        if (isset($_GET['name'])) {
            $options['tem_address'] = $_GET['name'];
        }
        if (isset($_GET['addr'])) {
            $options['tem_address_detail'] = $_GET['addr'];
        }
        if (isset($_GET['address_info'])) {
            $options['tem_address_info'] = $_GET['address_info'];
        }
        if (isset($_GET['consignee'])) {
            $options['tem_consignee'] = $_GET['consignee'];
        }
        if (isset($_GET['mobile'])) {
            $options['tem_mobile'] = $_GET['mobile'];
        }
        
        $temp_data = user_address_controller::update_temp_data('add', $_GET['clear'], $options);
        if ($is_return) {
            return $temp_data;
        }
    }
    
    //临时数据
    private static function update_temp_data($data_key, $is_clear, $options = array()) {
        if($is_clear) {
            return $temp_data = $_SESSION['address'][$data_key] = array();
        } 
        if ($options) {
            $keys_array = array(
                'id','consignee','address','address_info',
                'country','province','city','district',
                'country_name','province_name','city_name','district_name',
                'tel','mobile','email',
                'default_address',
                'best_time','zipcode',
                'location' => array(
                    'longitude',
                    'latitude'
                ),
                //tem
                'tem_city',
                'tem_city_name',
                'tem_address',
                'tem_address_info',
                'tem_address_detail',
                'tem_mobile',
                'tem_consignee'
            );
            
            foreach ($keys_array as $key) {
                if (is_array($key)) {
                    foreach ($key as $child) {
                        if (isset($options[$key][$child])) {
                            $_SESSION['address'][$data_key][$key][$child] = $options[$key][$child];
                        }
                    }
                } else {
                    if (isset($options[$key])) {
                        $_SESSION['address'][$data_key][$key] = $options[$key];
                    }
                }
            }
        }
        return $temp_data = $_SESSION['address'][$data_key];
        
    }

    /**
     * 增加收货地址
     */
    public static function add_address() {
        $temp_data = user_address_controller::save_temp_data(1, 'add', $_GET['clear'], $_GET);
        ecjia_front::$controller->assign('temp', $temp_data);
        ecjia_front::$controller->assign('location_backurl', urlencode(RC_Uri::url('user/user_address/add_address')));
        
		$referer_url = !empty($_GET['referer_url']) ? urlencode($_GET['referer_url']) : (!empty($_SESSION['referer_url']) ? $_SESSION['referer_url'] : '');
		if (!empty($referer_url)) {
			$_SESSION['referer_url'] = $referer_url;
			ecjia_front::$controller->assign('referer_url', $referer_url);
		}
    	ecjia_front::$controller->assign('form_action', RC_Uri::url('user/user_address/insert_address'));
        ecjia_front::$controller->assign('temp_key', 'add');
        ecjia_front::$controller->assign_title('添加收货地址');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_address_edit.dwt');
    }

    /**
     * 插入收货地址
     */
    public static function insert_address() {
        if (empty($_POST['city_id']) || empty($_POST['address']) || empty($_POST['consignee']) || empty($_POST['mobile'])) {
            return ecjia_front::$controller->showmessage('请完整填写相关信息', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => ''));
        }

        $params = array(
            'token' => ecjia_touch_user::singleton()->getToken(),
            'address' => array(
                'city'      	=> intval($_POST['city_id']),
                'address'   	=> htmlspecialchars($_POST['address']),
                'address_info'	=> htmlspecialchars($_POST['address_info']),
                'consignee' 	=> htmlspecialchars($_POST['consignee']),
                'mobile'    	=> htmlspecialchars($_POST['mobile']),
            )
           
        );
        $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_ADD)->data($params)->send()->getBody();
        $rs = json_decode($rs,true);
        
        if (!$rs['status']['succeed']) {
            return ecjia_front::$controller->showmessage($rs['status']['error_desc'], ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON,array('pjaxurl' => ''));
        } else {
        	$address_id = $rs['data']['address_id'];
        }
        $url_address_list = RC_Uri::url('user/user_address/address_list');
        user_address_controller::update_temp_data('add', 1);
        
        if (!empty($_SESSION['referer_url'])) {
        	$pjax_url = urldecode($_SESSION['referer_url']);
        	setcookie('location_address_id', $address_id);
        	setcookie('location_name', htmlspecialchars($_POST['address_location']));
        } else {
        	$pjax_url = RC_Uri::url('user/user_address/address_list');
        }
        unset($_SESSION['referer_url']);
        return ecjia_front::$controller->showmessage(RC_Lang::lang('add_address_success'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => $pjax_url));
        
    }

    /**
     * 编辑收货地址的处理
     */
    public static function edit_address() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (empty($id)) {
            return ecjia_front::$controller->showmessage('参数错误', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => ''));
        }
        $temp_key = 'edit_' . $id;
        $temp_data = user_address_controller::save_temp_data(1, $temp_key, $_GET['clear'], $_GET);
        $params = array('token' => ecjia_touch_user::singleton()->getToken(), 'address_id' => $id);
        $info = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_INFO)->data($params)->run();
        if (empty($temp_data['tem_city_name'])) {
            $temp_data['tem_city_name'] = $info['city_name'];
        }
        ecjia_front::$controller->assign('info', $info);
        ecjia_front::$controller->assign('temp', $temp_data);
        ecjia_front::$controller->assign('temp_key', $temp_key);
        ecjia_front::$controller->assign('form_action', RC_Uri::url('user/user_address/update_address'));
        ecjia_front::$controller->assign('location_backurl', urlencode(RC_Uri::url('user/user_address/edit_address', array('id' => $id))));
        // ecjia_front::$controller->assign('hideinfo', '1');
        ecjia_front::$controller->assign_title('编辑收货地址');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_address_edit.dwt');
    }

    /**
     * 更新地址信息
     */
    public static function update_address() {

        if (empty($_POST['address_id'])) {
            return ecjia_front::$controller->showmessage('参数错误', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => ''));
        }
        if (empty($_POST['city_id']) || empty($_POST['address']) || empty($_POST['consignee']) || empty($_POST['mobile'])) {
            return ecjia_front::$controller->showmessage('请完整填写相关信息', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => ''));
        }
        $params = array(
            'token' => ecjia_touch_user::singleton()->getToken(),
            'address_id' => $_POST['address_id'],
            'address' => array(
                'city'      => intval($_POST['city_id']),
                'address'   => htmlspecialchars($_POST['address']),
                'address_info'   => htmlspecialchars($_POST['address_info']),
                'consignee' => htmlspecialchars($_POST['consignee']),
                'mobile'    => htmlspecialchars($_POST['mobile']),
            )
             
        );
        $rs = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_UPDATE)->data($params)->send()->getBody();
        $rs = json_decode($rs,true);

        if (!$rs['status']['succeed']) {
            return ecjia_front::$controller->showmessage($rs['status']['error_desc'], ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON,array('pjaxurl' => ''));
        }
        $temp_data = user_address_controller::save_temp_data(0, 'edit_'.$_POST['address_id'], 1);
        
        $url_address_list = RC_Uri::url('user/user_address/address_list');
        return ecjia_front::$controller->showmessage(RC_Lang::lang('edit_address_success'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON,array('pjaxurl' => $url_address_list));
    }

    /**
     * 删除收货地址
     */
    public static function del_address() {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id) {
            return ecjia_front::$controller->showmessage('参数错误', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('address_list')));
        }

        $params = array('token' => ecjia_touch_user::singleton()->getToken(), 'address_id' => $id);
        $address_info = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_INFO)->data($params)->run();

        if ($address_info['default_address'] == 0) {
            $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_DELETE)->data($params)->send()->getBody();
            $data = json_decode($data,true);
            if ($data['status']['succeed']) {
                 return ecjia_front::$controller->showmessage('删除成功', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('address_list')));
            } else {
                return ecjia_front::$controller->showmessage($data['status']['error_desc'], ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('address_list')));
            }
    	    
        } else {
            return ecjia_front::$controller->showmessage('该地址为默认的收货地址，不能删除', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('address_list')));
        }
    }
    

    /**
     * 设置默认地址
     */
    public static function set_default() {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id) {
            return ecjia_front::$controller->showmessage('参数错误', ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('address_list')));
        }
    
        $params = array('token' => ecjia_touch_user::singleton()->getToken(), 'address_id' => $id);
    
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_SETDEFAULT)->data($params)->send()->getBody();
        $data = json_decode($data,true);
        if ($data['status']['succeed']) {
            return ecjia_front::$controller->showmessage('设置成功', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('address_list')));
        } else {
            return ecjia_front::$controller->showmessage($data['status']['error_desc'], ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('address_list')));
        }
    }

    /**
     * 地区筛选
     */
    public static function region() {}

    /**
     * 定位当前位置
     */
    public static function near_location() {
    	$referer_url = !empty($_GET['referer_url']) ? $_GET['referer_url'] : '';
    	if (!empty($referer_url)) {
    		ecjia_front::$controller->assign('referer_url', $referer_url);
    	}
    	
        if(!empty($_GET['address_id'])) {
            ecjia_front::$controller->assign('action_url', RC_Uri::url('user/user_address/edit_address', array('id' => intval($_GET['address_id']))));
            $temp_data = user_address_controller::save_temp_data(1, 'edit_'.$_GET['address_id'], $_GET['clear'], $_GET);
        } else {
            ecjia_front::$controller->assign('action_url', RC_Uri::url('user/user_address/add_address'));
            $temp_data = user_address_controller::save_temp_data(1, 'add', $_GET['clear'], $_GET);
            if (empty($temp_data['tem_city'])) {
                return ecjia_front::$controller->showmessage('请先选择城市', ecjia::MSGTYPE_ALERT| ecjia::MSGSTAT_SUCCESS, array('pjaxurl' => ''));
            }
        }
        ecjia_front::$controller->assign('temp', $temp_data);
    	// ecjia_front::$controller->assign('hideinfo', '1');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->assign_title('选择位置');
        ecjia_front::$controller->display('user_near_location.dwt');
    }

    /**
     * 定位列表
     */
    public static function location() {
    	// ecjia_front::$controller->assign('hideinfo', '1');
    	ecjia_front::$controller->assign('title', '上海');
        ecjia_front::$controller->assign_title('定位');
        ecjia_front::$controller->assign_lang();
        
        $referer_url = !empty($_GET['referer_url']) ? urldecode($_GET['referer_url']) : '';
        if (!empty($referer_url)) {
        	ecjia_front::$controller->assign('referer_url', urlencode($referer_url));
        }
        
        $address_list = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_LIST)->data(array('token' => $token['access_token']))->run();
        ecjia_front::$controller->assign('addres_list', $address_list);
        
        ecjia_front::$controller->display('user_location.dwt');
    }
    
    /**
     * 异步地址列表
     */
    public static function async_location() {
        $address_list = ecjia_touch_manager::make()->api(ecjia_touch_api::ADDRESS_LIST)->data(array('token' => $token['access_token']))->run();
        // ecjia_front::$controller->assign('hideinfo', 1);
        ecjia_front::$controller->assign_lang();
    	ecjia_front::$controller->assign('addres_list', $address_list);
    	$sayList = ecjia_front::$controller->fetch('user_location.dwt');
    	return ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page' ,'is_last' => $consignee_list['is_last']));
    }
    
    public static function near_address() {
    	$region   = $_GET['region'];
    	$keywords = $_GET['keywords'];
    	$key       = "HVNBZ-HHR3P-HVBDP-LID55-D2YM3-2AF2W";
//     	$key       = ecjia::config('map_qq_key');
    	$url       = "http://apis.map.qq.com/ws/place/v1/suggestion/?region=".$region."&keyword=".$keywords."&key=".$key;
    	$response = RC_Http::remote_get($url);
    	$content  = json_decode($response['body']);
    	return ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('content' => $content));
    
    }
    
    /**
     * 获取指定地区的子级地区
     */
    public function get_region(){
        $type      = !empty($_GET['type'])   ? intval($_GET['type'])   : 0;
        $parent        = !empty($_GET['parent']) ? intval($_GET['parent']) : 0;
        $arr['regions'] = ecjia_region::instance()->region_datas($type, $parent);
        $arr['type']    = $type;
        $arr['target']  = !empty($_GET['target']) ? stripslashes(trim($_GET['target'])) : '';
        $arr['target']  = htmlspecialchars($arr['target']);
        echo json_encode($arr);
    }
     /**
     * 根据地区获取经纬度
     */
    public function getgeohash(){
        $shop_province      = !empty($_REQUEST['province'])    ? intval($_REQUEST['province'])           : 0;
        $shop_city          = !empty($_REQUEST['city'])        ? intval($_REQUEST['city'])               : 0;
        $shop_district      = !empty($_REQUEST['district'])    ? intval($_REQUEST['district'])           : 0;
        $shop_address       = !empty($_REQUEST['address'])     ? htmlspecialchars($_REQUEST['address'])  : 0;
        if(empty($shop_province)){
            return $this->showmessage('请选择省份', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'province'));
        }
        if(empty($shop_city)){
            return $this->showmessage('请选择城市', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'city'));
        }
        if(empty($shop_district)){
            return $this->showmessage('请选择地区', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'district'));
        }
        if(empty($shop_address)){
            return $this->showmessage('请填写详细地址', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('element' => 'address'));
        }
        $city_name = RC_DB::table('region')->where('region_id', $shop_city)->pluck('region_name');
        $city_district = RC_DB::table('region')->where('region_id', $shop_district)->pluck('region_name');
        $address = $city_name.'市'.$shop_address;
        $shop_point = file_get_contents("https://api.map.baidu.com/geocoder/v2/?address='".$address."&output=json&ak=E70324b6f5f4222eb1798c8db58a017b");
        $shop_point = (array)json_decode($shop_point);
        $shop_point['result'] = (array)$shop_point['result'];
        $location = (array)$shop_point['result']['location'];
        echo json_encode($location);
    }
    
    public static function choose_address() {
    	$referer_url = !empty($_GET['referer_url']) ? urldecode($_GET['referer_url']) : RC_Uri::url('touch/index/init');
    	$address_id = !empty($_GET['address_id']) ? intval($_GET['address_id']) : 0;
    	if (!empty($address_id)) {
    		$address_info = user_function::address_info(ecjia_touch_user::singleton()->getToken(), $address_id);

    		setcookie('location_address_id', $address_id);
    		setcookie('location_name', $address_info['address']);
    		setcookie('longitude', $address_info['location']['longitude']);
    		setcookie('latitude', $address_info['location']['latitude']);
    	}
    	return ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => $referer_url));
    }
}

// end