<?php
/**
 * @package Minimalizine
 * @since Minimalizine 0.1
 */
?>
		<?php get_sidebar(); ?>
	</div><!-- #main -->

	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<?php do_action( 'minimalizine_footer' ); ?>
		</div><!-- .site-info -->

		<div class="credits">
			<p><?php printf( __('Proudly powered by <a href="http://wordpress.org/" title="%1$s" rel="generator">%2$s</a><br/> Theme: Minimalizine by <a href="http://hirizh.name/" title="%3$s" rel="designer">%4$s</a>', 'minimalizine'),
				esc_attr( 'A Semantic Personal Publishing Platform'),
				'WordPress',
				esc_attr( 'Rizqy Hidayat'),
				'Rizh'
			); ?></p>
		</div><!-- end .credits -->
	</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed -->

<?php wp_footer(); ?>

</body>
</html>
