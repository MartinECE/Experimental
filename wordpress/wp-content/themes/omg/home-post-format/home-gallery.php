<li class="item format">
	<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-link">
		<figure class="effect-chico"> <!-- hover effect -->
		<?php $first_img = omg_catch_gallery_image_full(); echo $first_img; ?> <!-- get the first gallery image -->
		</figure>
		<span class="fa fa-file-image-o"></span> <!-- post format icon -->
	</a>

	<div class="post-holder">
		<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
		<div class="excerpt">
			<?php the_excerpt(); ?>
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