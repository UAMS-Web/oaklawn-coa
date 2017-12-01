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

/**
 * Register the widget areas enabled by default in Utility.
 *
 * @since  1.0.0
 */
function utility_pro_register_widget_areas() {

	$widget_areas = array(
		array(
			'id'          => 'utility-bar',
			'name'        => __( 'Utility Bar', 'utility-pro' ),
			'description' => __( 'This is the utility bar across the top of page.', 'utility-pro' ),
		),
		array(
			'id'          => 'utility-home-widget-1',
			'name'        => __( 'Home Welcome', 'utility-pro' ),
			'description' => __( 'This is the welcome section at the top of the home page.', 'utility-pro' ),
		),
		array(
			'id'          => 'utility-home-widget-2',
			'name'        => __( 'Home Page 2', 'utility-pro' ),
			'description' => __( 'This is the text section below the Welcome at the top of the home page. (Optional Background Color)', 'utility-pro' ),
		),
		array(
			'id'          => 'utility-home-widget-3',
			'name'        => __( 'Home Page 3', 'utility-pro' ),
			'description' => __( 'Home Gallery widget area on home page. (Optional Background Image)', 'utility-pro' ),
		),
		array(
			'id'          => 'utility-home-widget-4',
			'name'        => __( 'Home Page 4', 'utility-pro' ),
			'description' => __( 'This is the home page 4 section. Default Call to Action area. (Optional Background Color, Default light gray)', 'utility-pro' ),
		),
		array(
			'id'          => 'utility-home-widget-5',
			'name'        => __( 'Home Page 5', 'utility-pro' ),
			'description' => __( 'This is the home page 5 section. (Optional Background Image)', 'utility-pro' ),
		),
		array(
			'id'          => 'utility-home-widget-6',
			'name'        => __( 'Home Page 6', 'utility-pro' ),
			'description' => __( 'This is the home page 6 section. (Optional Background Color)', 'utility-pro' ),
		),
		array(
			'id'          => 'utility-home-widget-7',
			'name'        => __( 'Home Page 7', 'utility-pro' ),
			'description' => __( 'This is the home page 7 section. (Optional Background Image.)', 'utility-pro' ),
		),
		array(
			'id'          => 'utility-home-widget-8',
			'name'        => __( 'Home Page 8', 'utility-pro' ),
			'description' => __( 'This is the home page 8 section. (Optional Background Color)', 'utility-pro' ),
		),
		array(
			'id'          => 'utility-home-widget-9',
			'name'        => __( 'Home Page 9', 'utility-pro' ),
			'description' => __( 'This is the home page 9 section.', 'utility-pro' ),
		),
	);

	$widget_areas = apply_filters( 'utility_pro_default_widget_areas', $widget_areas );

	foreach ( $widget_areas as $widget_area ) {
		genesis_register_sidebar( $widget_area );
	}
}
