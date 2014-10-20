<?php
/**
 * @package Admin Stylur
 * @version 1.3
 * @copyright 2014
 * @link  http://wordpress.org/plugins/admin-stylur
 */
/*
Plugin Name: Admin Stylur
Plugin URI: http://wordpress.org/plugins/admin-stylur
Description: Customized and tweaked dashboard and login views. Read more about the customization of your admin via the <a href="http://codex.wordpress.org/Creating_Admin_Themes">WordPress Codex</a>. Features include setting the login image to the URL of your blogsetting and setting the title attribute to your blog's name. Also provided is a logo uploader (found under the “Appearance” dashboard menu item) to swap the default WordPress logo on all login screens along with the ability to add a custom stylesheet that overrides the plugin's defaults.
Author: Gray Ghost Visuals
Version: 1.3
Author URI: http://grayghostvisuals.com
License: GPLv3
*/

// Inline Documentation: https://codex.wordpress.org/Inline_Documentation
// http://wordpress.org/plugins/about/faq
// http://wordpress.org/plugins/add

load_plugin_textdomain('Admin Stylur', false, basename( dirname( __FILE__ ) ) . '/languages' );


/********************************************************
 *
 * Allow users to upload and swap the login logo.
 * http://codex.wordpress.org/Adding_Administration_Menus
 * http://code.tutsplus.com/articles/how-to-integrate-the-wordpress-media-uploader-in-theme-and-plugin-options--wp-26052
 *
 * @since 1.1
 *
 ********************************************************
 */

/**
 * function admin_stylur_scripts()
 * Load required modal scripts and
 * styles for thickbox.
 *
 * @since 1.1
 */

function admin_stylur_scripts() {
  wp_enqueue_script('media-upload');
  wp_enqueue_script('thickbox');
  wp_enqueue_script('jquery');
}

function admin_stylur_styles() {
  wp_enqueue_style('thickbox');
}

add_action('admin_print_scripts', 'admin_stylur_scripts');
add_action('admin_print_styles', 'admin_stylur_styles');


/**
 * function admin_stylur_get_default_options()
 *
 * @since 1.1
 */

function admin_stylur_get_default_options() {
  $options = array(
    'logo' => ''
  );

  return $options;
}


/**
 * function admin_stylur_options_init()
 * Initialize Options
 *
 * @since 1.1
 */

function admin_stylur_options_init() {
  $admin_stylur_options = get_option( 'theme_admin_stylur_options' );

  // Are any options saved in the DB?
  // If not, we'll save our default options.
  if ( false === $admin_stylur_options ) {
    $admin_stylur_options = admin_stylur_get_default_options();

    add_option(
      'theme_admin_stylur_options',
      $admin_stylur_options
    );
  }
}

add_action( 'after_setup_theme', 'admin_stylur_options_init' );


/**
 * function admin_stylur_menu_options()
 * Add Options items to the "Appearance" menu.
 *
 * $page_title, $menu_title, $capability, $menu_slug, $function
 *
 * @since 1.1
 */

function admin_stylur_menu_options() {
  add_theme_page(
    'Admin Stylur Logo',
    'Admin Stylur',
    'edit_theme_options',
    'admin-stylur-settings',
    'admin_stylur_admin_options_page'
  );
}

add_action('admin_menu', 'admin_stylur_menu_options');


/**
 * function admin_stylur_admin_options_page()
 * present the options form to the user
 *
 * @since 1.1
 */

