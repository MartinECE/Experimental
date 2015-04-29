<?php
// LOAD omg CORE (if you remove this, the theme will break)
require_once( 'library/omg.php' );

// USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
//require_once( 'library/custom-post-type.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

function omg_ahoy() {

  // let's get language support going, if you need it
  load_theme_textdomain( 'omg', get_template_directory() . '/library/translation' );


  // A better title
  add_filter( 'wp_title', 'omg_rw_title', 10, 3 );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'omg_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'omg_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'use_default_gallery_style', '__return_false' ); 

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'omg_scripts_and_styles');
  // ie conditional wrapper

  // launching this stuff after theme setup
  omg_theme_support();

  // adding sidebars to WordPress (these are created in functions.php)
  add_action( 'widgets_init', 'omg_register_sidebars' );

  // cleaning up random code around images
  add_filter( 'the_content', 'omg_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'omg_excerpt_more' );

  /************* OEMBED SIZE OPTIONS *************/

  if ( ! isset( $content_width ) ) {
    $content_width = 640;
  }

} /* end omg ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'omg_ahoy' );

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'omg-thumb-600', 600, 150, true );
add_image_size( 'omg-thumb-300', 300, 100, true );
add_image_size( 'omg-slider-image', 1280, 500, true );
add_image_size( 'omg-thumb-image-300by300', 300, 300, true );


add_filter( 'image_size_names_choose', 'omg_custom_image_sizes' );
function omg_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'omg-thumb-600' => '600px by 150px',
        'omg-thumb-300' => '300px by 100px',
        'omg-slider-image' => '1280px by 500px'
    ) );
}

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function omg_register_sidebars() {
  register_sidebar(array(
    'id' => 'sidebar1',
    'name' => __( 'Posts Sidebar', 'omg' ),
    'description' => __( 'The Posts sidebar.', 'omg' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));

  register_sidebar(array(
    'id' => 'sidebar2',
    'name' => __( 'Page Sidebar', 'omg' ),
    'description' => __( 'The Page sidebar.', 'omg' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));

  register_sidebar(array(
    'id' => 'sidebar3',
    'name' => __( 'Menu Widget Area', 'omg' ),
    'description' => __( 'The Menu Widget Area.', 'omg' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h4 class="widgettitle">',
    'after_title' => '</h4>',
  ));


} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function omg_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="//www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=100" class="load-gravatar avatar avatar-48 photo" height="100" width="100" src="" alt="gravatar" />
        <?php // end custom gravatar call ?>
      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'omg' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'omg' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'omg' ),'  ','') ) ?>
        <br>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'omg' )); ?> </a></time>
        <?php comment_text() ?>
        <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
      </section>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!



/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function omg_fonts() {
  wp_enqueue_style('omg_raleway_fonts', get_template_directory_uri() . '/fonts/fonts.css');
}

add_action('wp_print_styles', 'omg_fonts');

/*******************************************************************
* These are settings for the Theme Customizer in the admin panel. 
*******************************************************************/
if ( ! function_exists( 'omg_theme_customizer' ) ) :
  function omg_theme_customizer( $wp_customize ) {
    
    $wp_customize->remove_section( 'title_tagline');
    $wp_customize->remove_section( 'static_front_page' );
  
  
    /* color scheme option */
    $wp_customize->add_setting( 'omg_color_settings', array (
      'default' => '#222222',
      'sanitize_callback' => 'sanitize_hex_color',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'omg_color_settings', array(
      'label'    => __( 'Primary Color Scheme', 'omg' ),
      'section'  => 'colors',
      'settings' => 'omg_color_settings',
    ) ) );

    $wp_customize->add_setting( 'omg_color_settings_2', array (
      'default' => '#656565',
      'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'omg_color_settings_2', array(
      'label'    => __( 'Secondary Color Scheme', 'omg' ),
      'section'  => 'colors',
      'settings' => 'omg_color_settings_2',
    ) ) );

    $wp_customize->add_setting( 'omg_color_settings_3', array (
      'default' => '#309DC1',
      'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'omg_color_settings_3', array(
      'label'    => __( 'Button and link Color Scheme', 'omg' ),
      'section'  => 'colors',
      'settings' => 'omg_color_settings_3',
    ) ) );

    
    /* logo option */
    $wp_customize->add_section( 'omg_logo_section' , array(
      'title'       => __( 'Site Logo', 'omg' ),
      'priority'    => 1,
      'description' => __( 'Upload a logo to replace the default site name in the header', 'omg' ),
    ) );
    
    $wp_customize->add_setting( 'omg_logo', array(
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'omg_logo', array(
      'label'    => __( 'Choose your logo (ideal width is 100-350px and ideal height is 35-40)', 'omg' ),
      'section'  => 'omg_logo_section',
      'settings' => 'omg_logo',
    ) ) );
  
    /* favicon option */
    $wp_customize->add_section( 'omg_favicon_section' , array(
      'title'       => __( 'Site favicon', 'omg' ),
      'priority'    => 2,
      'description' => __( 'Upload a favicon', 'omg' ),
    ) );
    
    $wp_customize->add_setting( 'omg_favicon', array(
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'omg_favicon', array(
      'label'    => __( 'Choose your favicon (ideal width and height is 16x16 or 32x32)', 'omg' ),
      'section'  => 'omg_favicon_section',
      'settings' => 'omg_favicon',
    ) ) );
    
    /* social media option */
    $wp_customize->add_section( 'omg_social_section' , array(
      'title'       => __( 'Social Media Icons', 'omg' ),
      'priority'    => 32,
      'description' => __( 'Optional media icons in the header', 'omg' ),
    ) );
    
    $wp_customize->add_setting( 'omg_facebook', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'omg_facebook', array(
      'label'    => __( 'Enter your Facebook url', 'omg' ),
      'section'  => 'omg_social_section',
      'settings' => 'omg_facebook',
      'priority'    => 101,
    ) ) );
  
    $wp_customize->add_setting( 'omg_twitter', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'omg_twitter', array(
      'label'    => __( 'Enter your Twitter url', 'omg' ),
      'section'  => 'omg_social_section',
      'settings' => 'omg_twitter',
      'priority'    => 102,
    ) ) );
    
    $wp_customize->add_setting( 'omg_google', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'omg_google', array(
      'label'    => __( 'Enter your Google+ url', 'omg' ),
      'section'  => 'omg_social_section',
      'settings' => 'omg_google',
      'priority'    => 103,
    ) ) );
    
    $wp_customize->add_setting( 'omg_pinterest', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'omg_pinterest', array(
      'label'    => __( 'Enter your Pinterest url', 'omg' ),
      'section'  => 'omg_social_section',
      'settings' => 'omg_pinterest',
      'priority'    => 104,
    ) ) );
    
    $wp_customize->add_setting( 'omg_linkedin', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'omg_linkedin', array(
      'label'    => __( 'Enter your Linkedin url', 'omg' ),
      'section'  => 'omg_social_section',
      'settings' => 'omg_linkedin',
      'priority'    => 105,
    ) ) );
    
    $wp_customize->add_setting( 'omg_youtube', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'omg_youtube', array(
      'label'    => __( 'Enter your Youtube url', 'omg' ),
      'section'  => 'omg_social_section',
      'settings' => 'omg_youtube',
      'priority'    => 106,
    ) ) );
    
    $wp_customize->add_setting( 'omg_tumblr', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'omg_tumblr', array(
      'label'    => __( 'Enter your Tumblr url', 'omg' ),
      'section'  => 'omg_social_section',
      'settings' => 'omg_tumblr',
      'priority'    => 107,
    ) ) );
    
    $wp_customize->add_setting( 'omg_instagram', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'omg_instagram', array(
      'label'    => __( 'Enter your Instagram url', 'omg' ),
      'section'  => 'omg_social_section',
      'settings' => 'omg_instagram',
      'priority'    => 108,
    ) ) );
    
    $wp_customize->add_setting( 'omg_flickr', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'omg_flickr', array(
      'label'    => __( 'Enter your Flickr url', 'omg' ),
      'section'  => 'omg_social_section',
      'settings' => 'omg_flickr',
      'priority'    => 109,
    ) ) );
    
    $wp_customize->add_setting( 'omg_vimeo', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'omg_vimeo', array(
      'label'    => __( 'Enter your Vimeo url', 'omg' ),
      'section'  => 'omg_social_section',
      'settings' => 'omg_vimeo',
      'priority'    => 110,
    ) ) );
    
    $wp_customize->add_setting( 'omg_rss', array (
      'sanitize_callback' => 'esc_url_raw',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'omg_rss', array(
      'label'    => __( 'Enter your RSS url', 'omg' ),
      'section'  => 'omg_social_section',
      'settings' => 'omg_rss',
      'priority'    => 112,
    ) ) );
    
    $wp_customize->add_setting( 'omg_email', array (
      'sanitize_callback' => 'sanitize_email',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'omg_email', array(
      'label'    => __( 'Enter your email address', 'omg' ),
      'section'  => 'omg_social_section',
      'settings' => 'omg_email',
      'priority'    => 113,
    ) ) );
    
    /* slider options */
    
    $wp_customize->add_section( 'omg_slider_section' , array(
      'title'       => __( 'Slider Options', 'omg' ),
      'priority'    => 33,
      'description' => __( 'Adjust the behavior of the image slider.', 'omg' ),
    ) );
    
    $wp_customize->add_setting( 'omg_slider_effect', array(
      'default' => 'scrollHorz',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control( 'effect_select_box', array(
      'settings' => 'omg_slider_effect',
      'label' => __( 'Select Effect:', 'omg' ),
      'section' => 'omg_slider_section',
      'type' => 'select',
      'choices' => array(
        'scrollHorz' => __( 'Horizontal (Default)', 'omg' ),
        'scrollVert' => __( 'Vertical', 'omg' ),
        'tileSlide' => __( 'Tile Slide', 'omg' ),
        'tileBlind' => __( 'Blinds', 'omg' ),
        'shuffle' => __( 'Shuffle', 'omg' ),
      ),
    ));
    
    $wp_customize->add_setting( 'omg_slider_timeout', array (
      'sanitize_callback' => 'omg_sanitize_integer',
    ) );
    
    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'omg_slider_timeout', array(
      'label'    => __( 'Autoplay Speed in Seconds', 'omg' ),
      'section'  => 'omg_slider_section',
      'settings' => 'omg_slider_timeout',
    ) ) );

     /* author bio in posts option */
    $wp_customize->add_section( 'omg_author_bio_section' , array(
      'title'       => __( 'Disable Author Bio', 'omg' ),
      'priority'    => 35,
      'description' => __( 'Option to disable the author bio in the posts.', 'omg' ),
    ) );
    
    $wp_customize->add_setting( 'omg_author_bio', array (
      'sanitize_callback' => 'omg_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control('author_bio', array(
      'settings' => 'omg_author_bio',
      'label' => __('Disable the Author Bio?', 'omg'),
      'section' => 'omg_author_bio_section',
      'type' => 'checkbox',
    ));

    /* related posts option */
    $wp_customize->add_section( 'omg_related_posts_section' , array(
      'title'       => __( 'Disable Related Posts', 'omg' ),
      'priority'    => 36,
      'description' => __( 'Option to disable the related posts in the posts.', 'omg' ),
    ) );
    
    $wp_customize->add_setting( 'omg_related_posts', array (
      'sanitize_callback' => 'omg_sanitize_checkbox',
    ) );
    
    $wp_customize->add_control('related_posts', array(
      'settings' => 'omg_related_posts',
      'label' => __('Disable the Related Posts?', 'omg'),
      'section' => 'omg_related_posts_section',
      'type' => 'checkbox',
    ));
    
    $wp_customize->remove_section( 'nav');  
  }
