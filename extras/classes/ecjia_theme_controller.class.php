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
        //自定义加载
        RC_Style::enqueue_style('installer-normalize', RC_App::apps_url('statics/front/css/normalize.css', $this->__FILE__));
        RC_Style::enqueue_style('installer-grid', RC_App::apps_url('statics/front/css/grid.css', $this->__FILE__));
        RC_Style::enqueue_style('installer-style', RC_App::apps_url('statics/front/css/style.css', $this->__FILE__));

        //系统加载样式
        RC_Style::enqueue_style('ecjia-ui');
        RC_Style::enqueue_style('install-bootstrap', RC_App::apps_url('statics/front/css/bootstrap.min.css', $this->__FILE__));
        RC_Style::enqueue_style('bootstrap-responsive-nodeps');
        RC_Style::enqueue_style('chosen');
        RC_Style::enqueue_style('uniform-aristo');
        RC_Style::enqueue_style('fontello');

        //系统加载脚本
        RC_Script::enqueue_script('ecjia-jquery-chosen');
        RC_Script::enqueue_script('jquery-migrate');
        RC_Script::enqueue_script('jquery-uniform');
        RC_Script::enqueue_script('smoke');
        RC_Script::enqueue_script('jquery-cookie');

        RC_Script::enqueue_script('ecjia-installer', RC_App::apps_url('statics/front/js/install.js', $this->__FILE__), array('ecjia-front'), false, true);
        RC_Script::localize_script('ecjia-installer', 'js_lang', config('app-installer::jslang.installer_page'));

//        dd(ecjia_loader::print_footer_scripts());
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