(function ($) {
   
    $('body').click(function(e) {
       console.log(e.target.classList);
        if (e.target.classList.contains('Icon_fullscreen')) {


            var Id_post = jQuery(e.target).parents('.box').attr('id');
            var referenceValue = jQuery(".modale_lightbox_content").html();
            console.log("post"+Id_post);
            console.log(referenceValue);

            // Empêcher l'envoi classique du formulaire
            e.preventDefault();

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = $(".ajax-lightbox").attr('action');

            // Les données de notre formulaire
            const data = {
                action: $(".ajax-lightbox").find('input[name=action]').val(),
                nonce: $(".ajax-lightbox").find('input[name=nonce]').val(),
                Id_post: Id_post,
   
            }

            // Pour vérifier qu'on a bien récupéré les données
            //console.log(ajaxurl); 
            //console.log(data); 

            // Requête Ajax en Jquery

            $.ajax({
                url: ajaxurl,
                type: 'post',
                dataType: "html",
                data: data,

                success: function (response) {
                    console.log(response);//
                    let rl = JSON.parse(response);//recuper l objet json 
                    $(".modale_lightbox_content").html(rl.data.html);// Remplacer le HTML
        
                    $(".modale_lightbox_bloc").slideDown();
                    $(".modale_lightbox_content").slideDown();

                },
            });
        }
    });

}
)(jQuery);
/*************************************************************************************************** */
jQuery(document).ready(function ($) {



    //fermeture modal contact
    //A Finir controler la fermeture 

    //   console.log($(' .modale_contact_bloc '));
    // console.log($('.modale_contact_bloc'));//
    $('.lightbox_close').click(function () {
        console.log($('.lightbox_close'));
        console.log();
        console.log();
        $(".modale_lightbox_bloc").slideToggle();
        $(".modale_lightbox_content").slideToggle();
    });


}); (jQuery);

