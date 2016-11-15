<?php
class b2b2c_user_merchant_controller {

    /**
     * 入驻流程列表
     */
    public static function step_list() {
        $user_id = $_SESSION['user_id'];

        if (empty($user_id)) {
            ecjia_front::$controller->showmessage('请先登陆！',ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR, array('pjaxurl'=>RC_Uri::url('user/index/login')));
        }

        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_steps_fields_model.class.php');
        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_steps_process_model.class.php');
        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_steps_title_model.class.php');
        $db_merchants_steps_fields      = new merchant_steps_fields_model();
        $db_merchants_steps_process     = new merchant_steps_process_model();
        $db_merchants_steps_title       = new merchant_steps_title_model();
        
        $res_step = $db_merchants_steps_title->field('tid, fields_steps, fields_titles, titles_annotation, steps_style, fields_special, special_type')->select();
        $res = $db_merchants_steps_process->order(array('process_steps' => 'asc', 'steps_sort' => 'asc'))->select();
        $steps_title_list = array();
        foreach($res_step as $row){
            $steps_title_list[$row['fields_steps']][] = $row;
        }

        //追加入驻状态查看分类
        $res[] = array(
            'id' => '999',
            'process_steps' => 4,
            'process_title' => '入驻状态',
            'steps_sort'    => 1
        );
        $site_process = $db_merchants_steps_fields->where(array('user_id'=>$user_id))->get_field('site_process');
        $strArr = explode('|',$site_process);
        $process_list = array();
        $lock = 0;
        $tmp_index = 1;
        foreach($res as $key=>$row){
            $process_list[$row['process_steps']][$row['steps_sort']]['id'] = $row['id'];
            $process_list[$row['process_steps']][$row['steps_sort']]['steps_sort'] = $row['steps_sort']-1;
            $process_list[$row['process_steps']][$row['steps_sort']]['process_title'] = $row['process_title'];
            $process_list[$row['process_steps']][$row['steps_sort']]['fields_next'] = $row['fields_next'];

            if (!empty($steps_title_list[$row['id']])) {
                foreach ($steps_title_list[$row['id']] as $v) {
                    $tmp_children = array();
                    $tmp_children['tid'] = $v['tid'];
                    $tmp_children['fields_titles'] = $v['fields_titles'];
                    if (in_array('id'.$row['id'].'_'.$v['tid'], $strArr)) {
                        $tmp_children['state'] = 1;
                    } else {
                        if ($lock) {
                            $tmp_children['lock'] = 1;
                        } else {
                            $lock = 1;
                        }
                    }
                    $tmp_children['index'] = $tmp_index++;
                    $process_list[$row['process_steps']][$row['steps_sort']]['children'][] = $tmp_children;
                }
            } else {
                if (in_array('id'.$row['id'].'_0', $strArr)) {
                    $process_list[$row['process_steps']][$row['steps_sort']]['state'] = 1;
                } else {
                    if ($lock) {
                        $process_list[$row['process_steps']][$row['steps_sort']]['lock'] = 1;
                    } else {
                        $lock = 1;
                    }
                }
                $process_list[$row['process_steps']][$row['steps_sort']]['index'] = $tmp_index++;
            }
        }

        ecjia_front::$controller->assign_title('商家入驻中心');
        ecjia_front::$controller->assign('header_left',     array('href' => RC_Uri::url('touch/index/init')));
        ecjia_front::$controller->assign('title',           '商家入驻中心');
        ecjia_front::$controller->assign('process_list',    $process_list);
        ecjia_front::$controller->display('merchants_step_list.dwt');
    }

