<?php

/**
 * Handles AJAX calls to: /wp-admin/admin-ajax.php?action=mcsw_subscribe
 */
function mcsw_subscribe()
{
    $ret = array(
        'success' => false,
        'message' => '',
    );

    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $nonce = isset($_POST['nonce']) ? trim($_POST['nonce']) : '';
    $mc_api_key = null;
    $mc_list_id = null;
    $error_message = '';
    $widget_id = isset($_POST['widget_id']) ? trim($_POST['widget_id']) : '';

    if (($widget_settings = get_widget_settings($widget_id))) {
        $mc_api_key = isset($widget_settings['api_key']) ? $widget_settings['api_key'] : null;
        $mc_list_id = isset($widget_settings['list_id']) ? $widget_settings['list_id'] : null;
        $error_message = isset($widget_settings['error_message']) ? $widget_settings['error_message'] : '';
    }

    if ($email &&
            $widget_settings &&
            $mc_api_key != null &&
            $mc_list_id != null &&
            wp_verify_nonce($nonce, mcsw_nonce_action())) {

        try {
            $list = new Mailchimp_Lists(new Mailchimp($mc_api_key));
            $resp = $list->subscribe($mc_list_id, array('email' => $email), null, 'html', false, true);

            if ($resp) {
                $ret['success'] = true;
                $ret['message'] = $widget_settings['success_message'];
            } else {
                $ret['message'] = $widget_settings['error_message'];
            }
        } catch (Exception $ex) {
            $ret['message'] = $widget_settings['error_message'];
        }
    } else {
        $ret['message'] = $error_message;
    }

    header('Content-Type: application/json');
    echo json_encode($ret);
    exit();
}

/**
 * @param string $widget_id
 * @return array 
 */
function get_widget_settings($widget_id)
{
    global $wp_registered_widgets;
    $ret = array();

    if (isset($wp_registered_widgets)) {
        $widget = $wp_registered_widgets[$widget_id];
        $option_data = get_option($widget['callback'][0]->option_name);

        if (isset($option_data[$widget['params'][0]['number']])) {
            $ret = $option_data[$widget['params'][0]['number']];
        }
    }

    return $ret;
}

add_action('wp_ajax_mcsw_subscribe', 'mcsw_subscribe', 10, 0);
add_action('wp_ajax_nopriv_mcsw_subscribe', 'mcsw_subscribe', 10, 0);
