<?php
function process_users() {
	// URL de base de l'API REST de WordPress
	$base_url = 'http://localhost/candidat//wp-json/wp/v2/users';

	// Fonction pour effectuer une requête GET à l'API REST de WordPress
	function make_request($url) {
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			return json_decode($response, true);
	}

	// Vérification et récupération de l'utilisateur connecté
	$connected_user = wp_get_current_user(); // Fonction WordPress pour obtenir l'utilisateur connecté

	if ($connected_user && !is_wp_error($connected_user)) {
			$connected_user_login = $connected_user->user_login;
			// Vérification de l'utilisateur connecté "test_meta"
			if ($connected_user_login === 'test_meta') {
					echo "Utilisateur connecté trouvé : " . $connected_user_login . "<br>";
					echo "<br>";
					echo " L'ID de l'utilisateur connecté est : " . $connected_user->ID . "<br>";
					echo "<br>";
					echo " L'EMAIL de l'utilisateur connecté est : " . $connected_user->user_email . "<br>";
					echo "<br>";
					echo " L'URL de l'utilisateur connecté est : " . $connected_user->user_url . "<br>";
					echo "<br>";

			} else {
					echo "L'Utilisateur connecté n'est pas 'test_meta', c'est : " . $connected_user_login . "<br>";
			}
	} else {
			echo "Aucun utilisateur connecté ou erreur lors de la récupération de l'utilisateur connecté.<br>";
	}

	// Récupération de l'utilisateur non connecté "info_meta"
	$info_meta_url = $base_url . '?search=info_meta'; // URL pour chercher l'utilisateur "info_meta"
	$info_meta_users = make_request($info_meta_url);

	if (!empty($info_meta_users)) {
			foreach ($info_meta_users as $info_meta_user) {
					$info_meta_login = $info_meta_user['login'];
					echo "Utilisateur non connecté 'info_meta' trouvé : " . $info_meta_login . "<br>";
					// Faire ce que tu veux avec l'utilisateur "info_meta"
			}
	} else {
			echo "Aucun utilisateur 'info_meta' trouvé.<br>";
	}
}




//EXO 2 : Exercice 2 : manipulation de tableau en php

function get_custom_post_meta_values() {
	$args = array(
			'post_type' => 'post', // Le type de publication que tu veux récupérer
			'meta_key' => 'test_array', // Clé meta que tu cherches
			'meta_compare' => '=', // Condition de comparaison (dans ce cas, égal à)
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) {
			while ($query->have_posts()) {
					$query->the_post();
					$meta_value = get_post_meta(get_the_ID(), 'test_array', true);

					$my_array = unserialize($meta_value);


				// Utilisation de la fonction pour trier les membres
				trierMembresParAnciennete($my_array);








echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
			// Utilisation de la fonction avec ton tableau
$projets_uniques = listerProjetsSansDoublons($my_array);

// Affichage des projets uniques
echo "2)Projets de l'agence (sans doublons) : <br>";
foreach ($projets_uniques as $projet) {
    echo "- $projet <br>";
}



echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo  " 3)  Ajoute à 'Creano_arcadia' un projet qui ne figure pas déjà dans sa liste de projets en piochant dans les projets à dispo de l'agence.";
echo "<br>";
echo "<br>";

// Projet disponible pour ajouter à Creano_arcadia
$projet_disponible = 'femmes du tourisme'; // Remplace avec le projet à ajouter
$match = 0;
foreach ($projets_uniques as $projet) {
	if ($projet_disponible == $projet) {
		$match++;

echo "</pre>";
}
}

if($match == 1) {
// Appel de la fonction pour ajouter un projet à Creano_arcadia
$my_array = ajouterProjetCreanoArcadia($my_array, $projet_disponible);
// Affichage des projets mis à jour de Creano_arcadia
echo "<pre>";
print_r($my_array['creano']['membres']['Creano_arcadia']['projet']);
}
else {
	echo "Le projet " .$projet_disponible. " n'est pas dispo dans les projets de l'agence.";

}




//liste tous les rôles 'Dev' qui ont plus de 3 projets incluant 'Vizio' dans leurs projets
$resultat = trouverDevsAvecVizio($my_array);


echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo  " 4) liste tous les rôles 'Dev' qui ont plus de 3 projets incluant 'Vizio' dans leurs projets";
echo "<br>";
echo "<br>";

print_r($resultat);

// // Affichage des résultats
// print_r($resultat);







			}
			wp_reset_postdata();
	} else {
			echo 'Aucun résultat trouvé.';
	}
}






//fonction pour trier
function trierMembresParAnciennete($my_array) {
	function compareAnciennete($a, $b) {
			return floatval($a['Ancienneté']) < floatval($b['Ancienneté']);
	}

	$membres = $my_array['creano']['membres'];

	usort($membres, 'compareAnciennete');

	return $membres;
}


//fonction pour lister les projets sans doublons
function listerProjetsSansDoublons($my_array) {
	$projets = [];

	// Parcourir le tableau pour extraire les projets
	foreach ($my_array['creano']['membres'] as $membre) {
			foreach ($membre['projet'] as $projet) {
					// Ajouter chaque projet dans un tableau pour éliminer les doublons
					$projets[] = $projet;
			}
	}

	// Retourner les projets uniques
	return array_unique($projets);
}


function ajouterProjetCreanoArcadia($my_array, $projet_disponible) {
	// Vérifier si Creano_arcadia existe dans le tableau
	if (isset($my_array['creano']['membres']['Creano_arcadia']) ) {
			// Récupérer les projets de Creano_arcadia
			$projets_arcadia = $my_array['creano']['membres']['Creano_arcadia']['projet'];

			// Vérifier si le projet n'est pas déjà dans la liste de Creano_arcadia
			if (!in_array($projet_disponible, $projets_arcadia)) {
					// Ajouter le projet à la liste de Creano_arcadia
					$my_array['creano']['membres']['Creano_arcadia']['projet'][] = $projet_disponible;

					echo "Le projet " .$projet_disponible. " a été ajouté à la liste de Creano_arcadia.";
			} else {
					echo "Le projet " .$projet_disponible. " existe déjà dans la liste de Creano_arcadia.";
			}
	} else {
			echo "Creano_arcadia n'existe pas dans les données fournies";
	}

	return $my_array;
}






function trouverDevsAvecVizio($array) {
	$devsAvecVizio = [];

	foreach ($array['creano']['membres'] as $membre) {
			if ($membre['role'] === 'Dev' && isset($membre['projet']) && count($membre['projet']) > 3 && in_array('Vizio', $membre['projet'])) {
					$devsAvecVizio[] = $membre;
			}
	}

	return $devsAvecVizio;
}



// Appeler la fonction au début
 process_users();
get_custom_post_meta_values();

