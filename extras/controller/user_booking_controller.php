<?php
/**
 * 登记模块控制器代码
 */
class user_booking_controller {

    /**
     * 缺货登记列表
     */
    public static function booking_list() {
        $user_id = $_SESSION['user_id'];
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $booking_list = get_booking_list($user_id, $size, $page);
        ecjia_front::$controller->assign('title', RC_Lang::lang('label_booking'));
        ecjia_front::$controller->assign('booking_list', $booking_list['list']);
        ecjia_front::$controller->assign('page', $booking_list['page']);
        ecjia_front::$controller->assign_title(RC_Lang::lang('label_booking'));
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_booking_list.dwt');
    }

    /**
     * 异步加载缺货登记列表
     */
    public static function async_booking_list() {
        $user_id = $_SESSION['user_id'];
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) : 10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $booking_list = get_booking_list($user_id, $size, $page);
        ecjia_front::$controller->assign('booking_list',$booking_list['list']);
        ecjia_front::$controller->assign_lang();
        $sayList = ecjia_front::$controller->fetch('user_booking_list.dwt');
        ecjia_front::$controller->showmessage('success', ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('list' => $sayList,'page' , 'is_last' => $booking_list['is_last']));
    }

    /**
     * 删除缺货登记
     */
    public static function del_booking() {
        $user_id = $_SESSION['user_id'];
        $id = intval($_GET['id']);
        if ($id == 0 || $user_id == 0) {
            ecjia_front::$controller->showmessage('参数错误', ecjia::MSGTYPE_JSON | ecjia::MSGSTAT_ERROR, array('pjaxurl' => RC_Uri::url('booking_list')));
        }
        delete_booking($id, $user_id);
        ecjia_front::$controller->showmessage(RC_Lang::lang('delete_booking_success'),ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('booking_list') ,'is_show' => false));
    }

    /**
     * 添加缺货登记
     */
    public static function add_booking() {
        // $db_booking_viewmodel = RC_Loader::load_app_model('booking_viewmodel');
        RC_Loader::load_theme('extras/model/user/user_booking_viewmodel.class.php');
            $db_booking_viewmodel  = new user_booking_viewmodel();
        $goods_id = intval($_GET['id'], 0);
        if ($goods_id == 0) {
            ecjia_front::$controller->showmessage(RC_Lang::lang('no_goods_id'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
        /* 根据规格属性获取货品规格信息 */
        $goods_attr = '';
        if ($_GET['spec'] != '') {
            $goods_attr_id = $_GET['spec'];
            $row = $db_booking_viewmodel->join('attribute')->field('a.attr_name,g.attr_value')->in(array('g.goods_attr_id' => $goods_attr_id))->select();
            $attr_list = array();
            if (!empty($row)) {
                foreach ($row as $v) {
                    $attr_list[] = $v['attr_name'] . ': ' . $v['attr_value'];
                }
            }
            $goods_attr = join(chr(13) . chr(10), $attr_list);
        }
        ecjia_front::$controller->assign('goods_attr', $goods_attr);
        ecjia_front::$controller->assign('info', get_goodsinfo($goods_id));
        ecjia_front::$controller->assign_title('添加缺货登记');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('user_add_booking.dwt');
    }

    /**
     * 增加缺货登记
     */
    public static function insert_booking() {
        $user_id = $_SESSION['user_id'];
        /*查看此商品是否已经登记过*/
        $rec_id = get_booking_rec($user_id, intval($_POST['id']));
        if (!empty($rec_id)) {
            ecjia_front::$controller->showmessage(RC_Lang::lang('booking_rec_exist'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
        $booking = array(
            'goods_id'      => intval($_POST['id']),
            'goods_amount'  => intval($_POST['number']),
            'desc'          => htmlspecialchars($_POST['desc']),
            'linkman'       => htmlspecialchars($_POST['linkman']),
            'email'         => htmlspecialchars($_POST['email']),
            'tel'           => htmlspecialchars($_POST['tel']),
            'booking_id'    => intval($_POST['rec_id']),
        );
        if (adds_booking($booking)) {
            ecjia_front::$controller->showmessage(RC_Lang::lang('booking_success'), ecjia::MSGSTAT_SUCCESS | ecjia::MSGTYPE_JSON, array('pjaxurl' => RC_Uri::url('user/user_booking/booking_list'),'is_show' => false));
        } else {
            ecjia_front::$controller->showmessage(RC_Lang::lang('booking_list_lnk'), ecjia::MSGSTAT_ERROR | ecjia::MSGTYPE_JSON);
        }
    }

}

// end
