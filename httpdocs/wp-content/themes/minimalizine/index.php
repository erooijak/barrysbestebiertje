<?php
/**
 * @package Minimalizine
 * @since Minimalizine 0.1
 */
 
get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php if ( have_posts() ) :

				while ( have_posts() ) : the_post();
					get_template_part( 'content', get_post_format() );
				endwhile;
				
				minimalizine_content_nav();
			else :

				get_template_part( 'no-results', 'index' );

			endif; ?>

		</div><!-- #content.site-content -->
	</div><!-- #primary.content-area -->

<?php get_footer(); ?>
