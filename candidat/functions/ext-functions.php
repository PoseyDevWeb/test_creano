<?php
/*------------------------------------*\
		CUSTOM FUNCTIONS
\*------------------------------------*/
function pm($element, $exit = false){
	echo '<pre>';
	print_r($element);
	echo '</pre>';
	$exit == true ? exit() : null;
}


/*------------------------------------*\
		@GET ID BY TEMPLATE NAME
\*------------------------------------*/
function get_id_by_template_name($template_name){
	$args = array(
    'post_type' => 'page',
    'fields' => 'ids',
    'nopaging' => true,
    'meta_key' => '_wp_page_template',
    'meta_value' => $template_name
	);
	$pages = get_posts( $args );

	if( sizeof($pages) <= 0)
		return false;

	$page_id = $pages[0];
	return $page_id;
}


/*------------------------------------*\
		String Manipulation
\*------------------------------------*/
/*
 * @transform string to remove accents
 */
function skip_accents( $str, $charset='utf-8' ) {
	$str = str_replace(array('ā','ī'), array('a', 'i'), $str);
	$str = htmlentities( $str, ENT_NOQUOTES, $charset );
	$str = preg_replace( '#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str );
	$str = preg_replace( '#&([A-za-z]{2})(?:lig);#', '\1', $str );
	$str = preg_replace( '#&[^;]+;#', '', $str );
	return $str;
}

/*
 * @transform string to variable naming convention
 */
function transform_to_value($string, $tiret = false){
	$string = str_replace(' & ', '-', $string);
	$trim_string = trim($string);

	if($tiret){

		$string_no_space = str_replace(array(' ', '　', '--', '_', '・', '<br>'), '-', $trim_string);

	} else {

		$string_no_space = str_replace(array(' ', '--', '-'), '_', $trim_string);

	}

	$value_string = strtolower($string_no_space);
	$value_string = skip_accents($value_string);

	return $value_string;
}

// Create Excerpt
function shorten_text($text, $max_length = 140, $cut_off = '...', $keep_word = false){
	if( strlen($text) <= $max_length )
		return $text;

	if( strlen($text) > $max_length ){
		if( $keep_word ){
			$text = substr($text, 0, $max_length + 1);

			if( $last_space = strrpos($text, ' ') ){
				$text = substr($text, 0, $last_space);
				$text = rtrim($text);
				$text .=  $cut_off;
			}
		} else {
			$text = substr($text, 0, $max_length);
			$text = rtrim($text);
			$text .=  $cut_off;
		}
	}
	return $text;
}


/*------------------------------------*\
EMAIL ENCODING
\*------------------------------------*/
function encode_email($e) {
	$output = '';
	for ($i = 0; $i < strlen($e); $i++) {
		$output .= '&#'.ord($e[$i]).';';
	}
	return $output;
}

?>
