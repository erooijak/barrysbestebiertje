<?php
/**
 * About Minimalizine admin page
 *
 * @package Minimalizine
 * @since Minimalizine 0.4
 */
 
/**
 * Display the about Minimalizine admin menu
 *
 * @since Minimalizine 0.4
 */
function minimalizine_admin_menu(){
	add_theme_page(__('About Minimalizine', 'minimalizine'), __('About Minimalizine', 'minimalizine'), 'switch_themes', 'minimalizine', 'minimalizine_admin_page_render');
}
add_action('admin_menu', 'minimalizine_admin_menu');

/**
 * Render the admin page
 *
 * @since Minimalizine 0.4
 */
function minimalizine_admin_page_render(){
	$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'about';
?>
	<div class="wrap">
		<h2 class="nav-tab-wrapper">
			<a href="<?php echo add_query_arg('tab', 'about'); ?>" class="nav-tab <?php echo $active_tab == 'about' ? 'nav-tab-active' : ''; ?>"><?php _e('About', 'minimalizine'); ?></a>
			<a href="<?php echo add_query_arg('tab', 'premium'); ?>" class="nav-tab <?php echo $active_tab == 'premium' ? 'nav-tab-active' : ''; ?>"><?php _e('Minimalizine Premium', 'minimalizine'); ?></a>
		</h2>
			
		<div id="tab_container">
			<?php if($active_tab == 'about') { ?>
				
			<div class="section">
				<h4 class="heading"><?php _e('Customizing', 'minimalizine'); ?></h4>
				<p><?php printf( __('We dropped the theme options since version 0.4 and start using WordPress Theme Customizer. You can navigate to <a href="%1$s">Customize Minimalizine</a> to start customizing, from colors, socials username, footer text, and others. Off course you can alse <a href="%2$s">customize your header</a> and/or your <a href="%3$s">background</a>.', 'minimalizine'), admin_url('customizer.php'), admin_url('themes.php?page=custom-header'), admin_url('themes.php?page=custom-background') ); ?></p>
				<p><?php _e('Started this version, Minimalizine dropped support for meta verification and analytics js. They\'re plugin territory, so if you still need them, you can choose and install from numerous plugins at directory to bring them back in Minimalizine.', 'minimalizine'); ?></p>
				<p><em><?php _e('At last, We are so sorry if you loose your last options. Since Minimalizine now using Customizer, <strong>all settings are saved as theme mod, not standard options anymore</strong>.', 'minimalizine'); ?></em></p>
			</div>
			
			<div class="section">
				<h4 class="heading"><?php _e('Thank you for using Minimalizine :)', 'minimalizine'); ?></h4>
				<p><?php printf( __('Minimalizine is made based on <a href="%1$s">_s</a> (Underscores) theme by Automattic. Comes with simple and minimalist concept.', 'minimalizine'), 'https://github.com/Automattic/_s' ); ?></p>
				<p><?php _e('Simple and responsive WordPress theme. It\'s clean and good for you who wants focused on the content. It supports 3 widget areas above the footer, and packed with 10 social media buttons widget. Has an optional full-width and sitemap page template, also translation ready.', 'minimalizine'); ?></p>
				<p><?php printf( __('If you have any problem or questions, you can post on <a href="%1$s">Minimalizine theme support</a> or mention me <a href="%2$s">@rizqyhi</a>. One more thing, don\'t forget to check <a href="%3$s">Minimalizine on WordPress.com</a>.', 'minimalizine'), 'http://wordpress.org/support/theme/minimalizine', 'http://twitter.com/rizqyhi', 'http://theme.wordpress.com/themes/minimalizine' ); ?></p>
				<p><?php printf( __('If you like Minimalizine and wanted to make it better, you can help by <a href="%1$s">writing a review</a> and shine some stars, or <a href="%2$s">buy the premium version</a>,  or <a href="%3$s">buy me a coffee</a>. Thank you.', 'minimalizine'), 'http://wordpress.org/support/view/theme-reviews/minimalizine', admin_url('themes.php?page=minimalizine&tab=premium'), 'https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=K8VZXEQQUBH9J' ); ?></p>
			</div>
			
			<div class="section">
				<h4 class="heading"><?php _e('Thanks to', 'minimalizine'); ?></h4>
				<ul>
					<li><a href='https://github.com/Automattic/_s'>_s (Underscores)</a></li>
					<li><a href='http://www.designdeck.co.uk/a/1271'>Relay social icon set</a></li>
					<li><a href='http://www.google.com/webfonts'>Google webfonts</a></li>
					<li><a href='http://www.justbenicestudio.com/studio/websymbols'>Web symbols regular webfont</a></li>
					<li><a href='http://profiles.wordpress.org/sixhours'>Sixhours</a>, <?php _e('for WordPress.com\'s version', 'minimalizine'); ?></li>
				</ul>
			</div>

			<?php } elseif($active_tab == 'premium') { ?>
			<div class="section">
				<h4 class="heading"><?php _e('Upgrade to Minimalizine Premium', 'minimalizine'); ?></h4>
				<p><?php _e('We are working in it and hopefully we could release it soon. :)', 'minimalizine'); ?></p>
			</div>
							
			<?php } ?>
		
		</div><!--end #tab_container-->		
	</div>
				
<?php 
}

