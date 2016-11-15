<?php
defined('IN_ECJIA') or exit('No permission resources.');

//获取会员申请入驻信息
function get_steps_user_shopInfo_list($user_id = 0, $ec_shop_bid = 0, $step) {
	RC_Loader::load_theme('extras/b2b2c/model/user/user_merchants_steps_process_model.class.php');
	$db = new user_merchants_steps_process_model();
    $step = empty($step) ? 1 : $step;
	$res = $db->where(array('process_steps' => array('neq' => 1)))->order(array('process_steps' => 'asc'))->limit($step-1,1)->select();
	
	$arr = array();
	foreach ($res as $key=>$row) {
		$arr[$key]['sp_id'] = $row['id'];
		$arr[$key]['process_title'] = $row['process_title'];
		$arr[$key]['steps_title'] = get_user_steps_title($row['id'],$user_id, $ec_shop_bid);
	}
	return array('current' => $arr, 'next' =>$res[0]['fields_next']);
}

//查询临时数据表中的数据
function get_fine_category_info($cat_id, $user_id){

	if($cat_id != 0){
		get_add_childCategory_info($cat_id, $user_id);
	}
	RC_Loader::load_theme('extras/b2b2c/model/user/user_merchants_category_temporarydate_model.class.php');
	$mct_db = new user_merchants_category_temporarydate_model();
	$res = $mct_db->field('ct_id, cat_id, cat_name, parent_name')->where(array('user_id' => $user_id))->select();
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

//返回插入基本信息字段数据
function get_setps_form_insert_date($formName,$user_id){
	$upload = RC_Upload::uploader('image', array('save_path' => 'data/septs_Image', 'auto_sub_dirs' => true));
	RC_Loader::load_theme('extras/b2b2c/model/user/user_merchants_steps_fields_model.class.php');
	$msf_db = new user_merchants_steps_fields_model();
	$formName = explode(',', $formName);
	
	$arr = array();
	for ($i=0; $i<count($formName); $i++) {
		if (substr($formName[$i],-3) == 'Img') {  //如果上传文件字段是图片或者压缩包 字段命名必须是 ******Img 格式 (自定义的上传文件)
			if ((isset($_FILES[$formName[$i]]['error']) && $_FILES[$formName[$i]]['error'] == 0) ||(!isset($_FILES[$formName[$i]]['error']) && isset($_FILES[$formName[$i]]['tmp_name'] ) &&$_FILES[$formName[$i]]['tmp_name'] != 'none')) {
				$arr[$formName[$i]] = $msf_db->where(array('user_id'=>$user_id))->get_field($formName[$i]);//原来图片的地址
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
				}
			} else {
				//没有修改上传文件  则为原来的路径
				$arr[$formName[$i]] = $msf_db->where(array('user_id'=>$user_id))->get_field($formName[$i]);
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

// 查询类目证件标题列表
function get_category_permanent_list($user_id){
	RC_Loader::load_theme('extras/b2b2c/model/user/user_merchants_documenttitle_model.class.php');
	RC_Loader::load_theme('extras/b2b2c/model/user/user_merchants_dt_file_model.class.php');
	RC_Loader::load_theme('extras/b2b2c/model/user/user_category_model.class.php');
	$c_db = new user_category_model();
	$md_db = new user_merchants_documenttitle_model();
	$mdf_db = new user_merchants_dt_file_model();
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
	$res = $md_db->field('dt_id, dt_title, cat_id')->in(array('cat_id' => $arr['parentId']))->order('dt_id asc')->select();
	$parentId = $arr['parentId'];
	$arr = array();
	foreach($res as $key=>$row){
		$arr[$key]['dt_id'] = $row['dt_id'];
		$arr[$key]['dt_title'] = $row['dt_title'];
		$arr[$key]['cat_id'] = $row['cat_id'];
		$arr[$key]['cat_name'] = $c_db->where(array('cat_id' => $row['cat_id']))->get_field('cat_name');
		
		$row = $mdf_db->field('permanent_file, permanent_date, cate_title_permanent,dtf_id')->find(array('cat_id'	=> $row['cat_id'],'dt_id'=> $row['dt_id'],'user_id' 	=> $user_id));
		
		if (!empty($row['permanent_file'])){
			$arr[$key]['permanent_file'] = RC_Upload::upload_url($row['permanent_file']);
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

	function get_user_steps_title($id = 0, $user_id, $ec_shop_bid) {
		RC_Loader::load_theme('extras/b2b2c/model/user/user_merchants_steps_title_viewmodel.class.php');
		$mstdbview = new user_merchants_steps_title_viewmodel();
	    $res = $mstdbview->where(array('fields_steps' => $id))->select();
		$arr = array();
		foreach ($res as $key => $row) {
			$arr[$key]['tid'] = $row['tid'];
			$arr[$key]['fields_titles'] = $row['fields_titles'];
			$arr[$key]['steps_style'] = $row['steps_style'];
			$arr[$key]['titles_annotation'] = $row['titles_annotation'];

			$cententFields = get_fields_centent_info($row['id'],$row['textFields'],$row['fieldsDateType'],$row['fieldsLength'],$row['fieldsNotnull'],$row['fieldsFormName'],$row['fieldsCoding'],$row['fieldsForm'],$row['fields_sort'],$row['will_choose'], 'root', $user_id);

			$arr[$key]['cententFields'] = get_array_sort($cententFields, 'fields_sort');

			foreach ($arr[$key]['cententFields'] as $k=>$v) {
				if ($v['otherForm'] == 'dateFile') {
					$field = $arr[$key]['cententFields'][$k]['textFields'];
					$data_file_url = RC_Upload::upload_url($v['title_contents'][$field]);
					if ($data_file_url == RC_Upload::upload_url()) {
						$data_file_url = '';
					}
					$arr[$key]['cententFields'][$k]['title_contents'][$field]= $data_file_url;
				}
			}
			$shop_info = get_merchants_septs_custom_userInfo('merchants_shop_information', $user_id); //店铺类型、 可经营类目---信息表

			$brand_info = get_merchants_septs_custom_userInfo('merchants_shop_brand', $user_id, 'pingpai', $ec_shop_bid); //品牌表
			if ($row['steps_style'] == 1) {
				$parent = array(  //店铺类型数据
					'shoprz_type' 			=> $shop_info['shoprz_type'],
					'subShoprz_type' 		=> $shop_info['subShoprz_type'],
					'shop_expireDateStart'	=> RC_Time::local_date("Y-m-d H:i", $shop_info['shop_expireDateStart']),
					'shop_expireDateEnd'	=> RC_Time::local_date("Y-m-d H:i", $shop_info['shop_expireDateEnd']),
					'shop_permanent'		=> $shop_info['shop_permanent'],
					'authorizeFile'			=> RC_Upload::upload_url($shop_info['authorizeFile']),
					'shop_hypermarketFile'	=> RC_Upload::upload_url($shop_info['shop_hypermarketFile']),
					'shop_categoryMain'		=> $shop_info['shop_categoryMain']
				);
				if ($parent['authorizeFile'] == RC_Upload::upload_url()) {
					$parent['authorizeFile'] = '';
				}
				if ($parent['shop_hypermarketFile'] == RC_Upload::upload_url()) {
					$parent['shop_hypermarketFile'] = '';
				}

			} elseif ($row['steps_style'] == 2) { //一级类目列表

				$arr[$key]['first_cate'] = get_first_cate_list('','','',$user_id);

				$parent = array(
					'shop_categoryMain' => $shop_info['shop_categoryMain']
				);
			} elseif ($row['steps_style'] == 3) { //品牌列表

				$arr[$key]['brand_list'] = get_septs_shop_brand_list($user_id); //品牌列表

				$brandfile_list = get_shop_brandfile_list($ec_shop_bid);
				$arr[$key]['brandfile_list'] = $brandfile_list;

				if (!empty($brand_info['brandEndTime'])) {
					$brand_info['brandEndTime'] = RC_Time::local_date("Y-m-d H:i", $brand_info['brandEndTime']);
				} else {
					$brand_info['brandEndTime'] = '';
				}
				$parent = array(
					'bank_name_letter' 			=> $brand_info['bank_name_letter'],
					'brandName' 				=> $brand_info['brandName'],
					'brandFirstChar' 			=> $brand_info['brandFirstChar'],
					'brandLogo' 				=> $brand_info['brandLogo'],
					'brandType' 				=> $brand_info['brandType'],
					'brand_operateType' 		=> $brand_info['brand_operateType'],
					'brandEndTime' 				=> $brand_info['brandEndTime'],
					'brandEndTime_permanent' 	=> $brand_info['brandEndTime_permanent']
				);
			} elseif ($row['steps_style'] == 4) {
				RC_Loader::load_theme('extras/b2b2c/model/user/user_merchants_shop_brand_model.class.php');
				$msbdb = new user_merchants_shop_brand_model();
				$brand_list = $msbdb->field('bid, brandName')->where(array('user_id' => $user_id))->select();

				$arr[$key]['brand_list'] = $brand_list;

				$parent = array(
					'shoprz_brandName' 		=> $shop_info['shoprz_brandName'],
					'shop_class_keyWords' 	=> $shop_info['shop_class_keyWords'],
					'shopNameSuffix' 		=> $shop_info['shopNameSuffix'],
					'rz_shopName' 			=> $shop_info['rz_shopName'],
					'hopeLoginName' 		=> $shop_info['hopeLoginName']
				);

				$parent['shoprz_type'] = $shop_info['shoprz_type'];
			}

			$arr[$key]['parentType'] = $parent; //自定义显示
		}
		return $arr;
	}

	function get_merchants_septs_custom_userInfo($table = '', $user_id = 0, $type = '', $id = '') {
		$where = array();
		if ($type == 'pingpai') {
			$where['bid'] = $id;
		}
		$table_model = 'user_'.$table.'_model';
		RC_Loader::load_theme('extras/b2b2c/model/user/'.$table.'.class.php');
		$db = new $table_model();

	
		$where['user_id'] = $user_id;
		return $db->find($where);
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
				RC_Loader::load_theme('extras/b2b2c/model/user/user_merchants_steps_fields_model.class.php');
				$msfdb = new user_merchants_steps_fields_model();
				$arr[$i+1]['title_contents'] = $msfdb->field($textFields[$i])->where(array('user_id'=>$user_id))->find();
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
						$arr[$i+1]['textAreaForm'] = get_textAreaForm_arr(explode(',', $arr[$i+1]['title_contents'][$textFields[$i]]));
						$arr[$i+1]['province_list'] = get_regions(1,$arr[$i+1]['textAreaForm']['country']);
						$arr[$i+1]['city_list'] = get_regions(2,$arr[$i+1]['textAreaForm']['province']);
						$arr[$i+1]['district_list'] = get_regions(3,$arr[$i+1]['textAreaForm']['city']);
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
		RC_Loader::load_theme('extras/b2b2c/model/user/user_merchants_category_temporarydate_model.class.php');
		$mctdb = new user_merchants_category_temporarydate_model();
		for ($i=0; $i<count($catarr); $i++) {
			if (!empty($catarr[$i])) {
				$mctdb->where(array('cat_id'=>$catarr[$i],'user_id'=>$user_id))->delete();
			}
		}
		return array();
	} else {
		RC_Loader::load_theme('extras/b2b2c/model/user/user_category_model.class.php');
		$c_db = new user_category_model();
		$result = $c_db->field('cat_id, cat_name')->where(array('parent_id' => $parent_id))->select();
		return $result;
	}
}


//入驻品牌列表 start
function get_septs_shop_brand_list($user_id = 0){
	RC_Loader::load_theme('extras/b2b2c/model/user/user_merchants_shop_brand_model.class.php');
	$msb_db = new user_merchants_shop_brand_model();
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

function get_shop_brandfile_list($ec_shop_bid){
	RC_Loader::load_theme('extras/b2b2c/model/user/user_merchants_shop_brandfile_model.class.php');
	$msbm = new user_merchants_shop_brandfile_model();
	$res = $msbm->field('b_fid, bid, qualificationNameInput, qualificationImg, expiredDateInput, expiredDate_permanent')->where(array('bid' => $ec_shop_bid))->order('b_fid asc')->select();
	$arr = array();	
	foreach ($res as $key=>$row) {
		$arr[] = $row;
		$arr[$key]['expiredDateInput'] = RC_Time::local_date("Y-m-d H:i", $row['expiredDateInput']);
	}
	return $arr;
}

function get_permanent_parent_cat_id($user_id = 0, $type = 0){
	RC_Loader::load_theme('extras/b2b2c/model/user/user_merchants_category_temporarydate_viewmodel.class.php');
	$db = new user_merchants_category_temporarydate_viewmodel();
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
	RC_Loader::load_theme('extras/b2b2c/model/user/user_merchants_category_temporarydate_model.class.php');
	$mctdb = new user_merchants_category_temporarydate_model();
	if ($type == 0) {
		for ($i=0; $i<count($catId_array); $i++) {
			$parentChild = explode(':', $catId_array[$i]);
			$arr[$i] = explode(',',$parentChild[1]);
			
			for($j=0; $j<count($arr[$i]); $j++){
				$mctdb->where(array('cat_id'=>$arr[$i][$j]))->update(array('is_add'=>1));
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

//类目证件插入或更新数据函数
function get_merchants_dt_file_insert_update($cat_id, $dt_id, $permanentFile, $permanent_date, $cate_title_permanent){
	RC_Loader::load_theme('extras/b2b2c/model/user/user_merchants_dt_file_model.class.php');
	$mdtdb = new user_merchants_dt_file_model();
	$upload = RC_Upload::uploader('image', array('save_path' => 'data/septs_Image', 'auto_sub_dirs' => false));

	for ($i=0; $i<count($cat_id); $i++) {
		$row = $mdtdb->field('permanent_file,dtf_id')->where(array('cat_id'=>$cat_id[$i],'dt_id'=>$dt_id[$i],'user_id'=>$_SESSION['user_id']))->find();
		$permanent_file = $permanentFile[$i];
		if (isset($permanent_file)) {
			$image_info = $upload->upload($permanent_file);
			if (!empty($image_info)) {
				unlink(RC_Upload::upload_path().$row['permanent_file']);
			}
			$pFile = $image_info['savepath'].'/'.$image_info['savename'];
		} else {
			$pFile = '';
		}
		$pFile = empty($pFile) ? $row['permanent_file'] : $pFile;	
		
		if (!empty($cate_title_permanent[$i])) {
			$permanent_date[$i] = '';
			$catPermanent = 1;
		} elseif (!empty($permanent_date[$i])) {
			$permanent_date[$i] = RC_Time::local_strtotime(trim($permanent_date[$i]));
			$catPermanent = 0;
		} else {
			$permanent_date[$i] = '';
			$catPermanent = 0;
		}
		
		$parent = array(
			'cat_id' => intval($cat_id[$i]),
			'dt_id' => intval($dt_id[$i]),
			'user_id' => $_SESSION['user_id'],
			'permanent_file' => $pFile,
			'permanent_date' => $permanent_date[$i],
			'cate_title_permanent' => $catPermanent
		);
		
		if($row['dtf_id'] > 0){
			$mdtdb->where(array('cat_id'=>$cat_id[$i],'dt_id'=>$dt_id[$i],'user_id'=>$_SESSION['user_id']))->update($parent);
		}else{
			$mdtdb->insert($parent);
		}
	}
}

//品牌资质文件上传
function get_shop_brand_file($qInput, $qImg, $eDinput, $eDpermant, $b_fid, $ec_shop_bid){
	RC_Loader::load_theme('extras/b2b2c/model/user/user_merchants_shop_brandfile_model.class.php');
	$msb_db = new user_merchants_shop_brandfile_model();
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
		
		if (!empty($eDpermant[$i])) {
			$eDpermant[$i] = 1;
			$eDinput[$i] = '';
		} else {
			$eDpermant[$i] = 0;
			if (!empty($eDinput[$i])) {
				$eDinput[$i] = RC_Time::local_strtotime($eDinput[$i]);
			} else {
				$eDinput[$i] = '';
			}
		}
		
		if (!empty($qInput[$i])) {
			$parent = array(
				'bid' 						=> $ec_shop_bid,
				'qualificationNameInput' 	=> $qInput[$i],
				'qualificationImg' 			=> $qImg[$i],
				'expiredDateInput' 			=> $eDinput[$i],
				'expiredDate_permanent' 	=> $eDpermant[$i]
			);
			if (!empty($b_fid[$i])) {
				$qualificationImg =	$msb_db->where(array('bid'=>$ec_shop_bid,'b_fid'=>$b_fid[$i]))->get_field('qualificationImg');
				if (empty($parent['qualificationImg'])) {
					$parent['qualificationImg'] = $qualificationImg;
				}
				$msb_db->where(array('bid'=>$ec_shop_bid,'b_fid'=>$b_fid[$i]))->update($parent);
			} else {
				$msb_db->insert($parent);
			}		
		}
	}
}

//查询二级类目详细信息 start //ajax返回类目数组
function get_child_category($cat){

    $arr = array();
    for($i=0; $i<count($cat); $i++){
        if(!empty($cat[$i])){
            $arr[$i] = $cat[$i];
            $arr['cat_id'] .= $cat[$i] . ',';
        }
    }

    $arr['cat_id'] = substr($arr['cat_id'], 0, -1);

    return $arr;
}

function get_regions($type = 0, $parent = 0) {
	RC_Loader::load_theme('extras/b2b2c/model/user/user_region_model.class.php');
	$region_db = new user_region_model();
	$countries= $region_db->field('region_id,region_name')->where(array('region_type' =>$type,'parent_id' =>$parent))->select();
	return $countries;
}
// end