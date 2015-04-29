<?php get_header(); ?>

			<div id="content">
				
				<div id="inner-content" class=" cf">
						
					<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">
						<div class="wrap cf">
						<header class="article-header">
							
								<h1 class="entry-title single-title"><?php the_title(); ?></h1>

						</header> <?php // end article header ?>

							<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<div id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> >
								<div class="entry-content cf">
									<?php

										the_content();

										wp_link_pages( array(
											'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'omg' ) . '</span>',
											'after'       => '</div>',
											'link_before' => '<span>',
											'link_after'  => '</span>',
										) );
									?>
								</div> <?php // end article section ?>

								

								<?php comments_template(); ?>

							</div>

							<?php endwhile; else : ?>

									<article id="post-not-found" class="hentry cf">
										<header class="article-header">
											<h1><?php _e( 'Oops, Nothing Found!', 'omg' ); ?></h1>
											<p><?php _e( 'Apologies, but no entries were found.', 'omg' ); ?></p>
										</header>
									</article>

							<?php endif; ?>

						</div>
						</div>
						<?php get_sidebar('page'); ?>

				</div>

			</div>

<?php get_footer(); ?>