<?php
/**
 * @package Minimalizine
 * @since Minimalizine 0.1
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<article id="post-0" class="post error404 not-found hentry">
				<header class="entry-header wide">
					<h2 class="entry-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'minimalizine' ); ?></h2>
				</header><!-- .entry-header -->

				<div class="entry-content wide">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'minimalizine' ); ?></p>

					<?php get_search_form(); ?>

				</div><!-- .entry-content -->
			</article><!-- #post-0 .post .error404 .not-found -->
		
		</div><!-- #content .site-content -->
	</div><!-- #primary .content-area -->

<?php get_footer(); ?>