	/**
	 * 入驻商
	 */
	public static function init() {
        RC_Loader::load_theme('extras/b2b2c/functions/merchant/b2b2c_front_merchant_steps.func.php');

		RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_shop_information_model.class.php');
        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_steps_fields_model.class.php');
		RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_admin_user_model.class.php');
        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_category_temporarydate_model.class.php');
        $db_merchants_category_temporarydate    = new merchant_category_temporarydate_model();
        $db_merchants_shop_information          = new merchant_shop_information_model();
        $db_merchants_steps_fields              = new merchant_steps_fields_model();
		$db_admin_user                          = new merchant_admin_user_model();

        $step = isset($_GET['step'])  ? intval($_GET['step']) : 1;//流程步骤
        $pid_key = isset($_GET['pid_key'])  ? intval($_GET['pid_key']) : 0; //当前步骤数组key
        $tid = isset($_GET['tid'])  ? intval($_GET['tid']) : 0; //当前步骤子项key
        $ec_shop_bid = isset($_REQUEST['ec_shop_bid']) ? $_REQUEST['ec_shop_bid'] : 0; //品牌ID
        $brandView = isset($_REQUEST['brandView']) ? htmlspecialchars(trim($_REQUEST['brandView'])) : ''; //为空则显示品牌列表，否则添加或编辑品牌信息
        $user_id = $_SESSION['user_id'];

        if (empty($user_id)) {
            ecjia_front::$controller->showmessage('请先登陆！',ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR, array('pjaxurl'=>RC_Uri::url('user/index/login')));
        }

        ecjia_front::$controller->assign('step',    $step); // 记录流程


        $db_merchants_category_temporarydate->where(array('is_add'=>0, 'user_id'=>$user_id))->delete();


        /* 取得国家列表、商店所在国家、商店所在国家的省列表 */
        $country_list 	= get_regions();
        ecjia_front::$controller->assign('country_list',    $country_list);

        $process_list = get_root_steps_process_list($step);
        $process = $process_list[$pid_key];
        ecjia_front::$controller->assign('process',         $process);  // 步骤信息
        ecjia_front::$controller->assign('pid_key',         $pid_key + 1);  // key值
        ecjia_front::$controller->assign('tid',             $tid);  // 子项key值
        ecjia_front::$controller->assign_title(             $process['process_title']);
        ecjia_front::$controller->assign('title',           $process['process_title']);


        //品牌操作 start
        ecjia_front::$controller->assign('b_pidKey',        $pid_key);  // 品牌操作
        ecjia_front::$controller->assign('ec_shop_bid',     $ec_shop_bid);  // 品牌操作类型 大于0则更新，否则为添加
        ecjia_front::$controller->assign('brandView',       $brandView);
        //品牌操作 end

        if($process['id'] > 0){

            if ($step == 1) {
                $online_agreement = get_root_directory_steps($step);
                ecjia_front::$controller->assign('online_agreement',$online_agreement);
                ecjia_front::$controller->assign('noagreement',1);
            }

            $category_info = get_fine_category_info(0,          $user_id); // 详细类目
            ecjia_front::$controller->assign('category_info',   $category_info);

            $permanent_list = get_category_permanent_list($_SESSION['user_id']);// 一级类目证件
            ecjia_front::$controller->assign('permanent_list',  $permanent_list);
            $steps_title = get_root_merchants_steps_title($process['id'], $user_id, $tid);

            if (!empty($steps_title[0]['fields_titles'])) {
                ecjia_front::$controller->assign('title',           $steps_title[0]['fields_titles']);
                ecjia_front::$controller->assign_title(             $steps_title[0]['fields_titles']);
            }

            ecjia_front::$controller->assign('steps_title',     $steps_title);  // 流程表单信息
        }

        if ($step == 4) {
            $shop_info = $db_merchants_shop_information->field('shoprz_brandName, steps_audit, rz_shopName, shopNameSuffix, shop_class_keyWords, hopeLoginName, merchants_audit, merchants_message')->where(array('user_id'=>$user_id))->find();
            $shop_info['rz_shopName'] = str_replace('|','',$shop_info['rz_shopName']);
            ecjia_front::$controller->assign('shop_info',    $shop_info);

            if ($shop_info['merchants_audit'] == 2) {
                ecjia_front::$controller->assign('tid',             1);  // 子项key值
            }

            $password_clear = $db_admin_user->where(array('ru_id'=>$user_id))->get_field('password_clear');
            ecjia_front::$controller->assign('password_clear',    $password_clear);

            ecjia_front::$controller->assign('title','商家入驻');
        }

		ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->assign('header_left', array('href' => RC_Uri::url('user/user_merchant/step_list')));
		ecjia_front::$controller->display('merchants_user_shopinfo.dwt');
	}

