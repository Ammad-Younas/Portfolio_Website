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
	wp_enqueue_style( 'ammad-portfolio-main', home_url( '/assets/css/main.css' ), array(), filemtime( get_template_directory() . '/assets/css/main.css' ) );

	// Custom JS
	wp_enqueue_script( 'ammad-portfolio-main-js', home_url( '/assets/js/main.js' ), array(), filemtime( get_template_directory() . '/assets/js/main.js' ), true );

    // Localize script for AJAX
    wp_localize_script( 'ammad-portfolio-main-js', 'portfolio_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' )
    ) );
}
add_action( 'wp_enqueue_scripts', 'ammad_portfolio_scripts' );

// Contact Form AJAX Handler
function submit_contact_form() {
    // Sanitize input
    $name = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
    $email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
    $message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

    if ( empty( $name ) || empty( $email ) || empty( $message ) ) {
        wp_send_json_error( array( 'message' => 'Please fill in all fields.' ) );
    }

    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Please provide a valid email address.' ) );
    }

    $to = get_option( 'admin_email' );
    $subject = 'New Contact Form Submission from ' . $name;
    $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
    $headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

    $sent = wp_mail( $to, $subject, $body, $headers );

    if ( $sent ) {
        wp_send_json_success( array( 'message' => 'Thank you! Your message has been sent.' ) );
    } else {
        wp_send_json_error( array( 'message' => 'Failed to send message. Please try again later.' ) );
    }
}
add_action( 'wp_ajax_submit_contact_form', 'submit_contact_form' );
add_action( 'wp_ajax_nopriv_submit_contact_form', 'submit_contact_form' );
