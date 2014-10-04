<?php
/**
 * Minimalizine Social Widgets
 *
 * @since Minimalizine 0.1
 */
 
// Widgets
add_action( 'widgets_init', 'minimalizine_social_widget' );

// Register our widget
function minimalizine_social_widget() {
	register_widget( 'Minimalizine_Social' );
}

// Minimalizine Social Widget
class Minimalizine_Social extends WP_Widget {

	//  Setting up the widget
	function Minimalizine_Social() {
		$widget_ops  = array( 'classname' => 'minimalizine_social', 'description' => __('Minimalizine social button Widget', 'minimalizine') );
		$control_ops = array( 'id_base' => 'minimalizine_social' );

		$this->WP_Widget( 'minimalizine_social', __('Minimalizine Social Button', 'minimalizine'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $shortname;

		extract( $args );

		$minimalizine_social_title = apply_filters('widget_title', $instance['minimalizine_social_title']);
		$social_twitter = get_theme_mod('twitter_username');
		$social_fb = get_theme_mod('fb_username');
		$social_gplus = get_theme_mod('gplus_username');
		$social_flickr = get_theme_mod('flickr_username');
		$social_linkedin = get_theme_mod('linkedin_username');
		$social_pinterest = get_theme_mod('pinterest_username');
		$social_dribbble = get_theme_mod('dribbble_username');
		$social_github = get_theme_mod('github_username');
		$social_vimeo = get_theme_mod('vimeo_username');
		$social_forrst = get_theme_mod('forrst_username');
		$social_zerply = get_theme_mod('zerply_username');
		
		echo $before_widget;
		echo $before_title . $minimalizine_social_title . $after_title; ?>

        <ul id="social-button">
        	<?php
        	if($social_twitter != '')
            	echo '<li><a href="http://twitter.com/' . esc_attr($social_twitter) . '" id="button-twitter" class="ir">Twitter</a></li>';
            if($social_fb != '')
            	echo '<li><a href="http://www.facebook.com/' . esc_attr($social_fb) . '" id="button-fb" class="ir">Facebook</a></li>';
            if($social_gplus != '')
            	echo '<li><a href="https://plus.google.com/u/' . esc_attr($social_gplus) . '" id="button-gplus" class="ir">Google+</a></li>';
            if($social_flickr != '')
            	echo '<li><a href="http://www.flickr.com/photos/' . esc_attr($social_flickr) . '" id="button-flickr" class="ir">Flickr</a></li>';
            if($social_linkedin != '')
            	echo '<li><a href="http://id.linkedin.com/in/' . esc_attr($social_linkedin) . '" id="button-linkedin" class="ir">Linked In</a></li>';
            if($social_pinterest != '')
            	echo '<li><a href="http://pinterest.com/' . esc_attr($social_pinterest) . '" id="button-pinterest" class="ir">Pinterest</a></li>';
            if($social_dribbble != '')
            	echo '<li><a href="http://dribbble.com/player/' . esc_attr($social_dribbble) . '" id="button-dribbble" class="ir">Dribbble</a></li>';
            if($social_github != '')
            	echo '<li><a href="https://github.com/' . esc_attr($social_github) . '" id="button-github" class="ir">Github</a></li>';
            if($social_vimeo != '')
            	echo '<li><a href="http://vimeo.com/' . esc_attr($social_vimeo) . '" id="button-vimeo" class="ir">Vimeo</a></li>';
            if($social_forrst != '')
            	echo '<li><a href="http://forrst.com/' . esc_attr($social_forrst) . '" id="button-forrst" class="ir">Forrst</a></li>';
            if($social_zerply != '')
            	echo '<li><a href="http://zerply.com/' . esc_attr($social_zerply) . '" id="button-zerply" class="ir">Zerply</a></li>'; ?>
        </ul>


	<?php
	echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['minimalizine_social_title'] = strip_tags( $new_instance['minimalizine_social_title'] );

		return $instance;
	}

	function form( $instance ) {
		global $shortname;

		$instance = wp_parse_args( (array) $instance, array('minimalizine_social_title' => __('Social Media', 'minimalizine')) );
	?>
        <p>
            <label for="<?php echo $this->get_field_id( 'minimalizine_social_title' ); ?>"><?php _e('Widget Title:', 'minimalizine'); ?></label>
            <input id="<?php echo $this->get_field_id( 'minimalizine_social_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'minimalizine_social_title' ); ?>" value="<?php echo $instance['minimalizine_social_title']; ?>" />
        </p>

	<?php
	}
}
?>
