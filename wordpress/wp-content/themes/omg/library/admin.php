<?php

/************* CUSTOM LOGIN PAGE *****************/

// calling your own login css so you can style it

//Updated to proper 'enqueue' method
//http://codex.wordpress.org/Plugin_API/Action_Reference/login_enqueue_scripts
function omg_login_css() {
	wp_enqueue_style( 'omg_login_css', get_template_directory_uri() . '/library/css/login.css', false );
}

// changing the logo link from wordpress.org to your site
function omg_login_url() {  return home_url(); }

// changing the alt text on the logo to show your site name
function omg_login_title() { return get_option( 'blogname' ); }

// calling it only on the login page
add_action( 'login_enqueue_scripts', 'omg_login_css', 10 );
add_filter( 'login_headerurl', 'omg_login_url' );
add_filter( 'login_headertitle', 'omg_login_title' );
