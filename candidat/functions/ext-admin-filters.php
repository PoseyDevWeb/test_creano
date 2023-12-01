<?php
/*------------------------------------*\
		remove useless rich editor => used with Carbon fields
\*------------------------------------*/
add_action( 'init', 'remove_pages_editor' );
function remove_pages_editor(){
	// remove_post_type_support( 'post', 'editor' );
	remove_post_type_support( 'page', 'editor' );
}

/*------------------------------------*\
		Remove Filters
\*------------------------------------*/
remove_filter('term_description','wpautop');

// Remove <p> tags from Excerpt altogether
remove_filter('the_excerpt', 'wpautop');


/*------------------------------------*\
* Callback function to filter the MCE settings
\*------------------------------------*/
add_filter( 'mce_buttons_2', 'sennza_mce_buttons' );
function sennza_mce_buttons( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}

add_filter( 'tiny_mce_before_init', 'my_format_TinyMCE' );
function my_format_TinyMCE( $in ) {
	$in['wpautop'] = false;
	return $in;
}
// TODO => A FACTORISER
add_filter( 'tiny_mce_before_init', 'enedis_mce_before_init' );
function enedis_mce_before_init( $init_array ) {

	// Add back some more of styles we want to see in TinyMCE
	$init_array['preview_styles'] = "color background-color";

	$style_formats = array(
		// Each array child is a format with it's own settings
		array(
			'title'   => 'Texte en bleu',
			'inline'  => 'span',
			'classes' => 'blue',
		),
		array(
			'title'   => 'Texte en vert',
			'inline'  => 'span',
			'classes' => 'green',
		),
		array(
			'title'   => 'Texte en orange',
			'inline'  => 'span',
			'classes' => 'yellow-orange',
		),
		array(
			'title'   => 'Texte en rouge',
			'inline'  => 'span',
			'classes' => 'watermelon',
		),
		array(
			'title'   => 'Du code en thème light',
			'inline'  => 'span',
			'classes' => 'markup-code__light',
		),
		array(
			'title'   => 'Du code en thème dark',
			'inline'  => 'span',
			'classes' => 'markup-code__dark',
		),
		array(
			'title'   => 'Du code en thème neutre',
			'inline'  => 'span',
			'classes' => 'markup-code__neutral',
		),
		array(
			'title'   => 'Bloc de code en thème dark',
			'block'  => 'code',
			'classes' => 'markup-blockcode__dark',
			'wrapper' => true,
		),
		array(
			'title'   => 'Lien bouton bleu',
			'inline'  => 'span',
			// 'selector' => 'a',
			'classes' => 'btn-btn__sm-btn__blue',
			// 'wrapper' => true,
		),
	);

	$init_array['style_formats'] = json_encode( $style_formats );
	return $init_array;
}
// TinyMCE Enedis config saved
// {"settings":{"toolbar_1":"formatselect,bold,italic,bullist,numlist,alignleft,aligncenter,alignright,link,unlink,undo,redo,fullscreen","toolbar_2":"styleselect,outdent,indent,pastetext,removeformat,charmap,table,wp_help","toolbar_3":"","toolbar_4":"","options":"","plugins":"table,importcss"},"admin_settings":{"options":"importcss","disabled_editors":"edit_post_screen,on_front_end"}}


/*------------------------------------*\
		ALLOW FILES TYPE
\*------------------------------------*/
add_filter('upload_mimes', 'files_mime_types');
function files_mime_types($mimes){
	$mimes['svg'] = 'image/svg+xml';
	$mimes['vcf'] = 'text/x-vcard';
 	$mimes['zip'] = 'application/zip';
  $mimes['gz']  = 'application/x-gzip';
	$mimes['json'] = 'text/json';
	$mimes['json'] = 'application/json';
	$mimes['json'] = 'text/plain';
	$mimes['ai'] = 'application/illustrator';
	$mimes['eps'] = 'application/postscript';
	$mimes['psd'] = 'image/vnd.adobe.photoshop';
	$mimes['tiff'] = 'image/tiff';
	$mimes['txt'] = 'text/*';

	// Optional. Remove a mime type.
	unset( $mimes['exe'] );

	return $mimes;
}

// Dump mime types managed by WP
// add_action( 'template_redirect', 'my_theme_output_upload_mimes' );
// function my_theme_output_upload_mimes() {
// 	var_dump( wp_get_mime_types() );
// }

?>
