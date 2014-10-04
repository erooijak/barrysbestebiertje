<?php
/**
 * Support for WordPress theme customizer
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Minimalizine
 * @since Minimalizine 0.4
 */

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Minimalizine 0.4
 */
function minimalizine_customize_preview_js() {
	wp_enqueue_script( 'minimalizine-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '0.4', true );
}
add_action( 'customize_preview_init', 'minimalizine_customize_preview_js' );


/**
 * Register customize menu in admin page for easier access to customizer
 *
 * @since Minimalizine 0.4
 */
function minimalizine_customize_menu() {
    add_theme_page( __('Customize Minimalizine', 'minimalizine'), __('Customize Minimalizine', 'minimalizine'), 'edit_theme_options', 'customize.php' );
}
add_action ('admin_menu', 'minimalizine_customize_menu');


/**
 * Register the settings of the customizer
 *
 * @since Minimalizine 0.4
 */
function minimalizine_customize($wp_customize) {
	
	// Register textarea control
	class Minimalizine_Customize_Textarea_Control extends WP_Customize_Control {
		public $type = 'textarea';

		public function render_content() { ?>
			<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
			</label>
		<?php }
	}

	// Social section
	$wp_customize->add_section( 'minimalizine_social_section', array(
		'title'          => __('Socials Settings', 'minimalizine'),
		'priority'       => 125
	) );
 
	$wp_customize->add_setting( 'fb_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'fb_username', array(
		'label'   => __('Facebook Username', 'minimalizine'),
		'section' => 'minimalizine_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'twitter_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'twitter_username', array(
		'label'   => __('Twitter Username', 'minimalizine'),
		'section' => 'minimalizine_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'gplus_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'gplus_username', array(
		'label'   => __('Google+ ID', 'minimalizine'),
		'section' => 'minimalizine_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'flickr_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'flickr_username', array(
		'label'   => __('Flickr Username', 'minimalizine'),
		'section' => 'minimalizine_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'linkedin_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'linkedin_username', array(
		'label'   => __('Linkedin Username', 'minimalizine'),
		'section' => 'minimalizine_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'pinterest_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'pinterest_username', array(
		'label'   => __('Pinterest Username', 'minimalizine'),
		'section' => 'minimalizine_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'dribbble_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'dribbble_username', array(
		'label'   => __('Dribbble Username', 'minimalizine'),
		'section' => 'minimalizine_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'github_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'github_username', array(
		'label'   => __('Github Username', 'minimalizine'),
		'section' => 'minimalizine_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'vimeo_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'vimeo_username', array(
		'label'   => __('Vimeo Username', 'minimalizine'),
		'section' => 'minimalizine_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'forrst_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'forrst_username', array(
		'label'   => __('Forrst Username', 'minimalizine'),
		'section' => 'minimalizine_social_section',
		'type'    => 'text'
	) );
	
	$wp_customize->add_setting( 'zerply_username', array(
		'default'        => '',
	) );

	$wp_customize->add_control( 'zerply_username', array(
		'label'   => __('Zerply Username', 'minimalizine'),
		'section' => 'minimalizine_social_section',
		'type'    => 'text'
	) );
	
	// General section
    $wp_customize->add_section( 'minimalizine_general_section', array(
        'title'          => __('General Settings', 'minimalizine'),
        'priority'       => 127,
    ) );
    
	$wp_customize->add_setting( 'footer_text', array(
		'default' => ''
	) );

	$wp_customize->add_control( new Minimalizine_Customize_Textarea_Control( $wp_customize, 'footer_text', array(
		'label'   => __('Footer text', 'minimalizine'),
		'section' => 'minimalizine_general_section',
		'settings'   => 'footer_text',
	) ) );
	
	$wp_customize->add_setting( 'custom_css', array(
		'default' => ''
	) );

	$wp_customize->add_control( new Minimalizine_Customize_Textarea_Control( $wp_customize, 'custom_css', array(
		'label'   => __('Custom CSS', 'minimalizine'),
		'section' => 'minimalizine_general_section',
		'settings'   => 'custom_css',
	) ) );
	
	// needed for live previewing
	$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
}
add_action('customize_register', 'minimalizine_customize');