function admin_stylur_admin_options_page() { ?>
  <!-- 
    'wrap','submit','button-primary' and 'button-secondary'
    are classe for a good WP Admin Panel viewing and are
    predefined by WP CSS
  -->

  <div class="wrap"> 
    <h2><?php _e( 'Admin Stylur Login Logo', 'admin_stylur' ); ?></h2>

    <!--
      If we have any error by submiting the form,
      they will appear here,
    -->
    <?php settings_errors( 'admin-stylur-settings-errors' ); ?>

    <form id="form-admin_stylur-options" action="options.php" method="post" enctype="multipart/form-data">
      <?php
        settings_fields('theme_admin_stylur_options');
        do_settings_sections('admin_stylur');
      ?>

      <p class="submit">
        <input name="theme_admin_stylur_options[submit]" id="submit_options_form" type="submit" class="button-primary" value="<?php esc_attr_e('Save Settings', 'admin_stylur'); ?>" />
        <input name="theme_admin_stylur_options[reset]" type="submit" class="button-secondary" value="<?php esc_attr_e('Reset', 'admin_stylur'); ?>" />
      </p>
    </form>

    <script>
      jQuery(document).ready(function($) {
        $('#upload_logo_button').click(function() {

          tb_show(
            'Upload a logo',
            'media-upload.php?referer=admin-stylur-settings&type=image&TB_iframe=true&post_id=0',
            false
          );

          return false;
        });


        window.send_to_editor = function(html) {
          var image_url = $('img', html).attr('src');
          $('#logo_url').val(image_url);
          tb_remove();
          $('#upload_logo_preview img').attr('src', image_url);
          $('#submit_options_form').trigger('click');
        }
      });
    </script>
  </div>
<?php }


/**
 * function admin_stylur_options_settings_init()
 *
 * @since 1.1
 */

function admin_stylur_options_settings_init() {
  register_setting(
    'theme_admin_stylur_options',
    'theme_admin_stylur_options',
    'admin_stylur_options_validate'
  );

  // Add a form section for the Logo
  add_settings_section(
    'admin_stylur_settings_header',
    __( 'Details', 'admin_stylur' ),
    'admin_stylur_settings_header_text',
    'admin_stylur'
  );

  // Add Logo uploader
  add_settings_field(
    'admin_stylur_setting_logo',
    __( 'Logo', 'admin_stylur' ),
    'admin_stylur_setting_logo',
    'admin_stylur',
    'admin_stylur_settings_header'
  );

  // Add Current Image Preview
  add_settings_field(
    'admin_stylur_setting_logo_preview',
    __( 'Logo Preview', 'admin_stylur' ),
    'admin_stylur_setting_logo_preview',
    'admin_stylur',
    'admin_stylur_settings_header'
  );
}

add_action( 'admin_init', 'admin_stylur_options_settings_init' );


/**
 * function admin_stylur_settings_header_text()
 *
 * @since 1.1
 */

function admin_stylur_settings_header_text() { ?>
  <p><?php _e( 'Make sure your logo is 80px x 80px before uploading.', 'admin_stylur' ); ?></p>
<?php }


/**
 * function admin_stylur_setting_logo()
 *
 * @since 1.1
 */

function admin_stylur_setting_logo() {
  $admin_stylur_options = get_option( 'theme_admin_stylur_options' );
  ?>

  <input type="hidden" id="logo_url" name="theme_admin_stylur_options[logo]" value="<?php echo esc_url( $admin_stylur_options['logo'] ); ?>" />
  <input id="upload_logo_button" type="button" class="button" value="<?php _e( 'Upload Logo', 'admin_stylur' ); ?>" />
  <?php if ( '' != $admin_stylur_options['logo'] ): ?>
  <input id="delete_logo_button" name="theme_admin_stylur_options[delete_logo]" type="submit" class="button" value="<?php _e( 'Delete Logo', 'admin_stylur' ); ?>" />
  <?php endif; ?>

  <span class="description"><?php _e('Upload a logo for your login screen', 'admin_stylur' ); ?></span>
<?php }


/**
 * function admin_stylur_setting_logo_preview()
 *
 * @since 1.1
 */

function admin_stylur_setting_logo_preview() {
  $admin_stylur_options = get_option( 'theme_admin_stylur_options' );  ?>
  <div id="upload_logo_preview" style="min-height: 100px;">
    <img style="max-width: 80px; width: 100%; height: 80px; background: #F1F1F1;" src="<?php echo esc_url( $admin_stylur_options['logo'] ); ?>" />
  </div>
<?php }


/**
 * function admin_stylur_options_validate()
 *
 * @since 1.1
 */

