<?php get_header(); ?>

			<div id="content">
				<div id="inner-content" class=" cf">
				
				<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">

						<div class="wrap cf">

							<header class="article-header">
								<h1 class="archive-title"><span><?php _e( 'Search Results for:', 'omg' ); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>
							</header>

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf archive' ); ?> role="article">
								<?php if ( has_post_thumbnail()): ?> 
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="image"> <?php
										$thumb_id = get_post_thumbnail_id();
										$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'omg-thumb-image-300by300', true);
										$thumb_url = $thumb_url_array[0]; ?> 
										<figure class="effect-chico">
											<img src="<?php echo $thumb_url; ?>" > 
										</figure>
									</a>
									
								<?php else: ?>
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="no-image"><p>No Featured Image</p></a>

								<?php endif; ?>
								<section class="entry-content cf">

									<h3 class="h2 entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
									<p class="byline vcard">
										 <?php printf( __( 'Posted on <span class="time">%2$s</span> by <span class="author">%3$s</span>', 'omg' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), get_the_author_link( get_the_author_meta( 'ID' ) )); ?>
									</p>

									<?php the_excerpt(); ?>

								</section>

							</article>

							<?php endwhile; ?>

									<?php omg_page_navi(); ?>

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
