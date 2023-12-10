<?php
function theme_motaphoto()
{
    add_theme_support('title-tag');
    add_theme_support('custom-logo');

    add_theme_support('post-thumbnails', array('post', 'photos')); //ajout des image de mise en avant dans les post 

    add_theme_support('menus');
    register_nav_menu('header', 'En tete');
    register_nav_menu('footer', 'pied de page');
    //add_theme_support( 'post-thumbnails', array( 'post', 'recette','ingredient') );  /** ajout des image de mise en avant dans les post */
    /** add_theme_support( 'post-thumbnails', array( 'recette' ) );ajout des image de mise en avant dans recettes */
    /**add_theme_support( 'post-thumbnails', array( 'ingredient' ) ); ajout des image de mise en avant dans ingredient */
}/*verifier les fonctions a installé ex:htlm5 ?*/
function theme_motaphoto_assets()
{
    wp_enqueue_style('motaphoto-style', get_stylesheet_uri(), array());  //css

    wp_enqueue_script('jquery', "//code.jquery.com/jquery-1.12.0.min.js");
    wp_enqueue_script('modal-contact', get_stylesheet_directory_uri() . '/js/modal_contact.js', [], 1.0, true);
}





/*****************************************************************************/

function mota_photo_init()
{


    register_post_type('photos', [
        'label' => 'photos',
        'public' => true,
        'menu_position' => 2,
        'menu_icon' => 'dashicons-images-alt2',
        'supports' => ['thumbnail', 'title', 'editor','revisions','author','comments','excerpt', 'post-formats', 'page-attributes'],
        'show_in_rest' => true,
        'has_archive' => true,

    ]);


    register_taxonomy('format', 'photos', [
        'labels' => [
            'name' => 'format',
            'edit_items' => 'tous les formats',
            'add_new_item' => 'Ajouter un nouveau format',
        ],
        'show_in_menu' => false,
        'show_in_rest' => true,
        'hierarchical' => false,
    ]);

    register_taxonomy('qualité','photos',[
    'labels'=> [
        'name'=> 'Type',
        'edit_items'=>'tous les types ',
       'add_new_item'=>'Ajouter type ',
    ],
    'show_in_menu' => false,
    'show_in_rest' => true,
    'hierarchical' => false ,
]);
    

    register_taxonomy('categories_photos', 'photos', [
        'labels' => [
            'name' => 'categories',
            'edit_items' => 'tous les categories',
            'add_new_item' => 'Ajouter une categorie',
        ],
        'show_in_menu' => false,
        'show_in_rest' => true,
        'hierarchical' => true,
    ]);

}







/**********************************************************************/
/*hook filter menu 'header'*/

function add_contact_link_to_menu_header($items, $args)
{
    if ($args->theme_location == 'header') {
        $admin_url = admin_url();
        $items .= '<li class="lien_contact"><a href=# >CONTACTS</a></li>';
    }
    return $items;
}
/*hook filter menu 'footer'*/

function add_TDR_link_to_menu_footer($items, $args)
{
    if ($args->theme_location == 'footer') {
        $admin_url = admin_url();
        $items .= '<li><span>TOUS DROITS RESERVES</span></li>';
    }
    return $items;
}
add_action('init', 'mota_photo_init');
add_action('after_setup_theme', 'theme_motaphoto');
add_action('wp_enqueue_scripts', 'theme_motaphoto_assets');


add_filter('wp_nav_menu_items', 'add_contact_link_to_menu_header', 10, 2);
add_filter('wp_nav_menu_items', 'add_TDR_link_to_menu_footer', 11, 2);
