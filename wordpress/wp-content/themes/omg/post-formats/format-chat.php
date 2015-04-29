<section class="entry-content cf">

  <?php if(is_plugin_active('advanced-custom-fields/acf.php')) : ?>
    <div class="chat-content"><?php echo get_field('wpdevshed_post_format_chat_content'); ?></div>
  <?php endif; ?>

  <?php

    the_content();

    wp_link_pages( array(
    'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'omg' ) . '</span>',
    'after'       => '</div>',
    'link_before' => '<span>',
    'link_after'  => '</span>',
    ) );
  ?>
</section> <?php // end article section ?>