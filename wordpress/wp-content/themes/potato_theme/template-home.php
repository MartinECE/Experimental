<?php
/*
Template Name: Home Template
*/
?>

<div class="row">
	<div id="container" class="col-md-12">
		<ul  class="grid effect-2 list-container" id="grid">
		<?php   
                query_posts( array( 'post_type' => 'post' , 'showposts' => '-1') );
                if ( have_posts() ) : $count = 0; while ( have_posts() ) : the_post(); $count++;

              $featured_img = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
              $category = get_the_category();
		?>
		<li class="item">
			<div class="work-item flow-hide">
			<a href="<?php the_permalink(); ?>" class="general-links">
			<img src="<?php echo $featured_img; ?>"  alt="<?php the_title(); ?>" class="img-responsive"/>
						<div class="item-title"><?php the_title(); ?></div>
						<div class="item-desc"><?php the_excerpt(); ?></div>
			</a>
			</div>
		</li>
		<?php endwhile; 
		      endif;
		?>
		</ul>	

	</div>
         

    <?php wp_reset_query(); ?>

</div>