endif;
add_action('customize_register', 'omg_theme_customizer');


/**
 * Sanitize checkbox
 */
if ( ! function_exists( 'omg_sanitize_checkbox' ) ) :
  function omg_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
      return 1;
    } else {
      return '';
    }
  }
endif;


/**
 * Sanitize integer input
 */
if ( ! function_exists( 'omg_sanitize_integer' ) ) :
  function omg_sanitize_integer( $input ) {
    return absint($input);
  }
endif;
/**
* Apply Color Scheme
*/

function omg_apply_color() {
    if ( get_theme_mod('omg_color_settings') ) {
  ?>
  <style>
      .blog-list .item h2,.pagination .current,.article-header h1,body .info p.author,body .related h3, body #comments-title,body .related ul li .related-info h3
      ,body cite.fn,body .comment-reply-title,.sidebar .widgettitle,.sidebar .widget #wp-calendar td#today,article.archive .entry-content h3 a
      {color: <?php echo get_theme_mod('omg_color_settings'); ?>;}
      body .pagination li:first-child {border: 2px solid <?php echo get_theme_mod('omg_color_settings'); ?>;}
  </style>
  <?php
    }
     if ( get_theme_mod('omg_color_settings_2') ) { ?>
     <style>
      .blog-list .item .excerpt p,.blog-list .item .date,.blog-list .item time,.entry-content p,body .byline,body .info p.author-desc,
       body .related ul li .related-info p,body .comment time a,body .comment_content p,#sidebar1 .widget ul li,body #sidebar1 a,#sideba1 .widget #wp-calendar td
      {color: <?php echo get_theme_mod('omg_color_settings_2'); ?>;}
     </style>

    <?php }

    if ( get_theme_mod('omg_color_settings_3') ) { ?>
      <style>
        .blog-list .item a.read-more,button, html input[type="button"], input[type="reset"], input[type="submit"],.widget #wp-calendar caption,.blue-btn, .comment-reply-link, #submit
        {background:<?php echo get_theme_mod('omg_color_settings_3'); ?>; }
        .entry-content p a,body .pagination li a,.blog-list .item a[rel="author"],body .byline a,body .info p.author-desc a,
        body .related ul li a,body .comment-reply-link
        {color: <?php echo get_theme_mod('omg_color_settings_3'); ?>;}
      </style>
    <?php }
    
  }
