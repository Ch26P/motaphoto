<?php
function theme_motaphoto()
{
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails', array('post', 'photos')); //ajout des image de mise en avant dans les post 
    add_theme_support('menus');

    register_nav_menu('header', 'En tete');
    register_nav_menu('footer', 'pied de page');

    // Définir d'autres tailles d'images : 
    // les options de base WP : 
    //      'thumbnail': 150 x 150 hard cropped 
    //      'medium' : 300 x 300 max height 300px
    //      'medium_large' : resolution (768 x 0 infinite height)
    //      'large' : 1024 x 1024 max height 1024px
    //      'full' : original size uploaded
    add_image_size('hero', 1440, 962, true);
    add_image_size('galerie', 600, 520, true);
    //add_image_size( 'lightbox', 1300, 900, true );


}/*verifier les fonctions a installé ex:htlm5 ?*/



function theme_motaphoto_assets()
{
    wp_enqueue_style('motaphoto-style', get_stylesheet_uri(), array());  //css

    wp_enqueue_script('jquery', "//code.jquery.com/jquery-1.12.0.min.js");
    wp_enqueue_script('modal-contact', get_stylesheet_directory_uri() . '/js/modal_contact.js', [], 1.0, true);

    // Charger des scripts spécifique pour la front page
    if (is_front_page()) {
        wp_enqueue_script(
            'more_pictures',
            get_template_directory_uri() . '/js/script-ajax-front.js',
            ['jquery'],
            '1.0',
            true
        );
    };
    wp_enqueue_script(
        'lightbox-ajax',
        get_template_directory_uri() . '/js/lightbox-ajax.js',
        ['jquery'],
        '1.0',
        true
    );

    wp_enqueue_script(
        'lightbox-in-ajax',
        get_template_directory_uri() . '/js/lightbox_in.js',
        ['jquery'],
        '1.0',
        true
    );
}





/*****************************************************************************/