/**
 * Style for the admin page
 *
 * @since Minimalizine 0.4
 */
function minimalizine_admin_page_style(){
?>
	
	<style type="text/css">
		#tab_container {
			padding:20px;
			border:1px solid #ccc;
			border-top:none;
			border-radius:0 3px 3px 3px
		}
		#tab_container .section {
			margin-bottom:50px
		}
		#tab_container .heading {
			margin:0;
			padding-bottom:5px;
			font-size:16px;
			border-bottom:1px solid #ddd
		}
		.buy_section {
			margin:40px 0 20px;
			text-align:center
		}
		.buy_premium {
			background-color:#3bb3e0;
			font-size:16px;
			text-decoration:none;
			color:#fff;
			position:relative;
			padding:10px 20px;
			border-left:solid 1px #2ab7ec;
			margin-left:35px;
			background-image: linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
			background-image: -o-linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
			background-image: -moz-linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
			background-image: -webkit-linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
			background-image: -ms-linear-gradient(bottom, rgb(44,160,202) 0%, rgb(62,184,229) 100%);
			background-image: -webkit-gradient(
			linear,
			left bottom,
			left top,
			color-stop(0, rgb(44,160,202)),
			color-stop(1, rgb(62,184,229))
			);
			-webkit-border-top-right-radius: 5px;
			-webkit-border-bottom-right-radius: 5px;
			-moz-border-radius-topright: 5px;
			-moz-border-radius-bottomright: 5px;
			border-top-right-radius: 5px;
			border-bottom-right-radius: 5px;
			-webkit-box-shadow: inset 0px 1px 0px #2ab7ec, 0px 5px 0px 0px #156785, 0px 10px 5px #999;
			-moz-box-shadow: inset 0px 1px 0px #2ab7ec, 0px 5px 0px 0px #156785, 0px 10px 5px #999;
			-o-box-shadow: inset 0px 1px 0px #2ab7ec, 0px 5px 0px 0px #156785, 0px 10px 5px #999;
			box-shadow: inset 0px 1px 0px #2ab7ec, 0px 5px 0px 0px #156785, 0px 10px 5px #999;
		}
		.buy_premium:hover {
			color:#fff
		}
		.buy_premium:active {
			top:3px;
			background-image: linear-gradient(bottom, rgb(62,184,229) 0%, rgb(44,160,202) 100%);
			background-image: -o-linear-gradient(bottom, rgb(62,184,229) 0%, rgb(44,160,202) 100%);
			background-image: -moz-linear-gradient(bottom, rgb(62,184,229) 0%, rgb(44,160,202) 100%);
			background-image: -webkit-linear-gradient(bottom, rgb(62,184,229) 0%, rgb(44,160,202) 100%);
			background-image: -ms-linear-gradient(bottom, rgb(62,184,229) 0%, rgb(44,160,202) 100%);
			background-image: -webkit-gradient(
			linear,
			left bottom,
			left top,
			color-stop(0, rgb(62,184,229)),
			color-stop(1, rgb(44,160,202))
			);
			-webkit-box-shadow: inset 0px 1px 0px #2ab7ec, 0px 2px 0px 0px #156785, 0px 5px 3px #999;
			-moz-box-shadow: inset 0px 1px 0px #2ab7ec, 0px 2px 0px 0px #156785, 0px 5px 3px #999;
			-o-box-shadow: inset 0px 1px 0px #2ab7ec, 0px 2px 0px 0px #156785, 0px 5px 3px #999;
			box-shadow: inset 0px 1px 0px #2ab7ec, 0px 2px 0px 0px #156785, 0px 5px 3px #999;
		}

		.buy_premium::before {
			background-color:#2561b4;
			content:"$12";
			width:45px;
			max-height:27px;
			height:100%;
			position:absolute;
			display:block;
			padding-top:12px;
			text-align:center;
			top:0px;
			left:-36px;
			font-size:16px;
			font-weight:bold;
			color:#8fd1ea;
			text-shadow:1px 1px 0px #07526e;
			border-right:solid 1px #07526e;
			background-image: linear-gradient(bottom, rgb(10,94,125) 0%, rgb(14,139,184) 100%);
			background-image: -o-linear-gradient(bottom, rgb(10,94,125) 0%, rgb(14,139,184) 100%);
			background-image: -moz-linear-gradient(bottom, rgb(10,94,125) 0%, rgb(14,139,184) 100%);
			background-image: -webkit-linear-gradient(bottom, rgb(10,94,125) 0%, rgb(14,139,184) 100%);
			background-image: -ms-linear-gradient(bottom, rgb(10,94,125) 0%, rgb(14,139,184) 100%);
			background-image: -webkit-gradient(
			linear,
			left bottom,
			left top,
			color-stop(0, rgb(10,94,125)),
			color-stop(1, rgb(14,139,184))
			);
			-webkit-border-top-left-radius: 5px;
			-webkit-border-bottom-left-radius: 5px;
			-moz-border-radius-topleft: 5px;
			-moz-border-radius-bottomleft: 5px;
			border-top-left-radius: 5px;
			border-bottom-left-radius: 5px;
			-webkit-box-shadow:inset 0px 1px 0px #2ab7ec, 0px 5px 0px 0px #032b3a, 0px 10px 5px #999 ;
			-moz-box-shadow:inset 0px 1px 0px #2ab7ec, 0px 5px 0px 0px #032b3a, 0px 10px 5px #999 ;
			-o-box-shadow:inset 0px 1px 0px #2ab7ec, 0px 5px 0px 0px #032b3a, 0px 10px 5px #999 ;
			box-shadow:inset 0px 1px 0px #2ab7ec, 0px 5px 0px 0px #032b3a, 0px 10px 5px #999 ;
		}

		.buy_premium:active::before {
			top:-3px;
			-webkit-box-shadow:inset 0px 1px 0px #2ab7ec, 0px 5px 0px 0px #032b3a, 1px 1px 0px 0px #044a64, 2px 2px 0px 0px #044a64, 2px 5px 0px 0px #044a64, 6px 4px 2px #0b698b, 0px 10px 5px #999 ;
			-moz-box-shadow:inset 0px 1px 0px #2ab7ec, 0px 5px 0px 0px #032b3a, 1px 1px 0px 0px #044a64, 2px 2px 0px 0px #044a64, 2px 5px 0px 0px #044a64, 6px 4px 2px #0b698b, 0px 10px 5px #999 ;
			-o-box-shadow:inset 0px 1px 0px #2ab7ec, 0px 5px 0px 0px #032b3a, 1px 1px 0px 0px #044a64, 2px 2px 0px 0px #044a64, 2px 5px 0px 0px #044a64, 6px 4px 2px #0b698b, 0px 10px 5px #999 ;
			box-shadow:inset 0px 1px 0px #2ab7ec, 0px 5px 0px 0px #032b3a, 1px 1px 0px 0px #044a64, 2px 2px 0px 0px #044a64, 2px 5px 0px 0px #044a64, 6px 4px 2px #0b698b, 0px 10px 5px #999 ;
		}
	</style>
	
<?php
}
add_action('admin_head', 'minimalizine_admin_page_style', 20);