add_action( 'wp_head', 'omg_apply_color' );

/*-----------------------------------------------------------------------------------*/
/* custom functions below */
/*-----------------------------------------------------------------------------------*/
define( 'NO_HEADER_TEXT', true );
define('THEMEURL', get_template_directory_uri());
define('IMAGES', THEMEURL.'/images'); 
define('JS', THEMEURL.'/js');
define('CSS', THEMEURL.'/css');

if(is_user_logged_in()){
  add_action( 'wp_head', 'omg_user_login' );
  function omg_user_login(){ ?>
    <style>#main-navigation{top: 30px!important;}</style>
    <?php
  }
}

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
add_filter( 'post_thumbnail_html', 'omg_remove_thumbnail_dimensions', 10, 3 );
function omg_remove_thumbnail_dimensions( $html, $post_id, $post_image_id ) {
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
    return $html;
}

function omg_paginate() {
global $wp_query, $wp_rewrite;
$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;

$pagination = array(
    'format' => '',
    'total' => $wp_query->max_num_pages,
    'current' => $current,
    'show_all' => true,
    'type' => 'list',
    'next_text' => '&raquo;',
    'prev_text' => '&laquo;'
    );

if( $wp_rewrite->using_permalinks() )
    $pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 'page', get_pagenum_link( 1 ) ) ) . '?page=%#%/', 'paged' );

