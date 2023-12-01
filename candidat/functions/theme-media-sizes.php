<?php
/*
 * Add custom image sizes
 */

// JPEG quality > 90
add_filter('jpeg_quality', function($arg){return 90;});


add_theme_support( 'post-thumbnails' );

// TODO: checker pourquoi taille pas prise en compte
// taille d'image à utiliser pour bandeau actu
add_image_size( 'banner', 1240, 370, true );

/* INFOS Tailles images:
- miniatures : thumbnail actu
- banner: image une actu
- moyenne: contenu de page
- grande taille : carousel home et page header
*/

?>
