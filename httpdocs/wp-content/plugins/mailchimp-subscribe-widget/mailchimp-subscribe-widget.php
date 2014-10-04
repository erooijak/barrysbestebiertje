<?php

/*
  Plugin Name: MailChimp Subscribe Widget
  Plugin URI: http://wordpress.org/plugins/mailchimp-subscribe-widget/
  Description: This plugin creates a "subscribe to list" widget
  Author: Nenad Mitic
  Version: 0.9
  Author URI: http://nenadmitic.com
 */

require_once dirname(__FILE__) . '/mc-api/src/Mailchimp.php';
require_once dirname(__FILE__) . '/McSubscribeWidget.php';
require_once dirname(__FILE__) . '/ajax-handler.php';

function mcsw_register_widget()
{
    register_widget('McSubscribeWidget');
}

function mcsw_add_scripts()
{
    wp_enqueue_style('mcsw', plugins_url('/css/mcsw.css', __FILE__));
    wp_enqueue_script('mcsw', plugins_url('/js/mcsw.js', __FILE__), array('jquery'), '0.9', true);
}

function mcsw_nonce_action()
{
    return 'mcsw_subscribe';
}

add_action('widgets_init', 'mcsw_register_widget');
add_action('wp_enqueue_scripts', 'mcsw_add_scripts');
