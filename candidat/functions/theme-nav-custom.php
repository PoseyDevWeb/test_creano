<?php
/******************************
*** CUSTOM MENU
******************************/
add_action( 'mbn_sitenav_level_two_title', 'mbn_add_sitenav_level_two_title' );
function mbn_add_sitenav_level_two_title() {
	$current_post_id = get_the_ID();
	$post_parent_id = wp_get_post_parent_id($current_post_id);

	if( !is_int($post_parent_id) )
		return;

	while ( $post_parent_id > 0 ) {
		$current_post_id = $post_parent_id;
		$post_parent_id = wp_get_post_parent_id($post_parent_id);
	}

	if( is_null(carbon_get_post_meta($current_post_id, 'level_1_picto')) )
		return;

	$level_1_picto_id = carbon_get_post_meta($current_post_id, 'level_1_picto'); ?>

	<div class="sitenav--level-two_title">
		<a href="<?= get_the_permalink($current_post_id) ?>">

			<?php if( $level_1_picto_id ){
				$level_1_picto = wp_get_attachment_image_src($level_1_picto_id, '')[0];
				$level_1_picto_alt = get_post_meta($level_1_picto_id, '_wp_attachment_image_alt', true); ?>

				<img src="<?= $level_1_picto ?>" alt="<?= $level_1_picto_alt ?>" />

			<?php } ?>

			<span><?= get_the_title($current_post_id) ?></span>
		</a>
	</div>

	<?php
}

?>
