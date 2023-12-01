<?php

/*------------------------------------*\
		BREADCRUMB
\*------------------------------------*/
function get_breadcrumb() {
	$post = [
		"membres",
		"projets",
	];

	$queriedObject = get_queried_object();
	$postType = isset($queriedObject->post_type) ? $queriedObject->post_type : null;
	$parent_link = get_post_type_archive_link($postType);
	$postName = ( isset($queriedObject->post_title) ? $queriedObject->post_title : $queriedObject->name );

	if($postName != "Accueil" && !empty($postName)) {
		echo '<a href="'.home_url().'" rel="nofollow">Accueil</a>';

		// Le post type
		if(in_array($postType, $post)) {
			if($parent_link) {
		//		echo "&nbsp;&#187;&nbsp;";
				echo "&nbsp;&rsaquo;&nbsp;";
				echo '<a href="' . $parent_link . '">';
				echo ucfirst($postType);
				echo '</a>';
			}
		}

		if($postType == "post"){
			$lang = pll_current_language();
			$actutext = carbon_get_theme_option('th_post_all_'.$lang);
			$actuurl = carbon_get_theme_option('th_post_url_'.$lang);
			echo "&nbsp;&rsaquo;&nbsp;";
			echo '<a href="' . $actuurl . '">';
			echo ucfirst($actutext);
			echo '</a>';
		}

		// Le Post
		//echo "&nbsp;&#187;&nbsp;";
		echo "&nbsp;&rsaquo;&nbsp;";
		echo '<em>';
		// Si post title existe, on l'affiche sinon on affiche le nom
		echo ucfirst( (isset($queriedObject->post_title) ? $queriedObject->post_title : $queriedObject->name) );
		echo '<em>';
	}
}




/**
 * Une "base" au cas où le besoin se fait sentir
 */
/*
	var_dump($queriedObject);
	exit;

	echo '<a href="'.home_url().'" rel="nofollow">Accueil</a>';
	if($postType) {
		// Le type de post
		echo "&nbsp;&#187;&nbsp;";
		echo "&nbsp;&rsaquo;&nbsp;";
		echo '<a href="' . $parent_link . '">';
		echo ucfirst($postType);
		echo '</a>';

		// Le Post
		echo "&nbsp;&#187;&nbsp;";
		echo "&nbsp;&rsaquo;&nbsp;";
		echo '<em>';
		echo ucfirst(get_queried_object()->post_title);
		echo '<em>';
	}
	else {
		echo "&nbsp;&#187;&nbsp;";
		echo "&nbsp;&rsaquo;&nbsp;";
		echo '<em>';
		echo ucfirst(get_queried_object()->name);
		echo '<em>';
	}
*/
