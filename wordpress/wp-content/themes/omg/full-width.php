<?php
/*
 Template Name: Full-width
 
*/
?>

<?php get_header(); ?>

	<div id="content">
		<header class="article-header">
			<div id="inner-content" class="wrap cf">
				<h1 class="page-title"><?php the_title(); ?></h1>
			</div>	
		</header>
		
		<div id="inner-content" class="wrap cf">

				<div id="main" class="m-all t-2of3 d-5of7 cf full" role="main">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class( 'cf' ); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

						<p class="byline vcard">
								<?php printf( __( 'Posted <time class="updated" datetime="%1$s" pubdate>%2$s</time> by <span class="author">%3$s</span>', 'omg' ), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), get_the_author_link( get_the_author_meta( 'ID' ) )); ?>
						</p>

						<section class="entry-content cf" itemprop="articleBody">
							<?php

								the_content();

								wp_link_pages( array(
									'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'omg' ) . '</span>',
									'after'       => '</div>',
									'link_before' => '<span>',
									'link_after'  => '</span>',
								) );
							?>
						</section>


						<?php comments_template(); ?>

					</article>

					<?php endwhile; else : ?>

							<article id="post-not-found" class="hentry cf">
									<header class="article-header">
										<h1><?php _e( 'Oops, Post Not Found!', 'omg' ); ?></h1>
										<p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'omg' ); ?></p>
									</header>
								
							</article>

					<?php endif; ?>

				</div>

				

		</div>

	</div>


<?php get_footer(); ?>
