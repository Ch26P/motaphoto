<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php wp_head() ?> <!--  +wp_footer=> insersion nav barr wp -->
</head>

<body>
    <header>
        <?php
$custom_logo_id = get_theme_mod( 'custom_logo' );
$custom_logo_url = wp_get_attachment_image_url( $custom_logo_id , 'complet' );
echo '<img src="' . esc_url( $custom_logo_url ) . '" alt="logo" class="img_logo">';
?>
        <?php
         wp_nav_menu(['theme_location' => 'header']) //affichage menu
?>
    </header>
    <div class="container">