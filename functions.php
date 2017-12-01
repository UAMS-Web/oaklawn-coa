<?php
/**
 * Utility Pro.
 *
 * @package      Utility_Pro
 * @link         http://www.carriedils.com/utility-pro
 * @author       Carrie Dils
 * @copyright    Copyright (c) 2015, Carrie Dils
 * @license      GPL-2.0+
 */

// Load internationalization components.
// English users do not need to load the text domain and can comment out or remove.
load_child_theme_textdomain( 'utility-pro', get_stylesheet_directory() . '/languages' );

// This file loads the Google fonts used in this theme.
require get_stylesheet_directory() . '/includes/google-fonts.php';

// This file contains search form improvements.
require get_stylesheet_directory() . '/includes/class-search-form.php';

add_action( 'genesis_setup', 'utility_pro_setup', 15 );
/**
 * Theme setup.
 *
 * Attach all of the site-wide functions to the correct hooks and filters. All
 * the functions themselves are defined below this setup function.
 *
 * @since 1.0.0
 */
function utility_pro_setup() {

	define( 'CHILD_THEME_NAME', 'utility-pro' );
	define( 'CHILD_THEME_URL', 'https://store.carriedils.com/utility-pro' );
	define( 'CHILD_THEME_VERSION', '1.0.0' );

	// Add HTML5 markup structure.
	add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

	// Add viewport meta tag for mobile browsers.
	add_theme_support( 'genesis-responsive-viewport' );

	// Add support for custom background.
	//add_theme_support( 'custom-background', array( 'wp-head-callback' => '__return_false' ) );

	// Add support for accessibility features.
	add_theme_support( 'genesis-accessibility', array( '404-page', 'headings', 'skip-links' ) );

	// Add support for three footer widget areas.
	add_theme_support( 'genesis-footer-widgets', 3 );

	// Add support for additional color style options.
	add_theme_support(
		'genesis-style-selector',
		array(
			'utility-pro-purple' => __( 'Purple', 'utility-pro' ),
			'utility-pro-green'  => __( 'Green', 'utility-pro' ),
			'utility-pro-red'    => __( 'Red', 'utility-pro' ),
		)
	);

	// Add support for structural wraps (all default Genesis wraps unless noted).
	add_theme_support(
		'genesis-structural-wraps',
		array(
			'footer',
			'footer-widgets',
			'footernav',    // Custom.
			'header',
			'home-gallery', // Custom.
			'menu-footer',  // Custom.
			'nav',
			'site-inner',
			'site-tagline',
		)
	);

	// Add support for two navigation areas (theme doesn't use secondary navigation).
	add_theme_support(
		'genesis-menus',
		array(
			'primary' => __( 'Primary Navigation Menu', 'utility-pro' ),
			'footer'  => __( 'Footer Navigation Menu', 'utility-pro' ),
		)
	);

	// Add custom image sizes.
	add_image_size( 'feature-large', 960, 330, true );
	add_image_size( 'feature-medium', 480, 270, true );

	// Unregister secondary sidebar.
	unregister_sidebar( 'sidebar-alt' );

	// Unregister layouts that use secondary sidebar.
	genesis_unregister_layout( 'content-sidebar-sidebar' );
	genesis_unregister_layout( 'sidebar-content-sidebar' );
	genesis_unregister_layout( 'sidebar-sidebar-content' );

	// Register the default widget areas.
	utility_pro_register_widget_areas();

	// Add Utility Bar above header.
	add_action( 'genesis_before_header', 'utility_pro_add_bar' );

	// Add featured image above posts.
	add_filter( 'the_content', 'utility_pro_featured_image' );

	// Add a navigation area above the site footer.
	add_action( 'genesis_before_footer', 'utility_pro_do_footer_nav' );

	// Remove Genesis archive pagination (Genesis pagination settings still apply).
	remove_action( 'genesis_after_endwhile', 'genesis_posts_nav' );

	// Add WordPress archive pagination (accessibility).
	add_action( 'genesis_after_endwhile', 'utility_pro_post_pagination' );

	// Apply search form enhancements (accessibility).
	add_filter( 'get_search_form', 'utility_pro_get_search_form', 25 );

	// Load files in admin.
	if ( is_admin() ) {

		// Add suggested plugins nag.
		include get_stylesheet_directory() . '/includes/suggested-plugins.php';

		// Add theme license (don't remove, unless you don't want theme support).
		include get_stylesheet_directory() . '/includes/theme-license.php';
	}
}

