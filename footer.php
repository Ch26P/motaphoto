
<footer>
    <?php
    // Output the contact modal.
    get_template_part('template-parts/modal-contact');
    
    //Output modal-Lightbox
    get_template_part('template-parts/modal-Lightbox');

    //affichage menu
    wp_nav_menu(['theme_location' => 'footer']) 
    ?>
</footer>
<?php wp_footer() ?>
</body>

</html>