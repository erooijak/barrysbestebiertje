<?php
/**
 * The template for displaying image attachments.
 *
 * @package Minimalizine
 * @since Minimalizine 0.4
 */

get_header();
?>

		<div id="primary" class="content-area image-attachment">
			<div id="content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="entry-meta side">
						<?php
							$metadata = wp_get_attachment_metadata();
							printf( __( '<span class="posted-on"><time class="entry-date" datetime="%1$s" pubdate>%2$s</time></span><span class="download-link"><a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a></span><span class="gallery-link"><a href="%6$s" title="Return to %7$s" rel="gallery">%7$s</a></span>', 'minimalizine' ),
								esc_attr( get_the_date( 'c' ) ),
								esc_html( get_the_date() ),
								wp_get_attachment_url(),
								$metadata['width'],
								$metadata['height'],
								get_permalink( $post->post_parent ),
								get_the_title( $post->post_parent )
							);
						?>
						<?php if ( comments_open() && pings_open() ) : // Comments and trackbacks open ?>
							<?php printf( __( '<span class="comments-link"><a class="comment-link" href="#respond" title="Leave a comment">Leave a comment</a> or <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">leave a trackback</a></span>', 'minimalizine' ), get_trackback_url() ); ?>
						<?php elseif ( ! comments_open() && pings_open() ) : // Only trackbacks open ?>
							<?php printf( __( '<span class="comments-link"><a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Leave a trackback</a></span>', 'minimalizine' ), get_trackback_url() ); ?>
						<?php elseif ( comments_open() && ! pings_open() ) : // Only comments open ?>
							<?php _e( '<span class="comments-link"><a class="comment-link" href="#respond" title="Leave a comment">Leave a comment</a></span>', 'minimalizine' ); ?>
						<?php elseif ( ! comments_open() && ! pings_open() ) : // Comments and trackbacks closed ?>
							<?php _e( '<span class="comments-link">Both comments and trackbacks are currently closed</span>', 'minimalizine' ); ?>
						<?php endif; ?>
						<?php edit_post_link( __( 'Edit', 'minimalizine' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-meta -->
					<header class="entry-header wide">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content wide">

						<div class="entry-attachment">
							<div class="attachment">
								<?php
									/**
									 * Grab the IDs of all the image attachments in a gallery so we can get the URL of the next adjacent image in a gallery,
									 * or the first image (if we're looking at the last image in a gallery), or, in a gallery of one, just the link to that image file
									 */
									$attachments = array_values( get_children( array( 'post_parent' => $post->post_parent, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID' ) ) );
									foreach ( $attachments as $k => $attachment ) {
										if ( $attachment->ID == $post->ID )
											break;
									}
									$k++;
									// If there is more than 1 attachment in a gallery
									if ( count( $attachments ) > 1 ) {
										if ( isset( $attachments[ $k ] ) )
											// get the URL of the next image attachment
											$next_attachment_url = get_attachment_link( $attachments[ $k ]->ID );
										else
											// or get the URL of the first image attachment
											$next_attachment_url = get_attachment_link( $attachments[ 0 ]->ID );
									} else {
										// or, if there's only 1 image, get the URL of the image
										$next_attachment_url = wp_get_attachment_url();
									}
								?>

								<a href="<?php echo $next_attachment_url; ?>" title="<?php echo esc_attr( get_the_title() ); ?>" rel="attachment"><?php
									$attachment_size = apply_filters( 'minimalizine_attachment_size', array( 1200, 1200 ) ); // Filterable image size.
									echo wp_get_attachment_image( $post->ID, $attachment_size );
								?></a>
							</div><!-- .attachment -->

							<?php if ( ! empty( $post->post_excerpt ) ) : ?>
							<div class="entry-caption">
								<?php the_excerpt(); ?>
							</div><!-- .entry-caption -->
							<?php endif; ?>
						</div><!-- .entry-attachment -->

						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'minimalizine' ), 'after' => '</div>' ) ); ?>
						
						<h3 class="attachment-more"><?php _e( 'More from this gallery', 'minimalizine' ); ?></h3>
						<div id="attachment-nav">
							<?php
							$post_parent = get_post($post->ID, ARRAY_A);
							$parent = $post_parent['post_parent'];
							$attachments = get_children("post_parent=$parent&post_type=attachment&post_mime_type=image&orderby=menu_order ASC, ID ASC");
							foreach($attachments as $id => $attachment) :
								echo wp_get_attachment_link($id, array(100,100), true);
							endforeach;
							?>
						</div><!-- end .attachment-navigation -->					
					</div><!-- .entry-content -->
				</article><!-- #post-<?php the_ID(); ?> -->

				<?php comments_template(); ?>

			<?php endwhile; // end of the loop. ?>

			</div><!-- #content .site-content -->
		</div><!-- #primary .content-area .image-attachment -->

<?php get_footer(); ?>
