<?php
/*
 * Add sidebar class
 */
add_action( 'wp_head', create_function( '', 'ob_start();' ) );
add_action( 'get_sidebar', 'my_sidebar_class' );
add_action( 'wp_footer', 'my_sidebar_class_replace' );

function my_sidebar_class( $name = '' ) {

	static $class = 'have-sidebar';

	if ( ! empty( $name ) )
		$class .= ' sidebar-' . $name;

	my_sidebar_class_replace( $class );

}

function my_sidebar_class_replace( $c = '' ) {
	static $class = '';
	if ( ! empty( $c ) ) {
		$class = $c;
	} else {
		echo str_replace( '<body class="', '<body class="' . $class . ' ', ob_get_clean() );
		ob_start();
	}
}


/*
 * If Dynamic Sidebar Exists
 */
if (function_exists('register_sidebar')) {
  // Define Sidebar Widget Area 1
	register_sidebar(array(
		'name'          => __('Widget 1', 'wpblank'),
		'description'   => __('Description de la zone de widget', 'wpblank'),
		'id'            => 'widget-area-1',
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	));

}

?>
