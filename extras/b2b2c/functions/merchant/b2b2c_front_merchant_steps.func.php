<?php 
defined('IN_ECJIA') or exit('No permission resources.');

//协议信息
function get_root_directory_steps($sid){
    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_steps_process_model.class.php');
    $db_merchants_steps_process = new merchant_steps_process_model();
    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_article_model.class.php');
    $db_article = new merchant_article_model();

    $row = $db_merchants_steps_process->field('process_title, process_article')->where(array('process_steps' => $sid))->find();

    if($row['process_article'] > 0){
        $row['article_content'] = $db_article->where(array('article_id'=>$row['process_article']))->get_field('content');
    }

    return $row;
}

///**
// * 获得指定国家的所有省份
// *
// * @access      public
// * @param       int     country    国家的编号
// * @return      array
// */
//function get_regions_steps($type = 0, $parent = 0)
//{
//    $db_region = RC_Loader::load_app_model('region_model');
//    return $db_region->field('region_id, region_name')->where(array('region_type'=>$type, 'parent_id'=>$parent))->select();
//}

//申请步骤列表
function get_root_steps_process_list($sid){
    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_steps_process_model.class.php');
    $db_merchants_steps_process = new merchant_steps_process_model();
    $res = $db_merchants_steps_process->field('id, process_title, fields_next')->where(array('process_steps'=>$sid))->order(array('process_steps' => 'asc'))->select();

    $arr = array();
    foreach($res as $key=>$row){
        $arr[$key]['id'] = $row['id'];
        $arr[$key]['process_title'] = $row['process_title'];
        $arr[$key]['fields_next'] = $row['fields_next'];
    }

    return $arr;
}


//查询临时数据表中的数据
function get_fine_category_info($cat_id, $user_id){

    if($cat_id != 0){
        get_add_childCategory_info($cat_id, $user_id);
    }
    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_category_temporarydate_model.class.php');
    $db_merchants_category_temporarydate = new merchant_category_temporarydate_model();
    $res = $db_merchants_category_temporarydate->field('ct_id, cat_id, cat_name, parent_name')->where(array('user_id' => $user_id))->select();
    $arr = array();
    foreach($res as $key=>$row){
        $key = $key + 1;
        $arr[$key]['ct_id'] = $row['ct_id'];
        $arr[$key]['cat_id'] = $row['cat_id'];
        $arr[$key]['cat_name'] = $row['cat_name'];
        $arr[$key]['parent_name'] = $row['parent_name'];
    }
    return $arr;
}








