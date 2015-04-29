<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <!--[if lt IE 8]>
    <div class="alert alert-warning">
      <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
    </div>
  <![endif]-->

  <?php
    do_action('get_header');
    get_template_part('templates/header-home');
  ?>

  <div class="wrap container page_head" role="document">
    <div class="content row">
      
      <div class="col-md-2">

        <div id="header">
          <header class="banner navbar full-width navbar-static-top margin-bottom-0" role="banner">

              <div class="navbar-header full-width">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand full-width" href="<?php echo esc_url(home_url('/')); ?>"><img class="logo-brand" src="<?php bloginfo('template_directory'); ?>/assets/img/logo.png"></a>
              </div>

              <nav class="collapse navbar-collapse" role="navigation">
                <?php
                  if (has_nav_menu('primary_navigation')) :
                    wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav navbar-nav'));
                  endif;
                ?>
              </nav>

          </header>
        </div><!-- #header -->

      </div>

      <div class="col-md-10 padding-top-20">
        <main class="main" role="main">
          <?php include roots_template_path(); ?>
        </main><!-- /.main -->
      </div>

    </div><!-- /.content -->
  </div><!-- /.wrap -->



  <?php get_template_part('templates/footer'); ?>

</body>
</html>
