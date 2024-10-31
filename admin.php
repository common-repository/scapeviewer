<?php

new WO_Plugin_Admin($this);

/**
 * Class WO_Plugin_Admin Admin tools for ScapeViewer
 */
class WO_Plugin_Admin
{
    /** @var WO_Plugin Backlink to the base plugin's class */
    var $wo_plugin;

    /**
     * @param $wo_plugin WO_Plugin
     */
    function __construct($wo_plugin)
    {
        $this->wo_plugin = $wo_plugin;

        add_action('admin_menu', array(&$this, 'register_menu_page'), 11);
        add_action('load-toplevel_page_scapeviewer', array(&$this, 'enqueue_style_and_script'));
    }

    function register_menu_page()
    {
        add_menu_page('ScapeViewer Shortcode builder', 'ScapeViewer', 'manage_options', 'scapeviewer', array(&$this, 'menu_page'), '', 120);
    }

    function enqueue_style_and_script()
    {
        wp_enqueue_style('admin-wo', plugin_dir_url(__FILE__) . 'admin-style.css', array(), '0.1');
        wp_enqueue_script('admin-wo', plugin_dir_url(__FILE__) . 'admin-script.js', array(), '0.1');
    }

    function menu_page()
    {
        include 'admin_template.php';
    }
}