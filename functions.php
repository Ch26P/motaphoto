<?php
function theme_motaphoto()
{
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails', array('post', 'photos')); //ajout des image de mise en avant dans les post 
    add_theme_support('menus');

    register_nav_menu('header', 'En tete');
    register_nav_menu('footer', 'pied de page');
}/*verifier les fonctions a installé ex:htlm5 ?*/



function theme_motaphoto_assets()
{
    wp_enqueue_style('motaphoto-style', get_stylesheet_uri(), array());  //css

    wp_enqueue_script('jquery', "//code.jquery.com/jquery-1.12.0.min.js");
    wp_enqueue_script('modal-contact', get_stylesheet_directory_uri() . '/js/modal_contact.js', [], 1.0, true);

    // Charger un script spécifique pour la front page
    if (is_front_page()) {
        wp_enqueue_script(
            'more_pictures',
            get_template_directory_uri() . '/js/script-ajax-front.js',
            ['jquery'],
            '1.0',
            true
        );
    }
}





/*****************************************************************************/

function mota_photo_init()
{


    register_post_type('photos', [
        'label' => 'photos',
        'public' => true,
        'menu_position' => 2,
        'menu_icon' => 'dashicons-images-alt2',
        'supports' => ['thumbnail', 'title', 'revisions', 'post-formats', 'editor'/*, 'author','comments', 'excerpt', , 'page-attributes'*/],
        'show_in_rest' => true,
        'has_archive' => true,

    ]);
}


/*filtrer les nom des colonnes de "photos" */
add_filter('manage_photos_posts_columns', function ($columns) {
    //   var_dump($columns);

    return [
        'cb' => $columns['cb'],
        'title' => $columns['title'],
        'thumbnail' => 'Miniature',
        'taxonomy-format' =>  'Formats',
        'taxonomy-categorie' => 'categories',
        'Type' => 'type',
        'reference' => 'référence',
        'date_prise' => 'date',
        'date' => $columns['date'],
    ];
});
/** filtrer le contenue des colonnes de "photos"*/
add_filter('manage_photos_posts_custom_column', function ($column, $postId) {

    if ($column === 'thumbnail') {
        the_post_thumbnail('thumbnail', $postId);
    }

    if ($column === 'reference') {

        echo (get_field('référence',  $postId));
    }

    if ($column === 'Type') {
        echo (get_field('type',  $postId));
    }

    if ($column === 'date_prise') {
        echo (get_field('date_photo',  $postId));
    }
}, 10, 2);



/**********************************************************************/
/*hook filter menu 'header'*/

function add_contact_link_to_menu_header($items, $args)
{
    if ($args->theme_location == 'header') {
        $admin_url = admin_url();
        $items .= '<li class="lien_contact"><a href=# >CONTACTS</a></li>';
    }
    return $items;
};
/*hook filter menu 'footer'*/

function add_TDR_link_to_menu_footer($items, $args)
{
    if ($args->theme_location == 'footer') {
        $admin_url = admin_url();
        $items .= '<li><span>TOUS DROITS RESERVES</span></li>';
    }
    return $items;
};

/************************************************************************************************** */

/*pagination infinit*/
function load_more_pictures()
{

    // Vérification de sécurité
    /*  if (
        !isset($_REQUEST['nonce']) or
        !wp_verify_nonce($_REQUEST['nonce'], 'load_more_pictures')
    ) {
        wp_send_json_error("Vous n’avez pas l’autorisation d’effectuer cette action.", 403);
    }*/

    $query = new WP_Query(
        [

            'post_type' => 'photos', //type de contenue a recuperer
            'posts_per_page' => 8, //nbrs de post dans la page(pagination)
            'orderby' => 'rand', // post organiser de maniere aleatoire
            //'nopaging'=>'true',
        ]
    );
    $new_pictures = "";
    if ($query->have_posts()) {

        while ($query->have_posts()) : $query->the_post();

            echo (" <a href=" . get_permalink() . ">" . the_post_thumbnail('medium') . " </a>"); // concatener

        endwhile;
        $new_pictures = ob_get_clean();
        // var_dump($new_pictures);
        // Envoyer les données au navigateur

    }
    wp_send_json_success(array('html' => $new_pictures));
    die();
};
/************************/
add_action('wp_ajax_load_more_pictures', 'load_more_pictures');
add_action('wp_ajax_nopriv_load_more_pictures', 'load_more_pictures');
/*********************** */
/************************************************************************************************* */


add_action('init', 'mota_photo_init');
add_action('after_setup_theme', 'theme_motaphoto');
add_action('wp_enqueue_scripts', 'theme_motaphoto_assets');


add_filter('wp_nav_menu_items', 'add_contact_link_to_menu_header', 10, 2);
add_filter('wp_nav_menu_items', 'add_TDR_link_to_menu_footer', 11, 2);
