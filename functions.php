<?php 
 function theme_motaphoto(){
add_theme_support('title-tag');
add_theme_support( 'custom-logo' );
add_theme_support('menus');
register_nav_menu( 'header', 'En tete' );
register_nav_menu( 'footer', 'pied de page' );
//add_theme_support( 'post-thumbnails', array( 'post', 'recette','ingredient') );  /** ajout des image de mise en avant dans les post */
/** add_theme_support( 'post-thumbnails', array( 'recette' ) );ajout des image de mise en avant dans recettes */
/**add_theme_support( 'post-thumbnails', array( 'ingredient' ) ); ajout des image de mise en avant dans ingredient */
}/*verifier les fonctions a installé ex:htlm5 ?*/

function theme_motaphoto_assets(){
    wp_enqueue_style('motaphoto-style', get_stylesheet_uri(),array());  //css
 }

add_action('after_setup_theme','theme_motaphoto');
add_action('wp_enqueue_scripts','theme_motaphoto_assets');
?>