<?php
/*
 * Template Name: Sitemap
 *
 * @package Minimalizine
 * @since Minimalizine 0.3
*/
get_header(); ?>

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">
		
			<?php while (have_posts()) : the_post(); ?>
	
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-meta side">
					<?php edit_post_link( __( 'Edit', 'minimalizine' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .entry-meta -->
				
				<header class="entry-header wide">
					<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
				</header><!-- .entry-header -->
		
				<div class="entry-content wide">
					<h3><?php _e('Last 20 Posts', 'minimalizine'); ?></h3>
					<ul>
						<?php $sitemap_query = new WP_Query('posts_per_page=20');
						while ($sitemap_query->have_posts()) : $sitemap_query->the_post(); ?>
							<li><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> / <em><?php the_time(get_option('date_format')); ?></em></li>
						<?php endwhile; wp_reset_postdata(); ?>
					</ul>
                            
					<h3><?php _e('Pages','minimalizine'); ?></h3>
					<ul><?php wp_list_pages('sort_column=menu_order&depth=0&title_li='); ?></ul>
					
					<h3><?php _e('Categories','minimalizine'); ?></h3>
					<ul><?php wp_list_categories('depth=0&title_li=&show_count=1'); ?></ul>

					<h3><?php _e('Archives','minimalizine'); ?></h3>
					<ul><?php wp_get_archives('type=monthly&limit=12'); ?> </ul>

					<h3><?php _e('Tags','minimalizine'); ?></h3>
					<?php wp_tag_cloud('smallest=10&largest=18&number=&order=desc&format=flat'); ?>
				</div><!-- .entry-content -->
			</article><!-- end #post-<?php the_ID(); ?>-->
			
			<?php if ( comments_open() || '0' != get_comments_number() )
					comments_template( '', true ); ?>
					
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content .site-content -->
		</div><!-- #site-content .content-area -->

<?php get_footer(); ?>
