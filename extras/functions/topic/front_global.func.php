<?php
defined ( 'IN_ECJIA' ) or exit ( 'No permission resources.' );

/**
 * 获取专题列表
 *
 */
function get_topic_list($page, $page_size, $keywords) {
    RC_Loader::load_theme('extras/model/topic/topic_model.class.php');
    $db_topic_model = new topic_model();

    $where = array('template' => array('neq'=>''));

    if (!empty($keywords)) {
    	$where['title'] = array('like' => "%".$keywords."%");
    }

    $count = $db_topic_model->where($where)->count('*');
    $pages = new touch_page($count, $page_size, 6, '', $page);
    $filter['record_count'] = $count;

    /* 判断是否需要分页 will.chen*/
    $limit =  $pages->limit();
    $result = $db_topic_model->where($where)->limit($limit)->select();
    foreach ($result as $key => $val){
        $result[$key]['topic_img'] = RC_Upload::upload_url($val['topic_img']);
    }
    $is_last = $page >= $pages->total_pages ? 1 : 0;
    return array('list'=>$result, 'page'=>$pages->show(3), 'desc' => $pages->page_desc(), 'is_last' => $is_last);
}

/**
 * 获取专题信息
 */
function get_topic_info($topic_id=0) {
    RC_Loader::load_theme('extras/model/topic/topic_model.class.php');
    $db_topic_model = new topic_model();

    $result = $db_topic_model->where(array('topic_id'=>$topic_id))->find();
    return $result;
}
// end