	/**
	 * 编辑入驻商数据更新
	 */
	public static function update() {
        RC_Loader::load_theme('extras/b2b2c/functions/merchant/b2b2c_front_merchant_steps.func.php');

        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_shop_information_model.class.php');
        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_steps_fields_model.class.php');
        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_steps_process_model.class.php');
        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_steps_title_model.class.php');
        $db_merchants_shop_information  = new merchant_shop_information_model();
        $db_merchants_steps_fields      = new merchant_steps_fields_model();
        $db_merchants_steps_process     = new merchant_steps_process_model();
        $db_merchants_steps_title       = new merchant_steps_title_model();

        $step = isset($_GET['step'])  ? intval($_GET['step']) : 1;//流程步骤
        $pid_key = isset($_GET['pid_key'])  ? intval($_GET['pid_key']) : 0; //当前步骤数组key
        $tid = isset($_GET['tid'])  ? intval($_GET['tid']) : 0; //当前步骤子项key
        $user_id = $_SESSION['user_id'];

        if (empty($user_id)) {
            ecjia_front::$controller->showmessage('请先登陆！',ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR, array('pjaxurl'=>RC_Uri::url('user/index/login')));
        }

        // 检查是否已入驻
        if ($db_merchants_shop_information->where(array('user_id' => $user_id))->get_field('steps_audit') && $step != 4) {
            ecjia_front::$controller->showmessage('已提交审核，不可修改。如需修改请联系管理员！', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl'=>RC_Uri::url('user/user_merchant/step_list')));
        }

        // 检查是否可编辑此模块
        $site_process = $db_merchants_steps_fields->where(array('user_id'=>$user_id))->get_field('site_process');
        $strArr = explode('|',$site_process);

        $process_list = get_root_steps_process_list($step);
        $process = $process_list[$pid_key];
        $noWkey = $pid_key - 1;
        $noWprocess = $process_list[$noWkey];

        // 子项目数组
        $res_step = $db_merchants_steps_title->field('tid, fields_steps, fields_titles')->select();
        foreach($res_step as $row){
            $steps_title_list[$row['fields_steps']][] = $row;
        }

        $res = $db_merchants_steps_process->order(array('process_steps' => 'asc', 'steps_sort' => 'asc'))->select();
        //TODO: 完善判定逻辑，并增加状态数组的存储
        foreach($res as $value) {
            if (!empty($steps_title_list[$value['id']])) {
                foreach ($steps_title_list[$value['id']] as $v) {
                    // 到当前的时候退出检测
                    if ('id'.$value['id'].'_'.$v['tid'] == 'id'.$noWprocess['id'].'_'.$tid) break(2);

                    if (!in_array('id'.$value['id'].'_'.$v['tid'], $strArr)) {
                        ecjia_front::$controller->showmessage('请先填写【'.$v['fields_titles'].'】的内容', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl'=>RC_Uri::url('user/user_merchant/step_list')));
                    }
                }
            } else {
                // 到当前的时候退出检测
                if ('id'.$value['id'].'_0' == 'id'.$noWprocess['id'].'_'.$tid) break;

                if (!in_array('id'.$value['id'].'_0', $strArr)) {
                    ecjia_front::$controller->showmessage('请先填写【'.$value['fields_titles'].'】的内容', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl'=>RC_Uri::url('user/user_merchant/step_list')));
                }
            }
        }

        // 流程信息处理
        $form = get_steps_title_insert_form($noWprocess['id']);
        $parent = get_setps_form_insert_date($form['formName']);
        if (!empty($parent)) {
            $db_merchants_steps_fields->where(array('user_id'=>$user_id))->update($parent);
        }

        if($step == 1) {
            $count = $db_merchants_steps_fields->where(array('user_id'=>$user_id))->count();
            if (empty($count)) {
                $db_merchants_steps_fields->insert(array('user_id' => $user_id));
            }

            if(!is_array($process)){
                $step = 2;
                $pid_key = 0;

                $db_merchants_steps_fields->where(array('user_id' => $user_id))->update(array('agreement' => 1));
            }
        } elseif($step == 2){
            if(!is_array($process)){
                $step = 3;
                $pid_key = 0;
            }
        }elseif($step == 3){
            if(!is_array($process)){
                $ec_hopeLoginName = isset($_REQUEST['ec_hopeLoginName']) ? trim($_REQUEST['ec_hopeLoginName']) : '';
                RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_admin_user_model.class.php');
                $db_admin_user = new merchant_admin_user_model();
                $admin_id = $db_admin_user->where(array('user_name'=>$ec_hopeLoginName))->get_field('user_id');
                if($admin_id > 0){
                    ecjia_front::$controller->showmessage('店铺登陆用户名已存在，请您重新填写！',ecjia::MSGTYPE_ALERT | ecjia::MSGSTAT_ERROR, array('pjaxurl'=>RC_Uri::url('user/user_merchant/init', "step=$step&pid_key=$noWkey")));
                }else{
                    $step = 4;
                    $pid_key = 0;
                }
            }
        } elseif ($step == 4) {
            if ($tid == 1) {
                $noWprocess['id'] = 999;
                $site_process = str_replace('|id999_0', '', $site_process);
                $db_merchants_steps_fields->where(array('user_id'=>$user_id))->update(array('site_process'=>$site_process));
                $db_merchants_shop_information->where(array('user_id'=>$user_id))->update(array('steps_audit'=>0, 'merchants_audit'=>0));
            } else {
                $noWprocess['id'] = 999;
                $db_merchants_shop_information->where(array('user_id'=>$user_id))->update(array('steps_audit'=>1));
            }
        }

        $steps_site = "merchants_steps.php?step=" .$step. "&pid_key=" .$pid_key. "&tid=" .$tid;
        $url_get = RC_Uri::url('user/user_merchant/step_list');
        if (!in_array('id'.$noWprocess['id'].'_'.$tid, $strArr)) {
            $site_process .= '|'.'id'.$noWprocess['id'].'_'.$tid;
            $db_merchants_steps_fields->where(array('user_id'=>$user_id))->update(array('steps_site'=>$steps_site,'site_process'=>$site_process));
        }

        ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl'=>$url_get));
	}





    /**
     * 获取分类名称
     */
    public function get_cat_name () {
        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_category_model.class.php');
        $db_category = new merchant_category_model();

        $parent_id = $_GET['parent_id'];
        if ($parent_id != 0) {
            $cat_list = $db_category->field('cat_id, cat_name')->where(array('parent_id' => $parent_id))->select();
        }

        $opt = array();
        foreach ($cat_list AS $key => $val) {
            $opt[] = array(
                'value' => $val['cat_id'],
                'text'  => $val['cat_name']
            );
        }
        ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $opt));
    }

    /**
     * 添加类目
     */
	public function addChildCate_checked() {
        RC_Loader::load_theme('extras/b2b2c/functions/merchant/b2b2c_front_merchant_steps.func.php');
        $cat_id = rtrim($_GET['cat_id'], ',');
	    $category_info = get_fine_category_info($cat_id, $_SESSION['user_id']);
	    ecjia_front::$controller->assign('category_info',$category_info);

	    $merchants_cate_checked_list = ecjia_front::$controller->fetch("merchants_cate_checked_list.dwt");

	    $permanent_list = get_category_permanent_list($_SESSION['user_id']);
	    ecjia_front::$controller->assign('permanent_list',$permanent_list);

	    $merchants_permanent_list = ecjia_front::$controller->fetch("merchants_steps_catePermanent.dwt");

	    ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $merchants_cate_checked_list, 'catePermanent' => $merchants_permanent_list));
	}

    /**
     * 删除类目
     */
	public function deleteChildCate_checked() {
        RC_Loader::load_theme('extras/b2b2c/functions/merchant/b2b2c_front_merchant_steps.func.php');
	    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_category_temporarydate_model.class.php');
	    $db_merchants_category_temporarydate = new merchant_category_temporarydate_model();

        $ct_id = rtrim($_GET['ct_id'], ',');

        $db_merchants_category_temporarydate->where(array('ct_id'=>$ct_id, 'user_id' => $_SESSION['user_id']))->delete();

	    $category_info = get_fine_category_info(0, $_SESSION['user_id']);
	    ecjia_front::$controller->assign('category_info',$category_info);

	    $merchants_cate_checked_list = ecjia_front::$controller->fetch("merchants_cate_checked_list.dwt");

	    $permanent_list = get_category_permanent_list($_SESSION['user_id']);
	    ecjia_front::$controller->assign('permanent_list',$permanent_list);
	    $merchants_permanent_list = ecjia_front::$controller->fetch("merchants_steps_catePermanent.dwt");

	    ecjia_front::$controller->showmessage('', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('content' => $merchants_cate_checked_list, 'catePermanent' => $merchants_permanent_list));
	}


    /**
     * 删除品牌列表
     */
    public function deleteBrand()
    {
        $bid = $_GET['bid'];
        if (empty($bid)) ecjia_front::$controller->showmessage('删除失败', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);

        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_shop_brand_model.class.php');
        $db_merchants_shop_brand = new merchant_shop_brand_model();
        $db_merchants_shop_brand->where(array('bid'=>$bid, 'user_id'=>$_SESSION['user_id']))->delete();
        ecjia_front::$controller->showmessage('删除成功', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_SUCCESS, array('pjaxurl'=> $_SERVER['HTTP_REFERER']));
    }
	
}