<?php
/**
 * Front page for the Utility Pro theme
 *
 * @package Utility_Pro
 * @author  Carrie Dils
 * @license GPL-2.0+
 */

add_action( 'genesis_meta', 'utility_pro_homepage_setup' );
/**
 * Set up the homepage layout by conditionally loading sections when widgets
 * are active.
 *
 * @since 1.0.0
 */
function utility_pro_homepage_setup() {

	$home_sidebars = array(
		'home_welcome' 	=> is_active_sidebar( 'utility-home-widget-1' ),
		'home_widget_2' => is_active_sidebar( 'utility-home-widget-2' ),
		'home_widget_3' => is_active_sidebar( 'utility-home-widget-3' ),
		'home_widget_4' => is_active_sidebar( 'utility-home-widget-4' ),
		'home_widget_5'	=> is_active_sidebar( 'utility-home-widget-5' ),
		'home_widget_6'	=> is_active_sidebar( 'utility-home-widget-6' ),
		'home_widget_7'	=> is_active_sidebar( 'utility-home-widget-7' ),
		'home_widget_8'	=> is_active_sidebar( 'utility-home-widget-8' ),
		'home_widget_9'	=> is_active_sidebar( 'utility-home-widget-9' ),
	);

	// Return early if no sidebars are active.
	if ( ! in_array( true, $home_sidebars ) ) {
		return;
	}

	// Get static home page number.
	$page = ( get_query_var( 'page' ) ) ? (int) get_query_var( 'page' ) : 1;

	// Only show home page widgets on page 1.
	if ( 1 === $page ) {

		// Add home welcome area if "Home Welcome" widget area is active.
		if ( $home_sidebars['home_welcome'] ) {
			add_action( 'genesis_after_header', 'utility_pro_add_home_welcome' );
		}

		// Add call to action area if "Call to Action" widget area is active.
		if ( $home_sidebars['home_widget_2'] ) {
			add_action( 'genesis_after_header', 'utility_pro_add_front_page_widget_2' );
		}

		// Add home gallery area if "Home Gallery" widget area is active.
		if ( $home_sidebars['home_widget_3'] ) {
			add_action( 'genesis_after_header', 'utility_pro_add_front_page_widget_3' );
		}

		// Add call to action area if "Call to Action" widget area is active.
		if ( $home_sidebars['home_widget_4'] ) {
			add_action( 'genesis_after_header', 'utility_pro_add_front_page_widget_4' );
		}
		// Add call to action area if "Call to Action" widget area is active.
		if ( $home_sidebars['home_widget_5'] ) {
			add_action( 'genesis_before_footer', 'utility_pro_add_front_page_widget_5', 5 );
		}
		// Add call to action area if "Call to Action" widget area is active.
		if ( $home_sidebars['home_widget_6'] ) {
			add_action( 'genesis_before_footer', 'utility_pro_add_front_page_widget_6', 5 );
		}
		// Add call to action area if "Call to Action" widget area is active.
		if ( $home_sidebars['home_widget_7'] ) {
			add_action( 'genesis_before_footer', 'utility_pro_add_front_page_widget_7', 5 );
		}
		// Add call to action area if "Call to Action" widget area is active.
		if ( $home_sidebars['home_widget_8'] ) {
			add_action( 'genesis_before_footer', 'utility_pro_add_front_page_widget_8', 5 );
		}
		// Add call to action area if "Call to Action" widget area is active.
		if ( $home_sidebars['home_widget_9'] ) {
			add_action( 'genesis_before_footer', 'utility_pro_add_front_page_widget_9', 5 );
		}
	}

	// Full width layout.
	// Uncomment the filter below if you'd like a full-width layout on the front page.
	// add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

	// Filter site title markup to include an h1.
	add_filter( 'genesis_site_title_wrap', 'utility_pro_return_h1' );

	// Remove standard loop and replace with loop showing Posts, not Page content.
	//remove_action( 'genesis_loop', 'genesis_do_loop' );
	//add_action( 'genesis_loop', 'utility_pro_front_loop' );

	// Remove entry title
	remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
}

/**
 * Use h1 for site title on a static front page.
 *
 * Hat tip to Bill Erickson for the suggestion.
 *
 * @see http://www.billerickson.net/genesis-h1-front-page/
 *
 * @since 1.2.0
 */
