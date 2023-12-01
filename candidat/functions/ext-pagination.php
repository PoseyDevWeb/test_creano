<?php
/*
 * Add Pagination
 */
if(!function_exists('html5wp_pagination')) {

	// add_action('init', 'html5wp_pagination');
	function html5wp_pagination() {
		$published_posts = pll_count_posts(pll_current_language());
		// $published_posts = wp_count_posts()->publish;
		$posts_per_page = get_option('posts_per_page');
		$page_number_max = ceil($published_posts / $posts_per_page);

    global $wp_query;
    $big = 999999999;
    $options = array(
      'base' => str_replace($big, '%#%', get_pagenum_link($big)),
      'format' => '?paged=%#%',
      'current' => max(1, get_query_var('paged')),
      'total' => $page_number_max,
      'next_text' => '&rsaquo;',
      'prev_text' => '&lsaquo;',
      'type' => 'list'
    );
    echo paginate_links($options);
  }

}

?>
