<?php

if ( ! function_exists( 'ammad_portfolio_setup' ) ) :
	function ammad_portfolio_setup() {
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Register Navigation Menus
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'ammad-portfolio' ),
			)
		);

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'ammad_portfolio_setup' );

/**
 * Enqueue scripts and styles.
 */
function ammad_portfolio_scripts() {
	// Main Stylesheet
	wp_enqueue_style( 'ammad-portfolio-style', get_stylesheet_uri(), array(), '1.0.0' );

	// Custom Google Fonts (Inter and Roboto Mono for tech feel)
	wp_enqueue_style( 'ammad-portfolio-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;800&family=Outfit:wght@400;700&display=swap', array(), null );

    // Font Awesome for icons
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0' );

	// Custom CSS
	wp_enqueue_style( 'ammad-portfolio-main', get_template_directory_uri() . '/assets/css/main.css', array(), filemtime( get_template_directory() . '/assets/css/main.css' ) );

	// Custom JS
	wp_enqueue_script( 'ammad-portfolio-main-js', get_template_directory_uri() . '/assets/js/main.js', array(), filemtime( get_template_directory() . '/assets/js/main.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'ammad_portfolio_scripts' );
