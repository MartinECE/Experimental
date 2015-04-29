<?php get_header(); ?>
<div class="front-wrapper">
	<div id="content">
		
		<div id="slide-wrap">
			<?php
				/*maximum number of post to show in the slider is 10*/
				$args = array('posts_per_page' => 10,'post_status' => 'publish','post__in' => get_option("sticky_posts"));
				$fPosts = new WP_Query( $args );
			?>

			<?php if ( $fPosts->have_posts() ) : ?>

				<div class="cycle-slideshow" 
					<?php /* slider effect */ ?>
					<?php if ( get_theme_mod('omg_slider_effect') ): echo 'data-cycle-fx="' . wp_kses_post( get_theme_mod('omg_slider_effect') ) . '" data-cycle-tile-count="10"'; else: echo 'data-cycle-fx="scrollHorz"'; endif; ?> 
						<?php /* slider timeout */ ?>
						data-cycle-slides="> div.slides" <?php if ( get_theme_mod('omg_slider_timeout') ): $slider_timeout = wp_kses_post( get_theme_mod('omg_slider_timeout') ); echo 'data-cycle-timeout="' . $slider_timeout . '000"'; else: echo 'data-cycle-timeout="5000"'; endif; ?> 
							<?php /* slider previous and next ID */ ?>
							data-cycle-prev="#sliderprev" data-cycle-next="#slidernext">

					<?php while ( $fPosts->have_posts() ) : $fPosts->the_post();  ?>

						<div class="slides">
						  <div id="post-<?php the_ID(); ?>" <?php post_class('post-theme'); ?>>

						    <?php 
						    	$image_full = omg_catch_that_image(); /* get the image inside a post */
						    	$gallery_full = omg_catch_gallery_image_full(); /* get the first gallery image inside a post */
						    ?>
						    
						    <?php if ( has_post_thumbnail()): ?>

						        <div class="slide-thumb">
						        	<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
						        		<?php the_post_thumbnail( "full" ); ?>
						        	</a>
						        	<div class="bg-overlay"></div>
						        </div>

						    <?php elseif(has_post_format('image') && !empty($image_full)):  ?>

								<div class="slide-thumb">
									<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
										<?php echo $image_full; ?>
									</a>
									<div class="bg-overlay"></div>
								</div>

						    <?php elseif(has_post_format('gallery') && !empty($gallery_full)): ?>  

						     	<div class="slide-thumb">
						     		<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
						     			<?php echo $gallery_full; ?>
						     		</a>
						     		<div class="bg-overlay"></div>
						     	</div>

						    <?php else: ?>
								<div class="slide-noimg">
									<p><?php _e('No featured image set for this post.', 'omg') ?></p>
									<div class="bg-overlay"></div>
								</div>
						        
						    <?php endif; ?>

						  </div>

						<!-- slide content area -->
						<div class="slide-copy-wrap">
							<div class="table">
								<div class="table-cell"> 
									<div class="slide-copy">
									<h2 class="slide-title"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Read %s', 'omg' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
									<?php the_excerpt(); ?>
									</div>
								</div>
							</div>
						</div>

						</div>

					<?php endwhile; ?>
						<!-- slide next/prev button -->
						<div class="slidernav">
							<a id="sliderprev" href="#" title="<?php _e('Previous', 'omg'); ?>"><?php _e('&#9664;', 'omg'); ?></a>
							<a id="slidernext" href="#" title="<?php _e('Next', 'omg'); ?>"><?php _e('&#9654;', 'omg'); ?></a>
						</div>

				</div>
				<?php endif; ?>

				<?php wp_reset_postdata(); ?>

		</div> <!-- slider-wrap -->
		
		<!-- list of blog area -->
		<ul class="blog-list" id='masonry'>

				<!-- display posts except sticky posts -->
				<?php $args2= array('post__not_in' => get_option( 'sticky_posts' ) ,'paged' => $paged);
				$blogPosts = new WP_Query( $args2 ); ?>
				<?php while ( $blogPosts -> have_posts() ) : $blogPosts -> the_post(); ?>
  						<?php get_template_part( 'home-post-format/home', get_post_format() ); ?>
  				<?php endwhile;  ?>
 				

		</ul>
		<div class="clear"></div>
		<!-- list of blog area -->
		
		<?php  omg_page_navi(); ?>
		<?php wp_reset_postdata(); ?>
	</div> <!-- content -->
</div><!-- front-wrapper -->

<?php get_footer(); ?>