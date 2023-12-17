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
        <nav>
            <div class="container_navbar">
                <?php
                $custom_logo_id = get_theme_mod('custom_logo');
                $custom_logo_url = wp_get_attachment_image_url($custom_logo_id, 'complet'); ?>
                <a href="<?php site_url(); ?>" ><?php echo '<img src="' . esc_url($custom_logo_url) . '" alt="logo" class="img_logo">'; ?></a>
                <div class="container_menus">
                    <?php
                    wp_nav_menu(['theme_location' => 'header']) //affichage menu
                    ?>
                <!--    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">-->
                    <button class="mobile_menu">
                        <span id="line_1" class="line"></span>
                        <span id="line_2" class="line"></span>
                        <span id="line_3" class="line"></span>
                    </button>
                </div>

            </div>
            <div class="burger_menu">

                <?php
                wp_nav_menu(['theme_location' => 'header', 'container' => false]) //affichage menu
                ?>
            </div>
        </nav>
    </header> <!-- #site-header -->


    