//流程信息列表
function get_root_merchants_steps_title($pid, $user_id, $tid)
{
    $upload = RC_Upload::uploader('image', array('save_path' => 'data/septs_Image', 'auto_sub_dirs' => true));

    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_steps_title_model.class.php');
    $db_merchants_steps_title = new merchant_steps_title_model();
    $res = $db_merchants_steps_title->field('tid, fields_titles, titles_annotation, steps_style, fields_special, special_type')->where(array('fields_steps' => $pid))->select();

    $arr = array();

    //拆分方法处理
    $key = 0;
    $row = array();

    foreach ($res as $k => $v) {
        if (empty($tid) || $tid == $v['tid']) {
//            $key = $k;
            $row = $v;
            break;
        }
    }


//    if (!empty($res)) {
//        foreach ($res as $key => $row) {

            $arr[$key]['tid'] = $row['tid'];
            $arr[$key]['fields_titles'] = $row['fields_titles'];
            $arr[$key]['titles_annotation'] = $row['titles_annotation'];
            $arr[$key]['steps_style'] = $row['steps_style'];
            $arr[$key]['fields_special'] = $row['fields_special'];
            $arr[$key]['special_type'] = $row['special_type'];

            RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_steps_fields_centent_model.class.php');
            $db_merchants_steps_fields_centent = new merchant_steps_fields_centent_model();
            $centent = $db_merchants_steps_fields_centent->field('*')->where(array('tid'=>$row['tid']))->find();
            $cententFields = get_fields_centent_info($centent['id'], $centent['textFields'], $centent['fieldsDateType'], $centent['fieldsLength'], $centent['fieldsNotnull'], $centent['fieldsFormName'], $centent['fieldsCoding'], $centent['fieldsForm'], $centent['fields_sort'], $centent['will_choose'], 'root', $user_id);
//            _dump($cententFields,1);
            $arr[$key]['cententFields'] = get_array_sort($cententFields, 'fields_sort');

            //自定义表单数据插入 start
            $ec_shop_bid = isset($_REQUEST['ec_shop_bid']) ? trim($_REQUEST['ec_shop_bid']) : '';
            $ec_shoprz_type = isset($_POST['ec_shoprz_type']) ? intval($_POST['ec_shoprz_type']) : 0;
            $ec_subShoprz_type = isset($_POST['ec_subShoprz_type']) ? intval($_POST['ec_subShoprz_type']) : 0;
            $ec_shop_expireDateStart = isset($_POST['ec_shop_expireDateStart']) ? trim($_POST['ec_shop_expireDateStart']) : '';
            $ec_shop_expireDateEnd = isset($_POST['ec_shop_expireDateEnd']) ? trim($_POST['ec_shop_expireDateEnd']) : '';
            $ec_shop_permanent = isset($_POST['ec_shop_permanent']) ? intval($_POST['ec_shop_permanent']) : 0;
            $ec_shop_categoryMain = isset($_POST['ec_shop_categoryMain']) ? intval($_POST['ec_shop_categoryMain']) : 0;

            //品牌基本信息
            $bank_name_letter = isset($_POST['ec_bank_name_letter']) ? trim($_POST['ec_bank_name_letter']) : '';
            $brandName = isset($_POST['ec_brandName']) ? trim($_POST['ec_brandName']) : '';
            $brandFirstChar = isset($_POST['ec_brandFirstChar']) ? trim($_POST['ec_brandFirstChar']) : '';
            $brandLogo = isset($_FILES['ec_brandLogo']) ? $_FILES['ec_brandLogo'] : '';

            if (!empty($brandLogo)) {
                //TODO:上传图片
                $brandLogo = $upload->upload($brandLogo);  //图片存放地址 -- data/septs_Image
            }
            $brandType = isset($_POST['ec_brandType']) ? intval($_POST['ec_brandType']) : 0;
            $brand_operateType = isset($_POST['ec_brand_operateType']) ? intval($_POST['ec_brand_operateType']) : 0;
            $brandEndTime = isset($_POST['ec_brandEndTime']) ? intval($_POST['ec_brandEndTime']) : '';
            $brandEndTime_permanent = isset($_POST['ec_brandEndTime_permanent']) ? intval($_POST['ec_brandEndTime_permanent']) : 0;

            //品牌资质证件
            $qualificationNameInput = isset($_POST['ec_qualificationNameInput']) ? $_POST['ec_qualificationNameInput'] : array();
            $qualificationImg = isset($_FILES['ec_qualificationImg']) ? $_FILES['ec_qualificationImg'] : array();
            $expiredDateInput = isset($_POST['ec_expiredDateInput']) ? $_POST['ec_expiredDateInput'] : array();
            $b_fid = isset($_POST['b_fid']) ? $_POST['b_fid'] : array();

            //店铺命名信息
            $ec_shoprz_brandName = isset($_POST['ec_shoprz_brandName']) ? $_POST['ec_shoprz_brandName'] : '';
            $ec_shop_class_keyWords = isset($_POST['ec_shop_class_keyWords']) ? $_POST['ec_shop_class_keyWords'] : '';
            $ec_shopNameSuffix = isset($_POST['ec_shopNameSuffix']) ? $_POST['ec_shopNameSuffix'] : '';
            $ec_rz_shopName = isset($_POST['ec_rz_shopName']) ? $_POST['ec_rz_shopName'] : '';
            $ec_hopeLoginName = isset($_POST['ec_hopeLoginName']) ? $_POST['ec_hopeLoginName'] : '';

            $shop_info = get_merchants_septs_custom_info('merchants_shop_information'); //店铺类型、 可经营类目---信息表
            $brand_info = get_merchants_septs_custom_info('merchants_shop_brand', 'pingpai', $ec_shop_bid); //品牌表

            RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_shop_information_model.class.php');
            $db_merchants_shop_information = new merchant_shop_information_model();
            $shop_id = $db_merchants_shop_information->where(array('user_id'=>$_SESSION['user_id']))->get_field('shop_id');

            if ($row['steps_style'] == 1) {
                if (!empty($_FILES['ec_authorizeFile'])) {
                    //TODO:上传图片
//                    $ec_authorizeFile = $image->upload_image($_FILES['ec_authorizeFile'], 'septs_Image');  //图片存放地址 -- data/septs_Image
                    $ec_authorizeFile = $upload->upload($_FILES['ec_authorizeFile']);
                }
                $ec_authorizeFile = empty($ec_authorizeFile) ? $shop_info['authorizeFile'] : $ec_authorizeFile;

                if (!empty($_FILES['ec_authorizeFile'])) {
                    //TODO:上传图片
//                $ec_shop_hypermarketFile = $image->upload_image($_FILES['ec_shop_hypermarketFile'], 'septs_Image');  //图片存放地址 -- data/septs_Image
                    $ec_authorizeFile = $upload->upload($_FILES['ec_shop_hypermarketFile']);
                }
                $ec_shop_hypermarketFile = empty($ec_shop_hypermarketFile) ? $shop_info['shop_hypermarketFile'] : $ec_shop_hypermarketFile;

                if ($ec_shop_permanent != 1) {
                    $ec_shop_expireDateStart = empty($ec_shop_expireDateStart) ? RC_Time::local_date("Y-m-d H:i", $shop_info['shop_expireDateStart']) : $ec_shop_expireDateStart;
                    $ec_shop_expireDateEnd = empty($ec_shop_expireDateEnd) ? RC_Time::local_date("Y-m-d H:i", $shop_info['shop_expireDateEnd']) : $ec_shop_expireDateEnd;

                    if (!empty($ec_shop_expireDateStart) || !empty($ec_shop_expireDateEnd)) {
                        $ec_shop_expireDateStart = RC_Time::local_strtotime($ec_shop_expireDateStart);
                        $ec_shop_expireDateEnd = RC_Time::local_strtotime($ec_shop_expireDateEnd);
                    }
                } else {
                    $ec_shop_expireDateStart = '';
                    $ec_shop_expireDateEnd = '';
                }

                //判断数据是否存在，如果存在则引用 start
                if ($ec_shoprz_type == 0) {
                    $ec_shoprz_type = $shop_info['shoprz_type'];
                }
                if ($ec_subShoprz_type == 0) {
                    $ec_subShoprz_type = $shop_info['subShoprz_type'];
                }
                if ($ec_shop_categoryMain == 0) {
                    $ec_shop_categoryMain = $shop_info['shop_categoryMain'];
                }
                //判断数据是否存在，如果存在则引用 end

                $parent = array(  //店铺类型数据插入
                    'user_id' => $_SESSION['user_id'],
                    'shoprz_type' => $ec_shoprz_type,
                    'subShoprz_type' => $ec_subShoprz_type,
                    'shop_expireDateStart' => $ec_shop_expireDateStart,
                    'shop_expireDateEnd' => $ec_shop_expireDateEnd,
                    'shop_permanent' => $ec_shop_permanent,
                    'authorizeFile' => $ec_authorizeFile,
                    'shop_hypermarketFile' => $ec_shop_hypermarketFile,
                    'shop_categoryMain' => $ec_shop_categoryMain
                );

                if ($_SESSION['user_id'] > 0) {
                    if ($shop_id > 0) {

                        if ($parent['shop_expireDateStart'] == '' || $parent['shop_expireDateEnd'] == '') {
                            if ($ec_shop_permanent != 1) {
                                if ($shop_info['shop_permanent'] == 1) {
                                    $parent['shop_permanent'] = $shop_info['shop_permanent'];
                                }
                            }
                        }

                        if (empty($parent['authorizeFile'])) {
                            $parent['shop_permanent'] = 0;
                        } else {
                            if ($parent['shop_expireDateStart'] == '' || $parent['shop_expireDateEnd'] == '') {
                                $parent['shop_permanent'] = 1;
                                $parent['shop_expireDateStart'] = '';
                                $parent['shop_expireDateEnd'] = '';
                            }
                        }

                        $db_merchants_shop_information->where(array('user_id'=>$_SESSION['user_id']))->update($parent);
                    } else {
                        $db_merchants_shop_information->insert($parent);
                    }
                }

                if ($ec_shop_permanent == 0) {
                    if ($parent['shop_expireDateStart'] != '') {
                        $parent['shop_expireDateStart'] = RC_Time::local_date("Y-m-d H:i", $shop_info['shop_expireDateStart']);
                    }
                    if ($parent['shop_expireDateEnd'] != '') {
                        $parent['shop_expireDateEnd'] = RC_Time::local_date("Y-m-d H:i", $shop_info['shop_expireDateEnd']);
                    }
                }

            } elseif ($row['steps_style'] == 2) { //一级类目列表

                //2014-11-19 start
                if ($_SESSION['user_id'] > 0) {
                    if ($shop_id < 1) {
                        $parent['user_id'] = $_SESSION['user_id'];
                        $parent['shop_categoryMain'] = $ec_shop_categoryMain;
                        $db_merchants_shop_information->insert($parent);
                    }
                }
                //2014-11-19 end

                $arr[$key]['first_cate'] = get_first_cate_list(0, 0, array(), $_SESSION['user_id']);
                $catId_array = get_catId_array();

                $parent['user_shopMain_category'] = implode('-', $catId_array);

                //2014-11-19 start
                if ($ec_shop_categoryMain == 0) {
                    $ec_shop_categoryMain = $shop_info['shop_categoryMain'];
                    $parent['shop_categoryMain'] = $ec_shop_categoryMain;
                }
                $parent['shop_categoryMain'] = $ec_shop_categoryMain;
                //2014-11-19 end

                $db_merchants_shop_information->where(array('user_id'=>$_SESSION['user_id']))->update($parent);

                if (!empty($parent['user_shopMain_category'])) {
                    get_update_temporarydate_isAdd($catId_array);
                }
                get_update_temporarydate_isAdd($catId_array, 1);

            } elseif ($row['steps_style'] == 3) { //品牌列表

                $arr[$key]['brand_list'] = get_septs_shop_brand_list($_SESSION['user_id']); //品牌列表

                if ($ec_shop_bid > 0) { //更新品牌数据

                    $bank_name_letter = empty($bank_name_letter) ? $brand_info['bank_name_letter'] : $bank_name_letter;
                    $brandName = empty($brandName) ? $brand_info['brandName'] : $brandName;
                    $brandFirstChar = empty($brandFirstChar) ? $brand_info['brandFirstChar'] : $brandFirstChar;
                    $brandLogo = empty($brandLogo) ? $brand_info['brandLogo'] : $brandLogo;
                    $brandType = empty($brandType) ? $brand_info['brandType'] : $brandType;
                    $brand_operateType = empty($brand_operateType) ? $brand_info['brand_operateType'] : $brand_operateType;
                    $brandEndTime = empty($brandEndTime) ? $brand_info['brandEndTime'] : RC_Time::local_strtotime($brandEndTime);
                    $brandEndTime_permanent = empty($brandEndTime_permanent) ? $brand_info['brandEndTime_permanent'] : $brandEndTime_permanent;

                    $brandfile_list = get_shop_brandfile_list($ec_shop_bid);
                    $arr[$key]['brandfile_list'] = $brandfile_list;

                    $parent = array(
                        'user_id' => $_SESSION['user_id'],
                        'bank_name_letter' => $bank_name_letter,
                        'brandName' => $brandName,
                        'brandFirstChar' => $brandFirstChar,
                        'brandLogo' => $brandLogo,
                        'brandType' => $brandType,
                        'brand_operateType' => $brand_operateType,
                        'brandEndTime' => $brandEndTime,
                        'brandEndTime_permanent' => $brandEndTime_permanent
                    );

                    if (!empty($parent['brandEndTime'])) {
                        $arr[$key]['parentType']['brandEndTime'] = RC_Time::local_date("Y-m-d H:i", $parent['brandEndTime']); //输出
                    }

                    if ($_SESSION['user_id'] > 0) {

                        if ($parent['brandEndTime_permanent'] == 1) {
                            $parent['brandEndTime'] = '';
                        }

                        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_shop_brand_model.class.php');
                        $db_merchants_shop_brand = new merchant_shop_brand_model();
                        $bRes = $db_merchants_shop_brand->where(array('brandName'=>$brandName, 'user_id'=>$_SESSION['user_id'], 'bid'=>array('neq'=>$ec_shop_bid)))->get_field('bid');

                        if ($bRes > 0) {
                            ecjia_front::$controller->showmessage('品牌名称已存在！',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                        } else {
                            $db_merchants_shop_brand->where(array('user_id'=>$_SESSION['user_id'],'bid'=>$ec_shop_bid))->update($parent);

                            get_shop_brand_file($qualificationNameInput, $qualificationImg, $expiredDateInput, $b_fid, $ec_shop_bid); //品牌资质文件上传
                        }
                    }
                } else { //插入品牌数据
                    if ($_SESSION['user_id'] > 0) {

                        if (!empty($bank_name_letter)) {
                            RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_shop_brand_model.class.php');
                            $db_merchants_shop_brand = new merchant_shop_brand_model();
                            $bRes = $db_merchants_shop_brand->where(array('brandName'=>$brandName, 'user_id'=>$_SESSION['user_id']))->get_field('bid');

                            if ($bRes > 0) {
                                ecjia_front::$controller->showmessage('品牌名称已存在！',ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR);
                            } else {

                                $parent = array(
                                    'user_id' => $_SESSION['user_id'],
                                    'bank_name_letter' => $bank_name_letter,
                                    'brandName' => $brandName,
                                    'brandFirstChar' => $brandFirstChar,
                                    'brandLogo' => $brandLogo,
                                    'brandType' => $brandType,
                                    'brand_operateType' => $brand_operateType,
                                    'brandEndTime' => $brandEndTime,
                                    'brandEndTime_permanent' => $brandEndTime_permanent
                                );

                                $bid = $db_merchants_shop_brand->insert($parent);
                                get_shop_brand_file($qualificationNameInput, $qualificationImg, $expiredDateInput, $b_fid, $bid); //品牌资质文件上传
                            }
                        }
                    }
                }
            } elseif ($row['steps_style'] == 4) {

                RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_shop_brand_model.class.php');
                $db_merchants_shop_brand = new merchant_shop_brand_model();
                $brand_list = $db_merchants_shop_brand->field('bid, brandName')->where(array('user_id'=>$_SESSION['user_id']))->select();

                $arr[$key]['brand_list'] = $brand_list;

                $ec_shoprz_brandName = empty($ec_shoprz_brandName) ? $shop_info['shoprz_brandName'] : $ec_shoprz_brandName;
                $ec_shop_class_keyWords = empty($ec_shop_class_keyWords) ? $shop_info['shop_class_keyWords'] : $ec_shop_class_keyWords;
                $ec_shopNameSuffix = empty($ec_shopNameSuffix) ? $shop_info['shopNameSuffix'] : $ec_shopNameSuffix;
                $ec_rz_shopName = empty($ec_rz_shopName) ? $shop_info['rz_shopName'] : $ec_rz_shopName;
                $ec_hopeLoginName = empty($ec_hopeLoginName) ? $shop_info['hopeLoginName'] : $ec_hopeLoginName;

                if (!empty($ec_rz_shopName)) {
                    $parent = array(
                        'shoprz_brandName' => $ec_shoprz_brandName,
                        'shop_class_keyWords' => $ec_shop_class_keyWords,
                        'shopNameSuffix' => $ec_shopNameSuffix,
                        'rz_shopName' => $ec_rz_shopName,
                        'hopeLoginName' => $ec_hopeLoginName,
                    );

                    if ($_SESSION['user_id'] > 0) {
                        if ($shop_id > 0) {
                            $db_merchants_shop_information->where(array('user_id'=>$_SESSION['user_id']))->update($parent);
                        } else {
                            $db_merchants_shop_information->insert($parent);
                        }
                    }
                }

                $parent['shoprz_type'] = $shop_info['shoprz_type'];
            }
            $parent['brandEndTime'] = $arr[$key]['parentType']['brandEndTime']; //品牌使用时间
            $arr[$key]['parentType'] = $parent; //自定义显示
            //自定义表单数据插入 end
//        }
//    }
//_dump($arr,1);
    return $arr;
}

//返回插入基本信息字段数据
function get_setps_form_insert_date($formName){
    $upload = RC_Upload::uploader('image', array('save_path' => 'data/septs_Image', 'auto_sub_dirs' => true));
    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_steps_fields_model.class.php');
    $db_merchants_steps_fields = new merchant_steps_fields_model();
    $formName = explode(',', $formName);

    $arr = array();
    for ($i=0; $i<count($formName); $i++) {
        if (substr($formName[$i],-3) == 'Img') {  //如果上传文件字段是图片或者压缩包 字段命名必须是 ******Img 格式 (自定义的上传文件)
            if ((isset($_FILES[$formName[$i]]['error']) && $_FILES[$formName[$i]]['error'] == 0) ||(!isset($_FILES[$formName[$i]]['error']) && isset($_FILES[$formName[$i]]['tmp_name'] ) &&$_FILES[$formName[$i]]['tmp_name'] != 'none')) {
                $arr[$formName[$i]] = $db_merchants_steps_fields->where(array('user_id'=>$_SESSION['user_id']))->get_field($formName[$i]);//原来图片的地址
                $info	= $upload->upload($_FILES[$formName[$i]]);
                if (!empty($info)) {
                    $setps_thumb = $info['savepath'] . '/' . $info['savename'];
                    //删除原来的图片
                    unlink(RC_Upload::upload_path() . $arr[$formName[$i]]);
                    //文本隐藏域数据
                    $textImg = $_POST['text_' . $formName[$i]];
                    if (empty($setps_thumb)) {
                        if (!empty($textImg)) {
                            $setps_thumb = $textImg;
                        }
                    }
                    $arr[$formName[$i]] = $setps_thumb;
                    $update_arr[$formName[$i]] = $setps_thumb;
                }
            } else {
                //没有修改上传文件  则为原来的路径
                $arr[$formName[$i]] = $db_merchants_steps_fields->where(array('user_id'=>$_SESSION['user_id']))->get_field($formName[$i]);
            }
        } else {
            $arr[$formName[$i]] = $_POST[$formName[$i]];
        }
        if (is_array($arr[$formName[$i]])) {
            $arr[$formName[$i]] = implode(',', $arr[$formName[$i]]);
        }
    }
    return $arr;
}

//字段循环生成数组
function get_fields_centent_info($id, $textFields, $fieldsDateType, $fieldsLength, $fieldsNotnull, $fieldsFormName, $fieldsCoding, $fieldsForm, $fields_sort, $will_choose, $webType = 'admin', $user_id = 0){

    if (!empty($textFields)) {
        $textFields 		= explode(',', $textFields);
        $fieldsDateType 	= explode(',', $fieldsDateType);
        $fieldsLength 		= explode(',', $fieldsLength);
        $fieldsNotnull 		= explode(',', $fieldsNotnull);
        $fieldsFormName 	= explode(',', $fieldsFormName);
        $fieldsCoding 		= explode(',', $fieldsCoding);
        $choose 			= explode('|', $fieldsForm);
        $fields_sort 		= explode(',', $fields_sort);
        $will_choose 		= explode(',', $will_choose);

        $arr = array();
        for ($i=0; $i < count($textFields); $i++) {
            $arr[$i+1]['id'] 				= $id;
            $arr[$i+1]['textFields'] 		= $textFields[$i];
            $arr[$i+1]['fieldsDateType'] 	= $fieldsDateType[$i];
            $arr[$i+1]['fieldsLength'] 		= $fieldsLength[$i];
            $arr[$i+1]['fieldsNotnull'] 	= $fieldsNotnull[$i];
            $arr[$i+1]['fieldsFormName'] 	= $fieldsFormName[$i];
            $arr[$i+1]['fieldsCoding'] 		= $fieldsCoding[$i];
            $arr[$i+1]['fields_sort'] 		= $fields_sort[$i];
            $arr[$i+1]['will_choose'] 		= $will_choose[$i];

            if ($user_id > 0) {
                RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_steps_fields_model.class.php');
                $db_merchants_steps_fields = new merchant_steps_fields_model();
                $arr[$i+1]['title_contents'] = $db_merchants_steps_fields->where(array('user_id'=>$user_id))->get_field($textFields[$i]);
            }

            $chooseForm = explode(':', $choose[$i]);
            $arr[$i+1]['chooseForm'] = $chooseForm[0];
            $form_special = explode('+',$chooseForm[1]);
            $arr[$i+1]['formSpecial'] = $form_special[1];	//表单注释

            if ($chooseForm[0] == 'input') {
                $arr[$i+1]['inputForm'] = $form_special[0];
            } elseif ($chooseForm[0] == 'textarea') {
                $textareaForm = explode(',', $form_special[0]);
                $arr[$i+1]['rows'] = $textareaForm[0];
                $arr[$i+1]['cols'] = $textareaForm[1];
            } elseif ($chooseForm[0] == 'radio' || $chooseForm[0] == 'checkbox') {
                if (!empty($form_special[0])) {
                    $radioCheckbox_sort = get_radioCheckbox_sort(explode(',', $form_special[0]));

                    if ($webType == 'root') {
                        $radioCheckbox_sort = get_array_sort($radioCheckbox_sort, 'rc_sort');
                    }

                    $arr[$i+1]['radioCheckboxForm'] = $radioCheckbox_sort;
                } else {
                    $arr[$i+1]['radioCheckboxForm'] = '';
                }
            } elseif ($chooseForm[0] == 'select') {
                if (!empty($form_special[0])) {
                    $arr[$i+1]['selectList'] = explode(',', $form_special[0]);
                } else {
                    $arr[$i+1]['selectList'] = '';
                }
            } elseif($chooseForm[0] == 'other') {
                $otherForm = explode(',', $form_special[0]);
                $arr[$i+1]['otherForm'] = $otherForm[0];
                if ($otherForm[0] == 'dateTime') { //日期

                    if ($webType == 'root') {
                        $arr[$i+1]['dateTimeForm'] = get_dateTimeForm_arr(explode('--', $otherForm[1]), explode(',', $arr[$i+1]['title_contents'][$textFields[$i]]));
                    } else {
                        $arr[$i+1]['dateTimeForm'] = $otherForm[1];
                    }
                } elseif ($otherForm[0] == 'textArea') { //地区
                    if ($webType == 'root') {
                        $arr[$i+1]['textAreaForm'] = get_textAreaForm_arr(explode(',', $arr[$i+1]['title_contents']));
                        $arr[$i+1]['province_list'] = get_regions(1,$arr[$i+1]['textAreaForm']['country']);
                        $arr[$i+1]['city_list'] = get_regions(2,$arr[$i+1]['textAreaForm']['province']);
                        $arr[$i+1]['district_list'] = get_regions(3,$arr[$i+1]['textAreaForm']['city']);
                    }
                } elseif ($otherForm[0] == 'dateFile') { //地区
                    if ($webType == 'root') {
                        $arr[$i+1]['title_contents'] = $arr[$i+1]['title_contents'];
                    }
                }
            }
        }
        return $arr;
    }else{
        return array();
    }
}

//单选或多选表单数据
function get_radioCheckbox_sort($radioCheckbox_sort){
    $arr = array();
    for($i=0; $i<count($radioCheckbox_sort); $i++){
        $rc_sort = explode('*', $radioCheckbox_sort[$i]);
        $arr[$i]['radioCheckbox'] = $rc_sort[0];
        $arr[$i]['rc_sort'] = $rc_sort[1];
    }

    return $arr;
}

//数组排序--根据键的值的数值排序
function get_array_sort($arr,$keys,$type='asc'){
    $new_array = array();
    if(is_array($arr) && !empty($arr)){
        $keysvalue = $new_array = array();
        foreach ($arr as $k=>$v){
            $keysvalue[$k] = $v[$keys];
        }
        if($type == 'asc'){
            asort($keysvalue);
        }else{
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k=>$v){
            $new_array[$k] = $arr[$k];
        }
    }
    return $new_array;
}

//会员申请商家入驻表单填写数据插入 start
function get_steps_title_insert_form($pid = 0){

    $steps_title = get_root_merchants_steps_title($pid, $_SESSION['user_id']);
    $arr = array();
    for($i=0; $i<count($steps_title); $i++){

        if(is_array($steps_title[$i]['cententFields'])){
            $cententFields = $steps_title[$i]['cententFields'];
            for($j=1; $j<=count($cententFields); $j++){
                $arr['formName'] .= $cententFields[$j]['textFields'] . ',';
            }
        }
    }

    $arr['formName'] = substr($arr['formName'], 0, -1);

    return $arr;
}

//地区表单数据
function get_textAreaForm_arr($textArea){

    $arr['country'] = $textArea[0];
    $arr['province'] = $textArea[1];
    $arr['city'] = $textArea[2];
    $arr['district'] = $textArea[3];

    return $arr;
}


//日期表单数据
function get_dateTimeForm_arr($dateTime, $date_centent){
    $arr = array();
    for($i=0; $i<$dateTime[0]; $i++){
        $arr[$i]['dateSize'] = $dateTime[1];
        $arr[$i]['dateCentent'] = $date_centent[$i];
    }

    return $arr;
}

//一级类目列表
function get_first_cate_list($parent_id = 0, $type = 0, $catarr = array(),$user_id = 0){
    if ($type == 1) {
        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_category_temporarydate_model.class.php');
        $db_merchants_category_temporarydate = new merchant_category_temporarydate_model();
        for ($i=0; $i<count($catarr); $i++) {
            if (!empty($catarr[$i])) {
                $db_merchants_category_temporarydate->where(array('cat_id'=>$catarr[$i],'user_id'=>$user_id))->delete();
            }
        }
        return array();
    } else {
        RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_category_model.class.php');
        $c_db = new merchant_category_model();
        $result = $c_db->field('cat_id, cat_name')->where(array('parent_id' => $parent_id))->select();
        return $result;
    }
}

//入驻品牌列表 start
function get_septs_shop_brand_list($user_id = 0){
    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_shop_brand_model.class.php');
    $msb_db = new merchant_shop_brand_model();
    $res = $msb_db->field('bid, bank_name_letter, brandName, brandFirstChar, brandLogo, brandType, brand_operateType, brandEndTime')->where(array('user_id' => $user_id))->order('bid asc')->select();
    $arr = array();
    $no_picture = RC_Uri::admin_url('statics/images/nopic.png');
    foreach($res as $key=>$row){
        $key = $key + 1;
        $arr[$key]['bid'] 				= $row['bid'];
        $arr[$key]['bank_name_letter'] 	= $row['bank_name_letter'];
        $arr[$key]['brandName'] 		= $row['brandName'];
        $arr[$key]['brandFirstChar'] 	= $row['brandFirstChar'];
        $arr[$key]['brandLogo'] 		= empty($row['brandLogo']) ? $no_picture : RC_Upload::upload_url($row['brandLogo']);
        $arr[$key]['brandType']		 	= $row['brandType'];
        $arr[$key]['brand_operateType'] = $row['brand_operateType'];
        $arr[$key]['brandEndTime'] 		= RC_Time::local_date("Y-m-d H:i", $row['brandEndTime']);
    }
    return $arr;
}

function get_permanent_parent_cat_id($user_id = 0, $type = 0){
    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_category_temporarydate_viewmodel.class.php');
    $db = new merchant_category_temporarydate_viewmodel();
    $group_by = array();
    if($type == 1){
        $group_by = 'c.parent_id';
    }
    $row = $db->join(array('category'))->field('c.parent_id, mct.cat_id')->where(array('user_id' => $user_id))->group($group_by)->select();
    return $row;
}

//组合父ID的下级分类数组
function get_catId_array($user_id = 0){
    if($user_id <= 0){
        $user_id = $_SESSION['user_id'];
    }
    $res = get_permanent_parent_cat_id($user_id);

    $arr = array();
    foreach($res as $key=>$row){
        @$arr[$row['parent_id']] .= $row['cat_id'] . ',';
    }
    @$arr = get_explode_array($arr);
    return $arr;
}

function get_explode_array($arr){
    $newArr = array();
    $i = 0;
    foreach($arr as $key=>$row){
        $newArr[$i] = substr($key .":". $row, 0, -1);
        $i++;
    }

    return $newArr;
}

//更新临时表中的数据为插入
function get_update_temporarydate_isAdd($catId_array, $type = 0){
    $arr = array();
    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_category_temporarydate_model.class.php');
    $db_merchants_category_temporarydate = new merchant_category_temporarydate_model();
    if ($type == 0) {
        for ($i=0; $i<count($catId_array); $i++) {
            $parentChild = explode(':', $catId_array[$i]);
            $arr[$i] = explode(',',$parentChild[1]);

            for($j=0; $j<count($arr[$i]); $j++){
                $db_merchants_category_temporarydate->where(array('cat_id'=>$arr[$i][$j]))->update(array('is_add'=>1));
            }
        }
    } else {
        for ($i=0; $i<count($catId_array); $i++) {
            $parentChild = explode(':', $catId_array[$i]);
            $arr[$i] = explode(',',$parentChild[1]);
            $cat_id = isset($_POST['permanentCat_id_' . $parentChild[0]]) ? $_POST['permanentCat_id_' . $parentChild[0]] : array();
            $dt_id = isset($_POST['permanent_title_' . $parentChild[0]]) ? $_POST['permanent_title_' . $parentChild[0]] : array();

            $permanentFiles = $_FILES['permanentFile_'.$parentChild[0]];
            foreach ($permanentFiles as $k => $v) {
                foreach ($v as $key => $val) {
                    $permanentFile[$key][$k] = $val;
                }
            }
            $permanent_date = isset($_POST['categoryId_date_' . $parentChild[0]]) ? $_POST['categoryId_date_' . $parentChild[0]] : array();
            $cate_title_permanent = isset($_POST['categoryId_permanent_' . $parentChild[0]]) ? $_POST['categoryId_permanent_' . $parentChild[0]] : array();
            //操作一级类目证件插入或更新数据
            if(count($cat_id) > 0){
                get_merchants_dt_file_insert_update($cat_id, $dt_id, $permanentFile, $permanent_date, $cate_title_permanent);	//插入类目行业资质
            }
        }
    }
    return $arr;

}

//品牌资质文件上传
function get_shop_brand_file($qInput, $qImg, $eDinput, $b_fid, $ec_shop_bid){
//    include_once(ROOT_PATH . '/includes/cls_image.php');
//    $image = new cls_image($_CFG['bgcolor']);
    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_shop_brandfile_model.class.php');
    $db_merchants_shop_brandfile = new merchant_shop_brandfile_model();
    $upload = RC_Upload::uploader('image', array('save_path' => 'data/septs_Image', 'auto_sub_dirs' => false));

    //处理提交的资质电子版
    foreach ($qImg as $key => $val) {
        foreach ($val as $k => $v) {
            $row[$k][$key] = $v;
        }
    }
    for ($i=0; $i<count($qInput); $i++) {
        $qInput[$i] = trim($qInput[$i]);

        $qImg[$i] = $upload->upload($row[$i]);
        if (!empty($qImg[$i])) {
            $qImg[$i] = $qImg[$i]['savepath'].'/'.$qImg[$i]['savename'];
        }
        $eDinput[$i] = trim($eDinput[$i]);

        if(empty($qImg[$i])){ //证件是否永久有效
            $qPermanent = 0;
        }else{
            if(!empty($eDinput[$i])){
                $qPermanent = 0;
            }else{
                $qPermanent = 1;
            }
        }

        if (!empty($qInput[$i])) {
            $parent = array(
                'bid' 						=> $ec_shop_bid,
                'qualificationNameInput' 	=> $qInput[$i],
                'qualificationImg' 			=> $qImg[$i],
                'expiredDateInput' 			=> $eDinput[$i],
                'expiredDate_permanent' 	=> $qPermanent
            );
            if (!empty($b_fid[$i])) {
                $qualificationImg =	$db_merchants_shop_brandfile->where(array('bid'=>$ec_shop_bid,'b_fid'=>$b_fid[$i]))->get_field('qualificationImg');
                if (empty($parent['qualificationImg'])) {
                    $parent['qualificationImg'] = $qualificationImg;
                }
                $db_merchants_shop_brandfile->where(array('bid'=>$ec_shop_bid,'b_fid'=>$b_fid[$i]))->update($parent);
            } else {
                $db_merchants_shop_brandfile->insert($parent);
            }
        }
    }
}

function get_regions($type = 0, $parent = 0) {
    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_region_model.class.php');
    $region_db = new merchant_region_model();
    $countries= $region_db->field('region_id,region_name')->where(array('region_type' =>$type,'parent_id' =>$parent))->select();
    return $countries;
}

function get_merchants_septs_custom_info($table = '', $type = '', $id = ''){

    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_shop_brandfile_model.class.php');
    $db_merchants_shop_brandfile = new merchant_shop_brandfile_model();
    $where = array('user_id'=>$_SESSION['user_id']);
    if($type == 'pingpai'){
        $where['bid'] = $id;
    }

    return $db_merchants_shop_brandfile->table($table)->field('*')->where($where)->find();
}

//二级类目数据插入临时数据表
function get_add_childCategory_info($cat_id,$user_id){
    if(empty($cat_id)){
        $cat_id = 0;
    }
    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_category_model.class.php');
    $catdb = new merchant_category_model();
    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_category_temporarydate_model.class.php');
    $db_merchants_category_temporarydate = new merchant_category_temporarydate_model();

    $res = $catdb->field('cat_id,cat_name,parent_id')->in(array('cat_id'=>$cat_id))->order(array('cat_id'=>DESC))->select();

    $arr = array();
    foreach($res as $key=>$row){
        $key = $key + 1;
        $arr[$key]['cat_id'] = $row['cat_id'];
        $arr[$key]['cat_name'] = $row['cat_name'];
        $arr[$key]['parent_name'] = $catdb->field('cat_name')->where(array('cat_id'=>$row['parent_id']))->find();
        $parent = array(
            'user_id' 		=> $user_id,
            'cat_id' 		=> $row['cat_id'],
            'parent_id' 	=> $row['parent_id'],
            'cat_name' 		=> $row['cat_name'],
            'parent_name' 	=> $arr[$key]['parent_name']['cat_name']
        );
        if($cat_id != 0){
            $ct_id = $db_merchants_category_temporarydate->field('ct_id')->where(array('cat_id'=>$row['cat_id'],'user_id'=>$user_id))->find();

            if ($ct_id <= 0) {
                $db_merchants_category_temporarydate->insert($parent);
            }
        }
    }

    return $arr;
}


/**
 * 查询类目证件标题列表
 */
function get_category_permanent_list($user_id){
    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_documenttitle_model.class.php');
    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_dt_file_model.class.php');
    RC_Loader::load_theme('extras/b2b2c/model/merchant/merchant_category_model.class.php');
    $db_merchants_documenttitle = new merchant_documenttitle_model();
    $db_merchants_dt_file = new merchant_dt_file_model();
    $c_db = new merchant_category_model();
    $res = get_permanent_parent_cat_id($user_id, 1);
    $arr = array();
    $arr['parentId'] = '';
    foreach($res as $key=>$row){
        $arr[$key]['parent_id'] = $row['parent_id'];
        $arr['parentId'] .= $row['parent_id'] . ',';
    }

    $arr['parentId'] = substr($arr['parentId'], 0, -1);
    if(empty($arr['parentId'])){
        $arr['parentId'] = 0;
    }
    $new_parentId = substr($arr['parentId'], 0, 1);
    if($new_parentId == ','){
        $arr['parentId'] = substr($arr['parentId'], 1);
    }
    $res = $db_merchants_documenttitle->field('dt_id, dt_title, cat_id')->in(array('cat_id' => $arr['parentId']))->order('dt_id asc')->select();
    $parentId = $arr['parentId'];
    $arr = array();
    foreach($res as $key=>$row){
        $arr[$key]['dt_id'] = $row['dt_id'];
        $arr[$key]['dt_title'] = $row['dt_title'];
        $arr[$key]['cat_id'] = $row['cat_id'];
        $arr[$key]['cat_name'] = $c_db->where(array('cat_id' => $row['cat_id']))->get_field('cat_name');

        $row = $db_merchants_dt_file->field('permanent_file, permanent_date, cate_title_permanent,dtf_id')->find(array('cat_id'	=> $row['cat_id'],'dt_id'=> $row['dt_id'],'user_id' 	=> $user_id));

        if (!empty($row['permanent_file'])){
            $arr[$key]['permanent_file'] = $row['permanent_file'];
        } else {
            $arr[$key]['permanent_file'] = '';
        }
        $arr[$key]['dtf_id'] = $row['dtf_id'];
        $arr[$key]['cate_title_permanent'] = $row['cate_title_permanent'];
        if(!empty($row['permanent_date'])){
            $arr[$key]['permanent_date'] = RC_Time::local_date("Y-m-d H:i", $row['permanent_date']);
        }
    }
    return $arr;
}

//end