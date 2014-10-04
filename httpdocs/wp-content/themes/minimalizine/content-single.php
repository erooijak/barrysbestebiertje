<?php
/**
 * @package Minimalizine
 * @since Minimalizine 0.4
 */
?>
 
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-meta side">
			<?php if ( has_post_format( 'image' ) || has_post_format( 'video' ) || has_post_format( 'aside' ) || has_post_format( 'quote' ) || has_post_format( 'link' ) ) : ?>
				<span class="post-format">
					<a class="entry-format" href="<?php echo esc_url( get_post_format_link( get_post_format() ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'All %s posts', 'minimalizine' ), get_post_format_string( get_post_format() ) ) ); ?>"><?php echo get_post_format_string( get_post_format() ); ?></a>
				</span>
			<?php endif; //has_post_formats() ?>
			
			<span class="posted-on">
				<?php minimalizine_posted_on(); ?>
			</span>
			
			<?php
				/* translators: used between list items, there is a space after the comma */
				$categories_list = get_the_category_list( __( ', ', 'minimalizine' ) );
				if ( $categories_list ) :
			?>
			<span class="cat-links">
				<?php echo $categories_list; ?>
			</span>
			<?php endif; // End if categories ?>

			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ', ', 'minimalizine' ) );
				if ( $tags_list ) :
			?>
			<span class="tags-links">
				<?php echo $tags_list; ?>
			</span>
			<?php endif; // End if $tags_list ?>

			<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
			<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'minimalizine' ), __( '1 Comment', 'minimalizine' ), __( '% Comments', 'minimalizine' ) ); ?></span>
			<?php endif; ?>

			<?php edit_post_link( __( 'Edit', 'minimalizine' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
		
		<header class="entry-header wide">
			<?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
			<?php if ( '' != get_the_post_thumbnail() ) : ?>
				<div class="entry-thumbnail">
					<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'minimalizine' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_post_thumbnail( 'post-thumbnail' ); ?></a>
				</div>
			<?php endif; //if get_the_post_thumbnail() ?>
		</header><!-- .entry-header -->
	
		<div class="entry-content wide">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div id="post-pages"><span>' . __( 'Pages:', 'minimalizine' ) . '</span>', 'after' => '</div><div class="clearfix"></div>' ) ); ?>
		</div><!-- .entry-content -->
	</article><!-- end #post-<?php the_ID(); ?>-->
