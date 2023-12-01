<?php

/* Add Filters
-------------------------- */

// Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'do_shortcode');

// Remove <p> tags in Dynamic Sidebars (better!)
add_filter('widget_text', 'shortcode_unautop');

// Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'shortcode_unautop');

// Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode');

// Remove Admin bar
function remove_admin_bar(){
	return false;
}
add_filter('show_admin_bar', 'remove_admin_bar');


/* Remove Actions
-------------------------- */

// remove useless emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');


/*
 * Remove wp-embed-min.js
 */
add_action( 'wp_footer', 'my_deregister_scripts' );
function my_deregister_scripts(){
  wp_deregister_script( 'wp-embed' );
}


/*
 * Add Conditional Page Scripts
 */
//function html5blank_conditional_scripts()
//{
//  if (is_page('pagenamehere')) {
//    wp_register_script('scriptname', get_template_directory_uri() . '/js/scriptname.js', array('jquery'), '1.0.0'); // Conditional script(s)
//    wp_enqueue_script('scriptname'); // Enqueue it!
//  }
//}
//add_action('wp_print_scripts', 'html5blank_conditional_scripts');


/*
 * Remove ?ver=x.x from css and js
 */
function remove_cssjs_ver( $src ){
  if( strpos( $src, '?ver=' ) )
  $src = remove_query_arg( 'ver', $src );
  return $src;
}


/*
 * Add styles
 */
function html5blank_styles(){
  // Styles
  wp_register_style('wpblank', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0', 'all');
  wp_enqueue_style('wpblank');
}
add_action('wp_enqueue_scripts', 'html5blank_styles');

?>
