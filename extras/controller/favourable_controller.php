<?php
/**
* 优惠活动模块控制器代码
*/
class favourable_controller {

    /**
     * 优惠活动 列表
     */
    public static function init() {
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) :  10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        $sort = 'last_update';
        $order = 'ASC';
        $list = get_activity_info($size, $page);
        ecjia_front::$controller->assign('order', $order);
        ecjia_front::$controller->assign('sort', $sort);
        ecjia_front::$controller->assign('favourable_activity', $list['list']);
        ecjia_front::$controller->assign_title('优惠活动');
        ecjia_front::$controller->assign('title','优惠活动');
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('activity.dwt');
    }

    /**
     * 优惠活动 - 活动商品列表
     */
    public static function goods_list() {
        // $db_favourable = RC_Loader::load_app_model('favourable_activity_model');
        RC_Loader::load_theme('extras/model/favourable/favourable_activity_model.class.php');
        $db_favourable  = new favourable_activity_model();
        $sort = $_GET['sort'];
        $order = $_GET['order'];
        if(empty($sort) || empty($order)){
            $sort = 'g.goods_id';
            $order = 'ASC';
        }
        $view = intval($_GET['view']);
        $id = intval($_REQUEST['id']);
        ecjia_front::$controller->assign('id', $id);
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) :  10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        ecjia_front::$controller->assign('sort', $sort);
        ecjia_front::$controller->assign('order', $order);
        if (!$id) {
            ecjia_front::$controller->redirect(RC_Uri::url('index'));
        }
        $res = $db_favourable->field()->where("act_id = '$id'")->order('sort_order ASC')->find();
        $list = array();
        if ($res['act_range'] != FAR_ALL && !empty($res['act_range_ext'])) {
            if ($res['act_range'] == FAR_CATEGORY) {
                $children = " cat_id " . db_create_in(get_children_cat($res['act_range_ext']));
            } elseif ($res['act_range'] == FAR_BRAND) {
                $brand = " g.brand_id " . db_create_in($res['act_range_ext']);
            } else {
                $goods = " g.goods_id " . db_create_in($res['act_range_ext']);
            }
        }
        $goods_list = category_get_goods($children, $brand, $goods, $size, $page, $sort, $order);
        ecjia_front::$controller->assign_title('优惠活动列表');
        ecjia_front::$controller->assign('title','优惠活动列表');
        ecjia_front::$controller->assign('view',$view);
        ecjia_front::$controller->assign('goods_list', $goods_list);
        ecjia_front::$controller->assign_lang();
        ecjia_front::$controller->display('activity_goods_list.dwt');
    }

    /**
    * 处理参数便于搜索商品信息
    */
    private static function parameter() {
        /*如果分类ID为0，则返回总分类页*/
        $size = intval($_GET['size']) > 0 ? intval($_GET['size']) :  10;
        $page = intval($_GET['page']) ? intval($_GET['page']) : 1;
        /* 排序、显示方式以及类型 */
        $default_display_type = ecjia::config('show_order_type') == '0' ? 'list' : (ecjia::config('show_order_type') == '1' ? 'grid' : 'album');
        $default_sort_order_method = ecjia::config('sort_order_method') == '0' ? 'DESC' : 'ASC';
        $default_sort_order_type = ecjia::config('sort_order_type') == '0' ? 'goods_id' : (ecjia::config('sort_order_type') == '1' ? 'shop_price' : 'last_update');
        ecjia_front::$controller->assign('show_asynclist', ecjia::config('show_asynclist'));
        $sort = (isset($_REQUEST['sort']) && in_array(trim(strtolower($_REQUEST['sort'])), array(
            'goods_id',
            'shop_price',
            'last_update',
            'sales_volume',
            'click_count'
        ))) ? trim($_REQUEST['sort']) : $default_sort_order_type; // 增加按人气、按销量排序
        $order = (isset($_REQUEST['order']) && in_array(trim(strtoupper($_REQUEST['order'])), array(
            'ASC',
            'DESC'
        ))) ? trim($_REQUEST['order']) : $default_sort_order_method;
        $display = (isset($_REQUEST['display']) && in_array(trim(strtolower($_REQUEST['display'])), array(
            'list',
            'grid',
            'album'
        ))) ? trim($_REQUEST['display']) : (isset($_COOKIE['ECS']['display']) ? $_COOKIE['ECS']['display'] : $default_display_type);
        ecjia_front::$controller->assign('display', $display);
        setcookie('ECS[display]', $display, RC_Time::gmtime() + 86400 * 7);
    }

}

// end
