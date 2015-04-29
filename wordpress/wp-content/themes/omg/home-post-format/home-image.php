<li class="item format">
	<?php $image = omg_catch_that_image(); if(!empty($image)) : ?> <!-- get the image -->
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="post-link">
			<figure class="effect-chico"> <!-- hover effect -->
			<?php echo $image; ?>
			</figure>
			<span class="fa fa-picture-o"></span> <!-- post format icon -->
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