/**
 * Add Utility Bar above header.
 *
 * @since 1.0.0
 */
function utility_pro_add_bar() {

	genesis_widget_area( 'utility-bar', array(
		'before' => '<div class="utility-bar"><div class="wrap">',
		'after'  => '</div></div>',
	) );
}

/**
 * Add featured image above single posts.
 *
 * Outputs image as part of the post content, so it's included in the RSS feed.
 * H/t to Robin Cornett for the suggestion of making image available to RSS.
 *
 * @since 1.0.0
 *
 * @param string $content Post content.
 *
 * @return null|string Return early if not a single post or there is no thumbnail.
 *                     Image and content markup otherwise.
 */
function utility_pro_featured_image( $content ) {

	if ( ! is_singular( 'post' ) || ! has_post_thumbnail() ) {
		return $content;
	}

	$image = '<div class="featured-image">';
	$image .= get_the_post_thumbnail( get_the_ID(), 'feature-large' );
	$image .= '</div>';

	return $image . $content;
}

add_filter( 'genesis_footer_creds_text', 'utility_pro_footer_creds' );
/**
 * Change the footer text.
 *
 * @since  1.0.0
 *
 * @param string $creds Existing credentials.
 *
 * @return string Footer credentials.
 */
function utility_pro_footer_creds( $creds ) {

	return 'Copyright [footer_copyright] Oaklawn Center on Aging All Rights Reserved. &middot; [footer_loginout]' ;
}

add_filter( 'genesis_author_box_gravatar_size', 'utility_pro_author_box_gravatar_size' );
/**
 * Customize the Gravatar size in the author box.
 *
 * @since 1.0.0
 *
 * @param int $size Existing pixel size of gravatar.
 *
 * @return int Pixel size of gravatar.
 */
function utility_pro_author_box_gravatar_size( $size ) {
	return 96;
}

/**
 * Flexible Widget Counts.
 *
 * @since 1.0.0
 *
 * @param int $id ID of the widget area.
 *
 * @return int Number of widgets.
 */
function utility_count_widgets( $id ) {

	global $sidebars_widgets;

	if ( isset( $sidebars_widgets[ $id ] ) ) {
		return count( $sidebars_widgets[ $id ] );
	}

}

/**
 * Flexible Widget Classes.
 *
 * @since 1.0.0
 *
 * @param int $id ID of the widget.
 *
 * @return string Widget class.
 */
function utility_widget_area_class( $id ) {

	$count = utility_count_widgets( $id );

	$class = '';

	if ( $count == 1 ) {
		$class .= ' widget-full';
	} elseif ( $count % 3 == 0 ) {
		$class .= ' widget-thirds';
	} elseif ( $count % 4 == 0 ) {
		$class .= ' widget-fourths';
	} elseif ( $count % 2 == 1 ) {
		$class .= ' widget-halves uneven';
	} else {
		$class .= ' widget-halves';
	}

	return $class;

}

/**
 * Apply Dropdown Menu Class to Primary Only
 *
 * @author Bill Erickson
 * @link https://gist.github.com/billerickson/6700212
 *
 * @param array $menus, theme locations
 * @return array $menus
 */
function be_dropdown_class_on_primary( $menus ) {
  return array( 'primary' );
}
add_filter( 'dropdown_menu_class_menus', 'be_dropdown_class_on_primary' );

// Add theme widget areas.
include get_stylesheet_directory() . '/includes/widget-areas.php';

// Add footer navigation components.
include get_stylesheet_directory() . '/includes/footer-nav.php';

// Add scripts to enqueue.
include get_stylesheet_directory() . '/includes/enqueue-assets.php';

// Miscellaenous functions used in theme configuration.
include get_stylesheet_directory() . '/includes/theme-config.php';
