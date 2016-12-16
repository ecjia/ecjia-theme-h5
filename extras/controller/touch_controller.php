<?php
/**
 * Touch主控制器
 */
class touch_controller {

    /**
     * 首页信息
     */
    public static function init() {
        ecjia_front::$controller->assign('more_sales', RC_Uri::url('goods/index/promotion'));
        ecjia_front::$controller->assign('more_news', RC_Uri::url('goods/index/new'));
        ecjia_front::$controller->assign('theme_url', RC_Theme::get_template_directory_uri() . '/');
        $addr = $_GET['addr'];
        $name = $_GET['name'];
        if(!empty($addr)){
        	setcookie("location_address", $addr);
        	setcookie("location_name", $name);
        	ecjia_front::$controller->redirect(RC_Uri::url('touch/index/init'));
        }
        
        $arr = array(
        	'location' => array('longitude' => '121.416359', 'latitude' => '31.235371')
        );
        $data = ecjia_touch_manager::make()->api(ecjia_touch_api::HOME_DATA)->data($arr)->run();
        //处理ecjiaopen url
        if (!empty($data)) {
        	foreach ($data as $k => $v) {
        		if ($k == 'player' || $k == 'mobile_menu') {
        			foreach ($v as $key => $val) {
        				if (strpos($val['url'], 'ecjiaopen://') === 0) {
        					$data[$k][$key]['url'] = with(new ecjia_open($val['url']))->toHttpUrl();
        				}
        			}
        		} elseif ($k == 'adsense_group' || $k == 'promote_goods') {
        			foreach ($v as $key => $val) {
        				if (isset($val['adsense'])) {
        					foreach ($val['adsense'] as $k_k => $v_v) {
        						if (strpos($v_v['url'], 'ecjiaopen://') === 0) {
        							$data[$k][$key]['adsense'][$k_k]['url'] = with(new ecjia_open($v_v['url']))->toHttpUrl();
        						}
        					}
        				}
        				if ($k == 'adsense_group') {
        					$data['adsense_group'][$key]['count'] = count($val['adsense']);
        				}
        				if ($k == 'promote_goods') {
        					$data['promote_goods'][$key]['promote_end_date'] = RC_Time::local_strtotime($val['promote_end_date']);
        				}
        			}
        		}
        	}
        }
        //首页菜单
        ecjia_front::$controller->assign('navigator', $data['mobile_menu']);
        
        //首页广告
        ecjia_front::$controller->assign('adsense_group', $data['adsense_group']);
        
        //首页促销商品
        ecjia_front::$controller->assign('promotion_goods', $data['promote_goods']);
        
        //新品推荐
        ecjia_front::$controller->assign('new_goods', $data['new_goods']);
        
        //热门推荐
        ecjia_front::$controller->assign('best_goods', $base['list']);
        
        ecjia_front::$controller->assign('hot_goods', $hot['list']);
        ecjia_front::$controller->assign('cat_best', $cat_rec[1]);
        ecjia_front::$controller->assign('cat_new', $cat_rec[2]);
        ecjia_front::$controller->assign('cat_hot', $cat_rec[3]);
        
        ecjia_front::$controller->assign('cycleimage', $data['player']);
        ecjia_front::$controller->assign('page_header', 'index');
        ecjia_front::$controller->assign('searchs', user_function::insert_search());
        ecjia_front::$controller->assign('shop_pc_url', ecjia::config('shop_pc_url'));
        ecjia_front::$controller->assign('copyright', ecjia::config('wap_copyright'));
        ecjia_front::$controller->assign('active', 'index');
        ecjia_front::$controller->assign('address', 'address');
        
        ecjia_front::$controller->assign('searchs', user_function::get_search($store_id));
        ecjia_front::$controller->assign('searchs_count', count(user_function::get_search($store_id)));
        
        ecjia_front::$controller->assign_title();
        ecjia_front::$controller->assign_lang();

        ecjia_front::$controller->display('index.dwt');
    }
    
    
    //请求接口返回数据
    public static function my_location() {
    	$old_locations = $_GET['lat'].','.$_GET['lng'];
    	$key = "HVNBZ-HHR3P-HVBDP-LID55-D2YM3-2AF2W";
//     	http://apis.map.qq.com/ws/coord/v1/translate?locations=39.12,116.83;30.21,115.43&type=3&key=OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77
    	$change_location = "http://apis.map.qq.com/ws/coord/v1/translate?locations=".$old_locations."&type=1"."&key=".$key;
    	$response_location  = RC_Http::remote_get($change_location);
    	$content = json_decode($response_location['body'],true);
    	$tencent_locations =$content['locations'][0]['lat'].','.$content['locations'][0]['lng'];
    
//     	http://apis.map.qq.com/ws/geocoder/v1/?location=39.984154,116.307490&key=OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77&get_poi=1
    	$url       = "https://apis.map.qq.com/ws/geocoder/v1/?location=".$tencent_locations."&key=".$key."&get_poi=1";
    	$response_address= RC_Http::remote_get($url);
    	$content   = json_decode($response_address['body'],true);
    	$location_content = $content['result']['pois'][0];
    	$location_name    = $location_content['title'];
    	$location_address = $location_content['address'];
    	
    	setcookie("location_address", $location_address);
    	setcookie("location_name", $location_name);
    	
    	$url = RC_Uri::url('touch/index/init');
    	ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('url' => $url));
    }
   
    /**
     * ajax获取商品
     */
    public static function ajax_goods() {
        $type = htmlspecialchars($_GET['type']);
        $limit = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        
        $paramater = array(
        	'action_type' 	=> $type,	
 			'pagination' 	=> array('count' => $limit, 'page' => $page),
			'location' 		=> array('longitude' => '121.416359', 'latitude' => '31.235371')
        );
        
        $arr = ecjia_touch_manager::make()->api(ecjia_touch_api::GOODS_SUGGESTLIST)->data($paramater)->send()->getBody();
        $list = json_decode($arr, true);

        $data = !empty($list['data']) ? $list['data'] : array();
        ecjia_front::$controller->assign('goods_list', $data);
        ecjia_front::$controller->assign_lang();
        $sayList = ecjia_front::$controller->fetch('index.dwt');
        
        if ($list['paginated']['more'] == 0) $data['is_last'] = 1;
        return ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList, 'page', 'is_last' => $data['is_last']));
    }

    /**
     * 搜索
     */
    public static function search() {
        $keywords = isset($_GET['keywords']) ? $_GET['keywords'] : '';
        ecjia_front::$controller->assign('keywords', $keywords);
        
        $store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
        ecjia_front::$controller->assign('store_id', $store_id);

        ecjia_front::$controller->assign('searchs', user_function::get_search($store_id));
        ecjia_front::$controller->assign('searchs_count', count(user_function::get_search($store_id)));

        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->assign_title('搜索');
        ecjia_front::$controller->display('search.dwt');
    }

    /**
     * 清除搜索
     */
    public static function del_search($store_id = 0) {
    	$store_id = !empty($_GET['store_id']) ? intval($_GET['store_id']) : 0;
    	$ecjia_search = 'ECJia[search]';
    	if (!empty($store_id)) {
    		$ecjia_search .= '['.$store_id.']';
    	} else {
    		$ecjia_search .= '[other]';
    	}
        setcookie($ecjia_search, '', 1);
        
        $pjaxurl = '';
        if ($store_id <= 0) {
        	$pjaxurl = RC_Uri::url('touch/index/search');
        }
        return ecjia_front::$controller->showmessage('', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => $pjaxurl));
    }
}

// end