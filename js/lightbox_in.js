


(function ($) {


    $(".modale_lightbox_content").click(function (e) {



        if (e.target.classList.contains('lightbox_close')) {
     

            $(".modale_lightbox_bloc").slideUp();
            $(".modale_lightbox_content").slideUp();
        };
        if (e.target.classList.contains('arrows')) { 
    
            //recuperer les valeurs
            var Id_post = jQuery(e.target).attr('id');
            
           
            var referenceValue = jQuery("#bloc_img_lightbox").html();
            console.log(referenceValue);
            /********************************************************************************** */
            // Empêcher l'envoi classique du formulaire
           //  e.preventDefault();

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = $(".ajax-lightbox_in").attr('action');

            // Les données de notre formulaire
            const data = {
                action: $(".ajax-lightbox_in").find('input[name=action]').val(),
                nonce: $(".ajax-lightbox_in").find('input[name=nonce]').val(),
                Id_post: Id_post,

            }
            
            // Pour vérifier qu'on a bien récupéré les données
           // console.log(ajaxurl);
          //  console.log(data);

            // Requête Ajax en Jquery

            $.ajax({
                url: ajaxurl,
                type: 'post',
                dataType: "html",
                data: data,

                success: function (response) {
                  
                   
                    let rlq = JSON.parse(response);//recuper l objet json     ?????parse
                  
                    
                    $(".modale_lightbox_content").html(rlq.data.html);// Remplacer le HTML
                    /*  if (rl.data.html.trim() !== '') {
                     
                      }
                          */


                },
            });
        };

    });

})(jQuery);//
