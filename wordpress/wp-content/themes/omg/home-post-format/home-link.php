<li class="item format">
	<a href="<?php the_permalink(); ?>" class="post-link" title="<?php the_title(); ?>">
		<?php if ( has_post_thumbnail()): ?>
			<figure class="effect-chico"><?php the_post_thumbnail( 'full');  ?></figure>
			<span class="fa fa-link"></span>
		<?php endif ?>
	</a>

	<div class="post-holder">
		<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
		<div class="excerpt">
			<?php if(is_plugin_active('advanced-custom-fields/acf.php')) : ?>
				<p class="format-link">
					<a href="<?php echo get_field('wpdevshed_post_format_link_url'); ?>">
						<?php echo get_field('wpdevshed_post_format_link_url'); ?>
					</a>
				</p>
			<?php endif; 
			the_excerpt(); ?>
		</div>

		<a href="<?php the_permalink(); ?>" class="read-more"><?php _e( 'Read More', 'omg' ); ?></a>
		<div class="date">
			<?php printf( __( 'Posted on <span class="time">%2$s</span> by ', 'omg' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format'))); ?>
			<?php the_author_posts_link(); ?>
		</div>
	</div>
</li>