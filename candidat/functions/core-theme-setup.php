<?php
/*
 * Set up the content width value based on the theme's design.
 */

if (!isset($content_width))
	$content_width = 960;

if ( !function_exists('custom_theme_features') ) {

	add_action( 'after_setup_theme', 'custom_theme_features' );

  // Register Theme Features
  function custom_theme_features()  {

    // Add theme support for Automatic Feed Links
    add_theme_support( 'automatic-feed-links' );

    // Add theme support for Post Formats
    // add_theme_support( 'post-formats', array( 'status', 'quote', 'gallery', 'image', 'video', 'audio', 'link', 'aside', 'chat' ) );

    // Add theme support for Featured Images
    add_theme_support( 'post-thumbnails' );

     // Set custom thumbnail dimensions
    set_post_thumbnail_size( 1024, 1024, true );

    // Add theme support for HTML5 Semantic Markup
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

    // Add theme support for document Title tag
    add_theme_support( 'title-tag' );

    // Add theme support for custom CSS in the TinyMCE visual editor
    add_editor_style();

    // Add theme support for Translation
    load_theme_textdomain( 'Enedis', get_template_directory() . '/language' );
  }

}


/*
 * Add page slug to body class, love this - Credit: Starkers Wordpress Theme
 */
function add_slug_to_body_class($classes){
  global $post;

  if ( is_home() ) {
    $key = array_search('blog', $classes);

    if ($key > -1)
    	unset($classes[$key]);
  }

  if ( is_page() || is_singular() )
  	$classes[] = sanitize_html_class($post->post_name);

  return $classes;
}
// add_filter('body_class', 'add_slug_to_body_class');


/*
 * Custom Excerpts
 * Create 20 Word Callback for Index page Excerpts, call using html5wp_excerpt('html5wp_index');
 */
function html5wp_index($length){
  return 20;
}


/*
 * Create 40 Word Callback for Custom Post Excerpts.
 * Call using html5wp_excerpt('html5wp_custom_post');
 */
function html5wp_custom_post($length){
  return 40;
}

/*
 * Create the Custom Excerpts callback
 */
function html5wp_excerpt($length_callback = '', $more_callback = ''){

  global $post;

  if ( function_exists($length_callback) )
  	add_filter('excerpt_length', $length_callback);

  if ( function_exists($more_callback) )
  	add_filter('excerpt_more', $more_callback);

  $output = get_the_excerpt();
  $output = apply_filters('wptexturize', $output);
  $output = apply_filters('convert_chars', $output);
  $output = '<p>' . $output . '</p>';

  echo $output;
}

/*
 * Custom View Article link to Post
 */
// add_filter('excerpt_more', 'html5_blank_view_article');
// function html5_blank_view_article($more){
//   global $post;
//   return '… <a class="article-viewMore" href="' . get_permalink($post->ID) . '">' . __('Lire l\'article', 'wpblank') . '</a>';
// }


/*
 * Remove 'text/css' from our enqueued stylesheet
 */
add_filter('style_loader_tag', 'html5_style_remove');
function html5_style_remove($tag){
  return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}


/*
 * Remove wp_head() injected Recent Comment styles
 */
function my_remove_recent_comments_style(){
  global $wp_widget_factory;

  remove_action('wp_head', array(
    $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
    'recent_comments_style'
  ));
}


/*
 * No Duplicate content
 * http://www.geekpress.fr/wordpress/astuce/duplicate-content-categorie-1416/
 */
add_action('wp', 'baw_non_duplicate_content' );
function baw_non_duplicate_content( $wp ){
  global $wp_query;

  if( isset( $wp_query->query_vars['category_name'], $wp_query->query['category_name'] )
  && $wp_query->query_vars['category_name'] != $wp_query->query['category_name'] ){

  	$correct_url = str_replace( $wp_query->query['category_name'], $wp_query->query_vars['category_name'], $wp->request );
    wp_redirect( home_url( $correct_url ), 301 );
  	die();
  }
}


/*
 * Remove WordPress custom field
 */
add_action('init','baw_remove_custom_field_meta_boxes');
function baw_remove_custom_field_meta_boxes(){
  remove_post_type_support( 'post','custom-fields' );
  remove_post_type_support( 'page','custom-fields' );
}


/*
 * Remove Widget Calendar
 */
add_action( 'widgets_init', 'remove_calendar_widget' );
function remove_calendar_widget(){
  unregister_widget('WP_Widget_Calendar');
}


/*
 * Load theme textdomain
 */
add_action('after_setup_theme', 'my_theme_setup');
function my_theme_setup(){
  load_theme_textdomain('my_theme', get_template_directory() . '/languages');
  // add_custom_image_sizes();
}

?>
