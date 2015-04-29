<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
    $featured_img = wp_get_attachment_url(get_post_thumbnail_id($post->ID));
    endwhile;
    endif;
 ?>

<div id="wrap" class="main-wrap" style="<?php if(has_post_thumbnail()){ ?>
				                background: url('<?php echo $featured_img; ?>') no-repeat 100% 100% fixed;"
				            <?php } else{ ?>
				                
				            <?php } ?>	>

  <div id="content">