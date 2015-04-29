<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php wp_title('|', true, 'right'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php wp_head(); ?>

  <title><?php wp_title('|', true, 'right'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <?php wp_head(); ?>

  <?php if (  (is_home()) || (is_front_page())  ) { ?>
	<meta name="description" content="Imhahinasyon is an artist that aims to promote art and creativity by doodling and typogprahy" />
  <?php } else  { ?>
  	<meta name="description" content="Imhahinasyon is an artist that aims to promote art and creativity by doodling and typogprahy" />
  <?php } ?>

  <script src="<?php echo bloginfo('template_directory'); ?>/js/modernizr.custom.js"></script>

  <meta name="keywords" content="doodle,typography,art,inspiration,philippines,doodling">
</head>
