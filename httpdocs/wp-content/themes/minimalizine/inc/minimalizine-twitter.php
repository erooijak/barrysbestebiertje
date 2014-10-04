<?php
/**
 * Minimalizine Twitter Widget
 *
 * @since Minimalizine 0.3
 */
 
// Widgets
add_action( 'widgets_init', 'minimalizine_twitter_widget' );

// Register our widget
function minimalizine_twitter_widget() {
	register_widget( 'Minimalizine_Twitter' );
}

class Minimalizine_Twitter extends WP_Widget {

	//  Setting up the widget
	function Minimalizine_Twitter() {
		$widget_ops  = array( 'classname' => 'minimalizine_twitter', 'description' => __('Minimalizine Twitter widget', 'minimalizine') );
		$control_ops = array( 'id_base' => 'minimalizine_twitter' );

		$this->WP_Widget( 'minimalizine_twitter', __('Minimalizine Twitter Widget', 'minimalizine'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $shortname;

		extract( $args );

		$minimalizine_twitter_title = apply_filters('widget_title', $instance['minimalizine_twitter_title']);
		$minimalizine_twitter_username = $instance['minimalizine_twitter_username'];
		$minimalizine_twitter_count = !empty($instance['minimalizine_twitter_count']) ? $instance['minimalizine_twitter_count'] : 1;
		$minimalizine_twitter_follow = $instance['minimalizine_twitter_follow'];
		
		echo $before_widget;
		echo $before_title . $minimalizine_twitter_title . $after_title; ?>

		<ul id="twitter_update_list">
			<li><?php _e('Loading...', 'minimalizine');?></li>
		</ul>
		<p class="follow-text"><a href="http://twitter.com/<?php echo $minimalizine_twitter_username;?>"><?php echo $minimalizine_twitter_follow; ?></a></p>
		
		<script type="text/javascript" src="http://twitter.com/javascripts/blogger.js"></script>
		<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<?php echo $minimalizine_twitter_username; ?>.json?callback=twitterCallback2&amp;count=<?php echo $minimalizine_twitter_count; ?>"></script> 
        
	<?php
	echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['minimalizine_twitter_title'] = strip_tags( $new_instance['minimalizine_twitter_title'] );
		$instance['minimalizine_twitter_username'] = strip_tags( $new_instance['minimalizine_twitter_username'] );
		$instance['minimalizine_twitter_count'] = strip_tags( $new_instance['minimalizine_twitter_count'] );
		$instance['minimalizine_twitter_follow'] = strip_tags( $new_instance['minimalizine_twitter_follow'] );

		return $instance;
	}

	function form( $instance ) {
		global $shortname;

		$instance = wp_parse_args( (array) $instance, array('minimalizine_twitter_title' => __('Latest Tweets', 'minimalizine'), 'minimalizine_twitter_username' => '', 'minimalizine_twitter_count' => '1', 'minimalizine_twitter_follow' => __('Follow me on Twitter', 'minimalizine') ) );
	?>
        <p>
            <label for="<?php echo $this->get_field_id( 'minimalizine_twitter_title' ); ?>"><?php _e('Widget Title:', 'minimalizine'); ?></label>
            <input id="<?php echo $this->get_field_id( 'minimalizine_twitter_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'minimalizine_twitter_title' ); ?>" value="<?php echo $instance['minimalizine_twitter_title']; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id( 'minimalizine_twitter_username' ); ?>"><?php _e('Twitter Username:', 'minimalizine'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'minimalizine_twitter_username' ); ?>" name="<?php echo $this->get_field_name( 'minimalizine_twitter_username' ); ?>" value="<?php echo $instance['minimalizine_twitter_username']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'minimalizine_twitter_count' ); ?>"><?php _e('Tweets Count:', 'minimalizine'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'minimalizine_twitter_count' ); ?>" name="<?php echo $this->get_field_name( 'minimalizine_twitter_count' ); ?>" value="<?php echo $instance['minimalizine_twitter_count']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'minimalizine_twitter_follow' ); ?>"><?php _e('Follow Button Text:', 'minimalizine'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'minimalizine_twitter_follow' ); ?>" name="<?php echo $this->get_field_name( 'minimalizine_twitter_follow' ); ?>" value="<?php echo $instance['minimalizine_twitter_follow']; ?>" />

	<?php
	}
}
?>
