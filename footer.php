
<footer>
    <?php
    // Output the contact modal.
    get_template_part('template-parts/modal-contact');
    ?>
    <?php
    wp_nav_menu(['theme_location' => 'footer']) //affichage menu
    ?>
</footer>
<?php wp_footer() ?>
</body>

</html>