function admin_stylur_options_validate( $input ) {
  $default_options = admin_stylur_get_default_options();
  $valid_input = $default_options;

  $submit = ! empty($input['submit']) ? true : false;
  $reset = ! empty($input['reset']) ? true : false;
  $delete_logo = ! empty($input['delete_logo']) ? true : false;

  if ( $submit ) {
    $valid_input['logo'] = $input['logo'];

    if ( $admin_stylur_options['logo'] != $input['logo'] && $admin_stylur_options['logo'] != '' )
      delete_image( $admin_stylur_options['logo'] );
 
    $valid_input['logo'] = $input['logo'];
  }
  elseif ( $reset ) {
    delete_image( $admin_stylur_options['logo'] );
    $valid_input['logo'] = $default_options['logo'];
  }
  elseif ( $delete_logo ) {
    delete_image( $admin_stylur_options['logo'] );
    $valid_input['logo'] = '';
  }

  return $valid_input;
}


/**
 * function admin_stylur_options_setup()
 * Replace txt for 'Insert into Post' button inside Thickbox
 *
 * @since 1.1
 */

function admin_stylur_options_setup() {
  global $pagenow;

  if ( 'media-upload.php' == $pagenow || 'async-upload.php' == $pagenow ) {
    add_filter( 'gettext', 'replace_thickbox_text'  , 1, 3 );
  }
}

add_action( 'admin_init', 'admin_stylur_options_setup' );


/**
 * function replace_thickbox_text()
 *
 * @since 1.1
 */

function replace_thickbox_text($translated_text, $text, $domain) {
  if ('Insert into Post' == $text) {
    $referer = strpos( wp_get_referer(), 'admin-stylur-settings' );

    if ( $referer != '' ) {
      return __('Use Logo', 'admin_stylur' );
    }
  }

  return $translated_text;
}


/**
 * function delete_image()
 * We need to get the image's meta ID,
 * and delete it.
 *
 * @since 1.1
 */

function delete_image( $image_url ) {
  global $wpdb;

  $query = "SELECT ID FROM wp_posts where guid = '" . esc_url($image_url) . "' AND post_type = 'attachment'";
  $results = $wpdb->get_results($query);

  foreach ( $results as $row ) {
    wp_delete_attachment( $row->ID );
  }
}


/**
 * function admin_stylur_logo
 * Register a new logo uploaded via plugin settings.
 * http://codex.wordpress.org/Customizing_the_Login_Form
 *
 * @since 1.1
 */

function admin_stylur_logo() { ?>
  <?php $admin_stylur_options = get_option('theme_admin_stylur_options'); ?>

  <?php if ( $admin_stylur_options['logo'] != '' ): ?>
  <style>
    #login h1 a {
      background-image: url(<?php echo $admin_stylur_options['logo']; ?>);
    }
  </style>
  <?php  endif; ?>
<?php }

add_action( 'login_enqueue_scripts', 'admin_stylur_logo' );


/**
 * function my_login_css
 * Loads our stylesheet into the head of our doc
 *
 * @since 1.0
 */

function my_login_css() {
  echo '<link rel="stylesheet" href="' . plugins_url('styles.css', __FILE__) . '">';
}

add_action('login_head', 'my_login_css');
add_action('admin_enqueue_scripts', 'my_login_css');


/**
 * @function my_custom_login_css()
 * Loads a custom CSS file if the script detects it's presence:
 * '<theme-name>/css/admin-stylur/wplogin.css'
 *
 * @since 1.3
 */

$admin_stylur_custom_stylesheet = '/css/admin-stylur/wplogin.css';
$admin_stylur_custom_css        = get_template_directory() . $admin_stylur_custom_stylesheet;

clearstatcache();

if( file_exists( $admin_stylur_custom_css ) ) {

  function admin_stylur_custom_styles() {

    global $admin_stylur_custom_stylesheet;
    echo '<link rel="stylesheet" href="' . get_template_directory_uri() . $admin_stylur_custom_stylesheet . '">';

  }

  add_action('login_head', 'admin_stylur_custom_styles');
  add_action('admin_enqueue_scripts', 'admin_stylur_custom_styles');

}


/**
 * function my_login_imgurl
 * Set the URL to which the login logo image is linked
 *
 * @since 1.0
 */

function my_login_imgurl() {
  return home_url();
}

add_filter( 'login_headerurl', 'my_login_imgurl');


/**
 * function my_login_imgtitle
 * Set the title of the login page
 *
 * @since 1.0
 */
function my_login_imgtitle() {
  return get_bloginfo('title', 'display');
}

add_filter( 'login_headertitle', 'my_login_imgtitle');