if( !empty($wp_query->query_vars['s']) )
    $pagination['add_args'] = array( 's' => get_query_var( 's' ) );

echo paginate_links( $pagination );
}

/*remove br tags*/
add_filter( 'the_content', 'omg_remove_br_gallery', 11, 2);
function omg_remove_br_gallery($output) {
    return preg_replace('/<br style=(.*)>/mi','',$output);
}

/*get the author excerpt*/
function omg_author_excerpt() {
      $text_limit = 50; //Words to show in author bio excerpt
      $read_more  = __( 'Read More', 'omg' ); //Read more text
      $end_of_txt = "...";
      $url_of_author  = get_author_posts_url(get_the_author_meta('ID'));
      $short_desc_author = wp_trim_words(strip_tags(
                          get_the_author_meta('description')), $text_limit, 
                          $end_of_txt.'<br/>
                        <a href="'.$url_of_author.'" style="font-weight:bold;">'.$read_more .'</a>');

      return $short_desc_author;
}

/* catch the image inside a post */
function omg_catch_that_image() {
  global $post;
  $pattern = '|<img.*?class="([^"]+)".*?/>|';
  $transformed_content = apply_filters('the_content',$post->post_content);
  preg_match($pattern,$transformed_content,$matches);
  if (!empty($matches[1])) {
    $classes = explode(' ',$matches[1]);
    $id = preg_grep('|^wp-image-.*|',$classes);
    if (!empty($id)) {
      $id = str_replace('wp-image-','',$id);
      if (!empty($id)) {
        $id = reset($id);
        $transformed_content = wp_get_attachment_image($id,'full');  
        return $transformed_content;
      }
    }
  }
  
}

/* catch the image inside a post */
function omg_catch_that_image_thumb() {
  global $post;
  $pattern = '|<img.*?class="([^"]+)".*?/>|';
  $transformed_content = apply_filters('the_content',$post->post_content);
  preg_match($pattern,$transformed_content,$matches);
  if (!empty($matches[1])) {
    $classes = explode(' ',$matches[1]);
    $id = preg_grep('|^wp-image-.*|',$classes);
    if (!empty($id)) {
      $id = str_replace('wp-image-','',$id);
      if (!empty($id)) {
        $id = reset($id);
        $transformed_content = wp_get_attachment_image($id,'thumbnail');  
         return $transformed_content;
      }
    }
  }
 
}

/* catch the first image in a gallery*/
function omg_catch_gallery_image_full()  { 
    global $post;
    $gallery = get_post_gallery( $post, false );
    if ( !empty($gallery['ids']) ) {
      $ids = explode( ",", $gallery['ids'] );
      $total_images = 0;
      foreach( $ids as $id ) {
        
        $image  = wp_get_attachment_image( $id, 'full');
        $total_images++;
        
        if ($total_images == 1) {
          $first_img = $image;
          return $first_img;
        }
      }
    } 
}

/* catch the first image in a gallery*/
function omg_catch_gallery_image_thumb()  { 
    global $post;
    $gallery = get_post_gallery( $post, false );
    if ( !empty($gallery['ids']) ) {
      $ids = explode( ",", $gallery['ids'] );
      $total_images = 0;
      foreach( $ids as $id ) {
        
        $image  = wp_get_attachment_image( $id, 'thumbnail');
        $total_images++;
        
        if ($total_images == 1) {
          $first_img = $image;
          return $first_img;
        }
      }
    } 
}

/* social icons*/
function omg_social_icons()  { 
  
  $social_networks = array(
      "omg_facebook" => "fa-facebook", "omg_twitter" => "fa-twitter", "omg_google" => "fa-google-plus",
      "omg_pinterest" => "fa-pinterest", "omg_linkedin" => "fa-linkedin", "omg_youtube" => "fa-youtube",
      "omg_tumblr" => "fa-tumblr", "omg_instagram" => "fa-instagram", "omg_flickr" => "fa-flickr",
      "omg_vimeo" => "fa-vimeo-square", "omg_rss" => "fa-rss", "omg_email" => "fa-envelope"
  );

  foreach ($social_networks as $key => $icon) {
     
      if (get_theme_mod( $key )){ ?>
       <a href="<?php echo esc_url( get_theme_mod($key) ); ?>" class="social-tw" title="<?php echo esc_url( get_theme_mod( $key ) ); ?>" target="_blank"><i class="fa <?php echo $icon; ?>"></i></a>
      <?php }
  }


}

/**
 * Include the TGM_Plugin_Activation class.
 */
require_once get_template_directory() . '/library/class/class-tgm-plugin-activation.php';

add_action( 'omg_register', 'omg_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the omg library
 * and one from the .org repo.
 *
 * The variable passed to omg_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into omg_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function omg_register_required_plugins() {
 
    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
 
 
        // This is an example of how to include a plugin from the WordPress Plugin Repository.
        array(
            'name'      => 'Advanced Custom Fields',
            'slug'      => 'advanced-custom-fields',
            'required'  => false,
        ),
 
    );
 
    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'omg-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'omg' ),
            'menu_title'                      => __( 'Install Plugins', 'omg' ),
            'installing'                      => __( 'Installing Plugin: %s', 'omg' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'omg' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'omg' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'omg' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'omg' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );
 
    omg( $plugins, $config );
 
}
/* DON'T DELETE THIS CLOSING TAG */ ?>