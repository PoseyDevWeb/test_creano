<?php

/* Custom Post Services
*******************/
function custom_post_type_services() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => _x( 'Services', 'Post Type General Name', 'coditrans' ),
		'singular_name'       => _x( 'service', 'Post Type Singular Name', 'coditrans' ),
		'menu_name'           => __( 'Services', 'coditrans' ),
		'parent_item_colon'   => __( 'service', 'coditrans' ),
		'all_items'           => __( 'Tous les services', 'coditrans' ),
		'view_item'           => __( 'Voir le service', 'coditrans' ),
		'add_new_item'        => __( 'Ajouter un service', 'coditrans' ),
		'add_new'             => __( 'Ajouter', 'coditrans' ),
		'edit_item'           => __( 'Editer le service', 'coditrans' ),
		'update_item'         => __( 'Modifier le service', 'coditrans' ),
		'search_items'        => __( 'Chercher un service', 'coditrans' ),
		'not_found'           => __( 'Non trouvé', 'coditrans' ),
		'not_found_in_trash'  => __( 'Non trouvé dans la corbeille', 'coditrans' ),
	);

// Set other options for Custom Post Type

	$args = array(
		'label'               => __( 'services', 'coditrans' ),
		'description'         => __( 'Permet de gérer les services', 'coditrans' ),
		'labels'              => $labels,
		'supports'            => array( 'title' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 30,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
		'menu_icon' => 'dashicons-admin-multisite',
		'menu_position' => 5
	);

	// Registering your Custom Post Type
	register_post_type( 'services', $args );

}

/* Hook into the 'init' action so that the function
* Containing our post type registration is not
* unnecessarily executed.
*/

add_action( 'init', 'custom_post_type_services', 0 );

/* Custom Taxonomy
*******************/
register_taxonomy(
	'type_de_clients',
	'services',
	array(
		'label' => 'Type de clients',
		'show_admin_column' => true,
		'labels' => array(
			'name' => 'Type de clients',
			'singular_name' => 'Type de client',
			'all_items' => 'Tous les type de clients',
			'edit_item' => 'Éditer le type de client',
			'view_item' => 'Voir le type de client',
			'update_item' => 'Mettre à jour le type de client',
			'add_new_item' => 'Ajouter un type de client',
			'new_item_name' => 'Nouvelle type de client',
			'search_items' => 'Rechercher parmi les type de clients',
			'popular_items' => 'Type de client les plus utilisés'
		),
		'hierarchical' => true
	)
);
register_taxonomy_for_object_type( 'type_de_clients', 'services' );


/* Custom Taxonomy
*******************/
register_taxonomy(
	'type_de_services',
	'services',
	array(
		'label' => 'Type de services',
		'show_admin_column' => true,
		'labels' => array(
			'name' => 'Type de services',
			'singular_name' => 'Type de service',
			'all_items' => 'Tous les type de services',
			'edit_item' => 'Éditer le type de service',
			'view_item' => 'Voir le type de service',
			'update_item' => 'Mettre à jour le type de service',
			'add_new_item' => 'Ajouter un type de service',
			'new_item_name' => 'Nouvelle type de service',
			'search_items' => 'Rechercher parmi les type de services',
			'popular_items' => 'Type de service les plus utilisés'
		),
		'hierarchical' => true
	)
);
register_taxonomy_for_object_type( 'type_de_services', 'services' );
