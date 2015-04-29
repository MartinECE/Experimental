<li class="item format">
	<a href="<?php the_permalink(); ?>" class="post-link" title="<?php the_title(); ?>">
		<?php if ( has_post_thumbnail()) : ?>
		<figure class="effect-chico"> <!-- hover effect -->
			<?php the_post_thumbnail( 'full');  ?>
		</figure>
		<span class="fa fa-music"></span> <!-- post format icon -->
		<?php endif; ?>
	</a>

	<div class="post-holder">
		<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
		<div class="excerpt">
			<!-- get the custom field data -->
			<?php if(is_plugin_active('advanced-custom-fields/acf.php')) : ?>
				<?php $audio = get_field('wpdevshed_post_format_audio_content') ?>
				<?php $attr = array(
					'src'      => $audio,
					'loop'     => '',
					'autoplay' => '',
					'preload' => 'none'
					);
				echo wp_audio_shortcode( $attr ); ?>
			<?php endif; the_excerpt(); ?>
		</div>

		<a href="<?php the_permalink(); ?>" class="read-more">
			<?php _e( 'Read More', 'omg' ); ?>
		</a>
		<div class="date">
			<?php printf( __( 'Posted on <span class="time">%2$s</span> by ', 'omg' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format'))); ?>
			<?php the_author_posts_link(); ?>
		</div>
	</div>
</li>