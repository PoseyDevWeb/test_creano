<?php
/*------------------------------------*\
		LOAD CUSTOM JS ON ADMIN => used for Carbon fields
\*------------------------------------*/
add_action('admin_enqueue_scripts', 'crb_load_scripts');
function crb_load_scripts() {
	// comment l.13 and uncomment l.12 if error found
	// wp_enqueue_script('custom-js', '/wp-content/themes/enedis/assets/js/admin-custom.js');
	wp_enqueue_script('custom-js', get_template_directory_uri() . "/assets/js/admin-custom.js");
}

?>
