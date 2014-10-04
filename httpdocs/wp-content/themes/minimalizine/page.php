<?php
/**
 * @package Minimalizine
 * @since Minimalizine 0.1
 */
 
get_header(); ?>

		<div id="primary" class="content-area">
			<div id="content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-meta side">
						<?php edit_post_link( __( 'Edit', 'minimalizine' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-meta -->
				
					<header class="entry-header wide">
						<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
					</header><!-- .entry-header -->

					<div class="entry-content wide">
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div id="post-pages"><span>' . __( 'Pages:', 'minimalizine' ) . '</span>', 'after' => '</div><div class="clearfix"></div>' ) ); ?>
					</div><!-- .entry-content -->
		
				</article><!-- end #post-<?php the_ID(); ?>-->
			
				<?php if ( comments_open() || '0' != get_comments_number() )
						comments_template( '', true ); ?>
				<?php endwhile; // end of the loop. ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area -->

<?php get_footer(); ?>
