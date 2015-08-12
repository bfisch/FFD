<?php
/**
 * Hammerhead functions and definitions
 *
 * @package Hammerhead
 */


/* =============================================================== */
// Hammerhead Setup
/* =============================================================== */


if ( ! function_exists( 'hammerhead_setup' ) ) :

	function hammerhead_setup() {

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );

		add_theme_support( 'html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', ) );

		add_theme_support( 'post-formats', array('aside', 'image', 'video', 'quote', 'link',) );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array('primary' => __( 'Main Menu', 'hammerhead' )) );

		require_once( 'projects.php' );

	}

endif; // hammerhead_setup

add_action( 'after_setup_theme', 'hammerhead_setup' );



/* =============================================================== */
// Sidebars
/* =============================================================== */

function hammerhead_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'hammerhead' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'hammerhead_widgets_init' );




/* =============================================================== */
// Enqueue Thy Scripts and Sheets of Style
/* =============================================================== */

function hammerhead_scripts() {
	//wp_enqueue_style( 'hammerhead-style', get_stylesheet_uri() );
	wp_enqueue_style( 'hammerhead-style-sass', get_template_directory_uri() . '/stylesheets/style.css' );

	//Custom Script
	wp_enqueue_script( 'hammerhead-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), '20150218', true );

	//Navigation Usability
	wp_enqueue_script( 'hammerhead-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'hammerhead-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	//Comments
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'hammerhead_scripts' );



/* =============================================================== */
// Extras
/* =============================================================== */

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
