<?php $options = get_option('mh_options'); ?>
<article <?php post_class(); ?>>
	<header class="post-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header>
	<div class="entry clearfix">
		<?php mh_featured_image(); ?>
		<?php the_content(); ?>
	</div>
	<?php if (has_tag()) : ?>
		<div class="post-tags meta clearfix">
        	<?php the_tags('<p class="meta-tags"><i class="fa fa-tag"></i>', ', ', '</p>'); ?>
        </div>
	<?php endif; ?>
</article>