function mota_photo_init()
{


    register_post_type('photos', [
        'label' => 'photos',
        'public' => true,
        'menu_position' => 2,
        'menu_icon' => 'dashicons-images-alt2',
        'supports' => ['thumbnail', 'title', 'revisions', 'post-formats'/*, 'editor', 'author','comments', 'excerpt', , 'page-attributes'*/],
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
        //   'date_prise' => 'date',
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


///filtres
function filtre_pictures()
{

    // Vérification de sécurité
    /* */
    if (
        !isset($_REQUEST['nonce']) or
        !wp_verify_nonce($_REQUEST['nonce'], ' filtre_pictures')
    ) {
        wp_send_json_error("Vous n’avez pas l’autorisation d’effectuer cette action.", 403);
    }

    /**************************************recuperer les valeur des taxomanie dans une varaible*********************************************************************** */


    $all_categorie = array_map(function ($term) {
        return $term->name;
    }, get_terms("categorie"));

    /*exemple avec foreach
    foreach ((get_terms("categorie")) as $terms) {
    return $terms->name; }
    */

    $all_format = array_map(function ($term) {
        return $term->name;
    }, get_terms("format"));



    /******************************************************************************************************************** */
    //recuperation des variables
    $paged = $_POST["page"];
    $order = $_POST['order'];
    if (

        (isset($_POST["categorie"]) && is_string($_POST["categorie"])) //verifier $_POST[] exist et si bien une chaine et si elle n est pas vide
        && $_POST["categorie"] !== ""
    ) {
        $categorie = $_POST["categorie"];
    } else {
        $categorie = $all_categorie;
    }

    if (

        (isset($_POST["format"]) && is_string($_POST["format"])) //verifier $_POST[] exist et si bien une chaine et si elle n est pas vide
        && $_POST["format"] !== ""
    ) {
        $format = $_POST["format"];
    } else {
        $format = $all_format;
    }
    /******************************************************************************************************** */

    $query = new WP_Query(

        [
            'post_status' => 'publish', //selement les posts publié
            'post_type' => 'photos', //type de contenue a recuperer
            'posts_per_page' => 8, //nbrs de post dans la page(pagination)

            // 'orderby' =>'meta_value_num', // //
            'order' => $order,
            'orderby' => 'date',
            'paged' => $paged, //

            'tax_query' =>
            [

                'relation' => 'AND', //
                [
                    'taxonomy' => 'categorie', //
                    'field' => 'slug',
                    'terms' => $categorie,

                ],
                [
                    'taxonomy' => 'format',
                    'field' => 'slug', //
                    'terms' => $format,

                ]
            ]
        ]
    );
    $new_page_filter = "";


    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) :
            $query->the_post(); ?>

            <div id="<?php echo (get_the_ID()) ?>" class="box">
                <a href="<?php echo (get_permalink()) ?>" class="Icon Icon_eye">
                    <img src="<?php echo get_template_directory_uri() . '/assets/images/Icon_eye.png' ?>" alt="">
                </a>

                <img src="<?php echo get_template_directory_uri() . '/assets/images/Icon_fullscreen.png' ?>" class="Icon Icon_fullscreen" alt="">

                <img src="<?php the_post_thumbnail_url('galerie'); ?>" alt="" class="img_photo">

                <h3 class="info-tittle"><?php the_title(); ?></h3>
                <h3 class="info-taxo"><?php the_terms(get_the_ID(), "categorie") ?></h3>

            </div>
        <?php endwhile;
        $new_page_filter = ob_get_clean();

        // Envoyer les données au navigateur
        wp_send_json_success(array('html' => $new_page_filter));
    } else {
        wp_send_json_success(array('html' => ""));
    }

    wp_reset_postdata(); // ! important réinisialise les donéé du post apres la boucle

    die();
};
/***************************** */
add_action('wp_ajax_filtre_pictures', 'filtre_pictures');
add_action('wp_ajax_nopriv_filtre_pictures', 'filtre_pictures');

/******************************* */

/************************************************************************************************** */

/*pagination infinit*/
function load_more_pictures()
{

    // Vérification de sécurité
    if (
        !isset($_REQUEST['nonce']) or
        !wp_verify_nonce($_REQUEST['nonce'], 'load_more_pictures')
    ) {
        wp_send_json_error("Vous n’avez pas l’autorisation d’effectuer cette action.", 403);
    }

    /**************************************recuperer les valeur des taxomanie dans une varaible*********************************************************************** */


    $all_categorie = array_map(function ($term) {
        return $term->name;
    }, get_terms("categorie"));

    /*exemple avec foreach
    foreach ((get_terms("categorie")) as $terms) {
    return $terms->name; }
    */

    $all_format = array_map(function ($term) {    //recupere tous les 
        return $term->name;
    }, get_terms("format"));



    /******************************************************************************************************************** */
    //recuperation des variables
    $paged = $_POST["page"];
    $order = $_POST['order'];
    if (

        (isset($_POST["categorie"]) && is_string($_POST["categorie"])) //verifier $_POST[] exist et si bien une chaine et si elle n est pas vide
        && $_POST["categorie"] !== ""
    ) {
        $categorie = $_POST["categorie"];
    } else {
        $categorie = $all_categorie;
    }

    if (

        (isset($_POST["format"]) && is_string($_POST["format"])) //verifier $_POST[] exist et si bien une chaine et si elle n est pas vide
        && $_POST["format"] !== ""
    ) {
        $format = $_POST["format"]; // si ok recupere la valeur envoyer
    } else {
        $format = $all_format; // sinon assigne toute les valeurs de la taxonomie
    }
    /******************************************************************************************************** */

    $query = new WP_Query(

        [
            'post_status' => 'publish', //selement les posts publié
            'post_type' => 'photos', //type de contenue a recuperer
            'posts_per_page' => 8, //nbrs de post dans la page(pagination)
            'order' => $order,
            'orderby' => 'date',
            'paged' => $paged,

            'tax_query' =>
            [

                'relation' => 'AND',
                [
                    'taxonomy' => 'categorie',
                    'field' => 'slug',
                    'terms' => $categorie,

                ],
                [
                    'taxonomy' => 'format',
                    'field' => 'slug',
                    'terms' => $format,

                ]
            ]
        ]
    );
    $new_pictures = "";


    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) :
            $query->the_post(); ?>
            <div id="<?php echo (get_the_ID()) ?>" class="box">
                <a href="<?php echo (get_permalink()) ?>" class="Icon Icon_eye">
                    <img src="<?php echo get_template_directory_uri() . '/assets/images/Icon_eye.png' ?>" alt="">
                </a>

                <img src="<?php echo get_template_directory_uri() . '/assets/images/Icon_fullscreen.png' ?>" class="Icon Icon_fullscreen" alt="">

                <img src="<?php the_post_thumbnail_url('galerie'); ?>" alt="" class="img_photo">

                <h3 class="info-tittle"><?php the_title(); ?></h3>
                <h3 class="info-taxo"><?php the_terms(get_the_ID(), "categorie") ?></h3>
            </div>

        <?php


        //     echo( "<article  id=" . get_the_ID() . " class= ".$paged."> <a href=" . get_permalink() . ">" . the_post_thumbnail('medium') . "</a> </article>");

        //  echo " <a href=" . get_permalink() . ">" . the_post_thumbnail('medium') . " </a>"; // concatener

        endwhile;
        $new_pictures = ob_get_clean();

        // Envoyer les données au navigateur
        wp_send_json_success(array('html' => $new_pictures));
    } else {
        wp_send_json_success(array('html' => ""));
    }

    wp_reset_postdata(); // ! important réinisialise les donéé du post apres la boucle

    die();
};
/************************/
add_action('wp_ajax_load_more_pictures', 'load_more_pictures');
add_action('wp_ajax_nopriv_load_more_pictures', 'load_more_pictures');
/*********************** */
/************************************************************************************************* */
/*modal-lightbox*/
function load_lightbox()
{

    // Vérification de sécurité
    if (
        !isset($_REQUEST['nonce']) or
        !wp_verify_nonce($_REQUEST['nonce'], 'load_lightbox')
    ) {
        wp_send_json_error("Vous n’avez pas l’autorisation d’effectuer cette action.", 403);
    }

    //recuperation des variables
    $Id_post = $_POST["Id_post"];

    /******************************************************************************************************** */

    $query = new WP_Query(

        [
            'page_id' => $Id_post,
            'post_status' => 'publish', //selement les posts publié
            'post_type' => 'photos', //type de contenue a recuperer
            'posts_per_page' => 1, //nbrs de post dans la page(pagination)

        ]
    );
    $new_lightbox_picture = "";


    if ($query->have_posts()) {
        ob_start();
        while ($query->have_posts()) :
            $query->the_post(); ?>

            <div id="bloc_img_lightbox">

                <img src="<?php the_post_thumbnail_url('full'); ?>" alt="" class="modale_lightbox_content_img">

            </div>

            <div class="lightbox_arrow">
                <div class="lightbox_arrow_preview">
                    <?php if (get_previous_post()) : ?>
                        <?php
                        echo (get_the_post_thumbnail(get_previous_post()->ID, 'thumbnail', array('class' => 'miniature miniature_prev')));

                        echo '<img id="' . get_previous_post()->ID . '" class="arrows" src ="' . get_stylesheet_directory_uri() . ' /assets/images/arrow-left-w.png ">'
                        ?>

                        <span>Précedente</span>


                    <?php endif; ?>

                </div>
                <div class="lightbox_arrow_next">
                    <?php
                    $Post_suivant = get_next_post();
                    //var_dump($Post_suivant);
                    ?>
                    <?php
                    if (get_next_post()) : //verifie si le post suivant exist

                        echo (get_the_post_thumbnail(get_next_post()->ID, 'thumbnail', array('class' => 'miniature miniature_next')));
                    ?>
                        <span>Suivante</span>

                    <?php
                        echo '<img id="' . get_next_post()->ID . '" class="arrows" src ="' . get_stylesheet_directory_uri() . ' /assets/images/arrow-right-w.png ">';
                    endif; ?>
                </div>

            </div>
            <div class="lightbox_info">
                <span> <?php the_terms(get_the_ID(), "categorie"); // affiche la valeur de la taxonomie
                        ?>
                </span>
                <?php
                $list_champs = get_fields();
                if (get_fields() !== false) : ?>
                    <?php foreach ($list_champs as $name => $value) : ?>
                        <?php if ($name === "référence") : ?>

                            <span><?php echo $value; ?></span>
            </div>

            <div class="lightbox_close" title="Refermer cet agrandissement">

            </div>
<?php
                        endif;
                    endforeach;
                endif;
            endwhile;
            $new_lightbox_picture = ob_get_clean();

            // Envoyer les données au navigateur
            wp_send_json_success(array('html' => $new_lightbox_picture));
        } else {
            wp_send_json_success(array('html' => ""));
        }

        wp_reset_postdata(); // ! important réinisialise les donéé du post apres la boucle

        die();
    };
    /************************/
    add_action('wp_ajax_load_lightbox', 'load_lightbox');
    add_action('wp_ajax_nopriv_load_lightbox', 'load_lightbox');
    /*********************** */
    /************************************************************************************************* */
    /*lightbox-in*/
    function lightbox_change_post()
    {

        // Vérification de sécurité
        if (
            !isset($_REQUEST['nonce']) or
            !wp_verify_nonce($_REQUEST['nonce'], 'lightbox_change_post')
        ) {
            wp_send_json_error("Vous n’avez pas l’autorisation d’effectuer cette action.", 403);
        }

        /******************************************************************************************************************** */
        //recuperation des variables
        $Id_post = $_POST["Id_post"];

        /******************************************************************************************************** */

        $query = new WP_Query(

            [
                'page_id' => $Id_post,
                'post_status' => 'publish', //selement les posts publié
                'post_type' => 'photos', //type de contenue a recuperer
                'posts_per_page' => 1, //nbrs de post dans la page(pagination)

            ]
        );
        $new_lightbox_picture = "";


        if ($query->have_posts()) {
            ob_start();
            while ($query->have_posts()) :
                $query->the_post(); ?>

    <div id="bloc_img_lightbox">

    <img src="<?php the_post_thumbnail_url('full'); ?>" alt="" class="modale_lightbox_content_img">

 
</div>

<div class="lightbox_arrow">
    <div class="lightbox_arrow_preview">
        <?php if (get_previous_post()) : ?>
            <?php
                    echo (get_the_post_thumbnail(get_previous_post()->ID, 'thumbnail', array('class' => 'miniature miniature_prev')));
                    /*
                        echo (previous_post_link( //affiche un lien vers la page précédente 
                            $format = ' %link',
                            $link = '<img class="arrows" src ="' . get_stylesheet_directory_uri() . ' /assets/images/arrow-left-w.png ">', //inserer une fleche de pagination
                        ));
                        */
                    echo '<img id="' . get_previous_post()->ID . '" class="arrows" src ="' . get_stylesheet_directory_uri() . ' /assets/images/arrow-left-w.png ">'
            ?>

            <span>Précedente</span>


        <?php endif; ?>

    </div>
    <div class="lightbox_arrow_next">
        <?php
                $Post_suivant = get_next_post();
                //var_dump($Post_suivant);
        ?>
        <?php
                if (get_next_post()) : //verifie si le post suivant exist

                    echo (get_the_post_thumbnail(get_next_post()->ID, 'thumbnail', array('class' => 'miniature miniature_next')));
        ?>
            <span>Suivante</span>

        <?php /* echo (next_post_link( //affiche un lien vers la page suivante
                            $format = ' %link',
                            $link = '<img class="arrows" src ="' . get_stylesheet_directory_uri() . ' /assets/images/arrow-right-w.png ">' //inserer une fleche de pagination

                        ));*/
                    echo '<img id="' . get_next_post()->ID . '" class="arrows" src ="' . get_stylesheet_directory_uri() . ' /assets/images/arrow-right-w.png ">';
                endif; ?>
    </div>

</div>
<div class="lightbox_info">
    <span> <?php the_terms(get_the_ID(), "categorie"); // affiche la valeur de la taxonomie
            ?>
    </span>
    <?php
                $list_champs = get_fields();
                if (get_fields() !== false) : ?>
        <?php foreach ($list_champs as $name => $value) : ?>
            <?php if ($name === "référence") : ?>

                <span><?php echo $value; ?></span>
    <?php endif;
                    endforeach;
                endif; ?>
</div>

<div class="lightbox_close" title="Refermer cet agrandissement"></div>






<?php endwhile;
            $new_lightbox_picture = ob_get_clean();

            // Envoyer les données au navigateur
            wp_send_json_success(array('html' => $new_lightbox_picture));
        } else {
            wp_send_json_success(array('html' => ""));
        }

        wp_reset_postdata(); // ! important réinisialise les donéé du post apres la boucle

        //  die();
    };
    /************************/
    add_action('wp_ajax_lightbox_change_post', 'lightbox_change_post');
    add_action('wp_ajax_nopriv_lightbox_change_post', 'lightbox_change_post');
    /*********************** */
    add_action('init', 'mota_photo_init');
    add_action('after_setup_theme', 'theme_motaphoto');
    add_action('wp_enqueue_scripts', 'theme_motaphoto_assets');


    add_filter('wp_nav_menu_items', 'add_contact_link_to_menu_header', 10, 2);
    add_filter('wp_nav_menu_items', 'add_TDR_link_to_menu_footer', 11, 2);
