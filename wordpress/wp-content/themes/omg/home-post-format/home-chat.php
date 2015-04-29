<li class="item format">
	<a href="<?php the_permalink(); ?>" class="post-link" title="<?php the_title(); ?>">
		<figure class="effect-chico"> <!-- hover effect -->
			<?php if ( has_post_thumbnail()) :
				the_post_thumbnail( 'full');  
			endif; ?> 
		</figure>
		<span class="fa fa-weixin"></span> <!-- post format icon -->
	</a>

	<div class="post-holder">
		<a href="<?php the_permalink(); ?>"><h2><?php the_title(); ?></h2></a>
		<!-- get the custom field data -->
		<?php if(is_plugin_active('advanced-custom-fields/acf.php')) : ?>
			<div class="chat-content"><?php echo get_field('wpdevshed_post_format_chat_content'); ?></div>
		<?php else: ?>
			<div class="excerpt">
				<?php the_excerpt(); ?>
			</div> 
		<?php endif; ?>

		<a href="<?php the_permalink(); ?>" class="read-more">
			<?php _e( 'Read More', 'omg' ); ?>
		</a>
		<div class="date">
			<?php printf( __( 'Posted on <span class="time">%2$s</span> by ', 'omg' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format'))); ?>
			<?php the_author_posts_link(); ?>
		</div>
	</div>
</li>