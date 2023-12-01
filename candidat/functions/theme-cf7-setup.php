<?php
/*-------------------------------------------------------*\
		CONTACT FORM 7
\*-------------------------------------------------------*/
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

add_action('wp_print_scripts', 'mbn_header_scripts');
function mbn_header_scripts(){
	if( !is_page_template('template-contact.php') && !is_page_template('template-form.php') && !is_page_template('template-step-form.php') )
		return;

	if ( function_exists( 'wpcf7_enqueue_scripts' ) )
		wpcf7_enqueue_scripts();

	if ( function_exists( 'wpcf7_enqueue_styles' ) )
		wpcf7_enqueue_styles();
}


/*------------------------------------*\
		CONTACT FORM 7 CLEAN TAGS
\*------------------------------------*/
// Remove span wrapper for fields
// add_filter('wpcf7_form_elements', function($content) {
//     $content = preg_replace('/<(span).*?class="\s*(?:.*\s)?wpcf7-form-control-wrap(?:\s[^"]+)?\s*"[^\>]*>(.*)<\/\1>/i', '\2', $content);

//     return $content;
// });

?>
