<!--

<div id="Modale_lightbox" class="modale_lightbox">
    <div class="modale_lightbox_bloc">
        <div class="modale_lightbox_content">
Bonjour
           
        </div>
        
    </div>
</div>
-->


<div class="modale_lightbox_bloc">
</div>
<form action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="ajax-lightbox_in">
    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('lightbox_change_post'); ?>">
    <input type="hidden" name="action" value="lightbox_change_post">
</form>
    <div class="modale_lightbox_content">
    
    </div>
