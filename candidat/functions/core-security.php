<?php

/*------------------------------------*\
DISABLE REST API ACCESS instead wp admin
\*------------------------------------*/
// add_filter( 'rest_authentication_errors', function( $result ) {
// 	if ( ! empty( $result ) ) {
// 			return $result;
// 	}
// 	if ( ! is_user_logged_in() ) {
// 			return new WP_Error( 'rest_not_logged_in', 'You are not currently logged in.', array( 'status' => 401 ) );
// 	}
// 	return $result;
// });

// ATTENTION CELA BLOQUE CONTACT FORM 7 pour les envois d'emails


/*------------------------------------*\
DISABLE XML RPC
\*------------------------------------*/
add_filter( 'xmlrpc_enabled', '__return_false' );
remove_action( 'wp_head', 'rsd_link' );


/*------------------------------------*\
		DISABLE SOME NATIVE FEATURES...
\*------------------------------------*/
// add_action( 'init', 'unregister_categories' );
// add_filter( 'get_the_categories', '__return_false' );
// add_filter( 'the_category', '__return_false' );
// add_filter( 'wp_get_object_terms', 'hide_categories_front_end', 10, 4 );
// add_action( 'pre_get_posts', 'redirect_404_category_archives' );

add_filter( 'get_search_form', 'remove_search_form' );
function remove_search_form ($a) {
	return null;
}
/*
add_action( 'parse_query', 'wpb_filter_query' );
function wpb_filter_query( $query, $error = true ) {
	if ( is_search() && !is_admin() ) {
		$query->is_search = false;
		$query->query_vars['s'] = false;
		$query->query['s'] = false;
		// if ( $error == true )
		$query->is_404 = true;
	}
}*/

/**
 * Removes categories from blog posts
 */
function unregister_categories() {
	unregister_taxonomy_for_object_type( 'category', 'post' );
}

/**
 * Removes categories from the front end
 */
function hide_categories_front_end( $terms, $object_ids, $taxonomies, $args ) {
	if( $taxonomies == "category" ) {
		$terms = false;
	}
	return $terms;
}

/**
 * Remove category pages
 */
function redirect_404_category_archives( $query ) {
	if( $query->is_main_query() && $query->is_category() ) {
		$query->set_404();
		status_header( 404 );
	}
}



add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

// Removes from admin bar
function mytheme_admin_bar_render() {
  global $wp_admin_bar;
  $wp_admin_bar->remove_menu('comments');
}


$role = get_role('administrator');
$role->add_cap('list_users');

?>
