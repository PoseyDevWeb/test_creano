<?php
/*-------------------------------------------------------*\
		ADMIN NOTIFICATION
\*-------------------------------------------------------*/
add_filter( 'wp_mail_from', 'crn_sender_email' );
add_filter( 'wp_mail_from_name', 'crn_sender_name' );

// Function to change email address
function crn_sender_email( $original_email_address ) {
	//PREPROD
	// return 'noreply@codival.creano.paris';

	//PROD
	return 'noreply@codival.ci';
}

// Function to change sender name
function crn_sender_name( $original_email_from ) {
	return 'Codival';
}


// Disable admin notification on user change password
add_filter( 'wp_password_change_notification_email', 'disable_admin_notification_on_user_change_pass');
function disable_admin_notification_on_user_change_pass($wp_password_change_notification_email){
	return $wp_password_change_notification_email;
}

// Disable notification on user registration
if ( !function_exists('wp_new_user_notification') ) {
  function wp_new_user_notification( ) {}
}

add_filter( 'wp_mail_content_type', 'crn_wp_email_content_type' );
function crn_wp_email_content_type() {
    if(isset($GLOBALS["use_html_content_type"])){
        return 'text/html';
    }else{
        return 'text/plain';
    }
}

?>
