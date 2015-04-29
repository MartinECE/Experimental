<li class="item format">
	<?php if(is_plugin_active('advanced-custom-fields/acf.php') && get_field('wpdevshed_post_format_embed_video')) : ?>
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-link">
			<?php echo get_field('wpdevshed_post_format_embed_video'); ?>
			<span class="fa fa-play"></span>
		</a>
	<?php endif; ?>

	<div class="post-holder">
		<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
		<div class="excerpt">
			<?php the_excerpt(); ?>
		</div>
		<a href="<?php the_permalink(); ?>" class="read-more"><?php _e( 'Read More', 'omg' ); ?></a>
		<div class="date">
			<?php printf( __( 'Posted on <span class="time">%2$s</span> by ', 'omg' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format'))); ?>
			<?php the_author_posts_link(); ?>
		</div>
	</div>
</li>