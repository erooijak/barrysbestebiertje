<?php
/**
 * @package Minimalizine
 * @since Minimalizine 0.1
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header wide">
				<h3 class="page-title"><?php printf( __( 'Search Results for: %s', 'minimalizine' ), '<span>' . get_search_query() . '</span>' ); ?></h3>
			</header><!-- .page-header -->
			<div class="clearfix"></div>

			<?php while ( have_posts() ) : the_post();
				get_template_part( 'content', get_post_format() );
			endwhile;

			minimalizine_content_nav();
		else :
			get_template_part( 'no-results', 'search' );
		endif; ?>

		</div><!-- #content.site-content -->
	</div><!-- #primary.content-area -->

<?php get_footer(); ?>
