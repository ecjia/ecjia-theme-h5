<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-08
 * Time: 17:20
 */

class ecjia_theme_controller extends ecjia_front
{

    public function __construct()
    {
        parent::__construct();

        $this->load_default_script_style();
    }

    protected function load_default_script_style()
    {
    	//加载样式
    	RC_Style::enqueue_style('bootstrap', ecjia_extra::themeUrl('lib/bootstrap3/css/bootstrap.css'));
    	RC_Style::enqueue_style('iconfont', ecjia_extra::themeUrl('dist/css/iconfont.min.css'));
    	RC_Style::enqueue_style('touch', ecjia_extra::themeUrl('css/ecjia.touch.css'));
    	RC_Style::enqueue_style('touch-develop', ecjia_extra::themeUrl('css/ecjia.touch.develop.css'));
    	RC_Style::enqueue_style('touch-b2b2c', ecjia_extra::themeUrl('css/ecjia.touch.b2b2c.css'));
    	RC_Style::enqueue_style('ecjia_city', ecjia_extra::themeUrl('css/ecjia_city.css'));
    	RC_Style::enqueue_style('ecjia_help', ecjia_extra::themeUrl('css/ecjia_help.css'));
    	RC_Style::enqueue_style('touch-models', ecjia_extra::themeUrl('css/ecjia.touch.models.css'));
    	RC_Style::enqueue_style('swiper', ecjia_extra::themeUrl('dist/other/swiper.min.css'));
    	RC_Style::enqueue_style('datePicker', ecjia_extra::themeUrl('lib/datePicker/css/datePicker.min.css'));
    	RC_Style::enqueue_style('winderCheck', ecjia_extra::themeUrl('lib/winderCheck/css/winderCheck.min.css'));
    	RC_Style::enqueue_style('photoswipe', ecjia_extra::themeUrl('lib/photoswipe/css/photoswipe.css'));
    	RC_Style::enqueue_style('default-skin', ecjia_extra::themeUrl('lib/photoswipe/css/default-skin/default-skin.css'));
    	RC_Style::enqueue_style('style', ecjia_extra::themeUrl('style.css')); 
    	RC_Style::enqueue_style('iosOverlay', ecjia_extra::themeUrl('lib/iOSOverlay/css/iosOverlay.css'));

        //加载脚本
    	RC_Script::enqueue_script('jquery-yomi', ecjia_extra::themeUrl('js/jquery.yomi.js'), array(), false, 1);
    	RC_Script::enqueue_script('touch-koala', ecjia_extra::themeUrl('js/ecjia.touch.koala.js'), array(), false, 1);
    	RC_Script::enqueue_script('ecjia-touch', ecjia_extra::themeUrl('js/ecjia.touch.js'), array(), false, 1);
    	RC_Script::enqueue_script('ecjia-touch-others', ecjia_extra::themeUrl('js/ecjia.touch.others.js'), array(), false, 1);
    	RC_Script::enqueue_script('ecjia-touch-goods', ecjia_extra::themeUrl('js/ecjia.touch.goods.js'), array(), false, 1);
    	RC_Script::enqueue_script('ecjia-touch-user', ecjia_extra::themeUrl('js/ecjia.touch.user.js'), array(), false, 1);
    	RC_Script::enqueue_script('ecjia-touch-flow', ecjia_extra::themeUrl('js/ecjia.touch.flow.js'), array(), false, 1);
    	
    	//链接赋值位置
//     	<script type="text/javascript">var theme_url = "{$theme_url}";</script>

    	RC_Script::enqueue_script('ecjia-touch-goods_detail', ecjia_extra::themeUrl('js/ecjia.touch.goods_detail.js'), array(), false, 1);
    	
    	//微信判断位置
//     	{if $is_weixin}
//     	<script type="text/javascript" src="{$theme_url}js/jweixin-1.2.0.js"></script>
//     	{/if}

    	RC_Script::enqueue_script('ecjia-touch-spread', ecjia_extra::themeUrl('js/ecjia.touch.spread.js'), array(), false, 1);
    	RC_Script::enqueue_script('ecjia-touch-user_account', ecjia_extra::themeUrl('js/ecjia.touch.user_account.js'), array(), false, 1);
    	RC_Script::enqueue_script('ecjia-touch-user_franchisee', ecjia_extra::themeUrl('js/ecjia.touch.franchisee.js'), array(), false, 1);
    	RC_Script::enqueue_script('ecjia-touch-user_comment', ecjia_extra::themeUrl('js/ecjia.touch.comment.js'), array(), false, 1);
    	RC_Script::enqueue_script('ecjia-touch-user_raty', ecjia_extra::themeUrl('js/ecjia.touch.raty.js'), array(), false, 1);
    	RC_Script::enqueue_script('ecjia-touch-user_fly', ecjia_extra::themeUrl('js/ecjia.touch.fly.js'), array(), false, 1);
    	RC_Script::enqueue_script('ecjia-touch-quickpay', ecjia_extra::themeUrl('js/ecjia.touch.quickpay.js'), array(), false, 1);
    	RC_Script::enqueue_script('ecjia-touch-share', ecjia_extra::themeUrl('js/ecjia.touch.share.js'), array(), false, 1);
    	
    	//弹窗 
    	RC_Script::enqueue_script('ecjia-touch-intro', ecjia_extra::themeUrl('js/ecjia.touch.intro.min.js'), array(), false, 1);
    	RC_Script::enqueue_script('Validform', ecjia_extra::themeUrl('lib/Validform/Validform_v5.3.2_min.js'), array(), false, 1);
    	RC_Script::enqueue_script('swiper', ecjia_extra::themeUrl('lib/swiper/js/swiper.min.js'), array(), false, 1);
    	RC_Script::enqueue_script('datePicker', ecjia_extra::themeUrl('lib/datePicker/js/datePicker.min.js'), array(), false, 1);
    	RC_Script::enqueue_script('winderCheck', ecjia_extra::themeUrl('lib/winderCheck/js/winderCheck.min.js'), array(), false, 1);
    	RC_Script::enqueue_script('greenCheck', ecjia_extra::themeUrl('js/greenCheck.js'), array(), false, 1);
    	RC_Script::enqueue_script('iosOverlay', ecjia_extra::themeUrl('lib/iOSOverlay/js/iosOverlay.js'), array(), false, 1);
    	RC_Script::enqueue_script('prettify', ecjia_extra::themeUrl('lib/iOSOverlay/js/prettify.js'), array(), false, 1);	
    }

    public function front_enqueue_scripts()
    {

    }

    public function front_print_styles()
    {

    }

    public function front_print_head_scripts()
    {

    }

    public function front_print_footer_scripts()
    {

    }

    public function _front_footer_scripts()
    {

    }

}