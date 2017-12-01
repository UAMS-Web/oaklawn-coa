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

// Enable shortcodes in widgets.
add_filter( 'widget_text', 'do_shortcode' );

add_filter( 'theme_page_templates', 'utility_pro_remove_genesis_page_templates' );
/**
 * Remove Genesis Blog page template.
 *
 * @param array $page_templates Existing recognised page templates.
 * @return array Amended recognised page templates.
 */
function utility_pro_remove_genesis_page_templates( $page_templates ) {
	unset( $page_templates['page_blog.php'] );
	return $page_templates;
}

add_filter( 'genesis_attr_nav-footer', 'utility_pro_add_nav_secondary_id' );
/**
 * Add ID to footer nav.
 *
 * In order to use skip links with the footer menu, the menu needs an
 * ID to anchor the link to. Hat tip to Robin Cornett for the tutorial.
 *
 * @link http://robincornett.com/genesis-responsive-menu/
 *
 * @since 1.2.1
 * @param array $attributes Optional. Extra attributes to merge with defaults.
 * @return array Merged and filtered attributes.
 */
function utility_pro_add_nav_secondary_id( $attributes ) {
	$attributes['id'] = 'genesis-nav-footer';
	return $attributes;
}

add_filter( 'genesis_skip_links_output', 'utility_pro_add_nav_secondary_skip_link' );
/**
 * Add skip link to footer navigation.
 *
 * @since 1.2.1
 *
 * @param array Default skiplinks.
 * @return array Amended markup for Genesis skip links.
 */
function utility_pro_add_nav_secondary_skip_link( $links ) {
	$new_links = $links;
	array_splice( $new_links, 1 );

	if ( has_nav_menu( 'footer' ) ) {
		$new_links['genesis-nav-footer'] = __( 'Skip to footer navigation', 'utility_pro' );
	}

	return array_merge( $new_links, $links );
}

/**
 * Customize the search form to improve accessibility.
 *
 * The instantiation can accept an array of custom strings, should you want
 * the search form have different strings in different contexts.
 *
 * @since 1.0.0
 *
 * @return string Search form markup.
 */
function utility_pro_get_search_form() {
	$search = new Utility_Pro_Search_Form;
	return $search->get_form();
}

/**
 * Use WordPress archive pagination.
 *
 * Return a paginated navigation to next/previous set of posts, when
 * applicable. Includes screen reader text for better accessibility.
 *
 * @since  1.0.0
 *
 * @see the_posts_pagination()
 */
function utility_pro_post_pagination() {
	$args = array(
		'mid_size' => 2,
		'before_page_number' => '<span class="screen-reader-text">' . __( 'Page', 'utility-pro' ) . ' </span>',
	);

	if ( 'numeric' === genesis_get_option( 'posts_nav' ) ) {
		the_posts_pagination( $args );
	} else {
		the_posts_navigation( $args );
	}
}

add_action( 'customize_register', 'utility_customizer_register' );
/**
 * Register settings and controls with the Customizer.
 *
 * @since 1.0.0
 * 
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function utility_customizer_register() {

	/**
	 * Customize Background Image Control Class
	 *
	 * @package WordPress
	 * @subpackage Customize
	 * @since 3.4.0
	 */
	class Child_Utility_Image_Control extends WP_Customize_Image_Control {

		/**
		 * Constructor.
		 *
		 * If $args['settings'] is not defined, use the $id as the setting ID.
		 *
		 * @since 3.4.0
		 * @uses WP_Customize_Upload_Control::__construct()
		 *
		 * @param WP_Customize_Manager $manager
		 * @param string $id
		 * @param array $args
		 */
		public function __construct( $manager, $id, $args ) {
			$this->statuses = array( '' => __( 'No Image', 'utility-pro' ) );

			parent::__construct( $manager, $id, $args );

			$this->add_tab( 'upload-new', __( 'Upload New', 'utility-pro' ), array( $this, 'tab_upload_new' ) );
			$this->add_tab( 'uploaded',   __( 'Uploaded', 'utility-pro' ),   array( $this, 'tab_uploaded' ) );

			if ( $this->setting->default )
				$this->add_tab( 'default',  __( 'Default', 'utility-pro' ),  array( $this, 'tab_default_background' ) );

			// Early priority to occur before $this->manager->prepare_controls();
			add_action( 'customize_controls_init', array( $this, 'prepare_control' ), 5 );
		}

		/**
		 * @since 3.4.0
		 * @uses WP_Customize_Image_Control::print_tab_image()
		 */
		public function tab_default_background() {
			$this->print_tab_image( $this->setting->default );
		}

	}

	global $wp_customize;

	$images = apply_filters( 'utility_images', array( '1', '3', '5', '7' ) );

	$colors = apply_filters( 'utility_bgcolor', array( '2', '4', '6', '8' ) );

	$wp_customize->add_section( 'utility-settings', array(
		'description' => __( 'Use images or personalize your site by uploading your own images.<br /><br />The default images are <strong>1600 pixels wide and 1050 pixels tall</strong>.', 'utility-pro' ),
		'title'    => __( 'Front Page Backgrounds', 'utility-pro' ),
		'priority' => 35,
	) );

	foreach( $images as $image ) {

		$wp_customize->add_setting( $image .'-utility-image', array(
			//'default'  => sprintf( '%s/images/bg-%s.jpg', get_stylesheet_directory_uri(), $image ),
			'sanitize_callback' => 'esc_url_raw',
			'type'     => 'option',
		) );

		$wp_customize->add_control( new Child_Utility_Image_Control( $wp_customize, $image .'-utility-image', array(
			'label'    => sprintf( __( 'Featured Section %s Image:', 'utility-pro' ), $image ),
			'section'  => 'utility-settings',
			'settings' => $image .'-utility-image',
			'priority' => $image+1,
		) ) );

	}

	foreach( $colors as $color ) {

		$wp_customize->add_setting( $color .'-bgcolor', array(
			'default'  => null,
			'sanitize_callback' => 'sanitize_hex_color',
			'type'     => 'option',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color .'-bgcolor', array(
			'label'    => sprintf( __( 'Featured Section %s Background Color:', 'utility-pro' ), $color ),
			'section'  => 'utility-settings',
			'settings' => $color .'-bgcolor',
			'priority' => $color+1,
		) ) );

	}


}
