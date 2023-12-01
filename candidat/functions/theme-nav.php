<?php

/*
 * Add Navigation
 */

if(!function_exists('custom_navigation_menus')) {

	add_action( 'init', 'custom_navigation_menus' );

	function custom_navigation_menus() {
		$locations = array(
			'header-menu' => __( 'Header Menu', 'wpblank' ),
			'footer-menu' => __( 'Footer Menu', 'wpblank' ),
			'footer-menu-secondary' => __( 'Footer Menu Secondary', 'wpblank' ),
		);
		register_nav_menus( $locations );
	}

}

/*
 * Navigation
 *
 * For option visit : http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */

if(!function_exists('nav_header')) {
	function nav_header() {
		wp_nav_menu(
			array(
				'theme_location' => 'header-menu',
				'container'      => false,
				'items_wrap'     => '<ul class="menu-list">%3$s</ul>',
				'depth'          => 2
			)
		);
	}
}

if(!function_exists('nav_footer')) {
	function nav_footer() {
		wp_nav_menu(
			array(
				'theme_location' => 'footer-menu',
				'container'      => false,
				'items_wrap'     => '<ul class="menu-list">%3$s</ul>',
				'depth'          => 1
			)
		);
	}
}

if(!function_exists('nav_footer_2')) {
	function nav_footer_secondary() {
		$options =  array(
			'theme_location' => 'footer-menu-secondary',
			'container'      => false,
			'items_wrap'     => '<ul class="footer--menu-list">%3$s</ul>',
			'depth'          => 1
		);
		$menu = wp_nav_menu($options);
		echo strip_tags($menu, '<a>');
	}
}


/*
 * Add "is-active" to "current-menu-items"
 */

if(!function_exists('current_to_active')) {

	add_filter('wp_nav_menu','current_to_active');

	function current_to_active($text) {
		$replace = array(
			// List of menu item classes that should be changed to "is-active"
			'current_page_item'     => 'current_page_item is-active',
			'current-page-parent'   => 'current-page-parent is-active',
			'current-page-ancestor' => 'current-page-ancestor is-active',
			'current-menu-ancestor' => 'current-menu-ancestor is-active',
			'current-menu-parent'   => 'current-menu-parent is-active',
			'current-menu-item'     => 'current-menu-item is-active'
		);
		$text = str_replace(array_keys($replace), $replace, $text);
		return $text;
	}

}

	// Get the $menu_location data (array of objects)
	function mbn_get_menu_items($menu_location){
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_location ] ) ) {
			$menu = wp_get_nav_menu_object( $locations[ $menu_location ] );
			return wp_get_nav_menu_items($menu->term_id);
		}
	}


