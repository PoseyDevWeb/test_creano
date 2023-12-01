<?php
/*------------------------------------*\
		ShortCode Functions
\*------------------------------------*/
// youtube embed
add_shortcode('youtube', 'youtube');
function youtube($atts, $content = null) {
	return '<div class="embed-video"><iframe src="https://www.youtube.com/embed/'. do_shortcode($content) .'?modestbranding=1&rel=0&showinfo=0&color=white" frameborder="0" allowfullscreen></iframe></div>';
}


// vimeo embed
add_shortcode('vimeo', 'vimeo');
function vimeo($atts, $content = null) {
	return '<div class="embed-video"><iframe src="https://player.vimeo.com/video/'. do_shortcode($content) .'?title=0&byline=0&portrait=0&badge=0&autoplay=1" frameborder="0" allowfullscreen></iframe></div>';
}


// PDF embed
add_shortcode('pdf', 'pdf');
function pdf($atts, $content = null) {
	$a = shortcode_atts( array(
		'height' => '1000',
	), $atts );
	return do_shortcode('[pdf-embedder url="' . $content. '"]');
}


// Iframe embed
add_shortcode('iframe', 'iframe');
function iframe($atts, $content = null) {
	$a = shortcode_atts( array(
		'height' => '1000',
	), $atts );
	return '<div class="embed-iframe"><iframe src="'. do_shortcode($content) .'" width="100%" height="'. esc_attr($a['height']) .'" frameborder="0" allowfullscreen="true"></iframe></div>';
}


/*------------------------------------*\
		SWAGGER SHORTCODE GENERATOR
\*------------------------------------*/
add_shortcode('addswagger', 'swagger_shortcode');
function swagger_shortcode ($atts) {
	$url = shortcode_atts(array('url' => ''), $atts);

	$swagger = "<script type='text/javascript'>var json_url='".$atts['url']."';</script><div id='embed-swagger-container'></div>";

	return $swagger;

}

?>
