<?php get_header(); ?>

			<div id="content">
				<header class="article-header">
					<div id="inner-content" class="wrap cf">
								<h1><?php _e( 'Epic 404 - Article Not Found', 'omg' ); ?></h1>
					</div>
				</header>
				<div id="inner-content" class="wrap cf">
					
					<div id="main" class="m-all t-2of3 d-5of7 cf" role="main">

						<article id="post-not-found" class="hentry cf full">


							<section class="entry-content">

								<p><?php _e( 'The article you were looking for was not found. You may want to check your link or perhaps that page does not exist anymore.', 'omg' ); ?></p>

							</section>

							<section class="search">

									<p><?php get_search_form(); ?></p>

							</section>

						</article>

					</div>

				</div>

			</div>

<?php get_footer(); ?>
