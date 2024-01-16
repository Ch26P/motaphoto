
<footer>

<form action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="ajax-lightbox">
				<input type="hidden" name="nonce" value="<?php echo wp_create_nonce('load_lightbox'); ?>">
				<input type="hidden" name="action" value="load_lightbox">
			</form>

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