function utility_pro_return_h1( $wrap ) {
	return 'h1';
}

/**
 * Display content for the "Home Welcome" section.
 *
 * @since 1.0.0
 */
function utility_pro_add_home_welcome() {

	genesis_widget_area( 'utility-home-widget-1',
		array(
			'before' => '<div class="home-welcome"><div class="wrap">',
			'after' => '</div></div>',
			'before' => '<div id="home-welcome" class="home-welcome home-widget-1"><div class="image-section"><div class="flexible-widgets widget-area' . utility_widget_area_class( 'utility-home-widget-1' ) . '"><div class="wrap">',
			'after'  => '</div></div></div></div>',
		)
	);
}

/**
 * Display content for the "Call to action" section.
 *
 * @since 1.0.0
 */
function utility_pro_add_front_page_widget_2() {

	genesis_widget_area(
		'utility-home-widget-2',
		array(
			'before' => '<div id="home-widget-2" class="home-widget-2 home-block"><div class="solid-section"><div class="flexible-widgets widget-area' . utility_widget_area_class( 'utility-home-widget-2' ) . '"><div class="wrap">',
			'after' => '</div></div></div></div>',
		)
	);
}

/**
 * Display content for the "Home Gallery" section.
 *
 * @since 1.0.0
 */
function utility_pro_add_front_page_widget_3() {

	genesis_widget_area(
		'utility-home-widget-3',
		array(
			'before' => '<div id="home-gallery" class="home-gallery"><div class="image-section"><div class="flexible-widgets widget-area' . utility_widget_area_class( 'utility-home-widget-3' ) . '"><div class="wrap">',
			'after' => '</div></div></div></div>',
		)
	);
}

/**
 * Display content for the "Call to action" section.
 *
 * @since 1.0.0
 */
function utility_pro_add_front_page_widget_4() {

	genesis_widget_area(
		'utility-home-widget-4',
		array(
			'before' => '<div id="home-widget-4" class="call-to-action-bar home-widget-4"><div class="solid-section"><div class="flexible-widgets widget-area' . utility_widget_area_class( 'utility-home-widget-4' ) . '"><div class="wrap">',
			'after' => '</div></div></div></div>',
		)
	);
}

function utility_pro_add_front_page_widget_5() {
	genesis_widget_area(
	 	'utility-home-widget-5', 
	 	array(
			'before' => '<div id="home-widget-5" class="home-widget-5 image-section"><div class="image-section"><div class="flexible-widgets widget-area' . utility_widget_area_class( 'utility-home-widget-5' ) . '"><div class="wrap">',
			'after' => '</div></div></div></div>',
		)
	);
}

function utility_pro_add_front_page_widget_6() {
	genesis_widget_area(
	 	'utility-home-widget-6', 
	 	array(
			'before' => '<div id="home-widget-6" class="home-widget-6"><div class="solid-section"><div class="flexible-widgets widget-area' . utility_widget_area_class( 'utility-home-widget-6' ) . '"><div class="wrap">',
			'after' => '</div></div></div></div>',
		)
	);
}

function utility_pro_add_front_page_widget_7() {
	genesis_widget_area(
	 	'utility-home-widget-7', 
	 	array(
			'before' => '<div id="home-widget-7" class="home-widget-7"><div class="image-section"><div class="flexible-widgets widget-area' . utility_widget_area_class( 'utility-home-widget-7' ) . '"><div class="wrap">',
			'after' => '</div></div></div></div>',
		)
	);
}

function utility_pro_add_front_page_widget_8() {
	genesis_widget_area(
	 	'utility-home-widget-8', 
	 	array(
			'before' => '<div id="home-widget-8" class="home-widget-8"><div class="solid-section"><div class="flexible-widgets widget-area' . utility_widget_area_class( 'utility-home-widget-8' ) . '"><div class="wrap">',
			'after' => '</div></div></div></div>',
		)
	);
}

function utility_pro_add_front_page_widget_9() {
	genesis_widget_area(
	 	'utility-home-widget-9', 
	 	array(
			'before' => '<div id="home-widget-9" class="home-widget-9"><div class="solid-section"><div class="flexible-widgets widget-area' . utility_widget_area_class( 'utility-home-widget-9' ) . '"><div class="wrap">',
			'after' => '</div></div></div></div>',
		)
	);
}

genesis();
