<?php
/**
 * @package Minimalizine
 * @since Minimalizine 0.1
 */
?>
	<div id="sidebar" class="widget-area" role="complementary">
		<div class="widget-left">
			<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
			<aside id="search" class="widget widget_search">
				<?php get_search_form(); ?>
			</aside>
			<?php endif; // end sidebar widget area ?>
		</div>
		
		<div class="widget-middle">
			<?php if ( ! dynamic_sidebar( 'sidebar-2' ) ) : ?>
			<aside id="archives" class="widget">
				<h4 class="widget-title"><?php _e( 'Archives', 'minimalizine' ); ?></h4>
				<ul>
					<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
				</ul>
			</aside>
			<?php endif; // end sidebar widget area ?>
		</div>
		
		<div class="widget-right">
			<?php if ( ! dynamic_sidebar( 'sidebar-3' ) ) : ?>
			<aside id="meta" class="widget">
				<h4 class="widget-title"><?php _e( 'Meta', 'minimalizine' ); ?></h4>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</aside>
			<?php endif; // end sidebar widget area ?>
		</div>
	</div><!-- end #sidebar .widget-area -->
