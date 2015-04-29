<?php get_header(); ?>

	<div id="content">
		
		<div id="inner-content" class="cf">
				
			<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">

				<div class="wrap cf">

					<header class="article-header">
						
							<h1 class="entry-title single-title"><?php the_title(); ?></h1>

					</header> <?php // end article header ?>

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

						<div id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?>>
							
							<p class="byline vcard">
							  <?php printf( __( 'Posted on <span class="time">%2$s</span> by <span class="author">%3$s</span>', 'omg' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), get_the_author_link( get_the_author_meta( 'ID' ) )); ?>
							  <?php
							    /* translators: used between list items, there is a space after the comma */
							    $category_list = get_the_category_list( __( ', ', 'omg' ) );
							    printf( __('under %s', 'omg'),
							      $category_list
							    );
							  ?>
							</p>
							
							<!-- post format area -->
							<?php
								
								get_template_part( 'post-formats/format', get_post_format() );
							?>

							<?php if ( get_theme_mod('omg_author_bio') ) :
								$author_class = 'author-hide';
							else:
								$author_class = '';
							endif;
							?>

							<?php if ( get_theme_mod('omg_related_posts') ) :
								$related_class = 'related-hide';
							else:
								$related_class = '';
							endif;
							?>

							<!-- author area -->
							<footer class="article-footer <?php echo $author_class; ?>">
								<div class="avatar">
									<?php echo get_avatar( get_the_author_meta( 'ID' ) , 150 ); ?>
								</div>
							<div class="info">
								<p class="author"><span><?php _e( 'Written by', 'omg' ); ?></span> <?php the_author(); ?></p>
								<p class="author-desc"> <?php if (function_exists('omg_author_excerpt')){echo omg_author_excerpt();} ?> </p>
							</div>
							<div class="clear"></div>
							</footer> <?php // end article footer ?>

							<!-- related posts area -->
							<?php 
								$related = get_posts( array( 'category__in' => wp_get_post_categories($post->ID), 'numberposts' => 4, 'post__not_in' => array($post->ID) ) ); 
							?>
							<?php if (!empty($related)) : ?>
								<div class="related posts <?php echo $related_class; ?>">

									<h3><?php _e( 'Related Posts', 'omg' ); ?></h3>
									<div class="related-wrapper"> 
										<?php if( $related ) :
										foreach( $related as $post ) { ?>
										<?php setup_postdata($post); ?>

											<article>
												<div class="related-image">
													<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>" class="featured-image">
														<?php $image_thumb = omg_catch_that_image_thumb(); $gallery_thumb = omg_catch_gallery_image_thumb(); 
														if ( has_post_thumbnail()): 
															the_post_thumbnail('omg-thumb-image-300by300');  
														?>
															<?php elseif(has_post_format('gallery') && !empty($gallery_thumb)): 
																echo $gallery_thumb; ?>
															<?php elseif(has_post_format('image') && !empty($image_thumb)):
																echo $image_thumb; ?>
															<?php else: ?>
																<span class="no-featured-image"></span>
														<?php endif; ?>
													</a>
												</div>

												<div class="related-info">
													<h3><?php the_title(); ?></h3>
													<?php the_excerpt(); ?>
													<p class="byline vcard">
														<?php printf( __( 'Posted on <span class="time">%2$s</span> by ', 'omg' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format'))); ?>
														<?php the_author_posts_link(); ?>
													</p>
												</div>
											</article>

										<?php } endif;
										wp_reset_postdata(); ?>
								       <div class="clear"></div>
							        </div>

						       </div>
					       <?php endif; ?>


								<?php comments_template(); ?>

						</div> <?php // end article ?>

					<?php endwhile; ?>

					<?php else : ?>

						<article id="post-not-found" class="hentry cf">
								<header class="article-header">
											<h1><?php _e( 'Oops, Nothing Found!', 'omg' ); ?></h1>
											<p><?php _e( 'Apologies, but no entries were found.', 'omg' ); ?></p>
								</header>
						</article>

					<?php endif; ?>

				</div>

			</div>

			<?php get_sidebar(); ?>

		</div>

	</div>
<?php get_footer(); ?>